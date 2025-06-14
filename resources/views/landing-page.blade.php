<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QATool - Modern QA Management Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .gradient-text {
            background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 50%, #d946ef 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-gradient {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 50%, rgba(217, 70, 239, 0.1) 100%);
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="font-['Inter'] bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <svg class="h-8 w-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900">QA Ignite</span>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Auth::check())
                        <a href="{{ route('dashboard') }}"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">Dashboard</a>
                    @else
                        <a href="/login" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">Sign
                            In</a>
                        <a href="/register"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">Get
                            Started</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden hero-gradient">
        <!-- Animated background elements -->
        <div class="absolute inset-0 opacity-10">
            <div
                class="absolute top-0 left-20 w-64 h-64 bg-purple-300 rounded-full mix-blend-multiply filter blur-2xl opacity-80 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute top-0 right-20 w-64 h-64 bg-indigo-300 rounded-full mix-blend-multiply filter blur-2xl opacity-80 animate-blob animation-delay-4000">
            </div>
            <div
                class="absolute bottom-20 left-1/2 w-64 h-64 bg-pink-300 rounded-full mix-blend-multiply filter blur-2xl opacity-80 animate-blob">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
                <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                    <h1
                        class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl md:text-56xl lg:text-6xl">
                        <span class="block">Revolutionize Your</span>
                        <span class="block gradient-text">QA Workflow</span>
                    </h1>
                    <p class="mt-4 text-xl text-gray-600 leading-relaxed">
                        The all-in-one platform for seamless test management, AI-powered test generation, and real-time
                        analytics. Built for teams who care about quality.
                    </p>
                    <div class="mt-8 sm:flex sm:justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="rounded-md shadow">
                            <a href="/register"
                                class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-lg font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition duration-300 transform hover:scale-105">
                                Start Free Today →
                            </a>
                        </div>
                        <div class="rounded-md shadow">
                            <a href="#"
                                class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-lg font-bold rounded-md text-indigo-700 bg-white hover:bg-gray-50 transition duration-300">
                                <svg class="h-6 w-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 15c1.657 0 3-1.343 3-3V6c0-1.657-1.343-3-3-3S9 4.343 9 6v6c0 1.657 1.343 3 3 3z" />
                                    <path
                                        d="M17 12c0 2.761-2.239 5-5 5s-5-2.239-5-5H5c0 3.866 3.134 7 7 7s7-3.134 7-7h-2z" />
                                </svg>
                                Watch Demo
                            </a>
                        </div>
                    </div>
                    <div class="mt-10 flex items-center space-x-6">
                        <div class="flex -space-x-2 overflow-hidden">
                            <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=100&h=100&q=80"
                                alt="">
                            <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&h=100&q=80"
                                alt="">
                            <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&h=100&q=80"
                                alt="">
                        </div>
                        <p class="text-gray-600">
                            Trusted by <span class="font-bold text-indigo-600">5,000+</span> QA professionals
                        </p>
                    </div>
                </div>
                <div class="mt-10 lg:mt-0 lg:col-span-6">
                    <div class="relative mx-auto w-full rounded-xl shadow-2xl overflow-hidden">
                        <div class="aspect-w-16 aspect-h-9">
                            <img class="w-full h-full object-cover"
                                src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2850&q=80"
                                alt="Dashboard screenshot">
                        </div>
                        <div class="absolute inset-0 bg-indigo-600 mix-blend-overlay opacity-20"></div>
                        <!-- Floating element on the screenshot -->
                        <div class="absolute top-10 left-10 bg-white p-4 rounded-lg shadow-lg w-64 animate-float">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Test passed!</p>
                                    <p class="text-sm text-gray-500">42/42 test cases</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <!-- Features Section -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold tracking-wide text-indigo-600 uppercase">Features</h2>
                <p class="mt-2 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                    Everything your team needs for quality assurance
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Comprehensive tools designed to streamline your entire testing workflow
                </p>
            </div>

            <!-- Feature Cards -->
            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Project Management -->
                <div
                    class="pt-6 pb-8 px-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                    <div class="flow-root bg-gray-50 rounded-lg -mt-12 p-4 inline-flex">
                        <div class="bg-indigo-500 p-3 rounded-lg shadow-md">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Project Management</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Organize testing projects with customizable workflows, milestones, and real-time team
                        collaboration.
                    </p>
                    <div class="mt-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            Team Sync
                        </span>
                        <span
                            class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            Roadmaps
                        </span>
                    </div>
                </div>

                <!-- Test Management -->
                <div
                    class="pt-6 pb-8 px-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                    <div class="flow-root bg-gray-50 rounded-lg -mt-12 p-4 inline-flex">
                        <div class="bg-purple-500 p-3 rounded-lg shadow-md">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Test Management</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Create, organize, and execute test cases with version control and comprehensive reporting.
                    </p>
                    <div class="mt-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Automation
                        </span>
                        <span
                            class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Reporting
                        </span>
                    </div>
                </div>

                <!-- Defect Tracking -->
                <div
                    class="pt-6 pb-8 px-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                    <div class="flow-root bg-gray-50 rounded-lg -mt-12 p-4 inline-flex">
                        <div class="bg-pink-500 p-3 rounded-lg shadow-md">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Defect Tracking</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Log, prioritize, and track defects with seamless integration to your development workflow.
                    </p>
                    <div class="mt-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            JIRA Sync
                        </span>
                        <span
                            class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Priority
                        </span>
                    </div>
                </div>

                <!-- Advanced Analytics -->
                <div
                    class="pt-6 pb-8 px-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                    <div class="flow-root bg-gray-50 rounded-lg -mt-12 p-4 inline-flex">
                        <div class="bg-blue-500 p-3 rounded-lg shadow-md">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Advanced Analytics</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Gain insights with customizable dashboards and real-time metrics on your QA process.
                    </p>
                    <div class="mt-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            Dashboards
                        </span>
                        <span
                            class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            Metrics
                        </span>
                    </div>
                </div>

                <!-- AI Test Case Generation -->
                <div
                    class="pt-6 pb-8 px-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                    <div class="flow-root bg-gray-50 rounded-lg -mt-12 p-4 inline-flex">
                        <div class="bg-green-500 p-3 rounded-lg shadow-md">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">AI Test Case Generation</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Leverage AI to automatically generate comprehensive test cases based on your requirements.
                    </p>
                    <div class="mt-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                            AI Powered
                        </span>
                        <span
                            class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Smart
                        </span>
                    </div>
                </div>

                <!-- Role-Based Access -->
                <div
                    class="pt-6 pb-8 px-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                    <div class="flow-root bg-gray-50 rounded-lg -mt-12 p-4 inline-flex">
                        <div class="bg-yellow-500 p-3 rounded-lg shadow-md">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Role-Based Access</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Customized interfaces and permissions for all team members and stakeholders.
                    </p>
                    <div class="mt-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            Secure
                        </span>
                        <span
                            class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Customizable
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Solutions For Section -->
    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold tracking-wide text-indigo-600 uppercase">Solutions For</h2>
                <p class="mt-2 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                    Designed for every role in your team
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Tailored experiences that adapt to your specific needs and responsibilities
                </p>
            </div>

            <!-- Role Cards -->
            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- QA Managers -->
                <div
                    class="pt-10 pb-8 px-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 text-center border-t-4 border-indigo-500">
                    <div class="flex justify-center -mt-14">
                        <div class="bg-indigo-100 p-4 rounded-full">
                            <svg class="h-10 w-10 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">QA Managers</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Comprehensive oversight with dashboards, reporting, and team management tools.
                    </p>
                    <div class="mt-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            Analytics
                        </span>
                        <span
                            class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            Control
                        </span>
                    </div>
                </div>

                <!-- Testers -->
                <div
                    class="pt-10 pb-8 px-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 text-center border-t-4 border-purple-500">
                    <div class="flex justify-center -mt-14">
                        <div class="bg-purple-100 p-4 rounded-full">
                            <svg class="h-10 w-10 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Testers</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Intuitive test creation, execution, and defect reporting tools.
                    </p>
                    <div class="mt-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Testing
                        </span>
                        <span
                            class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Automation
                        </span>
                    </div>
                </div>

                <!-- Developers -->
                <div
                    class="pt-10 pb-8 px-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 text-center border-t-4 border-blue-500">
                    <div class="flex justify-center -mt-14">
                        <div class="bg-blue-100 p-4 rounded-full">
                            <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Developers</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Seamless defect tracking and resolution with deep integration.
                    </p>
                    <div class="mt-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Bugs
                        </span>
                        <span
                            class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Fixes
                        </span>
                    </div>
                </div>

                <!-- Clients -->
                <div
                    class="pt-10 pb-8 px-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 text-center border-t-4 border-green-500">
                    <div class="flex justify-center -mt-14">
                        <div class="bg-green-100 p-4 rounded-full">
                            <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Clients</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Transparent progress tracking and simplified reporting.
                    </p>
                    <div class="mt-6">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            Visibility
                        </span>
                        <span
                            class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                            Reports
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    {{-- <div class="py-20 bg-gradient-to-r from-indigo-50 to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-16">
                <h2 class="text-base font-semibold tracking-wide text-indigo-600 uppercase">Trusted by Teams</h2>
                <p class="mt-2 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                    What Our Users Say
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 lg:mx-auto">
                    Join thousands of QA professionals who transformed their workflow
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="relative">
                                <img class="h-14 w-14 rounded-full"
                                    src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah K.">
                                <div class="absolute -bottom-1 -right-1 bg-indigo-500 rounded-full p-1">
                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 4v16l10-8-10-8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-900">Sarah K.</h4>
                            <p class="text-indigo-600">QA Director @TechCorp</p>
                        </div>
                    </div>
                    <div class="relative">
                        <svg class="absolute -top-3 -left-3 h-8 w-8 text-indigo-100" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <p class="relative text-gray-600 pl-8">
                            "The AI test case generation reduced our prep time by 70%. We're now running 3x more tests
                            with the same team."
                        </p>
                    </div>
                    <div class="mt-6 flex items-center">
                        <div class="flex -space-x-2">
                            <img class="h-8 w-8 rounded-full border-2 border-white"
                                src="https://randomuser.me/api/portraits/men/32.jpg" alt="Team member">
                            <img class="h-8 w-8 rounded-full border-2 border-white"
                                src="https://randomuser.me/api/portraits/women/11.jpg" alt="Team member">
                        </div>
                        <span class="ml-3 text-sm text-gray-500">+5 team members using</span>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="relative">
                                <img class="h-14 w-14 rounded-full"
                                    src="https://randomuser.me/api/portraits/men/76.jpg" alt="Michael T.">
                                <div class="absolute -bottom-1 -right-1 bg-purple-500 rounded-full p-1">
                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 4v16l10-8-10-8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-900">Michael T.</h4>
                            <p class="text-purple-600">Dev Lead @FinTech</p>
                        </div>
                    </div>
                    <div class="relative">
                        <svg class="absolute -top-3 -left-3 h-8 w-8 text-purple-100" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <p class="relative text-gray-600 pl-8">
                            "Our defect resolution time dropped from 5 days to 12 hours thanks to the seamless developer
                            integration."
                        </p>
                    </div>
                    <div class="mt-6">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="ml-1 text-sm text-gray-500">4.9/5 - 47 reviews</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="relative">
                                <img class="h-14 w-14 rounded-full"
                                    src="https://randomuser.me/api/portraits/women/65.jpg" alt="Priya M.">
                                <div class="absolute -bottom-1 -right-1 bg-pink-500 rounded-full p-1">
                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 4v16l10-8-10-8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-900">Priya M.</h4>
                            <p class="text-pink-600">CTO @HealthTech</p>
                        </div>
                    </div>
                    <div class="relative">
                        <svg class="absolute -top-3 -left-3 h-8 w-8 text-pink-100" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <p class="relative text-gray-600 pl-8">
                            "The analytics dashboards became our boardroom staple. We make data-driven QA decisions
                            now."
                        </p>
                    </div>
                    <div class="mt-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-8 w-8"
                                    src="https://tailwindui.com/img/logos/workcation-logo-indigo-600.svg"
                                    alt="Workcation">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">Used in <span class="font-bold">3x more
                                        projects</span> after adoption</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Final CTA Section -->
    <div class="relative bg-indigo-900">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-30"
                src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=2850&q=80"
                alt="Team working">
            <div class="absolute inset-0 bg-indigo-900 mix-blend-multiply"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Ready to transform your QA process?
            </h2>
            <p class="mt-6 text-xl text-indigo-100 max-w-3xl mx-auto">
                Join thousands of teams who ship better software faster with our platform.
            </p>
            <div class="mt-10 sm:flex sm:justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="/register"
                    class="flex items-center justify-center px-8 py-3 border border-transparent text-lg font-bold rounded-md text-indigo-700 bg-white hover:bg-indigo-50 md:py-4 md:text-xl md:px-10 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Get Started - Free Forever
                </a>
                <a href="#"
                    class="flex items-center justify-center px-8 py-3 border border-transparent text-lg font-bold rounded-md text-white bg-indigo-600 bg-opacity-60 hover:bg-opacity-80 md:py-4 md:text-xl md:px-10 transition-all duration-300">
                    <svg class="h-6 w-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 15c1.657 0 3-1.343 3-3V6c0-1.657-1.343-3-3-3S9 4.343 9 6v6c0 1.657 1.343 3 3 3z" />
                        <path d="M17 12c0 2.761-2.239 5-5 5s-5-2.239-5-5H5c0 3.866 3.134 7 7 7s7-3.134 7-7h-2z" />
                    </svg>
                    Watch Demo
                </a>
            </div>
            <div class="mt-8 flex items-center justify-center space-x-6">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2 text-sm text-indigo-200">No credit card required</span>
                </div>
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2 text-sm text-indigo-200">Unlimited projects & users</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="p-8">
            <p class="text-base text-gray-400 text-center">
                &copy; 2025 QA Ignite. All rights reserved.
            </p>
        </div>
    </footer>
</body>

</html>
