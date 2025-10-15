<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePropertyRequest extends FormRequest {
    public function authorize()
    {
        $user = Auth::user();
        return $user && ($user->isRole('Admin') || $user->isRole('Sales Manager'));
    }

    public function rules() {
        $propertyId = $this->route('property')?->property_id ?? null;

        return [
            'developer_id' => 'nullable|exists:developers,developer_id',
            'property_code' => 'nullable|string|max:50|unique:properties,property_code,' . $propertyId . ',property_id',
            'property_type' => 'required|string|in:Condominium,House,Lot,Apartment,Townhouse',
            'title' => 'required|string|max:150',
            'location' => 'required|string|max:255',
            'size' => 'nullable|numeric|min:1|max:1000000',
            'price' => 'required|numeric|min:0',
            'status' => 'nullable|in:Available,Reserved,Sold,Archived',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'floor_plan' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        ];
    }

    public function messages() {
        return [
            'developer_id.exists' => 'The selected developer does not exist.',
            'property_code.unique' => 'This property code already exists.',
            'property_type.required' => 'Please select the property type.',
            'title.required' => 'The property title is required.',
            'location.required' => 'The location field is required.',
            'price.required' => 'Please enter the property price.',
            'price.min' => 'The price cannot be negative.',
            'image.image' => 'The image must be a valid image file (JPG or PNG).',
            'floor_plan.mimes' => 'The floor plan must be a PDF or image file.',
        ];
    }
}
