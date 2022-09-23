<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomerAddressRequest extends FormRequest
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
          'name'            => 'required|min:3|max:100',
          'mobile_no'       => 'required|min:11|max:12',
          'region'          => 'required|integer',
          'city'            => 'required|integer',
          'area'            => 'required|integer',
          'ad_1'            => 'required'
      ];
      return $rules;
    }

    public function messages()
    {
        return [
            'name.required'         => 'Please enter name!',
            'mobile_no.required' => 'Please enter Mobile No!',
            'region.required' => 'Please select region!',
            'city.required' => 'Please select city!',
            'area.required' => 'Please select area!',
            'ad_1.required' => 'Please select address line 1!'
        ];
    }
}
