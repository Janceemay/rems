<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest{
    public function authorize() {
        return $this->user()->isRole('Agent') || $this->user()->isRole('Sales Manager');
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
