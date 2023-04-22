<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintMaterialColor extends Model {

    use HasFactory, HasCode, HasCodeRoute;

    public function printMaterial() {
        return $this->belongsTo(PrintMaterial::class);
    }

    public function image() {
        return $this->belongsTo(Image::class);
    }

    public function getImageUrl() {
        return $this->image ? $this->image->getUrl() : config("images.default");
    }
}
