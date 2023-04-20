@extends("layout")

@section("content")
<h1>{{ $user->name }}</h1>
<p>{{ $user->email }}</p>

@if ($user->canEdit(auth()->user()))
<p>
    <a class="btn btn-primary" href="{{ $user->getActionRoute('edit') }}">@lang("model.user.action.edit")</a>
</p>
<p>
    <a class="btn btn-danger" href="{{ $user->getActionRoute('delete') }}">@lang("model.user.action.delete")</a>
</p>
@endif
@endsection