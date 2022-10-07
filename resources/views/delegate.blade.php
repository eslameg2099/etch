<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <!-- Required Meta Tags -->
    <meta name="language" content="ar">
    <meta http-equiv="x-ua-compatible" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>@lang('global.fetch')</title>
    <!-- Open Graph Meta Tags -->
    <meta property="og:image" content="/frontend/img/logo-black.png"/>
    <meta name="twitter:image" content="/frontend/img/logo-black.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Other Meta Tags -->
    <meta name="robots" content="index, follow"/>
    <link rel="shortcut icon" type="image/png" href="/frontend/img/logo-black.png">
    <!-- Required CSS Files -->
    <link href="/frontend/css/tornado-icons.css" rel="stylesheet"/>
    <link href="/frontend/css/tornado-rtl.css" rel="stylesheet"/>
    <style>
        .copyrights {
            background-color: #343a40;
        }

        .about-logo {
            border-radius: 50%;
        }
        .uploader-hidden {
            display: none !important;
        }
    </style>
</head>
<body>

<!-- Page Content -->
<div class="section container-xl" id="app">
    <!-- About Logo -->
    <img src="/frontend/img/logo-black.png" alt="" class="about-logo">
    <!-- About -->

    <!-- // About -->

    <!-- Rich Content -->
    <div class="rich-content">

        <h2><b> </b></h2>
        <h1 style="text-align: center;"><b>مرحباً بكم في تطبيق فيتش </b></h1>
        <span style="font-weight: 400;"> </span>
        <h2 style="text-align: center;"><b>تسجيل عضوية مندوب </b></h2>


        <!--  Form -->
        <form action="{{ route('delegate.register') }}" class="form-ui large" method="post"
              enctype="multipart/form-data">

            @include('flash::message')

            @csrf


            <label class="{{ $errors->has('name') ? 'error' : '' }} ti-edit-pancel"> @lang('الاسم')</label>
            <input type="text" placeholder="---" name="name" value="{{ old('name') }}"
                   class="{{ $errors->has('name') ? 'error' : '' }}">
            @if($errors->has('name'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('name') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif


            <label class="{{ $errors->has('mobile') ? 'error' : '' }} ti-phone"> @lang('رقم الجوال')</label>
            <input type="tel" placeholder="---" name="mobile" value="{{ old('mobile') }}"
                   class="{{ $errors->has('mobile') ? 'error' : '' }}">
            @if($errors->has('mobile'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('mobile') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <label class="{{ $errors->has('city_id') ? 'error' : '' }} ti-map-marker"> @lang('المدينة')</label>
            <select required name="city_id" class="{{ $errors->has('city_id') ? 'error' : '' }}">
                @foreach(App\Models\MasterData\City::all() as $city)
                    <option {{ old('city_id') == $city->id ? 'selected' : '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
            @if($errors->has('city_id'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('city_id') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <label class="{{ $errors->has('delegate.national_id') ? 'error' : '' }} ti-edit-pancel"> @lang('رقم الهوية')</label>
            <input type="text" required placeholder="---" name="delegate[national_id]" value="{{ old('delegate.national_id') }}"
                   class="{{ $errors->has('delegate.national_id') ? 'error' : '' }}">
            @if($errors->has('delegate.national_id'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('delegate.national_id') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <label class="{{ $errors->has('delegate.vehicle_type') ? 'error' : '' }} ti-edit-pancel"> @lang('نوع المركبة')</label>
            <input type="text" required placeholder="---" name="delegate[vehicle_type]" value="{{ old('delegate.vehicle_type') }}"
                   class="{{ $errors->has('delegate.vehicle_type') ? 'error' : '' }}">
            @if($errors->has('vehicle_type'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('delegate.vehicle_type') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <label class="{{ $errors->has('delegate.vehicle_model') ? 'error' : '' }} ti-edit-pancel"> @lang('موديل المركبة')</label>
            <input type="text" required placeholder="---" name="delegate[vehicle_model]" value="{{ old('delegate.vehicle_model') }}"
                   class="{{ $errors->has('delegate.vehicle_model') ? 'error' : '' }}">
            @if($errors->has('delegate.vehicle_model'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('delegate.vehicle_model') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <label class="{{ $errors->has('delegate.vehicle_number') ? 'error' : '' }} ti-edit-pancel">
                @lang('لوحة المركبة')</label>
            <input type="text" required placeholder="---" name="delegate[vehicle_number]" value="{{ old('delegate.vehicle_number') }}"
                   class="{{ $errors->has('delegate.vehicle_number') ? 'error' : '' }}">
            @if($errors->has('delegate.vehicle_number'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('delegate.vehicle_number') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <label class="{{ $errors->has('password') ? 'error' : '' }} ti-edit-pancel"> @lang('كلمة المرور')</label>
            <input type="password" required placeholder="---" name="password" value="{{ old('password') }}"
                   class="{{ $errors->has('password') ? 'error' : '' }}">
            @if($errors->has('password'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('password') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <label class="{{ $errors->has('password_confirmation') ? 'error' : '' }} ti-edit-pancel"> @lang('تأكيد كلمة المرور')</label>
            <input type="password" required placeholder="---" name="password_confirmation" value="{{ old('password_confirmation') }}"
                   class="{{ $errors->has('password_confirmation') ? 'error' : '' }}">
            @if($errors->has('password_confirmation'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('password_confirmation') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif
            <div class="row">
                <div class="col col-md-4">
                    {{ BsForm::image('national_id_front_image')
                        ->maxWidth(500)
                        ->maxHeight(500)
                        ->collection('national_id_front_image')
                        ->label(trans('delegates.attributes.delegate.national_id_front_image')) }}
                </div>
                <div class="col col-md-4">
                    {{ BsForm::image('national_id_back_image')
                        ->maxWidth(500)
                        ->maxHeight(500)
                        ->collection('national_id_back_image')
                        ->label(trans('delegates.attributes.delegate.national_id_back_image')) }}
                </div>
                <div class="col col-md-4">
                    {{ BsForm::image('vehicle_number_image')
                        ->maxWidth(500)
                        ->maxHeight(500)
                        ->collection('vehicle_number_image')
                        ->label(trans('delegates.attributes.delegate.vehicle_number_image')) }}
                </div>
            </div>

            <input name="add_driver" type="submit" value="@lang('تسجيل')" class="pro-btn btn primary large rounded">
        </form>
        <!-- // Form -->


        <h2 style="text-align: center;"><b>معلومات الاتصال</b></h2>
        <span style="font-weight: 400;">إذا كان لديكم أي أسئلة حول هذه السياسة، يمكنكم التواصل عبر البريد الإلكتروني</span><a
                href="mailto:fetchsaudi@gmail.com"><span style="font-weight: 400;">fetchsaudi@gmail.com</span></a><span
                style="font-weight: 400;"> أو الاتصال على هاتف رقم  <a href="tel:+966920024282">920024282</a></span>

        <span style="font-weight: 400;">جميع الحقوق محفوظة © </span><b>فيتش 2021</b>

        <b> </b>
        <h2 dir="RTL" style="text-align: center;"></h2>

    </div>
    <!-- // Rich Content -->
</div>
<!-- // Page Content -->
<!-- Main Footer -->

<!-- Copyrights -->
<div class="copyrights">
    <div class="container-xl">
        <p>كل الحقوق محفوظة لتطبيق فيتش 2021 </p>
        <a href="https://www.delitechno.com/%D8%A8%D8%B1%D9%85%D8%AC%D8%A9-%D9%88%D8%AA%D8%B5%D9%85%D9%8A%D9%85-%D8%AA%D8%B7%D8%A8%D9%8A%D9%82-%D9%85%D8%AA%D8%AC%D8%B1-%D8%A5%D9%84%D9%83%D8%AA%D8%B1%D9%88%D9%86%D9%8A-%D8%A3%D9%8A%D9%81%D9%88/" class="dalel">تصميم و تطوير <img src="/frontend/img/cp.png" alt=""></a>
    </div>
</div>

<!-- Required JS Files -->
<script src="/frontend/js/tornado.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-file-uploader@2.3.0"></script>
<script>
  new Vue({
    el: '#app',
    data() {
      return {
        tokens: []
      }
    },
  })
</script>
</body>
</html>