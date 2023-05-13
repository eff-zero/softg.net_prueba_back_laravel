<?php

namespace App\Modules\RouteModule\validations;

use App\Http\Requests\BaseFormRequest;

class StoreRouteRequest extends BaseFormRequest
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
            'name' => ['required', 'string', 'min:5'],
            'description' => ['required', 'string', 'min:10'],
            'driver_id' => ['required',],
            'vehicle_id' => ['required',],
        ];
    }
}
