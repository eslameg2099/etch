@if(! $user->trashed())
    <a href="#user-{{ $user->id }}-delete-model"
       title="@lang('users.actions.delete')"
       class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"
       data-toggle="modal">
        <i class="feather icon-trash"></i>
    </a>


    <!-- Modal -->
    <div class="modal fade" id="user-{{ $user->id }}-delete-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modal-title-{{ $user->id }}">@lang('users.dialogs.delete.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('users.dialogs.delete.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.users.destroy', $user)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('users.dialogs.delete.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('users.dialogs.delete.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@else
    <a href="{{ route('dashboard.users.restore', $user) }}"
       title="@lang('users.actions.restore')"
       class="btn btn-icon btn-primary mr-1 mb-1 waves-effect waves-light">
        <i class="fas fa-trash-restore"></i>
    </a>
@endif
