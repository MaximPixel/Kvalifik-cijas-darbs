<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller {

    public function index(Request $request) {
        if (!$request->user() || !$request->user()->isAdmin()) {
            abort(404);
        }

        return view("admin.index");
    }
}
