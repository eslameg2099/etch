@if($delegate->trashed())
    <a href="{{ route('dashboard.delegates.trashed.show', $delegate) }}"
       title="@lang('delegates.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@else
    <a href="{{ route('dashboard.delegates.show', $delegate) }}"
       title="@lang('delegates.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@endif