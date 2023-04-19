<?php

namespace App\Models;

trait HasCode {

    public static function booted() {
        self::bootedHasCode();
    }

    protected static function bootedHasCode() {
        static::saving(function ($model) {
            if (!$model->exists) {
                $model->generateCode();
            }
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