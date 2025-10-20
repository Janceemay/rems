<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="profileStyle.css" />
</head>

<body style="background-color:#f3f6fa">
  <div class="container-fluid">
    <div class="row gx-4 gy-4">

      <!-- Sidebar -->
      <div class="col-lg-2 col-md-3 col-sm-12 bg-white p-3 border-end">
        <h5 class="fw-bold mb-4">K. Palafox Realty</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profiles.client') }}">My Profile</a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link" href="">Home</a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link active" href="{{ route('dashboard.client') }}">Dashboard</a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link" href="{{ route('properties.index') }}">Housing</a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link" href="">Message</a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link" href="">Bookmark</a>
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

      <!-- Profile Section -->
      <div class="col-lg-4 col-md-5 col-sm-12 p-4 text-center">
        <div class="card shadow-sm">
          <div class="card-body">
            <!-- Profile Picture -->
            <img src="{{ asset($user->profile_picture) }}"
              alt="Profile Picture"
              class="rounded-circle img-fluid mb-3"
              style="width: 120px; height: 120px; object-fit: cover;"
            >
            <h4 class="fw-bold">{{ $user->full_name }}</h4>
            <p class="text-muted">{{ $user->email }}</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
          </div>
        </div>
      </div>

      <!-- Profile Details Section -->
      <div class="col-lg-6 col-md-12 p-4">
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Personal Information</h5>
            <ul class="list-unstyled">
              <li><strong>Status:</strong> {{ $user->role->role_name }}</li>
              <li><strong>Occupation:</strong> {{ $user->client->current_job }} </li>
              <li><strong>Gender:</strong> {{ $user->gender }}</li>
              <li><strong>Age:</strong> {{ $user->age }}</li>
              <li><strong>Phone:</strong> {{ $user->contact_number }}</li>
              <li><strong>Address:</strong> {{ $user->client->address }}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Profile Modal -->
  <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('client.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="profile_picture" class="form-label">Profile Picture</label>
              <input type="file" class="form-control" id="profile_picture" name="profile_picture" ">
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ $user->full_name }}">
            </div>
            <div class="mb-3">
              <label for="age" class="form-label">Age</label>
              <input type="number" class="form-control" id="age" name="age" value="{{ $user->age }}">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" disabled>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->contact_number }}">
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
