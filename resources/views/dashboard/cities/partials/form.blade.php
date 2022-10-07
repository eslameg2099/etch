@include('dashboard.errors')
@bsMultilangualFormTabs
{{ BsForm::text('name') }}
@endBsMultilangualFormTabs
{{ BsForm::number('delivery_cost')->min(1)->required() }}
{{ BsForm::number('purchase_delivery_cost')->min(1)->required() }}
{{ BsForm::select('country_id')->required()->options(\App\Models\MasterData\Country::listsTranslations('name')->pluck('name', 'id')) }}
