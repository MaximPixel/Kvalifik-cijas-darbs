@extends("layout")

@section("content")
@include("bootstrap-form", [
    "title" => __("manf.action.create"),
    "fields" => [
        "name" => [
            "label" => __("manf.name"),
            "min" => "5",
            "max" => "255",
        ],
        "email" => [
            "label" => __("manf.email"),
            "type" => "email",
        ],
    ],
    "submit" => __("manf.action.submit"),
])
@endsection