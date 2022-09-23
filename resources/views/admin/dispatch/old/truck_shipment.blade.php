@extends('admin.layout.master')

@section('Dispatch Management','open')
@section('list_dispatch','active')

@section('title') Order | Track @endsection
@section('page-name') Order @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_title') </a></li>
    <li class="breadcrumb-item active">Track</li>
@endsection
@push('custom_css')
@endpush('custom_css')
@section('content')
<?php
    $roles = userRolePermissionArray();
    $trackHeader  = $data['trackHeader'] ?? [];
    $trackDetails = $data['trackDetails'] ?? [];
    $cp_code    = Config::get('static_array.cp_code') ?? array();
    $dispose_code    = Config::get('static_array.dispose_code') ?? array();




?>
<div class="card min-height">
    <div class="card-content collapse show">
        <div class="card-body" style="padding: 15px 5px;">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>Consignment Note</td>
                        <td>{{ $trackHeader[0]['hawb'] }}</td>
                        <td>Shipment Date</td>
                        <td>{{ $trackHeader[0]['shipdate'] }}</td>
                    </tr>
                    <tr>
                        <td>Delivery Date</td>
                        <td> {{ $trackHeader[0]['deldate'] }}</td>
                        <td>Destination station</td>
                        <td>{{ $trackHeader[0]['destinationstation'] }}</td>
                    </tr>
                    <tr>
                        <td>Consignee Name</td>
                        <td>{{ $trackHeader[0]['consigneename'] }}</td>
                        <td>Originstation</td>
                        <td>{{ $trackHeader[0]['originstation'] }}</td>
                    </tr>
                    <tr>
                        <td>Weight</td>
                        <td>
                            @if(!empty($trackHeader[0]['vw_height']))Height:{{ $trackHeader[0]['vw_height'] }}, @endif
                            @if(!empty($trackHeader[0]['vw_length'])) Length:{{ $trackHeader[0]['vw_length'] }}, @endif
                            @if(!empty($trackHeader[0]['vw_width'])) Width:{{ $trackHeader[0]['vw_width'] }}, @endif
                            @if(!empty($trackHeader[0]['t_weight']))Weight:{{ $trackHeader[0]['t_weight'] }} @endif
                        </td>
                        {{-- <td>Origin Station</td>
                        <td>{{ $trackHeader[0]['originstation'] }}</td> --}}
                    </tr>

                    <tr>
                        <td>Tel</td>
                        <td>{{ $trackHeader[0]['s_tel'] }}</td>
                        <td>Tos Mode</td>
                        <td>{{ $trackHeader[0]['tos_mode'] }}</td>
                    </tr>


                    {{-- <tr>
                        <td>detDate</td>
                        <td>{{ $trackDetails[0]['detDate'] }}</td>
                        <td>detTime</td>
                        <td>{{ $trackDetails[0]['detTime'] }}</td>
                    </tr>

                    <tr>
                        <td>CP Code</td>
                        <td>{{ $trackDetails[0]['CP_Code'] }}</td>
                        <td>Status</td>
                        <td>{{ $trackDetails[0]['status'] }}</td>
                    </tr>

                    <tr>
                        <td>Location</td>
                        <td>{{ $trackDetails[0]['location'] }}</td>
                        <td>Recipient</td>
                        <td>{{ $trackDetails[0]['Recipient'] }}</td>
                    </tr>
                    <tr>
                        <td>DisposeCode</td>
                        <td>{{ $trackDetails[0]['DisposeCode'] }}</td>
                        <td></td>
                        <td></td>
                    </tr> --}}

                </table>

            </div>

                <h5>Tracking Details</h5>
                <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>Details Date</th>
                            <th>CP Code</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Recipient</th>
                            <th>DisposeCode</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($trackDetails as $item)
                    <tr>
                        <td> {{ $item['detDate'] }}</td>
                        {{-- <td>detTime :{{ $item['detTime'] }}</td> --}}
                        <td> {{ $item['CP_Code'] }}-{{$cp_code[$item['CP_Code']] }}</td>
                        <td> {{ $item['status'] }}</td>
                        <td> {{ $item['location'] }}</td>
                        <td> {{ $item['Recipient'] }}</td>
                        <td>  @if(!empty($item['DisposeCode'])) {{ $item['DisposeCode'] }}-{{$dispose_code[$item['DisposeCode'] ]}}@endif</td>
                    </tr>
                    @endforeach

                </tbody>

                </table>

            </div>
        </div>
    </div>
</div>


@endsection
@push('custom_js')
@endpush
