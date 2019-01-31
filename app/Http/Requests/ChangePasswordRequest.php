<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'chk_pass',
            function($attribute, $value, $parameters) {
                return Hash::check($value, \Auth::user()->password);
            }
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
            'oldPassword' => 'required|chk_pass',
            'newPassword' => 'required|min:5|max:30',
            'confirmPassword' => 'required|same:newPassword',
        ];
    }
    /**
     * Custom error messages
     * @return array
     */
    public function messages() {
        return [
            'oldPassword.chk_pass' => 'Your old password is incorrect',
        ];
    }

    /**
     * @params $validator
     * @return json
     */
    public function failedValidation(Validator $validator) {
        Throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors()
        ], 422 ));
    }
}
