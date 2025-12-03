<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Recipedia') }} - {{ $title ?? 'Your Recipe Collection' }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                        <span class="text-2xl font-bold text-gray-900">Recipedia</span>
                    </a>
                    <!-- Navigation Links -->
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('recipes.index') }}" class="text-gray-700 hover:text-orange-500 font-medium transition">
                            Recipes
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-orange-500 font-medium transition">
                                Dashboard
                            </a>
                        @endauth
                    </div>
                </div>
                <!-- Search Bar (Desktop) -->
                <div class="hidden md:flex items-center flex-1 max-w-md mx-8">
                    <form action="{{ route('recipes.index') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search recipes..." 
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            >
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </form>
                </div>
                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('recipes.create') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            New Recipe
                        </a>
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-orange-500 font-medium">
                                <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden lg:block">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <!-- Dropdown -->
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border border-gray-200">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        <!-- Mobile Search -->
        <div class="md:hidden px-4 pb-3">
            <form action="{{ route('recipes.index') }}" method="GET">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Search recipes..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                >
            </form>
        </div>
    </nav>
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between" x-data="{ show: true }" x-show="show">
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="text-green-800 hover:text-green-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between" x-data="{ show: true }" x-show="show">
                <span>{{ session('error') }}</span>
                <button @click="show = false" class="text-red-800 hover:text-red-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif
    <!-- Main Content -->
    <main class="py-8">
        {{ $slot }}
    </main>
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-600 mb-4 md:mb-0">
                    © {{ date('Y') }} Recipedia. All rights reserved.
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-orange-500">About</a>
                    <a href="#" class="text-gray-600 hover:text-orange-500">Contact</a>
                    <a href="#" class="text-gray-600 hover:text-orange-500">Privacy</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
