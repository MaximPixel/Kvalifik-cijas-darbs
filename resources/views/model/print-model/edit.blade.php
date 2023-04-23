@extends("layout")

@section("content")
<form action="" method="POST" novalidate>
    @include("bootstrap.errors")
    @csrf
    <h3 class="mb-3">@lang("model.print-model.action.edit")</h3>
    <div class="mb-3">
        <label class="form-label" for="name">@lang("model.print-model.name")</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $printModel->name) }}" maxlength="255">
    </div>
    <div class="mb-3">
        <label class="form-label" for="scaleWidth">@lang("model.print-model.scale")</label>
        <table class="table">
            <tr>
                <th>@lang("model.print-model.length")</th>
                <td>
                    <input class="form-control" type="number" id="modelLengthInput" value="{{ $printModel->length }}">
                </td>
            </tr>
            <tr>
                <th>@lang("model.print-model.width")</th>
                <td>
                    <input class="form-control" type="number" id="modelWidthInput" value="{{ $printModel->width }}">
                </td>
            </tr>
            <tr>
                <th>@lang("model.print-model.height")</th>
                <td>
                    <input class="form-control" type="number" id="modelHeightInput" value="{{ $printModel->height }}">
                </td>
            </tr>
            <tr>
                <th>@lang("model.print-model.diameter")</th>
                <td>
                    <input class="form-control" type="number" id="modelDiameterInput" value="{{ $printModel->diameter }}" readonly>
                </td>
            </tr>
            <tr>
                <th>@lang("model.print-model.volume")</th>
                <td>
                    <input class="form-control" type="number" id="modelVolumeInput" value="{{ $printModel->volume }}" readonly>
                </td>
            </tr>
        </table>
        <input class="form-check-input" type="checkbox" id="applyOnAllAxes" checked>
        <label class="form-check-label" for="applyOnAllAxes">@lang("model.print-model.apply-on-all-axes")</label>
        <div class="input-group">
            <input type="number" class="form-control" name="scaleLength" id="scaleLength" step="0.1" value="{{ old('scaleLength', $printModel->scale_length) }}">
            <input type="number" class="form-control" name="scaleWidth" id="scaleWidth" step="0.1" value="{{ old('scaleWidth', $printModel->scale_width) }}">
            <input type="number" class="form-control" name="scaleHeight" id="scaleHeight" step="0.1" value="{{ old('scaleHeight', $printModel->scale_height) }}">
        </div>
    </div>
    <input type="submit" class="btn btn-primary" value="@lang('model.print-model.action.save')">
</form>
<script>
    function refreshModel() {
        console.log("refresh");
        let scaleLengthInput = document.getElementById("scaleLength");
        let scaleWidthInput = document.getElementById("scaleWidth");
        let scaleHeightInput = document.getElementById("scaleHeight");

        document.getElementById("modelLengthInput").value = ({{ $printModel->getOriginalLength() }} * scaleLengthInput.value).toFixed(2);
        document.getElementById("modelWidthInput").value = ({{ $printModel->getOriginalWidth() }} * scaleWidthInput.value).toFixed(2);
        document.getElementById("modelHeightInput").value = ({{ $printModel->getOriginalHeight() }} * scaleHeightInput.value).toFixed(2);
        document.getElementById("modelDiameterInput").value = ({{ $printModel->getOriginalDiameter() }} * Math.sqrt(scaleLengthInput.value * scaleWidthInput.value)).toFixed(2);
        document.getElementById("modelVolumeInput").value = ({{ $printModel->getOriginalVolume() }} * scaleLengthInput.value * scaleWidthInput.value * scaleHeightInput.value).toFixed(2);
    }

    let scaleInputIds = ["scaleLength", "scaleWidth", "scaleHeight"];

    function onScaleValueInput(value) {
        if (document.getElementById("applyOnAllAxes").checked) {
            scaleInputIds.forEach(id => {
                document.getElementById(id).value = value;
            });
        }

        refreshModel();
    }

    scaleInputIds.forEach(id => {
        let input = document.getElementById(id);
        input.addEventListener("input", event => {
            onScaleValueInput(event.target.value);
        });
    });

    document.getElementById("modelLengthInput").addEventListener("input", event => {
        let value = event.target.value / {{ $printModel->getOriginalLength() }};
        document.getElementById("scaleLength").value = value;
        onScaleValueInput(value);
    });

    document.getElementById("modelWidthInput").addEventListener("input", event => {
        let value = event.target.value / {{ $printModel->getOriginalWidth() }};
        document.getElementById("scaleWidth").value = value;
        onScaleValueInput(value);
    });

    document.getElementById("modelHeightInput").addEventListener("input", event => {
        let value = event.target.value / {{ $printModel->getOriginalHeight() }};
        document.getElementById("scaleHeight").value = value;
        onScaleValueInput(value);
    });
</script>
@endsection