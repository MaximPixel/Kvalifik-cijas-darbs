@php
    $featType = $field["featType"];
    $featValue = ($field["featValues"] ?? collect())->first();

    $featValueInputKey = $key . "[value]";
    $featValueUnitInputKey = $key . "[unit]";

    $units = collect();

    if ($featType->measure_type == "length" || $featType->measure_type == "diameter" || $featType->measure_type == "accuracy") {
        $units = collect(["mm", "cm", "m"]);
    } else if ($featType->measure_type == "temperature") {
        $units = collect(["°C"]);
    }
@endphp
<div class="input-group">
    <input
        class="form-control"
        type="text"
        name="{{ $featValueInputKey }}"
        id="{{ $featValueInputKey }}"
        value="{{ old($featValueInputKey, $featValue->name ?? null) }}"
    >
@if ($units->isNotEmpty())
    <select class="form-select" name="{{ $featValueUnitInputKey }}" id="{{ $featValueUnitInputKey }}">
    @foreach ($units as $unit)
        <option
            value="{{ $unit }}"
        @if (old($featValueUnitInputKey, $featValue->unit ?? null) == $unit)
            selected
        @endif
        >{{ $unit }}</option>
    @endforeach
    </select>
@endif
</div>