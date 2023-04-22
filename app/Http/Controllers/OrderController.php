<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderOrderStatus;
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
            } else if ($action == "list") {
                if ($request->has("user")) {
                    $user = \App\Models\User::firstCodeOrFail($request->get("user"));

                    if (!auth()->check() || $user->id != auth()->user()->id) {
                        return autoredirect();
                    }

                    $orders = auth()->user()->ordersVisible;

                    return view("model.order.list", ["orders" => $orders]);
                }
            }
        } else if ($request->has("code")) {
            $order = Order::where("deleted", false)->firstCodeOrFail($request->get("code"));
            return view("model.order.view", ["order" => $order]);
        }

        abort(404);
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
                    $order->deleted = true;
                    $order->save();
                    return redirect()->route("index");
                }
            } else if ($action == "change-status") {
                if ($request->has("code") && $request->has("status")) {
                    $order = Order::firstCodeOrFail($request->get("code"));

                    if ($order->canEdit($request->user())) {
                        $orderStatus = OrderStatus::where("name", $request->get("status"))->firstOrFail();

                        $orderOrderStatus = new OrderOrderStatus;
                        $orderOrderStatus->order_id = $order->id;
                        $orderOrderStatus->order_status_id = $orderStatus->id;
                        $orderOrderStatus->comment = $request->get("comment") ?? "";
                        $orderOrderStatus->user_id = $request->user()->id ?? null;
                        $orderOrderStatus->save();
                    }
                }
            }
        }

        abort(404);
    }
}
