<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ManfController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\PrintModelController;

Route::get("/", fn() => view("index"))->name("index");

Route::get("/manf", [ManfController::class, "view"])->name("model.manf");
Route::post("/manf", [ManfController::class, "post"]);

Route::get("/printer", [PrinterController::class, "view"])->name("model.printer");
Route::post("/printer", [PrinterController::class, "post"]);

Route::get("/model", [PrintModelController::class, "view"])->name("model.print-model");
Route::post("/model", [PrintModelController::class, "post"]);
