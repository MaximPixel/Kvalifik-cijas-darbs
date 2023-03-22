@extends("layout")

@section("content")
<h1>{{ $printModel->name }}</h1>
<img class="rounded img-thumbnail" style="width: 300px" src="{{ $printModel->image->getUrl() }}" alt="{{ $printModel->name }}">
<p>length: {{ $printModel->length }} mm</p>
<p>width: {{ $printModel->width }} mm</p>
<p>height: {{ $printModel->height }} mm</p>
<p>diameter: {{ $printModel->diameter }} mm</p>
<p>volume: {{ $printModel->volume }} mm3</p>
<p>
    <a href="{{ $printModel->getActionRoute('download') }}" target="_blank">@lang("model.print-model.action.download")</a>
</p>
<p>
    <a href="{{ $printModel->getActionRoute('edit') }}">@lang("model.print-model.action.edit")</a>
</p>
<p>
    <a href="{{ $printModel->getActionRoute('delete') }}">@lang("model.print-model.action.delete")</a>
</p>
@endsection