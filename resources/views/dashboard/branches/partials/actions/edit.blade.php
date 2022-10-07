@if(! $branch->trashed())
    <a href="{{ route('dashboard.branches.edit', $branch) }}"
       title="@lang('branches.actions.edit')"
       class="btn btn-icon btn-warning mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-edit"></i>
    </a>
@endif