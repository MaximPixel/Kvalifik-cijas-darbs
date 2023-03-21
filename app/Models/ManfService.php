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
}
