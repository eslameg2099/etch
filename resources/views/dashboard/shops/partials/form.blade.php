@include('dashboard.errors')
@bsMultilangualFormTabs
{{ BsForm::text('name')->required() }}
{{ BsForm::textarea('description')->required() }}
@endBsMultilangualFormTabs
{{ BsForm::checkbox('is_active')->value(1)->default(0)->checked($shop->is_active ?? old('is_active')) }}
{{ BsForm::select('category_id')->required()->options(\App\Models\MasterData\Category::listsTranslations('name')->pluck('name', 'id')) }}
{{ BsForm::select('city_id')->required()->options(\App\Models\MasterData\City::listsTranslations('name')->pluck('name', 'id')) }}

<div class="row">
    <div class="col-6">
        {{ BsForm::time('open_at') }}
    </div>
    <div class="col-6">
        {{ BsForm::time('closed_at') }}
    </div>
</div>
{{ BsForm::text('except_days') }}

{{--{{ BsForm::text('address')->attribute('readonly', 'readonly') }}--}}

{{--<google-map-marker--}}
{{--        :initial-lat-value="{{ $shop->lat ?? 24.700548606169395 }}"--}}
{{--        :initial-lng-value="{{ $shop->lng ?? 46.64410303322909 }}"--}}
{{--        :zoom="{{ isset($shop) ? 8 : 5 }}"--}}
{{--></google-map-marker>--}}

@isset($shop)
    {{ BsForm::image('image')->files($shop->getMediaResource()) }}
    {{ BsForm::image('menu')->unlimited()->collection('menu')->files($shop->getMediaResource('menu')) }}
@else
    {{ BsForm::image('image') }}
    {{ BsForm::image('menu')->unlimited()->collection('menu') }}
@endisset