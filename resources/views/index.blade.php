@extends("layout")

@section("content")
@php
$modelClasses = [
    \App\Models\Manf::class,
    \App\Models\Printer::class,
    \App\Models\PrintModel::class,
];
@endphp

@foreach ($modelClasses as $modelClass)
<p>{{ $modelClass }}</p>
<p>
    <a href="{{ $modelClass::getCreateRoute() }}">create</a>
</p>
@foreach ($modelClass::all() as $model)
<p>
    <a href="{{ $model->getRoute() }}">{{ $model->getCode() }}</a>
</p>
@endforeach
@endforeach
@endsection