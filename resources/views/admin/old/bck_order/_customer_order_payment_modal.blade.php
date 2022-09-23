{!! Form::hidden('', $data['order_value'], ['id'=>'order_value']) !!}
{!! Form::hidden('', 0, ['id'=>'order_group']) !!}
{!! Form::hidden('', $data['total_paid'], ['id'=>'total_paid']) !!}
<?php $last_inst = 0; ?>
@if ($data['payment_type'] == 'azuramart-90')
<div class="row " id="azuramart90">
    <?php $i = 0 ?>
    @for ($i; $i < 4; $i++)
    @if (isset($data['inst_payments']) && isset($data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT) && $data['inst_payments'][$i]->IS_PAID == 1)
    <?php
    // $data['order_value'] -= $data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT
    ?>
    <div class="col-6 col-md-3 mb-1">
        <div class="form-group">
        <label class="due-label" for="downpayment_90_{{ $i }}">{{ $i == 0 ? 'Downpayment' : ($i == 1 ? '1st Installment' : ($i == 2 ? '2nd Installment' : ($i == 3 ? '3rd Installment' : ($i == 4 ? '4th Installment' : ($i == 5 ? '5th Installment' : '6th Installment'))))) }}</label>
        <input type="number" class="paid form-control form-control-sm" id="downpayment_90_{{ $i }}" style="border:1px solid {{ $data['inst_payments'][$i]->IS_EXPIRED == 1 ? '#dc3545' : '#28A745' }}" value="{{ $data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT }}" name="" disabled="">
        <span class="text-center display-block">{{ $data['inst_payments'][$i]->IS_EXPIRED == 1 ? 'Expired' : 'Paid' }}</span>
        </div>
    </div>
    @else
    @break
    @endif
    @endfor
    @if ($i != 3)
    <?php $last_inst = 1; ?>
    <div class="col-6 col-md-3 mb-1">
        <div class="form-group">
        <label class="due-label" for="downpayment_90_{{ $i }}">{{ $i == 0 ? 'Downpayment' : ($i == 1 ? '1st Installment' : ($i == 2 ? '2nd Installment' : ($i == 3 ? '3rd Installment' : ($i == 4 ? '4th Installment' : ($i == 5 ? '5th Installment' : '6th Installment'))))) }}</label>
        <input type="number" id="downpayment_90_{{ $i }}" class="form-control form-control-sm quantity max_val_check min_val_check" style="" value="{{ $data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT }}" min="{{ $data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT }}" max="{{ $data['due'] }}" name="downpayment_90" required="">
        </div>
    </div>
    <?php ++$i ?>
    @endif
    @for ($j = $i; $j < 4; $j++)
    <div class="col-6 col-md-3 mb-1">
        <div class="form-group">
        <label class="due-label" for="downpayment_90_{{ $j }}">{{ $j == 0 ? 'Downpayment' : ($j == 1 ? '1st Installment' : ($j == 2 ? '2nd Installment' : ($j == 3 ? '3rd Installment' : ($j == 4 ? '4th Installment' : ($j == 5 ? '5th Installment' : '6th Installment'))))) }}</label>
        <input type="number" class="form-control form-control-sm {{ $last_inst == 0 ? 'quantity max_val_check min_val_check' : '' }}" id="downpayment_90_{{ $j }}" style="" value="{{ $data['inst_payments'][$j]->CALCULATED_INSTALLMENT_AMOUNT }}" data-value="{{ $data['inst_payments'][$j]->CALCULATED_INSTALLMENT_AMOUNT }}" name="" disabled="">
        </div>
    </div>
    @endfor
</div>

@elseif ($data['payment_type'] == 'azuramart-180')

