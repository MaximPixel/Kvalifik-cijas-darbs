@php
    $enctype = $enctype ?? null;
@endphp
<form
    action=""
    method="POST"
@if ($enctype !== null)
    enctype="{{ $enctype }}"
@endif
>
    @csrf
    <h3 class="mb-3">{{ $title }}</h3>
    @include("bootstrap.errors")
@foreach ($fields as $key => $field)
<div class="mb-3">
    @include("bootstrap.field", ["field" => $field])
</div>
@endforeach
    <input type="submit" class="btn btn-primary" value="{{ $submit }}">
</form>