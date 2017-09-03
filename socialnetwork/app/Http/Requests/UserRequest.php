<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [

            ],
            'password' => [

            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users',
            ],
            'number' => [

            ],
            'first_name' => [

            ],
            'last_name' => [

            ],
            'third_name' => [

            ],
            'country' => [

            ],
            'city' => [

            ]
        ];
    }
}
