{{ BsForm::resource('wallets')->get(url()->current()) }}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('wallets.actions.filter')</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                {{ BsForm::select('user_type')->options(trans('wallets.user_types'))->value(request('user_type')) }}
            </div>
            <div class="col-md-3">
                {{ BsForm::select('status')->options([
                    implode('-', [
                        \App\Support\Payment\Models\Transaction::WITHDRAWAL_REQUEST_STATUS,
                        \App\Support\Payment\Models\Transaction::WITHDRAWAL_STATUS,
                    ]) => trans('wallets.statuses.all'),
                    ($key = \App\Support\Payment\Models\Transaction::WITHDRAWAL_REQUEST_STATUS) => trans('wallets.statuses.'.$key),
                    ($key = \App\Support\Payment\Models\Transaction::WITHDRAWAL_STATUS) => trans('wallets.statuses.'.$key),
                ])->value(request('status')) }}
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
      $(function() {
        let start = '{{ explode(' - ', request('created_at'))[0] ?? null }}';
        let end = '{{ explode(' - ', request('created_at'))[1] ?? null }}';
        if (start) { start = moment(start) } else { start = moment('1970-01-01')}
        if (end) { end = moment(end) } else { end = moment()}
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
