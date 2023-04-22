<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model {

    use HasFactory;

    public function getDisplayName() {
        return __("model.order.status.types.$this->name");
    }
}
