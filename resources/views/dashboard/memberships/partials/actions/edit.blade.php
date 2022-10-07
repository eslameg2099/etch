@if(! $membership->trashed())
    <a href="{{ route('dashboard.memberships.edit', $membership) }}"
       title="@lang('memberships.actions.edit')"
       class="btn btn-icon btn-warning mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-edit"></i>
    </a>
@endif