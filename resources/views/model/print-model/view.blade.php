@extends("layout")

@section("content")
<div class="d-flex position-relative">
    <img style="width: 200px" src="{{ $printModel->getImageUrl() }}">
    <div>
        <h5 class="mt-0">{{ $printModel->name }}</h5>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">@lang("model.print-model.parameters")</div>
    <div class="card-body">
        <p>@lang("model.print-model.length"): {{ $printModel->length }} mm</p>
        <p>@lang("model.print-model.width"): {{ $printModel->width }} mm</p>
        <p>@lang("model.print-model.height"): {{ $printModel->height }} mm</p>
        <p>@lang("model.print-model.volume"): {{ $printModel->volume }} mm3</p>
    </div>
</div>

<p>
    <a class="btn btn-primary" href="{{ $printModel->getActionRoute('download') }}" target="_blank">@lang("model.print-model.action.download")</a>
</p>
<p>
    <a class="btn btn-primary" href="{{ $printModel->getActionRoute('edit') }}">@lang("model.print-model.action.edit")</a>
</p>
<p>
    <a class="btn btn-primary" href="{{ $printModel->getActionRoute('delete') }}">@lang("model.print-model.action.delete")</a>
</p>
@endsection