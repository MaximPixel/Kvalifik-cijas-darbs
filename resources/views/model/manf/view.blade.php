@php
    $canEdit = $manf->canEdit(auth()->user());
@endphp

@extends("layout")

@section("content")
<h1>{{ $manf->name }}</h1>
<p>{{ $manf->description }}</p>

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