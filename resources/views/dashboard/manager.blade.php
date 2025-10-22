{{-- Layout --}}
@extends('components.layouts.app')

{{-- Change this when updating the title bar --}}
@section('title', 'Dashboard')

@section('content')
    <!-- Main Content -->
    <main class="flex-1 p-4">   
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6"">

          <!-- Left col -->
          <div class="lg:col-span-2 space-y-6">
            <!-- Transaction Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="flex items-center gap-x-2 mb-2">
                  <img src="{{ asset('images/icons/ongoing.png') }}" alt="ongoing" class="w-8 h-8 mb-2">
                  <h3 class="font-semibold text-blue-800 mb-1"><strong>On-going</strong></h3>
                </div>
                <p class="text-sm text-gray-500 mb-3 text-center">{{ $ongoing ?? 1 }}</p>
              </div>
              <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="flex items-center gap-x-2 mb-2">
                  <img src="{{ asset('images/icons/check-mark.png') }}" alt="completed" class="w-8 h-8 mb-2">
                  <h3 class="font-semibold text-green-800 mb-1"><strong>Completed</strong></h3>
                </div>
                <p class="text-sm text-gray-500 mb-3 text-center">{{ $completed ?? 1 }}</p>
              </div>
              <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="flex items-center gap-x-2 mb-2">
                  <img src="{{ asset('images/icons/pending.png') }}" alt="pending" class="w-8 h-8 mb-2">
                  <h3 class="font-semibold text-amber-600 mb-1"><strong>Pendings</strong></h3>
                </div>
                <p class="text-sm text-gray-500 text-center mb-3">{{ $pending ?? 1 }}</p>
              </div>
            </div>

            <!-- Staticstics -->
            <h4 class="font-bold text-lg mb-4">STATISTICS</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white rounded-xl shadow p-4 mb-6">
              <div>
                <h5 class="mb-2 font-semibold">My Commissions</h5>
                <div class="border rounded bg-gray-100 p-4 min-h-[300px]">
                  <canvas id="myCommissions"></canvas>
                </div>
              </div>
              <div>
                <h5 class="mb-2 font-semibold">Team Commissions</h5>
                <div class="border rounded bg-gray-100 p-4 min-h-[300px]">
                  <canvas id="teamCommissions"></canvas>
                </div>
              </div>
            </div>

            @if (!empty($allTransactions))
            <div class="bg-white p-4 rounded-xl shadow mb-6">
              <h4 class="font-bold mb-4">All Transactions</h4>
              <section>
                @foreach($allTransactions as $t)
                <div class="mb-4">
                  <div class="border rounded p-4 h-60">
                    <h3 class="font-semibold">{{ $t->property_name ?? $t->property_code }}</h3>
                    <p><span class="font-semibold">Client:</span> {{ $t->client->client_id }}</p>
                    <p><span class="font-semibold">Status:</span> {{ $t->status }}</p>
                  </div>
                </div>
                @endforeach
              </section>
            </div>
            @endif
          </div>

          <!-- Right col -->
          <div class="space-y-6">
            <!-- Team Members -->
            <div class="bg-white rounded-xl shadow text-gray-500 p-4 max-h-[500px] overflow-y-auto">
              <h4 class="font-bold mb-3">TEAM MEMBERS</h4>
              <div class="flex flex-col gap-3">
                @forelse ($members as $member)
                  <div class="flex items-center p-2 border rounded">
                    <img src="{{ $member->profile_picture ? asset($member->profile_picture) : asset('images/default-profile.jpg') }}"
                        alt="Profile"
                        class="rounded-full w-[60px] h-[60px] object-cover" />
                    <div class="ml-3 text-left">
                      <strong>{{ $member->full_name }}</strong><br>
                      <p class="text-sm">{{ $member->email }}</p>
                      <small class="text-gray-500">{{ $member->rank }}</small>
                    </div>
                  </div>
                @empty
                  <p class="text-gray-500">No team members found.</p>
                @endforelse

                <div class="text-right mt-4">
                  <a href="{{ route('agents.create') }}"
                    class="inline-block bg-[#6991ff] text-white font-bold rounded-full px-6 py-2 hover:bg-blue-600">
                    +
                  </a>
                </div>
              </div>
            </div>

            <!-- Calender -->
            <div x-data="calendar()" class="bg-white rounded-xl p-6 shadow-sm">
              <!-- Header -->
              <div class="flex justify-between items-center mb-4">
                <button @click="prevMonth" class="p-1 hover:bg-gray-100 rounded">
                  <i class="fas fa-chevron-left text-gray-400"></i>
                </button>
                <h3 class="font-semibold" x-text="monthYear"></h3>
                <button @click="nextMonth" class="p-1 hover:bg-gray-100 rounded">
                  <i class="fas fa-chevron-right text-gray-400"></i>
                </button>
              </div>

              <!-- Weekdays -->
              <div class="grid grid-cols-7 gap-2 mb-2">
                <template x-for="day in ['S', 'M', 'T', 'W', 'TH', 'F', 'SA']" :key="day">
                  <div class="text-center text-s text-gray-500 font-medium" x-text="day"></div>
                </template>
              </div>

              <!-- Days -->
              <div class="grid grid-cols-7 gap-2">
                <template x-for="blank in blanks" :key="'b'+blank">
                  <div></div>
                </template>
                <template x-for="day in daysInMonth" :key="day">
                  <button
                    class="aspect-square flex items-center justify-center text-sm rounded-lg transition"
                    :class="{
                      'bg-blue-400 text-gray-800 font-semibold': isToday(day),
                      'text-gray-700 hover:bg-gray-100': !isToday(day)
                    }"
                    x-text="day">
                  </button>
                </template>
              </div>
            </div>

            <!-- Team Members -->
            <div class="bg-white rounded-xl shadow text-gray-500 p-4 max-h-[500px] overflow-y-auto">
              <h4 class="font-bold mb-3">Schedules</h4>
              <div class="flex flex-col gap-3">
                <p id="note">Select a date from the calendar.</p>
                <section id="schedules">
                  <template x-for="sched in schedules" :key="sched" >
                    <p x-text="sched"></p>
                  </template>
                </section>
              </div>
            </div>
            
          </div>   
        </section>
      </div>
  </div>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
        type: 'bar',
        data: {
          labels: monthLabels,
          datasets: [{ label: label, data: data, backgroundColor: '#222849' }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                font: { size: 14, family: 'Roboto Mono, monospace' },
                stepSize: 1,
              }
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
        type: 'line',
        data: {
          labels: monthLabels,
          datasets: [{ label: label, data: data, backgroundColor: '#222849' }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                font: { size: 14, family: 'Roboto Mono, monospace' },
                stepSize: 1,
              }
            }
          }
        }
      });
    }
    teamChart(teamCommissionsPerYear, 'Team Commissions');

    function calendar() {
      return {
        date: new Date(),
        get month() {
          return this.date.getMonth();
        },
        get year() {
          return this.date.getFullYear();
        },
        get monthYear() {
          return this.date.toLocaleString('default', { month: 'long', year: 'numeric' });
        },
        get daysInMonth() {
          const days = new Date(this.year, this.month + 1, 0).getDate();
          return Array.from({ length: days }, (_, i) => i + 1);
        },
        get blanks() {
          const firstDay = new Date(this.year, this.month, 1).getDay(); // 0 = Sunday
          return Array.from({ length: firstDay }, (_, i) => i);
        },
        isToday(day) {
          const today = new Date();
          return (
            day == today.getDate() &&
            this.month == today.getMonth() &&
            this.year == today.getFullYear()
          );
        },
        nextMonth() {
          this.date.setMonth(this.month + 1);
          this.date = new Date(this.date); // force reactivity
        },
        prevMonth() {
          this.date.setMonth(this.month - 1);
          this.date = new Date(this.date); // force reactivity
        }
      };
    }
    function show(day, monthYear) {
      let note = document.getElementById('note');
      const monthYearSplit = monthYear.split(" ");
      var schedules = document.getElementById('schedules');

      note.innerHTML = "Schedules for " + monthYearSplit[0] + " " + day + ", " + monthYearSplit[1] + ":";
    }
  </script>

</main>
@endsection