<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

    public function creatorUser() {
        return $this->belongsTo(User::class, "creator_user_id");
    }
}
