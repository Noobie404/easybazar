<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryBoyRequest extends FormRequest
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
            'name'              => 'required|min:3|max:100',
            // 'email'             => "EMAIL|unique:SA_USER,EMAIL,{$id},PK_NO",
            'mobile_no'         => 'required|min:11',
            'address'           => 'required',
            'sallery'           => 'required',
            'per_delivery_comm' => 'required',
            'joining_date'      => 'required',
            // 'password'          => 'required|min:6',
            'is_active'         => 'required',
        ];

        if($id > 0 ){
            $rules['email'] = "EMAIL|unique:SA_USER,EMAIL,{$id},PK_NO";

        }else{
            $rules['email'] = "EMAIL|unique:SA_USER,EMAIL";
            $rules['password'] = "required";
        }

        return $rules;
    }

    public function messages()
    {
        return [
           'name.required'        => 'Please enter your name',
           'email.required'       => 'Please enter your email',
           'mobile_no.required'   => 'Please enter your mobile number',
           'address.required'     => 'Please enter your address',

        ];
    }
}
