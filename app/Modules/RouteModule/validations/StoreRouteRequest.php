<?php

namespace App\Modules\RouteModule\validations;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

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
            'driver_id' => ['required', Rule::exists('users', 'id')->whereNotNull('ssn')->whereNotNull('deleted_at')],
            'vehicle_id' => ['required', Rule::exists('vehicles', 'id')->where('active', 1)->whereNotNull('deleted_at')],
        ];
    }
}
