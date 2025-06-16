<!DOCTYPE html>
<html lang="ru" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"  rel="stylesheet">
    <script src="{{ asset('js/admin.js') }}" defer></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile sidebar -->
        <div id="mobile-menu" class="fixed inset-0 z-50 flex md:hidden lg:hidden backdrop-blur-sm bg-black/30 hidden">
            <div class="w-64 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-300">
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-blue-600 dark:text-blue-400">Админ-панель</h2>
                    <button id="close-menu" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="mt-4">
                    @if(auth()->user()->role === 'administrator')
                        <ul class="space-y-1 p-4">
                            <li><a href="{{ url('/admin/dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 group">
                                <i class="fas fa-chart-line text-blue-500 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Дашборд</span>
                            </a></li>
                            <li><a href="{{ url('/admin/properties') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 group">
                                <i class="fas fa-building text-blue-500 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Объекты</span>
                            </a></li>
                            <li><a href="{{ url('/admin/users') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 group">
                                <i class="fas fa-users text-blue-500 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Пользователи</span>
                            </a></li>
                            <li><a href="{{ url('/admin/requests') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 group">
                                <i class="fas fa-file-alt text-blue-500 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Заявки</span>
                            </a></li>
                        </ul>
                    @elseif(auth()->user()->role === 'moderator')
                        <ul class="space-y-1 p-4">
                            <li><a href="{{ url('/admin/properties') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 group">
                                <i class="fas fa-clock text-blue-500 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">На проверке</span>
                            </a></li>
                        </ul>
                    @endif
                </nav>
            </div>
        </div>

        <!-- Sidebar -->
        <aside id="desktop-menu" class="hidden md:flex lg:flex flex-col w-64 bg-gradient-to-b from-blue-600 to-blue-700 text-white shadow-lg">
            <div class="flex items-center justify-between p-4">
                <h2 class="text-xl font-bold flex items-center">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Админ-панель
                </h2>
                <button id="collapse-menu" class="md:hidden lg:hidden text-white hover:text-blue-200">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto">
                <nav class="mt-4 px-2 py-4">
                    @if(auth()->user()->role === 'administrator')
                        <ul class="space-y-1">
                            <li><a href="{{ url('/admin/dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-500/30 transition-all duration-200 group">
                                <i class="fas fa-chart-line mr-3 text-white group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Дашборд</span>
                            </a></li>
                            <li><a href="{{ url('/admin/properties') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-500/30 transition-all duration-200 group">
                                <i class="fas fa-building mr-3 text-white group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Объекты</span>
                            </a></li>
                            <li><a href="{{ url('/admin/users') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-500/30 transition-all duration-200 group">
                                <i class="fas fa-users mr-3 text-white group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Пользователи</span>
                            </a></li>
                            <li><a href="{{ url('/admin/requests') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-500/30 transition-all duration-200 group">
                                <i class="fas fa-file-alt mr-3 text-white group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Заявки</span>
                            </a></li>
                        </ul>
                    @elseif(auth()->user()->role === 'moderator')
                        <ul class="space-y-1">
                            <li><a href="{{ url('/admin/properties') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-500/30 transition-all duration-200 group">
                                <i class="fas fa-clock mr-3 text-white group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">На проверке</span>
                            </a></li>
                        </ul>
                    @endif
                </nav>
            </div>
            <div class="p-4 border-t border-blue-500/30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-white/20 flex items-center justify-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="ml-2 text-sm">{{ auth()->user()->name }}</span>
                    </div>
                    <button class="text-white hover:text-blue-200">
                        <a href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt"></i></a>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow-md p-4 flex justify-between items-center sticky top-0 z-10">
                <div class="flex items-center">
                    <button id="toggle-menu" class="md:hidden lg:hidden mr-4 text-gray-600 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400">@yield('title')</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-600 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400">
                        <i class="fas fa-bell"></i>
                    </button>
                    <div class="hidden md:block lg:block">
                        <span class="text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                        <a href="{{ url('/logout') }}" class="ml-4 text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
                            <i class="fas fa-sign-out-alt mr-1"></i> Выйти
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenu = document.getElementById('mobile-menu');
        const toggleMenu = document.getElementById('toggle-menu');
        const closeMenu = document.getElementById('close-menu');

        toggleMenu.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
        });

        closeMenu.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });

        const collapseMenu = document.getElementById('collapse-menu');
        if (collapseMenu) {
            collapseMenu.addEventListener('click', () => {
                document.getElementById('desktop-menu').classList.toggle('w-16');
            });
        }
    });
</script>
</html>
