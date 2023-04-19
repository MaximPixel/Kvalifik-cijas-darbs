@php
    $manfServices = \App\Models\ManfService::all();
@endphp

@extends("layout")

@section("content")
<div class="card">
    <div class="card-header">
        Services
    </div>
    <div class="card-body">
        <ul class="list-group list-group-horizontal">
        @foreach ($manfServices as $manfService)
            <li class="list-group-item">
                <p>
                    <a href="{{ $manfService->getRoute() }}">{{ $manfService->name }}</a>
                </p>
            </li>
        @endforeach
        </ul>
    </div>
</div>
@endsection