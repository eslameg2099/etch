
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>@lang('global.fetch_login_title')</title>
    <meta charset="utf-8">
    <!-- IE Compatibility Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- First Mobile Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="{{ asset("dashboard_assets/images/ico/apple-touch-icon.png") }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset("dashboard_assets/images/ico/favicon.ico") }}">
    <link href="https://fonts.googleapis.com/css?family=Changa:200,400,500,600,700&subset=arabic" rel="stylesheet">
    <link href="{{ asset("/dashboard_assets/css-rtl/bootstrap.min.css") }}" rel="stylesheet" />
    <link href="{{ asset('/dashboard_assets/css-rtl/login-page.css') }}" rel="stylesheet" />


</head>

<body>
<div class="overlay" style="    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    color: #FFF;
"></div>
<div class="container">
    <div class="headd">
        <div class="col-lg-12 col-xs-12 text-center logo" style="display:block; ">
            <a class="float-shadow" href="#" title="Mazadat">
                <img src="{{ asset('assets/images/ic_splash_logo.png') }}" title="Mazadat" style="margin-top: 40px ; opacity: 1" alt="Mazadat" class="img-responsive center-block" width="142" height="200" /></a>
        </div>
    </div>

    <div class="clearfix"></div>
    <h3 class="headline" style="position: relative">@lang('global.fetch_login_title')<span></span></h3>

    @if ($errors->has('mobile'))
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $errors->first('mobile') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="logg col-12 d-flex justify-content-center">
        <form class="form-group" method="post" action="{{ route('dashboard.login') }}"  >
            @csrf

            <input class="mobileInput" type="text" name="mobile" value="{{ old('mobile') }}"  placeholder="@lang('global.mobile')" autocomplete="off" autofocus style="text-align: center" required>

            <input type="password" name="password" required placeholder="@lang('global.password')" style="text-align: center">

            <input type="submit" value="@lang("global.login")">
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.1.18/jquery.backstretch.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script>
    $(document).ready (function(){
        $('body').on('keypress', '.mobileInput', function (evt) {
            let code = evt.keyCode || evt.which;
            return code > 47 && code < 58;
        })
        if("{{ $errors->has('mobile') }}")
        {
            $("#alert").hide();
            $("#alert").fadeTo(7000, 900).slideUp(900, function(){
                $("#alert").slideUp(900);
            });

        }
    });
    $('body').backstretch([
        "/dashboard_assets/images/backgrounds/bg.jpg",
    ], {
        fade: 800,
        duration: 5000
    });

</script>

</body>

</html>
