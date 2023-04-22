<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Printer;

class PrinterController extends Controller {

    public function view(Request $request) {
        if ($request->has("action")) {
            $action = $request->query("action");

            if ($action == "create") {
                return view("model.printer.create");
            } else if ($action == "edit") {
                if ($request->has("code")) {
                    $code = $request->query("code");

                    $printer = Printer::firstCodeOrFail($code);

                    if ($printer->canEdit($request->user())) {
                        return view("model.printer.edit", ["printer" => $printer]);
                    }
                }
            }
        } else if ($request->has("code")) {
            $code = $request->query("code");

            $printer = Printer::query()
                ->where("deleted", false)
                ->with([
                    "printerFeats",
                    "printerFeats.printerFeatValue",
                    "printerFeats.printerFeatValue.printerFeatType",
                ])
                ->firstCodeOrFail($code);

            return view("model.printer.view", ["printer" => $printer]);
        }

        abort(404);
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->query("action");

            if ($action == "create") {
                $data = $request->validate([
                    "name" => "required|min:5|max:255",
                    "description" => "required|min:10|max:1000",
                    "manufacturer" => "required",
                ]);
        
                $printer = new Printer;
                $printer->name = $data["name"];
                $printer->description = $data["description"];
                $printer->manufacturer = $data["manufacturer"];
                //$printer->creator_user_id = auth()->user()->id;
                $printer->save();
        
                return redirect($printer->getRoute());
            } else if ($action == "edit") {
                $printer = Printer::firstCodeOrFail($request->get("code"));

                if ($printer->canEdit($request->user()) || true) {
                    $basicData = $request->validateWithBag("basicInfo", [
                        "name" => "required|min:5|max:255",
                        "description" => "required|min:10|max:1000",
                        "manufacturer" => "required",
                    ]);

                    $editFeatTypes = $printer->getEditFeatTypes();

                    $validateRules = $editFeatTypes
                        ->mapWithKeys(function ($featType) {
                            $key = "feat." . $featType->getCode() . ".value";
                            return [$key => $featType->getValidationRules()];
                        })->merge([
                            "feat" => ["required", "array"],
                        ])->toArray();

                    $params = $editFeatTypes
                        ->mapWithKeys(function ($featType) {
                            $code = $featType->getCode();
                            $displayName = $featType->getDisplayName();
                            return [
                                "feat.$code.value.required" => __("validation.required", ["attribute" => $displayName]),
                                "feat.$code.value.numeric" => __("validation.numeric", ["attribute" => $displayName]),
                                "feat.$code.value.between.numeric" => __("validation.numeric", ["attribute" => $displayName, "min" => 0, "max" => 99999.99]),
                            ];
                        })->toArray();

                    $featsData = $request->validateWithBag("feats", $validateRules, $params);

                    dd($basicData, $featsData, $request->all());
                }
            }
        }

        abort(404);
    }
}
