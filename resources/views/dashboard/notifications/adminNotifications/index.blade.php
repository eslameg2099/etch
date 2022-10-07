@extends('dashboard.layout.main')
@section('breadcrumbs')
    <h2 class="content-header-title float-left mb-0">@lang('sidebar.notifications')</h2>
    <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">@lang('sidebar.dashboard')</a>
            </li>
            <li class="breadcrumb-item"><a href="#">@lang('sidebar.notifications')</a>
            </li>
        </ol>
    </div>
@endsection
@section('content')
    <section id="column-selectors">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" action="{{ route('dashboard.adminNotifications.store') }}" method="post" >
                                @csrf

                                <div class="custom-hr"><span> @lang('global.interior-notification')</span></div>
                                <div class="col-4">
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="radio" class="sendToAllCheckBox" name="user_type" value="1">
                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                        <span class="">@lang('global.send_to_all_users')</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="radio" class="sendToAllCheckBox" name="user_type" value="2">
                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                        <span class="">@lang('global.send_to_all_delegates')</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="radio" class="sendToAllCheckBox" name="user_type" value="3">
                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                        <span class="">إرسال للكل</span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <label>@lang('global.notification_title')</label>
                                        <input name="label" class="form-control" value="{{ old('label') }}" >
                                        <small>@lang('global.max_100')</small>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('global.notification_body')</label>
                                        <textarea cols="12" rows="6" name="body" class="form-control" >{{ old('body') }}</textarea>
                                        <small>@lang('global.max_length2048')<span id="bodyLength">2048</span></small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('global.image')</label>
                                    {{ BsForm::image('image') }}
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-center mt-1">
                                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">@lang('global.send')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="row" id="table-striped">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
{{--                                    <th scope="col">@lang('notifications.attributes.id')</th>--}}
                                    <th scope="col">@lang('notifications.attributes.label')</th>
                                    <th scope="col">@lang('notifications.attributes.user_type')</th>
                                    <th scope="col">@lang('notifications.attributes.active')</th>
                                    <th scope="col">@lang('notifications.attributes.image')</th>
                                    <th scope="col">@lang('notifications.attributes.created_at')</th>
                                    <th scope="col" style="width: 200px;">...</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($ads as $adminNotification)
                                    <tr>
                                        <th scope="row">{{ $adminNotification->id }}</th>
                                        <td>{{ $adminNotification->label }}</td>
                                        <td> {{@trans('notifications.user_type.'.$adminNotification->user_type)}}</td>
                                        <td>{{ $adminNotification->active ?  'مفعل':'غير مفعل' }}</td>
                                        <td> {{$adminNotification->getFirstMediaUrl() ? 'مرفق صورة': 'لا يوجد' }}</td>
                                        <td>{{ $adminNotification->created_at }}</td>
                                        <td>
                                            <div class="d-flex">
                                                @include('dashboard.notifications.adminNotifications.partials.actions.show')
                                                @if($adminNotification->active)
                                                    @include('dashboard.notifications.adminNotifications.partials.actions.disable')
                                                @elseif(!$adminNotification->active)
                                                    @include('dashboard.notifications.adminNotifications.partials.actions.visible')
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <th class="text-center" colspan="100">@lang('memberships.empty')</th>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($ads->hasPages())
                        <div class="card-footer">
                            {{ $ads->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Nav Justified Ends -->
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/pages/app-user.min.css") }}">
    <style>
        .custom-hr{
            width: 100%;
            height: 20px;
            border-bottom: 1px solid #5BA72C;
            text-align: center;
            margin: 30px 0;
        }
        .custom-hr > span{
            font-size: 25px;
            background-color: #ffffff;
            padding: 0 20px;
        }
        .userActive{
            background-color: #38347a !important;
        }
        .pr30px{
            padding-right: 30px;
        }
    </style>
@endpush
@push('scripts')
    <script>
      const imgDiv = $("#imgDiv")
      imgDiv.hide()
      $(function (){
        let animation = ['wobble','backInDown','bounceInDown','fadeInDown','lightSpeedInRight','jackInTheBox','zoomInDown','slideInDown']
        let dir = "ltr";
        $('#replayType').on('change', function () {
          let type = $(this).find('option:selected').val();
          if(type == 1) {
            $('#bodyLength').html(2048);
          } else if(type == 2) {
            $('#bodyLength').html(500);
          } else if(type == 3) {
            imgDiv.show()
          }
          else {
            $('#replayBody').hide();
          }
        })

        $('.toggleUsers').on('click', function (){
          let input = $(this).data('input');
          $('.toggleUsers').removeClass('userActive')
          $(this).addClass('userActive')
          switch (input) {
            case 'users'    : toggle('.usersDiv'); break;
            case 'delegates'    : toggle('.delegatesDiv'); break;
          }
        })
        $('.toggleImage').on('click', function (){
          let input = $(this).data('input');
          $('.toggleImage').removeClass('ImageActive')
          $(this).addClass('ImageActive')
          switch (input) {
            case 'internal_notification'    : toggle('.imageDiv'); break;
          }
        })

        $('.sendToAllCheckBox').on('click', function (){
          $('.select2Filter').val(null).trigger("change");
        })

        $('.select2Filter').on('select2:select', function (){
          $('.sendToAllCheckBox').prop('checked' , false);
        })

        function toggle(className) {
          let random = Math.floor(Math.random() * animation.length);
          $('.usersDiv').hide()
          $('.delegatesDiv').hide()
          $('.sendToAllCheckBox').prop('checked' , false);
          $('.select2Filter').val(null).trigger("change");
          $(className).show()
          $(className).find('.select2Filter').select2({dir:dir});
          animateCSS(className, animation[random]);
        }

      })
    </script>
@endpush
