<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReturnOrderRequest extends FormRequest
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
            'booking_details_id'   => 'required',
            'booking_id'   => 'required',
            'reason'   => 'required',
      ];

      return $rules;
    }

    public function messages()
    {
        return [
            'booking_details_id.required' => 'Booking details id required',
            'booking_id.required' => 'Booking id details required',
            'reason.required' => 'Booking reason required',
        ];
    }


}
