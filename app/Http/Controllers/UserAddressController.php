<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserAddress;

class UserAddressController extends Controller {

    public function view(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "create") {
                return view("model.user-address.create");
            }
        }

        abort(404);
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "create") {
                $data = $request->validate([
                    "contact_name" => "required|max:255",
                    "phone_number_prefix" => "required|max:255",
                    "phone_number" => "required|max:255",
                    "address_street" => "required|max:255",
                    "address_apt" => "required|max:255",
                    "address_province" => "required|max:255",
                    "address_city" => "required|max:255",
                    "address_zipcode" => "required|max:255",
                    "comment" => "required|max:255",
                ]);

                $userAddress = new UserAddress;
                $userAddress->user_id = auth()->user()->id;
                foreach ($data as $key => $value) {
                    $userAddress->$key = $value;
                }
                $userAddress->save();

                return autoredirect();
            }
        }

        abort(404);
    }
}
