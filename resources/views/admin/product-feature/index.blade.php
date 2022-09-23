@extends('admin.layout.master')
@section('product feature master','active')

@section('title') Variant Factors @endsection
@section('page-name') Variant Factors @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard </a> </li>
    <li class="breadcrumb-item active">Variant Factors</li>
@endsection

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

<?php
    $roles = userRolePermissionArray();
    $productFeatureType = Config::get('static_array.product_feature_type');

?>

@section('content')
    <!-- Alternative pagination table -->
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <div class="form-group">
                                @if(hasAccessAbility('add_feature_master', $roles))
                                <a class="text-white" href="{{ route('admin.product-feature.new')}}">
                                    <button type="button" title="ADD NEW FEATURE MASTER" class="btn btn-round btn-sm btn-primary">
                                        <i class="la la-plus"></i> New Variant Factor
                                    </button>
                                </a>
                                @endif
                            </div>
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
                            <div class="card-body card-dashboard text-center">
                                <div class="table-responsive p-2">
                                    <table class="table table-striped table-bordered alt-pagination50 table-sm">
                                        <thead>
                                        <tr>
                                            <th>@lang('tablehead.sl')</th>
                                            <th class="text-left">@lang('tablehead.name')</th>
                                            <th class="text-left">Type</th>
                                            <th class="text-left">Status</th>
                                            <th class="text-left">Description</th>
                                            <th style="width: 120px;">@lang('tablehead.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (isset($data['data']) && count($data['data']) > 0 )
                                            @foreach($data['data'] as $row)
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td class="text-left">{{$row->NAME ?? ''}}</td>
                                                    <td class="text-left">{{ $productFeatureType[$row->FEATURE_TYPE] ?? ''}}</td>
                                                    <td class="text-left">
                                                        <div class="badge {{$row->IS_ACTIVE == 1 ? 'badge-success' : 'badge-danger'}}">{{$row->IS_ACTIVE == 1 ? 'Active' : 'Inactive'}}</div>
                                                    </td>
                                                    <td class="text-left">{{ $row->DESCRIPTION ?? ''}}</td>
                                                    <td>
                                                        @if(hasAccessAbility('edit_feature_master', $roles))
                                                        <a href="{{ route('admin.product-feature.edit', [$row->PK_NO]) }}" class="btn btn-xs btn-primary" title="EDIT"><i class="la la-edit"></i></a>
                                                        @endif
                                                        {{-- @if(hasAccessAbility('add_feature_child', $roles))
                                                        <a href="{{ route('admin.product-feature-child.new', [$row->PK_NO]) }}" class="btn btn-xs btn-info" title="ADD CHILD"><i class="la la-plus"></i></a>
                                                        @endif --}}
                                                        @if(hasAccessAbility('delete_feature_master', $roles))
                                                        <a href="{{route('admin.product-feature.delete', [$row->PK_NO])}}" class="btn btn-xs btn-danger" title="DELETE" onclick="return confirm('Are you sure you want to delete?')"><i class="la la-trash"></i>
                                                        </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
    <!-- BEGIN: Data Table-->
    <script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
    <!-- END: Data Table-->
    @endpush
@endsection
