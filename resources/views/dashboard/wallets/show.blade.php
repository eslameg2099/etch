<? /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Support\Payment\Models\Transaction[] $transactions */ ?>
@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            {{ BsForm::resource('wallets')->get(url()->current()) }}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('wallets.actions.filter')</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            {{ BsForm::select('status')
                                ->placeholder(__('wallets.statuses.all'))
                                ->options(Arr::except(trans('wallets.statuses'), 'all'))
                                ->value(request('status')) }}
                        </div>
                        <div class="col-md-3">
                            {{ BsForm::select('type')
                                ->placeholder(__('الكل'))
                                ->options([
                                    ($key = \App\Support\Payment\Models\Transaction::WITHDRAWAL_TYPE) => trans('wallets.types.'.$key),
                                    ($key = \App\Support\Payment\Models\Transaction::BALANCE_RECHARGE) => trans('wallets.types.'.$key),
                                ])
                                ->value(request('type')) }}
                        </div>
                        <div class="col-md-3">
                            {{ BsForm::text('created_at')->value(request('created_at')) }}
                        </div>
                        <div class="col-md-3">
                            {{ BsForm::number('perPage')
                                ->value(request('perPage', 15))
                                ->min(1)
                                 ->label(trans('users.perPage')) }}
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa fa-fw fa-filter"></i>
                        @lang('wallets.actions.filter')
                    </button>
                </div>
            </div>
            {{ BsForm::close() }}
            @push('scripts')
                <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
                <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
                <script type="text/javascript"
                        src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
                <link rel="stylesheet" type="text/css"
                      href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
                <script>
                  $(function () {
                    let start = '{{ explode(' - ', request('created_at'))[0] ?? null }}';
                    let end = '{{ explode(' - ', request('created_at'))[1] ?? null }}';
                    if (start) {
                      start = moment(start)
                    } else {
                      start = moment('1970-01-01')
                    }
                    if (end) {
                      end = moment(end)
                    } else {
                      end = moment()
                    }
                    $('input[name="created_at"]').daterangepicker({
                      opens: 'left',
                      startDate: start,
                      endDate: end,
                      ranges: {
                        'All Time': [moment('1970-01-01'), moment()],
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                      }
                    });
                  });
                </script>
            @endpush
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('محفظة ') {{ $user->name }}</h4>
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
                                <th scope="col">@lang('wallets.total')</th>
                                <th scope="col">@lang('wallets.attributes.status')</th>
                                <th scope="col">@lang('wallets.attributes.type')</th>
{{--                                <th scope="col">@lang('الرصيد السابق')</th>--}}
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
                                    <td>{{$user->getBalanceWithTransaction($transaction->created_at)}} </td>
                                    <td>@lang('wallets.statuses.'.$transaction->status)</td>
                                    <td>@lang('wallets.types.'.$transaction->type, ['order' => '#'. $transaction->order_id])</td>
{{--                                    <td> {{$user->transactions()->whereDate('created_at','<',$transaction->created_at)->sum('amount')??0}}</td>--}}
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
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection