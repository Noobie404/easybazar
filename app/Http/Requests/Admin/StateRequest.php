<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StateRequest extends FormRequest
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
            'region'              => 'required',
            'bn_region'           => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'region.required' => 'Please enter region!',
            'bn_region.required' => 'Please enter bn region!',

        ];
    }
}
