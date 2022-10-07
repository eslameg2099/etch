@if($user)
    @if($user->trashed())
        <a href="{{ route('dashboard.users.trashed.show', $user) }}">
            {{ $user->name }}
        </a>
    @else
        <a href="{{ route('dashboard.users.show', $user) }}">
            {{ $user->name }}
        </a>
    @endif
@else
    ---
@endif