@extends("layout")

@section("content")
@if (auth()->user()->userAddressesVisible->isEmpty())
<p>You don't have any addresses. Create?</p>
<p>
    <a href="{{ \App\Models\UserAddress::getCreateRoute(['redirect' => url()->full()]) }}">create</a>
</p>
@else
<form action="" method="POST">
    @csrf
    <h3 class="mb-3">@lang("model.order.create")</h3>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
    <div class="form-group">
        <label for="address">@lang("model.order.address")</label>
        <select class="form-select" name="address" id="address">
        @foreach (\App\Models\UserAddress::all() as $userAddress)
            <option value="{{ $userAddress->getCode() }}">{{ $userAddress->address_street }}</option>
        @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="model">@lang("model.order.model")</label>
        <select class="form-select" name="model" id="model" value="{{ old('model', 1) }}">
        @foreach (\App\Models\PrintModel::all() as $model)
            <option value="{{ $model->getCode() }}">{{ $model->name }}</option>
        @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="material_color">@lang("model.order.material_color")</label>
        <select class="form-select" name="material_color" id="material_color" value="{{ old('material_color', 1) }}">
        @php
            $printMaterialColors = $manfService->manfServicePrintMaterialColors->pluck("printMaterialColor");
            $printMaterials = $printMaterialColors->pluck("printMaterial")->unique("id");
        @endphp
        @foreach ($printMaterials as $printMaterial)
            <optgroup label="{{ $printMaterial->name }}">
            @foreach ($printMaterialColors->where("print_material_id", $printMaterial->id) as $printMaterialColor)
                <option value="{{ $printMaterialColor->getCode() }}" style="color: #{{ $printMaterialColor->hex }}">{{ $printMaterialColor->name }}</option>
            @endforeach
            </optgroup>
        @endforeach
        </select>
    </div>
        <label for="amount">@lang("model.order.amount")</label>
        <input class="form-control" type="number" name="amount" id="amount" value="{{ old('amount', 1) }}">
    </div>
    <div class="form-group">
        <label for="comment">@lang("model.order.comment")</label>
        <textarea class="form-control" name="comment" id="" cols="30" rows="10"></textarea>
    </div>
    <input type="submit" value="@lang('model.order.action.create')">
</form>
@endif
@endsection