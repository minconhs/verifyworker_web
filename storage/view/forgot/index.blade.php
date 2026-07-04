<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Verify Worker -Forgot password</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="min-h-screen flex">
        <!-- Left Section - Brand -->
        <div class="hidden lg:flex lg:w-2/5 bg-linear-to-br from-cyan-500 to-cyan-600 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
            </div>

            <!-- Brand Content -->
            <div class="relative z-10 flex flex-col justify-center w-full max-w-lg mx-auto px-10 py-16 text-white">
                <!-- Logo & Brand -->
                <div class="mb-14">
                    <h1 class="text-5xl font-medium mb-5">Forget Password</h1>
                    <p class="text-xl text-blue-100 leading-relaxed">
                        Recover your account and continue enjoying professional, fast, and secure CAPTCHA recognition services
                    </p>
                </div>

                <!-- Features -->
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

        <!-- Right Section - Login Form -->
        <div class="w-full lg:w-3/5 flex items-center justify-center px-4 py-12 bg-white">
            <div class="w-full max-w-md">
                <!-- Header -->
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-medium text-gray-900">Forget Password</h1>
                    <p class="mt-2 text-sm text-gray-500">Enter your user account's verified email address and we will send you a password reset link.</p>
                </div>

                <!-- Form Card -->
                <form method="post" class="space-y-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                    <g fill="none" stroke="#9ca3af" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="m22 7l-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                        <rect width="20" height="16" x="2" y="4" rx="2" />
                                    </g>
                                </svg>
                            </div>
                            <label for="email"></label>
                            <input type="text" name="email" placeholder="Enter your email" value="{{ $old['email'] ?? '' }}" required class="block w-full pl-10 pr-10 py-4 bg-white border border-gray-200 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all sm:text-sm">
                        </div>
                    </div>

                    @if($error)
                        @include('components.wrong', ['message' => $error, 'margin' => true])
                    @endif

                    @if($success)
                        @include('components.success', ['message' => $success, 'margin' => true])
                    @endif

                    <!-- Login Button -->
                    <button type="submit" class="w-full px-4 py-4 bg-cyan-500 text-white font-medium rounded-lg hover:bg-cyan-600 focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all duration-200">
                        Send password reset email
                    </button>
                </form>

                <!-- Footer -->
                <p class="mt-8 text-center text-sm text-gray-500">
                    Already have an account?
                    <a href="/auth/signin" class="font-medium text-gray-500 hover:text-cyan-700 transition-colors">Sign in</a>
                </p>
            </div>
        </div>
    </div>
    <a class="fixed top-6 left-6 z-50 flex items-center justify-center w-12 h-12 bg-white/90 backdrop-blur-sm border border-gray-200 rounded-full hover:bg-gray-50 hover:scale-105 transition-all shadow-sm" href="/auth/signin">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
            <path fill="none" stroke="#9ca3af" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18l-6-6l6-6" />
        </svg>
    </a>
</body>
</html>