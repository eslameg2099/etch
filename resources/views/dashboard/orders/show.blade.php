<? /** @var \App\Models\Order $order */ ?>
@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">ID</th>
                    <td>{{ $order->id }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.reference_number')</th>
                    <td>{{ $order->reference_number }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.user_id')</th>
                    <td>
                        @include('dashboard.users.partials.actions.link', ['user'=> $order->User])
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.delegate_id')</th>
                    @if($order->delegate)
                    <td>
                        @include('dashboard.delegates.partials.actions.link', ['delegate'=> $order->delegate])
                    </td>
{{--                    @elseif($order->offer->delegate)--}}
{{--                        @include('dashboard.delegates.partials.actions.link', ['delegate'=> $order->offer->delegate])--}}
                    @else
                        '--'
                    @endif
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.type')</th>
                    <td>
                        {{ trans('orders.types.'.$order->type) }}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.receiving_address_id')</th>
                    <td>
                        @if($order->ReceivingAddress)
                            {{ $order->ReceivingAddress->address }}
                        @elseif($order->branch)
                            {{ optional($order->branch)->address }}
                        @else
                            {{ optional($order->shop)->address }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.delivery_address_id')</th>
                    <td>
                        {{ optional($order->DeliveryAddress)->address }}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.shop_id')</th>
                    <td>
                        @include('dashboard.shops.partials.actions.link', ['shop' => $order->shop])
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.status')</th>
                    <td>
                        {{ trans_choice('orders.statuses.'.$order->status, $order->payment_type == \App\Models\Order::PAYMENT_ON_DELIVERY) }}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.payment_type')</th>
                    <td>
                        {{ trans('orders.payment_types.'.$order->payment_type) }}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.order_description')</th>
                    <td>
                        {{ $order->order_description }}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.created_at')</th>
                    <td>
                        {{ $order->created_at }}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.start_at')</th>
                    <td>
                        {{ $order->start_at }}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.schedule_date')</th>
                    <td>
                        {{ $order->schedule_date ?? '---' }}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.closed_at')</th>
                    <td>
                        {{ $order->closed_at }}
                    </td>
                </tr>
                @if($order->payment)
                    <tr>
                        <th width="200">@lang('orders.attributes.payment.sub_total')</th>
                        <td>
                            {{ price($order->payment->amount) }}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('orders.attributes.payment.discount')</th>
                        <td>
                            {{ price($order->payment->getDiscount()) }}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('orders.attributes.payment.total')</th>
                        <td>
                            {{ price($order->payment->getTotal()) }}
                        </td>
                    </tr>
                    @if($order->payment->coupon)
                        <tr>
                            <th width="200">@lang('orders.attributes.payment.coupon')</th>
                            <td>
                                {{ optional($order->payment->coupon)->code }}
                            </td>
                        </tr>
                    @endif
                    @if(($items = $order->payment->itemsDetails->merge($order->payment->staticDetails))->count())
                        <tr>
                            <th width="200">@lang('orders.attributes.payment.items')</th>
                            <td>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>@lang('orders.attributes.payment.item_name')</th>
                                        <th>@lang('orders.attributes.payment.item_cost')</th>
                                    </tr>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ price($item->cost )}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    @endif
                @endif
                <tr>
                    <th width="200">@lang('orders.attributes.rate')</th>
                    <td>
                        {{ $order->rate }} / 5
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('orders.attributes.status')</th>
                    <td>
                        {{ $order->readable_status }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.orders.partials.actions.edit')
        </div>
    </div>
@endsection

