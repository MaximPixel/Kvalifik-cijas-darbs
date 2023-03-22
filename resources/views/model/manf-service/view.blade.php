@extends("layout")

@section("content")
<h1>{{ $manfService->name }}</h1>
<p>{{ $manfService->description }}</p>
<p>
    <a href="{{ route('model.order', ['action' => 'create', 'service' => $manfService->getCode()]) }}">create order</a>
</p>

<p>printers:</p>
<ul>
    <li>
        <a href="{{ $manfService->getActionRoute('add-printer') }}">@lang("model.manf-service.action.add-printer")</a>
    </li>
@foreach ($manfService->manfServicePrinters as $manfServicePrinter)
@php $printer = $manfServicePrinter->printer @endphp
    <li>
        <a href="{{ $printer->getRoute() }}">{{ $printer->name }}</a> <a href="{{ route('model.manf-service', ['code' => $manfService->getCode(), 'printer' => $printer->getCode(), 'action' => 'remove-printer']) }}">remove</a>
    </li>
@endforeach
</ul>

<p>materials:</p>
@php
    $serviceMaterialColors = $manfService->manfServicePrintMaterialColors;
    $materialColors = $serviceMaterialColors->pluck("printMaterialColor");
    $materials = $materialColors->pluck("printMaterial")->unique();
@endphp
<ul>
    <li>
        <a href="{{ $manfService->getActionRoute('edit-materials') }}">@lang("model.manf-service.action.edit-materials")</a>
    </li>
@foreach ($materials as $material)
    <li>{{ $material->name }}</li>
    <ul>
    @foreach ($materialColors->where("print_material_id", $material->id) as $color)
        <li>{{ $color->name }}</li>
    @endforeach
    </ul>
@endforeach
</ul>

<p>orders:</p>
<ul>
@foreach (\App\Models\Order::where("manf_service_id", $manfService->id)->get() as $order)
    <li>
        <a href="{{ $order->getRoute() }}">order #{{ $order->getCode() }}</a>
    </li>
@endforeach
</ul>

<p>
    <a href="{{ $manfService->getActionRoute('delete') }}">@lang("model.manf-service.action.delete")</a>
</p>
@endsection