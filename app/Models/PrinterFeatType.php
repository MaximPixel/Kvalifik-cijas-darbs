<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinterFeatType extends Model {

    use HasFactory, HasCode;

    public function getDisplayName() {
        return __("model.printer.feat-type.$this->name");
    }

    public function getValidationRules() {
        if ($this->measure_type == "temperature") {
            return ["required", "numeric", "between:20,1000"];
        }
        return ["required", "numeric", "between:0.01,99999.99"];
    }
}
