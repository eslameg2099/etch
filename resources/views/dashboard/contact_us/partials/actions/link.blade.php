@if($message)
    @if($message->trashed())
        <a href="{{ route('dashboard.contact_us.trashed.show', $message) }}">
            {{ $message->name }}
        </a>
    @else
        <a href="{{ route('dashboard.contact_us.show', $message) }}">
            {{ $message->name }}
        </a>
    @endif
@else
    ---
@endif