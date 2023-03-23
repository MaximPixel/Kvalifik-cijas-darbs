<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model {

    public static function getCreateRoute($params = null) {
        return route("model.user-address", mergeparams(["action" => "create"], $params));
    }

    use HasFactory, HasCode, HasCodeRoute;
}
