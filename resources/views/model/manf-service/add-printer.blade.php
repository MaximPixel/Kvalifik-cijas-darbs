@extends("layout")

@section("content")
<form action="" method="POST">
    <label class="form-label">@lang("model.manf-service.add-printer.filters")</label>
    @csrf
    <div class="input-group mb-3">
        <input class="form-control" type="text" name="search" id="search" placeholder="@lang('model.printer.name')" value="{{ request()->get('search') }}">
        <select class="form-control" name="manufacturer" id="manufacturer">
        @php
            $manufacturers = \App\Models\Printer::query()
                ->select(["manufacturer"])
                ->distinct()
                ->get()
                ->pluck("manufacturer")
                ->map(fn ($a) => str($a)->upper());
        @endphp
        @foreach ($manufacturers as $manufacturer)
            <option value="">@lang("model.manf-service.add-printer.any-manf")</option>
            <option
                value="{{ $manufacturer }}"
            @if (str(request()->get("manufacturer"))->upper() == $manufacturer)
                selected
            @endif
            >{{ $manufacturer }}</option>
        @endforeach
        </select>
        <button type="submit" class="btn btn-primary">@lang("model.manf-service.add-printer.filter")</button>
    </div>
</form>
<h1>@lang("model.manf-service.action.add-printer")</h1>
@foreach ($printersPagination->items() as $printer)
<div class="card">
    <div class="card-body">
        <img src="{{ $printer->getImageUrl() }}" style="width: 200px">
        <h5 class="card-title">{{ $printer->getDisplayName() }}</h5>
        <p>{{ $printer->getPrintVolume() }}</p>
        <a href="{{ $manfService->getAddPrinterRoute($printer) }}" class="stretched-link"></a>
    </div>
</div>
@endforeach
@include("bootstrap.pagination", ["pagination" => $printersPagination])
@endsection