@extends("layout")

@section("content")
@include("bootstrap.form", [
    "title" => __("model.print-model.action.create"),
    "enctype" => "multipart/form-data",
    "fields" => [
        "model-file" => [
            "label" => __("model.print-model.file"),
            "type" => "file",
        ],
        "name" => [
            "label" => __("model.print-model.name"),
        ],
    ],
    "submit" => __("model.print-model.action.submit-create"),
])
@endsection