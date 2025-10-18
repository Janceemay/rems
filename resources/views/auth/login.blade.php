@extends('components.layouts.app')

@section('content')
<main class="min-h-screen flex items-center justify-center bg-blue-500">
    <div class="max-w-7xl bg-white rounded-xl shadow-lg p-8">
        <div class="flex flex-col items-center mb-6">
            <img src="/images/K._Palafox_Realty_Full_Logo.png" alt="K. Palafox Realty Logo" class="w-full mb-4">
            <h1 class="text-2xl font-semibold text-gray-800">Login</h1>
        </div>
        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-gray-700 font-medium">Email:</label>
                <input type="email" id="email" name="email"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
                    required autofocus>
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium">Password:</label>
                <input type="password" id="password" name="password"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Log In
                </button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
                </p>
            </div>
        </form>
    </div>
</main>
@endsection
