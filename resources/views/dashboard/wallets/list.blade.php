<? /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Support\Payment\Models\Transaction[] $transactions */ ?>
<div class="row" id="table-striped">
    <div class="col-12">
        {{ $filter ?? '' }}
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $title ?? '' }}</h4>
                <h4 class="card-title">
                    @isset($balanceTitle)
                        {{ $balanceTitle }}
                    @else
                        @lang('wallets.balance')
                    @endisset
                    : {{ $balance }} {{ Settings::locale()->get('currency') }}</h4>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">@lang('wallets.attributes.date')</th>
                            <th scope="col">@lang('wallets.attributes.amount')</th>
                            <th scope="col">@lang('wallets.attributes.status')</th>
                            <th scope="col">@lang('wallets.attributes.type')</th>
                            <th scope="col">...</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <th scope="row">{{ $transaction->id }}</th>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->amount }} {{ Settings::locale()->get('currency') }}</td>
                                <td>@lang('wallets.statuses.'.$transaction->status)</td>
                                <td>@lang('wallets.types.'.$transaction->type, ['order' => '#'. $transaction->order_id])</td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-dark btn-sm" data-toggle="modal"
                                            data-target="#transaction-{{ $transaction->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="transaction-{{ $transaction->id }}" tabindex="-1"
                                         role="dialog"
                                         aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">@lang('wallets.details')</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped">
                                                        @if($transaction->checkout)
                                                            <tr>
                                                                <th>@lang('wallets.attributes.checkout_id')</th>
                                                                <td>{{ $transaction->checkout->checkout_id }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status</th>
                                                                <td>{{ trans('hyperpay.'.$transaction->checkout->status) }} ({{ $transaction->checkout->status }})</td>
                                                            </tr>
                                                        @endif
                                                        {{--                                                        @if($transaction->actor)--}}
                                                        {{--                                                            <tr>--}}
                                                        {{--                                                                <th>@lang('wallets.attributes.actor_id')</th>--}}
                                                        {{--                                                                <td>--}}
                                                        {{--                                                                    @include('dashboard.users.partials.actions.link', ['user' => $transaction->actor])--}}
                                                        {{--                                                                </td>--}}
                                                        {{--                                                            </tr>--}}
                                                        {{--                                                        @endif--}}
                                                        @if($transaction->user)
                                                            <tr>
                                                                <th>@lang('wallets.attributes.user_id')</th>
                                                                <td>
                                                                    @include('dashboard.users.partials.actions.link', ['user' => $transaction->user])
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($transaction->order)
                                                            <tr>
                                                                <th>@lang('wallets.attributes.order_id')</th>
                                                                <td>
                                                                    @include('dashboard.orders.partials.actions.link', ['order' => $transaction->order])
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <th>@lang('wallets.attributes.amount')</th>
                                                            <td>
                                                                {{ $transaction->amount }} {{ Settings::locale()->get('currency') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>@lang('wallets.attributes.status')</th>
                                                            <td>
                                                                @lang('wallets.statuses.'.$transaction->status)
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>@lang('wallets.attributes.type')</th>
                                                            <td>
                                                                @lang('wallets.types.'.$transaction->type, ['order' => '#'. $transaction->order_id])
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>@lang('wallets.attributes.notes')</th>
                                                            <td>
                                                                {{ $transaction->notes ?? '---' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>@lang('wallets.attributes.date')</th>
                                                            <td>
                                                                {{ $transaction->date }}
                                                            </td>
                                                        </tr>
                                                        @if($transaction->account_name)
                                                            <tr>
                                                                <th>@lang('wallets.attributes.account_name')</th>
                                                                <td>
                                                                    {{ $transaction->account_name }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($transaction->bank_name)
                                                            <tr>
                                                                <th>@lang('wallets.attributes.bank_name')</th>
                                                                <td>
                                                                    {{ $transaction->bank_name }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($transaction->account_number)
                                                            <tr>
                                                                <th>@lang('wallets.attributes.account_number')</th>
                                                                <td>
                                                                    {{ $transaction->account_number }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($transaction->iban_number)
                                                            <tr>
                                                                <th>@lang('wallets.attributes.iban_number')</th>
                                                                <td>
                                                                    {{ $transaction->iban_number }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th class="text-center" colspan="100">@lang('wallets.empty')</th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($transactions->hasPages())
                <div class="card-footer">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>