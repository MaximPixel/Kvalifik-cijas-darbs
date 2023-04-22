@php
    $type = $field["type"] ?? "text";
    $label = $field["label"] ?? null;
    $min = $field["min"] ?? null;
    $max = $field["max"] ?? null;
@endphp
@if ($label)
@if ($type == "featValue")
    <label class="form-label" for="{{ $key }}Value">@lang("model.printer.feat-type.$label") ({{ $field["featType"]->measure_type }})</label>
@else
    <label class="form-label" for="{{ $key }}">{{ $label }}</label>
@endif
@endif
@if ($type == "select")
    <select class="form-select" name="{{ $key }}" id="{{ $key }}">
    @foreach ($field["values"] as $selectValue)
        <option
            value="{{ $selectValue['value'] }}"
        @if (old($key, $field["value"] ?? null) == $selectValue['value'])
            selected
        @endif
        >{{ $selectValue["label"] }}</option>
    @endforeach
    </select>
@elseif ($type == "featValue")
    @include("bootstrap.field.feat-value")
@elseif ($type == "textarea")
    @include("bootstrap.field.textarea")
@else
    @include("bootstrap.field.input")
@endif