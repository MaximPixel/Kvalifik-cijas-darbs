@php
    $modelTypes = [
        [
            "label" => __("admin.model.manf-service"),
            "class" => \App\Models\ManfService::class,
        ],
        [
            "label" => __("admin.model.user"),
            "class" => \App\Models\User::class,
        ],
        [
            "label" => __("admin.model.manf"),
            "class" => \App\Models\Manf::class,
        ],
        [
            "label" => __("admin.model.printer"),
            "class" => \App\Models\Printer::class,
        ],
    ];
@endphp

@extends("layout")

@section("content")
@foreach ($modelTypes as $modelType)
@php
    $pageName = (string) str($modelType["class"])->afterLast("\\")->snake("-") . "-page";
    $pagination = (new \App\Classes\CustomPaginator($modelType["class"]::paginate(perPage: 6, pageName: $pageName)))->withQueryString();
@endphp
<div class="card mb-3" id="{{ $modelType['class'] }}">
    <div class="card-header">{{ $modelType["label"] }}</div>
    <div class="card-body">
        <div class="row">
        @foreach ($pagination->items() as $model)
            <div class="col-2">
                <p>
                    <a href="{{ $model->getRoute() }}">{{ $model->getDisplayName() }}</a>
                </p>
            </div>
        @endforeach
        </div>
        @include("bootstrap.pagination")
    </div>
</div>
@endforeach
@endsection