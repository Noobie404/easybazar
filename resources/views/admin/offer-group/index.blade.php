@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@section('offer_group','active')
@section('offer_management','open')

@section('title') Offer group @endsection
@section('page-name') Offer group @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('form.dashboard')</a></li>
    <li class="breadcrumb-item active">Offer group</li>
@endsection

@php
    $roles = userRolePermissionArray();

@endphp

@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
@endpush
@section('content')
    <!-- Alternative pagination table -->
    <div class="content-body min-height">
        <section id="pagination">
          <div class="row">
            <div class="col-12">
              <div class="card card-success">
                <div class="card-header">
                    <div class="form-group">
                    @if(hasAccessAbility('new_offergroup', $roles))
                        <a class="btn btn-sm btn-primary " href="{{ route('admin.offergroup.create') }}" title="Add new offer"> <i class="ft-plus text-white"></i> Add new offer</a>
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
                  <div class="card-body card-dashboard ">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered alt-pagination table-sm" id="indextable">
                        <thead>
                          <tr>
                            <th style="width: 40px;" class="text-center">Sl.</th>
                            <th class="" style="">Offer Group Thumb Photo</th>
                            <th class="" style="">Offer Group Banner Photo</th>
                            <th class="" style="">Offer Group Name</th>
                            <th class="" style="">Offer Group Public Name</th>
                            <th>Offer(s)</th>
                            <th style="width: 80px;" class="text-center">Active</th>
                          </tr>
                        </thead>
                        <tbody>
                                @if($rows && count($rows) > 0 )
                                @foreach($rows as $key => $row )
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td>
                                    @if($row->IMAGE)
                                        <img src="{{ asset($row->IMAGE) }}"  width="80"/>
                                    @else
                                        <img src="{{ asset('assets/images/no_image.jpg') }}"  width="50"/>
                                    @endif
                                </td>
                                <td>
                                    @if($row->BANNER_IMAGE)
                                        <img src="{{ asset($row->BANNER_IMAGE) }}"  width="120"/>
                                    @else
                                        <img src="{{ asset('assets/images/no_image.jpg') }}"  width="50"/>
                                    @endif
                                </td>
                                <td>{{ $row->BUNDLE_NAME }}</td>
                                <td>{{ $row->BUNDLE_NAME_PUBLIC }}</td>
                                <td>
                                    @if($row->allOffers && count($row->allOffers) > 0 )
                                        @foreach($row->allOffers as $ck => $off)
                                        <p>{{ $ck+1 }}.{{ $off->BUNDLE_NAME_PUBLIC }}</p>
                                        @endforeach
                                    @endif
                                </td>
                                <td style="width: 80px;" class="text-center">

                                @if(hasAccessAbility('edit_offergroup', $roles))
                                    <a href="{{ route('admin.offergroup.edit', [$row->PK_NO]) }}" title="OFFER GROUP EDIT" class="btn btn-xxs btn-primary mr-05"><i class="la la-pencil"></i></a>
                                @endif

                                @if(hasAccessAbility('delete_offergroup', $roles))
                                    <a href="{{ route('admin.offergroup.delete', [$row->PK_NO]) }}"  class="btn btn-xxs btn-danger mr-05" onclick="return confirm('Are You Sure?')" title="OFFER GROUP DELETE"><i class="la la-trash"></i></a>
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


      @include('admin.account._account_edit_modal')

    <!--/ Alternative pagination table -->
@endsection
@push('custom_js')

<!--script only for brand page-->
<script type="text/javascript" src="{{ asset('assets/pages/account.js')}}"></script>


@endpush('custom_js')
