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
    <a href="{{ $model->getRoute() }}">{{ $model->name }}</a>
</p>
@endforeach
@endforeach
<p>
    <a href="{{ route('model.manf-service', ['action' => 'list']) }}">services list</a>
</p>
@endsection