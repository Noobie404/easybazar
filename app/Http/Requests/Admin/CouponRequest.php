<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        $rules = [
                'branch_id'           => 'required',
                'coupon_code'         => 'required',
                'coupon_type'         => 'required',
                'discount'            => 'required',
                'order_min_value'     => 'required',
                'validity_from'       => 'required',
                'validity_to'         => 'required',
                'coupon_for'          => 'required',
            ];
        return $rules;
    }

    public function messages()
    {
        return [
            'branch_id.required'       => 'This Field is Required !',
            'coupon_code.required'     => 'This Field is Required !',
            'coupon_type.required'     => 'This Field is Required !',
            'discount.required'        => 'This Field is Required !',
            'order_min_value.required' => 'This Field is Required !',
            'validity_from.required'   => 'This Field is Required !',
            'validity_to.required'     => 'This Field is Required !',
            'coupon_for.required'      => 'This Field is Required !',
        ];
    }
}
