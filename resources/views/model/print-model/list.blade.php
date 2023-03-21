@extends("layout")

@section("content")
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h1>models</h1>
    <p>
        <a href="{{ route('model.print-model', ['action' => 'create']) }}">upload and create new</a>
    </p>
    <ul class="list-unstyled">
        @foreach ($printModels as $printModel)
        <li class="media">
            <div class="media-body">
                <h5 class="mt-0">
                    <a href="{{ $printModel->getRoute() }}">{{ $printModel->name }}</a>
                </h5>
            </div>
        </li>
        @endforeach
    </ul>
</main>
@endsection