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

    public function image() {
        return $this->belongsTo(Image::class);
    }

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
        if (!$user) {
            return false;
        }
        return ($this->creator_user_id != null && $this->creator_user_id == $user->id) || $user->isAdmin();
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

    public function getImageUrl() {
        return $this->image ? $this->image->getUrl() : config("images.default");
    }

    public function getDisplayName() {
        return $this->name;
    }

    public function isCylindricalPrintVolume() {
        return $this->printerFeats->pluck("printerFeatValue")->pluck("printerFeatType")->where("name", "print-volume-d")->isNotEmpty();
    }

    public function getPrintVolume(string $axis = null) {
        if ($axis === null) {
            $axis = $this->isCylindricalPrintVolume() ? ["d", "z"] : ["x", "y", "z"];
        } else {
            $axis = [$axis];
        }

        $data = collect($axis)->map(function ($axis) {
            $printVolumeFeatType = PrinterFeatType::where("name", "print-volume-$axis")->first();
            $printerFeatValue = $this->printerFeats->pluck("printerFeatValue")->where("printer_feat_type_id", $printVolumeFeatType->id)->first();
            return $printerFeatValue->decimal_value;
        });

        if ($data->containsOneItem()) {
            return $data->first();
        }

        $string = $data->join(" x ") . " mm";

        if ($this->isCylindricalPrintVolume()) {
            $string = "ø $string";
        }

        return $string;
    }
}
