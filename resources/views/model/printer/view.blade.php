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
    @foreach ($printer->printerFeats as $index => $printerFeat)
        <tr>
            <th>{{ $printerFeat->printerFeatValue->printerFeatType->name }}</th>
            <td>{{ $printerFeat->printerFeatValue->name }} {{ $printerFeat->printerFeatValue->unit}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection