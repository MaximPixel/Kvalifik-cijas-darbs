@extends("layout")

@section("content")
@include("bootstrap-form", [
    "title" => __("printer.basic-info"),
    "fields" => [
        "name" => [
            "label" => __("printer.name"),
            "min" => "5",
            "max" => "255",
        ],
        "description" => [
            "label" => __("printer.description"),
            "type" => "textarea",
            "cols" => 30,
            "rows" => 10,
            "min" => "10",
            "max" => "1000",
        ],
        "manufacturer" => [
            "label" => __("printer.manufacturer"),
            "max" => "255",
        ],
    ],
    "submit" => __("printer.action.submit"),
])
@php
    $requiredFeats = \App\Models\PrinterFeatType::query()
        ->where("required", true)
        ->get();
@endphp
@include("bootstrap-form", [
    "title" => __("printer.feats"),
    "fields" => $requiredFeats->mapWithKeys(function ($printerFeatType) {
        return [
            "feat[$printerFeatType->code]" => [
                "type" => "featValue",
                "featType" => $printerFeatType,
                "label" => $printerFeatType->name,
            ]
        ];
    }),
    "submit" => __("printer.action.submit"),
])
@endsection