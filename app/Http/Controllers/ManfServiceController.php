<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Manf;
use App\Models\ManfService;
use App\Models\ManfServicePrinter;
use App\Models\Printer;

class ManfServiceController extends Controller {

    public function view(Request $request) {
        if ($request->has("action")) {
            $action = $request->input("action");

            if ($action == "create") {
                if ($request->has("manf")) {
                    $manf = Manf::firstCodeOrFail($request->input("manf"));
                    return view("model.manf-service.create", ["manf" => $manf]);
                }
            } else if ($action == "add-printer") {
                $manfService = ManfService::firstCodeOrFail($request->input("code"));
                $printers = Printer::query()
                    ->whereDoesntHave("manfServicePrinters", function ($query) use ($manfService) {
                        $query->where("manf_service_id", $manfService->id);
                    })
                    ->get();

                return view("model.manf-service.add-printer", ["manfService" => $manfService, "printers" => $printers]);
            } else if ($action == "remove-printer") {
                return view("yesno");
            }
        } else if ($request->has("code")) {
            $code = $request->input("code");
            $manfService = ManfService::firstCodeOrFail($code);
            return view("model.manf-service.view", ["manfService" => $manfService]);
        }
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->input("action");

            if ($action == "create") {
                if ($request->has("manf")) {
                    $manf = Manf::firstCodeOrFail($request->input("manf"));

                    $data = $request->validate([
                        "name" => "required|min:5|max:255",
                        "description" => "required|min:5|max:1000",
                    ]);

                    $manfService = new ManfService;
                    $manfService->manf_id = $manf->id;
                    $manfService->name = $data["name"];
                    $manfService->description = $data["description"];
                    $manfService->save();

                    return redirect($manfService->getRoute());
                }
            } else if ($action == "add-printer") {
                $manfService = ManfService::firstCodeOrFail($request->input("code"));
                
                $printer = Printer::firstCodeOrFail($request->input("printer"));
                
                $manfServicePrinter = new ManfServicePrinter;
                $manfServicePrinter->manf_service_id = $manfService->id;
                $manfServicePrinter->printer_id  = $printer->id;
                $manfServicePrinter->save();

                return redirect($manfService->getRoute());
            } else if ($action == "remove-printer") {
                $manfService = ManfService::firstCodeOrFail($request->input("code"));
                
                $printer = Printer::firstCodeOrFail($request->input("printer"));
                
                $manfServicePrinter = ManfServicePrinter::query()
                    ->where("manf_service_id", $manfService->id)
                    ->where("printer_id", $printer->id)
                    ->firstOrFail();

                $manfServicePrinter->delete();

                return redirect($manfService->getRoute());
            }
        }
    }
}
