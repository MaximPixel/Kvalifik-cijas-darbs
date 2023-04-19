@extends("layout")

@section("content")
@include("bootstrap.form", [
    "title" => __("model.printer.basic-info"),
    "fields" => [
        __("model.printer.basic-info") => [
            "_errors" => $errors->basicInfo,
            "name" => [
                "label" => __("model.printer.name"),
                "required" => true,
                "min" => "5",
                "max" => "255",
                "value" => $printer->name,
            ],
            "description" => [
                "label" => __("model.printer.description"),
                "type" => "textarea",
                "cols" => 30,
                "rows" => 10,
                "min" => "10",
                "max" => "1000",
                "value" => $printer->description,
            ],
            "manufacturer" => [
                "label" => __("model.printer.manufacturer"),
                "required" => true,
                "max" => "255",
                "value" => $printer->manufacturer,
            ],
        ],
        __("model.printer.feats") => $printer->getEditFeatTypes()->mapWithKeys(function ($printerFeatType) use ($printer) {
            return [
                "feat[$printerFeatType->code]" => [
                    "type" => "featValue",
                    "featType" => $printerFeatType,
                    "label" => $printerFeatType->name,
                    "featValues" => $printer->getPrinterFeatValues($printerFeatType),
                ],
            ];
        })->merge(["_errors" => $errors->feats]),
    ],
    "submit" => __("model.printer.action.edit-submit"),
])
@endsection