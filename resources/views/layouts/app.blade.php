<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Include Tailwind CSS via CDN (simplest solution) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Your existing Vite setup remains -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-100">

<!-- Mobile Menu Button -->
<button id="menuToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-gray-900 text-white p-3 rounded-lg shadow-lg hover:bg-gray-800 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<div class="min-h-screen relative flex">
    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed w-64 bg-gray-900 text-white p-5 h-screen overflow-y-auto z-40 -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl">
        <!-- Logo Section -->
        <div class="mb-8 pb-4 border-b border-gray-700">
            <h2 class="text-xl font-bold text-white">Attendance System</h2>
            <p class="text-sm text-gray-400 mt-1">Management Portal</p>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-6">
            <!-- Admin Section -->
            @if(auth()->user()->role == 'admin')
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-3">Admin Panel</p>
                <ul class="space-y-1">
                    <li>
                        <a href="/admin/dashboard" class="block px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 font-medium">
                            Admin Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 font-medium">
                            Manage Users
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 font-medium">
                            Attendance Reports
                        </a>
                    </li>
                </ul>
            </div>
            @endif
            <!-- User Section -->
            @if(auth()->user()->role == 'user')
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-3">User Panel</p>
                <ul class="space-y-1">
                    <li>
                        <a href="/user/dashboard" class="block px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 font-medium">
                            User Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/user/myAttendance" class="block px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 font-medium">
                            My Attendance
                        </a>
                    </li>
                </ul>
            </div>
            @endif

        </nav>

        <!-- Logout Button -->
        <form method="POST" action="/logout" class="mt-8 pt-4 border-t border-gray-700">
            @csrf
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 px-4 rounded-lg transition-colors duration-200 font-medium">
                Logout
            </button>
        </form>

        <!-- User Info -->
        <div class="mt-6 px-3 py-3 bg-gray-800 rounded-lg">
            <p class="text-sm text-gray-300">Logged in as</p>
            <p class="text-sm font-semibold text-white mt-1">Administrator</p>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl lg:ms-64 mx-auto">       
            
            <!-- Content Area -->
            <div class="bg-white rounded-xl shadow-sm p-4 lg:p-6 border border-gray-200">
                @yield('content')
            </div>

            <!-- Sample Stats Cards -->
             @if(auth()->user()->role == 'admin')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Total Employees</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">156</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Present Today</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">142</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">On Leave</p>
                    <p class="text-2xl font-bold text-orange-600 mt-1">14</p>
                </div>
            </div>
            @endif
        </div>
    </main>
</div>

<script>
    // Mobile menu toggle
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    function toggleMenu() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    menuToggle.addEventListener('click', toggleMenu);
    overlay.addEventListener('click', toggleMenu);

    // Close menu on window resize if open
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
        }
    });

    // Active link highlighting based on current URL
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const links = document.querySelectorAll('nav a');
        
        links.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('bg-gray-800', 'text-white');
            }
        });
    });
</script>

</body>
</html>