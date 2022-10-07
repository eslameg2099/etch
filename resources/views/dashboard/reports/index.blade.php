@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.reports.partials.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('reports.plural')</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('reports.attributes.user_id')</th>
                                <th scope="col">@lang('reports.attributes.delegate_id')</th>
                                <th scope="col">@lang('reports.attributes.order_id')</th>
                                <th scope="col">@lang('reports.attributes.status')</th>
                                <th scope="col">@lang('reports.attributes.message')</th>
                                <th scope="col">@lang('reports.attributes.created_at')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <th scope="row">{{ $report->id }}</th>
                                    <td>
                                        @include('dashboard.users.partials.actions.link', ['user' => $report->user])
                                    </td>
                                    <td>
                                        @include('dashboard.delegates.partials.actions.link', ['delegate' => $report->delegate])
                                    </td>
                                    <td>
                                        @include('dashboard.orders.partials.actions.link', ['order' => $report->order])
                                    </td>
                                    <td>
                                        @lang('reports.statuses.'.$report->status)
                                    </td>
                                    <td>{{ Str::limit($report->message) }}</td>
                                    <td>{{ $report->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.reports.partials.actions.show')
                                            @include('dashboard.reports.partials.actions.status')
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">@lang('reports.empty')</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($reports->hasPages())
                    <div class="card-footer">
                        {{ $reports->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection