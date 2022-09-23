@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/custom/vendor/bootstrap-select/css/bootstrap-select.min.css')}}">
@endpush('custom_css')
@section('web','open')
@section('home_page','active')
@section('title') Home Page Setting @endsection
@section('page-name') Home Page Setting @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Page</a></li>
<li class="breadcrumb-item active">Home Page Setting</li>
@endsection
<?php
   $sliders         = $data['sliders'] ?? [];
   $home_setting    = $data['home_setting'] ?? [];
   $home_slider     = getHomeSetting('home_slider_1');
   $brands          = $data['brands'] ?? [];
   $category        = $data['category'] ?? [];
   $selected_category = getHomeSetting('feature_category');
   ?>
@section('content')
<div class="content-body min-height">
   <div class="row">
      <div class="col-md-12">
         <div class="card card-sm card-success" >
            <div class="card-content">
               <div class="card-body">
                {!! Form::open([ 'route' => 'web.home_setting.sliderUpdate', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                @csrf
                <input name="section_type" type="hidden" value="home_slider_1">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-md-11">
                            <h4>Home Slider</h4>
                        </div>
                        <div class="col-md-1">
                            <div class="switch float-right">
                                <input type="radio" class="switch-input" name="is_active" value="1" id="no_{{$home_slider->PK_NO  }}" @if($home_slider->IS_ACTIVE ==1) checked @endif>
                                <label for="no_{{$home_slider->PK_NO  }}" class="switch-label switch-label-off">ON</label>
                                <input type="radio" class="switch-input" name="is_active" value="0" id="yes_{{$home_slider->PK_NO  }}" @if($home_slider->IS_ACTIVE ==0) checked @endif>
                                <label for="yes_{{$home_slider->PK_NO  }}" class="switch-label switch-label-on">OFF</label>
                                <span class="switch-selection"></span>
                              </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('slider') ? 'error' : '' !!}">
                                    <label>Slider<span class="text-danger">*</span></label>
                                    <div class="controls">
                                    {!! Form::select('slider', $sliders, $home_slider->VALUE ?? NULL,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => 1]) !!}
                                       {!! $errors->first('slider', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-info float-right">
                        <i class="la la-check-square-o"></i> Update </button>
                  </div>
                </div>
                {!! Form::close() !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open([ 'route' => 'web.home_setting.update', 'method' => 'post','novalidate']) !!}
                         @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5>Shop By Category (Max 4)</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group {!! $errors->has('section_title') ? 'error' : '' !!}">
                                    <label>Section title<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <div class="controls">
                                            {!! Form::text('section_title',  $selected_category->SECTION_TITLE ?? NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                            {!! $errors->first('section_title', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                 </div>
                                <input name="section_type" type="hidden" value="feature_category">
                                <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
                                    <label>Category<span class="text-danger">*</span></label>
                                    <div class="controls">
                                    {!! Form::select('value[]', $category, json_decode($selected_category->VALUE) ?? NULL,[ 'class' => 'form-control bootstrap-select', 'data-validation-required-message' => 'This field is required', 'tabindex' => 1,'multiple','data-live-search'=>'true']) !!}
                                       {!! $errors->first('gallery', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                 </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-outline-info float-right">
                                    <i class="la la-check-square-o"></i> Update </button>
                              </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                {!! Form::open([ 'route' => 'web.home_setting.update', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                @csrf
                <?php
                $type= 'home_banner_1';
                $home_banner1 = getHomeSetting($type);
                ?>
                <input name="section_type" type="hidden" value="home_banner_1">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-11"><h4>Home Banner 1</h4></div>
                        <div class="col-md-1">
                            <div class="switch float-right">
                                <input type="radio" class="switch-input" name="is_active" value="1" id="no_{{$home_banner1->PK_NO  }}" @if($home_banner1->IS_ACTIVE ==1) checked @endif>
                                <label for="no_{{$home_banner1->PK_NO  }}" class="switch-label switch-label-off">ON</label>
                                <input type="radio" class="switch-input" name="is_active" value="0" id="yes_{{$home_banner1->PK_NO  }}" @if($home_banner1->IS_ACTIVE ==0) checked @endif>
                                <label for="yes_{{$home_banner1->PK_NO  }}" class="switch-label switch-label-on">OFF</label>
                                <span class="switch-selection"></span>
                              </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('section_title') ? 'error' : '' !!}">
                                    <label>Section title<span class="text-danger">*</span></label>
                                    <div class="controls">
                                            <div class="controls">
                                               {!! Form::text('section_title', $home_banner1->SECTION_TITLE, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                               {!! $errors->first('section_title', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('section_title_bn') ? 'error' : '' !!}">
                                    <label>Section title bn<span class="text-danger">*</span></label>
                                    <div class="controls">
                                            <div class="controls">
                                               {!! Form::text('section_title_bn', $home_banner1->SECTION_TITLE_BN, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                               {!! $errors->first('section_title_bn', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('gallery') ? 'error' : '' !!}">
                                    <label>Gallery<span class="text-danger">*</span></label>
                                    <div class="controls">
                                    {!! Form::select('value', $sliders, $home_banner1->VALUE ?? NULL,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => 1]) !!}
                                       {!! $errors->first('gallery', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                 </div>
                        </div>
                        </div>
                   </div>
                   <div class="card-footer">
                    <button type="submit" class="btn btn-outline-info float-right">
                        <i class="la la-check-square-o"></i> Update </button>
                  </div>
                </div>
                  {!! Form::close() !!}
                  {!! Form::open([ 'route' => 'web.home_setting.update', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                @csrf
                <?php
                $type= 'home_banner_2';
                $home_banner2 = getHomeSetting($type);
                ?>
                <input name="section_type" type="hidden" value="home_banner_2">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-11"><h4>Home Banner 2</h4></div>
                        <div class="col-md-1">
                            <div class="switch float-right">
                                <input type="radio" class="switch-input" name="is_active" value="1" id="no_{{ $home_banner2->PK_NO }}" @if(!isset($home_banner1)) @if($home_banner2->IS_ACTIVE ==1) checked @endif  @endisset>
                                <label for="no_{{ $home_banner2->PK_NO }}" class="switch-label switch-label-off">ON</label>
                                <input type="radio" class="switch-input" name="is_active" value="0" id="yes_{{ $home_banner2->PK_NO }}" @if(!isset($home_banner1)) @if($home_banner2->IS_ACTIVE ==0) checked @endif  @endisset>
                                <label for="yes_{{ $home_banner2->PK_NO }}" class="switch-label switch-label-on">OFF</label>
                                <span class="switch-selection"></span>
                              </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('section_title') ? 'error' : '' !!}">
                                    <label>Section title<span class="text-danger">*</span></label>
                                    <div class="controls">
                                            <div class="controls">
                                               {!! Form::text('section_title', $home_banner2->SECTION_TITLE ?? NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                               {!! $errors->first('section_title', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('section_title_bn') ? 'error' : '' !!}">
                                    <label>Section title bn<span class="text-danger">*</span></label>
                                    <div class="controls">
                                            <div class="controls">
                                               {!! Form::text('section_title_bn', $home_banner2->SECTION_TITLE_BN, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                               {!! $errors->first('section_title_bn', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('gallery') ? 'error' : '' !!}">
                                    <label>Gallery<span class="text-danger">*</span></label>
                                    <div class="controls">
                                    {!! Form::select('value', $sliders, $home_banner2->VALUE ?? NULL,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => 1]) !!}
                                       {!! $errors->first('gallery', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                 </div>

                        </div>
                        </div>


                   </div>
                   <div class="card-footer">
                    <button type="submit" class="btn btn-outline-info float-right">
                        <i class="la la-check-square-o"></i> Update </button>
                  </div>
                </div>
                  {!! Form::close() !!}


                  {!! Form::open([ 'route' => 'web.home_setting.update', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                  @csrf
                  <?php
                  $type= 'home_banner_3';
                  $home_banner3 = getHomeSetting($type);

                //   dd($home_banner3);
                  ?>
                  <input name="section_type" type="hidden" value="home_banner_3">
                  <div class="card">
                      <div class="card-header row">
                          <div class="col-11"><h4>Home Banner 3</h4></div>
                          <div class="col-md-1">
                            <div class="switch float-right">
                                <input type="radio" class="switch-input" name="is_active" value="1" id="no_{{ $home_banner3->PK_NO }}" @if(!isset($home_banner3)) @if($home_banner2->IS_ACTIVE ==1) checked @endif @endisset>
                                <label for="no_{{ $home_banner3->PK_NO }}" class="switch-label switch-label-off">ON</label>
                                <input type="radio" class="switch-input" name="is_active" value="0" id="yes_{{ $home_banner3->PK_NO }}" @if(!isset($home_banner3)) @if($home_banner3->IS_ACTIVE ==0) checked @endif @endisset>
                                <label for="yes_{{ $home_banner3->PK_NO }}" class="switch-label switch-label-on">OFF</label>
                                <span class="switch-selection"></span>
                              </div>
                          </div>
                      </div>
                      <div class="card-body">
                          <div class="row">
                              <div class="col-6 col-md-4">
                                  <div class="form-group {!! $errors->has('section_title') ? 'error' : '' !!}">
                                      <label>Section title<span class="text-danger">*</span></label>
                                      <div class="controls">
                                              <div class="controls">
                                                 {!! Form::text('section_title', $home_banner3->SECTION_TITLE ?? NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                                 {!! $errors->first('section_title', '<label class="help-block text-danger">:message</label>') !!}
                                              </div>
                                      </div>
                                   </div>
                              </div>
                              <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('section_title_bn') ? 'error' : '' !!}">
                                    <label>Section title bn<span class="text-danger">*</span></label>
                                    <div class="controls">
                                            <div class="controls">
                                               {!! Form::text('section_title_bn', $home_banner3->SECTION_TITLE_BN, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                               {!! $errors->first('section_title_bn', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                    </div>
                                 </div>
                            </div>
                              <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('gallery') ? 'error' : '' !!}">
                                    <label>Gallery<span class="text-danger">*</span></label>
                                    <div class="controls">
                                    {!! Form::select('value', $sliders, $home_banner3->VALUE ?? NULL,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => 1]) !!}
                                       {!! $errors->first('gallery', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                 </div>

                        </div>
                          </div>

                     </div>
                     <div class="card-footer">
                      <button type="submit" class="btn btn-outline-info float-right">
                          <i class="la la-check-square-o"></i> Update </button>
                    </div>
                  </div>
                    {!! Form::close() !!}


                    {!! Form::open([ 'route' => 'web.home_setting.update', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                  @csrf
                  <?php
                  $type= 'feature_brand';
                  $feature_brand = getHomeSetting($type);
                  $selected_brand = json_decode($feature_brand->VALUE);
                  ?>
                  <input name="section_type" type="hidden" value="feature_brand">
                  <div class="card">
                      <div class="card-header row">
                          <div class="col-11"><h4>Feature Brand(Max 6)</h4></div>
                          <div class="col-md-1">
                              <div class="switch float-right">
                                  <input type="radio" class="switch-input" name="is_active" value="1" id="no_{{ $feature_brand->PK_NO }}" @if(!empty($feature_brand)) @if($feature_brand->IS_ACTIVE ==1) checked @endif @endif>
                                  <label for="no_{{ $feature_brand->PK_NO }}" class="switch-label switch-label-off">ON</label>
                                  <input type="radio" class="switch-input" name="is_active" value="0" id="yes_{{ $feature_brand->PK_NO }}" @if(!empty($feature_brand)) @if($feature_brand->IS_ACTIVE ==0) checked @endif @endif>
                                  <label for="yes_{{ $feature_brand->PK_NO }}" class="switch-label switch-label-on">OFF</label>
                                  <span class="switch-selection"></span>
                                </div>
                          </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('section_title') ? 'error' : '' !!}">
                                    <label>Section title<span class="text-danger">*</span></label>
                                    <div class="controls">
                                            <div class="controls">
                                               {!! Form::text('section_title', $feature_brand->SECTION_TITLE ?? NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                               {!! $errors->first('section_title', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('section_title_bn') ? 'error' : '' !!}">
                                    <label>Section title bn<span class="text-danger">*</span></label>
                                    <div class="controls">
                                            <div class="controls">
                                               {!! Form::text('section_title_bn', $feature_brand->SECTION_TITLE_BN, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                               {!! $errors->first('section_title_bn', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-6 col-md-4">
                              <div class="form-group {!! $errors->has('gallery') ? 'error' : '' !!}">
                                  <label>Brand<span class="text-danger">*</span></label>
                                  <div class="controls">
                                  {!! Form::select('value[]', $brands, $selected_brand ?? NULL,[ 'class' => 'form-control bootstrap-select', 'data-validation-required-message' => 'This field is required', 'tabindex' => 1,'multiple']) !!}
                                     {!! $errors->first('gallery', '<label class="help-block text-danger">:message</label>') !!}
                                  </div>
                               </div>

                      </div>
                        </div>
                     </div>
                     <div class="card-footer">
                      <button type="submit" class="btn btn-outline-info float-right">
                          <i class="la la-check-square-o"></i> Update </button>
                    </div>
                  </div>
                    {!! Form::close() !!}


                    {!! Form::open([ 'route' => 'web.home_setting.update', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                  @csrf
                  <?php
                  $type= 'home_banner_4';
                  $home_banner4 = getHomeSetting($type);
                  ?>
                  <input name="section_type" type="hidden" value="home_banner_4">
                  <div class="card">
                      <div class="card-header row">
                          <div class="col-lg-11"><h4>Home Banner 4</h4></div>
                          <div class="col-md-1">
                              <div class="switch float-right">
                                  <input type="radio" class="switch-input" name="is_active" value="1" id="week" @if(!empty($home_banner4)) @if($home_banner4->IS_ACTIVE ==1) checked @endif  @endif>
                                  <label for="week" class="switch-label switch-label-off">ON</label>
                                  <input type="radio" class="switch-input" name="is_active" value="0" id="month" @if(!empty($home_banner4)) @if($home_banner4->IS_ACTIVE ==0) checked @endif  @endif>
                                  <label for="month" class="switch-label switch-label-on">OFF</label>
                                  <span class="switch-selection"></span>
                                </div>
                          </div>
                      </div>
                      <div class="card-body">
                          <div class="row">
                              <div class="col-6 col-md-4">
                                  <div class="form-group {!! $errors->has('section_title') ? 'error' : '' !!}">
                                      <label>Section title<span class="text-danger">*</span></label>
                                      <div class="controls">
                                              <div class="controls">
                                                 {!! Form::text('section_title', $home_banner4->SECTION_TITLE ?? NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                                 {!! $errors->first('section_title', '<label class="help-block text-danger">:message</label>') !!}
                                              </div>
                                      </div>
                                   </div>
                              </div>
                              <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('section_title_bn') ? 'error' : '' !!}">
                                    <label>Section title bn<span class="text-danger">*</span></label>
                                    <div class="controls">
                                            <div class="controls">
                                               {!! Form::text('section_title_bn', $home_banner4->SECTION_TITLE_BN, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                               {!! $errors->first('section_title_bn', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                    </div>
                                 </div>
                            </div>
                              <div class="col-6 col-md-4">
                                <div class="form-group {!! $errors->has('gallery') ? 'error' : '' !!}">
                                    <label>Gallery<span class="text-danger">*</span></label>
                                    <div class="controls">
                                    {!! Form::select('value', $sliders, $home_banner4->VALUE ?? NULL,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => 1]) !!}
                                       {!! $errors->first('gallery', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                 </div>
                        </div>
                          </div>
                     </div>
                     <div class="card-footer">
                      <button type="submit" class="btn btn-outline-info float-right">
                          <i class="la la-check-square-o"></i> Update </button>
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
<script type="text/javascript" src="{{ asset('assets/custom/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/home_setting.js') }}"></script>
<script>
    $('.bootstrap-select').selectpicker();
</script>
@endpush('custom_js')
