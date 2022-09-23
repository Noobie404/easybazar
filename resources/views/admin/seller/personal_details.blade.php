<?php
$customer_address       = $data['customer_address'] ?? [];
$orders                 = $data['orders'] ?? [];
$address_type           = \Config::get('static_array.address_type');
$reseller       = $data['reseller'] ?? '';

// dd($reseller);
?>
@extends('admin.layout.master')
@section('Reseller Management','open')
@section('reseller_list','active')
@push('custom_css')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}?v=2.1.2">
@endpush
@section('title')
My Account
@endsection
@section('content')

<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-sm card-success">
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.reseller.history',['id' => $reseller->PK_NO]) }}">Account Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.reseller.reseller-details',['id' => $reseller->PK_NO]) }}">Personal Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.reseller.address-book',['id' => $reseller->PK_NO]) }}">Address Book</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.reseller.orders',['id' => $reseller->PK_NO]) }}">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.reseller.payments',['id' => $reseller->PK_NO]) }}">Payments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.reseller.balance',['id' => $reseller->PK_NO]) }}">Balance</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header"> <h3 class="dashboard-title">Personal Details</h3></div>
                <div class="card-body">
                    <div class="profile-pic">
                        @if(!empty($reseller->PROFILE_PIC_URL))
                        <img src="{{ asset($reseller->PROFILE_PIC_URL) }}" alt="{{ $reseller->NAME }}" width="100" class="img-fluid rounded-circle">
                        @else
                        <img src="{{ asset('assets/images/no_image.jpg') }}" alt="{{ $reseller->NAME }}" width="100" class="img-fluid rounded-circle">
                        @endif
                    </div>
                    <h4>Name : {{ $reseller->NAME }} {{ $reseller->LAST_NAME }}</h4>
                    <h5>Email : {{ $reseller->EMAIL }} </h5>
                    @if($reseller->MOBILE_NO)
                    <h5>Mobile No :{{ $reseller->country->DIAL_CODE }} {{ $reseller->MOBILE_NO }} </h5>
                    @endif
                    @if($reseller->ALTERNATE_NO)
                    <h5>{{ $reseller->country->DIAL_CODE }} {{ $reseller->ALTERNATE_NO }} </h5>
                    @endif
                    {{-- @if($reseller->CUM_BALANCE)
                    <h5>Balance: {{ $reseller->CUM_BALANCE }} </h5>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
            @endsection
@push('custom_js')
<script>
$("[id*=user_info]").find('input').jqBootstrapValidation();

$(document).on('click','#edit_email',function(){
    $(this).fadeOut(500);
    $(".email-section").show(500);
    $('#email').attr('required',true);
})
$(document).on('click','#edit_password',function(){
    $(this).fadeOut(500);
    $(".password-section").show(500);
    $('#old_password,#password,#password_confirmation').attr('required',true);
})
$(document).on('change','#profile_pic',function(){
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        console.log(1);
        reader.onload = function (e) {
            $('#profile_pic_preview').attr('src', e.target.result);
            console.log(2);
        }
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
