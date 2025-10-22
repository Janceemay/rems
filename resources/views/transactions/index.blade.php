@extends('components.layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800">Transactions</h2>
            @if(auth()->user()->isRole('Admin') || auth()->user()->isRole('Sales Manager') || auth()->user()->isRole('Agent'))
            <a href="{{ route('transactions.create') }}" class="px-6 py-2 bg-[#2a47ff] text-white rounded-full hover:bg-[#2a47ff]/80 font-semibold transition">
                <i class="bi bi-plus-circle"></i> New Transaction
            </a>
            @endif
        </div>

        {{-- Transactions Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Client</th>
                        <th class="px-6 py-3 text-left">Property</th>
                        <th class="px-6 py-3 text-left">Agent</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transactions as $t)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $t->transaction_id }}</td>
                        <td class="px-6 py-4">{{ $t->client->user->full_name }}</td>
                        <td class="px-6 py-4">{{ $t->property->title ?? $t->property->property_code }}</td>
                        <td class="px-6 py-4">{{ $t->agent->full_name }}</td>
                        <td class="px-6 py-4">
                            <div>
                                <span class="inline-block px-3 py-1 rounded-full text-white text-xs font-semibold
            {{ $t->status === 'pending' ? 'bg-yellow-500' : '' }}
            {{ $t->status === 'approved' ? 'bg-green-600' : '' }}
            {{ $t->status === 'canceled' ? 'bg-red-600' : '' }}">
                                    {{ ucfirst($t->status) }}
                                </span>
                                @if($t->status === 'canceled' && $t->cancellation_reason)
                                <p class="text-xs text-gray-500 mt-1 italic">Reason: {{ $t->cancellation_reason }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('transactions.show', $t->transaction_id) }}" class="text-[#2a47ff] hover:underline font-medium text-sm">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
