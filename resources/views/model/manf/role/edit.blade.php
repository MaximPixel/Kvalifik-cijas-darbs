@extends("layout")

@section("content")
<h1>{{ $manfRole->name }}</h1>

<p>
    <a href="{{ $manfRole->getActionRoute('delete', ['redirect' => $manfRole->manf->getRoute() ]) }}" class="btn btn-danger">@lang("model.manf.role.action.delete")</a>
</p>

<ul>
@foreach ($manfRole->manfRoleUsers as $manfRoleUser)
    <li>{{ $manfRoleUser->user->name }} ({{ $manfRoleUser->user->email }}) <a href="{{ $manfRole->getActionRoute('remove-user', ['user' => $manfRoleUser->user->getCode(), 'redirect' => url()->full()]) }}">@lang("model.manf.role.action.remove-user")</a></li>
@endforeach
</ul>

<div class="card">
    <div class="card-body">
        @include("bootstrap.errors")
        <form action="{{ $manfRole->getActionRoute('add-user', ['redirect' => url()->full()]) }}" method="POST">
            <label class="form-label">@lang("model.manf.role.action.add-user")</label>
            @csrf
            <div class="mb-3">
                <label for="userEmail">@lang("model.manf.role.user-email")</label>
                <input type="email" name="userEmail" id="userEmail">
            </div>
            <input class="btn btn-primary" type="submit" value="@lang('model.manf.role.action.add-user-submit')">
        </form>
    </div>
</div>
@endsection