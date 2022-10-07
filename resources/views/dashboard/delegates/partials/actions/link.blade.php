@if($delegate->trashed())
    <a href="{{ route('dashboard.delegates.trashed.show', $delegate) }}">
        {{ $delegate->name }}
    </a>
@else
    <a href="{{ route('dashboard.delegates.show', $delegate) }}">
        {{ $delegate->name }}
    </a>
@endif