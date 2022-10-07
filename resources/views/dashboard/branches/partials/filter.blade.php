{{ BsForm::resource('shops')->get(url()->current()) }}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('shops.actions.filter')</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                {{ BsForm::text('name')->value(request('name')) }}
            </div>
            <div class="col-md-6">
                {{ BsForm::select('is_active')
                    ->label(__('حالة المتجر'))
                    ->placeholder(__('الكل'))
                    ->options([
                        1 => __('مفعل'),
                        0 => __('غير مفعل'),
                    ])->value(request('is_active')) }}
            </div>
            <div class="col-md-4">
                {{ BsForm::select('category_id')
                    ->placeholder(__('الكل'))
                    ->options(\App\Models\MasterData\Category::all()->pluck('name', 'id'))->value(request('category_id')) }}
            </div>
            <div class="col-md-4">
                {{ BsForm::select('city_id')
                    ->placeholder(__('الكل'))
                    ->options(\App\Models\MasterData\City::all()->pluck('name', 'id'))->value(request('city_id')) }}
            </div>
            <div class="col-md-4">
                {{ BsForm::number('perPage')
                    ->value(request('perPage', 15))
                    ->min(1)
                     ->label(trans('shops.perPage')) }}
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('shops.actions.filter')
        </button>
    </div>
</div>
{{ BsForm::close() }}
