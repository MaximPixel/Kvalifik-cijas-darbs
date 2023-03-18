<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class PrintModel extends Model {

    use HasFactory, HasCode, HasCodeRoute;

    public function delete() {
        Storage::disk("models")->delete($this->getCode());
    }
}
