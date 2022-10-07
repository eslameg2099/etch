@extends('dashboard.layout.main')
@section('content')
    {{ BsForm::resource('delegates')->putModel($delegate, route('dashboard.delegates.update', $delegate), ['files' => true]) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('delegates.actions.edit')</h3>
        </div>
        <div class="card-body">
            @include('dashboard.delegates.partials.form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">
                @lang('delegates.actions.save')
            </button>
        </div>
    </div>
    {{ BsForm::close() }}

@endsection
