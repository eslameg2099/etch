@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.memberships.partials.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('memberships.plural')</h4>
                    @include('dashboard.memberships.partials.actions.create')
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('memberships.attributes.name')</th>
                                <th scope="col">@lang('memberships.attributes.rates_count')</th>
                                <th scope="col">@lang('memberships.attributes.created_at')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($memberships as $membership)
                                <tr>
                                    <th scope="row">{{ $membership->id }}</th>
                                    <td>{{ $membership->name }}</td>
                                    <td>{{ $membership->rates_count }}</td>
                                    <td>{{ $membership->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.memberships.partials.actions.show')
                                            @include('dashboard.memberships.partials.actions.edit')
                                            @include('dashboard.memberships.partials.actions.delete')
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">@lang('memberships.empty')</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($memberships->hasPages())
                    <div class="card-footer">
                        {{ $memberships->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection