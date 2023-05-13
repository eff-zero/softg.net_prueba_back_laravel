<?php

namespace App\Modules\DriverModule\validations;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends BaseFormRequest
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
            'password' => ['required', 'string', 'min:8'],
            'ssn' => ['required', 'numeric'],
            'dob' => ['required', 'date'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'zip' => ['required', 'string'],
            'phone' => ['required', 'unique:users', 'numeric', 'digits:10'],
        ];
    }
}
