<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manf extends Model {

    public static function getCreateRoute() {
        return route("model.manf", ["action" => "create"]);
    }

    use HasFactory, HasCode, HasCodeRoute;

    public function manfServices() {
        return $this->hasMany(ManfService::class);
    }
}
