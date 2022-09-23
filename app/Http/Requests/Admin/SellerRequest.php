<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class SellerRequest extends FormRequest
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


        if($id){
            if(request()->tab == 'two'){
                $rules = [
                    'name'      => 'required',
                    'phone'     => 'required',
                    'password'  => "nullable|string|min:6|max:30",
                    'email'     => "unique:SLS_SELLERS,EMAIL,{$id},PK_NO",

                ];
            }elseif(request()->tab == 'three'){
                $rules = [
                    'legal_name'        => 'required',
                    'shop_name'         => 'required',
                    'address1'          => 'required',
                    'address2'          => 'required',
                    'in_charge'         => 'required',
                    'registration_no'   => 'required',
                    'seller_tin'        => 'required',
                    'state'             => 'required',
                    'city'              => 'required',
                    'post_code'         => 'required',
                ];


            }elseif(request()->tab == 'four'){
                $rules = [
                    'account_title'     => 'required',
                    'account_no'        => 'required',
                    'bank_name'         => 'required',
                    'branch_name'       => 'required',
                    'routing_number'    => 'required',
                ];
            }elseif(request()->tab == 'complete'){
                $rules = [
                    'warehouse_name'    => 'required',
                    'address'           => 'required',
                    'phone_no'          => 'required',
                    'country'           => 'required',
                    'state'             => 'required',
                    'city'              => 'required',
                    'post_code'         => 'required',
                ];
            }

       }else{
        $rules = [
            'name'    => 'required',
            'phone'   => 'required',
            'email'   => "required|unique:SLS_SELLERS",
            'password' => "required|string|min:6|max:30",
        ];

       }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'  => 'Please enter Name!',
            'phone.required' => 'Please enter Phone No.!',
            'email.required' => 'Please enter Email!',
        ];

    }


}
