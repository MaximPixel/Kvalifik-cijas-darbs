@extends("layout")

@section("content")
<form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="model-file">@lang("model.print-model.model-file")</label>
        <input class="form-control" type="file" name="model-file" id="model-file">
    </div>
    <div class="form-group">
        <label for="name">@lang("model.print-model.name")</label>
        <input class="form-control" type="text" name="name" id="name">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="create">
    </div>
</form>
@endsection