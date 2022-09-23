@extends('admin.layout.master')

@section('Procurement','open')
@section('vendor','active')

@section('title') Vendor | View @endsection
@section('page-name') Vendor View @endsection
<?php
$tab_index = 1;
?>
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.vendor') }}"> Vendor </a></li>
    <li class="breadcrumb-item active">Vendor View</li>
@endsection


@push('custom_css')


@endpush('custom_css')

@section('content')
    <div class="card card-success min-height">
        <div class="card-header">
            <h4 class="card-title" id="basic-layout-colored-form-control"> View Vendor</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="form-body">
                    <div class="row">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Branch</td>
                                    <td>{{ $vendor->branch->SHOP_NAME }}</td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td>{{ $vendor->NAME }}</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>{{ $vendor->PHONE }}</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>{{ $vendor->country->NAME ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{ $vendor->ADDRESS }}</td>
                                </tr>
                            </tbody>

                        </table>


                    </div>
                    </div>
                    <div class="form-actions mt-10 text-center">
                       <a href="{{ route('admin.vendor')}}" class="btn btn-warning mr-1"title="Cancel"> <i class="ft-x"></i> Back</a>

                    </div>

                </div>
            </div>
        </div>
@endsection

@push('custom_js')


@endpush('custom_js')
