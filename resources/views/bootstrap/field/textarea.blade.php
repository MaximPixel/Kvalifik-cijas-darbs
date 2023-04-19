@php
    $cols = $field["cols"] ?? 30;
    $rows = $field["rows"] ?? 15;
@endphp
<textarea
    class="form-control"
    name="description"
    id="description"
    cols="{{ $cols }}"
    rows="{{ $rows }}"
@if ($min !== null)
    minlength="{{ $min }}"
@endif
@if ($max !== null)
    maxlength="{{ $max }}"
@endif
>{{ old($key, $field["value"] ?? null) }}</textarea>