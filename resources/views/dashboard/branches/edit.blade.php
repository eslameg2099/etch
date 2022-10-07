@extends('dashboard.layout.main')
@section('content')
    {{ BsForm::resource('branches')->putModel($branch, route('dashboard.branches.update', $branch), ['files' => true]) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('branches.actions.edit')</h3>
        </div>
        <div class="card-body">
            @include('dashboard.branches.partials.form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">
                @lang('branches.actions.save')
            </button>
        </div>
    </div>
    {{ BsForm::close() }}

@endsection
