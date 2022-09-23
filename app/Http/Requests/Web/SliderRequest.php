<?php

namespace App\Http\Requests\Web;
use Illuminate\Foundation\Http\FormRequest;
class SliderRequest extends FormRequest
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
        return [
            'banner'         => 'required|mimes:jpeg,jpg,png|max:1000',
         ];
    }

    public function messages()
    {
        return [
            'title.required'        => 'Please Attached Valid Image !',

        ];
    }
}
