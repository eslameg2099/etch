@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.users.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('users.plural')</h4>
                    @include('dashboard.users.partials.actions.create')
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('users.attributes.name')</th>
                                <th scope="col">@lang('users.attributes.mobile')</th>
                                <th scope="col">@lang('users.attributes.is_active')</th>
                                <th scope="col">@lang('users.attributes.created_at')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>
                                        @include('dashboard.users.partials.actions.link')
                                    </td>
                                    <td>{{ $user->mobile }}</td>
                                    <td><x-boolean :is="$user->is_active"></x-boolean></td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.users.partials.actions.show')
                                            @include('dashboard.users.partials.actions.edit')
                                            @include('dashboard.users.partials.actions.delete')
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">@lang('users.empty')</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($users->hasPages())
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        {{ $users->links() }}
                        <a href="{{ route('dashboard.user.export', request()->all()) }}" class="btn btn-primary">
                            <i class="fas fa-file-export"></i>
                            @lang('تصدير لملف Excel')
                        </a>
                    </div>
                @else
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a href="{{ route('dashboard.user.export', request()->all()) }}" class="btn btn-primary">
                            <i class="fas fa-file-export"></i>
                            @lang('تصدير لملف Excel')
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection