@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.audits.partials.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('audits.plural')</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('audits.table.user')</th>
                                <th scope="col">@lang('audits.table.worker')</th>
                                <th scope="col">@lang('audits.table.event')</th>
                                <th scope="col">@lang('audits.table.auditable')</th>
                                <th scope="col">@lang('audits.table.oldVal')</th>
                                <th scope="col">@lang('audits.table.newVal')</th>
                                <th scope="col">@lang('audits.table.created_at')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($audits as $audit)
                                <tr>
                                    <th scope="row">{{ $audit->id }}</th>
                                    <td>
                                        {{$audit->user->name}}
                                    </td>
                                    <td>
                                        {{ $audit->user_id .' - '. $audit->user_type}}
                                    </td>
                                    <td>
                                        {{$audit->event}}
                                    </td>
                                    <td>
                                        {{ $audit->auditable_id .' - '. $audit->auditable_type}}
                                    </td>
                                    <td>
                                            <ul>
                                                @foreach($audit->old_values as $key => $value)
                                                <li>
                                                    {{$key .': ' . $value}}
                                                </li>
                                                @endforeach
                                            </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach($audit->new_values as $key => $value)
                                                <li>
                                                    {{$key .':' . $value}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        {{$audit->created_at}}
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
                @if($audits->hasPages())
                    <div class="card-footer">
                        {{ $audits->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection