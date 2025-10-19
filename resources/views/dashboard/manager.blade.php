<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Team Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #a7c5fc;
    }
    .dashboard-container {
      display: flex;
      gap: 20px;
    }
    .team-status {
      flex: 1;
    }
    .team-members {
      width: 340px;
      flex-shrink: 0;
      position: sticky;
      top: 20px;
      align-self: flex-start;
    }
    .team-members .card {
      max-height: 500px;
      overflow-y: auto;
    }
    .team-members img {
      width: 60px;
      height: 60px;
      object-fit: cover;
    }
  </style>
</head>

<body>
  <div class="container-fluid p-4">
    <div class="row">

      <!-- Sidebar -->
      <div class="col-lg-2 col-md-3 bg-white p-3 border-end">
        <h5 class="fw-bold mb-4">K. Palafox Realty</h5>
        <ul class="nav flex-column">
          <li class="nav-item"><a class="nav-link" href="{{ route('profiles.manager') }}">My Profile</a></li>
          <li class="nav-item mb-2"><a class="nav-link" href="#">Home</a></li>
          <li class="nav-item mb-2"><a class="nav-link active" href="{{ route('dashboard.manager') }}">Dashboard</a></li>
          <li class="nav-item mb-2"><a class="nav-link" href="#">Housing</a></li>
          <li class="nav-item mb-2"><a class="nav-link" href="#">Message</a></li>
          <li class="nav-item mb-2"><a class="nav-link" href="#">Bookmark</a></li>
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
      <div class="col-md-10">
        <div class="dashboard-container">

          <!-- Team Status Section -->
          <div class="team-status">
            <h4 class="fw-bold mb-3">TEAM STATUS</h4>
            <div class="border mb-4" style="height:200px; background:#e9ecef;"></div>

            <div class="row text-center g-3">
              <div class="col-md-4">
                <div class="card d-flex align-items-center justify-content-center" style="height:100px; background:#f2ae61;">
                  <div>
                    <h6 class="fw-bold mb-1 text-white">PENDING</h6>
                    <h1 class="fw-bold mb-0 text-white">{{ $pending ?? 1 }}</h1>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="card d-flex align-items-center justify-content-center" style="height:100px; background:#6991ff;">
                  <div>
                    <h6 class="fw-bold mb-1 text-white">ONGOING</h6>
                    <h1 class="fw-bold mb-0 text-white">{{ $ongoing ?? 0 }}</h1>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="card d-flex align-items-center justify-content-center" style="height:100px; background:#3cc761;">
                  <div>
                    <h6 class="fw-bold mb-1 text-white">COMPLETED</h6>
                    <h1 class="fw-bold mb-0 text-white">{{ $completed ?? 0 }}</h1>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Team Members Section -->
          <div class="team-members">
            <h4 class="fw-bold mb-3">TEAM MEMBERS</h4>
            <div class="card p-3 shadow-sm">
              <div class="d-flex flex-column gap-3">
                @forelse ($members as $member)
                  <div class="d-flex align-items-center p-2 border rounded-3">
                    <img 
                      src="{{ $member->profile_picture ?? 'https://via.placeholder.com/60' }}" 
                      alt="Profile"
                      class="rounded"
                    >
                    <div class="ms-3 text-start">
                      <strong>{{ $member->full_name }}</strong><br>
                      <small class="text-muted">{{ $member->rank }}</small>
                    </div>
                  </div>
                @empty
                  <p class="text-muted">No team members found.</p>
                @endforelse
              </div>

              <div class="text-end mt-4">
                <a href="{{ route('agents.create') }}" 
                  class="btn btn-primary fw-bold" 
                  style="border-radius:20px; padding:6px 40px; background-color:#6991ff; border:none;">
                  +
                </a>
              </div>
            </div>
          </div>

        </div> <!-- dashboard-container -->
      </div>
    </div>
  </div>
</body>
</html>
