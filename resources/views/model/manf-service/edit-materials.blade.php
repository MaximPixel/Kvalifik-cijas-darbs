@extends("layout")

@section("content")
<form action="" method="POST">
    @csrf
    <ul>
    @foreach ($printMaterials as $printMaterial)
        <li>{{ $printMaterial->name }}</li>
        <ul>
        @foreach ($printMaterial->printMaterialColors as $printMaterialColor)
            <li>
                <input
                    class="form-check-input"
                    type="checkbox"
                    id="{{ $printMaterialColor->getCode() }}"
                    name="materialColors[{{ $printMaterialColor->getCode() }}]"
                @if ($manfService->manfServicePrintMaterialColors->contains("print_material_color_id", $printMaterialColor->id)) checked @endif
                >
                <label for="{{ $printMaterialColor->getCode() }}">{{ $printMaterialColor->name }}</label>
            </li>
        @endforeach
        </ul>
    @endforeach
    </ul>
    <input class="btn btn-primary" type="submit" value="@lang('model.manf-service.action.edit-materials-submit')">
</form>
@endsection