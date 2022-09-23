<?php
$customer_address       = $data['customer_address'] ?? [];
$orders                 = $data['orders'] ?? [];
$address_type           = \Config::get('static_array.address_type');
$customer       = $data['customer'] ?? '';
$type           = $data['type'] ?? [];
?>
@extends('admin.layout.master')
@section('Customer Management','open')
@section('customer_list','active')
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
                                <a class="nav-link" href="{{ route('admin.customer.history2',['id' => $customer->PK_NO,'type'=>$type]) }}">Account Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.customer.customer-details',['id' => $customer->PK_NO,'type'=>$type]) }}">Personal Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.customer.address-book',['id' => $customer->PK_NO,'type'=>$type]) }}">Address Book</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.customer.orders',['id' => $customer->PK_NO,'type'=>$type]) }}">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.customer.payments',['id' => $customer->PK_NO,'type'=>$type]) }}">Payments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.customer.balance',['id' => $customer->PK_NO,'type'=>$type]) }}">Balance</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header"> <h1 class="dashboard-title">Personal Details</h1></div>
                <div class="card-body">
                    <div class="profile-pic">
                        @if(!empty($customer->PROFILE_PIC_URL))
                        <img src="{{ asset($customer->PROFILE_PIC_URL) }}" alt="{{ $customer->NAME }}" width="100" class="img-fluid rounded-circle">
                        @else
                        <img src="{{ asset('assets/images/no_image.jpg') }}" alt="{{ $customer->NAME }}" width="100" class="img-fluid rounded-circle">
                        @endif
                    </div>
                    <h4>Name : {{ $customer->NAME }} {{ $customer->LAST_NAME }}</h4>
                    <h5>Email : {{ $customer->EMAIL }} </h5>
                    @if($customer->MOBILE_NO)
                    <h5>Mobile No :+88{{ $customer->MOBILE_NO }} </h5>
                    @endif
                    @if($customer->ALTERNATE_NO)
                    <h5>+88{{ $customer->ALTERNATE_NO }} </h5>
                    @endif
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
