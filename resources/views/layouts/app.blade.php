<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rental Management System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between shrink-0 shadow-lg">
            <div>
                <!-- Logo / Brand -->
                <div class="h-16 flex items-center justify-center border-b border-slate-800 px-4">
                    <h1 class="text-xl font-bold text-blue-400 flex items-center gap-2">
                        <i data-lucide="building-2"></i> Rental Admin
                    </h1>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-6 px-4 space-y-2">
                    <!-- Dashboard Navigation Link -->
                    <a href="{{ route('web.dashboard') }}" 
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('web.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300' }}">
                        <i data-lucide="layout-dashboard"></i> Dashboard
                    </a>

                    <!-- Properties Navigation Link -->
                    <a href="{{ route('web.properties') }}" 
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('web.properties') ? 'bg-blue-600 text-white' : 'text-slate-300' }}">
                        <i data-lucide="home"></i> អគារស្នាក់នៅ (Properties)
                    </a>

                    <!-- Rooms Navigation Link -->
                    <a href="{{ route('web.rooms') }}" 
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('web.rooms') ? 'bg-blue-600 text-white' : 'text-slate-300' }}">
                        <i data-lucide="door-open"></i> បន្ទប់ជួល (Rooms)
                    </a>

                    <!-- Tenants Navigation Link -->
                    <a href="{{ route('web.tenants') }}" 
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('web.tenants') ? 'bg-blue-600 text-white' : 'text-slate-300' }}">
                        <i data-lucide="users"></i> អ្នកជួល (Tenants)
                    </a>

                    <!-- Invoices Navigation Link -->
                    <a href="{{ route('web.invoices') }}" 
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('web.invoices') ? 'bg-blue-600 text-white' : 'text-slate-300' }}">
                        <i data-lucide="file-text"></i> វិក្កយបត្រ (Invoices)
                    </a>
                </nav>
            </div>

            <!-- Admin Profile / Logout -->
            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            A
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Admin</p>
                            <p class="text-xs text-slate-400">admin@rental.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- Top Navbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
                <h2 class="text-xl font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">កាលបរិច្ឆេទ៖ {{ date('d-M-Y') }}</span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>