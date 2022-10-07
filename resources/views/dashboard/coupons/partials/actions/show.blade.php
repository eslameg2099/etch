@if($coupon->trashed())
    <a href="{{ route('dashboard.coupons.trashed.show', $coupon) }}"
       title="@lang('coupons.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@else
    <a href="{{ route('dashboard.coupons.show', $coupon) }}"
       title="@lang('coupons.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@endif