@extends("layout")

@section("content")
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h1>@lang("model.print-model.list.title")</h1>
    <p>
        <a class="btn btn-primary" href="{{ route('model.print-model', ['action' => 'create']) }}">@lang("model.print-model.list.action.create-new")</a>
    </p>
    <ul class="list-unstyled">
        @foreach ($printModels as $printModel)
        <li class="d-flex mt-4 align-items-center">
            <div class="flex-shrink-0">
                <img class="mr-3 img-thumbnail" style="width: 100px" src="{{ $printModel->image->getUrl() }}" alt="{{ $printModel->name }}">
            </div>
            <div class="flex-grow-1 ms-3">
                <h5 class="mt-0">
                    <a href="{{ $printModel->getRoute() }}">{{ $printModel->name }}</a>
                </h5>
            </div>
        </li>
        @endforeach
    </ul>
</main>
@endsection