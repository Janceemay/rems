@extends('components.layouts.app')

@section('title', 'Dashboard')

@section('content')
<main class="flex-1 p-6 overflow-y-auto space-y-6">
    {{-- Transaction Summary --}}
    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 mb-6">Transaction Summary</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ([
        ['label' => 'Pending', 'value' => $pending ?? 0, 'icon' => 'fi-rr-time-past', 'color' => '#2a47ff'],
        ['label' => 'Ongoing', 'value' => $ongoing ?? 0, 'icon' => 'fi-rr-refresh', 'color' => '#2a47ff'],
        ['label' => 'Completed', 'value' => $completed ?? 0, 'icon' => 'fi-rr-check', 'color' => '#2a47ff'],
        ] as $stat)
        <div class="bg-white rounded-3xl p-8 border-2 border-gray-300 flex items-center gap-6">
            <div class="bg-sky-100 p-6 rounded-full">
                <i class="{{ $stat['icon'] }} text-4xl sm:text-5xl md:text-6xl text-[#2a47ff]"></i>
            </div>
            <div>
                <div class="text-4xl sm:text-5xl md:text-6xl font-bold text-[#2a47ff]">{{ $stat['value'] }}</div>
                <div class="text-lg sm:text-xl md:text-2xl font-medium text-gray-600 mt-2">{{ $stat['label'] }} Transactions</div>
            </div>
        </div>
        @endforeach
    </div>


    {{-- Commission Charts --}}
<div class="bg-white p-8 rounded-3xl border-2 border-gray-300">
    <h4 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-6">Commission Statistics</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h5 class="text-lg sm:text-xl font-semibold mb-3 text-[#2a47ff]">My Commissions</h5>
            <div class="border rounded-xl bg-gray-100 p-6 min-h-[300px]">
                <canvas id="myCommissions"></canvas>
            </div>
        </div>
        <div>
            <h5 class="text-lg sm:text-xl font-semibold mb-3 text-[#2a47ff]">Team Commissions</h5>
            <div class="border rounded-xl bg-gray-100 p-6 min-h-[300px]">
                <canvas id="teamCommissions"></canvas>
            </div>
        </div>
    </div>
</div>

    {{-- Team Members --}}
<div class="bg-white p-8 rounded-3xl border-2 border-gray-300">
    <h4 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-6">Team Members</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse ($members as $member)
        <div class="flex items-center gap-6 border rounded-xl p-6 shadow-sm">
            <img src="{{ $member->profile_picture ? asset($member->profile_picture) : asset('images/default-profile.jpg') }}"
                 alt="Profile" class="rounded-full w-20 h-20 object-cover border">
            <div>
                <div class="text-xl font-semibold text-gray-800">{{ $member->full_name }}</div>
                <div class="text-sm text-gray-600">{{ $member->email }}</div>
                <div class="text-xs text-gray-500">{{ $member->rank }}</div>
            </div>
        </div>
        @empty
        <p class="text-gray-500">No team members found.</p>
        @endforelse
    </div>
    <div class="text-right mt-6">
        <a href="{{ route('agents.create') }}" class="bg-[#2a47ff] text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-[#2a47ff]/80 transition">
            + Add Agent
        </a>
    </div>
</div>

    {{-- All Transactions --}}
@if (!empty($transactions))
<div class="bg-white p-8 rounded-3xl border-2 border-gray-300">
    <h4 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-6">All Transactions</h4>
    <div class="space-y-6">
        @foreach($transactions as $t)
        <div class="border rounded-xl p-6 shadow-sm bg-gray-50">
            <h3 class="text-xl sm:text-2xl font-semibold text-[#2a47ff]">{{ $t->property_name ?? $t->property_code }}</h3>
            <p class="mt-3 text-gray-700"><strong>Client:</strong> {{ $t->client->user->full_name ?? 'N/A' }}</p>
            <p class="text-gray-700"><strong>Status:</strong> {{ $t->status }}</p>
        </div>
        @endforeach
    </div>
</div>
@endif

</main>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const commissionsPerYear = [1, 2, 3, 2, 1, 5, 3, 1, 2, 1, 0];
    const teamCommissionsPerYear = [5, 2, 3, 5, 1, 5, 3, 1, 3, 1, 0];

    new Chart(document.getElementById('myCommissions').getContext('2d'), {
        type: 'bar'
        , data: {
            labels: monthLabels
            , datasets: [{
                label: 'Your Commissions'
                , data: commissionsPerYear
                , backgroundColor: '#2a47ff'
            }]
        }
        , options: {
            responsive: true
            , scales: {
                y: {
                    beginAtZero: true
                    , ticks: {
                        stepSize: 1
                        , font: {
                            size: 14
                            , family: 'Roboto Mono, monospace'
                        }
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('teamCommissions').getContext('2d'), {
        type: 'line'
        , data: {
            labels: monthLabels
            , datasets: [{
                label: 'Team Commissions'
                , data: teamCommissionsPerYear
                , backgroundColor: '#2a47ff'
            }]
        }
        , options: {
            responsive: true
            , scales: {
                y: {
                    beginAtZero: true
                    , ticks: {
                        stepSize: 1
                        , font: {
                            size: 14
                            , family: 'Roboto Mono, monospace'
                        }
                    }
                }
            }
        }
    });

</script>
@endsection
