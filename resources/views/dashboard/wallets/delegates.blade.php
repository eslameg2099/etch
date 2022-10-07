@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
{{--            {{ BsForm::resource('wallets')->get(url()->current()) }}--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h3 class="card-title">@lang('wallets.actions.filter')</h3>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-3">--}}
{{--                            {{ BsForm::select('status')--}}
{{--                                ->placeholder(__('wallets.statuses.all'))--}}
{{--                                ->options(Arr::except(trans('wallets.statuses'), 'all'))--}}
{{--                                ->value(request('status')) }}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            {{ BsForm::select('type')--}}
{{--                                ->placeholder(__('الكل'))--}}
{{--                                ->options(Arr::except(trans('wallets.types'), 'all'))--}}
{{--                                ->value(request('type')) }}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            {{ BsForm::text('created_at')->value(request('created_at')) }}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            {{ BsForm::number('perPage')--}}
{{--                                ->value(request('perPage', 15))--}}
{{--                                ->min(1)--}}
{{--                                 ->label(trans('users.perPage')) }}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-footer">--}}
{{--                    <button type="submit" class="btn btn-primary">--}}
{{--                        <i class="fas fa fa-fw fa-filter"></i>--}}
{{--                        @lang('wallets.actions.filter')--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            {{ BsForm::close() }}--}}

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('wallets.delegates')</h4>
                    <h4 class="card-title">
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('المستخدم')</th>
                                <th scope="col">@lang('اجمالي الشحن')</th>
                                <th scope="col">@lang('الرصيد الحالي')</th>
                                <th scope="col">@lang('طلب سحب')</th>
                                <th scope="col">@lang('عدد المعاملات')</th>
                                <th scope="col">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th scope="row">{{ $user->name }}</th>
                                    <th scope="row">{{ price($user->transactions()->where('type', \App\Support\Payment\Models\Transaction::BALANCE_RECHARGE)->sum('amount')) }}</th>
                                    <th scope="row">{{ price($user->getBalance()) }}</th>
                                    <th scope="row">{{ price(abs($user->transactions()->where('type', \App\Support\Payment\Models\Transaction::WITHDRAWAL_REQUEST_STATUS)->sum('amount'))) }}</th>
                                    <th scope="row">{{ $user->transactions()->count() }}</th>
                                    <th scope="row">
                                        <a href="{{ route('dashboard.wallets.show', $user) }}" class="btn btn-black">
                                            <i class="fas fa-eye fw"></i>
                                        </a>
                                    </th>

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
                @if($users->hasPages())
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
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