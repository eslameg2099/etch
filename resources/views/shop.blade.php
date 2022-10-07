<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <!-- Required Meta Tags -->
    <meta name="language" content="ar">
    <meta http-equiv="x-ua-compatible" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="google-key" content="{{ config('services.maps.key') }}"/>
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
        .map-search {
            bottom: -74px !important;
            height: 50px !important;
            width: 500px !important;
            position: relative !important;
            z-index: 1 !important;
            border: 1px solid #ccc !important;
            padding: 10px !important;
            outline: none !important;
            margin: 0 auto !important;
            background: #fff !important;
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
        <h2 style="text-align: center;"><b>انشاء متجر </b></h2>


        <!--  Form -->
        <form action="{{ route('shop.store') }}" class="form-ui large" method="post"
              enctype="multipart/form-data">

            @include('flash::message')

            @csrf


            <label class="{{ $errors->has('name') ? 'error' : '' }} ti-edit-pancel"> @lang('اسم المتجر')</label>
            <input type="text" placeholder="---" name="name" value="{{ old('name') }}"
                   class="{{ $errors->has('name') ? 'error' : '' }}">
            @if($errors->has('name'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('name') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif


            <label class="{{ $errors->has('description') ? 'error' : '' }} ti-edit-pancel"> @lang('وصف المتجر')</label>
            <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
            @if($errors->has('description'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('description') }}
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

            <label class="{{ $errors->has('category_id') ? 'error' : '' }} ti-edit-pancel"> @lang('القسم')</label>
            <select required name="category_id" class="{{ $errors->has('category_id') ? 'error' : '' }}">
                @foreach(App\Models\MasterData\Category::all() as $category)
                    <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @if($errors->has('category_id'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('category_id') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <label class="{{ $errors->has('open_at') ? 'error' : '' }} ti-edit-pancel"> @lang('وقت الفتح')</label>
            <input type="time" required placeholder="---" name="open_at" value="{{ old('open_at') }}"
                   class="{{ $errors->has('open_at') ? 'error' : '' }}">
            @if($errors->has('open_at'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('open_at') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <label class="{{ $errors->has('closed_at') ? 'error' : '' }} ti-edit-pancel"> @lang('وقت الغلق')</label>
            <input type="time" required placeholder="---" name="closed_at" value="{{ old('closed_at') }}"
                   class="{{ $errors->has('closed_at') ? 'error' : '' }}">
            @if($errors->has('closed_at'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('closed_at') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <label class="{{ $errors->has('except_days') ? 'error' : '' }} ti-edit-pancel"> @lang('الايام المستبعدة')</label>
            <input type="text" placeholder="---" name="except_days" value="{{ old('except_days') }}"
                   class="{{ $errors->has('except_days') ? 'error' : '' }}">
            @if($errors->has('except_days'))
                <span class="badge danger outline dismiss pointing-top">
                {{ $errors->first('except_days') }}
                <i class="ti-close remove-item"></i>
            </span>
            @endif

            <div>
                <label class="ti-edit-pancel"> @lang('عنوان المتجر')</label>
                <input type="text" readonly id="address" placeholder="---" name="address" value="">
            </div>

            <google-map-marker
                    :initial-lat-value="{{ $shop->lat ?? 24.700548606169395 }}"
                    :initial-lng-value="{{ $shop->lng ?? 46.64410303322909 }}"
                    :zoom="{{ isset($shop) ? 8 : 5 }}"
            ></google-map-marker>

            <div class="row" style="margin-top: 15px;">
                <div class="col col-md-6">
                    {{ BsForm::resource('shops')->image('image') }}
                </div>
                <div class="col col-md-6">
                    {{ BsForm::image('menu')->unlimited()->collection('menu') }}
                </div>
            </div>

            <input name="add_driver" type="submit" value="@lang('اضافة')" class="pro-btn btn primary large rounded">
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
        <a href="https://delitechno.com" class="dalel">تصميم و تطوير <img src="/frontend/img/cp.png" alt=""></a>
    </div>
</div>

<!-- Required JS Files -->
<script src="/js/app.js"></script>
</body>
</html>