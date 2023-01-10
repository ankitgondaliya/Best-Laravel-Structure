<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
{
    protected function failedValidation(Validator $validator) {
        if (request()->expectsJson()) {
            throw new  HttpResponseException(validatorError($validator));
        }
        throw (new ValidationException($validator))
        ->errorBag($this->errorBag)
        ->redirectTo($this->getRedirectUrl());
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

        $usernameRule = request()->id > 0 ?
        'required|string|max:100|unique:users,user_name,'.request()->id:
        'required|string|max:100|unique:users,user_name';

        return [
            'id'   =>  'required|numeric',
            'name'   =>  'required|max:50',
            'user_name'     =>  $usernameRule,
            'email'   =>  'required|unique:users,email,'.request()->id,
            'password'  =>  'required_if:id,=,0',
            'confirm_password' =>  'required_if:id,=,0|same:password',
            'image' =>  'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
