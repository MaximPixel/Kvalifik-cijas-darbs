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
        "price_base" => [
            "label" => __("manf-service.price_base"),
            "type" => "number",
        ],
        "price_min" => [
            "label" => __("manf-service.price_min"),
            "type" => "number",
        ],
        "price_per_time" => [
            "label" => __("manf-service.price_per_time"),
            "type" => "number",
        ],
        "price_per_volume" => [
            "label" => __("manf-service.price_per_volume"),
            "type" => "number",
        ],
    ],
    "submit" => __("manf-service.action.submit"),
])
@endsection