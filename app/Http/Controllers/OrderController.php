<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\PrintModel;
use App\Models\UserAddress;
use App\Models\ManfService;

class OrderController extends Controller {

    public function view(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "create") {
                $manfService = ManfService::firstCodeOrFail($request->get("service"));
                return view("model.order.create", ["manfService" => $manfService]);
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $order = Order::firstCodeOrFail($request->get("code"));
                    return view("yesno");
                }
            }
        } else if ($request->has("code")) {
            $order = Order::firstCodeOrFail($request->get("code"));
            return view("model.order.view", ["order" => $order]);
        }
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "create") {
                $manfService = ManfService::firstCodeOrFail($request->get("service"));
                $printMaterialColor = \App\Models\PrintMaterialColor::firstCodeOrFail($request->get("material_color"));

                if (!$manfService->manfServicePrintMaterialColors->contains("print_material_color_id", $printMaterialColor->id)) {
                    abort(404);
                }
                
                $order = new Order;
                $order->user_id = auth()->user()->id;
                $order->user_address_id = UserAddress::firstCodeOrFail($request->get("address"))->id;
                $order->manf_service_id = $manfService->id;
                $order->print_model_id  = PrintModel::firstCodeOrFail($request->get("model"))->id;
                $order->print_material_color_id  = $printMaterialColor->id;
                $order->amount = $request->get("amount");
                $order->comment = $request->get("comment");
                $order->save();

                return redirect($order->getRoute());
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $order = Order::firstCodeOrFail($request->get("code"));
                    $order->delete();
                    return redirect()->route("index");
                }
            }
        }
    }
}
