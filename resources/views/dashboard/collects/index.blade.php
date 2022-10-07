@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.delegates.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('مستحقات المناديب') }}</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('المندوب') }}</th>
                                <th scope="col">{{ __('رقم الجوال') }}</th>
                                <th scope="col">{{ __('عدد الطلبات') }}</th>
                                <th scope="col">{{ __('اجمالي المستحقات') }}</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($collects as $collect)
                                @if($collect->user)
                                <tr>
                                    <td>
                                        <a href="{{ route('dashboard.collects.show', $collect->user) }}">
                                            {{ $collect->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $collect->user->mobile }}</td>
                                    <td>{{ $collect->orders_count }}</td>
                                    <td>{{ price($collect->total) }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('dashboard.collects.show', $collect->user) }}"
                                               class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
                                                <i class="feather icon-eye"></i>
                                            </a>
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
            </div>
        </div>
    </div>
@endsection