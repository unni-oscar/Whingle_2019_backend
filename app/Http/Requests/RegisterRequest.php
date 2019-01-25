<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;

class RegisterRequest extends FormRequest
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
        // Mininum age for registration is 18 years
        $y18 = Carbon::create()->subYear(18)->format('Y/m/d');
        return [
            // 'created_by' => 'required|gte:1|lte:6',
            'name' => 'required|max:40|regex:/[a-zA-Z\s]+$/',
            // 'dob' => 'required|before:'.$y18,
            // 'gender' => 'required|in:1,2',
            //'marital_status' => 'required|in:1,2,3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:30'
        ];
    }
    /**
     * Custom error messages
     * @return array
     */
    // public function messages() {
    //     return [
    //         'created_by.gte' => 'Please make a valid selection',
    //         'created_by.lte' => 'Please make a valid selection',
    //         'name.regex' => 'The name field may only contain alphabetic characters as well as spaces.',
    //         'dob.before' => 'You should be 18 years of age',
    //         'gender.in' => 'Please select a valid gender',
    //         'marital_status.in' => 'Please select a valid marital status'
    //     ];
    // }
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
