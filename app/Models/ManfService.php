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

    use HasFactory, HasCode, HasCodeRoute, HasCodeEditRoute;

    public function manfServicePrinters() {
        return $this->hasMany(ManfServicePrinter::class);
    }

    public function manf() {
        return $this->belongsTo(Manf::class);
    }

    public function manfServicePrintMaterialColors() {
        return $this->hasMany(ManfServicePrintMaterialColor::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function image() {
        return $this->belongsTo(Image::class);
    }

    public function canCalculatePrice(\App\Models\Order $order) {
        return $order->print_time !== null;
    }

    public function calculatePrice(\App\Models\Order $order) {
        $printModel = $order->printModel;

        $price = $printModel->volume * $this->price_per_volume + $order->print_time * $this->price_per_time;

        $price *= $order->amount;

        $price += $this->price_base;

        $price = max($order->price_min, $price);

        return ceil($price * 100) / 100;
    }

    public function canEdit(User|null $user) {
        return $this->canView($user) && $this->manf->canEdit($user);
    }

    public function canView(User|null $user) {
        if (!$this->deleted) {
            return true;
        }

        return $user && $user->isAdmin();
    }

    public function getAddPrinterRoute(Printer $printer = null) {
        $params = [];
        if ($printer) {
            $params["printer"] = $printer->getCode();
        }
        return $this->getActionRoute("add-printer", $params);
    }

    public function getRemovePrinterRoute(Printer $printer) {
        return $this->getActionRoute("remove-printer", ["printer" => $printer->getCode()]);
    }

    public function getDisplayName() {
        return $this->name;
    }

    public function getImageUrl() {
        return $this->image ? $this->image->getUrl() : config("images.default");
    }
}
