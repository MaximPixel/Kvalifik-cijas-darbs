@php
    $type = $field["type"] ?? "text";
    $label = $field["label"] ?? null;
    $min = $field["min"] ?? null;
    $max = $field["max"] ?? null;
@endphp
@if ($label)
@if ($type == "featValue")
    <label for="{{ $key }}Value">@lang("model.printer.feat-type.$label") ({{ $field["featType"]->measure_type }})</label>
@else
    <label for="{{ $key }}">{{ $label }}</label>
@endif
@endif
@if ($type == "featValue")
    @include("bootstrap.field.feat-value")
@elseif ($type == "textarea")
    @include("bootstrap.field.textarea")
@else
    @include("bootstrap.field.input")
@endif