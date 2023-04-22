@extends("layout")

@section("content")
<h3>@lang("model.order.display-name", ["code" => $order->getCode()])</h3>
<div class="card mb-3">
    <div class="card-body">
        <p>@lang("model.order.service"): <a href="{{ $order->manfService->getRoute() }}">{{ $order->manfService->getDisplayName() }}</a></p>
        <p>@lang("model.order.model"): <a href="{{ $order->printModel->getRoute() }}">{{ $order->printModel->getDisplayName() }}</a></p>
    </div>
    <div class="card-body">
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
    </div>
</div>

@php
    $statusesHistoryPagination = (new \App\Classes\CustomPaginator($order->orderOrderStatuses()->paginate(4)))->withQueryString();
@endphp

<div class="card mb-3">
    <div class="card-body">
    @foreach ($statusesHistoryPagination->items() as $orderOrderStatus)
        <table class="table table-bordered table-striped">
            <thead></thead>
            <tbody>
                <tr>
                    <th>@lang("model.order.status.type")</th>
                    <td>{{ $orderOrderStatus->orderStatus->getDisplayName() }}</td>
                </tr>
                <tr>
                    <th>@lang("model.order.status.comment")</th>
                    <td>{{ $orderOrderStatus->comment }}</td>
                </tr>
                <tr>
                    <th>@lang("model.order.status.updated-at")</th>
                    <td>{{ $orderOrderStatus->updated_at }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach
        @include("bootstrap.pagination", ["pagination" => $statusesHistoryPagination])
    </div>
</div>

@if ($order->canEdit(request()->user()))
<div class="card mb-3">
    <div class="card-body">
        @include("bootstrap.form", [
            "title" => __("model.order.action.change-status"),
            "fields" => [
                "action" => [
                    "type" => "hidden",
                    "label" => "",
                    "value" => "change-status",
                ],
                "status" => [
                    "type" => "select",
                    "label" => __("model.order.status.type"),
                    "values" => \App\Models\OrderStatus::all()->map(function ($orderStatus) {
                        return [
                            "label" => $orderStatus->getDisplayName(),
                            "value" => $orderStatus->name,
                        ];
                        return null;
                    }),
                ],
                "comment" => [
                    "label" => __("model.order.status.comment-label"),
                    "type" => "textarea",
                ],
            ],
            "submit" => __("model.order.action.change-status-submit"),
        ])
    </div>
</div>
@endif
@endsection