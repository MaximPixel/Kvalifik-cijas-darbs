<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model {

    public static function getCreateRoute() {
        return route("model.user-address", ["action" => "create"]);
    }

    use HasFactory, HasCode, HasCodeRoute;
}
