{{-- Layout --}}
@extends('components.layouts.app')

{{-- Change this when updating the title bar --}}
@section('title', 'Profile')

{{-- Main Content --}}
@section('content')
<main class="flex-1 px-6 py-10 overflow-y-auto bg-white text-gray-800 border-gray-300 border-2 rounded-3xl">

    {{-- Profile Header --}}
    <section class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-6">
            <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="rounded-full w-32 h-32 object-cover border" />
            <div class="space-y-5">
                <h1 class="text-5xl font-bold text-[#2a47ff]">{{ $user->full_name }}</h1>
                <p class="text-xl text-gray-600">{{ $user->email }}</p>
            </div>
        </div>
        <div>
            <button onclick="document.getElementById('editProfileModal').classList.remove('hidden')" class="bg-[#2a47ff] text-white px-6 py-2 rounded-xl hover:bg-[#2a47ff]/80 transition">
                Edit Profile
            </button>
        </div>
    </section>

    {{-- Prompt to complete client profile --}}
    @if($user->isRole('Client') && !$user->client)
    <div class="max-w-5xl mx-auto mt-8 bg-yellow-100 border-l-4 border-yellow-500 p-6 rounded-xl">
        <h3 class="text-xl font-bold text-yellow-800 mb-2">Complete Your Profile</h3>
        <p class="text-sm text-yellow-700 mb-4">To submit property inquiries, please complete your client profile.</p>
        <a href="{{ route('clients.setup') }}" class="inline-block px-6 py-2 bg-yellow-500 text-white rounded-full hover:bg-yellow-600 font-semibold transition">
            <i class="fas fa-user-edit mr-2"></i> Setup Profile
        </a>
    </div>
    @endif

    {{-- Personal Details --}}
    <section class="max-w-5xl mx-auto mt-10 space-y-6 text-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="font-bold text-gray-700 text-3xl">Role</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->role->role_name }}</p>
            </div>
            <div>
                <label class="font-bold text-gray-700 text-3xl">Gender</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->client->gender }}</p>
            </div>
            <div><label class="font-bold text-gray-700 text-3xl">Age</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->age }}</p>
            </div>
            <div><label class="font-bold text-gray-700 text-3xl">Phone</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->contact_number }}</p>
            </div>
            <div><label class="font-bold text-gray-700 text-3xl">Email</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->email }}</p>
            </div>
            <div><label class="font-bold text-gray-700 text-3xl">Birthday</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->client->birthday ?? 'Not set' }}</p>
            </div>
            <div><label class="font-bold text-gray-700 text-3xl">Relationship Status</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->client->relationship_status ? ucfirst(str_replace('_', ' ', $user->client->relationship_status)) : 'Not set' }}</p>
            </div>
            <div><label class="font-bold text-gray-700 text-3xl">Address</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->client->address ?? 'Not set' }}</p>
            </div>
            <div><label class="font-bold text-gray-700 text-3xl">Occupation</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->client->current_job ?? 'Not set' }}</p>
            </div>
            <div><label class="font-bold text-gray-700 text-3xl">Source of Income</label>
                <p class="mt-1 text-gray-800 text-lg">{{ $user->client->financing_type ?? 'Not set' }}</p>
            </div>
        </div>
    </section>

{{-- Edit Profile Modal --}}
<div id="editProfileModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-white">Edit Your Profile</h2>
            <button onclick="document.getElementById('editProfileModal').classList.add('hidden')" class="text-white text-2xl hover:text-gray-200">&times;</button>
        </div>

        {{-- Form --}}
        <form action="{{ route('client.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            {{-- Profile Picture --}}
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Profile Picture</label>
                <input type="file" name="profile_picture" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
            </div>

            {{-- Name --}}
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Full Name</label>
                <input type="text" name="name" value="{{ $user->full_name }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
            </div>

            {{-- Age & Gender --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Age</label>
                    <input type="number" name="age" value="{{ $user->age }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Gender</label>
                    <select name="gender" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            {{-- Contact & Birthday --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Phone Number</label>
                    <input type="text" name="phone" value="{{ $user->contact_number }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Birthday</label>
                    <input type="date" name="birthday" value="{{ $user->client->birthday ?? '' }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
            </div>

            {{-- Relationship Status --}}
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Relationship Status</label>
                <select name="relationship_status" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select relationship status</option>
                    <option value="single" {{ $user->client->relationship_status === 'single' ? 'selected' : '' }}>Single</option>
                    <option value="in_a_relationship" {{ $user->client->relationship_status === 'in_a_relationship' ? 'selected' : '' }}>In a Relationship</option>
                    <option value="married" {{ $user->client->relationship_status === 'married' ? 'selected' : '' }}>Married</option>
                    <option value="divorced" {{ $user->client->relationship_status === 'divorced' ? 'selected' : '' }}>Divorced</option>
                </select>
            </div>

            {{-- Address & Occupation --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Address</label>
                    <input type="text" name="address" value="{{ $user->client->address ?? '' }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Occupation</label>
                    <input type="text" name="occupation" value="{{ $user->client->current_job ?? '' }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
            </div>

            {{-- Source of Income --}}
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Source of Income</label>
                <select name="source_of_income" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select source</option>
                    <option value="employed" {{ $user->client->financing_type === 'employed' ? 'selected' : '' }}>Employed</option>
                    <option value="self-employed" {{ $user->client->financing_type === 'self-employed' ? 'selected' : '' }}>Self-Employed</option>
                    <option value="freelancer" {{ $user->client->financing_type === 'freelancer' ? 'selected' : '' }}>Freelancer</option>
                    <option value="business-owner" {{ $user->client->financing_type === 'business-owner' ? 'selected' : '' }}>Business Owner</option>
                    <option value="investor" {{ $user->client->financing_type === 'investor' ? 'selected' : '' }}>Investor</option>
                    <option value="retired" {{ $user->client->financing_type === 'retired' ? 'selected' : '' }}>Retired</option>
                    <option value="student" {{ $user->client->financing_type === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="unemployed" {{ $user->client->financing_type === 'unemployed' ? 'selected' : '' }}>Unemployed</option>
                </select>
            </div>

            {{-- Submit --}}
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-4 px-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl">
                <i class="fas fa-save mr-2"></i> Save Changes
            </button>
        </form>
    </div>
</div>

</main>
@endsection
