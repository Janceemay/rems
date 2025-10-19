<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K. Palafox Realty</title>
    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Swiper CSS --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/> --}}
    {{-- Flowbite CSS --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css"/> --}}

</head>
<body class="bg-gradient-to-b from-sky-100 to-sky-300">
    {{-- Header & Hero --}}
    <section id="home" class="h-screen flex flex-col bg-[url('/images/Home_Background.jpg')] bg-cover bg-center bg-no-repeat bg-blend-multiply text-center text-black">
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

    <!-- Stat: Developers -->
    <div class="flex flex-col items-start justify-center bg-blue-700/60 rounded-lg p-6 w-48 h-48">
      <div class="text-6xl font-bold">00</div>
      <div class="mt-2 text-lg font-light">Developers</div>
    </div>

        <div class="w-full gap-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
            {{-- Block 1: Atlanta Realty --}}
            <a href="" class="flex flex-col bg-white border-2 border-gray-300 rounded-3xl p-4 w-full sm:w-64 md:w-72 lg:w-96">
                <div class="flex sm:flex-col md:flex-row lg:flex-col items-center justify-start gap-4 mb-4">
                    <img src="/images/logos/Atlanta_Realty_Logo.png" alt="Atlanta Realty Logo" class="w-2/3 md:w-12 md:h-12 lg:size-8/12 object-contain">
                    <h1 class="text-4xl md:text-6xl lg:text-3xl font-bold text-start">Atlanta Realty</h1>
                </div>
                <p class="text-start">Atlanta Realty is known for its innovative designs and quality construction, offering a variety of residential properties that cater to different lifestyles.</p>
            </a>
            {{-- Block 2: Ayala Land --}}
            <a href="" class="flex flex-col bg-white border-2 border-gray-300 rounded-3xl p-4 w-full sm:w-64 md:w-72 lg:w-96">
                <div class="flex sm:flex-col md:flex-row lg:flex-col items-center justify-start gap-4 mb-4">
                    <img src="/images/logos/Ayala_Logo.png" alt="Ayala Land Logo" class="w-2/3 md:w-12 md:h-12 lg:size-8/12 object-contain">
                    <h1 class="text-4xl md:text-6xl lg:text-3xl font-bold text-start">Ayala Land</h1>
                </div>
                <p class="text-start">Ayala Land is one of the largest and most established real estate developers in the Philippines, known for its master-planned communities and sustainable developments.</p>
            </a>
            {{-- Block 3: Borland --}}
            <a href="" class="flex flex-col bg-white border-2 border-gray-300 rounded-3xl p-4 w-full sm:w-64 md:w-72 lg:w-96">
                <div class="flex sm:flex-col md:flex-row lg:flex-col items-center justify-start gap-4 mb-4">
                    <img src="/images/logos/Borland_Logo.png" alt="Borland Logo" class="w-2/3 md:w-12 md:h-12 lg:size-8/12 object-contain">
                    <h1 class="text-4xl md:text-6xl lg:text-3xl font-bold text-start">Borland</h1>
                </div>
                <p class="text-start">Borland is recognized for its commitment to quality and customer satisfaction, offering a range of residential properties that combine modern living with affordability.</p>
            </a>
            {{-- Block 4: Century Properties --}}
            <a href="" class="flex flex-col bg-white border-2 border-gray-300 rounded-3xl p-4 w-full sm:w-64 md:w-72 lg:w-96">
                <div class="flex sm:flex-col md:flex-row lg:flex-col items-center justify-start gap-4 mb-4">
                    <img src="/images/logos/Century_Properties_Logo.png" alt="Century Properties Logo" class="w-2/3 md:w-12 md:h-12 lg:size-8/12 object-contain">
                    <h1 class="text-4xl md:text-6xl lg:text-3xl font-bold text-start">Century Properties</h1>
                </div>
                <p class="text-start">Century Properties is known for its innovative designs and quality construction, offering a variety of residential properties that cater to different lifestyles.</p>
            </a>
            {{-- Block 5: ServeQuest Group --}}
            <a href="" class="flex flex-col bg-white border-2 border-gray-300 rounded-3xl p-4 w-full sm:w-64 md:w-72 lg:w-96">
                <div class="flex sm:flex-col md:flex-row lg:flex-col items-center justify-start gap-4 mb-4">
                    <img src="/images/logos/ServeQuest_Group_Logo.png" alt="ServeQuest Group Logo" class="w-2/3 md:w-12 md:h-12 lg:size-8/12 object-contain">
                    <h1 class="text-4xl md:text-6xl lg:text-3xl font-bold text-start">ServeQuest Group</h1>
                </div>
                <p class="text-start">ServeQuest Group has built a reputation for delivering quality homes and excellent customer service, with a focus on creating vibrant communities.</p>
            </a>
            {{-- Block 6: Vista Land --}}
            <a href="" class="flex flex-col bg-white border-2 border-gray-300 rounded-3xl p-4 w-full sm:w-64 md:w-72 lg:w-96">
                <div class="flex sm:flex-col md:flex-row lg:flex-col items-center justify-start gap-4 mb-4">
                    <img src="/images/logos/Vista_Land_Logo.png" alt="Vista Land Logo" class="w-2/3 md:w-12 md:h-12 lg:size-8/12 object-contain">
                    <h1 class="text-4xl md:text-6xl lg:text-3xl font-bold text-start">Vista Land</h1>
                </div>
                <p class="text-start">Vista Land is one of the largest homebuilders in the Philippines, known for its diverse portfolio of residential developments that cater to various market segments.</p>
            </a>
        </div>
    </section>

    <!-- Property Section -->
    <section id="property" class="h-screen flex flex-col items-center justify-center p-8 gap-8 max-w-7xl mx-auto">
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-center mb-4">Property Type</h1>
        <p class="text-lg md:text-xl lg:text-2xl text-center max-w-3xl mx-auto mb-8">
            Explore a variety of property types to find the perfect home that suits your lifestyle and preferences.
        </p>
        <div class="relative w-full max-w-6xl overflow-hidden px-4">
            <div class="swiper w-full">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center justify-center bg-gray-100 p-6 rounded-lg h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] w-full">
                            <img src="/images/logos/Ayala_Logo.png" class="h-1/2 w-1/2 object-contain mb-4" alt="Ayala">
                            <span class="text-lg font-medium text-gray-800">Ayala Land</span>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center justify-center bg-gray-100 p-6 rounded-lg h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] w-full">
                            <img src="/images/logos/Century_Properties_Logo.png" class="h-1/2 w-1/2 object-contain mb-4" alt="Century">
                            <span class="text-lg font-medium text-gray-800">Century Properties</span>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center justify-center bg-gray-100 p-6 rounded-lg h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] w-full">
                            <img src="/images/logos/Vista_Land_Logo.png" class="h-1/2 w-1/2 object-contain mb-4" alt="Vista">
                            <span class="text-lg font-medium text-gray-800">Vista Land</span>
                        </div>
                    </div>
                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center justify-center bg-gray-100 p-6 rounded-lg h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] w-full">
                            <img src="/images/logos/Atlanta_Realty_Logo.png" class="h-1/2 w-1/2 object-contain mb-4" alt="Atlanta">
                            <span class="text-lg font-medium text-gray-800">Atlanta Realty</span>
                        </div>
                    </div>
                    <!-- Slide 5 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center justify-center bg-gray-100 p-6 rounded-lg h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] w-full">
                            <img src="/images/logos/Borland_Logo.png" class="h-1/2 w-1/2 object-contain mb-4" alt="Borland">
                            <span class="text-lg font-medium text-gray-800">Borland</span>
                        </div>
                    </div>
                    <!-- Slide 6 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center justify-center bg-gray-100 p-6 rounded-lg h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] w-full">
                            <img src="/images/logos/ServeQuest_Group_Logo.png" class="h-1/2 w-1/2 object-contain mb-4" alt="ServeQuest">
                            <span class="text-lg font-medium text-gray-800">ServeQuest Group</span>
                        </div>
                    </div>
                </div>
                <!-- Navigation buttons -->
                <div class="swiper-button-prev absolute top-1/2 left-0 transform -translate-y-1/2 z-10 flex items-center justify-center w-10 h-10 bg-white border border-gray-300 rounded-full shadow hover:bg-blue-100 hover:text-blue-700 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <div class="swiper-button-next absolute top-1/2 right-0 transform -translate-y-1/2 z-10 flex items-center justify-center w-10 h-10 bg-white border border-gray-300 rounded-full shadow hover:bg-blue-100 hover:text-blue-700 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>

                <!-- Pagination dots -->
                <div class="swiper-pagination mt-6 flex justify-center gap-2"></div>
            </div>
        </div>
    </section>

