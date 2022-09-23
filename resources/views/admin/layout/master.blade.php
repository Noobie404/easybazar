<?php
    $roles     = userRolePermissionArray();
    $settings  = getWebSettings();
    // $image_path = getImagePath();

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" href="{{ asset($settings->FAVICON_APPLE ?? '') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($settings->FAVICON ?? '') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
    <input type="hidden" name="base_url" id="base_url" value="{{url('/')}}">
    @include('admin.layout.includes.css')
</head>
<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        @include('admin.layout.top_nav')
    </div>
</nav>
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        @include('admin.layout.left_sidebar')
    </div>
</div>
<!-- END: Main Menu-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">@yield('page-name')</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('admin.layout.flash')
            </div>
        </div>
        @yield('content')
    </div>
</div>
@include('admin.layout.footer')
@include('admin.layout.includes.js')

<script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-messaging.js"></script>
<script>
    window.addEventListener( "pageshow", function ( event ) {
          var historyTraversal = event.persisted ||
          ( typeof window.performance != "undefined" &&
          window.performance.navigation.type === 2 );
          if ( historyTraversal ) {
          window.location.reload();
          }
      });
var firebaseConfig = {
    apiKey: 'AIzaSyCilxecJyIX0bIQvKmg2X6OOs63t_eedDU',
    authDomain: 'easydelivery-7810d.firebaseapp.com',
    databaseURL: 'https://azuramart-df8b6.firebaseio.com',
    projectId: 'asydelivery-7810d',
    storageBucket: 'easydelivery-7810d.appspot.com',
    messagingSenderId: '48539565433',
    appId: '1:48539565433:web:1b2fb42639f1f86c6e03a8',
    measurementId: 'G-84B58SC1M6',
};
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
  var get_url = $('#base_url').val();
        messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function(token) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
             });
            $.ajax({
                url:get_url+'/notification/save-token',
                type: 'POST',
                data: {
                    token: token
                },
                dataType: 'JSON',
                success: function (response) {
                },
                error: function (err) {
                    console.log('User Chat Token Error'+ err);
                },
            });
        }).catch(function (err) {
            console.log('User Chat Token Error'+ err);
        });
    messaging.onMessage(function(payload) {
    const noteTitle = payload.notification.title;
    const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
});

</script>

{{-- <script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.9.4/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.9.4/firebase-analytics.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
      apiKey: "AIzaSyCilxecJyIX0bIQvKmg2X6OOs63t_eedDU",
      authDomain: "easydelivery-7810d.firebaseapp.com",
      projectId: "easydelivery-7810d",
      storageBucket: "easydelivery-7810d.appspot.com",
      messagingSenderId: "48539565433",
      appId: "1:48539565433:web:1b2fb42639f1f86c6e03a8",
      measurementId: "G-84B58SC1M6"
    };
    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
  </script> --}}

{!! Toastr::message() !!}
</body>
</html>
