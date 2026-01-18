        <!-- Sidebar -->
        <aside class="h-screen flex flex-col absolute z-40 left-0 top-0 bottom-0 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out md:relative md:translate-x-0 hidden lg:flex">
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <div class="flex items-center gap-2 text-emerald-600">
                    <i class="fi fi-rr-wallet text-3xl"></i>
                    <span class="text-xl font-bold tracking-tight text-gray-900">Smart<span class="text-emerald-600">Wallet</span></span>
                </div>
            </div>

            <nav class="flex-1 h-full py-6 px-3 space-y-1 overflow-y-auto">
                <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 <?php echo (strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false) ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600'; ?> rounded-lg transition-colors">
                    <i class="fi fi-rr-apps text-lg"></i>
                    <span class="font-medium">Overview</span>
                </a>
                <a href="/incomes" class="flex items-center gap-3 px-3 py-2 <?php echo (strpos($_SERVER['REQUEST_URI'], '/incomes') !== false) ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600'; ?> rounded-lg transition-colors">
                    <i class="fi fi-rr-arrow-trend-up text-lg"></i>
                    <span class="font-medium">Incomes</span>
                </a>
                <a href="/expences" class="flex items-center gap-3 px-3 py-2 <?php echo (strpos($_SERVER['REQUEST_URI'], '/expences') !== false) ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600'; ?> rounded-lg transition-colors">
                    <i class="fi fi-rr-arrow-trend-down text-lg"></i>
                    <span class="font-medium">Expenses</span>
                </a>
                <a href="/logout" class="mt-auto flex items-center gap-3 px-3 py-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                    <i class="fi fi-rr-sign-out-alt text-lg"></i>
                    <span class="font-medium">Logout</span>
                </a>
            </nav>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 md:hidden" style="display: none;"></div>

        <!-- Mobile Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-lg transition-transform duration-300 md:hidden ease-in-out">
            <div class="h-16 flex items-center justify-between px-6 border-b border-gray-100">
                <span class="text-xl font-bold text-gray-900">Smart<span class="text-emerald-600">Wallet</span></span>
                <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fi fi-rr-cross"></i>
                </button>
            </div>
            <nav class="flex-1 h-full py-6 px-3 space-y-1">
                <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 <?php echo (strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false) ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600'; ?> rounded-lg">
                    <i class="fi fi-rr-apps text-lg"></i>
                    <span class="font-medium">Overview</span>
                </a>
                <a href="/incomes" class="flex items-center gap-3 px-3 py-2 <?php echo (strpos($_SERVER['REQUEST_URI'], '/incomes') !== false) ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600'; ?> rounded-lg">
                    <i class="fi fi-rr-arrow-trend-up text-lg"></i>
                    <span class="font-medium">Incomes</span>
                </a>
                <a href="/expences" class="flex items-center gap-3 px-3 py-2 <?php echo (strpos($_SERVER['REQUEST_URI'], '/expences') !== false) ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600'; ?> rounded-lg">
                    <i class="fi fi-rr-arrow-trend-down text-lg"></i>
                    <span class="font-medium">Expenses</span>
                </a>
                <a href="/logout" class="mt-auto flex items-center gap-3 px-3 py-2 text-red-500 hover:bg-red-50 rounded-lg">
                    <i class="fi fi-rr-sign-out-alt text-lg"></i>
                    <span class="font-medium">Logout</span>
                </a>
            </nav>
        </div>