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

    public function manfRoles() {
        return $this->hasMany(ManfRole::class);
    }

    public function canEdit(User|null $user) {
        if (!$user) {
            return false;
        }

        return $user->isAdmin() || $user->manfRoleUsers->contains(function ($manfRoleUser) {
            return $manfRoleUser->manfRole->where("manf_id", $this->id);
        });
    }

    public function getDisplayName() {
        return $this->name;
    }
}
