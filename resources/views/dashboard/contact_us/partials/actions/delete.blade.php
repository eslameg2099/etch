<a href="#message-{{ $message->id }}-delete-model"
   title="@lang('contact_us.actions.delete')"
   class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"
   data-toggle="modal">
    <i class="feather icon-trash"></i>
</a>


<!-- Modal -->
<div class="modal fade" id="message-{{ $message->id }}-delete-model" tabindex="-1" role="dialog"
     aria-labelledby="modal-title-{{ $message->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="modal-title-{{ $message->id }}">@lang('contact_us.dialogs.delete.title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @lang('contact_us.dialogs.delete.info')
            </div>
            <div class="modal-footer">
                {{ BsForm::delete(route('dashboard.contact_us.destroy', $message)) }}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    @lang('contact_us.dialogs.delete.cancel')
                </button>
                <button type="submit" class="btn btn-danger">
                    @lang('contact_us.dialogs.delete.confirm')
                </button>
                {{ BsForm::close() }}
            </div>
        </div>
    </div>
</div>
