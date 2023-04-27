@extends("layout")

@section("content")
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex position-relative">
            <img class="me-3" style="width: 200px" src="{{ $user->getImageUrl() }}">
            <div>
                <h5>{{ $user->name }}</h5>
                <p>{{ $user->email }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
    @if ($user->canEdit(request()->user()))
        <p>
            <a class="btn btn-primary" href="{{ $user->getActionRoute('edit') }}">@lang("model.user.action.edit")</a>
        </p>
        <p>
            <a class="btn btn-danger" href="{{ $user->getActionRoute('delete') }}">@lang("model.user.action.delete")</a>
        </p>
    @endif
    </div>
</div>

@if (request()->user() && request()->user()->id == $user->id)
<div class="card mb-3">
    <div class="card-body">
        <p>
            <a class="btn btn-primary" href="{{ \App\Models\Manf::getCreateRoute() }}">@lang("model.user.action.create-manf")</a>
        </p>
    </div>
</div>
@endif
@endsection