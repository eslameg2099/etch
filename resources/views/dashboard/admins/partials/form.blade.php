@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::text('mobile')->required() }}
{{ BsForm::select('city_id')->required()->options(\App\Models\MasterData\City::listsTranslations('name')->pluck('name', 'id')) }}
{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}
