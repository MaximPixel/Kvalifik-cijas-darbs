<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinterFeat extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function printerFeatValue() {
        return $this->belongsTo(PrinterFeatValue::class);
    }
}
