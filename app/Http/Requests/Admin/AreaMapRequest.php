<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AreaMapRequest extends FormRequest
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
            'region'            => 'required',
            'city'              => 'required',
            'area'              => 'required',
            // 'zone'              => 'required',
            // 'nw_lat_lon'        => 'required',
            // 'se_lat_lon'        => 'required',

        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'region.required' => 'Please enter region!',
            'city.required' => 'Please enter city!',
            'area.required' => 'Please enter area!',
            // 'zone.required' => 'Please enter zone!',
            // 'nw_lat_lon.required' => 'Please enter lat lon!',
            // 'se_lat_lon.required' => 'Please enter lat lon!',
        ];
    }
}
