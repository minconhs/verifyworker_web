@extends('layouts.main')

@section('title', 'Withdraw')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-slate-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <a href="/wallet" class="text-slate-400 hover:text-cyan-600 transition-colors">Wallet</a>
        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-slate-900 font-medium">Withdraw</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-slate-900 mb-1">Withdraw</h1>
            <p class="text-sm text-slate-500">Submit withdrawal requests and review recent payout status.</p>
        </div>
        <a href="/wallet" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Wallet
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6 sm:space-y-8">
        @if($error)
            @include('components.wrong', ['message' => $error, 'margin' => true])
        @endif

        @if($success)
            @include('components.success', ['message' => $success, 'margin' => true])
        @endif

        <!-- Overview -->
        <div class="grid grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-4">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2Zm0-7h-4a2 2 0 0 0 0 4h4M18 7V5.6a2 2 0 0 0-2.5-1.93L5 6.47"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-400">Available</span>
                </div>
                <p class="text-xs text-gray-500">Available Balance</p>
                <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">${{ $wallet_task->balance ?? '0.00000' }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5 13 4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-400">Successful</span>
                </div>
                <p class="text-xs text-gray-500">Completed</p>
                <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">{{ $successful_withdrawals_count }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-400">Under review</span>
                </div>
                <p class="text-xs text-gray-500">Pending</p>
                <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">{{ $pending_withdrawals_count }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7h8m0 0v8m0-8-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-400">All time</span>
                </div>
                <p class="text-xs text-gray-500">Total Withdrawn</p>
                <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">${{ number_format($successful_withdrawals_total_amount, 2) }}</p>
            </div>
        </div>

        <!-- Form + Tips -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm lg:col-span-2">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="text-base font-medium text-slate-900">New Withdrawal</h2>
                </div>

                <form action="/wallet/withdraw/submit" method="post" class="space-y-6 px-6 py-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Withdrawal Amount</label>
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                            @foreach($amount_list as $item)
                                <label class="cursor-pointer">
                                    <input type="radio" name="amount" value="{{ $item->id }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                                    <div class="relative rounded-lg border border-slate-200 bg-white px-3 py-3 text-center text-slate-900 transition peer-checked:text-white peer-checked:bg-cyan-500">
                                        <span class="text-sm font-medium text-current">${{ number_format($item->amount, 2) }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Select the amount you want to withdraw.</p>
                    </div>
                    
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Withdrawal Method</label>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 items-stretch">
                            <label class="cursor-pointer">
                                <input type="radio" name="method" value="polygon" class="peer sr-only" checked>
                                <div class="flex h-full min-h-[72px] items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white px-3 py-3 text-gray-900 transition peer-checked:border-cyan-500 peer-checked:bg-cyan-500 peer-checked:text-white peer-checked:[&_.method-icon]:bg-white peer-checked:[&_.method-title]:text-white peer-checked:[&_.method-desc]:text-white/80 peer-checked:[&_.method-radio]:border-white peer-checked:[&_.method-radio]:bg-white peer-checked:[&_.method-radio-dot]:bg-cyan-500 peer-checked:[&_.method-radio-dot]:opacity-100 hover:border-gray-300">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="method-icon flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 transition">
                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <g fill="none">
                                                    <path fill="url(#polygonGrad)" d="m16.364 15.217l4.27-2.435a.73.73 0 0 0 .366-.627V7.284a.72.72 0 0 0-.366-.627l-4.27-2.435a.74.74 0 0 0-.732 0l-4.27 2.435a.72.72 0 0 0-.366.627v8.704l-2.994 1.707l-2.994-1.707v-3.415l2.994-1.707l1.974 1.127V9.702l-1.608-.918a.75.75 0 0 0-.732 0l-4.27 2.435a.72.72 0 0 0-.366.627v4.87c0 .258.14.498.366.627l4.27 2.436a.75.75 0 0 0 .732 0l4.27-2.436a.72.72 0 0 0 .366-.626V8.012l.053-.03l2.94-1.677l2.994 1.707v3.415l-2.994 1.707l-1.972-1.124v2.291l1.606.916a.75.75 0 0 0 .732 0z"/>
                                                    <defs>
                                                        <linearGradient id="polygonGrad" x1="2.942" x2="20.119" y1="17.194" y2="7.101" gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#a726c1"/>
                                                            <stop offset=".88" stop-color="#803bdf"/>
                                                            <stop offset="1" stop-color="#7b3fe4"/>
                                                        </linearGradient>
                                                    </defs>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="method-title text-sm font-medium text-slate-900 transition">Polygon USDT</p>
                                            <p class="method-desc mt-1 text-xs text-slate-500 transition">Fast crypto withdrawal</p>
                                        </div>
                                    </div>
                                    <span class="method-radio flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-white transition">
                                        <span class="method-radio-dot h-2 w-2 rounded-full bg-white opacity-0 transition"></span>
                                    </span>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="method" value="paypal" class="peer sr-only">
                                <div class="flex h-full min-h-[72px] items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white px-3 py-3 text-gray-900 transition peer-checked:border-cyan-500 peer-checked:bg-cyan-500 peer-checked:text-white peer-checked:[&_.method-icon]:bg-white peer-checked:[&_.method-title]:text-white peer-checked:[&_.method-desc]:text-white/80 peer-checked:[&_.method-radio]:border-white peer-checked:[&_.method-radio]:bg-white peer-checked:[&_.method-radio-dot]:bg-cyan-500 peer-checked:[&_.method-radio-dot]:opacity-100 hover:border-gray-300">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="method-icon flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 transition">
                                            <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 302">
                                                <path fill="#27346a" d="M217.168 23.507C203.234 7.625 178.046.816 145.823.816h-93.52A13.39 13.39 0 0 0 39.076 12.11L.136 259.077c-.774 4.87 2.997 9.28 7.933 9.28h57.736l14.5-91.971l-.45 2.88c1.033-6.501 6.593-11.296 13.177-11.296h27.436c53.898 0 96.101-21.892 108.429-85.221c.366-1.873.683-3.696.957-5.477q-2.334-1.236 0 0c3.671-23.407-.025-39.34-12.686-53.765" />
                                                <path fill="#27346a" d="M102.397 68.84a11.7 11.7 0 0 1 5.053-1.14h73.318c8.682 0 16.78.565 24.18 1.756a102 102 0 0 1 6.177 1.182a90 90 0 0 1 8.59 2.347c3.638 1.215 7.026 2.63 10.14 4.287c3.67-23.416-.026-39.34-12.687-53.765C203.226 7.625 178.046.816 145.823.816H52.295C45.71.816 40.108 5.61 39.076 12.11L.136 259.068c-.774 4.878 2.997 9.282 7.925 9.282h57.744L95.888 77.58a11.72 11.72 0 0 1 6.509-8.74" />
                                                <path fill="#2790c3" d="M228.897 82.749c-12.328 63.32-54.53 85.221-108.429 85.221H93.024c-6.584 0-12.145 4.795-13.168 11.296L61.817 293.621c-.674 4.262 2.622 8.124 6.934 8.124h48.67a11.71 11.71 0 0 0 11.563-9.88l.474-2.48l9.173-58.136l.591-3.213a11.71 11.71 0 0 1 11.562-9.88h7.284c47.147 0 84.064-19.154 94.852-74.55c4.503-23.15 2.173-42.478-9.739-56.054c-3.613-4.112-8.1-7.508-13.327-10.28c-.283 1.79-.59 3.604-.957 5.477" />
                                                <path fill="#1f264f" d="M216.952 72.128a90 90 0 0 0-5.818-1.49a110 110 0 0 0-6.177-1.174c-7.408-1.199-15.5-1.765-24.19-1.765h-73.309a11.6 11.6 0 0 0-5.053 1.149a11.68 11.68 0 0 0-6.51 8.74l-15.582 98.798l-.45 2.88c1.025-6.501 6.585-11.296 13.17-11.296h27.444c53.898 0 96.1-21.892 108.428-85.221c.367-1.873.675-3.688.958-5.477q-4.682-2.47-10.14-4.279a83 83 0 0 0-2.77-.865" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="method-title text-sm font-medium text-slate-900 transition">PayPal</p>
                                            <p class="method-desc mt-1 text-xs text-slate-500 transition">Withdraw to PayPal account</p>
                                        </div>
                                    </div>
                                    <span class="method-radio flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-white transition">
                                        <span class="method-radio-dot h-2 w-2 rounded-full bg-white opacity-0 transition"></span>
                                    </span>
                                </div>
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Supported channels and processing times depend on the selected method.</p>
                    </div>

                    <div>
                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                            <div>
                                <label for="account" class="mb-2 block text-sm font-medium text-slate-700">Receiving Account</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                                        <span class="flex h-7 w-7 items-center justify-center rounded-lg">
                                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <input id="account" type="text" name="account" value="{{ $old['account'] ?? '' }}" placeholder="PayPal email or Polygon wallet address" required class="block h-11 w-full rounded-lg border border-slate-200 bg-white pl-12 pr-4 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-900/10">
                                </div>
                                <p class="mt-1.5 text-xs text-slate-500">Check the account carefully before submitting.</p>
                            </div>

                            <div>
                                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Payment Password</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                                        <span class="flex h-7 w-7 items-center justify-center rounded-lg">
                                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" stroke-width="1.8"/>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke-width="1.8"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <input id="password" type="password" name="password" placeholder="Enter payment password" required class="block h-11 w-full rounded-lg border border-slate-200 bg-white pl-12 pr-4 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-900/10">
                                </div>
                                <p class="mt-1.5 text-xs text-slate-500">Forgot your payment password? <a href="/setting/pay-password/reset" class="font-medium text-cyan-600 hover:text-cyan-700">Reset it here</a>.</p>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}"/>
                    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs text-slate-500">Withdrawal requests are reviewed before processing.</p>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors bg-cyan-500 text-white hover:bg-cyan-600 cursor-pointer">
                            <svg class="h-4 w-4" width="1em" height="1em" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor" d="m9 20.42l-6.21-6.21l2.83-2.83L9 14.77l9.88-9.89l2.83 2.83z" />
                            </svg>
                            Confirm withdrawal
                        </button>
                    </div>

                </form>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white shadow-sm lg:col-span-1">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="text-base font-medium text-slate-900">Withdraw Tips</h2>
                </div>

                <div class="space-y-4 px-6 py-5">
                    <div class="rounded-lg border border-slate-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-slate-900">Confirm receiving account</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">Check your PayPal email or Polygon wallet address carefully before submitting. Incorrect accounts may delay or fail the withdrawal.</p>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-slate-900">Processing review</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">Withdrawal requests are reviewed before processing. Requests with unusual account or amount activity may take longer.</p>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-slate-900">Channel timing</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">Polygon USDT transfers usually complete faster, while PayPal withdrawals may take longer depending on account checks.</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Records -->
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">

            <div class="flex flex-col gap-4 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" width="1em" height="1em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <g fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="14" height="17" x="5" y="4" rx="2" />
                                <path stroke-linecap="round" d="M9 9h6m-6 4h6m-6 4h4" />
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-950">Withdrawal Records</h3>
                        <p class="mt-1 text-xs text-gray-500">Your withdrawal transaction history</p>
                    </div>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <a href="/wallet/withdraw/records" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-950">
                        View All
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left">
                    <thead class="bg-slate-50/80">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-slate-500">Order Number</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-slate-500">Method</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-slate-500">Amount</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-slate-500">Account</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-slate-500">Status</th>
{{--                        <th scope="col" class="px-5 py-3 text-xs font-medium text-slate-500">Message</th>--}}
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-slate-500">Time</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($pagination->items() as $item)
                        <tr class="align-middle transition-colors hover:bg-slate-50/70">
                            <td class="px-6 py-4 text-sm font-medium text-slate-700">#{{ $item->order_no }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($item->method === 'polygon')
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-50 ring-1 ring-slate-200">
                                            <svg class="h-5 w-5 text-cyan-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="m16.364 15.217l4.27-2.435a.73.73 0 0 0 .366-.627V7.284a.72.72 0 0 0-.366-.627l-4.27-2.435a.74.74 0 0 0-.732 0l-4.27 2.435a.72.72 0 0 0-.366.627v8.704l-2.994 1.707l-2.994-1.707v-3.415l2.994-1.707l1.974 1.127V9.702l-1.608-.918a.75.75 0 0 0-.732 0l-4.27 2.435a.72.72 0 0 0-.366.627v4.87c0 .258.14.498.366.627l4.27 2.436a.75.75 0 0 0 .732 0l4.27-2.436a.72.72 0 0 0 .366-.626V8.012l.053-.03l2.94-1.677l2.994 1.707v3.415l-2.994 1.707l-1.972-1.124v2.291l1.606.916a.75.75 0 0 0 .732 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">Polygon USDT</p>
                                            <p class="text-xs text-slate-400">Crypto withdrawal</p>
                                        </div>
                                    @else
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-50 ring-1 ring-slate-200">
                                            <svg class="h-5 w-5 text-cyan-600" width="0.85em" height="1em" viewBox="0 0 256 302">
                                                <path d="M0 0h256v302H0z" fill="none" />
                                                <path fill="#27346a" d="M217.168 23.507C203.234 7.625 178.046.816 145.823.816h-93.52A13.39 13.39 0 0 0 39.076 12.11L.136 259.077c-.774 4.87 2.997 9.28 7.933 9.28h57.736l14.5-91.971l-.45 2.88c1.033-6.501 6.593-11.296 13.177-11.296h27.436c53.898 0 96.101-21.892 108.429-85.221c.366-1.873.683-3.696.957-5.477q-2.334-1.236 0 0c3.671-23.407-.025-39.34-12.686-53.765" />
                                                <path fill="#27346a" d="M102.397 68.84a11.7 11.7 0 0 1 5.053-1.14h73.318c8.682 0 16.78.565 24.18 1.756a102 102 0 0 1 6.177 1.182a90 90 0 0 1 8.59 2.347c3.638 1.215 7.026 2.63 10.14 4.287c3.67-23.416-.026-39.34-12.687-53.765C203.226 7.625 178.046.816 145.823.816H52.295C45.71.816 40.108 5.61 39.076 12.11L.136 259.068c-.774 4.878 2.997 9.282 7.925 9.282h57.744L95.888 77.58a11.72 11.72 0 0 1 6.509-8.74" />
                                                <path fill="#2790c3" d="M228.897 82.749c-12.328 63.32-54.53 85.221-108.429 85.221H93.024c-6.584 0-12.145 4.795-13.168 11.296L61.817 293.621c-.674 4.262 2.622 8.124 6.934 8.124h48.67a11.71 11.71 0 0 0 11.563-9.88l.474-2.48l9.173-58.136l.591-3.213a11.71 11.71 0 0 1 11.562-9.88h7.284c47.147 0 84.064-19.154 94.852-74.55c4.503-23.15 2.173-42.478-9.739-56.054c-3.613-4.112-8.1-7.508-13.327-10.28c-.283 1.79-.59 3.604-.957 5.477" />
                                                <path fill="#1f264f" d="M216.952 72.128a90 90 0 0 0-5.818-1.49a110 110 0 0 0-6.177-1.174c-7.408-1.199-15.5-1.765-24.19-1.765h-73.309a11.6 11.6 0 0 0-5.053 1.149a11.68 11.68 0 0 0-6.51 8.74l-15.582 98.798l-.45 2.88c1.025-6.501 6.585-11.296 13.17-11.296h27.444c53.898 0 96.1-21.892 108.428-85.221c.367-1.873.675-3.688.958-5.477q-4.682-2.47-10.14-4.279a83 83 0 0 0-2.77-.865" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">PayPal</p>
                                            <p class="text-xs text-slate-400">Account withdrawal</p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm font-medium text-rose-600">-${{ $item->amount }}</td>
                            <td class="px-5 py-4 text-sm text-slate-600">
                                <div class="max-w-[360px] rounded-lg bg-slate-50 px-3 py-2 ring-1 ring-slate-200">
                                    <p class="break-all font-mono text-xs leading-5 text-slate-700">{{ $item->account }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm">
                                @if($item->status == 0)
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0a9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        Pending
                                    </span>
                                @elseif($item->status == 1)
                                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-cyan-200 bg-cyan-50 px-2.5 py-1 text-xs font-medium text-cyan-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13l4 4L19 7"/>
                                        </svg>
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Failed
                                    </span>
                                @endif
                            </td>
{{--                            <td class="px-5 py-4 text-sm text-slate-600">--}}
{{--                                <p class="max-w-[300px] truncate" title="{{ $item->status_message ?? '-' }}">{{ $item->status_message ?? '-' }}</p>--}}
{{--                            </td>--}}
                            <td class="px-6 py-4 text-sm text-slate-600">
                                <p class="text-slate-700">{{ $item->created_at->format('M j, Y') }}</p>
                                <p class="text-xs text-slate-400">{{ $item->created_at->format('g:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <p class="text-sm font-medium text-slate-900">No withdrawal records yet</p>
                                    <p class="mt-1 text-sm text-slate-500">Your withdrawal history will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @parent
@endsection
