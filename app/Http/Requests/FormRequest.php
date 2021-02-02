<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

class FormRequest extends LaravelFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|string|max:255',
            'cpf' => 'required|max:11|cpf|unique:forms',
            'birthdate' => 'required|date',
            'prioritygroup_id' => 'required',
            'vacinationplace_id' => 'required',
            'gender' => 'required',
            'public_place' => 'required|string|max:255',
            'place_number' => 'required|string|max:255',
            'neighborhood' => 'required|max:255',
            'city' => 'required',
            //'application_date_vaccine' => 'required|date'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
