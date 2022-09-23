@extends('admin.layout.master')
@section('slider','active')
@section('title')
    Gallery List
@endsection
@section('page-name')
Gallery List
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> Gallery List </a></li>
    <li class="breadcrumb-item active">Gallery</li>
@endsection
@push('custom_css')
<link rel="stylesheet" type="text/css"  href="{{asset('assets/css/plugins/icheck/yellow.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
@endpush
<?php
$rows = $data['slider'] ?? [];
$roles = userRolePermissionArray();
?>
@section('content')
<section id="basic-form-layouts">
    <div class="row match-height min-height">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <a href="{{ route('web.slider.create') }}" class="btn btn-primary float-lg-right btn-sm"> <i class="la la-plus"></i> Create New</a>
                </div>
                <hr>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>title</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($rows) && count($rows)>0)
                                @foreach($rows as $key=>$row)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{ $row->TITLE }}</td>
                                    <td>
                                        @if($row->IS_ACTIVE == 1)
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-danger">Deactive</span>
                                        @endif
                                    </td>
                                      <td style="width: 140px;">
                                        @if(hasAccessAbility('view_web_settings', $roles))
                                            {{-- <a href="{{ route('web.slider.order-up', [$row->PK_NO]) }}" class="btn btn-xs btn-warning" title="Order Up"><i class="la la-chevron-circle-up" aria-hidden="true"></i></a>
                                            <a href="{{ route('web.slider.order-down', [$row->PK_NO]) }}" class="btn btn-xs btn-success" title="Order Down"><i class="la la-chevron-circle-down" aria-hidden="true"></i></a> --}}
                                            <a href="{{ route('web.slider.edit', [$row->PK_NO]) }}" class="btn btn-xs btn-info" title="EDIT"><i class="la la-edit"></i></a>
                                        @endif
                                        @if(hasAccessAbility('view_web_settings', $roles))
                                            <a href="{{ route('web.slider.delete', [$row->PK_NO]) }}" class="btn btn-xs btn-danger " onclick="return confirm('Are you sure you want to delete?')" title="DELETE"><i class="la la-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr class="alert">
                                    <td rowspan="5">Data Not Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('custom_js')

<script src="{{asset('assets/css/plugins/icheck/icheck.min.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.is_feature').iCheck({
            checkboxClass: 'icheckbox_square-yellow',
            radioClass: 'iradio_square-yellow',
            increaseArea: '20%'
        });
        $('.is_feature').on('ifClicked', function(event){
            id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: "{{ URL('web/slider/featureStatus') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id
                },
                success: function(data) {

                    toastr.success('Home Slider', 'Feature Status Updated')


                },
            });
        });
        $('.is_feature').on('ifToggled', function(event) {
            $(this).closest('tr').toggleClass('warning');
        });
    });
</script>
@endpush
@endsection
