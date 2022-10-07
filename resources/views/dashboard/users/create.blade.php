@extends('dashboard.layout.main')
@section('content')
    {{ BsForm::resource('users')->post(route('dashboard.users.store')) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('users.actions.create')</h3>
        </div>
        <div class="card-body">
            @include('dashboard.users.partials.form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">
                @lang('users.actions.save')
            </button>
        </div>
    </div>
    {{ BsForm::close() }}

@endsection
