<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartWallet - Master Your Finances</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons@3.3.1/css/all/all.min.css">
    <link rel="icon" href="imgs/icon.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hero-gradient {
            background: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.1) 0%, rgba(255, 255, 255, 0) 50%);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 antialiased overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.location.href='/'">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <i class="fi fi-rr-wallet text-xl mt-1"></i>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">Smart<span class="text-emerald-600">Wallet</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-emerald-600 font-medium transition-colors">Features</a>
                    <a href="#about" class="text-gray-600 hover:text-emerald-600 font-medium transition-colors">About</a>
                    <div class="flex items-center gap-4 ml-4">
                        <a href="/login" class="text-gray-900 font-semibold hover:text-emerald-600 transition-colors">Log in</a>
                        <a href="/register" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-full font-medium shadow-lg shadow-emerald-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                            Get Started
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-gray-600 hover:text-gray-900 p-2">
                        <i class="fi fi-rr-menu-burger text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 hero-gradient"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-100 rounded-full px-4 py-1.5 mb-8 animate-fade-in-up">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-sm font-medium text-emerald-700">The #1 Personal Finance Tool</span>
                </div>

                <h1 class="text-5xl lg:text-7xl font-extrabold text-gray-900 tracking-tight mb-8 leading-tight">
                    Smart Insights for <br>
                    <span class="text-emerald-600 inline-block relative">
                        Better Decisions
                        <svg class="absolute w-full h-3 -bottom-1 left-0 text-emerald-200 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" />
                        </svg>
                    </span>
                </h1>

                <p class="text-xl text-gray-600 mb-12 max-w-2xl mx-auto leading-relaxed">
                    Take control of your financial future with powerful analytics, effortless tracking, and smart savings goals. Join thousands managing their money smarter.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="/register" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white text-lg px-8 py-4 rounded-xl font-bold shadow-xl shadow-emerald-200 hover:shadow-2xl hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2">
                        Start for Free
                        <i class="fi fi-rr-arrow-small-right text-xl mt-1"></i>
                    </a>
                    <a href="#demo" class="w-full sm:w-auto bg-white hover:bg-gray-50 text-gray-900 border border-gray-200 text-lg px-8 py-4 rounded-xl font-bold hover:border-gray-300 transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fi fi-rr-play-alt text-emerald-600 text-lg mt-1"></i>
                        Watch Demo
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="mt-16 pt-8 border-t border-gray-200/60 flex flex-col items-center">
                    <p class="text-sm text-gray-500 mb-6 font-medium">TRUSTED BY SMART SAVERS EVERYWHERE</p>
                    <div class="flex flex-wrap justify-center gap-8 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                        <!-- Placeholders for "Logos" using text for now -->
                        <span class="text-xl font-bold text-gray-400">Finance<span class="text-gray-600">Corp</span></span>
                        <span class="text-xl font-bold text-gray-400">Save<span class="text-gray-600">It</span></span>
                        <span class="text-xl font-bold text-gray-400">Money<span class="text-gray-600">Mate</span></span>
                        <span class="text-xl font-bold text-gray-400">Bank<span class="text-gray-600">Zero</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-emerald-600 font-semibold tracking-wide uppercase text-sm mb-3">Features</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Everything you need to grow your wealth</h3>
                <p class="text-lg text-gray-600">Stop guessing where your money goes. SmartWallet gives you the tools to track, analyze, and optimize your spending.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-2xl bg-gray-50 hover:bg-white border border-gray-100 hover:border-emerald-100 hover:shadow-xl hover:shadow-emerald-50 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fi fi-rr-chart-histogram"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Visual Analytics</h4>
                    <p class="text-gray-600 leading-relaxed">Visualize your income and expenses with beautiful, easy-to-read charts and graphs.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-2xl bg-gray-50 hover:bg-white border border-gray-100 hover:border-blue-100 hover:shadow-xl hover:shadow-blue-50 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fi fi-rr-wallet"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Budget Tracking</h4>
                    <p class="text-gray-600 leading-relaxed">Set monthly budgets for different categories and get notified when you're close to limits.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-2xl bg-gray-50 hover:bg-white border border-gray-100 hover:border-purple-100 hover:shadow-xl hover:shadow-purple-50 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fi fi-rr-shield-check"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Secure & Private</h4>
                    <p class="text-gray-600 leading-relaxed">Your financial data is encrypted and secure. We prioritize your privacy above all else.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-24 bg-gray-900 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

        <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Ready to take control?</h2>
            <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">Join the community of smart savers today. No credit card required for basic account.</p>
            <a href="/register" class="inline-block bg-emerald-500 hover:bg-emerald-400 text-gray-900 font-bold text-lg px-8 py-4 rounded-xl shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:shadow-[0_0_30px_rgba(16,185,129,0.6)] hover:-translate-y-1 transition-all duration-200">
                Create Your Free Account
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white">
                            <i class="fi fi-rr-wallet mt-1"></i>
                        </div>
                        <span class="font-bold text-lg text-gray-900">SmartWallet</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">Making financial freedom accessible to everyone through smart analytics.</p>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-400 hover:text-emerald-600 transition-colors"><i class="fi fi-brands-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-emerald-600 transition-colors"><i class="fi fi-brands-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-emerald-600 transition-colors"><i class="fi fi-brands-instagram"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Product</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-emerald-600 transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-emerald-600 transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-emerald-600 transition-colors">Security</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-emerald-600 transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-emerald-600 transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-emerald-600 transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-emerald-600 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-emerald-600 transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500">&copy; <?php echo date('Y'); ?> SmartWallet. All rights reserved.</p>
                <div class="flex gap-6 text-sm text-gray-500">
                    <a href="#" class="hover:text-emerald-600">Privacy</a>
                    <a href="#" class="hover:text-emerald-600">Terms</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>