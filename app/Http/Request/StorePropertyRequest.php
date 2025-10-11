<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePropertyRequest extends FormRequest {
    public function authorize() {
        $user = Auth::user();
        return $user && ($user->isRole('Sales Manager') || $user->isRole('Admin'));
    }

    public function rules() {
        return [
            'developer_id' => 'nullable|exists:developers,developer_id',
            'property_code' => 'nullable|string|max:50|unique:properties,property_code',
            'property_type' => 'required|in:Condominium,House,Lot,Apartment,Townhouse',
            'title' => 'nullable|string|max:150',
            'location' => 'nullable|string',
            'size' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'status' => 'nullable|in:Available,Reserved,Sold,Archived',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'floor_plan' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ];
    }
}
