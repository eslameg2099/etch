@include('dashboard.errors')
{{--@if(! isset($shop))--}}
{{--<shops-select--}}
{{--        name="shop_id"--}}
{{--        label="@lang('branches.singular')"--}}
{{--        placeholder="@lang('branches.select')"--}}
{{--        value="{{ $branch->shop_id ?? old('shop_id') }}"--}}
{{--></shops-select>--}}
{{--@endif--}}
@bsMultilangualFormTabs
{{ BsForm::text('name')->required() }}
{{ BsForm::textarea('description') }}
@endBsMultilangualFormTabs
{{ BsForm::select('city_id')->required()->options(\App\Models\MasterData\City::listsTranslations('name')->pluck('name', 'id')) }}


{{ BsForm::text('address')->attribute('readonly', 'readonly') }}

<google-map-marker
        :initial-lat-value="{{ $branch->lat ?? 24.700548606169395 }}"
        :initial-lng-value="{{ $branch->lng ?? 46.64410303322909 }}"
        :zoom="{{ isset($branch) ? 8 : 5 }}"
></google-map-marker>