@extends("layout")

@section("content")

@php
    $admin = request()->user()->isAdmin();

    $fields = [
        "name" => [
            "label" => __("model.user.name"),
            "max" => "255",
            "value" => $user->name,
        ],
    ];

    if ($admin) {
        $fields["email"] = [
            "label" => __("model.user.email"),
            "max" => "255",
            "value" => $user->email,
        ];

        $fields["password"] = [
            "label" => __("model.user.password"),
            "value" => null,
        ];

        $fields["user_group"] = [
            "label" => __("model.user.user_group"),
            "type" => "select",
            "value" => $user->userGroup->name,
            "values" => \App\Models\UserGroup::all()->map(function ($userGroup) {
                return [
                    "value" => $userGroup->name,
                    "label" => str($userGroup->name)->ucfirst(),
                ];
            }),
        ];
    }
@endphp

@include("bootstrap.form", [
    "title" => __("model.user.action.edit"),
    "fields" => $fields,
    "submit" => __("model.user.action.save"),
])
@endsection