@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}">
@endpush('custom_css')
@section('web','open')
@section('settings','active')
@section('title') Settings @endsection
@section('page-name') Create Settings @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Settings</a></li>
<li class="breadcrumb-item active">Settings</li>
@endsection
<?php
$row = $data['settings'] ?? [];
?>
@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                <div class="card-content">
                    <div class="card-body">
                                {!! Form::open([ 'route' => ['web.home.settings.store'], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                @csrf
                                @if(!empty($row->PK_NO))
                                {!! Form::hidden('id', $row->PK_NO) !!}
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header border-bottom"><h5>Info</h5></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group {!! $errors->has('title') ? 'error' : '' !!}">
                                                            <label>Title</label>
                                                            <div class="controls">
                                                                {!! Form::text('title', $row->TITLE ?? NULL, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter title', 'tabindex' => 1]) !!}
                                                                {!! $errors->first('title', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group {!! $errors->has('description') ? 'error' : '' !!}">
                                                            <label>Description</label>
                                                            <div class="controls">
                                                                {!! Form::textarea('description', $row->DESCRIPTION ?? NULL, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter description', 'tabindex' => 2,'cols'=>3,'rows'=>3]) !!}
                                                                {!! $errors->first('description', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('phone_1') ? 'error' : '' !!}">
                                                            <label>Phone No 1</label>
                                                            <div class="controls">
                                                                {!! Form::text('phone_1', $row->PHONE_1 ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter phone', 'tabindex' => 3]) !!}
                                                                {!! $errors->first('phone_1', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('phone_2') ? 'error' : '' !!}">
                                                            <label>Phone No 2</label>
                                                            <div class="controls">
                                                                {!! Form::text('phone_2', $row->PHONE_2 ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter phone', 'tabindex' => 4]) !!}
                                                                {!! $errors->first('phone_1', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('email_1') ? 'error' : '' !!}">
                                                            <label>Email 1</label>
                                                            <div class="controls">
                                                                {!! Form::email('email_1', $row->EMAIL_1 ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter email address', 'tabindex' => 5]) !!}
                                                                {!! $errors->first('email_1', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('email_2') ? 'error' : '' !!}">
                                                            <label>Email 2</label>
                                                            <div class="controls">
                                                                {!! Form::email('email_2', $row->EMAIL_2 ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter email address', 'tabindex' => 6]) !!}
                                                                {!! $errors->first('email_2', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('web_url') ? 'error' : '' !!}">
                                                            <label>Web URL</label>
                                                            <div class="controls">
                                                                {!! Form::url('web_url', $row->URL ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter web url', 'tabindex' => 7]) !!}
                                                                {!! $errors->first('web_url', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('address') ? 'error' : '' !!}">
                                                            <label>Address</label>
                                                            <div class="controls">
                                                                {!! Form::textarea('address', $row->HQ_ADDRESS ?? NULL, [ 'class' => 'form-control', 'placeholder' => 'Enter address', 'tabindex' => 8,'cols'=>3,'rows'=>3,'id'=>'address']) !!}
                                                                {!! $errors->first('address', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('max_login_attempt') ? 'error' : '' !!}">
                                                            <label>Maximum login attempt</label>
                                                            <div class="controls">
                                                                {!! Form::url('max_login_attempt', $row->MAX_LOGIN_ATTEMPT ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter max no of attempts', 'tabindex' => 7]) !!}
                                                                {!! $errors->first('max_login_attempt', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('android_app_link') ? 'error' : '' !!}">
                                                            <label>Android App Link</label>
                                                            <div class="controls">
                                                                {!! Form::url('android_app_link', $row->ANDROID_APP_LINK ?? NULL, [ 'class' => 'form-control mb-1',  'placeholder' => 'Android app link', 'tabindex' => 9]) !!}
                                                                {!! $errors->first('android_app_link', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('android_app_version') ? 'error' : '' !!}">
                                                            <label>Android App Version</label>
                                                            <div class="controls">
                                                                {!! Form::text('android_app_version', $row->ANDROID_APP_VERSION ?? NULL, [ 'class' => 'form-control mb-1',  'placeholder' => 'Android app version', 'tabindex' => 10]) !!}
                                                                {!! $errors->first('android_app_version', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('android_version_name') ? 'error' : '' !!}">
                                                            <label>App Version Name</label>
                                                            <div class="controls">
                                                                {!! Form::text('android_version_name', $row->ANDROID_VERSION_NAME ?? NULL, [ 'class' => 'form-control mb-1',  'placeholder' => 'Android version name', 'tabindex' => 10]) !!}
                                                                {!! $errors->first('android_version_name', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('iphone_app_link') ? 'error' : '' !!}">
                                                            <label>Ios App Link</label>
                                                            <div class="controls">
                                                                {!! Form::url('iphone_app_link', $row->IPHONE_APP_LINK ?? NULL, [ 'class' => 'form-control mb-1',  'placeholder' => 'Ios app link', 'tabindex' => 11]) !!}
                                                                {!! $errors->first('iphone_app_link', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('iphone_app_version') ? 'error' : '' !!}">
                                                            <label>Ios App Version</label>
                                                            <div class="controls">
                                                                {!! Form::text('iphone_app_version', $row->IPHONE_APP_VERSION ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Ios app version', 'tabindex' => 12]) !!}
                                                                {!! $errors->first('iphone_app_version', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('iphone_version_name') ? 'error' : '' !!}">
                                                            <label>Ios Version Name</label>
                                                            <div class="controls">
                                                                {!! Form::text('iphone_version_name', $row->IPHONE_VERSION_NAME ?? NULL, [ 'class' => 'form-control mb-1',  'placeholder' => 'Ios version name', 'tabindex' => 10]) !!}
                                                                {!! $errors->first('iphone_version_name', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('app_update_mandatory') ? 'error' : '' !!}">
                                                            <label>App Update Mandatory ?</label>
                                                            <div class="controls">
                                                                {!! Form::select('app_update_mandatory', ['1'=>'Yes','0'=>'No'], $row->APP_UPDATE_MANDATORY, ['class'=>'form-control mb-1', 'id' => 'app_update_mandatory','placeholder' => 'Select ', 'tabindex' => 1]) !!}
                                                                {!! $errors->first('app_update_mandatory', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header border-bottom"><h5>Social</h5></div>
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('facebook') ? 'error' : '' !!}">
                                                            <label>Facebook</label>
                                                            <div class="controls">
                                                                {!! Form::url('facebook', $row->FACEBOOK_URL ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter facebook url', 'tabindex' => 13]) !!}
                                                                {!! $errors->first('facebook', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('twitter') ? 'error' : '' !!}">
                                                            <label>Twitter</label>
                                                            <div class="controls">
                                                                {!! Form::url('twitter', $row->TWITTER_URL ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter twitter url', 'tabindex' => 14]) !!}
                                                                {!! $errors->first('twitter', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('instagram') ? 'error' : '' !!}">
                                                            <label>Instagram</label>
                                                            <div class="controls">
                                                                {!! Form::url('instagram', $row->INSTAGRAM_URL ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter instagram url', 'tabindex' => 15]) !!}
                                                                {!! $errors->first('instagram', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('youtube') ? 'error' : '' !!}">
                                                            <label>Youtube</label>
                                                            <div class="controls">
                                                                {!! Form::url('youtube', $row->YOUTUBE_URL ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter youtube url', 'tabindex' => 16]) !!}
                                                                {!! $errors->first('youtube', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('pinterest') ? 'error' : '' !!}">
                                                            <label>Pinterest</label>
                                                            <div class="controls">
                                                                {!! Form::url('pinterest', $row->PINTEREST_URL ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter pinterest id', 'tabindex' => 17]) !!}
                                                                {!! $errors->first('pinterest', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('whats_app') ? 'error' : '' !!}">
                                                            <label>Whats App</label>
                                                            <div class="controls">
                                                                {!! Form::url('whats_app', $row->WHATS_APP ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter whats app id', 'tabindex' => 18]) !!}
                                                                {!! $errors->first('whats_app', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('facebook_app') ? 'error' : '' !!}">
                                                            <label>Facebook App</label>
                                                            <div class="controls">
                                                                {!! Form::text('facebook_app', $row->FB_APP_ID ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter facebook app id', 'tabindex' => 19]) !!}
                                                                {!! $errors->first('facebook_app', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('facebook_app_secret') ? 'error' : '' !!}">
                                                            <label>Facebook App Secret</label>
                                                            <div class="controls">
                                                                {!! Form::text('facebook_app_secret', $row->FACEBOOK_SECRET_ID ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter facebook app secret', 'tabindex' => 20]) !!}
                                                                {!! $errors->first('facebook_app_secret', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('analytic_id') ? 'error' : '' !!}">
                                                            <label>Google Analytic Id</label>
                                                            <div class="controls">
                                                                {!! Form::text('analytic_id', $row->ANALYTIC_ID ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter google analytic', 'tabindex' => 21]) !!}
                                                                {!! $errors->first('analytic_id', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('google_app') ? 'error' : '' !!}">
                                                            <label for="google_app">Google App Id </label>
                                                            <div class="controls">
                                                                {!! Form::text('google_app', $row->GOOGLE_APP_ID ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter google app id', 'tabindex' => 22]) !!}
                                                                {!! $errors->first('google_app', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('google_app_secret') ? 'error' : '' !!}">
                                                            <label for="google_app">Google App Secret </label>
                                                            <div class="controls">
                                                                {!! Form::text('google_app_secret', $row->GOOGLE_CLIENT_SECRET ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter google app secret', 'tabindex' => 23]) !!}
                                                                {!! $errors->first('google_app_secret', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('latitute') ? 'error' : '' !!}">
                                                            <label for="latitute">Latitute </label>
                                                            <div class="controls">
                                                                {!! Form::text('latitute', $row->LATITUDE ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter Latitute', 'tabindex' => 23]) !!}
                                                                {!! $errors->first('latitute', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('longitute') ? 'error' : '' !!}">
                                                            <label for="longitute">Longitute </label>
                                                            <div class="controls">
                                                                {!! Form::text('longitute', $row->LONGITUDE ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter Longitute', 'tabindex' => 23]) !!}
                                                                {!! $errors->first('longitute', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group {!! $errors->has('google_map') ? 'error' : '' !!}">
                                                            <label>Google Map <small class="text-danger"> Embed html code from google map  <a href="https://www.google.com/maps" target="_blank"><i class="la la-map-marker" aria-hidden="true"></i>
                                                            </a></small></label>
                                                            <div class="controls">
                                                                {!! Form::textarea('google_map', $row->GOOGLE_MAP ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter google map', 'tabindex' => 24,'rows'=>3]) !!}
                                                                {!! $errors->first('google_map', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="border-bottom">Instagram Feed Config</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('insta_user_1') ? 'error' : '' !!}">
                                            <label>Instagram username (Fashion & Accessories
                                                )</label>
                                            <div class="controls">
                                                {!! Form::text('insta_user_1', $row->INSTA_USERNAME_1 ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter instagram user name', 'tabindex' => 25]) !!}
                                                {!! $errors->first('insta_user_1', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('access_token_1') ? 'error' : '' !!}">
                                            <label>Access Token(Fashion & Accessories)</label>
                                            <div class="controls">
                                                {!! Form::textarea('access_token_1', $row->INSTA_TOKEN_1 ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter access token', 'tabindex' => 27,'rows'=>3]) !!}
                                                {!! $errors->first('access_token_1', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('insta_user_2') ? 'error' : '' !!}">
                                            <label>Instagram username (Home & Kitchen
                                                )</label>
                                            <div class="controls">
                                                {!! Form::text('insta_user_2', $row->INSTA_USERNAME_2 ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter instagram user name', 'tabindex' => 25]) !!}
                                                {!! $errors->first('insta_user_2', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('access_token_2') ? 'error' : '' !!}">
                                            <label>Access Token(Home & Kitchen)</label>
                                            <div class="controls">
                                                {!! Form::textarea('access_token_2', $row->INSTA_TOKEN_2 ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter access token', 'tabindex' => 27,'rows'=>3]) !!}
                                                {!! $errors->first('access_token_2', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div><div class="col-md-6">
                                        <div class="form-group {!! $errors->has('insta_user_3') ? 'error' : '' !!}">
                                            <label>Instagram username (Customer Reviews)</label>
                                            <div class="controls">
                                                {!! Form::text('insta_user_3', $row->INSTA_USERNAME_3 ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter instagram user name', 'tabindex' => 25]) !!}
                                                {!! $errors->first('insta_user_3', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('access_token_3') ? 'error' : '' !!}">
                                            <label>Access Token(Customer Reviews)</label>
                                            <div class="controls">
                                                {!! Form::textarea('access_token_3', $row->INSTA_TOKEN_3 ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter access token', 'tabindex' => 27,'rows'=>3]) !!}
                                                {!! $errors->first('access_token_3', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="border-bottom">SEO Meta</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('meta_title') ? 'error' : '' !!}">
                                            <label>Meta Title <small class="text-danger"> recommends keeping your titles under 60 characters.</small></label>
                                            <div class="controls">
                                                {!! Form::text('meta_title', $row->META_TITLE ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter meta title', 'tabindex' => 25]) !!}
                                                {!! $errors->first('meta_title', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('meta_keywards') ? 'error' : '' !!}">
                                            <label>Meta Keywards <small class="text-danger"> recommend keywards between 1–10.</small></label>
                                            <div class="controls">
                                                {!! Form::text('meta_keywards', $row->META_KEYWARDS ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter meta keywards', 'tabindex' => 26]) !!}
                                                {!! $errors->first('meta_keywards', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('meta_description') ? 'error' : '' !!}">
                                            <label>Meta Description <small class="text-danger"> recommend descriptions between 50–160 characters.</small></label>
                                            <div class="controls">
                                                {!! Form::textarea('meta_description', $row->META_DESCRIPTION ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter meta description', 'tabindex' => 27,'rows'=>3]) !!}
                                                {!! $errors->first('meta_description', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('copyright') ? 'error' : '' !!}">
                                            <label>Copyright Text</label>
                                            <div class="controls">
                                                {!! Form::textarea('copyright', $row->COPYRIGHT_TEXT ?? NULL, [ 'class' => 'form-control',  'placeholder' => 'Enter copyright text', 'tabindex' => 27,'rows'=>3]) !!}
                                                {!! $errors->first('copyright', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group {!! $errors->has('style') ? 'error' : '' !!}">
                                            <label>Custom Style</label>
                                            <div class="controls">
                                            <textarea name="style" id="style" cols="30" rows="25" class="form-control">{{ $row->STYLE ?? NULL }}</textarea>
                                                {!! $errors->first('style', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Custom Style</label>
                                            <div class="controls">
                                            <textarea  cols="30" rows="25" class="form-control" readonly>{{ $row->INIT_STYLE ?? NULL }}</textarea>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group {!! $errors->has('shipping_return') ? 'error' : '' !!}">
                                            <label>Shipping & Returns</label>
                                            <div class="controls">
                                                {!! Form::textarea('shipping_return', $row->SHIPPING_RETURN ?? NULL, [ 'class' => 'form-control summernote',  'placeholder' => 'Enter Shipping & Return', 'tabindex' => 27,'rows'=>3]) !!}
                                                {!! $errors->first('copyright', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('meta_image') ? 'error' : '' !!}">
                                            <label class="active">Meta Image</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->META_IMAGE))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->META_IMAGE))
                                                <img src="{{asset($row->META_IMAGE)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('meta_image', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 28]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>

                                                <br>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i> {{trans('form.image_size')}} 1200 x 630 pixels max & min 600 x 315 pixels</span>
                                             </div>
                                                 {!! $errors->first('meta_image', '<label class="help-block text-danger">:message</label>') !!}
                                                </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="border-bottom py-2 section-title">Logos</h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('header_logo') ? 'error' : '' !!}">
                                            <label class="active" for="header_logo"> Header logo</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->HEADER_LOGO))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->HEADER_LOGO))
                                                <img src="{{asset($row->HEADER_LOGO)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('header_logo', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 29]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 200 x 82 pixels</span>
                                             </div>
                                                 {!! $errors->first('header_logo', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('footer_logo') ? 'error' : '' !!}">
                                            <label class="active" for="footer_logo"> Footer Logo</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->FOOTER_LOGO))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->FOOTER_LOGO))
                                                <img src="{{asset($row->FOOTER_LOGO)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('footer_logo', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 30]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 200 x 82 pixels</span>
                                             </div>
                                                 {!! $errors->first('footer_logo', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('app_logo') ? 'error' : '' !!}">
                                            <label class="active" for="app_logo"> App Logo</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->APP_LOGO))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->APP_LOGO))
                                                <img src="{{asset($row->APP_LOGO)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('app_logo', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 31]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                             </div>
                                                 {!! $errors->first('app_logo', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group  {!! $errors->has('email_header_logo') ? 'error' : '' !!}">
                                            <label class="active" for="email_header_logo"> Email Header Logo</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->EMAIL_HEADER_LOGO))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->EMAIL_HEADER_LOGO))
                                                <img src="{{asset($row->EMAIL_HEADER_LOGO)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('email_header_logo', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                             </div>
                                                 {!! $errors->first('email_header_logo', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group  {!! $errors->has('email_footer_logo') ? 'error' : '' !!}">
                                            <label class="active" for="email_footer_logo"> Email Footer Logo</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->EMAIL_FOOTER_LOGO))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail bg-dark" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->EMAIL_FOOTER_LOGO))
                                                <img src="{{asset($row->EMAIL_FOOTER_LOGO)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('email_footer_logo', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 1920 x 145 pixels</span>
                                             </div>
                                                 {!! $errors->first('email_footer_logo', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-3">
                                        <div class="form-group  {!! $errors->has('billplz_payplan') ? 'error' : '' !!}">
                                            <label class="active" for="billplz_payplan">Bill Plz logo</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->BILLPLZ_PAYPLAN))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail bg-dark" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->BILLPLZ_PAYPLAN))
                                                <img src="{{asset($row->BILLPLZ_PAYPLAN)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('billplz_payplan', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 143 x 25 pixels</span>
                                             </div>
                                                 {!! $errors->first('billplz_payplan', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-md-3">
                                        <div class="form-group  {!! $errors->has('azura_payplan_1') ? 'error' : '' !!}">
                                            <label class="active" for="azura_payplan_1"> Azura Payment Plan Logo 1</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->AZURA_PAYPLAN_1))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->AZURA_PAYPLAN_1))
                                                <img src="{{asset($row->AZURA_PAYPLAN_1)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('azura_payplan_1', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 143 x 25 pixels</span>
                                             </div>
                                                 {!! $errors->first('azura_payplan_1', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group  {!! $errors->has('azura_payplan_2') ? 'error' : '' !!}">
                                            <label class="active" for="azura_payplan_2"> Azura Payment Plan Logo 2</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->AZURA_PAYPLAN_2))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->AZURA_PAYPLAN_2))
                                                <img src="{{asset($row->AZURA_PAYPLAN_2)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('azura_payplan_2', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 143 x 25 pixels</span>
                                             </div>
                                                 {!! $errors->first('azura_payplan_2', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group  {!! $errors->has('hoolah_payplan') ? 'error' : '' !!}">
                                            <label class="active" for="hoolah_payplan"> Hoolah Payment Plan Logo </label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->HOOLAH_PAYPLAN))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->HOOLAH_PAYPLAN))
                                                <img src="{{asset($row->HOOLAH_PAYPLAN)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('hoolah_payplan', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 143 x 25 pixels</span>
                                             </div>
                                                 {!! $errors->first('hoolah_payplan', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group  {!! $errors->has('grab_payplan') ? 'error' : '' !!}">
                                            <label class="active" for="grab_payplan"> Grab Payment Plan Logo </label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->GRAB_PAYPLAN))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->GRAB_PAYPLAN))
                                                <img src="{{asset($row->GRAB_PAYPLAN)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('grab_payplan', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 143 x 25 pixels</span>
                                             </div>
                                                 {!! $errors->first('grab_payplan', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="section-title py-2 border-bottom">Icons</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('favicon') ? 'error' : '' !!}">
                                            <label class="active" for="favicon"> Favicon</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->FAVICON))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->FAVICON))
                                                <img src="{{asset($row->FAVICON)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('favicon', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 32 x 32 or 16 x 16 pixels</span>
                                             </div>
                                                 {!! $errors->first('favicon', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('playstore_icon') ? 'error' : '' !!}">
                                            <label class="active" for="playstore_icon"> Playstore Icon</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->PLAYSTORE_ICON))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->PLAYSTORE_ICON))
                                                <img src="{{asset($row->PLAYSTORE_ICON)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('playstore_icon', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                {{-- <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 1920 x 145 pixels</span> --}}
                                             </div>
                                                 {!! $errors->first('cta_banner', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('appstore_icon') ? 'error' : '' !!}">
                                            <label class="active" for="appstore_icon"> Iphone Store Icon </label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->APPSTORE_ICON))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->APPSTORE_ICON))
                                                <img src="{{asset($row->APPSTORE_ICON)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('appstore_icon', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                {{-- <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 1920 x 145 pixels</span> --}}
                                             </div>
                                                 {!! $errors->first('appstore_icon', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('payment_icon') ? 'error' : '' !!}">
                                            <label class="active" for="payment_icon"> Payment Icon</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->FOOTER_PAYMENT_ICON))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->FOOTER_PAYMENT_ICON))
                                                <img src="{{asset($row->FOOTER_PAYMENT_ICON)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('payment_icon', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                             </div>
                                                 {!! $errors->first('payment_icon', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="section-title py-2 border-bottom">Banners</h4>
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('default_banner') ? 'error' : '' !!}">
                                            <label class="active" for="default_banner"> Default banner</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->DEFAULT_BANNER))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->DEFAULT_BANNER))
                                                <img src="{{asset($row->DEFAULT_BANNER)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('default_banner', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 1920 x 145 pixels</span>
                                             </div>
                                                 {!! $errors->first('default_banner', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('cta_banner') ? 'error' : '' !!}">
                                            <label class="active" for="cta_banner"> Cta banner</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->CTA_BANNER))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->CTA_BANNER))
                                                <img src="{{asset($row->CTA_BANNER)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('cta_banner', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 1920 x 145 pixels</span>
                                             </div>
                                                 {!! $errors->first('cta_banner', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                        </div>
                                    </div>




                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('brand_banner') ? 'error' : '' !!}">
                                            <label class="active" for="brand_banner"> Brand banner</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->BRAND_BANNER))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->BRAND_BANNER))
                                                <img src="{{asset($row->BRAND_BANNER)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('brand_banner', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                             </div>

                                             <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 1920 x 145 pixels</span>
                                                 {!! $errors->first('brand_banner', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group  {!! $errors->has('offer_banner') ? 'error' : '' !!}">
                                            <label class="active" for="offer_banner"> Offer banner</label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($row->OFFER_BANNER))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($row->OFFER_BANNER))
                                                <img src="{{asset($row->OFFER_BANNER)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i>
                                                </span>
                                                {!! Form::file('offer_banner', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'banner', 'tabindex' => 32]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i>
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}} 1920 x 145 pixels</span>
                                             </div>
                                                 {!! $errors->first('offer_banner', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-actions text-center">
                                            <a href="{{route('web.home.settings')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
                                            <button type="submit" class="btn bg-primary bg-darken-1 text-white">
                                             <i class="la la-check-square-o"></i> {{ trans('form.btn_save') }} </button>
                                         </div>
                                     </div>
                                 </div>
                                 {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/editors/summernote/summernote.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
         callbacks: {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'style']],
            ['height', ['height']],
            ['Insert', ['picture', 'link', 'video', 'table', 'hr']],
            ['Misc', ['fullscreen', 'codeview', 'help']],
            ['mybutton', ['highlight']]
        ],
        imageAttributes: {
            icon: '<i class="note-icon-pencil"/>',
            figureClass: 'figureClass',
            figcaptionClass: 'captionClass',
            captionText: 'Caption Goes Here.',
            manageAspectRatio: true // true = Lock the Image Width/Height, Default to true
        },
        lang: 'en-US',
        popover: {
            image: [
                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],,
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']],
                ['custom', ['imageAttributes']],
            ],
        },
        imageTitle: {
          specificAltField: true,
        },
        height: 100,
        minHeight: null,
        maxHeight: null,
        focus: false
    });
    });

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: '{{URL("ajax/text-editor/image-upload/")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "post",
                success: function(url) {
                    var image = $('<img>').attr('src', url).attr('class', 'img-fluid');
                    $('.summernote').summernote("insertNode", image[0]);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        $(document).ready(function() {
        $('#address').summernote({
        toolbar: [
            ['para', ['ul', 'ol', 'paragraph', 'style']],
        ],
        lang: 'en-US',
        height: 100,
        minHeight: null,
        maxHeight: null,
        focus: false
    });
    });
 </script>
 @endpush('custom_js')
