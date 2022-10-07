@if(! $city->trashed())
    <a href="{{ route('dashboard.cities.edit', $city) }}"
       title="@lang('cities.actions.edit')"
       class="btn btn-icon btn-warning mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-edit"></i>
    </a>
@endif