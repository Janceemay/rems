<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K. Palafox Realty</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-sky-100 to-sky-300">
    {{-- Header & Hero --}}
    <section id="home" class="h-screen flex flex-col  bg-[url('/images/Home_Background.jpg')] bg-cover bg-center bg-no-repeat bg-blend-multiply text-center text-black">

        <header class="h-20 p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center gap-8">
                {{-- Logo   --}}
                <div class="flex-shrink-0">
                    <img src="/images/logos/K._Palafox_Realty_Full_Logo.png" alt="Logo" class="h-12 w-auto">
                </div>

                {{-- Navigation --}}
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

        {{-- Hero Content --}}
        <div class="flex-1 flex flex-col items-center justify-center gap-8 p-8">
            <h1 class="text-4xl sm:text-4xl md:text-7xl lg:text-8xl font-bold">YOUR GROWTH PARTNER WITH VISION</h1>
            <p class="text-xl sm:text-xl md:text-2xl lg:text-3xl">We help you find your dream home from the best developers in the country.</p>

            {{-- Search Bar and Button --}}
            <div class="w-full max-w-sm md:max-w-md lg:max-w-lg mt-6">
                <div class="relative flex items-center gap-2">
                    <input class="w-full border border-gray-300 rounded-lg py-2 px-4" type="text" placeholder="Search for location, developer, or property type">
                    <button class="w-1/4 bg-blue-500 text-white rounded-lg py-2 px-4" type="button">Search</button>
                </div>
            </div>
        </div>
    </section>


    {{-- About Section --}}
    <section id="about" class="h-screen flex flex-col items-center justify-center p-8 gap-8 max-w-7xl mx-auto">
        <h1 class="text-4xl sm:text-4xl md:text-7xl lg:text-8xl font-bold">ABOUT US</h1>
        <p class="text-xl sm:text-xl md:text-base lg:text-2xl text-center">K. Palafox Realty is a premier real estate company dedicated to connecting homebuyers with top developers in the Philippines. Our mission is to provide exceptional service and help our clients find their dream homes with ease and confidence.</p>
        {{-- Statistics --}}
        <div class="w-full gap-4 flex sm:flex-col md:flex-row lg:flex-row justify-center items-center">
            {{-- Houses --}}
            <div class="flex flex-col items-start justify-center bg-white border-2 border-gray-300 rounded-3xl p-4 w-full max-w-xs sm:max-w-xs md:max-w-sm lg:max-w-md">
                <div class="bg-sky-200 p-4 rounded-full mb-2 hidden md:block">
                    <img src="/images/icons/Houses_Icon.png" alt="Houses Icon" class="md:size-12 lg:size-16 object-contain">
                </div>
                <div class="text-4xl sm:4xl md:text-6xl lg:text-8xl font-bold">00</div>
                <div class="mt-2 sm:text-sm md:text-md lg:text-2xl font-light">Houses</div>
            </div>
            {{-- Developers --}}
            <div class="flex flex-col items-start justify-center bg-white border-2 border-gray-300 rounded-3xl p-4 w-full max-w-xs sm:max-w-xs md:max-w-sm lg:max-w-md">
                <div class="bg-sky-200 p-4 rounded-full mb-2 hidden md:block">
                    <img src="/images/icons/Developers_Icon.png" alt="Developers Icon" class="md:size-12 lg:size-16 object-contain">
                </div>
                <div class="text-4xl sm:4xl md:text-6xl lg:text-8xl font-bold">00</div>
                <div class="mt-2 sm:text-sm md:text-md lg:text-2xl font-light">Developers</div>
            </div>
            {{-- House Owners --}}
            <div class="flex flex-col items-start justify-center bg-white border-2 border-gray-300 rounded-3xl p-4 w-full max-w-xs sm:max-w-xs md:max-w-sm lg:max-w-md">
                <div class="bg-sky-200 p-4 rounded-full mb-2 hidden md:block">
                    <img src="/images/icons/House_Owners_Icon.png" alt="House Owners Icon" class="md:size-12 lg:size-16 object-contain">
                </div>
                <div class="text-4xl sm:4xl md:text-6xl lg:text-8xl font-bold">00</div>
                <div class="mt-2 sm:text-sm md:text-md lg:text-2xl font-light">House Owners</div>
            </div>
        </div>
    </section>

    {{-- House Developers Section --}}
    <section id="developers" class="h-screen flex flex-col items-center justify-center p-8 gap-8 max-w-7xl mx-auto">
        <h1 class="text-4xl sm:text-4xl md:text-7xl lg:text-8xl font-bold text-center mb-8">HOUSE DEVELOPERS</h1>
        <p class="text-xl sm:text-xl md:text-base lg:text-2xl text-center">
            We partner with the most trusted and reputable house developers in the Philippines to bring you a wide range of quality homes that suit your lifestyle and budget.
        </p>

        <div class="w-full gap-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
            {{-- Block 1: Atlanta Realty --}}
            <a href="" class="flex flex-col bg-white border-2 border-gray-300 rounded-3xl p-4 w-full sm:w-64 md:w-72 lg:w-96">
                <div class="flex sm:flex-col md:flex-row lg:flex-col w-full mb-2">
                    <img src="/images/logos/Atlanta_Realty_Logo.png" alt="Atlanta Realty Logo" class="w-2/3 md:w-12 md:h-12 lg:size-8/12 object-contain">
                    <h1 class="text-4xl md:text-6xl lg:text-3xl font-bold text-start">Atlanta Realty</h1>
                </div>
                <p class="text-start">Atlanta Realty is known for its innovative designs and quality construction, offering a variety of residential properties that cater to different lifestyles.</p>
            </a>
        </div>
    </section>

    {{-- <section class="w-full gap-4 grid grid-cols-3 grid-rows-3 justify-center items-center text-center" id="developers">
        <a href="/" class="block w-full">
            <div class="bg-white border-2 border-gray-300 rounded-lg p-4 w-full h-full hover:shadow-lg transition-shadow duration-300">
                <h1 class="text-4xl font-bold">Atlanta Realty</h1>
                <div>
                    <img src="images/logos/Atlanta_Realty_Logo.png" alt="Atlanta Logo" class="w-24 h-auto mb-2">
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>
            </div>
        </a>
        <div class="bg-white border-2 border-gray-300 rounded-lg p-4 w-full">
            <h1 class="text-4xl font-bold">Ayala</h1>
            <div class="">
                <div class="">
                    <a href="" class="">
                        <img src="images/logos/Ayala_Logo.png" alt="Ayala Logo" class="md:size-1/4 lg:size-1/2 object-contain">
                    </a>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>
            </div>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-lg p-4 w-full">
            <h1 class="text-4xl font-bold">Borland</h1>
            <div class="">
                <div class="">
                    <a href="" class="">
                        <img src="images/logos/Borland_Logo.png" alt="Borland Logo" class="">
                    </a>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>
            </div>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-lg p-4 w-full">
            <h1 class="text-4xl font-bold">Century Properties</h1>
            <div class="">
                <div class="">
                    <a href="" class="">
                        <img src="images/logos/Century_Properties_Logo.png" alt="Century Properties Logo" class="">
                    </a>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>
            </div>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-lg p-4 w-full">
            <h1 class="text-4xl font-bold">ServeQuest Group</h1>
            <div class="">
                <div class="">
                    <a href="" class="">
                        <img src="images/logos/ServeQuest_Group_Logo.png" alt="ServeQuest Group Logo" class="">
                    </a>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>
            </div>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-lg p-4 w-full">
            <h1 class="text-4xl font-bold">Vista Land</h1>
            <div class="">
                <div class="">
                    <a href="" class="">
                        <img src="images/logos/Vista_Land_Logo.png" alt="Vista Land Logo" class="">
                    </a>
                    <p>The quick brown fox jumps over the lazy dog the quick...</p>
                </div>
            </div>
        </div>
    </section> --}}
    {{-- Property Section --}}

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
    {{-- Location and FAQ Section --}}
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
    {{-- Footer --}}
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
