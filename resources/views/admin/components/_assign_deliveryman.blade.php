<!-- Modal -->
<div class="modal" id="deliveryMan" tabindex="-1" aria-labelledby="deliveryManLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deliveryManLabel">Assign Delivery Man</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open([ 'route' => 'admin.booking.assign-deliveryman', 'method' => 'post', 'class' => 'form-horizontal','novalidate', 'id' => 'assignDeliManForm']) !!}
      <div class="modal-body">
          {!! Form::hidden('booking_id', null, ['id'=>'booking_id']) !!}
          <div class="deliveryManBody">
          </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div> -->
      {!! Form::close() !!}
    </div>
  </div>
</div>
