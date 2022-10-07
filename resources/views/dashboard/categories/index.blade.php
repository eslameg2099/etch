@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.categories.partials.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('categories.plural')</h4>
                    @include('dashboard.categories.partials.actions.create')
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('categories.attributes.name')</th>
                                <th scope="col">@lang('categories.attributes.is_active')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <th scope="row">{{ $category->id }}</th>
                                    <td>
                                        @include('dashboard.categories.partials.actions.link')
                                    </td>
                                    <td>
                                        @include('dashboard.categories.partials.flags.active')
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.categories.partials.actions.show')
                                            @include('dashboard.categories.partials.actions.edit')
                                            @include('dashboard.categories.partials.actions.delete')
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">@lang('categories.empty')</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($categories->hasPages())
                    <div class="card-footer">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection