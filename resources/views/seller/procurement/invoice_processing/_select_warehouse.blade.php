<!--Edit Product Subcategory  html-->
<div class="modal fade text-left" id="stockGenerate" tabindex="-1" role="dialog" aria-labelledby="category_name" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Select Outlet to Receive products for Invoice No : <span id="invoice_id"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                {!! Form::open(['route' => 'admin.invoice_processing.new', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate' , 'id' => 'subcat_add_edit_frm' ]) !!}
                    @csrf

                    <input type="hidden" name="invoice_pk_no" value="" id="invoice_pk_no" />

                <div class="modal-body">
                    <div class="form-group {!! $errors->has('store') ? 'error' : '' !!}">
                        <label>Outlet <span class="text-danger">*</span></label>
                        <div class="controls">
                            {!! Form::select('store', $store_list, 1, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select outlet', 'data-validation-required-message' => 'This field is required','required', 'tabindex' => 4,'id' => 'store_no']) !!}
                            {!! $errors->first('store', '<label class="help-block text-danger">:message</label>') !!}


                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Cancel">
                    <input type="submit" id="stock_generate_submit" data-url="{{ route('admin.invoice_processing.new') }}" class="btn btn-primary btn-sm submit-btn" value="Receive">
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</div>
<!--End Edit Product Subcategory  html-->
