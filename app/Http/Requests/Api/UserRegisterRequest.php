<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
{
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            validatorError($validator)
        );
    }

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
            'name'   =>  'required|max:50',
            'user_name'     =>  'required|string|max:100|unique:users,user_name',
            'email'   =>  'required|unique:users,email,'.request()->id,
            'password'  =>  'required_if:id,=,0',
            'confirm_password' =>  'required_if:id,=,0|same:password',
            'image' =>  'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.max'     =>  'The display name may not be greater than 50 characters. ',
        ];
    }
}
