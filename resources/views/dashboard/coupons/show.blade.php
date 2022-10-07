@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('coupons.attributes.code')</th>
                    <td>{{ $coupon->code }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('coupons.attributes.percentage_value')</th>
                    <td>{{ $coupon->percentage_value }} %</td>
                </tr>
                <tr>
                    <th width="200">@lang('coupons.attributes.usage_count')</th>
                    <td>{{ $coupon->usage_count }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('coupons.attributes.only_once')</th>
                    <td>{{ $coupon->only_once }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('coupons.attributes.only_new')</th>
                    <td>{{ $coupon->only_new }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('coupons.attributes.created_at')</th>
                    <td>{{ $coupon->created_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.coupons.partials.actions.edit')
            @include('dashboard.coupons.partials.actions.delete')
        </div>
    </div>
@endsection

