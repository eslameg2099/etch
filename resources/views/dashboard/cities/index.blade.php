@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.cities.partials.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('cities.plural')</h4>
                    @include('dashboard.cities.partials.actions.create')
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('cities.attributes.name')</th>
                                <th scope="col">@lang('cities.attributes.country_id')</th>
                                <th scope="col">@lang('cities.attributes.delivery_cost')</th>
                                <th scope="col">@lang('cities.attributes.purchase_delivery_cost')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($cities as $city)
                                <tr>
                                    <th scope="row">{{ $city->id }}</th>
                                    <td>
                                        @include('dashboard.cities.partials.actions.link')
                                    </td>
                                    <td>{{ $city->country->name }}</td>
                                    <td>{{ $city->delivery_cost }}</td>
                                    <td>{{ $city->purchase_delivery_cost }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.cities.partials.actions.show')
                                            @include('dashboard.cities.partials.actions.edit')
                                            @include('dashboard.cities.partials.actions.delete')
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">@lang('cities.empty')</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($cities->hasPages())
                    <div class="card-footer">
                        {{ $cities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection