@extends("layout")

@section("content")
<form action="" method="POST">
    @csrf
    <select name="printer" id="printer">
    @foreach ($printers as $printer)
        <option value="{{ $printer->getCode() }}">{{ $printer->name }}</option>
    @endforeach
    </select>
    <input type="submit" value="add">
</form>
@endsection