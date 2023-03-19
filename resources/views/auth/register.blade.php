@extends("layout")

@section("content")
@include("bootstrap-form", [
    "title" => __("auth.register"),
    "fields" => [
        "name" => [
            "label" => __("auth.name"),
            "min" => 2,
            "max" => 255,
        ],
        "email" => [
            "label" => __("auth.email"),
            "type" => "email",
            "max" => 255,
        ],
        "password" => [
            "label" => __("auth.password"),
            "type" => "password",
        ],
        "password_confirmation" => [
            "label" => __("auth.password-confirmation"),
            "type" => "password",
        ],
    ],
    "submit" => __("auth.register"),
])
@endsection