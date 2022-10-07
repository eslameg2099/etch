@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::text('mobile')->required() }}
{{ BsForm::select('city_id')->required()->options(\App\Models\MasterData\City::listsTranslations('name')->pluck('name', 'id')) }}
{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}
@if(isset($user))
    {{ BsForm::number('cancellation_attempts')->min(0) }}
@endif
{{ BsForm::checkbox('is_active')->value(1)->default(0)->checked($user->is_active ?? old('is_active')) }}
