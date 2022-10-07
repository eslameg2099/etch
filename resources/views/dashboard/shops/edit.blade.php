@extends('dashboard.layout.main')
@section('content')
    {{ BsForm::resource('shops')->putModel($shop, route('dashboard.shops.update', $shop), ['files' => true]) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('shops.actions.edit')</h3>
        </div>
        <div class="card-body">
            @include('dashboard.shops.partials.form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">
                @lang('shops.actions.save')
            </button>
        </div>
    </div>
    {{ BsForm::close() }}

@endsection
