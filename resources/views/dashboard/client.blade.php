{{-- Layout --}}
@extends('components.layouts.app')

{{-- Change this when updating the title bar --}}
@section('title', 'Dashboard')

@section('content')
{{-- Main Content --}}
<main class="flex-1 p-6 overflow-y-auto space-y-6">
    {{-- Status Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="flex items-center p-6 rounded-3xl border-2 border-gray-300 gap-5">
            {{-- Icon --}}
            <div class="bg-sky-200 size-16 md:size-20 lg:size-24 flex items-center justify-center rounded-full">
                <i class="fi fi-rr-coins text-3xl md:text-4xl lg:text-5xl text-[#2a47ff]"></i>
            </div>

            <!-- Stat Content -->
            <div class="">
                <div class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-bold text-[#2a47ff]">
                    ₱{{ number_format($totalBalance, 2) }}
                </div>
                <div class="mt-2 text-sm sm:text-base md:text-lg lg:text-xl font-light text-gray-700">
                    Balance
                </div>
                <div class="mt-1 text-sm sm:text-base md:text-lg lg:text-xl font-semibold text-[#2a47ff]">
                    {{ $balancePercent }}%
                </div>
            </div>
        </div>

        <div class="flex items-center p-6 rounded-3xl border-2 border-gray-300 gap-5">
            {{-- Icon --}}
            <div class="bg-sky-200 size-16 md:size-20 lg:size-24 flex items-center justify-center rounded-full">
                <i class="fi fi-rr-credit-card text-3xl md:text-4xl lg:text-5xl text-[#2a47ff]"></i>
            </div>

            <!-- Stat Content -->
            <div>
                <div class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-bold text-[#2a47ff]">
                    ₱{{ number_format($totalPaid, 2) }}
                </div>
                <div class="mt-2 text-sm sm:text-base md:text-lg lg:text-xl font-light text-gray-700">
                    Paid
                </div>
                <div class="mt-1 text-sm sm:text-base md:text-lg lg:text-xl font-semibold text-[#2a47ff]">
                    {{ $paidPercent }}%
                </div>
            </div>
        </div>
    </div>

    {{-- Property Info --}}
    <div class="bg-white rounded-3xl border-2 border-gray-300 p-6">
        <h5 class="text-xl font-bold mb-2">Name of Property Currently Paying</h5>
        <p class="text-sm text-gray-700">{{ $property['description'] ?? 'No description available.' }}</p>
    </div>

    {{-- Transactions --}}
    <div class="bg-white rounded-3xl border-2 border-gray-300 p-6">
        <h5 class="text-lg font-bold mb-4">Transactions</h5>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="border-b font-semibold text-gray-700">
                    <tr>
                        <th class="text-left py-2">Account Name</th>
                        <th class="text-left py-2">Amount</th>
                        <th class="text-left py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $t)
                    <tr class="border-b">
                        <td class="py-2 text-gray-800">
                            <i class="fa-solid fa-wallet mr-2 text-blue-600"></i>{{ $t['name'] }}
                        </td>
                        <td class="py-2 text-gray-800">₱ {{ number_format($t['amount'], 2) }}</td>
                        <td class="py-2 text-gray-800">{{ $t['date'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500">No transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>
</div>
@endsection