{{-- Location & FAQ Section --}}
<section id="location" class="h-screen flex flex-col items-center justify-center p-8 gap-8 max-w-7xl mx-auto">
    <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-center mb-4">Location & FAQ</h1>
    <p class="text-lg md:text-xl lg:text-2xl text-center max-w-3xl mx-auto mb-8">
        Discover our location and frequently asked questions.
    </p>

    <div class="w-full flex flex-col lg:flex-row gap-8 justify-center items-start">
        <!-- Map -->
        <div class="flex-1">
            <img src="images/K._Palafox_Realty_Map_Location.png" alt="City Map"
                 class="w-full h-[400px] object-cover rounded-2xl shadow-md">
        </div>

        <!-- FAQ Accordion (Flowbite) -->
        <div class="flex-1">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-6">Frequently Asked Questions</h2>

            <div id="accordion-open" data-accordion="open">
                <!-- FAQ 1 -->
                <h2 id="faq-heading-1">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-gray-700 border border-b-0 rounded-t-xl hover:bg-gray-100"
                        data-accordion-target="#faq-body-1" aria-expanded="true" aria-controls="faq-body-1">
                        <span>Where is K. Palafox Realty located?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="faq-body-1" class="hidden" aria-labelledby="faq-heading-1">
                    <div class="p-5 border border-b-0 text-gray-600">
                        We are located at [Insert complete address here]. You can find us easily on Google Maps.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <h2 id="faq-heading-2">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-gray-700 border border-b-0 hover:bg-gray-100"
                        data-accordion-target="#faq-body-2" aria-expanded="false" aria-controls="faq-body-2">
                        <span>What are your business hours?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="faq-body-2" class="hidden" aria-labelledby="faq-heading-2">
                    <div class="p-5 border border-b-0 text-gray-600">
                        We are open Monday to Saturday, from 8:00 AM to 6:00 PM.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <h2 id="faq-heading-3">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-gray-700 border border-b-0 hover:bg-gray-100"
                        data-accordion-target="#faq-body-3" aria-expanded="false" aria-controls="faq-body-3">
                        <span>Do you offer property consultations?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="faq-body-3" class="hidden" aria-labelledby="faq-heading-3">
                    <div class="p-5 border border-b-0 text-gray-600">
                        Yes, we provide free consultations for property buying, selling, and investment planning.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <h2 id="faq-heading-4">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-gray-700 border border-b-0 hover:bg-gray-100"
                        data-accordion-target="#faq-body-4" aria-expanded="false" aria-controls="faq-body-4">
                        <span>Can I schedule a property viewing online?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="faq-body-4" class="hidden" aria-labelledby="faq-heading-4">
                    <div class="p-5 border border-b-0 text-gray-600">
                        Yes! You can schedule a property viewing through our website or by contacting us directly.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <h2 id="faq-heading-5">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-gray-700 border hover:bg-gray-100"
                        data-accordion-target="#faq-body-5" aria-expanded="false" aria-controls="faq-body-5">
                        <span>Do you assist with property financing?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="faq-body-5" class="hidden" aria-labelledby="faq-heading-5">
                    <div class="p-5 border border-t-0 text-gray-600">
                        Yes, we can connect you with trusted financial institutions for home loans and financing options.
                    </div>
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

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true
            , centerdSlides: true
            , spaceBetween: 50
            , slidesPerView: 3
            , breakpoints: {
                640: {
                    slidesPerView: 1
                , }
                , 768: {
                    slidesPerView: 2
                , }
                , 1024: {
                    slidesPerView: 3
                , }
            , }
            , navigation: {
                nextEl: '.swiper-button-next'
                , prevEl: '.swiper-button-prev'
            , },

            pagination: {
                el: '.swiper-pagination'
                , clickable: true
            , }
        , });

    </script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>
</html>
