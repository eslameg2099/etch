{{ BsForm::resource('users')->get(url()->current()) }}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('users.actions.filter')</h3>
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
                {{ BsForm::select('is_active')
                    ->label(__('حالة المستخدم'))
                    ->placeholder(__('الكل'))
                    ->options([
                        1 => __('مفعل'),
                        0 => __('غير مفعل'),
                    ])->value(request('is_active')) }}
            </div>
            <div class="col-md-3">
                {{ BsForm::number('perPage')
                    ->value(request('perPage', 15))
                    ->min(1)
                     ->label(trans('users.perPage')) }}
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('users.actions.filter')
        </button>
    </div>
</div>
{{ BsForm::close() }}
