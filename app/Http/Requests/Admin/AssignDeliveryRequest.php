<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AssignDeliveryRequest extends FormRequest
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
          'delivery_boy_id'    => 'required|numeric|min:1',
          'booking_id'    => 'required|numeric|min:1',
      ];

      return $rules;
    }

    public function messages()
    {
        return [
            'booking_id.required' => 'Please checked order!',
            'delivery_boy_id.required' => 'Please select delivery man!',
            
        ];
    }
}
