<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Carbon\Carbon;

class ProfileRequest extends FormRequest
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
             'created_by' => 'required|gte:1|lte:6',
             'name' => 'required|max:40|regex:/[a-zA-Z\s]+$/',
             'dob' => 'required|before:'.$y18,
             'gender' => 'required|in:1,2',
             'marital_status' => 'required|in:1,2,3',
             'sisters' => 'nullable|numeric',
             'sisters_married' => 'nullable|numeric|greater_than_equal_field:sisters',
             'brothers' => 'nullable|numeric',
             'brothers_married' => 'nullable|numeric|greater_than_equal_field:brothers',
             'contact_number' => 'required|numeric|digits_between:5,15'
             // 'email' => 'required|email|unique:users',
             // 'password' => 'required|min:5|max:30'
             // 'phone' => 'nullable|numeric'
         ];
    }

    public function messages() {
        return [
            'created_by.gte' => 'Please make a valid selection',
            'created_by.lte' => 'Please make a valid selection',
            'name.regex' => 'The name field may only contain alphabetic characters as well as spaces.',
            'dob.before' => 'You should be 18 years of age',
            'gender.in' => 'Please select a valid gender',
            'marital_status.in' => 'Please select a valid marital status',
            'sisters_married.greater_than_equal_field' => "'Sisters married' should be less than or equal to no. of sister(s).",
            'brothers_married.greater_than_equal_field' => "'Brothers married' should be less than or equal to no. of brother(s)."
        ];
    }
    public function failedValidation(Validator $validator) {
        Throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors()
        ], 422 ));
    }
}
