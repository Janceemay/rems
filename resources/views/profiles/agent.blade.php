@extends('components.layouts.app')

@section('title', 'Profile')

@section('content')
<main class="flex-1 p-6 overflow-y-auto space-y-6">
  <!-- Profile Section -->
  <div class="w-full xl:w-3/4 mx-auto">
    <div class="flex flex-wrap gap-4">
      <!-- Profile Card -->
      <div class="w-full md:w-1/3">
        <div class="bg-white shadow rounded flex flex-col items-center p-6">
          <img src="{{ asset($user->profile_picture) }}"
               alt="Profile Picture"
               class="rounded-full mb-4 w-32 h-32 object-cover" />
          <h4 class="font-bold text-lg">{{ $user->full_name }}</h4>
          <p class="text-gray-500">{{ $user->email }}</p>
          <button @click="document.getElementById('editProfileModal').classList.remove('hidden')"
                  class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-4">
            Edit Profile
          </button>
        </div>
      </div>

      <!-- Info Card -->
      <div class="w-full md:w-2/3 flex justify-end">
        <div class="bg-white shadow rounded w-full md:w-2/3 p-6">
          <ul class="space-y-3 text-gray-700">
            <li><span class="font-semibold">Status:</span> {{ $user->role->role_name }}</li>
            <li><span class="font-semibold">Gender:</span> {{ $user->gender }}</li>
            <li><span class="font-semibold">Age:</span> {{ $user->age }}</li>
            <li><span class="font-semibold">Phone:</span> {{ $user->contact_number }}</li>
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
        <form action="{{ route('agent.update') }}" method="POST" enctype="multipart/form-data">
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
</main>

<script>
  document.querySelectorAll('[data-bs-toggle="modal"]').forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.getAttribute('data-bs-target');
      document.querySelector(target).classList.remove('hidden');
    });
  });
</script>
@endsection
