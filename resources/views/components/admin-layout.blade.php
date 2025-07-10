<x-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-100">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden">
        </div>

        <!-- Sidebar -->
        <!-- Mobile Sidebar -->
        <div x-show="sidebarOpen" x-cloak
            class="fixed inset-y-0 left-0 z-30 w-64 transition duration-300 transform bg-blue-800 text-white shadow-lg lg:hidden"
            :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">
            <div class="p-4 font-bold text-xl bg-blue-900 border-b border-blue-700 flex justify-between items-center">
                <h1>Admin Dashboard</h1>
                <button @click="sidebarOpen = false" class="p-2 rounded-md hover:bg-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-4">
                <ul>
                    <li class="mb-1">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->is('dashboard') ? 'bg-blue-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('karyawan.index') }}"
                            class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->is('karyawan*') ? 'bg-blue-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Data Karyawan
                        </a>
                    </li>
                    @can('admin')
                        <li class="mb-1">
                            <a href="{{ route('users.index') }}"
                                class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->is('users*') ? 'bg-blue-700' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Manajemen User
                            </a>
                        </li>
                    @endcan
                </ul>
            </nav>
        </div>

        <!-- Desktop Sidebar -->
        <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0 bg-blue-800 text-white shadow-lg">
            <div class="p-4 font-bold text-xl bg-blue-900 border-b border-blue-700">
                <h1>Admin Dashboard</h1>
            </div>
            <nav class="mt-4 flex-1">
                <ul>
                    <li class="mb-1">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->is('dashboard') ? 'bg-blue-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('karyawan.index') }}"
                            class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->is('karyawan*') ? 'bg-blue-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 0 012 2" />
                            </svg>
                            Data Karyawan
                        </a>
                    </li>
                    @can('admin')
                        <li class="mb-1">
                            <a href="{{ route('users.index') }}"
                                class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->is('users*') ? 'bg-blue-700' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Manajemen User
                            </a>
                        </li>
                    @endcan
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top Navigation -->
            <div class="bg-white shadow-md p-4 flex justify-between items-center">
                <!-- Mobile hamburger -->
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-800" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <h2 class="text-xl font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
                <div class="flex items-center">
                    <span class="mr-2 hidden sm:inline">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-blue-800 text-white px-2 sm:px-4 py-2 rounded hover:bg-blue-900 transition">
                            <span class="hidden sm:inline">Logout</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:hidden" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-4 md:p-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-layout>
