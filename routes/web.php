<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManfController;
use App\Http\Controllers\ManfServiceController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\PrintModelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserAddressController;

Route::get("/", fn() => view("index"))->name("index");

Route::get("/register", [AuthController::class, "registerView"])->name("auth.register");
Route::post("/register", [AuthController::class, "registerPost"]);
Route::get("/login", [AuthController::class, "loginView"])->name("auth.login");
Route::post("/login", [AuthController::class, "loginPost"]);
Route::any("/logout", [AuthController::class, "logout"])->name("auth.logout");

Route::get("/manf", [ManfController::class, "view"])->name("model.manf");
Route::post("/manf", [ManfController::class, "post"]);

Route::get("/service", [ManfServiceController::class, "view"])->name("model.manf-service");
Route::post("/service", [ManfServiceController::class, "post"]);

Route::get("/printer", [PrinterController::class, "view"])->name("model.printer");
Route::post("/printer", [PrinterController::class, "post"]);

Route::get("/model", [PrintModelController::class, "view"])->name("model.print-model");
Route::post("/model", [PrintModelController::class, "post"]);

Route::get("/order", [OrderController::class, "view"])->name("model.order");
Route::post("/order", [OrderController::class, "post"]);

Route::get("/address", [UserAddressController::class, "view"])->name("model.user-address");
Route::post("/address", [UserAddressController::class, "post"]);
