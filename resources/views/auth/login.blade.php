<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - K. Palafox Realty</title>
    @vite('resources/css/app.css') <!-- or your Tailwind build path -->
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-b from-sky-100 to-sky-300">
    <div class="w-150 p-6 bg-amber-50">
        <div class="flex items-center justify-center mb-6 space-x-3">
            <img src="{{ asset('images/logos/KPR_logo.png') }}" alt="Logo" class="size-32 border">
            <h2 class="text-2xl"><strong>K. Palafox Realty</strong> <br> Property Finder — Real Estate, Homes For Sale Philippines</h2>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required autofocus
                    class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit"class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition">
                LOGIN
            </button>
        </form>
    </div>
</body>
</html>