<header class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="shrink-0">
                <a href="/">
                    <div class="flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 512 512"><path fill="#06b6d4" d="M256.156 22.125L60.28 82.438c.432 108.262 10.918 200.47 40.25 270.437c13.326 31.78 30.345 59.02 52.126 81.47c4.056-11.198 8.352-22.57 12.813-34.064c-16.453-18.292-29.438-40.056-39.345-64.75c-23.25-57.95-30.656-131.856-30.656-217.717l-.095-7.188l6.563-1.72L246.313 62.47a2236 2236 0 0 1 18.125-37.814zm52.656 16.188l-17.875 33.124l23.313 7.5c5.9-11.474 11.73-22.754 17.375-33.593zM376.5 59.156c-6.004 11.338-12.02 22.668-18.03 34l25.25 8.125a2525 2525 0 0 1 20.186-33.686zm71.156 21.907l-33.844 51.5c-.736 79.713-7.717 148.21-29.25 202.687c-22.848 57.806-63.124 99.61-127.312 118.625l-2.656.813l-2.656-.813c-32.193-9.537-58.434-25.294-79.5-46.25a1391 1391 0 0 1-19.625 26.844c26.645 27.41 60.394 47.68 103.28 60.25c80.56-23.573 128.42-71.69 157.5-142.095c28.78-69.676 38.15-161.577 38.532-270.188l-4.47-1.374zm-212 4.437L114.25 124.563c.405 81.79 8.107 151.38 29.22 204a250 250 0 0 0 1.374 3.375c24.524-86.216 54.174-165.683 90.812-246.438m46.25 2.625L147.25 337.5c7.214 16.193 15.74 30.653 25.875 43.344c38.187-95.228 87.792-197.513 132.5-285.094l-23.72-7.625zm67.688 21.78C297.91 207.07 245.08 303.326 183.22 392.346c18.644 19.297 42.002 33.62 71.374 42.75c57.576-17.84 91.637-53.702 112.594-106.72c17.472-44.204 25.07-100.542 27.25-166.344L235.594 403.845c36.84-95.574 83.337-190.838 138.47-286.063l-24.47-7.874z"/></svg>
                        <span class="ml-1 text-xl font-bold">Verify Worker</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-700 hover:text-cyan-600 transition-colors font-medium">Home</a>
                <a href="/pricing" class="text-gray-700 hover:text-cyan-600 transition-colors font-medium">Pricing</a>
                <a href="/docs" class="text-gray-700 hover:text-cyan-600 transition-colors font-medium">Docs</a>
                <a href="/help" class="text-gray-700 hover:text-cyan-600 transition-colors font-medium">Help</a>
            </div>
            <!-- User Section -->
            @isset($member)
                <div class="hidden md:flex items-center">
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <div class="flex items-center gap-3 px-4 py-2 transition-all cursor-pointer">
                            <div class="flex flex-col items-start">
                                <span class="text-gray-900 font-medium text-sm">
                                    {{ $member->username }}
                                </span>
                                <span class="text-gray-400 text-xs">{{ $member->email }}</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 transition-transform group-hover:rotate-180 duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-0 pt-3 w-72 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="bg-white shadow-2xl shadow-black/10 rounded-lg border border-gray-200/80 overflow-hidden transform scale-95 group-hover:scale-100 transition-transform duration-200 origin-top-right backdrop-blur-xl">
                                <!-- User Info Header -->
                                <div class="px-4 py-4 bg-gray-50/80 border-b border-gray-100">
                                    <div class="flex items-center gap-3">

                                        <div class="flex-1">
                                            <div class="text-gray-800 font-bold">{{ isset($profile) && $profile->nickname ? $profile->nickname : $member->username }}</div>
                                            <div class="text-gray-400 text-sm">{{ $member->email }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menu Items -->
                                <div class="p-2">
                                    <a href="/console" class="group/item flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-all duration-200">
                                        <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                                            <svg class="w-5 h-5 text-gray-400 group-hover/item:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M8.4 3H5.6A1.6 1.6 0 0 0 4 4.6v4.8A1.6 1.6 0 0 0 5.6 11h2.8A1.6 1.6 0 0 0 10 9.4V4.6A1.6 1.6 0 0 0 8.4 3Zm0 12H5.6A1.6 1.6 0 0 0 4 16.6v2.8A1.6 1.6 0 0 0 5.6 21h2.8a1.6 1.6 0 0 0 1.6-1.6v-2.8A1.6 1.6 0 0 0 8.4 15Zm10-12h-2.8A1.6 1.6 0 0 0 14 4.6v2.8A1.6 1.6 0 0 0 15.6 9h2.8A1.6 1.6 0 0 0 20 7.4V4.6A1.6 1.6 0 0 0 18.4 3Zm0 10h-2.8a1.6 1.6 0 0 0-1.6 1.6v4.8a1.6 1.6 0 0 0 1.6 1.6h2.8a1.6 1.6 0 0 0 1.6-1.6v-4.8a1.6 1.6 0 0 0-1.6-1.6Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-gray-700 font-semibold text-sm">Console</div>
                                            <div class="text-gray-400 text-xs">Overview & analytics</div>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-300 group-hover/item:translate-x-1 group-hover/item:text-gray-400 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>

                                    <a href="/profile" class="group/item flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-all duration-200">
                                        <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                                            <svg class="w-5 h-5 text-gray-400 group-hover/item:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linejoin="round" d="M4 18a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z" />
                                                    <circle cx="12" cy="7" r="3" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-gray-700 font-semibold text-sm">Profile</div>
                                            <div class="text-gray-400 text-xs">Account settings</div>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-300 group-hover/item:translate-x-1 group-hover/item:text-gray-400 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>

                                    <a href="/wallet" class="group/item flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-all duration-200">
                                        <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                                            <svg class="w-5 h-5 text-gray-400 group-hover/item:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <path d="M19 20H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2Z" />
                                                    <path fill="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M16.5 14a.5.5 0 1 1 0-1a.5.5 0 0 1 0 1" />
                                                    <path d="M18 7V5.603a2 2 0 0 0-2.515-1.932l-11 2.933A2 2 0 0 0 3 8.537V9" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-gray-700 font-semibold text-sm">Wallet</div>
                                            <div class="text-gray-400 text-xs">Plans & payments</div>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-300 group-hover/item:translate-x-1 group-hover/item:text-gray-400 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>

                                    <a href="/settings" class="group/item flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-all duration-200">
                                        <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                                            <svg class="w-5 h-5 text-gray-400 group-hover/item:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-gray-700 font-semibold text-sm">Settings</div>
                                            <div class="text-gray-400 text-xs">Preferences</div>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-300 group-hover/item:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>

                                <!-- Logout -->
                                <div class="p-2 border-t border-gray-100 bg-gray-50/50">
                                    <a href="/member/signout" class="group/item flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 transition-all duration-200">
                                        <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm group-hover/item:bg-red-50 group-hover/item:border-red-200">
                                            <svg class="w-5 h-5 text-gray-400 group-hover/item:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-gray-600 font-semibold text-sm group-hover/item:text-red-500 transition-colors">Sign Out</div>
                                            <div class="text-gray-400 text-xs">Logout from account</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
            @empty($member)
                <div class="hidden md:flex items-center gap-3">
                    <a href="/auth/signup" class="px-4 py-1.5 bg-cyan-500 text-white text-sm rounded hover:bg-cyan-600 font-medium transition-colors">Sign Up</a>
                    <a href="/auth/signin" class="px-4 py-1.5 text-gray-700 text-sm rounded border border-gray-200 hover:text-cyan-600 font-medium transition-colors">Sign In</a>
                </div>
            @endempty


            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-200 mt-2">
            <div class="pt-4 space-y-1">
                <a href="/" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-cyan-600 font-medium">Home</a>
                <a href="/pricing" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-cyan-600 font-medium">Pricing</a>
                <a href="/docs" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-cyan-600 font-medium">Docs</a>
                <a href="/help" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-cyan-600 font-medium">Help</a>

                @isset($member)
                    <!-- Mobile User Menu -->
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <div class="px-3 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $member->username }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $member->email }}</p>
                                </div>
                            </div>
                        </div>
                        <a href="/console" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-cyan-600">
                            <svg class="w-5 h-5 text-gray-400 group-hover/item:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M8.4 3H5.6A1.6 1.6 0 0 0 4 4.6v4.8A1.6 1.6 0 0 0 5.6 11h2.8A1.6 1.6 0 0 0 10 9.4V4.6A1.6 1.6 0 0 0 8.4 3Zm0 12H5.6A1.6 1.6 0 0 0 4 16.6v2.8A1.6 1.6 0 0 0 5.6 21h2.8a1.6 1.6 0 0 0 1.6-1.6v-2.8A1.6 1.6 0 0 0 8.4 15Zm10-12h-2.8A1.6 1.6 0 0 0 14 4.6v2.8A1.6 1.6 0 0 0 15.6 9h2.8A1.6 1.6 0 0 0 20 7.4V4.6A1.6 1.6 0 0 0 18.4 3Zm0 10h-2.8a1.6 1.6 0 0 0-1.6 1.6v4.8a1.6 1.6 0 0 0 1.6 1.6h2.8a1.6 1.6 0 0 0 1.6-1.6v-4.8a1.6 1.6 0 0 0-1.6-1.6Z" />
                            </svg>
                            <span class="text-sm font-medium">Console</span>
                        </a>
                        <a href="/profile" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-cyan-600">
                            <svg class="w-5 h-5 text-gray-400 group-hover/item:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linejoin="round" d="M4 18a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z" />
                                    <circle cx="12" cy="7" r="3" />
                                </g>
                            </svg>
                            <span class="text-sm font-medium">Profile</span>
                        </a>

                        <a href="/wallet" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-cyan-600">
                            <svg class="w-5 h-5 text-gray-400 group-hover/item:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M19 20H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2Z" />
                                    <path fill="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M16.5 14a.5.5 0 1 1 0-1a.5.5 0 0 1 0 1" />
                                    <path d="M18 7V5.603a2 2 0 0 0-2.515-1.932l-11 2.933A2 2 0 0 0 3 8.537V9" />
                                </g>
                            </svg>
                            <span class="text-sm font-medium">Wallet</span>
                        </a>

                        <a href="/settings" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-cyan-600">
                            <svg class="w-5 h-5 text-gray-400 group-hover/item:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-sm font-medium">Settings</span>
                        </a>
                        <a href="/member/signout" class="flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 mt-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="text-sm font-medium">Sign Out</span>
                        </a>
                    </div>
                @endisset
                @empty($member)
                    <div class="pt-4 mt-4 border-t border-gray-200 space-y-2">
                        <a href="/auth/signup" class="block px-3 py-2 text-center bg-cyan-500 text-white rounded hover:bg-cyan-600 font-medium">
                            Sign Up
                        </a>
                        <a href="/auth/signin" class="block px-3 py-2 text-center border border-gray-300 rounded text-gray-700 hover:bg-gray-50 hover:text-cyan-600 font-medium">
                            Sign In
                        </a>
                    </div>
                @endempty
            </div>
        </div>
    </nav>
</header>