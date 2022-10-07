@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('admins.plural')</h4>
                    @include('dashboard.admins.partials.actions.create')
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('admins.attributes.name')</th>
                                <th scope="col">@lang('admins.attributes.mobile')</th>
                                <th scope="col">@lang('admins.attributes.created_at')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\Users\Admin[] $admins */ ?>
                            @foreach($admins as $admin)
                                <tr>
                                    <th scope="row">{{ $admin->id }}</th>
                                    <td>
                                        <a href="{{ route('dashboard.admins.show', $admin) }}">
                                            {{ $admin->name }}
                                        </a>
                                    </td>
                                    <td>{{ $admin->mobile }}</td>
                                    <td>{{ $admin->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.admins.partials.actions.show')
                                            @include('dashboard.admins.partials.actions.edit')
                                            @include('dashboard.admins.partials.actions.delete')
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($admins->hasPages())
                    <div class="card-footer">
                        {{ $admins->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection