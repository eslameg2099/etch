<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Mazadat">
    <meta name="keywords" content="Mazadat">
    <meta name="author" content="PIXINVENT">
    <title>@lang('global.mazadat')</title>
    <link rel="apple-touch-icon" href="{{ asset('/dashboard/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/dashboard/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    @if(in_array(app()->getLocale(), ['ar']))
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/vendors/css/vendors-rtl.min.css") }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/vendors/css/vendors.min.css") }}">
    @endif

    @if(in_array(app()->getLocale(), ['ar']))
    <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css-rtl/bootstrap.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css-rtl/bootstrap-extended.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css-rtl/colors.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css-rtl/components.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css-rtl/themes/dark-layout.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css-rtl/themes/semi-dark-layout.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css-rtl/core/menu/menu-types/vertical-menu.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css-rtl/core/colors/palette-gradient.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css-rtl/pages/dashboard-analytics.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css-rtl/pages/card-analytics.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css-rtl/plugins/forms/validation/form-validation.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/custom.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css-rtl/plugins/file-uploaders/dropzone.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css-rtl/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css-rtl/pages/app-chat.css') }}">
        @stack('style_rtl')
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/bootstrap.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/bootstrap-extended.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/colors.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/components.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/themes/dark-layout.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/themes/semi-dark-layout.css") }}">

        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/core/menu/menu-types/vertical-menu.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/core/colors/palette-gradient.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/pages/dashboard-analytics.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/pages/card-analytics.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard/css/custom.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/file-uploaders/dropzone.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/core/menu/menu-types/vertical-menu.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/pages/app-chat.css') }}">
        @stack('style_ltr')
    @endif
    <link rel="stylesheet" typeof="text/css" href="{{ asset('dashboard/css/auction-status.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/js/scripts/datetimepicker/build/jquery.datetimepicker.min.css') }}" >
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- BEGIN: Page CSS-->
    <!-- END: Page CSS-->
    @stack('style')
    @stack('headerScript')
</head>

<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout content-left-sidebar chat-application navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar" data-layout="semi-dark-layout">
@include('dashboard.layout.partials._header')
<ul class="main-search-list-defaultlist d-none">
    <li class="d-flex align-items-center"><a class="pb-25" href="#">
            <h6 class="text-primary mb-0">Files</h6>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
            <div class="d-flex">
                <div class="mr-50"><img src="{{ asset('/dashboard/images/icons/xls.png') }}" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing Manager</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
            <div class="d-flex">
                <div class="mr-50"><img src="{{ asset('/dashboard/images/icons/jpg.png') }}" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd Developer</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
            <div class="d-flex">
                <div class="mr-50"><img src="{{ asset('/dashboard/images/icons/pdf.png') }}" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital Marketing Manager</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
            <div class="d-flex">
                <div class="mr-50"><img src="{{ asset('/dashboard/images/icons/doc.png') }}" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web Designer</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
        </a></li>
    <li class="d-flex align-items-center"><a class="pb-25" href="#">
            <h6 class="text-primary mb-0">Members</h6>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
            <div class="d-flex align-items-center">
                <div class="avatar mr-50"><img src="{{ asset('/dashboard/images/portrait/small/avatar-s-8.jpg') }}" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
            <div class="d-flex align-items-center">
                <div class="avatar mr-50"><img src="{{ asset('/dashboard/images/portrait/small/avatar-s-1.jpg') }}" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd Developer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
            <div class="d-flex align-items-center">
                <div class="avatar mr-50"><img src="{{ asset('/dashboard/images/portrait/small/avatar-s-14.jpg') }}" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing Manager</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
            <div class="d-flex align-items-center">
                <div class="avatar mr-50"><img src="{{ asset('/dashboard/images/portrait/small/avatar-s-6.jpg') }}" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
                </div>
            </div>
        </a></li>
</ul>
<ul class="main-search-list-defaultlist-other-list d-none">
    <li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100 py-50">
            <div class="d-flex justify-content-start"><span class="mr-75 feather icon-alert-circle"></span><span>No results found.</span></div>
        </a></li>
</ul>
@include('dashboard.layout.sidebar.sidebar')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    @yield('content')
</div>
<!-- END: Content-->

<!-- BEGIN: Vendor JS-->
<script src="{{ asset('dashboard/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('dashboard/js/core/app-menu.js') }}"></script>
<script src="{{ asset('dashboard/js/core/app.js') }}"></script>
<script src="{{ asset('dashboard/js/scripts/components.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('dashboard/js/scripts/pages/app-chat.js') }}"></script>
<!-- END: Page JS-->
@stack('scripts')
</body>
<!-- END: Body-->

</html>
