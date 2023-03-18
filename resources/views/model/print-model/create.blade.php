@extends("layout")

@section("content")
<form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="modelFile" id="modelFile">
    <input type="submit" value="s">
</form>
@endsection