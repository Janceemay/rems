<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTransactionRequest extends FormRequest{
    public function authorize() {
        $user = Auth::user();
        return $user && ($user->isRole('Agent') || $user->isRole('Client'));
    }

    public function rules() {
        return [
            'client_id' => 'required|exists:clients,client_id',
            'agent_id' => 'required|exists:users,user_id',
            'property_id' => 'required|exists:properties,property_id',
            'notes' => 'nullable|string',
        ];
    }
}
