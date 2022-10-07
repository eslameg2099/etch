@if($order)
    @if($order->trashed())
        <a href="{{ route('dashboard.orders.trashed.show', $order) }}">
            {{ $order->name }}
        </a>
    @else
        <a href="{{ route('dashboard.orders.show', $order) }}">
            #{{ $order->id }}
        </a>
    @endif
@endif