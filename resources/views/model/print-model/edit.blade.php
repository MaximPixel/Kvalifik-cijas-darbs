@extends("layout")

@section("content")
<form action="" method="POST">
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
                <td id="modelLength" original="{{ $printModel->length / $printModel->scale_length }}">{{ $printModel->length }}</td>
            </tr>
            <tr>
                <th>@lang("model.print-model.width")</th>
                <td id="modelWidth" original="{{ $printModel->width / $printModel->scale_width }}">{{ $printModel->width }}</td>
            </tr>
            <tr>
                <th>@lang("model.print-model.height")</th>
                <td id="modelHeight" original="{{ $printModel->height / $printModel->scale_height }}">{{ $printModel->height }}</td>
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
    let a = [
        ["scaleLength", "modelLength"],
        ["scaleWidth", "modelWidth"],
        ["scaleHeight", "modelHeight"],
    ];

    let applyOnAllAxesCheckbox = document.getElementById("applyOnAllAxes");

    for (let i in a) {
        let input = document.getElementById(a[i][0]);

        input.addEventListener("change", function() {
            let tableData = document.getElementById(a[i][1]);
            tableData.innerText = tableData.getAttribute("original") * input.value;

            for (let j in a) {
                let tableData = document.getElementById(a[j][1]);

                if (applyOnAllAxesCheckbox.checked || i == j) {
                    document.getElementById(a[j][0]).value = input.value;
                    tableData.innerText = tableData.getAttribute("original") * input.value;
                }
            }
        });
    }
</script>
@endsection