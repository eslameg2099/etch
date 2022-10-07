@extends('dashboard.layout.main')
@section('content')
    {{ BsForm::resource('categories')->putModel($category, route('dashboard.categories.update', $category), ['files' => true]) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('categories.actions.edit')</h3>
        </div>
        <div class="card-body">
            @include('dashboard.categories.partials.form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">
                @lang('categories.actions.save')
            </button>
        </div>
    </div>
    {{ BsForm::close() }}

@endsection
