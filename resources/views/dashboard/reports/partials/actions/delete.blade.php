<a href="#report-{{ $report->id }}-delete-model"
   title="@lang('reports.actions.delete')"
   class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"
   data-toggle="modal">
    <i class="feather icon-trash"></i>
</a>


<!-- Modal -->
<div class="modal fade" id="report-{{ $report->id }}-delete-model" tabindex="-1" role="dialog"
     aria-labelledby="modal-title-{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="modal-title-{{ $report->id }}">@lang('reports.dialogs.delete.title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @lang('reports.dialogs.delete.info')
            </div>
            <div class="modal-footer">
                {{ BsForm::delete(route('dashboard.reports.destroy', $report)) }}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    @lang('reports.dialogs.delete.cancel')
                </button>
                <button type="submit" class="btn btn-danger">
                    @lang('reports.dialogs.delete.confirm')
                </button>
                {{ BsForm::close() }}
            </div>
        </div>
    </div>
</div>
