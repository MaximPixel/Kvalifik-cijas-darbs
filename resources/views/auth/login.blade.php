@extends("layout")

@section("content")
<div class="p-4 d-flex justify-content-center">
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
</div>
@endsection