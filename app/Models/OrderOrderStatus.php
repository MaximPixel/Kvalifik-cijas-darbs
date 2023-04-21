<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOrderStatus extends Model {

    use HasFactory;

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function orderStatus() {
        return $this->belongsTo(OrderStatus::class);
    }

    public static function booted() {
        static::created(function ($model) {
            $model->orderStatus->order_status_id = $model->order_status_id;
            if ($model->orderStatus->isDirty()) {
                $model->orderStatus->save();
            }
        });
    }
}
