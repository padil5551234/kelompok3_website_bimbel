<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar { transition: transform 0.3s ease; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 sidebar fixed inset-y-0 left-0 z-50" id="sidebar">
            <div class="text-white text-2xl text-center font-bold mb-8">
                Admin Panel
            </div>
            
            <nav class="space-y-2">
                <a href="{{ route('admin.integrated-dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition duration-200">
                    <i class="fas fa-graduation-cap mr-3"></i>Integrated Courses
                </a>
                
                <!-- Fixed: Remove problematic route references -->
                <a href="javascript:void(0)" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition duration-200 opacity-50 cursor-not-allowed" title="Coming Soon">
                    <i class="fas fa-file-alt mr-3"></i>Materials
                </a>
                
                <a href="javascript:void(0)" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition duration-200 opacity-50 cursor-not-allowed" title="Coming Soon">
                    <i class="fas fa-users mr-3"></i>Users
                </a>
                
                <a href="javascript:void(0)" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition duration-200 opacity-50 cursor-not-allowed" title="Coming Soon">
                    <i class="fas fa-book mr-3"></i>Paket Ujian
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden md:ml-64">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button class="text-gray-500 focus:outline-none md:hidden mr-4" onclick="toggleSidebar()">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Admin Panel')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Welcome, Admin!</span>
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-semibold">A</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = event.target.closest('button[onclick="toggleSidebar()"]');
            
            if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth <= 768) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>