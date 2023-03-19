@extends("layout")

@section("content")
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <form action="" method="POST">
                    @csrf
                    <select name="manf" id="manf">
                        <option value="">-</option>
                    @foreach ($totalManfServices->pluck("manf")->unique("id") as $manf)
                        <option
                            value="{{ $manf->getCode() }}"
                            @if (request()->get("manf") == $manf->getCode()) selected @endif
                        >{{ $manf->name }}</option>
                    @endforeach
                    </select>
                    <select name="model" id="model">
                        <option value="">-</option>
                    @foreach (\App\Models\PrintModel::all() as $model)
                        <option
                            value="{{ $model->getCode() }}"
                            @if (request()->get("model") == $model->getCode()) selected @endif
                        >{{ $model->getCode() }}</option>
                    @endforeach
                    </select>
                    <input type="submit" value="filter">
                </form>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h1>services</h1>
            <ul class="list-unstyled">
                @foreach ($manfServices as $manfService)
                <li class="media">
                    <div class="media-body">
                        <h5 class="mt-0">
                            <a href="{{ $manfService->getRoute() }}">{{ $manfService->name }}</a>
                        </h5>
                        <p>{{ $manfService->description }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </main>
    </div>
</div>
@endsection