<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K. Palafox Realty</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-sky-100 to-sky-300">
    {{-- Wrapper --}}
    <div>
        {{-- Header --}}
        <header class="text-black p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center gap-8">
                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <img src="/images/K._Palafox_Realty_Full_Logo.png" alt="Logo" class="h-12 w-auto">
                </div>

                {{-- Navigation --}}
                <nav class="flex items-center gap-6">
                    <a href="#home" class="hover:underline">Home</a>
                    <a href="#about" class="hover:underline">About</a>
                    <a href="#developers" class="hover:underline">Developers</a>
                    <a href="#property" class="hover:underline">Property</a>
                    <a href="#location" class="hover:underline">Location</a>
                </nav>

                {{-- Buttons --}}
                <div class="flex gap-3 ml-4">
                    <button type="button" onclick="window.location.href='{{ route('login') }}'" class="text-black bg-white border border-gray-200 rounded-lg text-sm text-center p-2">
                        Log In
                    </button>
                    <button type="button" class="text-white bg-blue-500 border border-gray-200 rounded-lg text-sm text-center p-2">Sign Up</button>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="text-black p-6">
            <div class="max-w-7xl mx-auto flex flex-nowrap justify-between gap-8">

                {{-- Logo --}}
                <div class="w-full sm:w-1/2 md:w-1/4">
                    <img src="/images/K._Palafox_Realty_Full_Logo.png" alt="Logo">
                    <address>Papaya Road, Mabini Homesite, Cabanatuan City Nueva Ecija 3100 Philippines</address>
                </div>

                {{-- Navigation 1 --}}
                <nav class="w-full sm:w-1/2 md:w-1/4">
                    <h4 class="text-xl font-semibold">Home</h4>
                    <ul>
                        <li><a href="#about" class="hover:underline">About Us</a></li>
                        <li><a href="#team" class="hover:underline">Team</a></li>
                        <li><a href="#developers" class="hover:underline">Developers</a></li>
                        <li><a href="#location" class="hover:underline">Location</a></li>
                    </ul>
                </nav>

                {{-- Navigation 2 --}}
                <nav class="w-full sm:w-1/2 md:w-1/4">
                    <h4 class="text-xl font-semibold">Link</h4>
                    <ul>
                        <li><a href="#xxx" class="hover:underline">Help Center</a></li>
                        <li><a href="#xxx" class="hover:underline">Contact</a></li>
                        <li><a href="#xxx" class="hover:underline">Privacy Policy</a></li>
                    </ul>
                </nav>

                {{-- Navigation 3 --}}
                <div class="w-full sm:w-1/2 md:w-1/4">
                    <h4 class="text-xl font-semibold">Contact Us</h4>
                    <ul>
                        <li><a href="#xxx" class="hover:underline">K. Palafox Realty</a></li>
                        <li><a href="#xxx" class="hover:underline">kpalafoxrealtyofficial@gmail.com</a></li>
                        <li><a href="#xxx" class="hover:underline">09123456789</a></li>
                    </ul>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="mt-6 text-center mx-auto">
                <p>© 2025 K. Palafox Realty. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>
