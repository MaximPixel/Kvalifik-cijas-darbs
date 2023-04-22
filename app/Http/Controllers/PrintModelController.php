<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

use App\Models\PrintModel;

use App\Jobs\CalculateModel;
use App\Jobs\StlRender;

class PrintModelController extends Controller {

    public function view(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "create") {
                if (!auth()->check()) {
                    return autoredirect();
                }

                return view("model.print-model.create");
            } else if ($action == "edit") {
                if ($request->has("code")) {
                    $printModel = PrintModel::firstCodeOrFail($request->get("code"));
                    return view("model.print-model.edit", ["printModel" => $printModel]);
                }
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $printModel = PrintModel::firstCodeOrFail($request->get("code"));
                    return view("yesno");
                }
            } else if ($action == "download") {
                if ($request->has("code")) {
                    $printModel = PrintModel::firstCodeOrFail($request->get("code"));
                    $storage = Storage::disk("models");
                    return $storage->download($printModel->getCode(), $printModel->getCode() . ".stl");
                }
            } else if ($action == "list") {
                if ($request->has("user")) {
                    $user = \App\Models\User::firstCodeOrFail($request->get("user"));

                    if (!auth()->check() || $user->id != auth()->user()->id) {
                        return autoredirect();
                    }

                    $printModels = auth()->user()->printModelsVisible;

                    return view("model.print-model.list", ["printModels" => $printModels]);
                }
            }
        } else if ($request->has("code")) {
            $printModel = PrintModel::where("deleted", false)->firstCodeOrFail($request->get("code"));
            return view("model.print-model.view", ["printModel" => $printModel]);
        }

        abort(404);
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "create") {
                if (!auth()->check()) {
                    return autoredirect();
                }

                $data = $request->validate([
                    "model-file" => "required|file",
                    "name" => "string|max:255",
                ]);

                $printModel = new PrintModel;
                $printModel->name = $data["name"];
                $printModel->length = 0;
                $printModel->width = 0;
                $printModel->height = 0;
                $printModel->diameter = 0;
                $printModel->volume = 0;
                $printModel->user_id = auth()->user()->id;
                $printModel->save();

                Storage::disk("models")->put($printModel->getCode(), file_get_contents($data["model-file"]));

                CalculateModel::dispatch($printModel->id);
                StlRender::dispatch($printModel->id);

                return redirect($printModel->getRoute());
            } else if ($action == "edit") {
                if ($request->has("code")) {
                    $printModel = PrintModel::firstCodeOrFail($request->get("code"));

                    if ($printModel->canEdit($request->user())) {
                        $data = $request->validate([
                            "name" => "required|string|max:255",
                            "scaleLength" => "required|numeric|between:0.01,100",
                            "scaleWidth" => "required|numeric|between:0.01,100",
                            "scaleHeight" => "required|numeric|between:0.01,100",
                        ]);
                        
                        $printModel->name = $data["name"];
                        $printModel->length = $printModel->length / $printModel->scale_length * $data["scaleLength"];
                        $printModel->width = $printModel->width / $printModel->scale_width * $data["scaleWidth"];
                        $printModel->height = $printModel->height / $printModel->scale_height * $data["scaleHeight"];
                        $printModel->scale_length = $data["scaleLength"];
                        $printModel->scale_width = $data["scaleWidth"];
                        $printModel->scale_height = $data["scaleHeight"];
                        $printModel->save();

                        return redirect($printModel->getRoute());
                    }
                }
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $printModel = PrintModel::firstCodeOrFail($request->get("code"));

                    if ($printModel->canEdit($request->user())) {
                        $printModel->deleted = true;
                        $printModel->save();
                        return autoredirect();
                    }
                }
            }
        }

        abort(404);
    }
}
