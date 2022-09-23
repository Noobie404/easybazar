<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
          'customer_id'    => 'required|numeric|min:1',
          'product_id'    => 'required|numeric|min:1',
          'branch_id'    => 'required|numeric|min:1',
      ];

      return $rules;
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Please select customer!',
            'product_id.required' => 'Please select delivery man!',
            'branch_id.required' => 'Please select delivery man!',
            
        ];
    }
}
