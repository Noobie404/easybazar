{{-- @extends('admin.layout.master') --}}
@extends(\Auth::user()->USER_TYPE == 0 ? 'admin.layout.master' : 'seller.layout.master' )
@section('seller-user','active')
@section('title')
    Seller User
@endsection
@section('page-name')
    Seller User
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('seller.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Seller User
    </li>
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
                    <div class="card card-success">
                        <div class="card-header">
                            @if(hasAccessAbility('add_admin_user', $roles))
                                <a class="text-white btn btn-sm btn-primary" href="{{route('seller.seller-user.new')}}" title="Create Seller User">
                                    <i class="ft-user-plus text-white"></i> Create Seller User
                                </a>
                            @endif
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
                                <div class="table-responsive p-1">
                                    <table class="table display nowrap table-striped table-bordered  alt-pagination50 dataTables_scroll" id="indextable">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Sl.</th>
                                            <th class="text-center">Image</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Mobile no</th>
                                            <th>Group</th>
                                            <th>Role</th>
                                            <th class="text-center">Can login</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($triggers as $row)
                                            <tr>
                                                <td>{{$loop->index + 1}}</td>
                                                <td>
                                                    <?php
                                                    if($row->PROFILE_PIC_URL == ''){
                                                        $profile_pic = asset('assets/images/no-image.jpg');
                                                    }else{
                                                        if(file_exists( public_path().$row->PROFILE_PIC_URL )){
                                                            $profile_pic = $row->PROFILE_PIC_URL;
                                                        }else{
                                                            $profile_pic = asset('assets/images/no-image.jpg');
                                                        }
                                                    }

                                                    ?>
                                                    <img align="middle" width="50" height="50" src="{{ $profile_pic }}" alt="Profile">
                                                </td>
                                                <td>{{$row->FIRST_NAME}} {{$row->LAST_NAME}}</td>
                                                <td>{{$row->NAME}}</td>
                                                <td>{{$row->DESIGNATION}}</td>
                                                <td>{{$row->EMAIL}}</td>
                                                <td>{{$row->MOBILE_NO}}</td>
                                                <td>{{$row->GROUP_NAME}}</td>
                                                <td>{{$row->NAME}}</td>
                                                @if($row->CAN_LOGIN == 0)
                                                    <td class="text-center"><i class='ft-crosshair text-danger'></i>
                                                    </td>
                                                @else
                                                    <td class="text-center"><i class='ft-check text-success'></i></td>
                                                @endif
                                                <td>
                                                    @if($row->STATUS == 0)
                                                        {{'Inactive'}}
                                                    @else
                                                        {{'Active'}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(hasAccessAbility('edit_admin_user', $roles))
                                                    <a href="{{ route('seller.seller-user.edit', array($row->PK_NO)) }}" class="btn btn-xs btn-info mr-1" title="Edit"><i class="la la-edit"></i></a>
                                                    @endif
                                                    @if(hasAccessAbility('delete_admin_user', $roles))
                                                    {{-- <a href="{{ route('seller.seller-user.delete', [$row->PK_NO]) }}" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-xs btn-danger mr-1" title="Delete"><i class="la la-trash"></i></a> --}}
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
    <!--/ Alternative pagination table -->
@endsection
