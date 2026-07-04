@extends('layouts.app')

@section('title', 'Help')

@section('content')
    <div class="bg-white text-slate-950">
        <section class="border-b border-slate-200">
            <div class="container mx-auto px-4 py-14 sm:px-6 sm:py-16 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-end">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-cyan-600">Help Center</p>
                        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">Find the right support path</h1>
                        <p class="mt-4 text-lg leading-8 text-slate-600">
                            Quick answers for account setup, API integration, pricing, wallet balance, and support tickets.
                        </p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="/docs" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-5 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                            Read Docs
                        </a>
                        <a href="/ticket/create" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition-colors duration-200 hover:border-cyan-500 hover:text-cyan-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                            Open Ticket
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <section class="border-b border-slate-200 bg-slate-50 py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ([
                        ['Documentation', 'API endpoints, request fields, examples, and error codes.', '/docs', 'View documentation'],
                        ['Pricing', 'Costs by captcha type and what is included with every task.', '/pricing', 'View pricing'],
                        ['Support tickets', 'Create and track support requests for account, wallet, or task issues.', '/ticket', 'Manage tickets'],
                    ] as [$title, $copy, $href, $cta])
                        <a href="{{ $href }}" class="group cursor-pointer rounded-xl border border-slate-200 bg-white p-6 transition-colors duration-200 hover:border-cyan-300 hover:bg-cyan-50/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                            <div class="mb-5 flex h-10 w-10 items-center justify-center rounded-lg bg-cyan-50 text-cyan-600 transition-colors duration-200 group-hover:bg-white motion-reduce:transition-none">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-slate-950">{{ $title }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                            <div class="mt-5 text-sm font-semibold text-cyan-700">{{ $cta }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-white py-14 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[0.7fr_1.3fr] lg:items-start">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-cyan-600">FAQ</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Common questions</h2>
                        <p class="mt-4 text-base leading-7 text-slate-600">
                            Short answers for the issues most users hit before opening a ticket.
                        </p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach ([
                            ['How do I create an account?', 'Use Sign Up, verify your email, then open the console to manage API keys and wallet balance.'],
                            ['Where is my API key?', 'After signing in, open the API keys or secrets page from your account area.'],
                            ['How do I submit a CAPTCHA task?', 'Choose a task type in the docs, send the required fields, and store the returned order number.'],
                            ['How do I get the result?', 'Use the result query endpoint with order_no, or provide a callback URL when creating the task.'],
                            ['Which captcha types are supported?', 'Image text, image math, image click, Turnstile, reCAPTCHA, GeeTest, rotate captcha, and more.'],
                            ['How does billing work?', 'Recharge your balance and pay only for successful completed tasks based on captcha type.'],
                            ['Why did a request fail?', 'Check the error code, request parameters, API key validity, and available balance.'],
                            ['When should I open a ticket?', 'Open a ticket for account access, payment, wallet, failed task, or integration issues you cannot resolve from docs.'],
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
                <div class="rounded-xl border border-slate-200 bg-slate-950 p-8 text-white sm:p-10">
                    <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
                        <div>
                            <h2 class="text-3xl font-semibold tracking-tight">Still need help?</h2>
                            <p class="mt-4 text-base leading-7 text-slate-300">
                                Create a ticket with your account email, order number, endpoint, and the error message you received.
                            </p>
                        </div>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="/ticket/create" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-300 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 motion-reduce:transition-none">
                                Open Ticket
                            </a>
                            <a href="/ticket" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-white/15 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 motion-reduce:transition-none">
                                View Tickets
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
