<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'real_name' => [
                'required',
                'string',
                'max:255'
            ],

            'nickname' => [
                'required',
                'string',
                'max:255',
                'unique:player_profiles,nickname'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'min:8'
            ],

            'uid_game' => [
                'nullable',
                'string'
            ],

            'division_id' => [
                'required',
                'exists:divisions,id'
            ],

            'role_id' => [
                'required',
                'exists:roles,id'
            ],

        ];
    }
}
