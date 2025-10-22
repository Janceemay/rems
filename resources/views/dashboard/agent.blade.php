@extends('components.layouts.app')

@section('title', 'Dashboard')

@section('content')
<main class="flex-1 p-6 overflow-y-auto space-y-6">

    {{-- Commission Summary --}}
    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 mb-6">Commission Summary</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach([
        ['label' => 'Total Commissions', 'value' => '₱' . number_format($totalCommission ?? 0, 2), 'icon' => 'fi-rr-coins'],
        ['label' => 'Ongoing Commissions', 'value' => $ongoing ?? 0, 'icon' => 'fi-br-refresh'],
        ['label' => 'Pending Approvals', 'value' => $pending ?? 0, 'icon' => 'fi-br-time-past'],
        ] as $stat)
        <div class="flex items-center p-8 rounded-3xl border-2 border-gray-300 gap-6 bg-white shadow-sm">
            <div class="bg-sky-200 size-20 md:size-24 lg:size-28 flex items-center justify-center rounded-full">
                <i class="{{ $stat['icon'] }} text-4xl md:text-5xl lg:text-6xl text-[#2a47ff]"></i>
            </div>
            <div>
                <div class="text-4xl sm:text-5xl md:text-6xl font-bold text-[#2a47ff]">{{ $stat['value'] }}</div>
                <div class="mt-2 text-lg md:text-xl font-light text-gray-700">{{ $stat['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Active Transaction --}}
    <div class="bg-white p-8 rounded-3xl border-2 border-gray-300 shadow-sm">
        <h4 class="text-2xl font-bold text-gray-800 mb-4">Active Transaction</h4>
        <div class="border p-6 rounded-xl min-h-[320px] bg-gray-50">
            @if($activeTransaction)
            <h3 class="text-xl font-semibold text-[#2a47ff]">
                {{ $activeTransaction->property->title ?? $activeTransaction->property->property_code }}
            </h3>
            <p class="mt-2 text-gray-700">Client: {{ $activeTransaction->client->user->full_name }}</p>
            <p class="text-gray-700">Status: {{ ucfirst($activeTransaction->status) }}</p>
            @else
            <p class="text-gray-500 italic">No active transaction found.</p>
            @endif
        </div>
    </div>

    {{-- Commission Charts --}}
    <div class="bg-white p-8 rounded-3xl border-2 border-gray-300 shadow-sm">
        <h4 class="text-2xl font-bold text-gray-800 mb-6">Statistics</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h5 class="text-lg font-semibold mb-3 text-[#2a47ff]">My Commissions</h5>
                <div class="border rounded-xl bg-gray-100 p-6 min-h-[300px]">
                    <canvas id="myCommissions"></canvas>
                </div>
            </div>
            <div>
                <h5 class="text-lg font-semibold mb-3 text-[#2a47ff]">Team Commissions</h5>
                <div class="border rounded-xl bg-gray-100 p-6 min-h-[300px]">
                    <canvas id="teamCommissions"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Contribution & Team Members --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white p-8 rounded-3xl border-2 border-gray-300 shadow-sm min-h-[320px]">
            <h4 class="text-2xl font-bold text-gray-800 mb-4">Contribution By Team Member</h4>
            @if(!empty($contributionLabels) && array_sum($contributionValues) > 0)
            <canvas id="teamContributionChart" class="w-full h-full"></canvas>
            @else
            <p class="text-gray-500 italic">No contribution data available.</p>
            @endif
        </div>
        <div class="bg-white p-8 rounded-3xl border-2 border-gray-300 shadow-sm min-h-[320px]">
            <h4 class="text-2xl font-bold text-gray-800 mb-4">Team Members</h4>
            @if($teamMembers->isNotEmpty())
            <ul class="list-disc pl-4 text-gray-700 space-y-1">
                @foreach($teamMembers as $member)
                <li>{{ $member->full_name }}</li>
                @endforeach
            </ul>
            @else
            <p class="text-gray-500 italic">No team members assigned.</p>
            @endif
        </div>
    </div>

    {{-- All Transactions --}}
    @if (!empty($allTransactions))
    <div class="bg-white p-8 rounded-3xl border-2 border-gray-300 shadow-sm">
        <h4 class="text-2xl font-bold text-gray-800 mb-6">All Transactions</h4>
        <section class="space-y-6">
            @foreach($allTransactions as $t)
            <div class="border rounded-xl p-6 bg-gray-50 min-h-[240px] shadow-sm">
                <h3 class="text-xl font-semibold text-[#2a47ff]">{{ $t->property_name ?? $t->property_code }}</h3>
                <p class="mt-2 text-gray-700">Client: {{ $t->client->client_id }}</p>
                <p class="text-gray-700">Status: {{ $t->status }}</p>
            </div>
            @endforeach
        </section>
    </div>
    @endif

</main>

{{-- Chart.js and DataLabels plugin --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Monthly labels
        const monthLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Static commission data
        const commissionsPerYear = [1, 2, 3, 2, 1, 5, 3, 1, 2, 1, 0];
        const teamCommissionsPerYear = [5, 2, 3, 5, 1, 5, 3, 1, 3, 1, 0];

        // My Commissions Chart
        const myCommissionsCanvas = document.getElementById('myCommissions');
        if (myCommissionsCanvas) {
            new Chart(myCommissionsCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: 'Your Commissions',
                        data: commissionsPerYear,
                        backgroundColor: '#2a47ff'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 14,
                                    family: 'Roboto Mono, monospace'
                                }
                            }
                        }
                    }
                }
            });
        }

        // Team Commissions Chart
        const teamCommissionsCanvas = document.getElementById('teamCommissions');
        if (teamCommissionsCanvas) {
            new Chart(teamCommissionsCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: 'Team Commissions',
                        data: teamCommissionsPerYear,
                        backgroundColor: '#2a47ff',
                        borderColor: '#2a47ff',
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 14,
                                    family: 'Roboto Mono, monospace'
                                }
                            }
                        }
                    }
                }
            });
        }

        // Team Contribution Doughnut Chart
        const contributionLabels = {!! json_encode($contributionLabels ?? []) !!};
        const contributionValues = {!! json_encode($contributionValues ?? []) !!};
        const teamContributionCanvas = document.getElementById('teamContributionChart');

        if (
            teamContributionCanvas &&
            contributionLabels.length &&
            contributionValues.length &&
            contributionValues.reduce((a, b) => a + b, 0) > 0
        ) {
            new Chart(teamContributionCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: contributionLabels,
                    datasets: [{
                        data: contributionValues,
                        backgroundColor: ['#2a47ff', '#38bdf8', '#facc15', '#f87171', '#34d399']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                const total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                return total ? ((value / total) * 100).toFixed(1) + '%' : '0%';
                            },
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 14
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        } else {
            console.warn("No contribution data available or canvas missing.");
        }
    });
</script>
@endsection
