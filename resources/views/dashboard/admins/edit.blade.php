@extends('dashboard.layout.main')
@section('content')
    {{ BsForm::resource('admins')->putModel($admin, route('dashboard.admins.update', $admin), ['files' => true]) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('admins.actions.edit')</h3>
        </div>
        <div class="card-body">
            @include('dashboard.admins.partials.form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">
                @lang('admins.actions.save')
            </button>
        </div>
    </div>
    {{ BsForm::close() }}

@endsection
