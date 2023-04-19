@extends("layout")

@section("content")
<h1>{{ $printer->name }}</h1>
<p>{{ $printer->description }}</p>
<p>
    <a href="{{ $printer->getEditRoute() }}">@lang("model.printer.action.edit")</a>
</p>
<table class="table table-striped table-bordered table-hover">
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
@endsection