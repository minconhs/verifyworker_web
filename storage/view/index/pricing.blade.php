@extends('layouts.app')

@section('title', 'Pricing')

@section('content')
    <div class="bg-white text-slate-950">
        <section class="border-b border-slate-200">
            <div class="container mx-auto px-4 py-14 text-center sm:px-6 sm:py-18 lg:px-8 lg:py-20">
                <p class="text-sm font-semibold uppercase tracking-wide text-cyan-600">Pricing</p>
                <h1 class="mx-auto mt-4 max-w-3xl text-4xl font-semibold leading-tight tracking-tight text-slate-950 sm:text-5xl">
                    Pay only for completed solves
                </h1>
                <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-600">
                    No subscription lock-in. Recharge your balance, send tasks through the API, and pay by captcha type.
                </p>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-slate-50 py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid gap-5 lg:grid-cols-3">
                    @foreach ([
                        [
                            'name' => 'Image Text',
                            'price' => '$0.50',
                            'description' => 'Recognize distorted letters, numbers, and mixed image text.',
                            'speed' => '3-8 seconds',
                            'accuracy' => '95%+ accuracy',
                            'badge' => null,
                        ],
                        [
                            'name' => 'Image Math',
                            'price' => '$0.65',
                            'description' => 'Solve simple arithmetic questions rendered inside images.',
                            'speed' => '5-12 seconds',
                            'accuracy' => '94%+ accuracy',
                            'badge' => 'Popular',
                        ],
                        [
                            'name' => 'Image Click',
                            'price' => '$0.80',
                            'description' => 'Select objects, regions, or grid cells from image challenges.',
                            'speed' => '8-20 seconds',
                            'accuracy' => '92%+ accuracy',
                            'badge' => null,
                        ],
                    ] as $plan)
                        <div class="relative rounded-xl border {{ $plan['badge'] ? 'border-cyan-500 bg-white' : 'border-slate-200 bg-white' }} p-6">
                            @if ($plan['badge'])
                                <span class="absolute right-5 top-5 rounded-md bg-cyan-50 px-2.5 py-1 text-xs font-semibold text-cyan-700">{{ $plan['badge'] }}</span>
                            @endif

                            <h2 class="text-xl font-semibold text-slate-950">{{ $plan['name'] }}</h2>
                            <p class="mt-3 min-h-12 text-sm leading-6 text-slate-600">{{ $plan['description'] }}</p>

                            <div class="mt-6 flex items-end gap-2">
                                <span class="text-4xl font-semibold tracking-tight text-slate-950">{{ $plan['price'] }}</span>
                                <span class="pb-1 text-sm text-slate-500">/ 1K solves</span>
                            </div>

                            <ul class="mt-6 space-y-3 text-sm text-slate-600">
                                @foreach ([$plan['speed'], $plan['accuracy'], 'API + callback support'] as $feature)
                                    <li class="flex items-start gap-2">
                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            @isset($member)
                                <a href="/task/client" class="mt-7 inline-flex w-full cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-5 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                    Create Task
                                </a>
                            @else
                                <a href="/auth/signup" class="mt-7 inline-flex w-full cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-5 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                    Sign Up Free
                                </a>
                            @endisset
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 rounded-lg border border-slate-200 bg-white px-5 py-4 text-center text-sm leading-6 text-slate-700">
                    More captcha types are available, including Turnstile, reCAPTCHA, GeeTest, rotate captcha, and number captcha.
                    <a href="/docs" class="font-semibold text-slate-950 underline underline-offset-2">View the API docs</a>.
                </div>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-white py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div>
                    <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-cyan-600">Included</p>
                            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Every task type includes the basics</h2>
                            <p class="mt-4 text-base leading-7 text-slate-600">
                                Pricing changes by challenge complexity, but the operational workflow stays the same.
                            </p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            @foreach ([
                                ['Bearer API auth', 'Use one API key across supported task endpoints.'],
                                ['Result query', 'Poll by order number when your job runner needs control.'],
                                ['Webhook callback', 'Receive results automatically when the solve is complete.'],
                                ['Wallet records', 'Track recharge, balance changes, and task spending.'],
                            ] as [$title, $copy])
                                <div class="rounded-lg border border-slate-200 bg-white p-5">
                                    <h3 class="text-base font-semibold text-slate-950">{{ $title }}</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-slate-50 py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div>
                    <div class="mx-auto max-w-2xl text-center">
                        <p class="text-sm font-semibold uppercase tracking-wide text-cyan-600">FAQ</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Pricing questions</h2>
                    </div>

                    <div class="mt-8 grid gap-4 md:grid-cols-3">
                        @foreach ([
                            ['Is there a monthly fee?', 'No. You recharge balance and pay for successful task completions.'],
                            ['Can I test before paying?', 'New accounts can use the welcome bonus to test common captcha types.'],
                            ['Where do I see spending?', 'Wallet flow and task records show recharge, usage, and solve status.'],
                        ] as [$question, $answer])
                            <div class="rounded-lg border border-slate-200 bg-white p-5">
                                <h3 class="text-base font-semibold text-slate-950">{{ $question }}</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $answer }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-xl border border-slate-200 bg-slate-950 p-8 text-center text-white sm:p-10">
                    <h2 class="text-3xl font-semibold tracking-tight">Start with a small test</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-base leading-7 text-slate-300">
                        Create an account, generate an API key, and send your first captcha task from the docs.
                    </p>
                    <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
                        @isset($member)
                            <a href="/console" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-300 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 motion-reduce:transition-none">
                                Open Console
                            </a>
                        @else
                            <a href="/auth/signup" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-300 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 motion-reduce:transition-none">
                                Sign Up Free
                            </a>
                        @endisset
                        <a href="/docs" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-white/15 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 motion-reduce:transition-none">
                            View API Docs
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
