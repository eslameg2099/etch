<a href="#notification-{{ $adminNotification->id }}-delete-model"
   title="@lang('notifications.actions.enable')"
   class="btn btn-icon btn-success mr-1 mb-1 waves-effect waves-light"
   data-toggle="modal">
    <i class="feather icon-eye"></i>
</a>


<!-- Modal -->
<div class="modal fade" id="notification-{{ $adminNotification->id }}-delete-model" tabindex="-1" role="dialog"
     aria-labelledby="modal-title-{{ $adminNotification->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="modal-title-{{ $adminNotification->id }}">@lang('notifications.dialogs.enable.title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @lang('notifications.dialogs.enable.body')
            </div>
            <div class="modal-footer">
                {{ BsForm::put(route('dashboard.adminNotifications.active', $adminNotification)) }}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    @lang('notifications.dialogs.enable.cancel')
                </button>
                <button type="submit" class="btn btn-danger">
                    @lang('notifications.dialogs.enable.confirm')
                </button>
                {{ BsForm::close() }}
            </div>
        </div>
    </div>
</div>
