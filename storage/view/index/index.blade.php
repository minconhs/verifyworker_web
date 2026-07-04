@extends('layouts.app')

@section('title', 'Captcha Solving API')

@section('content')
    <div class="bg-white text-slate-950">
        <section class="border-b border-slate-200">
            <div class="container mx-auto px-4 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-24">
                <div class="text-center">
                    <p class="text-sm font-semibold uppercase tracking-wide text-cyan-600">Verify Worker API</p>

                    <h1 class="mt-5 text-4xl font-semibold leading-tight tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                        Solve CAPTCHAs with a simple API
                    </h1>

                    <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                        Submit a challenge, receive an order number, then get the result by callback or query endpoint. Built for image captchas, click tasks, Turnstile, reCAPTCHA, GeeTest, and more.
                    </p>

                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                        @isset($member)
                            <a href="/console" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                Open Console
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/>
                                </svg>
                            </a>
                        @else
                            <a href="/auth/signup" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                Create Account
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/>
                                </svg>
                            </a>
                        @endisset
                        <a href="/docs" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition-colors duration-200 hover:border-cyan-500 hover:text-cyan-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                            Read Docs
                        </a>
                    </div>

                    <div class="mt-12 rounded-xl border border-slate-200 bg-slate-950 p-5 text-left">
                        <div class="flex items-center justify-between border-b border-white/10 pb-3">
                            <span class="text-sm font-medium text-white">POST /api/solve/image_text</span>
                            <span class="rounded-md bg-emerald-400/10 px-2 py-1 text-xs font-medium text-emerald-300">JSON</span>
                        </div>
                        <pre class="mt-4 overflow-x-auto text-xs leading-6 text-slate-300"><code>curl -X POST \
  -H "Authorization: Bearer API_KEY" \
  -d "image=base64..." \
  /api/solve/image_text</code></pre>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-white py-8">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <dl class="grid gap-4 text-center sm:grid-cols-3">
                    @foreach ([
                        ['95%+', 'solve accuracy'],
                        ['3-8s', 'image text average'],
                        ['$0.50', 'from per 1K solves'],
                    ] as [$value, $label])
                        <div class="rounded-lg border border-slate-200 bg-white px-5 py-4">
                            <dt class="text-sm font-medium text-slate-500">{{ $label }}</dt>
                            <dd class="mt-1 text-3xl font-semibold tracking-tight text-slate-950">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-slate-50 py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ([
                        ['Fast integration', 'One REST API, bearer auth, JSON responses, and documented parameters.'],
                        ['Human accuracy', 'Workers handle ambiguous visual challenges that pure automation often misses.'],
                        ['Clear operations', 'Track balance, task records, solve status, and callbacks from the console.'],
                    ] as [$title, $copy])
                        <div class="rounded-lg border border-slate-200 bg-white p-6">
                            <div class="mb-4 flex h-9 w-9 items-center justify-center rounded-lg bg-cyan-50 text-cyan-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-slate-950">{{ $title }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-white py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[0.82fr_1.18fr] lg:items-start">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-cyan-600">For Customers</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Send a task, let workers solve it, receive the answer</h2>
                        <p class="mt-4 text-base leading-7 text-slate-600">
                            Customers use the API to submit captcha challenges. Verify Worker handles task dispatch, worker processing, status tracking, and result delivery.
                        </p>

                        <div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-cyan-50 text-cyan-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9h8m-8 4h6m-8 8h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-slate-950">Built for API users</h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-600">Use order numbers, callbacks, query endpoints, and console records to keep every captcha task traceable.</p>
                                </div>
                            </div>
                        </div>

                        <a href="/docs" class="mt-6 inline-flex cursor-pointer items-center text-sm font-semibold text-cyan-700 transition-colors duration-200 hover:text-cyan-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                            Read integration docs
                            <svg class="ml-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ([
                            ['01', 'Choose task type', 'Select the endpoint for image text, click tasks, Turnstile, reCAPTCHA, GeeTest, or another supported challenge.'],
                            ['02', 'Submit request', 'Send the challenge data with your API key. The system returns an order number for tracking.'],
                            ['03', 'Worker processing', 'The task enters the worker queue and is handled by available workers with the right task instructions.'],
                            ['04', 'Receive result', 'Get the solved answer through callback delivery or query the order status until completion.'],
                        ] as [$step, $title, $copy])
                            <div class="rounded-lg border border-slate-200 bg-white p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-950 text-xs font-semibold text-white">{{ $step }}</div>
                                    <div class="h-px flex-1 bg-slate-200"></div>
                                </div>
                                <h3 class="mt-5 text-lg font-semibold text-slate-950">{{ $title }}</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-slate-50 py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-cyan-600">For Workers</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Earn money by solving captcha tasks</h2>
                        <p class="mt-4 text-base leading-7 text-slate-600">
                            Verify Worker is not only an API platform for developers. Workers can join the task pool, complete available captcha jobs, and receive earnings based on completed work.
                        </p>

                        <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                            @isset($member)
                                <a href="/task/worker" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-slate-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                    Start Working
                                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/>
                                    </svg>
                                </a>
                            @else
                                <a href="/auth/signup" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-slate-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                    Become a Worker
                                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/>
                                    </svg>
                                </a>
                            @endisset
                            @isset($member)
                                <a href="/wallet" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition-colors duration-200 hover:border-cyan-500 hover:text-cyan-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                    View Wallet
                                </a>
                            @else
                                <a href="/auth/signin" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition-colors duration-200 hover:border-cyan-500 hover:text-cyan-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                    Sign In
                                </a>
                            @endisset
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                        @foreach ([
                            ['Claim available tasks', 'Open the worker workspace and receive captcha jobs when tasks are available.', 'M4 7h16M4 12h10M4 17h16'],
                            ['Submit accurate answers', 'Complete tasks within the time limit. Successful results count toward your worker record.', 'm5 13 4 4L19 7'],
                            ['Track earnings', 'Completed work is credited to your task balance, where you can review income and wallet activity.', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 9v1m9-5a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                        ] as [$title, $copy, $icon])
                            <div class="rounded-lg border border-slate-200 bg-white p-5">
                                <div class="flex gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-950">{{ $title }}</h3>
                                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-white py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div>
                    <div class="grid gap-6 lg:grid-cols-[0.85fr_1.15fr] lg:items-center">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-cyan-600">Coverage</p>
                            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Common challenge types</h2>
                            <p class="mt-4 text-base leading-7 text-slate-600">
                                Start with the task type you need now. The full API reference has request fields and result examples.
                            </p>
                            <a href="/docs" class="mt-6 inline-flex cursor-pointer items-center text-sm font-semibold text-cyan-700 transition-colors duration-200 hover:text-cyan-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                View API reference
                                <svg class="ml-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            @foreach (['Image Text', 'Image Math', 'Image Click', 'Turnstile', 'reCAPTCHA', 'GeeTest'] as $type)
                                <div class="rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700">
                                    {{ $type }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-xl border border-slate-200 bg-slate-950 p-8 text-center text-white sm:p-10">
                    <h2 class="text-3xl font-semibold tracking-tight">Ready to test your first solve?</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-base leading-7 text-slate-300">
                        Create an account and use the docs to submit your first task in a few minutes.
                    </p>
                    <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
                        @isset($member)
                            <a href="/secret" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-300 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 motion-reduce:transition-none">
                                Manage API Keys
                            </a>
                        @else
                            <a href="/auth/signup" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-300 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 motion-reduce:transition-none">
                                Create Account
                            </a>
                        @endisset
                        <a href="/pricing" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-white/15 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 motion-reduce:transition-none">
                            See Pricing
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
