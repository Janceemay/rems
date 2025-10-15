<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class StorePaymentRequest extends FormRequest {
    public function authorize() {
        $user = Auth::user();
        return $user && (
            $user->isRole('Agent') ||
            $user->isRole('Sales Manager') ||
            $user->isRole('Admin')
        );
    }

    public function rules(Request $request) {
        $rules = [
            'transaction_id' => 'required|exists:transactions,transaction_id',
            'due_date' => 'nullable|date',
            'amount_due' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_status' => 'nullable|in:Pending,Paid,Overdue,Partial',
            'remarks' => 'nullable|string|max:255',
        ];

        if (in_array($request->method(), ['PUT', 'PATCH'])) {
            $rules['payment_id'] = 'sometimes|exists:payments,payment_id';
        }

        return $rules;
    }

    public function messages(){
        return [
            'transaction_id.required' => 'A transaction reference is required.',
            'transaction_id.exists' => 'The selected transaction does not exist.',
            'amount_due.required' => 'Please enter the total amount due.',
            'amount_due.min' => 'Amount due must be greater than zero.',
            'amount_paid.min' => 'Amount paid cannot be negative.',
            'payment_status.in' => 'Invalid payment status selected.',
        ];
    }
}
