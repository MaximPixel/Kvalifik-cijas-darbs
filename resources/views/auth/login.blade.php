@extends("layout")

@php
    dump($errors);
@endphp

@section("content")
@include("bootstrap.form", [
    "title" => __("auth.login"),
    "fields" => [
        "email" => [
            "label" => __("auth.email"),
            "type" => "email",
        ],
        "password" => [
            "label" => __("auth.password"),
            "type" => "password",
        ],
    ],
    "submit" => __("auth.login"),
])
@endsection