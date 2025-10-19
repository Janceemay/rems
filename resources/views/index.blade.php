<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K. Palafox Realty</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-sky-100 to-sky-300">
    <!-- Hero Section with Header inside -->
    <section id="home" class="h-screen flex flex-col  bg-[url('/images/Home_Background.jpg')] bg-cover bg-center bg-no-repeat bg-blend-multiply text-center text-black">

        <header class="h-20 p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center gap-8">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <img src="/images/logos/K._Palafox_Realty_Full_Logo.png" alt="Logo" class="h-12 w-auto">
                </div>

                <!-- Navigation -->
                <nav class="flex items-center gap-6">
                    <a href="#home" class="hover:underline">Home</a>
                    <a href="#about" class="hover:underline">About</a>
                    <a href="#developers" class="hover:underline">Developers</a>
                    <a href="#property" class="hover:underline">Property</a>
                    <a href="#location" class="hover:underline">Location</a>
                </nav>

                <!-- Buttons -->
                <div class="flex gap-3 ml-4">
                    <button type="button" onclick="window.location.href='{{ route('login') }}'" class="text-black bg-white border border-gray-200 rounded-lg text-sm text-center p-2">
                        Log In
                    </button>
                    <button type="button" class="text-white bg-blue-500 border border-gray-200 rounded-lg text-sm text-center p-2">Sign Up</button>
                </div>
            </div>
        </header>

        <!-- Hero Content (fills remaining space) -->
        <div class="flex-1 flex flex-col items-center justify-center gap-8 p-8">
            <h1 class="text-4xl sm:text-4xl md:text-7xl lg:text-8xl font-bold">YOUR GROWTH PARTNER WITH VISION</h1>
            <p class="text-xl sm:text-xl md:text-2xl lg:text-3xl">We help you find your dream home from the best developers in the country.</p>

            <!-- Search Bar -->
            <div class="w-full max-w-sm md:max-w-md lg:max-w-lg mt-6">
                <div class="relative flex items-center gap-2">
                    <input class="w-full border border-gray-300 rounded-lg py-2 px-4" type="text" placeholder="Search for location, developer, or property type">
                    <button class="w-1/4 bg-blue-500 text-white rounded-lg py-2 px-4" type="button">Search</button>
                </div>
            </div>
        </div>
    </section>


<!-- Stats Section -->
<section id="about" class="h-screen flex items-center justify-center bg-gradient-to-br from-sky-100 to-sky-300">
  <div class="container mx-auto w-full max-w-7xl p-8 rounded-xl flex justify-between items-center text-center text-white">
    
    <!-- Stat: Houses -->
    <div class="flex flex-col items-start justify-center bg-blue-700/60 rounded-lg p-6 w-48 h-48">
      <div class="text-6xl font-bold">00</div>
      <div class="mt-2 text-lg font-light">Houses</div>
    </div>

    <!-- Stat: Developers -->
    <div class="flex flex-col items-start justify-center bg-blue-700/60 rounded-lg p-6 w-48 h-48">
      <div class="text-6xl font-bold">00</div>
      <div class="mt-2 text-lg font-light">Developers</div>
    </div>

    <!-- Stat: House Owners -->
    <div class="flex flex-col items-start justify-center bg-blue-700/60 rounded-lg p-6 w-48 h-48">
      <div class="text-6xl font-bold">00</div>
      <div class="mt-2 text-lg font-light">House Owners</div>
    </div>

  </div>
</section>


    <!-- House Developers Section -->
    <section class="" id="developers">
        <div class="">
            <h2>House Developers</h2>
            <div class="">
                <div class="">
                    <a href="developer1.html" class="">
                        <img src="assets/vistaland_logo.png" alt="Developer Logo">
                    </a>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>
                <!-- repeat other developer items -->
            </div>
        </div>
    </section>
    <!-- Property Types Section -->
    <section class="" id=property>
        <div class="">
            <h2>Property Type</h2>
            <div class="">
                <a href="luxury-homes.html" class="">
                    <div class="">
                        <i class=""></i>
                        <h3>Luxury Homes</h3>
                    </div>
                </a>
                <!-- repeat other property types -->
            </div>
        </div>
    </section>
    <!-- Map Section -->
    <section class="" id="location">
        <div class="">
            <div class="">
                <div class="">
                    <img src="images/K._Palafox_Realty_Map_Location.png" alt="City Map" style="width:100%; height:400px;">
                </div>
                <div class="">
                    <h2>Frequently Asked Questions</h2>
                    <div class="">
                        <h3>Question 1</h3>
                    </div>
                    <div class="">
                        <h3>Question 2</h3>
                    </div>
                    <div class="">
                        <h3>Question 3</h3>
                    </div>
                    <div class="">
                        <h3>Question 4</h3>
                    </div>
                    <div class="">
                        <h3>Question 5</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
    <footer class="text-black p-6">
        <div class="max-w-7xl mx-auto flex flex-nowrap justify-between gap-8">

            {{-- Logo --}}
            <div class="w-full sm:w-1/2 md:w-1/4">
                <img src="/images/logos/K._Palafox_Realty_Full_Logo.png" alt="Logo">
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
</body>
</html>
