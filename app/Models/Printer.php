<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model {

    public static function getCreateRoute() {
        return route("model.printer", ["action" => "create"]);
    }

    public static function getRequiredFeatTypes() {
        $requiredFeats = PrinterFeatType::query()
            ->where("required", true)
            ->get();
        
        return $requiredFeats;
    }

    use HasFactory, HasCode, HasCodeRoute, HasCodeEditRoute;

    public function creatorUser() {
        return $this->belongsTo(User::class, "creator_user_id");
    }

    public function printerFeats() {
        return $this->hasMany(PrinterFeat::class);
    }

    public function manfServicePrinters() {
        return $this->hasMany(ManfServicePrinter::class);
    }

    public function canEdit(User|null $user) {
        return $this->user_id != null && $this->user_id == $user->id;
    }

    public function getDefinedFeatTypes() {
        return $this->printerFeats->pluck("printerFeatValue")->pluck("printerFeatType");
    }

    public function getEditFeatTypes() {
        $requiredFeatTypes = $this->getRequiredFeatTypes();
        $currentFeatTypes = $this->getDefinedFeatTypes();

        return collect([$requiredFeatTypes, $currentFeatTypes])
            ->collapse()
            ->unique("id")
            ->values();
    }

    public function getPrinterFeatValues(PrinterFeatType $printerFeatType) {
        return $this->printerFeats->pluck("printerFeatValue")
            ->filter(fn ($printerFeatValue) => $printerFeatValue->printer_feat_type_id == $printerFeatType->id)
            ->values();
    }

    public function addPrinterFeatValue(PrinterFeatType $printerFeatType) {

    }
}
