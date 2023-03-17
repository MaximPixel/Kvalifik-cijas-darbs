<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PrinterController;

Route::get("/", function () {
    return view("welcome");
})->name("index");

Route::get("/printer/create", [PrinterController::class, "createView"])->name("printer.create");
Route::post("/printer/create", [PrinterController::class, "createPost"]);
Route::get("/printer/{printerId}", [PrinterController::class, "view"])->name("printer.view");
