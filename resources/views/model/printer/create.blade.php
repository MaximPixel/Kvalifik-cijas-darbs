@extends("layout")

@section("content")
<form action="" method="POST">
    @csrf
    <h3 class="mb-3">@lang("printer.action.create")</h3>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
    <div class="form-group">
        <label for="name">@lang("printer.name")</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
    </div>
    <div class="form-group">
        <label for="description">@lang("printer.description")</label>
        <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
    </div>
    <div class="form-group">
        <label for="manufacturer">@lang("printer.manufacturer")</label>
        <input type="text" class="form-control" id="manufacturer" name="manufacturer" value="{{ old('manufacturer') }}">
    </div>
    <input type="submit" class="btn btn-primary" value="@lang('printer.action.submit')">
</form>
@endsection