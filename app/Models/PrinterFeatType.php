<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinterFeatType extends Model {

    use HasFactory, HasCode;

    public function getDisplayName() {
        return __("model.printer.feat-type.$this->name");
    }
}
