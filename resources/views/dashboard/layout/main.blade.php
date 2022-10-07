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
    <title>@lang('global.fetch')</title>
    <link rel="apple-touch-icon" href="{{ asset('/dashboard_assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/dashboard_assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-key" content="{{ config('services.maps.key') }}"/>


    <!-- BEGIN: Vendor CSS-->
    @if(in_array(app()->getLocale(), ['ar']))
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/vendors/css/vendors-rtl.min.css") }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/vendors/css/vendors.min.css") }}">
    @endif

    @if(in_array(app()->getLocale(), ['ar']))
    <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css-rtl/bootstrap.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css-rtl/bootstrap-extended.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css-rtl/colors.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css-rtl/components.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css-rtl/themes/dark-layout.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css-rtl/themes/semi-dark-layout.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css-rtl/core/menu/menu-types/vertical-menu.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css-rtl/core/colors/palette-gradient.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css-rtl/pages/dashboard-analytics.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css-rtl/pages/card-analytics.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/custom.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assets/css-rtl/plugins/file-uploaders/dropzone.css') }}">
        @stack('style_rtl')
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/bootstrap.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/bootstrap-extended.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/colors.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/components.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/themes/dark-layout.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/themes/semi-dark-layout.css") }}">

        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/core/menu/menu-types/vertical-menu.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/core/colors/palette-gradient.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/pages/dashboard-analytics.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/pages/card-analytics.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("dashboard_assets/css/custom.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assets/css/plugins/file-uploaders/dropzone.css') }}">
        @stack('style_ltr')
    @endif
    <link rel="stylesheet" typeof="text/css" href="{{ asset('dashboard_assets/css/auction-status.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assets/js/scripts/datetimepicker/build/jquery.datetimepicker.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assets/js/scripts/jquery-magnific-popup/magnific-popup.css') }}" >
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="{{ asset('dashboard_assets/css/fontawesome/css/all.css') }}"/>
    @stack('style')
    @stack('headerScript')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
<!-- BEGIN: Header-->
@include('dashboard.layout.partials._header')

<!-- END: Header-->

<!-- BEGIN: Main Menu-->
@include('dashboard.layout.sidebar.sidebar')
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        @yield('breadcrumbs')
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body" id="app">
            @include('flash::message')
            @include('dashboard.errors')
            @yield('content')
        </div>
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; {{ now()->year }}<a class="text-bold-800 grey darken-2" href="https://www.delitechno.com/en/" target="_blank">Deli Techno,</a>All rights Reserved</span>
        <span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i class="feather icon-heart pink"></i></span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
    </p>
</footer>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="/js/app.js"></script>

<script src="{{ asset('/dashboard_assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('/dashboard_assets/vendors/js/charts/apexcharts.min.js') }}"></script>
<script src="{{ asset('/dashboard_assets/vendors/js/extensions/tether.min.js') }}"></script>
<script src="{{ asset('/dashboard_assets/vendors/js/extensions/shepherd.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('/dashboard_assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('/dashboard_assets/js/core/app.js') }}"></script>
<script src="{{ asset('/dashboard_assets/js/scripts/components.js') }}"></script>
<script src="{{ asset("dashboard_assets/js/scripts/notify.min.js") }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset("dashboard_assets/js/scripts/jquery.toast.js") }}"></script>
<script src="{{ asset("dashboard_assets/js/scripts/sortable.min.js") }}"></script>
<script src="{{ asset('dashboard_assets/js/scripts/datetimepicker/build/jquery.datetimepicker.full.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/jquery.animateCSS.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/scripts/jquery-magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/browser-image-compression@1.0.13/dist/browser-image-compression.js"></script>

<!-- END: Theme JS-->

@stack('scripts')
<style>.tw-bg-gray-400{background-color:#cbd5e0!important}</style>
<!-- include libraries(jQuery, bootstrap) -->
{{--<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">--}}
{{--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>--}}

{{--<!-- include summernote css/js -->--}}
{{--<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">--}}
{{--<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>--}}
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote({
      height: 300,
      callbacks: {
        onImageUpload: function (files) {
          let data = new FormData();
          data.append("image", files[0]);
          $.ajax({
            data: data,
            type: 'POST',
            url: '/api/editor/upload',
            cache: false,
            contentType: false,
            processData: false,
            success: url => {
              let image = $('<img>').attr('src', url);
              $(this).summernote("insertNode", image[0]);
            }
          });
        }
      },
      placeholder: 'Start typing your text...',
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['ltr', 'rtl']],
        ['insert', ['link', 'picture', 'video', 'hr']],
        ['view', ['fullscreen', 'codeview']]
      ]
    });
  });
    $(function () {
        let dir = "rtl";
        $('.form').on('submit' , function () {
            $(this).find('button[type="submit"]').attr('disabled' , true);
            $('.saveBtn').attr('disabled' , true);
        });

        $('.citySelect').select2({
            dir: dir,
        });

        $('.select2Filter').select2({
            dir: dir,
        });


        let body = $('body');
        let sessionErrors = JSON.parse("{{ $errors }}".replace(/&quot;/g,'"'));
        let success =   parseInt("{{ session()->has('success') }}");
        let error   =   parseInt("{{ session()->has('error')}}");

        $.each(sessionErrors, function (key, value) {
            console.log(key , value);
            $("[name='"+key+"']").notify(value[0], 'error');
        })

        if(success) {
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: "{{ session()->get('success') }}",
                    animation: false,
                    customClass: 'animated swing',
                    showLoaderOnConfirm: true,
                    onClose: function(){
                        return delaySwalWithAnimation("fadeInUp","fadeOutUp");
                    },
                    preConfirm: function(){
                        return delaySwalWithAnimation("fadeInUp","fadeOutUp");
                    }
                })
            } , 300)
        }

        if(error) {
            setTimeout(() => {
                Swal.fire({
                    icon: 'error',
                    title: "{{ session()->get('error') }}",
                    confirmButtonText: "@lang('global.close')",
                    customClass: 'animated swing',
                    showLoaderOnConfirm: true,
                    onClose: function(){
                        return delaySwalWithAnimation("fadeInUp","fadeOutUp");
                    },
                    preConfirm: function(){
                        return delaySwalWithAnimation("fadeInUp","fadeOutUp");
                    }
                })
            } , 300)

        }

        $('.mpImage').magnificPopup({type:'image'});

        body.on('click', '.deleteBtn',function(e){
            e.preventDefault();
            let form = $(this).parents('form');
            Swal.fire({
                title: "@lang('global.are_you_sure')",
                text: "@lang('global.cannot_recovery')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('global.yes_deleted')",
                cancelButtonText: "@lang('global.no_cancel')",
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })
        });

        body.on('click', '.restoreBtn',function(e){
            e.preventDefault();
            let form = $(this).parents('form');
            Swal.fire({
                title: "@lang('global.are_you_sure')",
                text: "@lang('global.restore_data')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('global.yes_restore')",
                cancelButtonText: "@lang('global.no_cancel')",
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })
        });

        $('.toggleIsActive').on('click', function (evt) {
            evt.preventDefault();
            let id = $(this).data('id');
            let route   =   $(this).data('route');
            let message = $(this).data('message');
            let altMsg = $(this).data('alt-msg');
            Swal.fire({
                title: "@lang('global.are_you_sure')",
                text: message,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('global.yes_toggle_it')",
                cancelButtonText: "@lang('global.no_cancel')",
            }).then((result) => {
                if (result.value) {
                    $.Toast.showToast({
                        "title": "@lang('global.wait_to_proceed')",
                        "icon": "loading",
                        "duration" : -1,
                    });

                    $.ajax({
                        method : "post",
                        url :   route,
                        data    :   {_token:"{{ csrf_token() }}", id: id},
                        success : (response) => {
                            $.Toast.hideToast();
                            $.Toast.showToast({
                                "title": "@lang('global.toggle_done')",
                                "icon": "success",
                                "duration" : 1500,
                            });
                            if(response.is_active) {
                                $(this).removeClass('btn-success');
                                $(this).addClass('btn-dark');
                                $(this).find('i').removeClass('fa-thumbs-up');
                                $(this).find('i').addClass('fa-thumbs-down');
                                let i = $(this).closest('tr').find('.is_active').find('i');
                                i.removeClass('fa-times text-danger');
                                i.addClass('fa-check text-success');

                            } else {
                                $(this).removeClass('btn-dark');
                                $(this).addClass('btn-success');
                                $(this).find('i').removeClass('fa-thumbs-down');
                                $(this).find('i').addClass('fa-thumbs-up');
                                let i = $(this).closest('tr').find('.is_active').find('i');
                                i.addClass('fa-times text-danger');
                                i.removeClass('fa-check text-success');
                            }
                            $(this).data('message', altMsg);
                            $(this).data('alt-msg', message);
                        },
                        error: (response) => {
                            $.Toast.hideToast();
                            $.Toast.showToast({
                                "title": "@lang('global.failed_to_toggle')",
                                "icon": "error",
                                "duration" : 3000,
                            });
                        }
                    })
                }
            })
        });

        // if ('serviceWorker' in navigator) {
        //     navigator.serviceWorker.register('/serviceworke.js', {
        //         scope: '/'
        //     });
        // }

        $('.readNotification').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let id = $(this).data('id');
            Swal.fire({
                title: "@lang('global.are_you_sure')",
                text: "@lang('global.delete_notification')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('global.yes_deleted')",
                cancelButtonText: "@lang('global.no_cancel')",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        method: "post",
                        {{--url: "{{ route('markNotificationAsRead') }}",--}}
                        data: {_token:"{{ csrf_token() }}", id: id},
                        success: (response) => {
                            $(this).closest('.notificationContainer').remove();
                            $('.notiCount').html(response.count)
                        }
                    })
                }
            }).then(()=>{
                setTimeout(()=>{$('.uiNotification').dropdown('show');}, 400)
            })
        });

        $('body input[type="file"]').on('change', function (e){
            var pageURL = window.location.href;
            var lastURLSegment = pageURL.split('/');
            if (lastURLSegment[4] !== 'categories') {
                handleImageUpload(e);
            }
        });

        function delaySwalWithAnimation(animationA, animationB){
            return new Promise(function(resolve) {
                $(".swal2-popup").removeClass(animationA);
                $(".swal2-popup").addClass(animationB);
                setTimeout(function() {
                    resolve();
                },300);
            });
        }

        async function handleImageUpload(event) {
            let container = new DataTransfer();
            let images = Array.from(event.target.files)

            for (const imageFile of images) {
                // console.log('originalFile instanceof Blob', imageFile instanceof Blob); // true
                // console.log(`originalFile size ${imageFile.size / 1024 / 1024} MB`);

                const options = {
                    maxSizeMB: 1,
                    maxWidthOrHeight: 1920,
                    useWebWorker: true
                }
                try {
                    const compressedFile = await imageCompression(imageFile, options);
                    // console.log('compressedFile instanceof Blob', compressedFile instanceof Blob); // true
                    // console.log(`compressedFile size ${compressedFile.size / 1024 / 1024} MB`); // smaller than maxSizeMB

                    let file = new File([compressedFile], compressedFile.name)
                    container.items.add(file);
                } catch (error) {
                    console.log(error);
                }
            }

        event.target.files  =   container.files
        }

    })

    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    $('#flash-overlay-modal').modal();

</script>
@stack('scripts')
</body>
<!-- END: Body-->

</html>
