@extends("layout")

@section("content")
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <form action="" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="manf">@lang("model.manf-service.list.manf")</label>
                        <select class="form-select" name="manf" id="manf">
                            <option value="">-</option>
                        @foreach ($totalManfServices->pluck("manf")->unique("id") as $manf)
                            <option
                                value="{{ $manf->getCode() }}"
                            @if (request()->get("manf") == $manf->getCode()) selected @endif
                            >{{ $manf->name }}</option>
                        @endforeach
                        </select>
                    </div>

                    @php
                        $printModels = request()->user()->printModelsVisible ?? collect();
                    @endphp

                    @if ($printModels->isNotEmpty())
                    <div class="mb-3">
                        <label for="model">@lang("model.manf-service.list.model")</label>
                        <select class="form-select" name="model" id="model">
                            <option value="">-</option>
                        @foreach ($printModels as $model)
                            <option
                                value="{{ $model->getCode() }}"
                            @if (request()->get("model") == $model->getCode()) selected @endif
                            >{{ $model->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="material_color">@lang("model.manf-service.list.material-color")</label>
                        <select class="form-select" name="material_color" id="material_color">
                            <option value="">-</option>
                            @foreach (\App\Models\PrintMaterial::all() as $printMaterial)
                                <optgroup label="{{ $printMaterial->name }}">
                                @foreach ($printMaterial->printMaterialColors as $printMaterialColor)
                                    <option
                                        value="{{ $printMaterialColor->getCode() }}"
                                        style="color: #{{ $printMaterialColor->hex }}"
                                    @if (request()->get("material_color") == $printMaterialColor->getCode()) selected @endif
                                    >{{ $printMaterialColor->name }}</option>
                                @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <input class="btn btn-primary" type="submit" value="@lang('model.manf-service.list.action.filter')">
                </form>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h1>@lang("model.manf-service.list.title")</h1>
            <p>@lang("model.manf-service.list.show", ["count" => $manfServicesPagination->count(), "total" => $manfServicesPagination->total()])</p>
            <ul class="list-unstyled">
                @foreach ($manfServicesPagination->items() as $manfService)
                <li class="media">
                    <div class="media-body">
                        <h5 class="mt-0">
                            <a href="{{ $manfService->getRoute() }}">{{ $manfService->name }}</a>
                        </h5>
                        <p>{{ $manfService->description }}</p>
                        @php
                            $printerNames = $manfService->manfServicePrinters->pluck("printer")->map(fn ($a) => $a->getDisplayName());
                            $visiblePrinterNames = $printerNames->take(2);
                        @endphp
                    @if ($printerNames->count() == $visiblePrinterNames->count())
                        <p>{{ $visiblePrinterNames->join(", ") }}</p>
                    @else
                        <p>{{ $visiblePrinterNames->join(", ") }}, ({{ $printerNames->count() - $visiblePrinterNames->count() }} more)</p>
                    @endif
                    </div>
                </li>
                @endforeach
            </ul>
            @include("bootstrap.pagination", ["pagination" => $manfServicesPagination])
        </main>
    </div>
</div>
@endsection