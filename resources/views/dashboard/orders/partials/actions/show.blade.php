@if($order->trashed())
    <a href="{{ route('dashboard.orders.trashed.show', $order) }}"
       title="@lang('orders.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@else
    <a href="{{ route('dashboard.orders.show', $order) }}"
       title="@lang('orders.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@endif