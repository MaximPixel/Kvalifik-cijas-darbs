<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Printer;

class PrinterController extends Controller {

    public function view(Request $request, $printerId) {
        $printer = Printer::find($printerId);

        if (!$printer) {
            return redirect()->route("index");
        }

        dd($printer);

        return view("model.printer.view");
    }

    public function createView(Request $request) {
        return view("model.printer.create");
    }

    public function createPost(Request $request) {
        $data = $request->validate([
            "name" => "required|min:10|max:255",
            "description" => "required|min:10|max:10000",
            "manufacturer" => "required",
        ]);

        $printer = new Printer;
        $printer->name = $data["name"];
        $printer->description = $data["description"];
        $printer->manufacturer = $data["manufacturer"];
        $printer->creator_user_id = auth()->user()->id;
        $printer->save();

        return redirect()->route("printer.view", ["printerId" => $printer->id]);
    }
}
