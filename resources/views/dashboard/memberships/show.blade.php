@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('memberships.attributes.name')</th>
                    <td>{{ $membership->name }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('memberships.attributes.rates_count')</th>
                    <td>{{ $membership->rates_count }}</td>
                </tr>
                @if($membership->getFirstMedia())
                    <tr>
                        <th width="200">@lang('memberships.attributes.image')</th>
                        <td>
                            <file-preview :media="{{ $membership->getMediaResource() }}"></file-preview>
                        </td>
                    </tr>
                @endif
                <tr>
                    <th width="200">@lang('memberships.attributes.created_at')</th>
                    <td>{{ $membership->created_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.memberships.partials.actions.edit')
            @include('dashboard.memberships.partials.actions.delete')
        </div>
    </div>
@endsection

