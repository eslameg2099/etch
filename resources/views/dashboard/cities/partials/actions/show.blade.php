@if($city->trashed())
    <a href="{{ route('dashboard.cities.trashed.show', $city) }}"
       title="@lang('cities.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@else
    <a href="{{ route('dashboard.cities.show', $city) }}"
       title="@lang('cities.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@endif