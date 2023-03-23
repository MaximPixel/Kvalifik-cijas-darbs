@extends("layout")

@section("content")
<form action="" method="POST">
    @csrf

    <div class="mb-3">
        <select class="form-select" name="printer" id="printer">
        @foreach ($printers as $printer)
            <option value="{{ $printer->getCode() }}">{{ $printer->name }}</option>
        @endforeach
        </select>
    </div>

    <input class="btn btn-primary" type="submit" value="add">
</form>
@endsection