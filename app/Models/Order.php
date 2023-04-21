<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    use HasFactory, HasCode, HasCodeRoute;

    public static function booted() {
        static::created(function ($model) {
            $model->manfService->increment("_orders_count");
        });
        self::bootedHasCode();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function userAddress() {
        return $this->belongsTo(UserAddress::class);
    }

    public function manfService() {
        return $this->belongsTo(ManfService::class);
    }

    public function printModel() {
        return $this->belongsTo(PrintModel::class);
    }

    public function printMaterialColor() {
        return $this->belongsTo(PrintMaterialColor::class);
    }

    public function canEdit(User|null $user) {
        return $this->manfService->canEdit($user);
    }
}
