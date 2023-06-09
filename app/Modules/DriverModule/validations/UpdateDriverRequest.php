<?php

namespace App\Modules\DriverModule\validations;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDriverRequest extends BaseFormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => [],
            'ssn' => ['required', 'numeric'],
            'dob' => ['required', 'date'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'zip' => ['required', 'string'],
            'phone' => ['required', 'numeric', 'digits:10', Rule::unique('users')->ignore($this->driver)],
        ];
    }
}
