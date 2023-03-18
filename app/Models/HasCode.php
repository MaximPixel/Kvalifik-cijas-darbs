<?php

namespace App\Models;

trait HasCode {

    public static function booted() {
        static::saving(function ($model) {
            $model->generateCode();
        });
    }

    public function generateCode() {
        do {
            $code = str()->random(15);
            $sameObject = self::firstWhere("code", $code);
        } while ($sameObject);

        $this->code = $code;
    }

    public function getCode() {
        return $this->code;
    }
}