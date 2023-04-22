<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic;

class Image extends Model {

    public static function upload($url) {
        $image = new Image;
        $image->save();

        ImageManagerStatic::make($url)->resize(500, 500)->save($image->getPath());

        return $image;
    }

    use HasFactory, HasCode;

    public function delete() {
        parent::delete();
        Storage::disk("images")->delete($this->getFilename());
    }

    public function printModels() {
        return $this->hasMany(PrintModel::class);
    }

    public function getFilename() {
        return $this->getCode() . ".webp";
    }

    public function getUrl() {
        return Storage::disk("images")->url($this->getFilename());
    }

    public function getPath() {
        return Storage::disk("images")->path($this->getFilename());
    }

    public function findUsages() {
        return $this->printModels;
    }
}
