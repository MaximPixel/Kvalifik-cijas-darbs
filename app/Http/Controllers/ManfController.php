<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Manf;
use App\Models\ManfRole;
use App\Models\ManfRoleUser;

class ManfController extends Controller {

    public function view(Request $request) {
        if ($request->has("action")) {
            $action = $request->query("action");

            if ($action == "create") {
                return view("model.manf.create");
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $manf = Manf::firstCodeOrFail($request->query("code"));
                    return view("yesno");
                }
            }
        } else if ($request->has("code")) {
            $manf = Manf::where("deleted", false)->firstCodeOrFail($request->query("code"));
            return view("model.manf.view", ["manf" => $manf]);
        }
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->query("action");

            if ($action == "create") {
                $data = $request->validate([
                    "name" => "required|min:5|max:255",
                    "email" => "required|email",
                ]);
        
                $manf = new Manf;
                $manf->name = $data["name"];
                $manf->email = $data["email"];
                $manf->save();

                $manfRole = new ManfRole;
                $manfRole->manf_id = $manf->id;
                $manfRole->name = "Creator";
                $manfRole->save();

                $manfRoleUser = new ManfRoleUser;
                $manfRoleUser->manf_role_id = $manfRole->id;
                $manfRoleUser->user_id = auth()->user()->id;
                $manfRoleUser->save();

                return redirect($manf->getRoute());
            } else if ($action == "delete") {
                if ($request->has("code")) {
                    $manf = Manf::firstCodeOrFail($request->query("code"));
                    $manf->deleted = true;
                    $manf->save();
                    return redirect()->route("index");
                }
            }
        }
    }
}
