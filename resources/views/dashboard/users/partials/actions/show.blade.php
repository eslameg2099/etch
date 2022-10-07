@if($user->trashed())
    <a href="{{ route('dashboard.users.trashed.show', $user) }}"
       title="@lang('users.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@else
    <a href="{{ route('dashboard.users.show', $user) }}"
       title="@lang('users.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@endif