<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Manf;

class ManfController extends Controller {

    public function createView(Request $request) {
        return view("model.manf.create");
    }

    public function createPost(Request $request) {
        $data = $request->validate([
            "name" => "required|min:5|max:255",
            "email" => "required|email",
        ]);

        $manf = new Manf;
        $manf->name = $data["name"];
        $manf->email = $data["email"];
        $manf->save();

        return redirect()->route("manf.view", ["manfId" => $manf->id]);
    }
}
