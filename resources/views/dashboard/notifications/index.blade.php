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
                            <div class="row">
                                <div class="col-4"><button data-input="users" class="btn btn-primary btn-block toggleUsers userActive">@lang('global.users')</button> </div>
                                <div class="col-4"><button data-input="delegates" class="btn btn-primary btn-block toggleUsers">@lang('global.delegates')</button> </div>
                                <div class="col-4"><button data-input="all" class="btn btn-primary btn-block toggleUsers">@lang('global.send_to_all')</button> </div>
                            </div>
                            <form class="form" action="{{ route('dashboard.notifications.store') }}" method="post" >
                                @csrf
                                <div class="custom-hr"><span> @lang('global.select_user_to_send_notification')</span></div>
                                <div class="row usersDiv">
                                    <div class="col-8 pr30px">
                                        <select class="form-control select2Filter usersSelect" name="user_id">
                                            <option value=""> @lang('global.select_user')</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}> {{ $user->name . '    ' . $user->mobile }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" class="sendToAllCheckBox" name="all_users" value="false">
                                            <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                            <span class="">@lang('global.send_to_all_users')</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: none" class="row delegatesDiv">
                                    <div class="col-8 pr30px">
                                        <select class="form-control select2Filter delegatesSelect" name="delegate_id">
                                            <option value=""> @lang('global.select_delegate')</option>
                                            @foreach($delegates as $delegate)
                                                <option value="{{ $delegate->id }}" {{ old('delegate_id') == $delegate->id ? 'selected' : '' }}> {{ $delegate->name . '  ---  ' . $delegate->mobile }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" class="sendToAllCheckBox" name="all_delegates" value="false">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">@lang('global.send_to_all_delegates')</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: none" class="row allDiv">
                                    <div class="col-4">
                                        <div class="vs-checkbox-con vs-checkbox-primary" >
                                            <input type="checkbox" class="sendToAllCheckBox" name="all" value="true" >
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">@lang('global.send_to_all')</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">

                                    <select class="form-control" id="replayType" name="type" required>
                                        <option value=""> @lang('global.select_type')</option>
                                        <option value="1" {{ old('type') == 1 ? 'selected' : '' }}> @lang('global.notification')</option>
                                        <option value="2" class="toggleImage ImageActive" {{ old('type') == 2 ? 'selected' : '' }}> @lang('global.sms')</option>
                                    </select>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <label>@lang('global.notification_title')</label>
                                        <input name="title" class="form-control" value="{{ old('title') }}" required>
                                        <small>@lang('global.max_100')</small>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('global.notification_body')</label>
                                        <textarea cols="12" rows="6" name="body" class="form-control" required>{{ old('body') }}</textarea>
                                        <small>@lang('global.max_length2048')<span id="bodyLength">2048</span></small>
                                    </div>
                                </div>
                                <div id="imgDiv" class="form-group ImageDiv toggleImage">
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
            case 'all'    : toggle('.allDiv'); break;
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
          $('.allDiv').hide()
          $('.sendToAllCheckBox').prop('checked' , false);
          $('.select2Filter').val(null).trigger("change");
          $(className).show()
          $(className).find('.select2Filter').select2({dir:dir});
          animateCSS(className, animation[random]);
        }

      })
    </script>
@endpush
