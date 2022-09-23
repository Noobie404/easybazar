<?php
    $roles     = userRolePermissionArray();
    $settings  = getWebSettings();
    $image_path = getImagePath();
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
    @include('seller.layout.includes.css')
    <style type="text/css">
#pre-loader {
    background-color: rgb(85, 83, 83);
    height: 100%;
    width: 100%;
    position: fixed;
    z-index: 1;
    margin-top: 0px;
    top: 0px;
    left: 0px;
    bottom: 0px;
    overflow: hidden !important;
    right: 0px;
    z-index: 999999;
}

#pre-loader img {
    text-align: center;
    left: 0;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    z-index: 99;
    margin: 0 auto;
}
    </style>



</head>
<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <div id="pre-loader">
        <img src="{{ asset('/assets/img/loader.gif') }}" alt="Loading...">
    </div>


<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        @include('seller.layout.top_nav')
    </div>
</nav>
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        @include('seller.layout.left_sidebar')
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
                @include('seller.layout.flash')
            </div>
        </div>
        @yield('content')
    </div>
</div>
@include('seller.layout.footer')
@include('seller.layout.includes.js')


</body>
</html>
