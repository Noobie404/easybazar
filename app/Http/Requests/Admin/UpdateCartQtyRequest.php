<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartQtyRequest extends FormRequest
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
          'cart_id'      => 'required|numeric|min:1',
          'type'         => 'required',
          'customer_id'  => 'required|numeric|min:1',
          'branch_id'    => 'required|numeric|min:1',
      ];

      return $rules;
    }

    public function messages()
    {
        return [
            'cart_id.required' => 'Please checked cart id!',
            'type.required' => 'Type',
            'customer_id.required' => 'Please select customer!',
            'branch_id.required' => 'Please select branch',
            
        ];
    }
}
