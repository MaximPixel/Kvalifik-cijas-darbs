<input
    type="{{ $type }}"
    class="form-control"
    id="{{ $key }}"
    name="{{ $key }}"
    value="{{ old($key, $field['value'] ?? null) }}"
@if ($min !== null)
    minlength="{{ $min }}"
@endif
@if ($max !== null)
    maxlength="{{ $max }}"
@endif
>