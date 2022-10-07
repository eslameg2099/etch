{{ BsForm::resource('memberships')->get(url()->current()) }}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('memberships.actions.filter')</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                {{ BsForm::text('name')->value(request('code')) }}
            </div>
            <div class="col-md-6">
                {{ BsForm::number('perPage')
                    ->value(request('perPage', 15))
                    ->min(1)
                     ->label(trans('memberships.perPage')) }}
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('memberships.actions.filter')
        </button>
    </div>
</div>
{{ BsForm::close() }}