<div class="row ml-1 mb-1" id="azuramart180">
    <?php $i = 0 ?>
    @for ($i; $i < 7; $i++)
    @if (isset($data['inst_payments']) && isset($data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT) && $data['inst_payments'][$i]->IS_PAID == 1)
    <?php
    // $data['order_value'] -= $data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT
    ?>
    <div class="col-md-3">
        <div class="form-group">
        <label class="due-label" for="downpayment_180_{{ $i }}">{{ $i == 0 ? 'Downpayment' : ($i == 1 ? '1st Installment' : ($i == 2 ? '2nd Installment' : ($i == 3 ? '3rd Installment' : ($i == 4 ? '4th Installment' : ($i == 5 ? '5th Installment' : '6th Installment'))))) }}</label>
        <input type="number" class="form-control paid" id="downpayment_180_{{ $i }}" style="border:1px solid {{ $data['inst_payments'][$i]->IS_EXPIRED == 1 ? '#dc3545' : '#28A745' }}" value="{{ $data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT }}" name="" disabled="">
        <span class="text-center display-block">{{ $data['inst_payments'][$i]->IS_EXPIRED == 1 ? 'Expired' : 'Paid' }}</span>
        </div>
    </div>
    @else
    @break
    @endif
    @endfor
    @if ($i != 6)
    <?php $last_inst = 1; ?>
    <div class="col-md-3">
        <div class="form-group">
        <label class="due-label" for="downpayment_180_{{ $i }}">{{ $i == 0 ? 'Downpayment' : ($i == 1 ? '1st Installment' : ($i == 2 ? '2nd Installment' : ($i == 3 ? '3rd Installment' : ($i == 4 ? '4th Installment' : ($i == 5 ? '5th Installment' : '6th Installment'))))) }}</label>
        <input type="number" id="downpayment_180_{{ $i }}" class="form-control quantity max_val_check min_val_check" value="{{ $data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT }}" min="{{ $data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT }}" max="{{ $data['due'] }}" data-min_amount="" name="downpayment_180" required="">
        </div>
    </div>
    <?php ++$i ?>
    @endif
    @for ($j = $i; $j < 7; $j++)
    <div class="col-md-3">
        <div class="form-group">
        <label class="due-label" for="downpayment_180_{{ $j }}">{{ $j == 0 ? 'Downpayment' : ($j == 1 ? '1st Installment' : ($j == 2 ? '2nd Installment' : ($j == 3 ? '3rd Installment' : ($j == 4 ? '4th Installment' : ($j == 5 ? '5th Installment' : '6th Installment'))))) }}</label>
        <input type="number" class="form-control {{ $last_inst == 0 ? 'quantity max_val_check min_val_check' : '' }}" id="downpayment_180_{{ $j }}" value="{{ $data['inst_payments'][$j]->CALCULATED_INSTALLMENT_AMOUNT }}" data-value="{{ $data['inst_payments'][$j]->CALCULATED_INSTALLMENT_AMOUNT }}" name="" disabled="">
        </div>
    </div>
    @endfor
</div>
@elseif ($data['payment_type'] == 'billplz')
<div class="row ml-1 mb-1" id="">
    <div class="col-md-3">
        <div class="form-group">
        <label class="due-label" for="">Insert Payment</label>
        <input type="number" id="billplz" class="form-control quantity max_val_check" value="{{ $data['due'] }}" min="1" max="{{ $data['due'] }}" data-min_amount="" name="billplz" required="">
        </div>
    </div>
</div>
@endif
@if ($data['due'] > 0)
<div class="row mt-2" style="border-top: 1px solid #ebebeb;">
    <div class="col-6 col-md-6 ml-auto">
        <table class="order-due-table">
            <tr>
                <td>Total - </td>
                <td class="text-right"><span id="total">{{ number_format($data['order_value']) }}</span></td>
            </tr>
            <tr>
                <td>Paid - </td>
                <td class="text-right"><span id="paid">{{ number_format($data['total_paid']) }}</span></td>
            </tr>

            <tr>
                <td>Pay - </td>
                <td class="text-right"><span id="payment">{{ number_format($data['inst_payments'][$i ?? 0]->CALCULATED_INSTALLMENT_AMOUNT ?? $data['due']) }}</span></td>
            </tr>

            <tr>
                <td><span class="text-danger">Due - </span></td>
                <td class="text-right"><span class="text-danger" id="due">{{ number_format($data['due']) }}</span></td>
            </tr>
        </table>
        {{-- <p>Total - <span id="total">{{ number_format($data['order_value']) }}</span></p>
        <p>Paid - <span id="paid">{{ number_format($data['total_paid']) }}</span></p>
        <p>Pay - <span id="payment">{{ number_format($data['inst_payments'][$i]->CALCULATED_INSTALLMENT_AMOUNT) }}</span></p>
        <p class="text-danger">Due - <span id="due">{{ number_format($data['due']) }}</span></p> --}}
    </div>
</div>
<div class="row mt-2" id="show_url" style="display: none">
    <div class="col-8 col-md-8 m-auto">
        <p><strong>URL</strong> : <span title="CLICK TO COPY THE URL" style="cursor: pointer" id="url"></span></p>
    </div>
</div>
<div class="row">
    <div class="col-2 col-md-2 m-auto">
        <button class="btn btn-primary mt-2" id="get_billplz_url">Get URL</button>
    </div>
</div>
@endif
