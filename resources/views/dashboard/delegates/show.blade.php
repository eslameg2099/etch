@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('delegates.attributes.name')</th>
                    <td>{{ $delegate->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('delegates.attributes.city_id')</th>
                    <td>{{ $delegate->city->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('delegates.attributes.mobile')</th>
                    <td>{{ $delegate->mobile }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('delegates.attributes.cancellation_attempts')</th>
                    <td>{{ $delegate->cancellation_attempts }}</td>
                </tr>
                {{--                <tr>--}}
                {{--                    <th width="200">@lang('delegates.attributes.is_active')</th>--}}
                {{--                    <td>--}}
                {{--                        <x-boolean :is="$delegate->is_active"></x-boolean>--}}
                {{--                    </td>--}}
                {{--                </tr>--}}
                @if($delegate->delegate)
                    <tr>
                        <th width="200">@lang('delegates.attributes.delegate.is_approved')</th>
                        <td>
                            <x-boolean :is="$delegate->delegate->is_approved"></x-boolean>
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.delegate.is_available')</th>
                        <td>
                            <x-boolean :is="$delegate->delegate->is_available"></x-boolean>
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.delegate.can_receive_cash_orders')</th>
                        <td>
                            <x-boolean :is="$delegate->delegate->can_receive_cash_orders"></x-boolean>
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.delegate.national_id')</th>
                        <td>
                            {{ $delegate->delegate->national_id }}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.delegate.vehicle_type')</th>
                        <td>
                            {{ $delegate->delegate->vehicle_type }}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.delegate.vehicle_model')</th>
                        <td>
                            {{ $delegate->delegate->vehicle_model }}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.delegate.vehicle_number')</th>
                        <td>
                            {{ $delegate->delegate->vehicle_number }}
                        </td>
                    </tr>
                @endif
                @if($delegate->getFirstMedia('national_id_front_image'))
                    <tr>
                        <th width="200">@lang('delegates.attributes.delegate.national_id_front_image')</th>
                        <td>
                            <file-preview
                                    :media="{{ $delegate->getMediaResource('national_id_front_image') }}"></file-preview>
                        </td>
                    </tr>
                @endif
                @if($delegate->getFirstMedia('national_id_back_image'))
                    <tr>
                        <th width="200">@lang('delegates.attributes.delegate.national_id_back_image')</th>
                        <td>
                            <file-preview
                                    :media="{{ $delegate->getMediaResource('national_id_back_image') }}"></file-preview>
                        </td>
                    </tr>
                @endif
                @if($delegate->getFirstMedia('vehicle_number_image'))
                    <tr>
                        <th width="200">@lang('delegates.attributes.delegate.vehicle_number_image')</th>
                        <td>
                            <file-preview
                                    :media="{{ $delegate->getMediaResource('vehicle_number_image') }}"></file-preview>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.delegates.partials.actions.edit')
            @include('dashboard.delegates.partials.actions.delete')
            <a href="{{ route('dashboard.collects.show', $delegate) }}"
               class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
                {{ __('المستحقات') }}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {{ BsForm::resource('wallets')->post(route('dashboard.wallets.recharge', $delegate)) }}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('wallets.actions.recharge')</h4>
                </div>
                <div class="card-body">
                    {{ BsForm::number('amount')->required() }}
                    {{ BsForm::textarea('notes')->rows(3) }}
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        @lang('wallets.actions.recharge-submit')
                    </button>
                </div>
            </div>
            {{ BsForm::close() }}
        </div>
        <div class="col-md-6">
            @include('dashboard.wallets.list', ['title' => trans('wallets.singular')])
        </div>
    </div>
@endsection

