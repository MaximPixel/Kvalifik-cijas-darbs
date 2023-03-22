@extends("layout")

@section("content")
<h1>{{ $manf->name }}</h1>
<p>{{ $manf->description }}</p>

<p>services</p>
<p>
    <a href="{{ \App\Models\ManfService::getCreateRoute($manf) }}">create</a>
</p>
@foreach ($manf->manfServices as $manfService)
<p>
    <a href="{{ $manfService->getRoute() }}">{{ $manfService->name }}</a>
</p>
@endforeach

<p>
    <a href="{{ $manf->getActionRoute('delete') }}">@lang("model.manf.action.delete")</a>
</p>
@endsection