<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens, HasFactory, Notifiable, HasCode;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function printers() {
        return $this->hasMany(Printer::class);
    }

    public function printModels() {
        return $this->hasMany(PrintModel::class);
    }

    public function printModelsVisible() {
        return $this->hasMany(PrintModel::class)
            ->where("deleted", false);
    }

    public function userAddresses() {
        return $this->hasMany(UserAddress::class);
    }

    public function userAddressesVisible() {
        return $this->hasMany(UserAddress::class)
            ->where("deleted", false);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function ordersVisible() {
        return $this->hasMany(Order::class)
            ->where("deleted", false);
    }
}
