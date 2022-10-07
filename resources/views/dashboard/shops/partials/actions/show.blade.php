@if($shop->trashed())
    <a href="{{ route('dashboard.shops.trashed.show', $shop) }}"
       title="@lang('shops.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@else
    <a href="{{ route('dashboard.shops.show', $shop) }}"
       title="@lang('shops.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@endif