@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">

            <div class="card">
                <div class="card-content">
                    <table class="table table-striped table-middle pb-0">
                        <tbody>
                        <tr>
                            <th width="200">@lang('delegates.attributes.name')</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th width="200">@lang('delegates.attributes.city_id')</th>
                            <td>{{ $user->city->name }}</td>
                        </tr>
                        <tr>
                            <th width="200">@lang('delegates.attributes.mobile')</th>
                            <td>{{ $user->mobile }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header mb-2">
                    <h4 class="card-title">{{ __('الرصيد المستحق') }}</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('الشهر') }}</th>
                                <th scope="col">{{ __('عدد الطلبات') }}</th>
                                <th scope="col">{{ __('اجمالي المستحقات') }}</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($uncollect as $collect)
                                <tr>
                                    <td>{{ Carbon\Carbon::parse($collect->date)->format('Y-M') }}</td>
                                    <td>{{ $collect->orders_count }}</td>
                                    <td>{{ price($collect->total) }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <form action="{{ route('dashboard.collects.collect', $user) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="date" value="{{ $collect->date }}">
                                                <button type="submit" class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
                                                    {{ __('تحصيل') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">{{ __('لايوجد مستحقات حاليا') }}</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header mb-2">
                    <h4 class="card-title">{{ __('الرصيد المحصل') }}</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('الشهر') }}</th>
                                <th scope="col">{{ __('عدد الطلبات') }}</th>
                                <th scope="col">{{ __('اجمالي المستحقات') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($collected as $collect)
                                <tr>
                                    <td>{{ Carbon\Carbon::parse($collect->date)->format('Y-M') }}</td>
                                    <td>{{ $collect->orders_count }}</td>
                                    <td>{{ price($collect->total) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">{{ __('لايوجد ارصدة حاليا') }}</th>
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