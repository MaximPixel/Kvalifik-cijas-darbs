@php
$printMaterialColors = $manfService->manfServicePrintMaterialColors->pluck("printMaterialColor");
$printMaterials = $printMaterialColors->pluck("printMaterial")->unique("id");
@endphp

@extends("layout")

@section("content")
@if (auth()->user()->userAddressesVisible->isEmpty())
<p>@lang("model.user-address.missing")</p>
<p>
    <a class="btn btn-primary" href="{{ \App\Models\UserAddress::getCreateRoute(['redirect' => url()->full()]) }}">@lang("model.order.action.create-address")</a>
</p>
@else
<form action="" method="POST">
    @csrf
    <h3 class="mb-3">@lang("model.order.action.create")</h3>
    @include("bootstrap.errors")

    <div class="mb-3">
        <label for="address">@lang("model.order.address")</label>
        <select class="form-select" name="address" id="address">
        @foreach (\App\Models\UserAddress::all() as $userAddress)
            <option value="{{ $userAddress->getCode() }}">{{ $userAddress->address_street }}</option>
        @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="model">@lang("model.order.model")</label>
        <select class="form-select" name="model" id="model" value="{{ old('model', 1) }}">
        @foreach (\App\Models\PrintModel::all() as $model)
            <option value="{{ $model->getCode() }}">{{ $model->name }}</option>
        @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="material_color">@lang("model.order.material_color")</label>
        <select class="form-select" name="material_color" id="material_color" value="{{ old('material_color', 1) }}">
        @foreach ($printMaterials as $printMaterial)
            <optgroup label="{{ $printMaterial->name }}">
            @foreach ($printMaterialColors->where("print_material_id", $printMaterial->id) as $printMaterialColor)
                <option value="{{ $printMaterialColor->getCode() }}" style="color: #{{ $printMaterialColor->hex }}">{{ $printMaterialColor->name }}</option>
            @endforeach
            </optgroup>
        @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="amount">@lang("model.order.amount")</label>
        <input class="form-control" type="number" name="amount" id="amount" value="{{ old('amount', 1) }}">
    </div>

    <div class="mb-3">
        <label for="comment">@lang("model.order.comment")</label>
        <textarea class="form-control" name="comment" id="" cols="30" rows="10"></textarea>
    </div>

    <input class="btn btn-primary" type="submit" value="@lang('model.order.action.create')">
</form>
@endif
@endsection