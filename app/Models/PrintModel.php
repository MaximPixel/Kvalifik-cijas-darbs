<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class PrintModel extends Model {

    public static function getCreateRoute() {
        return route("model.print-model", ["action" => "create"]);
    }

    use HasFactory, HasCode, HasCodeRoute;

    public function getImageUrl() {
        return $this->image ? $this->image->getUrl() : "noimage";
    }

    public function delete() {
        parent::delete();
        Storage::disk("models")->delete($this->getCode());
    }

    public function image() {
        return $this->belongsTo(Image::class);
    }
}
