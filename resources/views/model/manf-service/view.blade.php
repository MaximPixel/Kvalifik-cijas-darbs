@extends("layout")

@section("content")
<h1>{{ $manfService->name }}</h1>
<p>{{ $manfService->description }}</p>

<p>printers:</p>
<ul>
    <li>
        <a href="{{ route('model.manf-service', ['action' => 'add-printer', 'code' => $manfService->getCode() ]) }}">add printer</a>
    </li>
@foreach ($manfService->manfServicePrinters as $manfServicePrinter)
@php $printer = $manfServicePrinter->printer @endphp
    <li>
        <a href="{{ $printer->getRoute() }}">{{ $printer->name }}</a> <a href="{{ route('model.manf-service', ['code' => $manfService->getCode(), 'printer' => $printer->getCode(), 'action' => 'remove-printer']) }}">remove</a>
    </li>
@endforeach
</ul>
@endsection