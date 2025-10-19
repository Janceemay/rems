<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Client Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/clientStyle.css') }}" />
</head>

<body style="background-color:#a7c5fc;">
  <div class="container-fluid">
    <div class="row">
        
      <!-- Sidebar -->
      <div class="col-lg-2 col-md-3 col-sm-12 bg-white p-3 border-end">
        <h5 class="fw-bold mb-4">K. Palafox Realty</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('client.profile') }}">My Profile</a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link active" href="{{ route('dashboard.client') }}">Dashboard</a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link" href="#">Housing</a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link" href="#">Message</a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link" href="#">Bookmark</a>
            </li>
            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-danger bg-transparent border-0">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                </form>
            </li>
        </ul>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 p-4">
        <!-- Status Cards -->
        <div class="row text-center g-3 mb-4">
          <div class="col-md-6">
            <div class="card d-flex align-items-center justify-content-center" style="height:120px; background:#6991ff;">
              <div>
                <h6 class="fw-bold mb-1 text-white">BALANCE</h6>
                <h1 class="fw-bold mb-0 text-white">{{ $balancePercent }}%</h1>
                <p class="text-white">₱ {{ number_format($totalBalance, 2) }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card d-flex align-items-center justify-content-center" style="height:120px; background:#3cc761;">
              <div>
                <h6 class="fw-bold mb-1 text-white">PAID</h6>
                <h1 class="fw-bold mb-0 text-white">{{ $paidPercent }}%</h1>
                <p class="text-white">₱ {{ number_format($totalPaid, 2) }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Property Info -->
        <div class="mb-4 bg-white p-3 rounded shadow-sm">
          <h5 class="fw-bold">NAME OF PROPERTY NA CURRENTLY PAYING</h5>
          <p>{{ $property['description'] ?? 'No description available.' }}</p>
        </div>

        <!-- Transactions -->
        <div class="bg-white p-3 rounded shadow-sm">
          <h5 class="fw-bold mb-3">TRANSACTIONS</h5>
          <table class="table table-borderless">
            <thead>
              <tr>
                <th>ACCOUNT NAME</th>
                <th>AMOUNT</th>
                <th>DATE</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($transactions as $t)
                <tr>
                  <td><i class="bi bi-wallet2 me-2 text-primary"></i>{{ $t['name'] }}</td>
                  <td>₱ {{ number_format($t['amount'], 2) }}</td>
                  <td>{{ $t['date'] }}</td>
                </tr>
              @empty
                <tr><td colspan="3">No transactions found.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>