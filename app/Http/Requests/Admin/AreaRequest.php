<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AreaRequest extends FormRequest
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
            'region'                => 'required',
            'city'                  => 'required',
            'area'                  => 'required',
            'bn_area'               => 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'region.required' => 'Please enter region!',
            'city.required' => 'Please enter city!',
            'area.required' => 'Please enter area!',
            'bn_area.required' => 'Please enter bn area!',
        ];
    }
}
