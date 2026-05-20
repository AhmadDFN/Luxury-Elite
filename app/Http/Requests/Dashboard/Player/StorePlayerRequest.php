<?php

namespace App\Http\Requests\Dashboard\Player;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan hanya role tertentu (misal: Owner/Admin) yang bisa nambah player
        return $this->user()->hasRole(['owner', 'admin', 'captain']);
    }

    public function rules(): array
    {
        return [
            // Rules yang sudah ada...
            'real_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'nickname' => ['required', 'string', 'max:50', 'unique:player_profiles,nickname'],
            'uid_game' => ['nullable', 'string', 'max:100'],
            'division_id' => ['required', 'exists:divisions,id'],
            'role_id' => ['required', 'exists:roles,id'],
            'status' => ['required', 'in:active,trial,exit,transfer'],

            // Rules BARU untuk kolom tambahan
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Maks 2MB
            'stats_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            // Array role
            'selected_game_roles' => ['array'],
            'selected_game_roles.*' => ['exists:game_roles,id'],
            'selected_vehicles' => ['array'],
            'selected_vehicles.*' => ['exists:vehicle_specializations,id'],

            // History Validation (Transfer)
            'record_history' => ['boolean'],
            'from_team' => ['nullable', 'string', 'max:100'],
            'to_team' => ['nullable', 'string', 'max:100'],
            'history_notes' => ['nullable', 'string', 'max:255'],
        ];
    }
}
