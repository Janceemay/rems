<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use App\Models\Property;
use App\Models\Transaction;

class StoreTransactionRequest extends FormRequest
{
    public function authorize()
    {
        $user = Auth::user();
        return $user && (
            $user->isRole('Agent') ||
            $user->isRole('Client') ||
            $user->isRole('Sales Manager') ||
            $user->isRole('Admin')
        );
    }

    public function rules()
    {
        $user = Auth::user();
        $isClient = $user && $user->isRole('Client');

        $rules = [
            'property_id' => 'required|exists:properties,property_id',
            'notes' => 'nullable|string|max:1000',
        ];

        if ($isClient) {
            $rules['client_id'] = 'required|exists:clients,client_id';
            $rules['inquiry_details'] = 'nullable|string|max:1000';
        } else {
            $rules['client_id'] = 'required|exists:clients,client_id';
            $rules['agent_id'] = 'nullable|exists:users,user_id';
        }

        return $rules;
    }

    public function withValidator(Validator $validator)
    {
        $user = Auth::user();
        $isClient = $user && $user->isRole('Client');

        $validator->after(function ($validator) use ($isClient) {
            $propertyId = $validator->input('property_id');
            $clientId = $validator->input('client_id');

            $property = Property::find($propertyId);
            if ($property && $property->status !== 'Available') {
                $validator->errors()->add('property_id', 'The selected property is not available for transaction.');
            }

            if (!$isClient && $clientId && $propertyId) {
                $exists = Transaction::where('client_id', $clientId)
                    ->where('property_id', $propertyId)
                    ->whereNotIn('status', ['Cancelled'])
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('property_id', 'This client already has a transaction for this property.');
                }
            }
        });
    }

    public function messages()
    {
        return [
            'client_id.required'   => 'Please select a valid client.',
            'client_id.exists'     => 'The selected client does not exist.',
            'agent_id.required'    => 'Please select an agent.',
            'agent_id.exists'      => 'The selected agent is invalid.',
            'property_id.required' => 'A property must be selected.',
            'property_id.exists'   => 'The selected property does not exist.',
            'notes.string'         => 'Additional notes must be text.',
        ];
    }
}
