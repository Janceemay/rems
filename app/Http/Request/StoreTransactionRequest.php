<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest{
    public function authorize() {
        return $this->user()->isRole('Agent') || $this->user()->isRole('Client');
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
