@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.coupons.partials.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('coupons.plural')</h4>
                    @include('dashboard.coupons.partials.actions.create')
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('coupons.attributes.code')</th>
                                <th scope="col">@lang('coupons.attributes.percentage_value')</th>
                                <th scope="col">@lang('coupons.attributes.usage_limit')</th>
                                <th scope="col">@lang('coupons.attributes.usage_count')</th>
                                <th scope="col">@lang('coupons.attributes.created_at')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($coupons as $coupon)
                                <tr>
                                    <th scope="row">{{ $coupon->id }}</th>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->percentage_value }} %</td>
                                    <td>{{ $coupon->usage_count }}</td>
                                    <td>{{ $coupon->coupon_count }}</td>
                                    <td>{{ $coupon->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.coupons.partials.actions.show')
                                            @include('dashboard.coupons.partials.actions.edit')
                                            @include('dashboard.coupons.partials.actions.delete')
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">@lang('coupons.empty')</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($coupons->hasPages())
                    <div class="card-footer">
                        {{ $coupons->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection