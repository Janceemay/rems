<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: #98DED9;
    }
  </style>
</head>
<body class="flex flex-row">
  <aside class="w-1/4">
    <div class="bg-white p-4 h-full shadow rounded">
      <h1 class="font-bold text-xl mb-4">K.Palafox Realty</h1>
      <nav>
        <ul class="space-y-4">
          <li><a class="text-black no-underline" href="{{ route('profiles.agent') }}">My Profile</a></li>
          <li><a class="text-black no-underline" href="{{ route('dashboard.agent') }}">Dashboard</a></li>
          <li>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" type="submit">Logout</button>
            </form>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="w-3/4 p-4 h-screen overflow-y-auto">
    <div class="flex flex-wrap -mx-2">
      <div class="w-full md:w-1/3 px-2 mt-2">
        <div class="text-center text-white p-4 rounded shadow" style="background: #67aa5aff">
          <h4 class="font-bold">Total Commissions</h4>
          <h1>0</h1>
        </div>
      </div>
      <div class="w-full md:w-1/3 px-2 mt-2">
        <div class="text-center p-4 rounded shadow" style="background: #C7FFD8">
          <h4 class="font-bold">Ongoing Commissions</h4>
          <h1>0</h1>
        </div>
      </div>
      <div class="w-full md:w-1/3 px-2 mt-2">
        <div class="text-center p-4 rounded shadow" style="background: rgba(255, 187, 110, 1)">
          <h4 class="font-bold">Pending Approvals</h4>
          <h1>0</h1>
        </div>
      </div>
    </div>

    <div class="bg-white p-4 mt-4 rounded shadow">
      <h5 class="font-bold mb-2">Active Transaction</h5>
      <div class="border flex items-baseline h-80 p-4">
        <section>
          <h3>PropName</h3>
          <h5>Client Name</h5>
          <h5>Status</h5>
        </section>
      </div>
    </div>

    <div class="bg-white p-4 mt-4 rounded shadow">
      <h4 class="font-bold mb-4">Statistics</h4>
      <div class="flex flex-wrap -mx-2">
        <div class="w-full md:w-1/2 px-2 mb-4">
          <h5 class="mb-2">My Commissions</h5>
          <div class="border min-h-[300px] p-2">
            <canvas id="myCommissions"></canvas>
          </div>
        </div>
        <div class="w-full md:w-1/2 px-2 mb-4">
          <h5 class="mb-2">Team Commissions</h5>
          <div class="border min-h-[300px] p-2">
            <canvas id="teamCommissions"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-wrap -mx-2 mt-2">
      <div class="w-full md:w-2/3 px-2">
        <div class="bg-white p-4 rounded shadow h-80">
          <h4 class="font-bold mb-2">Contribution By Team Member</h4>
          <div class="border h-full"></div>
        </div>
      </div>
      <div class="w-full md:w-1/3 px-2">
        <div class="bg-white p-4 rounded shadow h-80">
          <h4 class="font-bold mb-2">Team Members</h4>
          <p>List</p>
        </div>
      </div>
    </div>

    @if (!empty($allTransactions))
    <div class="mt-4">
      <div class="bg-white p-4 rounded shadow">
        <h4 class="font-bold mb-4">All Transactions</h4>
        <section>
          @foreach($allTransactions as $t)
          <div class="mb-4">
            <div class="border rounded p-4 h-60">
              <section>
                <h3>{{ $t->property_name ?? $t->property_code }}</h3>
                <h5>Client: </h5>{{ $t->client->client_id }}
                <h5>Status: </h5>{{ $t->status }}
              </section>
            </div>
          </div>
          @endforeach
        </section>
      </div>
    </div>
    @endif
  </div>

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
  </script>
</body>
</html>