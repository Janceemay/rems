<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Transaction::with(['client.user', 'agent', 'property'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Transaction ID',
            'Client Name',
            'Agent Name',
            'Property Title',
            'Status',
            'Total Amount',
            'Request Date',
            'Approval Date'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_id,
            optional($transaction->client->user)->full_name,
            optional($transaction->agent)->full_name,
            optional($transaction->property)->title,
            $transaction->status,
            $transaction->total_amount ?? 'N/A',
            optional($transaction->request_date)->format('Y-m-d'),
            optional($transaction->approval_date)->format('Y-m-d'),
        ];
    }
}
