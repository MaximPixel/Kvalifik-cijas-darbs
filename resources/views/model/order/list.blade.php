@extends("layout")

@section("content")
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h1>@lang("model.order.action.list")</h1>
    <ul class="list-unstyled">
        @foreach ($orders as $order)
        <li class="d-flex mt-4 align-items-center">
            <div class="flex-shrink-0">
                <img class="mr-3 img-thumbnail" style="width: 100px" src="{{ $order->printModel->image->getUrl() }}" alt="order #{{ $order->getCode() }}">
            </div>
            <div class="flex-grow-1 ms-3">
                <h5 class="mt-0">
                    <a href="{{ $order->getRoute() }}">order #{{ $order->getCode() }}</a>
                </h5>
            </div>
        </li>
        @endforeach
    </ul>
</main>
@endsection