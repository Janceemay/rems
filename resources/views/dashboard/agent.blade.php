{{-- Layout --}}
@extends('components.layouts.app')

{{-- Change this when updating the title bar --}}
@section('title', 'Dashboard')

@section('content')
{{-- Main Content --}}
<main class="flex-1 p-6 overflow-y-auto space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {{-- Total Commissions --}}
        <div class="flex items-center p-6 rounded-3xl border-2 border-gray-300 gap-5">
            <!-- Icon -->
            <div class="bg-sky-200 size-16 md:size-20 lg:size-24 flex items-center justify-center rounded-full">
                <i class="fi fi-rr-coins text-3xl md:text-4xl lg:text-5xl text-[#2a47ff]"></i>
            </div>

            {{-- Stat Content --}}
            <div>
                <div class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-bold text-[#2a47ff]">₱0</div>
                <div class="mt-2 text-sm sm:text-base md:text-lg lg:text-xl font-light text-gray-700">Total Commissions</div>
            </div>
        </div>

        <!-- Ongoing Commissions -->
        <div class="flex items-center p-6 rounded-3xl border-2 border-gray-300 gap-5">
            <!-- Icon -->
            <div class="bg-sky-200 size-16 md:size-20 lg:size-24 flex items-center justify-center rounded-full">
                <i class="fi fi-br-refresh text-3xl md:text-4xl lg:text-5xl text-[#2a47ff]"></i>
            </div>

            <!-- Stat Content -->
            <div>
                <div class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-bold text-[#2a47ff]">₱0</div>
                <div class="mt-2 text-sm sm:text-base md:text-lg lg:text-xl font-light text-gray-700">Ongoing Commissions</div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="flex items-center p-6 rounded-3xl border-2 border-gray-300 gap-5">
            <!-- Icon -->
            <div class="bg-sky-200 size-16 md:size-20 lg:size-24 flex items-center justify-center rounded-full">
                <i class="fi fi-br-time-past text-3xl md:text-4xl lg:text-5xl text-[#2a47ff]"></i>
            </div>

            <!-- Stat Content -->
            <div>
                <div class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-bold text-[#2a47ff]">₱0</div>
                <div class="mt-2 text-sm sm:text-base md:text-lg lg:text-xl font-light text-gray-700">Pending Approvals</div>
            </div>
        </div>
    </div>

    <!-- Active Transaction -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h5 class="font-bold mb-4 text-lg">Active Transaction</h5>
        <div class="border p-4 min-h-[320px] flex items-start rounded">
            <section>
                <h3 class="text-xl font-semibold">PropName</h3>
                <h5 class="mt-2">Client Name</h5>
                <h5>Status</h5>
            </section>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h4 class="font-bold mb-6 text-lg">Statistics</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h5 class="mb-2 font-semibold">My Commissions</h5>
                <div class="border min-h-[300px] p-2 rounded">
                    <canvas id="myCommissions"></canvas>
                </div>
            </div>
            <div>
                <h5 class="mb-2 font-semibold">Team Commissions</h5>
                <div class="border min-h-[300px] p-2 rounded">
                    <canvas id="teamCommissions"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Contribution & Team Members -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow min-h-[320px]">
            <h4 class="font-bold mb-4 text-lg">Contribution By Team Member</h4>
            <div class="border h-full rounded"></div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow min-h-[320px]">
            <h4 class="font-bold mb-4 text-lg">Team Members</h4>
            <p>List</p>
        </div>
    </div>

    <!-- All Transactions -->
    @if (!empty($allTransactions))
    <div class="bg-white p-6 rounded-lg shadow">
        <h4 class="font-bold mb-6 text-lg">All Transactions</h4>
        <section class="space-y-4">
            @foreach($allTransactions as $t)
            <div class="border rounded p-4 min-h-[240px]">
                <section>
                    <h3 class="text-xl font-semibold">{{ $t->property_name ?? $t->property_code }}</h3>
                    <h5 class="mt-2">Client: {{ $t->client->client_id }}</h5>
                    <h5>Status: {{ $t->status }}</h5>
                </section>
            </div>
            @endforeach
        </section>
    </div>
    @endif

</main>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const commissionsPerYear = [1, 2, 3, 2, 1, 5, 3, 1, 2, 1, 0];
    const teamCommissionsPerYear = [5, 2, 3, 5, 1, 5, 3, 1, 3, 1, 0];

    const myCommCtx = document.getElementById('myCommissions').getContext('2d');
    const teamCommCtx = document.getElementById('teamCommissions').getContext('2d');

    let myCommissionsChart;

    function myChart(data, label) {
        if (myCommissionsChart) myCommissionsChart.destroy();
        myCommissionsChart = new Chart(myCommCtx, {
            type: 'bar'
            , data: {
                labels: monthLabels
                , datasets: [{
                    label: label
                    , data: data
                    , backgroundColor: '#2a47ff'
                }]
            }
            , options: {
                responsive: true
                , scales: {
                    y: {
                        beginAtZero: true
                        , ticks: {
                            font: {
                                size: 14
                                , family: 'Roboto Mono, monospace'
                            }
                            , stepSize: 1
                        , }
                    }
                }
            }
        });
    }
    myChart(commissionsPerYear, 'Your Commissions');

    let teamCommissionsChart;

    function teamChart(data, label) {
        if (teamCommissionsChart) teamCommissionsChart.destroy();
        teamCommissionsChart = new Chart(teamCommCtx, {
            type: 'line'
            , data: {
                labels: monthLabels
                , datasets: [{
                    label: label
                    , data: data
                    , backgroundColor: '#2a47ff'
                }]
            }
            , options: {
                responsive: true
                , scales: {
                    y: {
                        beginAtZero: true
                        , ticks: {
                            font: {
                                size: 14
                                , family: 'Roboto Mono, monospace'
                            }
                            , stepSize: 1
                        , }
                    }
                }
            }
        });
    }
    teamChart(teamCommissionsPerYear, 'Team Commissions');

</script>
@endsection
