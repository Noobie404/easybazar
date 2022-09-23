@extends('admin.layout.master')

@section('Product Management','open')
@section('product_special_category','active')

@section('title') Special category @endsection
@section('page-name') Special category @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Special category</li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

@php
    $roles = userRolePermissionArray();
@endphp

@section('content')
    <!-- Alternative pagination table -->
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-sm card-success">
                        <div class="card-header pl-2">
                            @if(hasAccessAbility('new_special_category', $roles))
                                <a href="{{route('product.spcategory.create')}}" class="btn btn-sm btn-primary text-white" title="Add new subcategory"><i class="ft-plus text-white"></i> Create new

                                </a>
                                @endif
                            <a class="heading-elements-toggle heading-elements-toggle-sm"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements heading-elements-sm">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-bordered alt-pagination50 table-sm" id="indextable">
                                        <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th class="text-left" >@lang('tablehead.category')</th>
                                            <th class="text-left" >Banner</th>
                                            <th class="text-left" >Thumb</th>
                                            <th class="text-left" >Icon</th>
                                            <th class="text-left" >Order ID</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                       @foreach($data['rows'] as $row)

                                            <tr>
                                                <td>{{$loop->index + 1}}</td>
                                                <td class="text-left">{{ $row->NAME }}</td>
                                                <td class="text-center">
                                                    @if($row->BANNER_PATH)
                                                    <img src="{{ asset($row->BANNER_PATH) }}" width="60" >
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($row->THUMBNAIL_PATH)
                                                    <img src="{{ asset($row->THUMBNAIL_PATH) }}" width="60" >
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($row->ICON)
                                                    <img src="{{ asset($row->ICON) }}" width="60" >
                                                    @endif
                                                </td>

                                                <td class="text-left">{{ $row->ORDER_ID }}</td>

                                                <td>

                                                    @if(hasAccessAbility('edit_special_category', $roles))
                                                    <a href="{{route('product.spcategory.edit',$row->PK_NO)}}" class="btn btn-xs btn-info mr-1" title="EDIT"><i class="la la-edit"></i></a>
                                                    @endif

                                                    @if(hasAccessAbility('delete_special_category', $roles))
                                                    <a href="{{route('product.spcategory.delete',$row->PK_NO)}}" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-xs btn-danger mr-1" title="DELETE"><i class="la la-trash"></i>
                                                    </a>
                                                    @endif

                                                </td>
                                            </tr>

                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('custom_js')
    <script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
    @endpush
@endsection
