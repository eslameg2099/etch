@extends('dashboard.layout.main')
@section('content')
    {{ BsForm::resource('cities')->putModel($city, route('dashboard.cities.update', $city), ['files' => true]) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('cities.actions.edit')</h3>
        </div>
        <div class="card-body">
            @include('dashboard.cities.partials.form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">
                @lang('cities.actions.save')
            </button>
        </div>
    </div>
    {{ BsForm::close() }}

@endsection
