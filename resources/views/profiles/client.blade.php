{{-- Layout --}}
@extends('components.layouts.app')

{{-- Change this when updating the title bar --}}
@section('title', 'Profile')

{{-- Main Content --}}
@section('content')
<main class="flex-1 px-6 py-10 overflow-y-auto bg-white text-gray-800 border-gray-300 border-2 rounded-3xl">
    {{-- Profile Header --}}
    <section class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
        {{-- Left: Profile Picture + Info --}}
        <div class="flex items-center gap-6">
            <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="rounded-full w-32 h-32 object-cover border" />

            <div class="space-y-5">
                <h1 class="text-5xl font-bold text-[#2a47ff]">{{ $user->full_name }}</h1>
                <p class="text-xl text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        {{-- Right: Edit Button --}}
        <div>
            <button onclick="document.getElementById('editProfileModal').classList.remove('hidden')" class="bg-[#2a47ff] text-white px-6 py-2 rounded-xl hover:bg-[#2a47ff]/80 transition">
                Edit Profile
            </button>
        </div>
    </section>

    {{-- Personal Details --}}
    <section class="max-w-5xl mx-auto mt-10 space-y-6 text-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="font-bold text-gray-700 text-3xl">Role</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->role->role_name }}</p>
            </div>
            <div>
                <label class="font-bold text-gray-700 text-3xl">Gender</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->gender }}</p>
            </div>
            <div>
                <label class="font-bold text-gray-700 text-3xl">Age</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->age }}</p>
            </div>
            <div>
                <label class="font-bold text-gray-700 text-3xl">Phone</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->contact_number }}</p>
            </div>
            <div>
                <label class="font-bold text-gray-700 text-3xl">Email</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->email }}</p>
            </div>
            <div>
                <label class="font-bold text-gray-700 text-3xl">Address</label>
                {{-- <p class="mt-1 text-gray-800">{{ $user->client->address }}</p> --}}
            </div>
            <div>
                <label class="font-bold text-gray-700 text-3xl">Occupation</label>
                {{-- <p class="mt-1 text-gray-800">{{ $user->client->current_job }}</p> --}}
            </div>
        </div>
    </section>

    {{-- Edit Profile Modal --}}
    <div id="editProfileModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl w-full max-w-md shadow-lg">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h5 class="text-lg font-semibold text-[#2a47ff]">Edit Profile</h5>
                <button onclick="document.getElementById('editProfileModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
            </div>
            <div class="px-6 py-4">
                <form action="{{ route('client.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" />
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" id="name" name="name" value="{{ $user->full_name }}" class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" />
                    </div>

                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                        <input type="number" id="age" name="age" value="{{ $user->age }}" class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" disabled class="w-full border rounded-xl px-4 py-2 bg-gray-100 text-gray-500" />
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ $user->contact_number }}" class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" />
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        {{-- <input type="text" id="address" name="address" value="{{ $user->client->address }}" --}}
                        class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" />
                    </div>

                    <div>
                        <label for="occupation" class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                        {{-- <input type="text" id="occupation" name="occupation" value="{{ $user->client->current_job }}" --}}
                        class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" />
                    </div>

                    <button type="submit" class="w-full bg-[#2a47ff] text-white py-2 rounded-2xl hover:bg-[#2a47ff]/80 transition">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

</main>
@endsection
