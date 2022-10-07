<? /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Support\Payment\Models\Transaction[] $transactions */ ?>
@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.wallets.withdrawal-filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('wallets.withdrawal')</h4>
                    <h4 class="card-title">

                        @lang('wallets.total')
                        : {{ $balance }} {{ Settings::locale()->get('currency') }}</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('wallets.attributes.user_id')</th>
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
                                    <td>@include('dashboard.users.partials.actions.link', ['user' => $transaction->user])</td>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ abs($transaction->amount) }} {{ Settings::locale()->get('currency') }}</td>
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
                                                                    <td>{{ $transaction->checkout->status }}</td>
                                                                </tr>
                                                            @endif
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
                                        @if($transaction->status == \App\Support\Payment\Models\Transaction::WITHDRAWAL_REQUEST_STATUS)
                                            <a href="{{ route('dashboard.withdrawal.confirm', $transaction) }}"
                                               class="btn btn-primary btn-sm">
                                                @lang('wallets.statuses.'.\App\Support\Payment\Models\Transaction::WITHDRAWAL_STATUS)
                                            </a>
                                        @endif
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
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        {{ $transactions->links() }}
                        <a href="{{ route('dashboard.withdrawal.export', request()->all()) }}" class="btn btn-primary">
                            <i class="fas fa-file-export"></i>
                            @lang('تصدير لملف Excel')
                        </a>
                    </div>
                @else
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a href="{{ route('dashboard.withdrawal.export', request()->all()) }}" class="btn btn-primary">
                            <i class="fas fa-file-export"></i>
                            @lang('تصدير لملف Excel')
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection