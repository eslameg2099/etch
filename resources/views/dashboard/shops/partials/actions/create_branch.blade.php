@if(! $shop->trashed())
    <a href="{{ route('dashboard.branches.createBranchShop', $shop) }}"
       title="@lang('shops.actions.edit')"
       class="btn btn-icon btn-primary mr-1 mb-1 waves-effect waves-light">
        {{__("إضافة فرع")}}
        <i class="fas fa-plus"></i>
    </a>
@endif