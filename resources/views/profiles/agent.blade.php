<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: #C7FFD8;
    }
  </style>
</head>
<body class="flex flex-row">
  <style>
    @keyframes fade {
      0% {opacity: 0%; top: -15px}
      100% {opacity: 100%; top: 0}
    }
    #editProfileModal {
      animation: fade;
      animation-duration: 0.25s;
    }
  </style>

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
      <div class="w-full md:w-1/3 px-2">
        <div class="bg-white shadow rounded flex flex-col items-center p-4">
          <img src="{{ asset($user->profile_picture) }}"
               alt="Profile Picture"
               class="rounded-full mb-3"
               style="width: 120px; height: 120px; object-fit: cover;" />
          <h4 class="font-bold text-lg">{{ $user->full_name }}</h4>
          <p class="text-gray-500">{{ $user->email }}</p>
          <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-2"
                  data-bs-toggle="modal"
                  data-bs-target="#editProfileModal">
            Edit Profile
          </button>
        </div>
      </div>
      <div class="w-full md:w-2/3 px-2 flex justify-end">
        <div class="bg-white shadow rounded w-1/2 p-4">
          <ul class="space-y-2">
            <li><b>Status:</b> {{ $user->role->role_name }}</li>
            <li><b>Gender:</b> {{ $user->gender }}</li>
            <li><b>Age:</b> {{ $user->age }}</li>
            <li><b>Phone:</b> {{ $user->contact_number }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden" id="editProfileModal">
    <div class="bg-white rounded-lg w-full max-w-md">
      <div class="flex justify-between items-center border-b p-4">
        <h5 class="text-lg font-semibold">Edit Profile</h5>
        <button class="text-gray-500 hover:text-gray-700" onclick="document.getElementById('editProfileModal').classList.add('hidden')">×</button>
      </div>
      <div class="p-4">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-4">
            <label for="profile_picture" class="block font-medium mb-1">Profile Picture</label>
            <input type="file" id="profile_picture" name="profile_picture" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-4">
            <label for="name" class="block font-medium mb-1">Name</label>
            <input type="text" id="name" name="name" value="{{ $user->full_name }}" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-4">
            <label for="age" class="block font-medium mb-1">Age</label>
            <input type="number" id="age" name="age" value="{{ $user->age }}" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-4">
            <label for="email" class="block font-medium mb-1">Email</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100" />
          </div>
          <div class="mb-4">
            <label for="phone" class="block font-medium mb-1">Phone Number</label>
            <input type="text" id="phone" name="phone" value="{{ $user->contact_number }}" class="w-full border rounded px-3 py-2" />
          </div>
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
  
  <script>
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.getAttribute('data-bs-target');
        document.querySelector(target).classList.remove('hidden');
      });
    });
  </script>
</body>
</html>