@extends("layout")

@section("content")
<h1>"{{ $manf->name }}" @lang("model.manf.roles")</h1>

@php
    $pagination = $manf->manfRoles()->paginate(5)->withQueryString();
@endphp

<ul class="list-unstyled">
    @foreach ($pagination->items() as $manfRole)
    <li class="media">
        <div class="media-body">
            <h5 class="mt-0">{{ $manfRole->name }}</h5>
            <p>
                <a href="{{ $manfRole->getActionRoute('edit') }}" class="btn btn-primary">@lang("model.manf.role.action.edit")</a>
            </p>
            <p>{{ $manfRole->manfRoleUsers->pluck("user")->pluck("name")->join(", ") }}</p>
        </div>
    </li>
    @endforeach
</ul>
@include("bootstrap.pagination")
@endsection