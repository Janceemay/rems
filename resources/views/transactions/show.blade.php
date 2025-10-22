@extends('components.layouts.app')

@section('content')
<div class="p-8" x-data="{ showCancelModal: false }">
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800">
                Transaction #{{ $transaction->transaction_id }}
            </h2>
            <span class="inline-block px-4 py-2 rounded-full text-white font-semibold text-sm
                {{ $transaction->status === 'pending' ? 'bg-yellow-500' : '' }}
                {{ $transaction->status === 'approved' ? 'bg-green-600' : '' }}
                {{ $transaction->status === 'cancelled' ? 'bg-red-600' : '' }}">
                {{ ucfirst($transaction->status) }}
            </span>
        </div>

        {{-- Transaction Details --}}
        <div class="bg-white border-2 border-gray-300 rounded-3xl p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                <div><strong>Client:</strong> {{ $transaction->client->user->full_name }}</div>
                <div><strong>Property:</strong> {{ $transaction->property->title }}</div>
                <div><strong>Agent:</strong> {{ $transaction->agent->full_name }}</div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-4 mt-4">
                @if(auth()->user()->isRole('Sales Manager') && $transaction->status !== 'approved')
                <form method="POST" action="{{ route('transactions.approve', $transaction->transaction_id) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="bi bi-check-circle"></i> Approve
                    </button>
                </form>
                @endif

                @if(auth()->user()->isRole('Agent') || auth()->user()->isRole('Sales Manager'))
                @if($transaction->status === 'canceled')
                <div class="flex flex-col gap-2">
                    <button disabled class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed">
                        <i class="bi bi-x-circle"></i> Transaction Canceled
                    </button>
                    @if($transaction->cancellation_reason)
                    <p class="text-sm text-gray-600 italic">
                        Reason: {{ $transaction->cancellation_reason }}
                    </p>
                    @endif
                </div>
                @else
                <button @click="showCancelModal = true" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    <i class="bi bi-x-circle"></i> Cancel Transaction
                </button>
                @endif
                @endif
            </div>
        </div>

        {{-- Payments Table --}}
        <div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Payments</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-left">Due Date</th>
                            <th class="px-6 py-3 text-left">Amount Due</th>
                            <th class="px-6 py-3 text-left">Amount Paid</th>
                            <th class="px-6 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($transaction->payments as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $p->due_date }}</td>
                            <td class="px-6 py-4">₱{{ number_format($p->amount_due, 2) }}</td>
                            <td class="px-6 py-4">₱{{ number_format($p->amount_paid, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 rounded-full text-white text-xs font-semibold
                                        {{ $p->payment_status === 'paid' ? 'bg-green-600' : '' }}
                                        {{ $p->payment_status === 'unpaid' ? 'bg-red-600' : '' }}
                                        {{ $p->payment_status === 'partial' ? 'bg-yellow-500' : '' }}">
                                    {{ ucfirst($p->payment_status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No payments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Cancel Modal --}}
    <div x-show="showCancelModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="showCancelModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 space-y-4">

            <h3 class="text-lg font-bold text-gray-800">Cancel Transaction</h3>
            <p class="text-sm text-gray-600">Please provide a reason for cancellation.</p>

            <form method="POST" action="{{ route('transactions.cancel', $transaction->transaction_id) }}" class="space-y-4">
                @csrf
                <input type="text" name="reason" required placeholder="Cancellation reason" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showCancelModal = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Close
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
