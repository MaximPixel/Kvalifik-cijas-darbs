<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManfServicePrintMaterialColor extends Model {

    use HasFactory;

    protected $primaryKey = ["manf_service_id", "print_material_color_id"];
    public $incrementing = false;

    protected function setKeysForSaveQuery($query) {
        collect($this->primaryKey)->each(function ($field) use ($query) {
            $query->where($field, $this->getKeyForSaveQuery($field));
        });
        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null) {
        if ($keyName === null) {
            $keyName = $this->getKeyName();
        }

        return $this->original[$keyName] ?? $this->getAttribute($keyName);
    }

    public function getKey() {
        return collect($this->primaryKey)->mapWithKeys(function ($field) {
            return [ $field => $this->getKeyForSaveQuery($field) ];
        });
    }

    public function manfService() {
        return $this->belongsTo(ManfService::class);
    }

    public function printMaterialColor() {
        return $this->belongsTo(PrintMaterialColor::class);
    }
}
