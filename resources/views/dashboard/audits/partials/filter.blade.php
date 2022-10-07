{{ BsForm::resource('audits')->get(url()->current()) }}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('reports.actions.filter')</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                {{BsForm::number('user_id')->value(request('user_id'))}}
            </div>
            <div class="col-md-3">
                {{BsForm::number('auditable_id')->value(request('auditable_id'))}}
            </div>
            <div class="col-md-6">
                {{ BsForm::number('perPage')
                    ->value(request('perPage', 15))
                    ->min(1)
                     ->label(trans('reports.perPage')) }}
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('reports.actions.filter')
        </button>
    </div>
</div>
{{ BsForm::close() }}
