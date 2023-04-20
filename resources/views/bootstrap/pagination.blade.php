@php
    $current = $pagination->currentPage();
    $last = $pagination->lastPage();

    if ($last > 6) {
        $from = max(1, $current - 1);
        $to = min($last, $from + 2);
        if ($to - $from < 2) $from = max(1, $to - 2);
    } else {
        $from = 1;
        $to = $last;
    }
@endphp

<ul class="pagination">
<li class="page-item @if($current == 1) disabled @endif">
    <a class="page-link" href="{{ $pagination->previousPageUrl() }}">@lang("pagination.previous")</a>
</li>
@if ($from > 1)
    <li class="page-item @if($current == 1) active @endif">
        <a class="page-link" href="{{ $pagination->url(1) }}">1</a>
    </li>
@endif

@if ($from > 2)
    <li class="page-item disabled">
        <span class="page-link">&hellip;</span>
    </li>
@endif

@for ($i = $from; $i <= $to; $i++)
    <li class="page-item @if($current == $i) active @endif">
        <a class="page-link " href="{{ $pagination->url($i) }}">{{ $i }}</a>
        </li>
@endfor

@if ($to < $last - 1)
    <li class="page-item disabled">
        <span class="page-link">&hellip;</span>
    </li>
@endif

@if ($to < $last)
    <li class="page-item @if($current == $last) active @endif">
        <a class="page-link" href="{{ $pagination->url($last) }}">{{ $last }}</a>
    </li>
@endif

    <li class="page-item @if($current == $last) disabled @endif">
        <a class="page-link" href="{{ $pagination->nextPageUrl() }}">@lang("pagination.next")</a>
    </li>
</ul>