{{ BsForm::resource('delegates')->get(url()->current()) }}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('delegates.actions.filter')</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                {{ BsForm::text('name')->value(request('name')) }}
            </div>
            <div class="col-md-3">
                {{ BsForm::text('mobile')->value(request('mobile')) }}
            </div>
            <div class="col-md-3">
                {{ BsForm::select('is_approved')
                    ->label(__('حالة المندوب'))
                    ->placeholder(__('الكل'))
                    ->options([
                        1 => __('مفعل'),
                        0 => __('غير مفعل'),
                    ])->value(request('is_approved')) }}
            </div>
            <div class="col-md-3">
                {{ BsForm::number('perPage')
                    ->value(request('perPage', 15))
                    ->min(1)
                     ->label(trans('delegates.perPage')) }}
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('delegates.actions.filter')
        </button>
    </div>
</div>
{{ BsForm::close() }}
