<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Verify Worker - Sign Up</title>
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
                    <h1 class="text-5xl font-medium mb-5">Join Us Today</h1>
                    <p class="text-xl text-blue-100 leading-relaxed">
                        Create an account to start using our professional CAPTCHA recognition services
                    </p>
                </div>

                <!-- Features -->
                <div class="space-y-5 mb-12">
                    <div class="flex items-center gap-5 p-5 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
                        <div class="w-14 h-14 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M2 21a8 8 0 0 1 13.292-6" />
                                    <circle cx="10" cy="8" r="5" />
                                    <path d="M19 16v6m3-3h-6" />
                                </g>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-lg">Easy Registration</h3>
                            <p class="text-base text-blue-100">Quick sign up in minutes</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-5 p-5 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
                        <div class="w-14 h-14 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M12 7v14m8-10v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8m3.5-4a1 1 0 0 1 0-5A4.8 8 0 0 1 12 7a4.8 8 0 0 1 4.5-5a1 1 0 0 1 0 5" />
                                    <rect width="18" height="4" x="3" y="7" rx="1" />
                                </g>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-lg">Free Trial</h3>
                            <p class="text-base text-blue-100">Get free credits to start</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-5 p-5 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
                        <div class="w-14 h-14 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-lg">24/7 Support</h3>
                            <p class="text-base text-blue-100">Always here to help</p>
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

        <!-- Right Section - Register Form -->
        <div class="w-full lg:w-3/5 flex items-center justify-center px-4 py-12 bg-white" id="app">
            <div class="w-full max-w-lg">
                <!-- Header -->
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-medium text-gray-900">Sign Up</h1>
                    <p class="mt-2 text-gray-500">Fill in the details below to get started</p>
                </div>

                <!-- Form Card -->
                <form method="post" class="space-y-6">

                    <!-- Username -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Username</label>
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
                            <input type="text" name="username" placeholder="Enter your username" value="{{ $old['username'] ?? '' }}" required class="w-full pl-10 pr-4 py-4 bg-white border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all sm:text-sm">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Email</label>
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
                            <input type="email" name="email" placeholder="Enter your email" value="{{ $old['email'] ?? '' }}"  required class="w-full pl-10 pr-4 py-4 bg-white border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all sm:text-sm">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password</label>
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
                            <input type="password" name="password" placeholder="Enter your password" required class="w-full pl-10 pr-4 py-4 bg-white border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all sm:text-sm">
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="password_confirmation">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                    <g fill="none" stroke="#9ca3af" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </g>
                                </svg>
                            </div>
                            <label for="password_confirmation"></label>
                            <input type="password" name="password_confirmation" placeholder="Confirm your password" required class="w-full pl-10 pr-4 py-4 bg-white border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all sm:text-sm">
                        </div>
                    </div>

                    <!-- Referral -->
                    @if($referral)
                        <input type="hidden" name="referral" value="{{ $referral }}">
                    @else
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="invite_code">Invite Code</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <rect width="24" height="24" fill="none"/>
                                        <path fill="none" stroke="#9ca3af" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 8v8m0-8a2 2 0 1 0 0-4a2 2 0 0 0 0 4m0 8a2 2 0 1 0 0 4a2 2 0 0 0 0-4m6-2a2 2 0 1 1 4 0a2 2 0 0 1-4 0m0 0h-1a5 5 0 0 1-5-5v-.5"/>
                                    </svg>
                                </div>
                                <label for="referral"></label>
                                <input type="text" name="referral" placeholder="Enter invite code (optional)" value="{{ $old['referral'] ?? '' }}" class="w-full pl-10 pr-4 py-4 bg-white border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all sm:text-sm">
                            </div>
                        </div>
                    @endif

                    <!-- Terms -->
                    <div class="flex items-start gap-3 py-2">
                        <div class="relative flex items-center justify-center w-5 h-5 shrink-0">
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                            <span class="relative flex items-center justify-center w-4 h-4">
                                <input type="checkbox" required name="terms" class="peer appearance-none w-4 h-4 border border-gray-300 rounded checked:bg-cyan-500 checked:border-cyan-500 focus:outline-none">
                                <svg viewBox="0 0 14 14" class="absolute w-4 h-4 text-white invisible peer-checked:visible" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8L6 11L11 3.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            </label>
                        </div>
                        <label class="text-sm text-gray-500 cursor-pointer" for="terms">
                            I agree to the <a class="text-cyan-600 hover:text-cyan-700 underline" href="/terms">Terms of
                                Service</a>
                            and <a class="text-cyan-600 hover:text-cyan-700 underline" href="/privacy">Privacy Policy</a>
                        </label>
                    </div>

                    @if($error)
                        @include('components.wrong', ['message' => $error, 'margin' => true])
                    @endif

                    @if($success)
                        @include('components.success', ['message' => $success, 'margin' => true])
                    @endif

                    <!-- Register Button -->
                    <button class="w-full px-6 py-4 bg-cyan-500 text-white font-medium rounded-lg hover:bg-cyan-600 focus:outline-none focus:ring-4 focus:ring-cyan-500/30 transition-all duration-200" type="submit">
                        Complete Registration
                    </button>
                </form>

                <!-- Footer -->
                <p class="mt-8 text-center text-sm text-gray-500">
                    Already have an account?
                    <a class="font-medium text-gray-500 hover:text-cyan-700 transition-colors" href="/auth/signin">Sign in</a>
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
