@extends("layout")

@section("content")
<h1>{{ $manfService->name }}</h1>
<p>{{ $manfService->description }}</p>
@if (auth()->check())
<p>
    <a class="btn btn-primary" href="{{ route('model.order', ['action' => 'create', 'service' => $manfService->getCode()]) }}">@lang("model.manf.action.create-order")</a>
</p>
@endif

<div class="card mb-3">
    <div class="card-header">@lang("model.manf-service.printers")</div>
    <div class="card-body">
        <a class="btn btn-primary mb-3" href="{{ $manfService->getActionRoute('add-printer') }}">@lang("model.manf-service.action.add-printer")</a>
        <ul class="list-group list-group-flush">
        @foreach ($manfService->manfServicePrinters as $manfServicePrinter)
        @php $printer = $manfServicePrinter->printer @endphp
            <li class="list-group-item">
                <a href="{{ $printer->getRoute() }}">{{ $printer->name }}</a> <a href="{{ route('model.manf-service', ['code' => $manfService->getCode(), 'printer' => $printer->getCode(), 'action' => 'remove-printer']) }}">@lang("model.manf-service.action.remove-printer")</a>
            </li>
        @endforeach
        </ul>
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
        <a class="btn btn-primary mb-3"href="{{ $manfService->getActionRoute('edit-materials') }}">@lang("model.manf-service.action.edit-materials")</a>
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

<div class="card mb-3">
    <div class="card-header">@lang("model.manf-service.orders")</div>
    <div class="card-body">
        <ul>
        @foreach (\App\Models\Order::where("manf_service_id", $manfService->id)->get() as $order)
            <li>
                <a href="{{ $order->getRoute() }}">@lang("model.order.display-name", ["code" => $order->getCode() ])</a>
            </li>
        @endforeach
        </ul>
    </div>
</div>

<p>
    <a class="btn btn-danger" href="{{ $manfService->getActionRoute('delete') }}">@lang("model.manf-service.action.delete")</a>
</p>
@endsection