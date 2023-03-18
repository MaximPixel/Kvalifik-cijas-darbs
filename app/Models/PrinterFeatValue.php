<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinterFeatValue extends Model
{
    use HasFactory, HasCode;

    public function printerFeatType() {
        return $this->belongsTo(PrinterFeatType::class);
    }
}
