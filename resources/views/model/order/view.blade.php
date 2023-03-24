@extends("layout")

@section("content")
<h3>@lang("model.order.display-name", ["code" => $order->getCode()])</h3>
<p>
    <a class="btn btn-primary" href="{{ $order->manfService->getRoute() }}">@lang("model.order.service")</a>
</p>
<p>
    <a class="btn btn-primary" href="{{ $order->printModel->getRoute() }}">@lang("model.order.model")</a>
</p>
<p>@lang("model.order.material"): {{ $order->printMaterialColor->printMaterial->name }} - {{ $order->printMaterialColor->name }}</p>
<p>@lang("model.order.amount"): {{ $order->amount }}</p>
@if ($order->time !== null)
<p>@lang("model.order.time"): {{ $order->time }}</p>
@else
<p>@lang("model.order.time"): @lang("model.order.time-not-defined")</p>
@endif
@if ($order->manfService->canCalculatePrice($order))
<p>@lang("model.order.price"): {{ $order->manfService->calculatePrice($order) }}</p>
@else
<p>@lang("model.order.price-cant-calculate")</p>
@endif
@endsection