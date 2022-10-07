@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.orders.partials.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('orders.plural')</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('orders.attributes.reference_number')</th>
                                <th scope="col">@lang('orders.attributes.user_id')</th>
                                <th scope="col">@lang('orders.attributes.type')</th>
                                <th scope="col">@lang('orders.attributes.status')</th>
                                <th scope="col">@lang('orders.attributes.receiving_address_id')</th>
                                <th scope="col">@lang('orders.attributes.delivery_address_id')</th>
                                <th scope="col">@lang('orders.attributes.created_at')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <th scope="row">{{ $order->id }}</th>
                                    <td>
                                        {{ $order->reference_number }}
                                    </td>
                                    <td>
                                        @include('dashboard.users.partials.actions.link', ['user'=> $order->User])
                                    </td>
                                    <td>{{ trans('orders.types.'.$order->type) }}</td>
                                    <td>{{ $order->readableStatus }}</td>
                                    <td>
                                        @if($order->ReceivingAddress)
                                            {{ $order->ReceivingAddress->address }}
                                        @elseif($order->branch)
                                            {{ optional($order->branch)->address }}
                                        @else
                                            {{ optional($order->shop)->address }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ optional($order->DeliveryAddress)->address }}
                                    </td>
                                    <td>
                                        {{ $order->created_at }}
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.orders.partials.actions.show')
                                            @if(! in_array($order->status, [\App\Models\Order::CanceledBySystem , \App\Models\Order::CanceledByUser , \App\Models\Order::CanceledByDelegate , \App\Models\Order::Delivered,
\App\Models\Order::CanceledAutomatic,
\App\Models\Order::WaitingForAddPayment,
\App\Models\Order::PaymentTimeOut,
\App\Models\Order::UnderReview,
\App\Models\Order::PaymentDone,
]) )
                                                @include('dashboard.orders.partials.actions.edit')
                                            @endif


{{--                                            @include('dashboard.orders.partials.actions.delete')--}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">@lang('orders.empty')</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($orders->hasPages())
                    <div class="card-footer">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection