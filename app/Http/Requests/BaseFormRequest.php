<?php

namespace App\Http\Requests;

use App\Helpers\RestActions;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class BaseFormRequest extends FormRequest
{
    use RestActions, SoftDeletes;
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
        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->respondJson('unprocessable_entity', [], $validator->errors())
        );
    }
}
