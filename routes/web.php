<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChangeLangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManfController;
use App\Http\Controllers\ManfRoleController;
use App\Http\Controllers\ManfServiceController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\PrintModelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get("/", fn() => view("index"))->name("index");

Route::redirect("/", "/service?action=list");

Route::get("/change-lang/{locale}", [ChangeLangController::class, "changeLang"])->name("change-lang");

Route::get("/register", [AuthController::class, "registerView"])->name("auth.register");
Route::post("/register", [AuthController::class, "registerPost"]);
Route::get("/login", [AuthController::class, "loginView"])->name("auth.login");
Route::post("/login", [AuthController::class, "loginPost"]);
Route::any("/logout", [AuthController::class, "logout"])->name("auth.logout");

Route::get("/manf", [ManfController::class, "view"])->name("model.manf");
Route::post("/manf", [ManfController::class, "post"]);

Route::get("/manf-role", [ManfRoleController::class, "view"])->name("model.manf-role");
Route::post("/manf-role", [ManfRoleController::class, "post"]);

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

Route::get("/user", [UserController::class, "view"])->name("model.user");
Route::post("/user", [UserController::class, "post"]);

Route::get("/admin", [AdminController::class, "index"])->name("admin");
Route::post("/admin", [AdminController::class, "indexPost"]);
