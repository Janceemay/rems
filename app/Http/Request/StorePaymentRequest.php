<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePaymentRequest extends FormRequest{
    public function authorize() {
        $user = Auth::user();
        return $user && ($user->isRole('Agent') || $user->isRole('Sales Manager'));
    }

    public function rules() {
        return [
            'transaction_id' => 'required|exists:transactions,transaction_id',
            'due_date' => 'nullable|date',
            'amount_due' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_status' => 'nullable|in:Pending,Paid,Overdue',
            'remarks' => 'nullable|string',
        ];
    }
}
