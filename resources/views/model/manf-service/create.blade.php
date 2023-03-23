@extends("layout")

@section("content")
@include("bootstrap.form", [
    "title" => __("model.manf-service.action.create"),
    "fields" => [
        "name" => [
            "label" => __("model.manf-service.name"),
            "min" => "5",
            "max" => "255",
        ],
        "description" => [
            "label" => __("model.manf-service.description"),
            "type" => "textarea",
        ],
        "price_base" => [
            "label" => __("model.manf-service.price_base"),
            "type" => "number",
        ],
        "price_min" => [
            "label" => __("model.manf-service.price_min"),
            "type" => "number",
        ],
        "price_per_time" => [
            "label" => __("model.manf-service.price_per_time"),
            "type" => "number",
        ],
        "price_per_volume" => [
            "label" => __("model.manf-service.price_per_volume"),
            "type" => "number",
        ],
    ],
    "submit" => __("model.manf-service.action.create-submit"),
])
@endsection