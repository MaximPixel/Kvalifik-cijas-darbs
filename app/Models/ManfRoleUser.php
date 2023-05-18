<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManfRoleUser extends Model {

    use HasFactory;

    protected $primaryKey = ["manf_role_id", "user_id"];
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

    public function manfRole() {
        return $this->belongsTo(ManfRole::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
