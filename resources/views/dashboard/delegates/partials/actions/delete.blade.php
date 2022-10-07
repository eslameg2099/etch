@if(! $delegate->trashed())
    <a href="#delegate-{{ $delegate->id }}-delete-model"
       title="@lang('delegates.actions.delete')"
       class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"
       data-toggle="modal">
        <i class="feather icon-trash"></i>
    </a>


    <!-- Modal -->
    <div class="modal fade" id="delegate-{{ $delegate->id }}-delete-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $delegate->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modal-title-{{ $delegate->id }}">@lang('delegates.dialogs.delete.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('delegates.dialogs.delete.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.delegates.destroy', $delegate)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('delegates.dialogs.delete.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('delegates.dialogs.delete.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@else
    <a href="{{ route('dashboard.delegates.restore', $delegate) }}"
       title="@lang('delegates.actions.restore')"
       class="btn btn-icon btn-primary mr-1 mb-1 waves-effect waves-light">
        <i class="fas fa-trash-restore"></i>
    </a>
@endif
