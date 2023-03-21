@extends("layout")

@section("content")
@include("bootstrap-form", [
    "title" => __("user-address.action.create"),
    "fields" => [
        "contact_name" => [
            "label" => __("user-address.contact_name"),
            "max" => 255,
        ],
        "phone_number_prefix" => [
            "label" => __("user-address.phone_number_prefix"),
            "max" => 255,
        ],
        "phone_number" => [
            "label" => __("user-address.phone_number"),
            "max" => 255,
        ],
        "address_street" => [
            "label" => __("user-address.address_street"),
            "max" => 255,
        ],
        "address_apt" => [
            "label" => __("user-address.address_apt"),
            "max" => 255,
        ],
        "address_province" => [
            "label" => __("user-address.address_province"),
            "max" => 255,
        ],
        "address_city" => [
            "label" => __("user-address.address_city"),
            "max" => 255,
        ],
        "address_zipcode" => [
            "label" => __("user-address.address_zipcode"),
            "max" => 255,
        ],
        "comment" => [
            "label" => __("user-address.comment"),
            "max" => 255,
        ],
    ],
    "submit" => __("user-address.action.submit"),
])
@endsection