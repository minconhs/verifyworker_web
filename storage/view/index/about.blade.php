@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <div class="relative bg-slate-900 text-white overflow-hidden">
        <div class="absolute inset-0 bg-[url('/static/images/grid.svg')] opacity-10"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-cyan-500/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-500/20 blur-3xl"></div>

        <div class="relative container mx-auto px-4 py-24 lg:py-32 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/80 border border-slate-700 text-cyan-400 text-xs font-medium tracking-wider uppercase mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                Human Intelligence Layer
            </div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-medium mb-8 tracking-tight leading-tight bg-clip-text text-transparent bg-gradient-to-b from-white to-slate-400">
                Precision Driven by <br class="hidden md:block" /> Real People.
            </h1>
            <p class="text-lg md:text-xl text-slate-400 max-w-3xl mx-auto leading-relaxed font-light">
                We provide specialized manual recognition services tailored for complex scenarios. <br class="hidden lg:block">When automation reaches its limit, our dedicated workforce steps in.
            </p>
        </div>
    </div>

    <div class="bg-white py-20 lg:py-28">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-24">
                <div class="w-full lg:w-1/2">
                    <h2 class="text-3xl lg:text-4xl font-medium text-slate-900 mb-8 leading-tight">
                        Bridging the gap between <br>
                        <span class="text-cyan-600">Technology</span> and <span class="text-cyan-600">Nuance</span>.
                    </h2>
                    <div class="space-y-6 text-slate-600 text-lg leading-relaxed font-light">
                        <p>
                            In a digital world dominated by algorithms, we understand that technology isn't always perfect. There are subtle nuances that simply require a human touch.
                        </p>
                        <p>
                            We are a team focused on providing high-quality manual verification services. We do not claim to replace automation entirely, but to support it where it falters. Our goal is to handle the edge cases and complexities that scripts often struggle with, aiming for the highest possible success rates in the industry.
                        </p>
                    </div>
                </div>

                <div class="w-full lg:w-1/2">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-1 space-y-6 pt-12">
                            <div class="bg-slate-50 p-8 rounded-2xl shadow-sm border border-slate-100 hover:border-cyan-100 transition-colors duration-300">
                                <div class="text-4xl font-medium text-slate-900 mb-2">24/7</div>
                                <div class="text-sm font-medium text-slate-500 uppercase tracking-wide">Availability</div>
                            </div>
                            <div class="bg-slate-50 p-8 rounded-2xl shadow-sm border border-slate-100 hover:border-cyan-100 transition-colors duration-300">
                                <div class="text-4xl font-medium text-cyan-600 mb-2">Global</div>
                                <div class="text-sm font-medium text-slate-500 uppercase tracking-wide">Workforce</div>
                            </div>
                        </div>
                        <div class="col-span-1 space-y-6">
                            <div class="bg-cyan-600 p-8 rounded-2xl shadow-lg text-white transform -rotate-1 hover:rotate-0 transition-transform duration-300">
                                <div class="text-4xl font-medium text-white mb-2">95%+</div>
                                <div class="text-sm font-medium text-cyan-100 uppercase tracking-wide">Target Accuracy</div>
                                <p class="mt-4 text-xs text-cyan-100/80 leading-relaxed border-t border-cyan-500 pt-4">We strive for perfection in every manual interaction.</p>
                            </div>
                            <div class="bg-slate-50 p-8 rounded-2xl shadow-sm border border-slate-100 hover:border-cyan-100 transition-colors duration-300">
                                <div class="text-4xl font-medium text-slate-900 mb-2">Secure</div>
                                <div class="text-sm font-medium text-slate-500 uppercase tracking-wide">Protocols</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 py-24 border-y border-slate-200">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                <!-- Mission -->
                <div class="bg-white p-10 lg:p-12 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 bg-cyan-50 rounded-xl flex items-center justify-center text-cyan-600 mb-8 group-hover:bg-cyan-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-medium text-slate-900 mb-4">Our Mission</h3>
                    <p class="text-slate-600 leading-relaxed">
                        To serve as a reliable backup layer for your business logic. We strive to clear the hurdles that block legitimate access, ensuring your data workflows remain uninterrupted even when automated methods falter.
                    </p>
                </div>

                <div class="bg-white p-10 lg:p-12 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-medium text-slate-900 mb-4">Our Vision</h3>
                    <p class="text-slate-600 leading-relaxed">
                        We envision a seamless integration of human expertise and digital infrastructure. Our aim is to set a standard for quality in manual services, proving that efficiency and human care can coexist.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white py-24">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="text-center mb-20">
                <h2 class="text-3xl font-medium text-slate-900">Core Values</h2>
                <div class="w-16 h-1 bg-cyan-500 mx-auto mt-6 rounded-full"></div>
                <p class="text-slate-500 mt-6 text-lg">The principles that guide our every operation</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center md:text-left">
                    <span class="block text-6xl font-medium text-slate-100 mb-6">01</span>
                    <h4 class="text-xl font-medium text-slate-900 mb-4">Quality First</h4>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        Perfection is difficult, but we don't settle for "good enough". We implement rigorous training for our staff and regular quality checks to maintain a high standard.
                    </p>
                </div>

                <div class="text-center md:text-left">
                    <span class="block text-6xl font-medium text-slate-100 mb-6">02</span>
                    <h4 class="text-xl font-medium text-slate-900 mb-4">Privacy Centric</h4>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        We respect your data. Our systems are designed to process requests with minimal exposure. We do not store sensitive information longer than necessary.
                    </p>
                </div>

                <div class="text-center md:text-left">
                    <span class="block text-6xl font-medium text-slate-100 mb-6">03</span>
                    <h4 class="text-xl font-medium text-slate-900 mb-4">Reliability</h4>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        We understand that your business relies on uptime. We maintain redundant systems and shift-based workforce management to ensure we are always online.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection