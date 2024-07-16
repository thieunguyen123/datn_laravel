<?php

namespace App\Http\Requests\BadmintonCourt;

use Illuminate\Foundation\Http\FormRequest;

class CreateBadmintonCourt extends FormRequest
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
            'name' => 'required|string|min:2|max:50',
            'description' => 'required|string|min:20',
            'address' => 'required|string|unique:badminton_courts',
            'price' => 'required|numeric|min:0',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function withValidator($validator)
    {
        $images = $this->files->get('images', []);
        $imageCount = count($images);

        if ($imageCount > 5) {
            $validator->errors()->add('images', 'Tối đa chỉ được tải lên 5 ảnh.');
        }
    }
}
