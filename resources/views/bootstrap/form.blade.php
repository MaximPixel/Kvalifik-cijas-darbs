@php
    $enctype = $enctype ?? null;

    $fieldGroups = collect();

    foreach ($fields as $key => $value) {
        if (!isset($value["label"])) {
            $fieldGroups->push([
                "title" => $key,
                "fields" => $value,
                "errors" => $value["_errors"] ?? null,
            ]);
        } else {
            $fieldGroups->push([
                "title" => $title,
                "fields" => collect($fields)->forget("_errors"),
                "errors" => $value["_errors"] ?? null,
            ]);
            break;
        }
    }
@endphp
<form
    action=""
    method="POST"
@if ($enctype !== null)
    enctype="{{ $enctype }}"
@endif
>
    @csrf
@foreach ($fieldGroups as $fieldGroup)
    <h3 class="mb-3">{{ $fieldGroup["title"] }}</h3>
    @include("bootstrap.errors")
    @include("bootstrap.errors", ["errors" => $fieldGroup["errors"] ?? new \Illuminate\Support\ViewErrorBag])
@foreach (collect($fieldGroup["fields"])->forget("_errors") as $key => $field)
    <div class="mb-3">
        @include("bootstrap.field", ["field" => $field])
    </div>
@endforeach
@endforeach
    <input type="submit" class="btn btn-primary" value="{{ $submit }}">
</form>