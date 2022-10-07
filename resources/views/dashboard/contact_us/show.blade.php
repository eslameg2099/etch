@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('contact_us.attributes.name')</th>
                    <td>
                        {{ $message->name }}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('contact_us.attributes.email')</th>
                    <td>
                        {{ $message->email }}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('contact_us.attributes.mobile')</th>
                    <td>
                        {{ $message->mobile }}
                    </td>
                </tr>

                <tr>
                    <th width="200">@lang('contact_us.attributes.message')</th>
                    <td>{{ $message->message }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('contact_us.attributes.created_at')</th>
                    <td>{{ $message->created_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('dashboard.contact_us.partials.actions.delete')
        </div>
    </div>
@endsection

