@if($membership->isNot(auth()->user()))
    @if(! $membership->trashed())
        <a href="#membership-{{ $membership->id }}-delete-model"
           title="@lang('memberships.actions.delete')"
           class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"
           data-toggle="modal">
            <i class="feather icon-trash"></i>
        </a>


        <!-- Modal -->
        <div class="modal fade" id="membership-{{ $membership->id }}-delete-model" tabindex="-1" role="dialog"
             aria-labelledby="modal-title-{{ $membership->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modal-title-{{ $membership->id }}">@lang('memberships.dialogs.delete.title')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('memberships.dialogs.delete.info')
                    </div>
                    <div class="modal-footer">
                        {{ BsForm::delete(route('dashboard.memberships.destroy', $membership)) }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            @lang('memberships.dialogs.delete.cancel')
                        </button>
                        <button type="submit" class="btn btn-danger">
                            @lang('memberships.dialogs.delete.confirm')
                        </button>
                        {{ BsForm::close() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <a href="{{ route('dashboard.memberships.restore', $membership) }}"
           title="@lang('memberships.actions.restore')"
           class="btn btn-icon btn-primary mr-1 mb-1 waves-effect waves-light">
            <i class="fas fa-trash-restore"></i>
        </a>
    @endif
@endif
