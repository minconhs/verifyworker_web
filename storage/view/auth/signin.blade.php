<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Verify Worker - Sign In</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="min-h-screen flex">
    <div class="hidden lg:flex lg:w-2/5 bg-linear-to-br from-cyan-500 to-cyan-600 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
        </div>

        <div class="relative z-10 flex flex-col justify-center w-full max-w-lg mx-auto px-10 py-16 text-white">

            <div class="mb-14">
                <h1 class="text-5xl font-medium mb-5">Welcome Back</h1>
                <p class="text-xl text-blue-100 leading-relaxed">
                    Sign in to continue enjoying professional, fast, and secure CAPTCHA recognition services
                </p>
            </div>

            <div class="space-y-5 mb-12">
                <div class="flex items-center gap-5 p-5 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
                    <div class="w-14 h-14 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-lg">Fast Response</h3>
                        <p class="text-base text-blue-100">Average time &lt; 3 seconds</p>
                    </div>
                </div>

                <div class="flex items-center gap-5 p-5 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
                    <div class="w-14 h-14 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                <path d="m9 12l2 2l4-4" />
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-lg">Secure</h3>
                        <p class="text-base text-blue-100">Enterprise-level encryption</p>
                    </div>
                </div>

                <div class="flex items-center gap-5 p-5 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
                    <div class="w-14 h-14 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M16 7h6v6" />
                                <path d="m22 7l-8.5 8.5l-5-5L2 17" />
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-lg">High Accuracy</h3>
                        <p class="text-base text-blue-100">Accuracy &gt; 95%</p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6 p-8 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20">
                <div class="text-center">
                    <div class="text-3xl font-medium text-white">1M+</div>
                    <div class="text-sm text-blue-100">Daily</div>
                </div>
                <div class="text-center border-x border-white/20">
                    <div class="text-3xl font-medium text-white">500+</div>
                    <div class="text-sm text-blue-100">Workers</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-medium text-white">24/7</div>
                    <div class="text-sm text-blue-100">Service</div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full lg:w-3/5 flex items-center justify-center px-4 py-12 bg-white">
        <div class="w-full max-w-md">

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-medium text-gray-900">Sign In</h1>
                <p class="mt-2 text-gray-500">Sign in to your account to continue</p>
            </div>

            <form method="post" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="username">Email or Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                <g fill="none" stroke="#9ca3af" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <circle cx="12" cy="8" r="5" />
                                    <path d="M20 21a8 8 0 0 0-16 0" />
                                </g>
                            </svg>
                        </div>
                        <label for="username"></label>
                        <input type="text" id="username" name="username" placeholder="Enter your email or username" value="{{ $old['username'] ?? '' }}" required class="w-full pl-10 pr-4 py-4 bg-white border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all sm:text-sm">
                    </div>
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between gap-4">
                        <label class="text-sm font-medium text-gray-700" for="password">Password</label>
                        <a href="/forgot" class="text-sm font-medium text-gray-500 transition-colors hover:text-cyan-700">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                <g fill="none" stroke="#9ca3af" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </g>
                            </svg>
                        </div>
                        <label for="password"></label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" value="{{ $old['password'] ?? '' }}" required class="w-full pl-10 pr-4 py-4 bg-white border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all sm:text-sm">
                    </div>
                </div>

                @if($error)
                    @include('components.wrong', ['message' => $error, 'margin' => true])
                @endif

                @if($success)
                    @include('components.success', ['message' => $success, 'margin' => true])
                @endif

                <button type="submit" class="w-full px-6 py-4 bg-cyan-500 text-white font-medium rounded-lg hover:bg-cyan-600 focus:outline-none focus:ring-4 focus:ring-cyan-500/30 transition-all duration-200" >
                    Sign In
                </button>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">Or continue with</span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <a class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-200 bg-white rounded-lg hover:bg-gray-50 transition-all duration-200" href="/auth/google">
                    <svg height="1.2em" viewBox="0 0 128 128" width="1.2em" xmlns="http://www.w3.org/2000/svg"><path d="M44.59 4.21a63.28 63.28 0 0 0 4.33 120.9a67.6 67.6 0 0 0 32.36.35a57.13 57.13 0 0 0 25.9-13.46a57.44 57.44 0 0 0 16-26.26a74.3 74.3 0 0 0 1.61-33.58H65.27v24.69h34.47a29.72 29.72 0 0 1-12.66 19.52a36.2 36.2 0 0 1-13.93 5.5a41.3 41.3 0 0 1-15.1 0A37.2 37.2 0 0 1 44 95.74a39.3 39.3 0 0 1-14.5-19.42a38.3 38.3 0 0 1 0-24.63a39.25 39.25 0 0 1 9.18-14.91A37.17 37.17 0 0 1 76.13 27a34.3 34.3 0 0 1 13.64 8q5.83-5.8 11.64-11.63c2-2.09 4.18-4.08 6.15-6.22A61.2 61.2 0 0 0 87.2 4.59a64 64 0 0 0-42.61-.38" fill="#fff"/><path d="M44.59 4.21a64 64 0 0 1 42.61.37a61.2 61.2 0 0 1 20.35 12.62c-2 2.14-4.11 4.14-6.15 6.22Q95.58 29.23 89.77 35a34.3 34.3 0 0 0-13.64-8a37.17 37.17 0 0 0-37.46 9.74a39.25 39.25 0 0 0-9.18 14.91L8.76 35.6A63.53 63.53 0 0 1 44.59 4.21" fill="#e33629"/><path d="M3.26 51.5a63 63 0 0 1 5.5-15.9l20.73 16.09a38.3 38.3 0 0 0 0 24.63q-10.36 8-20.73 16.08a63.33 63.33 0 0 1-5.5-40.9" fill="#f8bd00"/><path d="M65.27 52.15h59.52a74.3 74.3 0 0 1-1.61 33.58a57.44 57.44 0 0 1-16 26.26c-6.69-5.22-13.41-10.4-20.1-15.62a29.72 29.72 0 0 0 12.66-19.54H65.27c-.01-8.22 0-16.45 0-24.68" fill="#587dbd"/><path d="M8.75 92.4q10.37-8 20.73-16.08A39.3 39.3 0 0 0 44 95.74a37.2 37.2 0 0 0 14.08 6.08a41.3 41.3 0 0 0 15.1 0a36.2 36.2 0 0 0 13.93-5.5c6.69 5.22 13.41 10.4 20.1 15.62a57.13 57.13 0 0 1-25.9 13.47a67.6 67.6 0 0 1-32.36-.35a63 63 0 0 1-23-11.59A63.7 63.7 0 0 1 8.75 92.4" fill="#319f43"/></svg>
                    <span class="text-sm font-medium text-gray-700">Google</span>
                </a>
            </div>

            <p class="mt-8 text-center text-sm text-gray-500">
                Don't have an account?
                <a class="font-medium text-gray-500 hover:text-cyan-700 transition-colors" href="/auth/signup">Sign up for free</a>
            </p>
        </div>
    </div>
</div>
<!-- Back Button -->
<a class="fixed top-6 left-6 z-50 flex items-center justify-center w-12 h-12 bg-white/90 backdrop-blur-sm border border-gray-200 rounded-full hover:bg-gray-50 hover:scale-105 transition-all shadow-sm" href="/">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
        <path fill="none" stroke="#9ca3af" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18l-6-6l6-6" />
    </svg>
</a>
</body>
</html>
