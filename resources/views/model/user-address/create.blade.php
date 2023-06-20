@extends("layout")

@section("content")
@include("bootstrap.form", [
    "title" => __("model.user-address.action.create"),
    "fields" => [
        "contact_name" => [
            "label" => __("model.user-address.contact_name"),
            "max" => 255,
        ],
        "phone_number_prefix" => [
            "label" => __("model.user-address.phone_number_prefix"),
            "max" => 255,
        ],
        "phone_number" => [
            "label" => __("model.user-address.phone_number"),
            "max" => 255,
        ],
        "address_street" => [
            "label" => __("model.user-address.address_street"),
            "max" => 255,
        ],
        "address_apt" => [
            "label" => __("model.user-address.address_apt"),
            "max" => 255,
        ],
        "address_province" => [
            "label" => __("model.user-address.address_province"),
            "max" => 255,
        ],
        "address_city" => [
            "label" => __("model.user-address.address_city"),
            "max" => 255,
        ],
        "address_zipcode" => [
            "label" => __("model.user-address.address_zipcode"),
            "max" => 255,
        ],
        "comment" => [
            "label" => __("model.user-address.comment"),
            "max" => 255,
        ],
    ],
    "submit" => __("model.user-address.action.submit"),
])
<p>
    <button class="btn btn-warning" id="test" onclick="test()">Test</button>
</p>
<script>
    function test() {
        document.getElementById("contact_name").value = "Test";
        document.getElementById("phone_number_prefix").value = "+371";
        document.getElementById("phone_number").value = "12345678";
        document.getElementById("address_street").value = "Kaut kāda iela";
        document.getElementById("address_apt").value = "";
        document.getElementById("address_province").value = "Riga";
        document.getElementById("address_city").value = "Riga";
        document.getElementById("address_zipcode").value = "1234";
        document.getElementById("comment").value = "";
    }
</script>
@endsection