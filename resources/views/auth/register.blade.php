<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register | K. Palafox Realty</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen grid grid-cols-1 md:grid-cols-2 bg-white font-sans text-gray-800">

    {{-- Left: Register Form --}}
    <section class="flex flex-col justify-center px-10 py-16">
        <div class="max-w-md w-full mx-auto space-y-8">

            {{-- Logo --}}
            <div class="flex justify-center">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logos/KPR_logo.png') }}" alt="K. Palafox Realty" class="h-12 w-auto">
                </a>
            </div>

            {{-- Title --}}
            <h2 class="text-4xl font-bold text-[#2a47ff] text-center">Create Your Account</h2>
            <p class="text-lg text-center">Start your journey with us today.</p>

            {{-- Success Alert --}}
            @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="p-4 bg-green-100 border border-green-300 text-green-800 rounded transition-opacity duration-500">
                <strong>Success:</strong> {{ session('success') }}
            </div>
            @endif

            {{-- Error Alert --}}
            @if ($errors->any())
            <div class="p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                <strong>Oops!</strong> Please fix the following:
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Register Form --}}
            <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input name="full_name" class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role_id" class="w-full border rounded-xl px-4 py-2 shadow-sm focus:ring-[#2a47ff] focus:border-[#2a47ff]" required>
                        @foreach($roles as $role)
                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full bg-[#2a47ff] text-white py-2 rounded-2xl hover:bg-[#2a47ff]/80 transition">
                    Register
                </button>
            </form>

            <p class="text-sm text-center text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#2a47ff] hover:underline">Login here</a>
            </p>

            <footer class="text-xs text-center text-gray-500 mt-8">
                K. Palafox Realty 2025 &bull; <a href="#" class="hover:underline">Privacy</a> &bull; <a href="#" class="hover:underline">Terms</a>
            </footer>
        </div>
    </section>

    {{-- Right: Promo Graphic --}}
    <section class="relative bg-cover bg-center" style="background-image: url('/images/Home_Background.jpg')">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 flex flex-col justify-center h-full px-10 py-16 text-white">
            <h2 class="text-4xl font-bold leading-tight max-w-md">
                Property Finder — Real Estate, Homes For Sale Philippines
            </h2>
        </div>
    </section>

    {{-- Alpine.js for alert transitions --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
