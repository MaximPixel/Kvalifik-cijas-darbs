<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintMaterial extends Model {

    use HasFactory, HasCode, HasCodeRoute;

    public function printMaterialColors() {
        return $this->hasMany(PrintMaterialColor::class);
    }
}
