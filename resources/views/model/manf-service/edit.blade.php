@extends("layout")

@section("content")
@include("bootstrap.form", [
    "title" => __("model.manf-service.action.create"),
    "fields" => [
        "name" => [
            "label" => __("model.manf-service.name"),
            "min" => "5",
            "max" => "255",
            "value" => $manfService->name,
        ],
        "description" => [
            "label" => __("model.manf-service.description"),
            "type" => "textarea",
            "value" => $manfService->description,
        ],
        "price_base" => [
            "label" => __("model.manf-service.price_base"),
            "type" => "number",
            "value" => $manfService->price_base,
        ],
        "price_min" => [
            "label" => __("model.manf-service.price_min"),
            "type" => "number",
            "value" => $manfService->price_min,
        ],
        "price_per_time" => [
            "label" => __("model.manf-service.price_per_time"),
            "type" => "number",
            "value" => $manfService->price_per_time,
        ],
        "price_per_volume" => [
            "label" => __("model.manf-service.price_per_volume"),
            "type" => "number",
            "value" => $manfService->price_per_volume,
        ],
    ],
    "submit" => __("model.manf-service.action.edit-submit"),
])
@endsection