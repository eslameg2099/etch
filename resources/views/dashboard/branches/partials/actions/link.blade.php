@if($shop)
    @if($shop->trashed())
        <a href="{{ route('dashboard.shops.trashed.show', $shop) }}">
            {{ $shop->name }}
        </a>
    @else
        <a href="{{ route('dashboard.shops.show', $shop) }}">
            {{ $shop->name }}
        </a>
    @endif
@else
    ---
@endif