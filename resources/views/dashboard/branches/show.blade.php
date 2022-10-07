@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('shops.attributes.name')</th>
                    <td>{{ $shop->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.description')</th>
                    <td>{{ $shop->description }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.category_id')</th>
                    <td>
                        @include('dashboard.categories.partials.actions.link', ['category' => $shop->category])
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.city_id')</th>
                    <td>
                        @include('dashboard.cities.partials.actions.link', ['city' => $shop->city])
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.open_at')</th>
                    <td>{{ $shop->open_at }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.closed_at')</th>
                    <td>{{ $shop->closed_at }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.except_days')</th>
                    <td>{{ $shop->except_days }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.rate')</th>
                    <td>{{ $shop->rate }} / 5</td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.lat')</th>
                    <td>{{ $shop->lat }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.lng')</th>
                    <td>{{ $shop->lng }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.address')</th>
                    <td>{{ $shop->address }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('shops.attributes.is_active')</th>
                    <td>
                        @include('dashboard.shops.partials.flags.active')
                    </td>
                </tr>
                @if($shop->getFirstMedia())
                    <tr>
                        <th width="200">@lang('shops.attributes.image')</th>
                        <td>
                            <file-preview :media="{{ $shop->getMediaResource() }}"></file-preview>
                        </td>
                    </tr>
                @endif
                @if($shop->getMedia('menu')->count())
                    <tr>
                        <th width="200">@lang('shops.attributes.image')</th>
                        <td>
                            <file-preview :media="{{ $shop->getMediaResource('menu') }}"></file-preview>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.shops.partials.actions.edit')
            @include('dashboard.shops.partials.actions.delete')
        </div>
    </div>
@endsection

