@extends('components.layouts.app')

@section('title', 'Dashboard')

@section('content')
<main class="flex-1 p-6 overflow-y-auto space-y-6">

    {{-- Balance Summary --}}
    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 mb-6">Balance Summary</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach([
            ['label' => 'Balance', 'value' => $totalBalance ?? 0, 'percent' => $balancePercent ?? 0, 'icon' => 'fi-rr-coins'],
            ['label' => 'Paid', 'value' => $totalPaid ?? 0, 'percent' => $paidPercent ?? 0, 'icon' => 'fi-rr-credit-card'],
        ] as $stat)
        <div class="flex items-center p-8 rounded-3xl border-2 border-gray-300 gap-6 bg-white">
            <div class="bg-sky-200 size-20 md:size-24 lg:size-28 flex items-center justify-center rounded-full">
                <i class="{{ $stat['icon'] }} text-4xl md:text-5xl lg:text-6xl text-[#2a47ff]"></i>
            </div>
            <div>
                <div class="text-4xl sm:text-5xl md:text-6xl font-bold text-[#2a47ff]">
                    ₱{{ number_format($stat['value'], 2) }}
                </div>
                <div class="mt-2 text-lg md:text-xl font-light text-gray-700">
                    {{ $stat['label'] }}
                </div>
                <div class="mt-1 text-lg md:text-xl font-semibold text-[#2a47ff]">
                    {{ $stat['percent'] }}%
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Property Info --}}
    <div class="bg-white p-8 rounded-3xl border-2 border-gray-300 shadow-sm">
        <h4 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4">Current Property</h4>
        @if(!empty($property))
            <p class="text-base text-gray-700 mb-2">{{ $property['description'] ?? 'No description available.' }}</p>
            <a href="{{ route('properties.show', $property['property_id']) }}"
               class="inline-block mt-2 px-4 py-2 bg-[#2a47ff] text-white rounded-full hover:bg-[#2a47ff]/80 font-semibold transition">
                <i class="bi bi-house-door"></i> View Property
            </a>
        @else
            <p class="text-base text-gray-600 mb-4">You have no active property.</p>
            <a href="{{ route('properties.index') }}"
               class="inline-block px-4 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 font-semibold transition">
                <i class="bi bi-search"></i> Browse Properties
            </a>
        @endif
    </div>

    {{-- Transactions --}}
    <div class="bg-white p-8 rounded-3xl border-2 border-gray-300 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800">Transactions</h4>
            <a href="{{ route('transactions.index') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 font-semibold transition">
                <i class="bi bi-list-ul"></i> View All
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-base">
                <thead class="border-b-2 border-gray-300 font-semibold text-gray-700">
                    <tr>
                        <th class="text-left py-3">Account Name</th>
                        <th class="text-left py-3">Amount</th>
                        <th class="text-left py-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $t)
                    <tr class="border-b border-gray-200">
                        <td class="py-3 text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-wallet text-blue-600"></i>{{ $t['name'] }}
                        </td>
                        <td class="py-3 text-gray-800">
                            ₱{{ number_format($t['amount'], 2) }}
                            @if(!empty($t['status']))
                                <span class="ml-2 inline-block px-2 py-1 rounded-full text-xs font-semibold text-white
                                    {{ $t['status'] === 'pending' ? 'bg-yellow-500' : '' }}
                                    {{ $t['status'] === 'approved' ? 'bg-green-600' : '' }}
                                    {{ $t['status'] === 'canceled' ? 'bg-red-600' : '' }}">
                                    {{ ucfirst($t['status']) }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3 text-gray-800">{{ $t['date'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-6 text-center text-gray-500">No transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
