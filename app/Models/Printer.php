<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model {

    public static function getCreateRoute() {
        return route("model.printer", ["action" => "create"]);
    }

    use HasFactory, HasCode, HasCodeRoute, HasCodeEditRoute;

    public function creatorUser() {
        return $this->belongsTo(User::class, "creator_user_id");
    }

    public function printerFeats() {
        return $this->hasMany(PrinterFeat::class);
    }

    public function generateUrl() {
        $this->url = str()->random(10);
    }
}
