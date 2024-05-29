<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    protected $employeeId;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation(){
        $this->employeeId=$this->route('employee');
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
            'address' => 'required',
            'salary' => 'required|numeric|min:1',
            'phone' => 'required|digits_between:10,15',
            'joining_date' => 'required',
            'nid'=>'nullable|digits:14|unique:Employees,nid,'.$this->employeeId,
            'email'=>'required|email|unique:Employees,email,'.$this->employeeId,
        ];
    }
}
