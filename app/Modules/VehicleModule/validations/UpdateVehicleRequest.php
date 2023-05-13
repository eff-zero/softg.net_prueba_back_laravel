<?php

namespace App\Modules\VehicleModule\validations;

use App\Http\Requests\BaseFormRequest;

class UpdateVehicleRequest extends BaseFormRequest
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
            'description' => ['required', 'string'],
            'year' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 1),],
            'mark' => ['required', 'string'],
            'capacity' => ['required', 'numeric'],
            'active' => [],
        ];
    }
}
