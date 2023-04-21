@extends("layout")

@section("content")
<div class="d-flex position-relative">
    <img style="width: 200px" src="{{ $printer->getImageUrl() }}">
    <div>
        <h5 class="mt-0">{{ $printer->name }}</h5>
        <p>{{ $printer->description }}</p>
    @if ($printer->canEdit(request()->user()))
        <p>
            <a class="btn btn-primary" href="{{ $printer->getEditRoute() }}">@lang("model.printer.action.edit")</a>
        </p>
    @endif
    </div>
</div>
<hr>
<div class="card">
    <div class="card-header">@lang("model.printer.feats")</div>
    <div class="card-body">
        <table class="table table-hover">
            <thead></thead>
            <tbody>
        @foreach ($printer->getDefinedFeatTypes() as $printerFeatType)
            <tr>
                <th>{{ $printerFeatType->getDisplayName() }}</th>
                <td>{{ $printer->getPrinterFeatValues($printerFeatType)->map(fn ($a) => $a->getDisplayName())->join(", ") }}</td>
            </tr>
        @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection