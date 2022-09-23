@extends('admin.layout.master')
@section('System Settings','open')
@section('delivery_schedule','active')
@section('title') Delivery Schedule @endsection
@section('page-name') Delivery Schedule @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Delivery Schedule</li>
@endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
@endpush
@php
    $roles = userRolePermissionArray();
    $data = [];
    use Carbon\Carbon;
@endphp
@section('content')
<div class="content-body min-height">
    <section id="pagination">
       <div class="row">
          <div class="col-12">
             <div class="card card-sm card-success">
                <div class="card-header pl-2">
                    @if(hasAccessAbility('new_address_type', $roles))
                    <button type="button" class="btn btn-primary open-modal">
                    <i class="ft-plus text-white"></i> Create new
                    </button>
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
                   <div class="card-body card-dashboard ">
                      <div class="table-responsive p-1">
                         <table class="table table-striped table-bordered alt-pagination50 table-sm" id="indextable" >
                            <thead>
                               <tr>
                                  <th style="width: 50px;">Sl.</th>
                                  <th>Schedule</th>
                                  <th style="width: 100px;">Action</th>
                               </tr>
                            </thead>
                            <tbody id="area-data">
                                @if(!empty($rows) && count($rows) > 0)
                               @foreach($rows as $key => $row)

                               <tr class="item{{ $row->PK_NO }}">
                                  <td>{{$key+1}}</td>
                                  <td>
                                    <div> <span class="badge badge-info">Slot:</span> {{$row->SLOT_TITLE}}</div>
                                  </td>
                                  <td style="width: 100px;">
                                     @if(hasAccessAbility('edit_address_type', $roles))
                                     {{-- <a href="#" title="Edit" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-primary mr-1 edit-row" title="EDIT"><i class="la la-edit"></i></a> --}}
                                     <a href="#" data-id="{{ $row->PK_NO }}" title="Edit" class="btn btn-xs btn-danger mr-1 delete-row" title="Delete"><i class="la la-trash"></i></a>
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
    <div class="modal fade" id="deliverySchModal" tabindex="-1" aria-labelledby="deliverySchModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
          <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="deliverySchModalLabel">Delivery Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <div class="modal-body" id="deliverySchModalBody">
             </div>
          </div>
       </div>
    </div>


    <!-- Modal -->
<div class="modal" id="regenerateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Schedule Generate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open([ 'route' => 'admin.schedule.generate', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
            <div class="modal-body" id="regenerateBody">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" id="f_shop_no" class="form-control" name="f_shop_no"  value="">
                            <div class="form-group">
                                <label for="gen_date">Date</label>
                                <input type="text" id="gen_date" class="form-control pickadate" name="gen_date" title="" value="" data-validation-required-message ="This field is required">
                            </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close" title="Close">
                <button type="submit" class="btn btn-primary btn-sm submit-btn">Generate</button>
            </div>

      {!! Form::close() !!}

    </div>
  </div>
</div>

 </div>
 @endsection
@push('custom_js')
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<!-- END: Data Table-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>

<script>

$(document).on('click', '.open-modal', function () {
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/get-schedule-create',
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    $('#deliverySchModalBody').empty();
                    $('#deliverySchModal').modal('show');
                    $('#deliverySchModalBody').append(response.data);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        $(document).on('submit', "#delScForm", function (e) {
            e.preventDefault();
            var form = $("#delScForm");
            $.ajax({
                type: 'post',
                data: form.serialize(),
                url: form.attr('action'),
                async: true,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (response) {
                    if (response.status == 1) {
                        toastr.success(response.message);
                        window.location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error('Something wrong');
                },
                complete: function (response) {
                    $("body").css("cursor", "default");
                }
            });
        });

    $(document).on("click", ".delete-row", function (e) {
        e.preventDefault();
        var schedule = $(this).data('id');
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $.ajax({
                type: 'GET',
                url: '{{URL("ajax/schedule-delete")}}' + "/" + schedule,
                success: function (response) {
                    if (response.status == 1) {
                        $('.item' + schedule).remove();
                        toastr.success(response.message);
                    }else{
                        toastr.success(response.message);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error('something wrong');
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        }
    });




</script>
@endpush

