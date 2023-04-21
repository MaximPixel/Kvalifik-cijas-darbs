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
                $totalManfServices = ManfService::where("deleted", false)->get();
                $manfServicesQuery = ManfService::where("deleted", false);

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

                $sort = $request->get("sort");

                if ($sort == "creation-desc") {
                    $manfServicesQuery->orderBy("created_at", "desc");
                } else if ($sort == "orders-asc") {
                    $manfServicesQuery->orderBy("_orders_count", "asc");
                } else if ($sort == "orders-desc") {
                    $manfServicesQuery->orderBy("_orders_count", "desc");
                } else {
                    $manfServicesQuery->orderBy("created_at", "asc");
                }

                $manfServicesQuery->orderBy("id");

                return view("model.manf-service.list", [
                    "totalManfServices" => $totalManfServices,
                    "manfServicesPagination" => (new \App\Classes\CustomPaginator($manfServicesQuery->paginate(10)))->withQueryString(),
                ]);
            } else if ($action == "create") {
                if ($request->has("manf")) {
                    $manf = Manf::firstCodeOrFail($request->get("manf"));
                    return view("model.manf-service.create", ["manf" => $manf]);
                }
            } else if ($action == "add-printer") {
                $manfService = ManfService::firstCodeOrFail($request->get("code"));

                if ($manfService->canEdit($request->user())) {
                    if ($request->has("printer")) {
                        $printer = Printer::firstCodeOrFail($request->get("printer"));

                        $manfServicePrinter = new ManfServicePrinter;
                        $manfServicePrinter->manf_service_id = $manfService->id;
                        $manfServicePrinter->printer_id  = $printer->id;
                        $manfServicePrinter->save();

                        return autoredirect($manfService->getRoute());
                    }

                    $printersQuery = Printer::query()
                        ->whereDoesntHave("manfServicePrinters", function ($query) use ($manfService) {
                            $query->where("manf_service_id", $manfService->id);
                        });

                    if ($request->has("search")) {
                        $printersQuery->where("name", "like", "%" . $request->get("search") . "%");
                    }
                    if ($request->has("manufacturer")) {
                        $printersQuery->where("manufacturer", $request->get("manufacturer"));
                    }

                    $printersPagination = (new \App\Classes\CustomPaginator($printersQuery->paginate(10)))->withQueryString();

                    return view("model.manf-service.add-printer", ["manfService" => $manfService, "printersPagination" => $printersPagination]);
                }
            } else if ($action == "remove-printer") {
                $manfService = ManfService::firstCodeOrFail($request->get("code"));

                if ($manfService->canEdit($request->user())) {
                    return view("yesno");
                }
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $manfService = ManfService::firstCodeOrFail($request->get("code"));

                    if ($manfService->canEdit($request->user())) {
                        return view("yesno");
                    }
                }
            } else if ($action == "edit-materials") {
                if ($request->has("code")) {
                    $manfService = ManfService::firstCodeOrFail($request->get("code"));
                    
                    if ($manfService->canEdit($request->user())) {
                        return view("model.manf-service.edit-materials", ["manfService" => $manfService, "printMaterials" => \App\Models\PrintMaterial::all()]);
                    }
                }
            } else if ($action == "edit") {
                if ($request->has("code")) {
                    $manfService = ManfService::firstCodeOrFail($request->get("code"));

                    if ($manfService->canEdit($request->user())) {
                        return view("model.manf-service.edit", ["manfService" => $manfService]);
                    }
                }
            }
        } else if ($request->has("code")) {
            $manfService = ManfService::firstCodeOrFail($request->get("code"));

            if ($manfService->canView($request->user())) {
                return view("model.manf-service.view", ["manfService" => $manfService]);
            }
            abort(404);
        }
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->input("action");

            if ($action == "list") {
                return redirect()->route("model.manf-service", $request->except(["_token", "page"]));
            } else if ($action == "create") {
                if ($request->has("manf")) {
                    $manf = Manf::firstCodeOrFail($request->input("manf"));

                    $data = $request->validate([
                        "name" => "required|min:5|max:255",
                        "description" => "required|min:5|max:1000",
                        "price_base" => "required|decimal:0,2",
                        "price_min" => "required|decimal:0,2",
                        "price_per_time" => "required|decimal:0,2",
                        "price_per_volume" => "required|decimal:0,2",
                    ]);

                    $manfService = new ManfService;
                    $manfService->manf_id = $manf->id;
                    foreach ($data as $key => $value) {
                        $manfService->$key = $value;
                    }
                    $manfService->save();

                    return redirect($manfService->getRoute());
                }
            } else if ($action == "remove-printer") {
                $manfService = ManfService::firstCodeOrFail($request->input("code"));

                if ($manfService->canEdit($request->user())) {
                    $printer = Printer::firstCodeOrFail($request->input("printer"));
                    
                    $manfServicePrinter = ManfServicePrinter::query()
                        ->where("manf_service_id", $manfService->id)
                        ->where("printer_id", $printer->id)
                        ->firstOrFail();

                    $manfServicePrinter->delete();

                    return redirect($manfService->getRoute());
                }
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $manfService = ManfService::firstCodeOrFail($request->query("code"));

                    if ($manfService->canEdit($request->user())) {
                        $manfService->deleted = true;
                        $manfService->save();
                        return redirect()->route("index");
                    }
                }
            } else if ($action == "add-printer") {
                return redirect()->route("model.manf-service", $request->except(["_token", "page"]));
            } else if ($action == "edit-materials") {
                if ($request->has("code")) {
                    $manfService = ManfService::firstCodeOrFail($request->get("code"));

                    if ($manfService->canEdit($request->user())) {
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
            } else if ($action == "edit") {
                if ($request->has("code")) {
                    $manfService = ManfService::firstCodeOrFail($request->get("code"));

                    if ($manfService->canEdit($request->user())) {
                        $data = $request->validate([
                            "name" => "required|min:5|max:255",
                            "description" => "required|min:5|max:1000",
                            "price_base" => "required|decimal:0,2",
                            "price_min" => "required|decimal:0,2",
                            "price_per_time" => "required|decimal:0,2",
                            "price_per_volume" => "required|decimal:0,2",
                        ]);

                        foreach ($data as $key => $value) {
                            $manfService->$key = $value;
                        }
                        if ($manfService->isDirty()) {
                            $manfService->save();
                        }

                        return redirect($manfService->getRoute());
                    }
                }
            }
        }
    }
}
