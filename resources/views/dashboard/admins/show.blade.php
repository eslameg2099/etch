@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('admins.attributes.name')</th>
                    <td>{{ $admin->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('admins.attributes.city_id')</th>
                    <td>{{ $admin->city->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('admins.attributes.mobile')</th>
                    <td>{{ $admin->mobile }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.admins.partials.actions.edit')
            @include('dashboard.admins.partials.actions.delete')
        </div>
    </div>
@endsection

