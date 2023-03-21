<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManfService extends Model {

    public static function getListRoute() {
        return route("model.manf-service", ["action" => "list"]);
    }

    public static function getCreateRoute(Manf $manf) {
        return route("model.manf-service", ["action" => "create", "manf" => $manf->getCode()]);
    }

    use HasFactory, HasCode, HasCodeRoute;

    public function manfServicePrinters() {
        return $this->hasMany(ManfServicePrinter::class);
    }

    public function manf() {
        return $this->belongsTo(Manf::class);
    }

    public function manfServicePrintMaterialColors() {
        return $this->hasMany(ManfServicePrintMaterialColor::class);
    }

    public function canCalculatePrice(\App\Models\Order $order) {
        return $order->print_time !== null;
    }

    public function calculatePrice(\App\Models\Order $order) {
        $printModel = $order->printModel;

        $price = $this->price_base
            + $printModel->volume * $this->price_per_volume
            + $order->print_time * $this->price_per_time;

        return max($order->price_min, $price);
    }
}
