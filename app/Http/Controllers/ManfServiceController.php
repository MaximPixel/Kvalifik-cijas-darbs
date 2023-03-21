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

            if ($action == "list") {
                $totalManfServices = ManfService::all();
                $manfServicesQuery = ManfService::query();
                
                if ($request->has("manf")) {
                    $manf = Manf::firstCode($request->get("manf"));
                    if ($manf) {
                        $manfServicesQuery->where("manf_id", $manf->id);
                    }
                }

                if ($request->has("model")) {
                    $model = \App\Models\PrintModel::firstCode($request->get("model"));
                    if ($model) {
                        $manfServicesQuery->whereServiceCanPrint($model);
                    }
                }

                if ($request->has("material_color")) {
                    $materialColor = \App\Models\PrintMaterialColor::firstCode($request->get("material_color"));
                    if ($materialColor) {
                        $manfServicesQuery->whereHas("manfServicePrintMaterialColors", fn ($query) => $query->where("print_material_color_id", $materialColor->id));
                    }
                }

                $manfServicesQuery->orderBy("id");

                return view("model.manf-service.list", [
                    "totalManfServices" => $totalManfServices,
                    "manfServices" => $manfServicesQuery->get(),
                ]);
            } else if ($action == "create") {
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
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $manfService = ManfService::firstCodeOrFail($request->get("code"));
                    return view("yesno");
                }
            } else if ($action == "edit-materials") {
                if ($request->has("code")) {
                    $manfService = ManfService::firstCodeOrFail($request->get("code"));
                    return view("model.manf-service.edit-materials", ["manfService" => $manfService, "printMaterials" => \App\Models\PrintMaterial::all()]);
                }
            }
        } else if ($request->has("code")) {
            $manfService = ManfService::firstCodeOrFail($request->get("code"));
            return view("model.manf-service.view", ["manfService" => $manfService]);
        }
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->input("action");

            if ($action == "list") {
                return redirect()->route("model.manf-service", $request->except("_token"));
            } else if ($action == "create") {
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
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $manfService = ManfService::firstCodeOrFail($request->query("code"));
                    $manfService->delete();
                    return redirect()->route("index");
                }
            } else if ($action == "edit-materials") {
                if ($request->has("code")) {
                    $manfService = ManfService::firstCodeOrFail($request->get("code"));

                    $materialColors = collect($request->get("materialColors"))->keys();
                    $materialColors = \App\Models\PrintMaterialColor::whereIn("code", $materialColors)->pluck("id");

                    $current = $manfService->manfServicePrintMaterialColors->pluck("printMaterialColor")->pluck("id");

                    $toDelete = $current->diff($materialColors);
                    $toInsert = $materialColors->diff($current);
                    
                    $manfService->manfServicePrintMaterialColors->whereIn("print_material_color_id", $toDelete)->each(fn ($a) => $a->delete());
                    $toInsert->each(function ($materialColorId) use ($manfService) {
                        $manfServicePrintMaterialColor = new \App\Models\ManfServicePrintMaterialColor;
                        $manfServicePrintMaterialColor->manf_service_id = $manfService->id;
                        $manfServicePrintMaterialColor->print_material_color_id = $materialColorId;
                        $manfServicePrintMaterialColor->save();
                    });

                    return redirect($manfService->getRoute());
                }
            }
        }
    }
}
