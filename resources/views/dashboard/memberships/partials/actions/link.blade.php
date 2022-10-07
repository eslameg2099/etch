@if($membership)
    @if($membership->trashed())
        <a href="{{ route('dashboard.memberships.trashed.show', $membership) }}">
            {{ $membership->name }}
        </a>
    @else
        <a href="{{ route('dashboard.memberships.show', $membership) }}">
            {{ $membership->name }}
        </a>
    @endif
@else
    ---
@endif