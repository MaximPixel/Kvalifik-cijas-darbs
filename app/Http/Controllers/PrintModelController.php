<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

use App\Models\PrintModel;

use PHPSTL\Reader\STLReader;

class PrintModelController extends Controller {

    public function view(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "create") {
                return view("model.print-model.create");
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
                    $printModels = PrintModel::query()
                        ->where("user_id", $user->id)
                        ->get();
                    return view("model.print-model.list", ["printModels" => $printModels]);
                }
            }
        } else if ($request->has("code")) {
            $printModel = PrintModel::firstCodeOrFail($request->get("code"));
            return view("model.print-model.view", ["printModel" => $printModel]);
        }
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "create") {
                $data = $request->validate([
                    "model-file" => "required|file",
                    "name" => "string",
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

                $filename = $printModel->getCode();
                $storage = Storage::disk("models");
                $storage->put($filename, file_get_contents($data["model-file"]));

                $stlFilepath = $storage->path($filename);

                $reader = STLReader::forFile($stlFilepath);
                $reader->setHandler(new \PHPSTL\Handler\DimensionsHandler);
                $dimensions = $reader->readModel();
                $reader = STLReader::forFile($stlFilepath);
                $reader->setHandler(new \PHPSTL\Handler\VolumeHandler);
                $volume = $reader->readModel();

                $length = $dimensions->length;
                $width = $dimensions->width;
                $height = $dimensions->height;
                $diameter = $dimensions->bounding_diameter;

                $printModel->length = $length;
                $printModel->width = $width;
                $printModel->height = $height;
                $printModel->diameter = $diameter;
                $printModel->volume = $volume;
                $printModel->save();

                $image = new \App\Models\Image;
                $image->save();

                $imagesStorage = Storage::disk("images");
                $imageFilepath = $imagesStorage->path($image->getCode() . ".webp");

                $pythonFilepath = escapeshellarg(base_path() . "/python/stl_render.py");
                $stlFilepath = escapeshellarg($stlFilepath);
                $imageFilepath = escapeshellarg($imageFilepath);
                $a = null;
                $b = null;
                $c = exec("C:\Users\Maxim\AppData\Local\Programs\Python\Python311\python.exe $pythonFilepath --filepath=$stlFilepath --output=$imageFilepath", $a, $b);

                $printModel->image_id = $image->id;
                $printModel->save();

                return redirect($printModel->getRoute());
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $printModel = PrintModel::firstCodeOrFail($request->get("code"));
                    $printModel->delete();
                    return redirect()->route("index");
                }
            }
        }
    }
}
