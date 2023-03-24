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

                    dd($printer);
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
            }
        }
    }
}
