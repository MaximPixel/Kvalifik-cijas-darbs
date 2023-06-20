<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManfRole extends Model {

    use HasFactory, HasCode, HasCodeRoute;

    public function manf() {
        return $this->belongsTo(Manf::class);
    }

    public function manfRoleUsers() {
        return $this->hasMany(ManfRoleUser::class);
    }

    public function canEdit(User|null $user) {
        return $this->manf->canEdit($user);
    }
}
