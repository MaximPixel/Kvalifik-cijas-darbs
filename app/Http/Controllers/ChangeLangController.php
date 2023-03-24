<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChangeLangController extends Controller {

    public function changeLang(Request $request, $locale) {
        session(["locale" => $locale]);
        return redirect()->back();
    }
}
