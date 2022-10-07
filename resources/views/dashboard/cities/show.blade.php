@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('cities.attributes.name')</th>
                    <td>{{ $city->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('cities.attributes.country_id')</th>
                    <td>{{ $city->country->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('cities.attributes.delivery_cost')</th>
                    <td>{{ $city->delivery_cost }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('cities.attributes.purchase_delivery_cost')</th>
                    <td>{{ $city->purchase_delivery_cost }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.cities.partials.actions.edit')
            @include('dashboard.cities.partials.actions.delete')
        </div>
    </div>
@endsection

