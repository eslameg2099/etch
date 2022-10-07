<li class="dropdown dropdown-notification nav-item">
    <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
        <i class="ficon feather icon-bell"></i>
        <span class="badge badge-pill badge-primary badge-up notiCount">{{ auth('sanctum')->user()->unreadNotifications->count() }}</span></a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right uiNotification">
        <li class="dropdown-menu-header">
            <div class="dropdown-header m-0 p-2">
                <h3 class="white"><span class="notiCount">{{ auth('sanctum')->user()->unreadNotifications->count() }}</span> @lang('global.new')</h3><span class="notification-title">@lang('global.notification')</span>
            </div>
        </li>
        <li class="scrollable-container media-list">
            @foreach(auth('sanctum')->user()->unreadNotifications as $notification)
                <a class="d-flex justify-content-between notificationContainer" href="{{ isset($notification->data['url']) ? $notification->data['url'] : "javascript:void(0)"}}">
                    <div class="media d-flex align-items-start">
                        <div class="media-left"><i class="feather icon-message-circle font-medium-5 success"></i></div>
                        <div class="media-body">
                            <h6 class="success media-heading red darken-1">{{ optional($notification->data)['title'] }}</h6>
                            <small class="notification-text">{{ optional($notification->data)['body'] }}</small>
                        </div>
                        <div class="text-center">
                            <small>
                                <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">{{ $notification->created_at->diffForHumans() }}</time>
                            </small>
                            <br/>
                            <div class="mt-1 readNotification" data-id="{{ $notification->id }}">
                                <button type="button" class="btn btn-sm btn-default"><i class="fa fa-close"></i></button>
                            </div>
                        </div>

                    </div>
                </a>
            @endforeach

        </li>
        <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center" href="javascript:void(0)">{{ \Carbon\Carbon::now()->toDateString() }}</a></li>
    </ul>
</li>
