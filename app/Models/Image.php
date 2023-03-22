<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class Image extends Model {

    use HasFactory, HasCode;

    public function getUrl() {
        return Storage::disk("images")->url($this->getCode() . ".webp");
    }
}
