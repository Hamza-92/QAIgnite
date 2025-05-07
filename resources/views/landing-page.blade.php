<!DOCTYPE html>
<html lang="en" x-data="{ mobileMenuOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QA Ignite | Next-Gen QA Management Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                },
                extend: {
                    colors: {
                        primary: {
                            500: '#0A84FF',
                            600: '#0077E6'
                        },
                        secondary: {
                            500: '#FF5722',
                            100: '#FFE0B2',
                            900: '#BF360C'
                        },
                        dark: {
                            800: '#1E293B',
                            900: '#0F172A',
                            950: '#020617'
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body {
            background-color: #0F172A;
            color: #E2E8F0;
        }
        .back-to-top {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        .back-to-top.show {
            opacity: 1;
            transform: translateY(0);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased overflow-x-hidden">
    <!-- Navigation -->
    <nav class="bg-gray-900/90 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-800">
        <div class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="#" class="flex items-center space-x-2">
                    <div class="w-10 h-10 rounded-lg bg-primary-500 flex items-center justify-center">
                        <i class="fas fa-bolt text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">QA Ignite</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#features" class="text-gray-400 hover:text-primary-400 font-medium transition-colors duration-300">Features</a>
                    <a href="#solutions" class="text-gray-400 hover:text-primary-400 font-medium transition-colors duration-300">Solutions</a>
                    <a href="#testimonials" class="text-gray-400 hover:text-primary-400 font-medium transition-colors duration-300">Testimonials</a>
                    <a href="#contact" class="text-gray-400 hover:text-primary-400 font-medium transition-colors duration-300">Contact</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden lg:flex items-center space-x-4">
                    @if (Auth::check())
                    <a href="{{route('dashboard')}}" class="px-6 py-2 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300">Dashboard</a>
                    @else
                    <a href="{{route('login')}}" class="px-4 py-2 text-gray-300 font-medium rounded-lg hover:text-primary-400 transition-colors duration-300">Login</a>
                    <a href="{{route('register')}}" class="px-6 py-2 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300">Get Started</a>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-300 focus:outline-none">
                    <i class="fas fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-xl" x-show="mobileMenuOpen"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="lg:hidden" x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95" @click.away="mobileMenuOpen = false">
                <div class="pt-4 pb-6 space-y-1 bg-gray-900 shadow-lg">
                    <a href="#features" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-primary-400 hover:bg-gray-800">Features</a>
                    <a href="#solutions" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-primary-400 hover:bg-gray-800">Solutions</a>
                    <a href="#testimonials" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-primary-400 hover:bg-gray-800">Testimonials</a>
                    <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-primary-400 hover:bg-gray-800">Contact</a>
                    <div class="pt-4 border-t border-gray-800">
                        <div class="flex items-center justify-between px-3">
                            @if (Auth::check())
                                <a href="{{route('dashboard')}}" class="px-4 py-2 text-gray-300 font-medium rounded-lg hover:text-primary-400">Dashboard</a>
                            @else
                                <a href="{{route('login')}}" class="px-4 py-2 text-gray-300 font-medium rounded-lg hover:text-primary-400">Login</a>
                                <a href="{{route('register')}}" class="px-4 py-2 bg-primary-500 text-white font-medium rounded-lg shadow-md">Get Started</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Illustration -->
    <section class="relative overflow-hidden bg-gray-950">
        <div class="container mx-auto px-6 py-24 md:py-32 lg:py-40">
            <div class="flex flex-col lg:flex-row items-center">
                <!-- Hero Content -->
                <div class="lg:w-1/2 mb-16 lg:mb-0">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 text-white">
                        The Ultimate Platform for <span class="text-primary-400">QA Excellence</span>
                    </h1>
                    <p class="text-xl text-gray-400 mb-8 max-w-lg">
                        Streamline your entire quality assurance process with our powerful, all-in-one solution designed for modern development teams.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#" class="px-8 py-4 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center">
                            Start Free Trial <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="#features" class="px-8 py-4 border border-gray-700 font-semibold rounded-lg hover:bg-gray-800 transition-colors duration-300 text-center text-white">
                            Explore Features
                        </a>
                    </div>
                </div>

                <!-- Hero Illustration -->
                <div class="lg:w-1/2 relative">
                    <div class="relative w-full max-w-xl mx-auto animate-float">
                        <img src="https://source.unsplash.com/featured/?dashboard,technology" alt="QA Dashboard Illustration" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section (keep your existing features section) -->
    <section id="features" class="py-20 bg-gray-900">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <span
                    class="inline-block px-3 py-1 text-sm font-semibold bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-300 rounded-full mb-4">Features</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Everything You Need for <span
                        class="gradient-text">Quality Assurance</span></h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Powerful features designed to
                    streamline your QA process from start to finish</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="w-14 h-14 rounded-lg bg-primary-500 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-project-diagram text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Project Management</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Organize and track all your QA projects with
                        intuitive dashboards and progress tracking.</p>
                    <a href="#"
                        class="inline-flex items-center text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 font-medium">
                        Learn more <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Feature 2 -->
                <div
                    class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div
                        class="w-14 h-14 rounded-lg bg-secondary-500 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-robot text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">AI Test Generation</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Automatically generate comprehensive test cases
                        from requirements using our AI engine.</p>
                    <a href="#"
                        class="inline-flex items-center text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 font-medium">
                        Learn more <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Feature 3 -->
                <div
                    class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="w-14 h-14 rounded-lg bg-purple-500 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-bug text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Defect Tracking</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Efficiently log, track, and resolve defects with
                        customizable workflows and notifications.</p>
                    <a href="#"
                        class="inline-flex items-center text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 font-medium">
                        Learn more <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Feature 4 -->
                <div
                    class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="w-14 h-14 rounded-lg bg-green-500 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-link text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Traceability Matrix</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Maintain full traceability between requirements,
                        test cases, and defects for compliance.</p>
                    <a href="#"
                        class="inline-flex items-center text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 font-medium">
                        Learn more <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Feature 5 -->
                <div
                    class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="w-14 h-14 rounded-lg bg-yellow-500 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Advanced Analytics</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Gain actionable insights with customizable
                        dashboards and real-time reporting.</p>
                    <a href="#"
                        class="inline-flex items-center text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 font-medium">
                        Learn more <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Feature 6 -->
                <div
                    class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="w-14 h-14 rounded-lg bg-blue-500 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Team Collaboration</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Real-time collaboration tools to keep your QA team
                        aligned and productive.</p>
                    <a href="#"
                        class="inline-flex items-center text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 font-medium">
                        Learn more <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions Section (keep your existing solutions section) -->
    <section id="solutions" class="py-20 bg-gray-950">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <span
                    class="inline-block px-3 py-1 text-sm font-semibold bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-300 rounded-full mb-4">Solutions</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Tailored for <span class="gradient-text">Your
                        Role</span></h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">QA Ignite adapts to your specific
                    needs, no matter your role in the quality process</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Solution 1 -->
                <div
                    class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl transform hover:-translate-y-2">
                    <div class="h-3 bg-primary-500"></div>
                    <div class="p-6">
                        <div
                            class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-800 flex items-center justify-center text-primary-500 dark:text-blue-300 mb-4">
                            <i class="fas fa-user-tie text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 dark:text-white">QA Managers</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Oversee the entire QA process with
                            comprehensive dashboards and reporting tools.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Team performance metrics</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Quality trend analysis</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Resource planning</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 font-medium inline-flex items-center">
                            Explore <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Solution 2 -->
                <div
                    class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl transform hover:-translate-y-2">
                    <div class="h-3 bg-secondary-500"></div>
                    <div class="p-6">
                        <div
                            class="w-12 h-12 rounded-lg bg-secondary-100 dark:bg-orange-700 flex items-center justify-center text-secondary-600 dark:text-orange-300 mb-4">
                            <i class="fas fa-vial text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 dark:text-white">Testers</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Execute test cases efficiently with intuitive
                            tools designed for QA professionals.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Test case management</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Defect reporting</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Test automation</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 font-medium inline-flex items-center">
                            Explore <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Solution 3 -->
                <div
                    class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl transform hover:-translate-y-2">
                    <div class="h-3 bg-purple-500"></div>
                    <div class="p-6">
                        <div
                            class="w-12 h-12 rounded-lg bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-500 dark:text-purple-300 mb-4">
                            <i class="fas fa-code text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 dark:text-white">Developers</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Quickly address defects and understand test
                            coverage to improve code quality.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Defect triage</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Test coverage</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">CI/CD integration</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 font-medium inline-flex items-center">
                            Explore <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Solution 4 -->
                <div
                    class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl transform hover:-translate-y-2">
                    <div class="h-3 bg-green-500"></div>
                    <div class="p-6">
                        <div
                            class="w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-500 dark:text-green-300 mb-4">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 dark:text-white">Clients</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Monitor project progress and quality metrics
                            with client-friendly dashboards.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Project status</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Quality metrics</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">Feedback tools</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 font-medium inline-flex items-center">
                            Explore <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section (keep your existing testimonials) -->
    <section id="testimonials" class="py-20 bg-primary-500/10">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <span
                    class="inline-block px-3 py-1 text-sm font-semibold bg-white/20 rounded-full mb-4">Testimonials</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Trusted by <span class="text-yellow-300">Leading
                        Teams</span></h2>
                <p class="text-lg text-white/90 max-w-2xl mx-auto">Don't just take our word for it. Here's what our
                    customers say about QA Ignite.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div
                    class="bg-white/10 backdrop-blur-md rounded-xl p-8 border border-white/20 hover:border-white/30 transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg"
                            class="w-12 h-12 rounded-full mr-4" alt="Sarah Johnson">
                        <div>
                            <h4 class="font-bold">Sarah Johnson</h4>
                            <p class="text-sm text-white/70">QA Director, TechCorp</p>
                        </div>
                    </div>
                    <p class="mb-6 italic">"QA Ignite has transformed our testing process. The AI test generation alone
                        has saved us hundreds of hours each quarter."</p>
                    <div class="flex text-yellow-300">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div
                    class="bg-white/10 backdrop-blur-md rounded-xl p-8 border border-white/20 hover:border-white/30 transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-12 h-12 rounded-full mr-4"
                            alt="Michael Chen">
                        <div>
                            <h4 class="font-bold">Michael Chen</h4>
                            <p class="text-sm text-white/70">Lead Developer, InnovateSoft</p>
                        </div>
                    </div>
                    <p class="mb-6 italic">"The defect tracking and collaboration features have dramatically improved
                        our developer-QA workflow. Highly recommended!"</p>
                    <div class="flex text-yellow-300">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div
                    class="bg-white/10 backdrop-blur-md rounded-xl p-8 border border-white/20 hover:border-white/30 transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg"
                            class="w-12 h-12 rounded-full mr-4" alt="Emma Rodriguez">
                        <div>
                            <h4 class="font-bold">Emma Rodriguez</h4>
                            <p class="text-sm text-white/70">Product Manager, GlobalBank</p>
                        </div>
                    </div>
                    <p class="mb-6 italic">"The traceability matrix has been a game-changer for our compliance needs.
                        Implementation was seamless and the support excellent."</p>
                    <div class="flex text-yellow-300">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section (keep your existing contact form) -->
    <section id="contact" class="py-20 bg-gray-900">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Contact Info -->
                <div class="lg:w-1/2">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Get in <span class="gradient-text">Touch</span>
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">Have questions or want to learn more about
                        QA Ignite? Our team is here to help.</p>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 bg-primary-100 dark:bg-primary-900 p-3 rounded-lg text-primary-500 dark:text-primary-300 mr-4">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 dark:text-white mb-1">Email Us</h4>
                                <p class="text-gray-600 dark:text-gray-400">support@qa-ignite.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 bg-primary-100 dark:bg-primary-900 p-3 rounded-lg text-primary-500 dark:text-primary-300 mr-4">
                                <i class="fas fa-phone-alt text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 dark:text-white mb-1">Call Us</h4>
                                <p class="text-gray-600 dark:text-gray-400">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 bg-primary-100 dark:bg-primary-900 p-3 rounded-lg text-primary-500 dark:text-primary-300 mr-4">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 dark:text-white mb-1">Visit Us</h4>
                                <p class="text-gray-600 dark:text-gray-400">123 QA Street, Tech City, TC 12345</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="font-bold text-gray-800 dark:text-white mb-4">Follow Us</h4>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-300">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#"
                                class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-300">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#"
                                class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-300">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#"
                                class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-300">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:w-1/2">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md p-8">
                        <h3 class="text-2xl font-bold mb-6 dark:text-white">Send Us a Message</h3>
                        <form x-data="{ formData: { name: '', email: '', subject: '', message: '' }, submitting: false, success: false }"
                            @submit.prevent="submitting = true; $nextTick(() => { submitting = false; success = true; setTimeout(() => success = false, 5000); formData = { name: '', email: '', subject: '', message: '' }; })">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
                                    <input type="text" id="name" x-model="formData.name" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-all duration-300">
                                </div>
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                    <input type="email" id="email" x-model="formData.email" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-all duration-300">
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="subject"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                                <input type="text" id="subject" x-model="formData.subject" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-all duration-300">
                            </div>
                            <div class="mb-6">
                                <label for="message"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                                <textarea id="message" x-model="formData.message" rows="5" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-all duration-300"></textarea>
                            </div>
                            <div class="flex items-center justify-between">
                                <div x-show="success" x-transition class="text-green-600 dark:text-green-400 text-sm">
                                    <i class="fas fa-check-circle mr-1"></i> Your message has been sent successfully!
                                </div>
                                <button type="submit"
                                    class="px-8 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                                    :disabled="submitting">
                                    <span x-show="!submitting">Send Message</span>
                                    <span x-show="submitting" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Sending...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (keep your existing footer) -->
    <footer class="bg-gray-950 pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-primary-500 flex items-center justify-center text-white">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <span class="text-xl font-bold text-white">QA Ignite</span>
                    </div>
                    <p class="mb-4">The intelligent QA management platform for modern software teams.</p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 hover:bg-gray-700 flex items-center justify-center text-gray-400 hover:text-white transition-colors duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 hover:bg-gray-700 flex items-center justify-center text-gray-400 hover:text-white transition-colors duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 hover:bg-gray-700 flex items-center justify-center text-gray-400 hover:text-white transition-colors duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 hover:bg-gray-700 flex items-center justify-center text-gray-400 hover:text-white transition-colors duration-300">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Product</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="hover:text-white transition-colors duration-300">Features</a>
                        </li>
                        <li><a href="#solutions" class="hover:text-white transition-colors duration-300">Solutions</a>
                        </li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Integrations</a>
                        </li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Roadmap</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="hover:text-white transition-colors duration-300">Documentation</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">API
                                Reference</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Community</a>
                        </li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Webinars</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition-colors duration-300">About Us</a>
                        </li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Press</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Legal</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="mb-4 md:mb-0">© 2023 QA Ignite. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-white transition-colors duration-300">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors duration-300">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors duration-300">Cookie Policy</a>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" x-data="{ show: false }"
            @scroll.window="show = window.pageYOffset > 300" :class="{ 'show': show }"
            class="back-to-top fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-full shadow-lg flex items-center justify-center hover:shadow-xl transition-all duration-300">
            <i class="fas fa-arrow-up"></i>
        </button>
    </footer>

    <!-- GSAP Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            // Animate hero content
            gsap.from('.hero-content h1', {
                duration: 1,
                y: 50,
                opacity: 0,
                ease: 'power3.out'
            });

            gsap.from('.hero-content p', {
                duration: 1,
                y: 50,
                opacity: 0,
                delay: 0.3,
                ease: 'power3.out'
            });

            gsap.from('.hero-content .buttons', {
                duration: 1,
                y: 50,
                opacity: 0,
                delay: 0.6,
                ease: 'power3.out'
            });

            // Animate illustration
            gsap.from('.hero-illustration', {
                duration: 1,
                x: 50,
                opacity: 0,
                delay: 0.3,
                ease: 'power3.out'
            });
        });
    </script>
</body>
</html>
