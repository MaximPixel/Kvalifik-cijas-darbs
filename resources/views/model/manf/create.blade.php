@extends("layout")

@section("content")
@include("bootstrap.form", [
    "title" => __("model.manf.action.create"),
    "fields" => [
        "name" => [
            "label" => __("model.manf.name"),
            "min" => "5",
            "max" => "255",
        ],
        "email" => [
            "label" => __("model.manf.email"),
            "type" => "email",
        ],
    ],
    "submit" => __("model.manf.action.submit-create"),
])
@endsection