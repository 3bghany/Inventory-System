<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:Employees|email',
            'address' => 'required',
            'salary' => 'required|numeric|min:1',
            'phone' => 'required|digits_between:10,15',
            'joining_date' => 'required',
            'nid'=>'nullable|unique:Employees|digits:14'
        ];
    }
}
