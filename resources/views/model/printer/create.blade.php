@php
    $requiredFeats = \App\Models\PrinterFeatType::query()
        ->where("required", true)
        ->get();
@endphp

@extends("layout")

@section("content")
@include("bootstrap.form", [
    "title" => __("model.printer.basic-info"),
    "fields" => collect([
        "name" => [
            "label" => __("model.printer.name"),
            "min" => "5",
            "max" => "255",
        ],
        "description" => [
            "label" => __("model.printer.description"),
            "type" => "textarea",
            "cols" => 30,
            "rows" => 10,
            "min" => "10",
            "max" => "1000",
        ],
        "manufacturer" => [
            "label" => __("model.printer.manufacturer"),
            "max" => "255",
        ],
    ])->merge($requiredFeats->mapWithKeys(function ($printerFeatType) {
        return [
            "feat[$printerFeatType->code]" => [
                "type" => "featValue",
                "featType" => $printerFeatType,
                "label" => $printerFeatType->name,
            ]
        ];
    })),
    "submit" => __("model.printer.action.create-submit"),
])
@endsection