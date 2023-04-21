@php
    $canEdit = $manfService->canEdit(auth()->user());
@endphp

@extends("layout")

@section("content")
<h1>
    {{ $manfService->name }}
</h1>
<p>{{ $manfService->description }}</p>
<p>
    @lang("model.manf-service.manf"): <a href="{{ $manfService->manf->getRoute() }}">{{ $manfService->manf->getDisplayName() }}</a>
</p>
@if ($canEdit)
<p>
    <a class="btn btn-primary" href="{{ $manfService->getEditRoute() }}">@lang("model.manf-service.action.edit")</a>
</p>
@endif
@if (auth()->check())
<p>
    <a class="btn btn-primary" href="{{ route('model.order', ['action' => 'create', 'service' => $manfService->getCode()]) }}">@lang("model.manf-service.action.create-order")</a>
</p>
@endif

<div class="card mb-3">
    <div class="card-header">@lang("model.manf-service.printers")</div>
    <div class="card-body">
    @if ($canEdit)
        <a class="btn btn-primary mb-3" href="{{ $manfService->getAddPrinterRoute() }}">@lang("model.manf-service.action.add-printer")</a>
    @endif
        <div class="overflow-auto">
            <div class="d-inline-flex">
                @foreach ($manfService->manfServicePrinters as $manfServicePrinter)
                @php $printer = $manfServicePrinter->printer @endphp
                <div class="d-inline-block" style="width: 200px">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-text" style="position: relative;">
                                <img src="{{ $printer->getImageUrl() }}" alt="" style="width: 100%">
                                <h5 class="card-title">{{ $printer->getDisplayName() }}</h5>
                                <p class="card-text">{{ $printer->getPrintVolume() }}</p>
                                <a href="{{ $printer->getRoute() }}" class="stretched-link"></a>
                            </div>
                        @if ($canEdit)
                            <div class="card-text">
                                <a class="btn btn-danger" href="{{ $manfService->getRemovePrinterRoute($printer) }}">@lang("model.manf-service.action.remove-printer")</a>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@php
    $serviceMaterialColors = $manfService->manfServicePrintMaterialColors;
    $materialColors = $serviceMaterialColors->pluck("printMaterialColor");
    $materials = $materialColors->pluck("printMaterial")->unique();
@endphp
<div class="card mb-3">
    <div class="card-header">@lang("model.manf-service.materials")</div>
    <div class="card-body">
    @if ($canEdit)
        <a class="btn btn-primary mb-3"href="{{ $manfService->getActionRoute('edit-materials') }}">@lang("model.manf-service.action.edit-materials")</a>
    @endif
        <ul class="list-group list-group-flush">
        @foreach ($materials as $material)
            <li class="list-group-item">{{ $material->name }}</li>
            <ul class="list-group list-group-flush ms-5">
            @foreach ($materialColors->where("print_material_id", $material->id) as $color)
                <li class="list-group-item">{{ $color->name }}</li>
            @endforeach
            </ul>
        @endforeach
        </ul>
    </div>
</div>

@if ($canEdit && $manfService->orders->isNotEmpty())
<div class="card mb-3">
    <div class="card-header">@lang("model.manf-service.orders")</div>
    <div class="card-body">
        <ul>
        @foreach ($manfService->orders as $order)
            <li>
                <a href="{{ $order->getRoute() }}">@lang("model.order.display-name", ["code" => $order->getCode() ])</a>
            </li>
        @endforeach
        </ul>
    </div>
</div>
@endif

@if ($canEdit && !$manfService->deleted)
<p>
    <a class="btn btn-danger" href="{{ $manfService->getActionRoute('delete') }}">@lang("model.manf-service.action.delete")</a>
</p>
@endif
@endsection