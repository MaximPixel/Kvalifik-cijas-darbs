@extends("layout")

@section("content")
@php
    $urls = [
        \App\Models\Printer::getCreateRoute(),
        route("model.print-model", ["action" => "create"]),
    ];
@endphp
@foreach ($urls as $url)
<p>
    <a href="{{ $url }}">{{ $url }}</a>
</p>
@endforeach
@foreach (\App\Models\Printer::all() as $printer)
<p>
    <a href="{{ $printer->getRoute() }}">{{ $printer->getRoute() }}</a>
</p>
@endforeach
@foreach (\App\Models\Manf::all() as $manf)
<p>
    <a href="{{ $manf->getRoute() }}">{{ $manf->getRoute() }}</a>
</p>
@endforeach
@foreach (\App\Models\PrintModel::all() as $printModel)
<p>
    <a href="{{ $printModel->getRoute() }}">{{ $printModel->getRoute() }}</a>
</p>
@endforeach
@endsection