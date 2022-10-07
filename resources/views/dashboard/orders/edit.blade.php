@extends('dashboard.layout.main')
@section('content')
    {{ BsForm::resource('orders')->putModel($order, route('dashboard.orders.update', $order), ['files' => true]) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('orders.actions.edit')</h3>
        </div>
        <div class="card-body">
            @include('dashboard.orders.partials.form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">
                @lang('orders.actions.save')
            </button>
        </div>
    </div>
    {{ BsForm::close() }}

@endsection
