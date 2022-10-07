@if($coupon)
    @if($coupon->trashed())
        <a href="{{ route('dashboard.coupons.trashed.show', $coupon) }}">
            {{ $coupon->name }}
        </a>
    @else
        <a href="{{ route('dashboard.coupons.show', $coupon) }}">
            {{ $coupon->name }}
        </a>
    @endif
@else
    ---
@endif