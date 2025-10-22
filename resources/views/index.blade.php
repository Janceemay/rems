<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>K. Palafox Realty</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />

    {{-- Flowbite CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" />
</head>
<body class="bg-gradient-to-b from-sky-100 to-sky-300">

    {{-- Header --}}
    <header class="p-6 bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-4">
            <img src="/images/logos/K._Palafox_Realty_Full_Logo.png" alt="Logo" class="h-12 w-auto">
            <nav class="flex flex-wrap gap-4 text-sm sm:text-base">
                <a href="#home" class="hover:underline">Home</a>
                <a href="#about" class="hover:underline">About</a>
                <a href="#developers" class="hover:underline">Developers</a>
                <a href="#property" class="hover:underline">Property</a>
                <a href="#location" class="hover:underline">Location</a>
            </nav>
            <div class="flex gap-2">
                <a href="{{ route('login') }}" class="text-black bg-white border border-gray-300 rounded-xl text-sm px-4 py-2">Log In</a>
                <a href="{{ route('register') }}" class="text-white bg-[#2a47ff] rounded-xl text-sm px-4 py-2">Sign Up</a>
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section id="home" class="min-h-screen flex flex-col justify-center items-center text-center px-4 bg-[url('/images/Home_Background.jpg')] bg-cover bg-center bg-no-repeat bg-blend-multiply">
        <h1 class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-bold text-white">YOUR GROWTH PARTNER WITH VISION</h1>
        <p class="text-lg sm:text-xl md:text-2xl mt-4 text-white">We help you find your dream home from the best developers in the country.</p>
        <div class="mt-6 w-full max-w-lg">
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" placeholder="Search for location, developer, or property type" class="flex-1 border border-gray-300 rounded-lg py-2 px-4">
                <button class="bg-[#2a47ff] text-white rounded-xl py-2 px-4">Search</button>
            </div>
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="py-16 px-4 max-w-7xl mx-auto text-center">
        <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold mb-6">About Us</h2>
        <p class="text-lg sm:text-xl md:text-2xl mb-10">K. Palafox Realty is a premier real estate company dedicated to connecting homebuyers with top developers in the Philippines.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach (['Houses', 'Developers', 'House Owners'] as $label)
            <div class="bg-white border-2 border-gray-300 rounded-3xl p-6 flex flex-col items-center">
                <img src="/images/icons/{{ str_replace(' ', '_', $label) }}_Icon.png" alt="{{ $label }} Icon" class="size-16 object-contain mb-4 hidden md:block">
                <div class="text-5xl font-bold">00</div>
                <div class="mt-2 text-lg font-light">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- Developers --}}
    <section id="developers" class="py-16 px-4 max-w-7xl mx-auto">
        <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold text-center mb-10">Top Developers</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach (['Atlanta Realty', 'Ayala Land', 'Borland', 'Century Properties', 'ServeQuest Group', 'Vista Land'] as $dev)
            <a href="#" class="bg-white border-2 border-gray-300 rounded-3xl p-6 flex flex-col gap-4">
                <div class="flex items-center gap-4">
                    <img src="/images/logos/{{ str_replace(' ', '_', $dev) }}_Logo.png" alt="{{ $dev }} Logo" class="w-16 h-16 object-contain">
                    <h3 class="text-xl font-bold">{{ $dev }}</h3>
                </div>
                <p class="text-sm text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit. {{ $dev }} offers quality homes and vibrant communities.</p>
            </a>
            @endforeach
        </div>
    </section>

    {{-- Property Carousel --}}
    <section id="property" class="py-16 px-4 max-w-7xl mx-auto text-center">
        <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold mb-6">Property Type</h2>
        <p class="text-lg sm:text-xl md:text-2xl mb-10">Explore a variety of property types to find the perfect home that suits your lifestyle.</p>
        <div class="swiper w-full overflow-hidden">
            <div class="swiper-wrapper">
                @foreach (['Ayala Land', 'Century Properties', 'Vista Land', 'Atlanta Realty', 'Borland', 'ServeQuest Group'] as $dev)
                <div class="swiper-slide">
                    <div class="bg-gray-100 p-6 rounded-lg flex flex-col items-center justify-center h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px]">
                        <img src="/images/logos/{{ str_replace(' ', '_', $dev) }}_Logo.png" alt="{{ $dev }}" class="h-1/2 w-1/2 object-contain mb-4">
                        <span class="text-lg font-medium text-gray-800">{{ $dev }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination mt-6"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>

    {{-- Location & FAQ --}}
    <section id="location" class="py-16 px-4 max-w-7xl mx-auto">
        <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold text-center mb-6">Location & FAQ</h2>
        <p class="text-lg sm:text-xl md:text-2xl text-center mb-10">Discover our location and frequently asked questions.</p>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <img src="/images/K._Palafox_Realty_Map_Location.png" alt="Map" class="w-full h-[400px] object-cover rounded-xl shadow-md">
            <div>
                <h3 class="text-2xl font-bold mb-4">Frequently Asked Questions</h3>
                <div id="accordion-open" data-accordion="open">
                    @foreach ([
                    'Where is K. Palafox Realty located?' => 'We are located at [Insert complete address here].',
                    'What are your business hours?' => 'Monday to Saturday, 8:00 AM to 6:00 PM.',
                    'Do you offer property consultations?' => 'Yes, we provide free consultations for buying, selling, and investment planning.',
                    'Can I schedule a property viewing online?' => 'Yes! You can schedule through our website or contact us directly.',
                    'Do you assist with property financing?' => 'Yes, we connect you with trusted financial institutions for home loans.'
                    ] as $question => $answer)
                    <h2>
                        <button type="button" class="flex justify-between w-full p-4 font-medium text-gray-700 border hover:bg-gray-100">
                            <span>{{ $question }}</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                        <div id="faq-body-{{ $loop->index }}" class="hidden">
                            <div class="p-4 border border-t-0 text-gray-600">
                                {{ $answer }}
                            </div>
                        </div>
                    </h2>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-white text-black py-10 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <!-- Logo & Address -->
            <div>
                <img src="/images/logos/K._Palafox_Realty_Full_Logo.png" alt="Logo" class="mb-2">
                <address class="text-sm">Papaya Road, Mabini Homesite, Cabanatuan City, Nueva Ecija 3100 Philippines</address>
            </div>

            <!-- Navigation 1 -->
            <div>
                <h4 class="text-lg font-semibold mb-2">Home</h4>
                <ul class="space-y-1 text-sm">
                    <li><a href="#about" class="hover:underline">About Us</a></li>
                    <li><a href="#developers" class="hover:underline">Developers</a></li>
                    <li><a href="#property" class="hover:underline">Property</a></li>
                    <li><a href="#location" class="hover:underline">Location</a></li>
                </ul>
            </div>

            <!-- Navigation 2 -->
            <div>
                <h4 class="text-lg font-semibold mb-2">Support</h4>
                <ul class="space-y-1 text-sm">
                    <li><a href="#xxx" class="hover:underline">Help Center</a></li>
                    <li><a href="#xxx" class="hover:underline">Contact</a></li>
                    <li><a href="#xxx" class="hover:underline">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-2">Contact Us</h4>
                <ul class="space-y-1 text-sm">
                    <li>K. Palafox Realty</li>
                    <li>kpalafoxrealtyofficial@gmail.com</li>
                    <li>0912 345 6789</li>
                </ul>
            </div>
        </div>

        <div class="mt-8 text-center text-sm text-gray-600">
            © 2025 K. Palafox Realty. All rights reserved.
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true
            , spaceBetween: 30
            , slidesPerView: 1
            , breakpoints: {
                640: {
                    slidesPerView: 1
                }
                , 768: {
                    slidesPerView: 2
                }
                , 1024: {
                    slidesPerView: 3
                }
            , }
            , navigation: {
                nextEl: '.swiper-button-next'
                , prevEl: '.swiper-button-prev'
            }
            , pagination: {
                el: '.swiper-pagination'
                , clickable: true
            }
            , autoplay: {
                delay: 3000
                , disableOnInteraction: false
            }
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>
</html>
