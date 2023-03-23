@extends("layout")

@section("content")
@include("bootstrap.form", [
    "title" => __("model.print-model.action.edit"),
    "fields" => [
        "name" => [
            "label" => __("model.print-model.name"),
            "max" => "255",
            "value" => $printModel->name,
        ],
    ],
    "submit" => __("model.print-model.action.save"),
])
@endsection