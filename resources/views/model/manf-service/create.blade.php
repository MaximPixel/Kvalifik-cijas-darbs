@extends("layout")

@section("content")
@include("bootstrap-form", [
    "title" => __("manf-service.action.create"),
    "fields" => [
        "name" => [
            "label" => __("manf-service.name"),
            "min" => "5",
            "max" => "255",
        ],
        "description" => [
            "label" => __("manf-service.description"),
            "type" => "textarea",
        ],
    ],
    "submit" => __("manf-service.action.submit"),
])
@endsection