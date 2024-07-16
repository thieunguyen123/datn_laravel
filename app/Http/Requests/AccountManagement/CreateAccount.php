<?php

namespace App\Http\Requests\AccountManagement;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccount extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required','min:3','max:20','regex:/^[0-9a-zA-Z]+$/u'],
            'last_name' => ['required','min:3','max:20','regex:/^[0-9a-zA-Z]+$/u'],
            'email' => 'required|email|unique:users|max:255',
            'phone_number' => ['required','regex:/^((\+84)|(0))(3[2-9]|5[689]|7[06-9]|8[1-9]|9[0-9])[0-9]{7}$/u'],
            'gender' => 'required|in:M,F,O',
            'role_id' => 'required|in:R1,R2,R3',
            'password' => 'required|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
