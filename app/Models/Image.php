<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class Image extends Model {

    use HasFactory, HasCode;

    public function delete() {
        parent::delete();
        Storage::disk("images")->delete($this->getCode() . ".webp");
    }

    public function printModels() {
        return $this->hasMany(PrintModel::class);
    }

    public function getUrl() {
        return Storage::disk("images")->url($this->getCode() . ".webp");
    }

    public function findUsages() {
        return $this->printModels;
    }
}
