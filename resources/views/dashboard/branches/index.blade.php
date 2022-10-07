@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.shops.partials.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('shops.plural')</h4>
                    @include('dashboard.shops.partials.actions.create')
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('shops.attributes.name')</th>
                                <th scope="col">@lang('shops.attributes.category_id')</th>
                                <th scope="col">@lang('shops.attributes.city_id')</th>
                                <th scope="col">@lang('shops.attributes.is_active')</th>
                                <th scope="col">@lang('shops.attributes.address')</th>
                                <th scope="col">@lang('shops.attributes.created_at')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($shops as $shop)
                                <tr>
                                    <th scope="row">{{ $shop->id }}</th>
                                    <td>
                                        @include('dashboard.shops.partials.actions.link')
                                    </td>
                                    <td>{{ optional($shop->category)->name }}</td>
                                    <td>{{ optional($shop->city)->name }}</td>
                                    <td>
                                        @include('dashboard.shops.partials.flags.active')
                                    </td>
                                    <td>{{ Str::limit($shop->address,20) ?? '--'}}</td>
                                    <td>{{ $shop->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.shops.partials.actions.show')
                                            @include('dashboard.shops.partials.actions.edit')
                                            @include('dashboard.shops.partials.actions.delete')
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">@lang('shops.empty')</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($shops->hasPages())
                    <div class="card-footer">
                        {{ $shops->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection