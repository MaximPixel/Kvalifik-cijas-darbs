@extends("layout")

@section("content")
<h3>order #{{ $order->getCode() }}</h3>
<p>
    <a href="{{ $order->manfService->getRoute() }}">service</a>
</p>
<p>
    <a href="{{ $order->printModel->getRoute() }}">model</a>
</p>
<p>material: {{ $order->printMaterialColor->printMaterial->name }} - {{ $order->printMaterialColor->name }}</p>
<p>amount: {{ $order->amount }}</p>
@if ($order->time !== null)
<p>time: {{ $order->time }}</p>
@else
<p>time: not defined</p>
@endif
@if ($order->manfService->canCalculatePrice($order))
<p>calculated price: {{ $order->manfService->calculatePrice($order) }}</p>
@else
<p>can't calculate price</p>
@endif
@endsection