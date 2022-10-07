@extends('dashboard.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-middle">
                <tbody>
                <tr>
                    <th width="200">@lang('notifications.attributes.id')</th>
                    <td>
                        {{$adminNotification->id}}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('notifications.attributes.user_type')</th>
                    <td>
                        {{@trans('notifications.user_type.'.$adminNotification->user_type)}}
                    </td>
                </tr>
                <tr>
                    <th width="200">@lang('notifications.attributes.label')</th>
                    <td>{{ $adminNotification->label }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('notifications.attributes.body')</th>
                    <td>{{ $adminNotification->body }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('notifications.attributes.active')</th>
                    <td>{{ $adminNotification->active ? __('فعال') : __('غير فعال') }}</td>
                </tr>
                <tr>
                    <th width="200">@lang('notifications.attributes.created_at')</th>
                    <td>{{ $adminNotification->created_at }}</td>
                </tr>

                </tbody>
            </table>
            @if($adminNotification->active)
                @include('dashboard.notifications.adminNotifications.partials.actions.disable')
            @elseif(!$adminNotification->active)
                @include('dashboard.notifications.adminNotifications.partials.actions.visible')
            @endif
            @if($adminNotification->active)
                @include('dashboard.notifications.adminNotifications.partials.actions.disable')
            @elseif(!$adminNotification->active)
                @include('dashboard.notifications.adminNotifications.partials.actions.visible')
            @endif
        </div>

    </div>
@endsection

