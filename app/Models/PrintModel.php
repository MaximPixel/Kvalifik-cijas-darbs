<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class PrintModel extends Model {

    public static function getCreateRoute() {
        return route("model.print-model", ["action" => "create"]);
    }

    use HasFactory, HasCode, HasCodeRoute;

    public function delete() {
        parent::delete();
        Storage::disk("models")->delete($this->getCode());
    }

    public function image() {
        return $this->belongsTo(Image::class);
    }

    public function getImageUrl() {
        return $this->image ? $this->image->getUrl() : config("images.default");
    }

    public function getPath() {
        return Storage::disk("models")->path($this->getCode());
    }

    public function getDisplayName() {
        return $this->name;
    }

    public function canEdit(User|null $user) {
        if (!$user) {
            return false;
        }

        return $this->user_id == $user->id || $user->isAdmin();
    }

    public function getOriginalLength() {
        return $this->length / $this->scale_length;
    }

    public function getOriginalWidth() {
        return $this->width / $this->scale_width;
    }

    public function getOriginalHeight() {
        return $this->height / $this->scale_height;
    }

    public function getOriginalDiameter() {
        return $this->diameter / sqrt($this->scale_length * $this->scale_width);
    }

    public function getOriginalVolume() {
        return $this->volume / ($this->scale_length * $this->scale_width * $this->scale_height);
    }

    public function scale(float $length, float $width, float $height) {
        $this->length = $this->getOriginalLength() * $length;
        $this->width = $this->getOriginalWidth() * $width;
        $this->height = $this->getOriginalHeight() * $height;
        $this->diameter = $this->getOriginalDiameter() * sqrt($length * $width);
        $this->volume = $this->getOriginalVolume() * $length * $width * $height;
        $this->scale_length = $length;
        $this->scale_width = $width;
        $this->scale_height = $height;
    }
}
