<button class="btn btn-danger btn-sm"
        data-checkbox=".item-checkbox"
        data-form="confirm-selected-form"
        data-toggle="modal"
        data-target="#confirm-selected-model">
    <i class="fas fa-trash"></i>
    @lang('check-all.actions.confirm')
</button>

<!-- Modal -->
<div class="modal fade" id="confirm-selected-model" tabindex="-1" role="dialog"
     aria-labelledby="selected-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selected-modal-title">
                    @lang('check-all.dialogs.confirm.title')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-danger">
                @lang('check-all.dialogs.confirm.info', ['type' => $resource ?? ''])
                <form action="{{ route('dashboard.confirm.selected') }}"
                      id="confirm-selected-form"
                      method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="type" value="{{ $type ?? '' }}">
                    <input type="hidden" name="resource" value="{{ $resource ?? '' }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    @lang('check-all.dialogs.confirm.cancel')
                </button>
                <button type="submit" class="btn btn-danger btn-sm" form="confirm-selected-form">
                    @lang('check-all.dialogs.confirm.confirm')
                </button>
            </div>
        </div>
    </div>
</div>