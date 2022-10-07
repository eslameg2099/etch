@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::text('mobile')->required() }}
{{ BsForm::select('city_id')->required()->options(\App\Models\MasterData\City::listsTranslations('name')->pluck('name', 'id')) }}
{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}
@if(isset($delegate))
    {{ BsForm::number('cancellation_attempts')->min(0) }}
@endif
{{--{{ BsForm::checkbox('is_active')->value(1)->default(0)->checked($delegate->is_active ?? old('is_active')) }}--}}

<hr>
{{ BsForm::text('delegate[national_id]')
    ->required()
    ->value($delegate->delegate->national_id ?? old('national_id'))
    ->label(trans('delegates.attributes.delegate.national_id')) }}

{{ BsForm::text('delegate[vehicle_type]')
    ->required()
    ->value($delegate->delegate->vehicle_type ?? old('vehicle_type'))
    ->label(trans('delegates.attributes.delegate.vehicle_type')) }}

{{ BsForm::text('delegate[vehicle_model]')
    ->required()
    ->value($delegate->delegate->vehicle_model ?? old('vehicle_model'))
    ->label(trans('delegates.attributes.delegate.vehicle_model')) }}

{{ BsForm::text('delegate[vehicle_number]')
    ->required()
    ->value($delegate->delegate->vehicle_number ?? old('vehicle_number'))
    ->label(trans('delegates.attributes.delegate.vehicle_number')) }}

{{ BsForm::checkbox('delegate[is_approved]')
        ->value(1)
        ->default(0)
        ->label(trans('delegates.attributes.delegate.is_approved'))
        ->checked($delegate->delegate->is_approved ?? old('is_approved')) }}
{{ BsForm::checkbox('delegate[is_available]')
        ->value(1)
        ->default(0)
        ->label(trans('delegates.attributes.delegate.is_available'))
        ->checked($delegate->delegate->is_available ?? old('is_available')) }}
{{ BsForm::checkbox('delegate[can_receive_cash_orders]')
        ->value(1)
        ->default(0)
        ->label(trans('delegates.attributes.delegate.can_receive_cash_orders'))
        ->checked($delegate->delegate->can_receive_cash_orders ?? old('can_receive_cash_orders')) }}
@isset($delegate)
    <div class="row">
        <div class="col col-md-4">
            {{ BsForm::image('national_id_front_image')
                ->collection('national_id_front_image')
                ->label(trans('delegates.attributes.delegate.national_id_front_image'))
                ->files($delegate->getMediaResource('national_id_front_image')) }}
        </div>
        <div class="col col-md-4">
            {{ BsForm::image('national_id_back_image')
                ->collection('national_id_back_image')
                ->label(trans('delegates.attributes.delegate.national_id_back_image'))
                ->files($delegate->getMediaResource('national_id_back_image')) }}
        </div>
        <div class="col col-md-4">
            {{ BsForm::image('vehicle_number_image')
                ->collection('vehicle_number_image')
                ->label(trans('delegates.attributes.delegate.vehicle_number_image'))
                ->files($delegate->getMediaResource('vehicle_number_image')) }}
        </div>
    </div>

@else
    <div class="row">
        <div class="col col-md-4">
            {{ BsForm::image('national_id_front_image')
                ->collection('national_id_front_image')
                ->label(trans('delegates.attributes.delegate.national_id_front_image')) }}
        </div>
        <div class="col col-md-4">
            {{ BsForm::image('national_id_back_image')
                ->collection('national_id_back_image')
                ->label(trans('delegates.attributes.delegate.national_id_back_image')) }}
        </div>
        <div class="col col-md-4">
            {{ BsForm::image('vehicle_number_image')
                ->collection('vehicle_number_image')
                ->label(trans('delegates.attributes.delegate.vehicle_number_image')) }}
        </div>
    </div>
@endisset
