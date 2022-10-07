<a href="#report-{{ $report->id }}-status-model"
   class="btn btn-icon btn-black mr-1 mb-1 waves-effect waves-light"
   data-toggle="modal">
    <i class="feather icon-edit"></i>
</a>


<!-- Modal -->
<div class="modal fade" id="report-{{ $report->id }}-status-model" tabindex="-1" role="dialog"
     aria-labelledby="modal-title-{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="modal-title-{{ $report->id }}">@lang('reports.dialogs.status.title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ BsForm::select('status')->attribute('form', "report-{$report->id}-status-form")->options(trans('reports.statuses'))->value($report->status) }}
            </div>
            <div class="modal-footer">
                {{ BsForm::patch(route('dashboard.reports.update', $report), ['id' => "report-{$report->id}-status-form"]) }}
                <button type="submit" class="btn btn-primary">
                    @lang('reports.actions.save')
                </button>
                {{ BsForm::close() }}

            </div>
        </div>
    </div>
</div>
