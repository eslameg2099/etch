@if($membership->trashed())
    <a href="{{ route('dashboard.memberships.trashed.show', $membership) }}"
       title="@lang('memberships.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@else
    <a href="{{ route('dashboard.memberships.show', $membership) }}"
       title="@lang('memberships.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@endif