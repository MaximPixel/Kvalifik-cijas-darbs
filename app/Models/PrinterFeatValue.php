<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinterFeatValue extends Model {

    use HasFactory, HasCode;

    public static function booted() {
        static::saving(function ($model) {
            if (!$model->exists) {
                $model->value_reference = self::getValueReference([
                    "name" => $model->name,
                    "decimal_value" => $model->decimal_value,
                    "boolean_value" => $model->boolean_value,
                    "unit" => $model->unit,
                    "printer_feat_type_id" => $model->printer_feat_type_id,
                ]);
            }
        });
        self::bootedHasCode();
    }

    public static function getValueReference(array $array) {
        $strings = collect([
            $array["printer_feat_type_id"],
            $array["name"],
            $array["decimal_value"] ?? null,
            $array["boolean_value"] ?? null,
            $array["unit"] ?? null,
        ]);
        return $strings->filter()->join("-");
    }

    public static function getOrCreate(array $array, PrinterFeatType $printerFeatType) {
        $array["printer_feat_type_id"] = $printerFeatType->id;
        $valueReference = self::getValueReference($array);

        $printerFeatValue = PrinterFeatValue::where("value_reference", $valueReference)->first();

        if (!$printerFeatValue) {
            $printerFeatValue = new PrinterFeatValue;
            $printerFeatValue->deleted = false;
            $printerFeatValue->printer_feat_type_id = $printerFeatType->id;
            $printerFeatValue->name = $array["name"];
            $printerFeatValue->description = $array["desciption"] ?? "";
            $printerFeatValue->decimal_value = $array["decimal_value"] ?? null;
            $printerFeatValue->boolean_value = $array["boolean_value"] ?? null;
            $printerFeatValue->unit = $array["unit"] ?? null;
            $printerFeatValue->save();
        }

        return $printerFeatValue;
    }

    public function printerFeatType() {
        return $this->belongsTo(PrinterFeatType::class);
    }

    public function getDisplayName() {
        return "$this->name $this->unit";
    }
}
