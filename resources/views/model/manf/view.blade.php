@php
    $canEdit = $manf->canEdit(request()->user());
@endphp

@extends("layout")

@section("content")
<h1>{{ $manf->name }}</h1>
<p>{{ $manf->description }}</p>

@if ($canEdit)
<p>
    <a class="btn btn-primary mb-3" href="{{ $manf->getActionRoute('edit') }}">@lang("model.manf.action.edit")</a>
</p>

@php
    $manfRoles = $manf->manfRoles()->take(5)->get();
@endphp

<div class="card mb-3">
    <div class="card-header">@lang("model.manf.roles")</div>
    <div class="card-body">
        <a class="btn btn-primary mb-3" href="{{ $manf->getActionRoute('roles-edit') }}">@lang("model.manf.action.edit-roles")</a>
        
        <div class="overflow-auto">
            <div class="d-inline-flex">
                @foreach ($manfRoles as $manfRole)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $manfRole->name }}</h5>
                        <p>{{ $manfRole->manfRoleUsers->pluck("user")->pluck("name")->join(", ") }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<div class="card mb-3">
    <div class="card-header">@lang("model.manf.services")</div>
    <div class="card-body">
    @if ($canEdit)
        <a class="btn btn-primary mb-3" href="{{ \App\Models\ManfService::getCreateRoute($manf) }}">@lang("model.manf.action.create-service")</a>
    @endif
        <ul class="list-group list-group-flush">
            @foreach ($manf->manfServices as $manfService)
            <li class="list-group-item">
                <a href="{{ $manfService->getRoute() }}">{{ $manfService->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@if ($canEdit)
<p>
    <a class="btn btn-danger" href="{{ $manf->getActionRoute('delete') }}">@lang("model.manf.action.delete")</a>
</p>
@endif
@endsection