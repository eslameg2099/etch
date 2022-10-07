@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.delegates.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('delegates.plural')</h4>
                    @include('dashboard.delegates.partials.actions.create')
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('delegates.attributes.name')</th>
                                <th scope="col">@lang('delegates.attributes.mobile')</th>
                                <th scope="col">@lang('delegates.attributes.delegate.is_approved')</th>
                                <th scope="col">@lang('delegates.attributes.orders_count')</th>
                                <th scope="col">@lang('delegates.attributes.delegate.national_id')</th>
                                <th scope="col">@lang('delegates.attributes.created_at')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($delegates as $delegate)
                                @if($delegate->delegate)
                                <tr class="{{ optional($delegate->delegate)->is_approved ? '' : 'bg-warning bg-lighten-4' }}">
                                    <th scope="row">{{ $delegate->id }}</th>
                                    <td>
                                        @include('dashboard.delegates.partials.actions.link')
                                    </td>
                                    <td>{{ $delegate->mobile }}</td>
                                    <td><x-boolean :is="optional($delegate->delegate)->is_approved"></x-boolean></td>
                                    <td>{{ $delegate->delegate_orders_count }}</td>
                                    <td>{{ $delegate->delegate->national_id }}</td>
                                    <td>{{ $delegate->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.delegates.partials.actions.show')
                                            @include('dashboard.delegates.partials.actions.edit')
                                            @include('dashboard.delegates.partials.actions.delete')
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">@lang('delegates.empty')</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($delegates->hasPages())
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        {{ $delegates->links() }}
                        <a href="{{ route('dashboard.delegate.export', request()->all()) }}" class="btn btn-primary">
                            <i class="fas fa-file-export"></i>
                            @lang('تصدير لملف Excel')
                        </a>
                    </div>
                @else
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a href="{{ route('dashboard.delegate.export', request()->all()) }}" class="btn btn-primary">
                            <i class="fas fa-file-export"></i>
                            @lang('تصدير لملف Excel')
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection