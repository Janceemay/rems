<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>K.Palafox Realty</title>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- UIcons --}}
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css">
</head>

<body x-data="{ sidebarOpen: window.innerWidth >= 1024, collapsed: false }" class="bg-white min-h-screen flex">

    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-full bg-white shadow-lg z-40 transition-all duration-300 ease-in-out"
           :class="{ 'w-20': collapsed, 'w-64': !collapsed, '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

        <!-- Collapse Toggle -->
        <div class="p-6 flex justify-between items-center">
            <h1 x-show="!collapsed" class="text-xl font-bold whitespace-nowrap">K.Palafox Realty</h1>
            <button @click="collapsed = !collapsed" class="text-[#2a47ff]">
                <i class="fi fi-br-menu-burger text-2xl"></i>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        @include('components.sidebar.sidebar')
    </aside>

    <!-- Main Content -->
    <div class="flex-1 transition-all duration-300 ease-in-out"
         :class="{ 'ml-20': collapsed && sidebarOpen, 'ml-64': !collapsed && sidebarOpen, 'ml-0': !sidebarOpen }">

        <!-- Top Navigation -->
        <div class="p-4 border-b-2 border-gray-300 bg-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-2xl font-bold text-gray-800">@yield('title')</h2>

                @auth
                <div class="flex items-center gap-3 text-sm sm:text-base text-gray-600">
                    <div class="text-right">
                        <div class="font-semibold text-gray-800 truncate max-w-[150px] sm:max-w-none">{{ Auth::user()->full_name }}</div>
                        <div class="text-xs text-gray-500 truncate max-w-[150px] sm:max-w-none">{{ Auth::user()->email }}</div>
                    </div>
                    <img src="{{ asset(Auth::user()->profile_picture ?? 'images/default-profile.jpg') }}"
                         alt="Avatar"
                         class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border" />
                </div>
                @endauth
            </div>
        </div>

        <!-- Page Content -->
        <main class="p-4 sm:p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
