<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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

        if(request()->shop_id){
            $rules = [
                'is_feature'        => 'required',
                'is_popular'        => 'required',
                'order_id'          => 'required',
            ];
        }else{
            $rules = [
                'name'              => 'required',
                'url_slug'          => 'required',
                'bn_name'           => 'required',
                'parent_id'         => 'required',
                'is_feature'        => 'required',
                'is_popular'        => 'required',
                'order_id'          => 'required',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter category name!'

        ];
    }
}
