@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('categories.attributes.name')</th>
                    <td>{{ $category->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('categories.attributes.is_active')</th>
                    <td>
                        @include('dashboard.categories.partials.flags.active')
                    </td>
                </tr>
                @if($category->getFirstMedia())
                    <tr>
                        <th width="200">@lang('categories.attributes.image')</th>
                        <td>
                            <file-preview :media="{{ $category->getMediaResource() }}"></file-preview>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.categories.partials.actions.edit')
            @include('dashboard.categories.partials.actions.delete')
        </div>
    </div>
@endsection

