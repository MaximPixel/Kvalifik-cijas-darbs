@extends("layout")

@section("content")
<h1>{{ $printModel->name }}</h1>
<p>length: {{ $printModel->length }} mm</p>
<p>width: {{ $printModel->width }} mm</p>
<p>height: {{ $printModel->height }} mm</p>
<p>diameter: {{ $printModel->diameter }} mm</p>
<p>volume: {{ $printModel->volume }} mm3</p>
<p>
    <a href="{{ route('model.print-model', ['action' => 'download', 'code' => $printModel->getCode()]) }}" target="_blank">download</a>
</p>
@endsection