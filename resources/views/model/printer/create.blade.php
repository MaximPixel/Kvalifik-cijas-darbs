@php
    $requiredFeatTypes = \App\Models\Printer::getRequiredFeatTypes();
@endphp

@extends("layout")

@section("content")
@include("bootstrap.form", [
    "title" => __("model.printer.basic-info"),
    "fields" => [
        __("model.printer.basic-info") => [
            "_errors" => $errors->basicInfo,
            "name" => [
                "label" => __("model.printer.name"),
                "required" => true,
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
                "required" => true,
                "max" => "255",
            ],
        ],
        __("model.printer.feats") => $requiredFeatTypes->mapWithKeys(function ($printerFeatType) {
            return [
                "feat[$printerFeatType->code]" => [
                    "type" => "featValue",
                    "featType" => $printerFeatType,
                    "label" => $printerFeatType->name,
                ],
            ];
        })->merge(["_errors" => $errors->feats]),
    ],
    "submit" => __("model.printer.action.create-submit"),
])
@endsection