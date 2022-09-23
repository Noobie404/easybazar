<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
          'name'         => 'required',
          'mobile_no'         => 'required|min:11|max:11',
      ];

      return $rules;
    }

    public function messages()
    {
        return [
            'name.required'     => 'Please enter customer name !',
            'mobile_no.required' => 'Please enter mobile no !',
        ];
    }
}
