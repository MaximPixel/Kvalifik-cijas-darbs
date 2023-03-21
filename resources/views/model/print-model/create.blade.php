@extends("layout")

@section("content")
<form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <input type="file" name="modelFile" id="modelFile">
    </div>
    <div class="form-group">
        <input type="text" name="name" id="name">
    </div>
    <input type="submit" value="create">
</form>
@endsection