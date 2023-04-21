@extends("layout")

@section("content")
@include("bootstrap.form", [
    "title" => __("model.manf.action.edit"),
    "fields" => [
        "name" => [
            "label" => __("model.manf.name"),
            "min" => "5",
            "max" => "255",
            "value" => $manf->name,
        ],
        "email" => [
            "label" => __("model.manf.email"),
            "type" => "email",
            "value" => $manf->email,
        ],
    ],
    "submit" => __("model.manf.action.submit-edit"),
])
@endsection