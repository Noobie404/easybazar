<?php
$settings = \DB::table('WEB_SETTINGS')->first();
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Welcome to {{ $settings->SITE_NAME ?? 'DEMO WEBSITE' }}">
    <meta name="keywords" content="Welcome to {{ $settings->SITE_NAME ?? 'DEMO WEBSITE' }}">
    <meta name="author" content="PIXINVENT">
    <title> Login - Admin Panel - {{ $settings->SITE_NAME ?? 'DEMO WEBSITE' }}</title>
    <link rel="apple-touch-icon" href="{{ asset($settings->FAVICON_APPLE ?? '') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($settings->FAVICON ?? '') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/components.css')}}">
</head>

<body class="vertical-layout vertical-menu-modern 1-column bg-full-screen-image  bg-cyan bg-lighten-2 blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 m-0">
                            <div class="card-header border-0">
                                <div class="card-title text-center">
                                    <div class="p-1"><img src="{{ asset($settings->LOGIN_LOGO ?? '') }}" alt="{{ $settings->SITE_NAME ?? 'DEMO WEBSITE' }}" style="width: 200px;"></div>
                                </div>
                                {{-- @include('admin.layout.flash') --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <div>
                                            @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <form class="form-horizontal" method="post" action="{{ url('admin') }}">                                @csrf
                                        <input type="hidden" value="{{ request()->get('user') ?? '' }}" name="user_type" >
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="user-email">Email</label>
                                            <input type="email" class="form-control" name="email" placeholder="Your email" value="admin@easybazar.com">
                                        </fieldset>
                                        <fieldset class="form-group floating-label-form-group mb-1">
                                            <label for="user-password">Enter password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Enter password">
                                        </fieldset>
                                        <button type="submit" class="btn btn-info btn-block"><i class="ft-unlock"></i> Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<script src="{{asset('assets/vendors/js/vendors.js')}}"></script>
</body>
</html>
