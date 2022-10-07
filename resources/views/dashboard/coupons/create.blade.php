@extends('dashboard.layout.main')
@section('content')
    {{ BsForm::resource('coupons')->post(route('dashboard.coupons.store')) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('coupons.actions.create')</h3>
        </div>
        <div class="card-body">
            @include('dashboard.coupons.partials.form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">
                @lang('coupons.actions.save')
            </button>
        </div>
    </div>
    {{ BsForm::close() }}

@endsection
