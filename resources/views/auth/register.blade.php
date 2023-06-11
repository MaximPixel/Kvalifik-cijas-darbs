@extends("layout")

@section("content")
<div class="p-4 d-flex justify-content-center">
    @include("bootstrap.form", [
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
</div>
@endsection