@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('reports.attributes.user_id')</th>
                    <td>
                        @include('dashboard.users.partials.actions.link', ['user' => $report->user])
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('reports.attributes.delegate_id')</th>
                    <td>
                        @include('dashboard.delegates.partials.actions.link', ['delegate' => $report->delegate])
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('reports.attributes.order_id')</th>
                    <td>
                        @include('dashboard.orders.partials.actions.link', ['order' => $report->order])
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('reports.attributes.status')</th>
                    <td>
                        @lang('reports.statuses.'.$report->status)
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('reports.attributes.message')</th>
                    <td>{{ $report->message }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('reports.attributes.created_at')</th>
                    <td>{{ $report->created_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.reports.partials.actions.status')
        </div>
    </div>
@endsection

