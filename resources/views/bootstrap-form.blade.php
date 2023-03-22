<form action="" method="POST">
    @csrf
    <h3 class="mb-3">{{ $title }}</h3>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
@foreach ($fields as $key => $field)
@php
    $type = $field["type"] ?? "text";
    $label = $field["label"] ?? null;
    $min = $field["min"] ?? null;
    $max = $field["max"] ?? null;
@endphp
<div class="form-group">
@if ($label)
@if ($type == "featValue")
    <label for="{{ $key }}">{{ $label }} ({{ $field["featType"]->measure_type }})</label>
@else
    <label for="{{ $key }}">{{ $label }}</label>
@endif
@endif
@if ($type == "featValue")
@php
    $featType = $field["featType"];
@endphp
@if ($featType->measure_type == "length" || $featType->measure_type == "diameter" || $featType->measure_type == "accuracy")
    <div class="input-group">
        <input
            class="form-control"
            type="text"
            name="{{ $key }}Value"
            id="{{ $key }}Value"
        >
        <select class="form-select" name="{{ $key }}Unit" id="{{ $key }}Unit">
            <option value="mm">mm</option>
            <option value="cm">cm</option>
            <option value="m">m</option>
        </select>
    </div>
@elseif ($featType->measure_type == "temperature")
    <div class="input-group">
        <input
            class="form-control"
            type="text"
            name="{{ $key }}Value"
            id="{{ $key }}Value"
        >
        <select class="form-select" name="{{ $key }}Unit" id="{{ $key }}Unit">
            <option value="°C">°C</option>
            <option value="°F">°F</option>
            <option value="°K">°K</option>
        </select>
    </div>
@endif
@elseif ($type == "textarea")
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
    >{{ old($key) }}</textarea>
@else
    <input
        type="{{ $type }}"
        class="form-control"
        id="{{ $key }}"
        name="{{ $key }}"
        value="{{ old($key, $field["value"] ?? null) }}"
    @if ($min !== null)
        minlength="{{ $min }}"
    @endif
    @if ($max !== null)
        maxlength="{{ $max }}"
    @endif
    >
@endif
</div>
@endforeach
    <input type="submit" class="btn btn-primary" value="{{ $submit }}">
</form>