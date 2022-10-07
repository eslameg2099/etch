@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('users.attributes.name')</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('users.attributes.city_id')</th>
                    <td>{{ $user->city->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('users.attributes.mobile')</th>
                    <td>{{ $user->mobile }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('users.attributes.cancellation_attempts')</th>
                    <td>{{ $user->cancellation_attempts }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('users.attributes.is_active')</th>
                    <td>
                        @include('dashboard.users.partials.flags.active')
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.users.partials.actions.edit')
            @include('dashboard.users.partials.actions.delete')
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {{ BsForm::resource('wallets')->post(route('dashboard.wallets.recharge', $user)) }}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('wallets.actions.recharge')</h4>
                </div>
                <div class="card-body">
                    {{ BsForm::number('amount')->step('.01')->required() }}
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

