<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
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
        $id = (int) $this->segment(2);
        $rules = [
          'mobileno'             => 'required',
          'customername'         => 'required',
          'short_name'           => 'string|required|max:3|min:3',
          'ukpass'               => 'nullable|min:6',
          'email'                => "required|unique:SLS_MERCHANT,EMAIL,{$id},PK_NO",
          'ukid'                 => "nullable|unique:SLS_MERCHANT,UKSHOP_ID,{$id},PK_NO",

      ];

      return $rules;
    }

    public function messages()
    {
        return [
            'mobileno.required'         => 'Please enter customer mobile !',
            'customername.required'     => 'Please enter customer name !',
            'ukpass.required'           => 'Please enter customer password !',
            'email.required'            => 'Please enter valid email',
            'ukid.unique'               => 'This ID already used',
        ];
    }
}
