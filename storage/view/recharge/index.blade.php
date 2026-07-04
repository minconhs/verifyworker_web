@extends('layouts.main')

@section('title', 'Top Up')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <a href="/wallet" class="text-gray-400 hover:text-cyan-600 transition-colors">Wallet</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Deposits</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Deposits</h1>
            <p class="text-sm text-gray-500">Create deposit orders and review recent deposit activity.</p>
        </div>
        <a href="/wallet" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Wallet
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        @if($error)
            @include('components.wrong', ['message' => $error, 'margin' => true])
        @endif

        @if(!empty($success))
            <section class="rounded-lg bg-cyan-500 px-5 py-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-white">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-white">Deposits order created</h2>
                            <p class="mt-1 text-sm text-white">Your deposits order has been created. Continue to the payment page and complete the payment before the order expires.</p>
                        </div>
                    </div>
                    <a href="{{ $success }}" target="_blank" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-green-600">
                        Pay now
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h5m0 0v5m0-5L10 15"/>
                        </svg>
                    </a>
                </div>
            </section>
        @endif

        <!-- Overview -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 sm:gap-5">
            <div class="rounded-lg border border-gray-200 bg-white p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Available Balance</span>
                    </div>
                </div>
                <p class="text-2xl font-medium text-gray-900">${{ $wallet_recharge->balance ?? '0.00000' }}</p>
                <p class="mt-1 text-xs text-gray-400">Current deposits balance</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Successful Amount</span>
                    </div>
                </div>
                <p class="text-2xl font-medium text-gray-900">${{ number_format((float)($successful_recharge_amount ?? 0), 2) }}</p>
                <p class="mt-1 text-xs text-gray-400">Total paid deposits amount</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" width="2em" height="2em" viewBox="0 0 2048 2048">
                                <path d="M0 0h2048v2048H0z" fill="none" />
                                <path fill="currentColor" d="m1472 600l575 288v782l-575 288l-576-286v-321l-320 159L0 1224l1-784l575-288l575 288l1 321zm368 327l-368-183l-368 183l368 184zM944 479L576 296L208 479l368 184zM129 583l-1 561l384 191V774zm511 752l257-127V888l127-63l-1-242l-383 191zm385-304l-1 561l384 191v-561zm511 752l383-192v-560l-383 191z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Deposits Orders</span>
                    </div>
                </div>
                <p class="text-2xl font-medium text-gray-900">{{ $pagination->total() }}</p>
                <p class="mt-1 text-xs text-gray-400">Total deposits records</p>
            </div>
        </div>

        <!-- Form + Tips -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <section class="rounded-lg border border-gray-200 bg-white lg:col-span-2">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">New Deposits</h2>
                </div>

                <form action="/wallet/deposits/submit" method="post" class="space-y-4 px-5 py-4">
                    <div>
                        <label for="amount" class="mb-2 block text-sm font-medium text-gray-700">Deposits Amount</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-sm font-medium text-gray-400">$</span>
                            </div>
                            <input id="amount" type="number" name="amount" value="{{ $old['amount'] ?? '50.00' }}" placeholder="0.00" required class="block h-10 w-full rounded-lg border border-gray-200 bg-white pl-7 pr-4 text-base font-medium text-gray-900 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Enter the amount you want to deposit, or pick a quick amount below.</p>

                        <div class="mt-3 grid grid-cols-4 gap-2">
                            <button type="button" onclick="document.getElementById('amount').value='50.00';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$50</button>
                            <button type="button" onclick="document.getElementById('amount').value='100.00';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$100</button>
                            <button type="button" onclick="document.getElementById('amount').value='300.00';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$300</button>
                            <button type="button" onclick="document.getElementById('amount').value='1000.00';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$1,000</button>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Payment Method</label>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 items-stretch">
                            <label class="cursor-pointer">
                                <input type="radio" name="method" value="minx" class="peer sr-only" checked>
                                <div class="flex h-full min-h-[72px] items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white px-3 py-3 text-gray-900 transition peer-checked:border-cyan-500 peer-checked:bg-cyan-500 peer-checked:text-white peer-checked:[&_.method-icon]:bg-white peer-checked:[&_.method-title]:text-white peer-checked:[&_.method-desc]:text-white/80 peer-checked:[&_.method-radio]:border-white peer-checked:[&_.method-radio]:bg-white peer-checked:[&_.method-radio-dot]:bg-cyan-500 peer-checked:[&_.method-radio-dot]:opacity-100 hover:border-gray-300">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="method-icon flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 transition">
                                            <svg class="h-6 w-6" viewBox="0 0 123 141" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="#164AFF" d="M5.8250618,10.9662284 C2.41795018,12.1722752 0,15.5711343 0,19.5181965 L0,77.189161 C0,107.559612 43.1933828,132.996235 57.591177,140.122875 C58.8001521,140.780719 60.3388477,141 61.5478228,141 C62.7567979,141 64.2954934,140.671078 65.5044685,140.122875 C80.0121696,133.105876 123.095646,107.559612 123.095646,77.189161 L123.095646,40.569195 L52.8651835,93.196691 C48.5788173,96.3762689 42.424035,95.1702222 39.7862712,90.4556756 L18.7940673,58.002053 C17.4751854,55.8092407 20.0030424,53.2875065 22.3110858,54.6031939 L43.6330101,69.2950366 L44.0726374,69.5143178 C46.0509603,70.5010834 48.4689104,70.5010834 50.5571401,69.5143178 L123.315459,31.5786644 L123.315459,19.6278371 C123.315459,15.6807749 120.897509,12.2819158 117.490397,11.075869 C99.5755847,4.05886954 82.6499334,0.00216671483 61.6577296,0.00216671483 C40.6655258,-0.107473902 23.7398745,3.94922892 5.8250618,10.9662284 Z"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="method-title text-sm font-medium text-gray-900 transition">MinxPay</p>
                                            <p class="method-desc mt-1 text-xs text-gray-500 transition">Fast payment channel</p>
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
                                            <p class="method-title text-sm font-medium text-gray-900 transition">PayPal</p>
                                            <p class="method-desc mt-1 text-xs text-gray-500 transition">Pay with PayPal</p>
                                        </div>
                                    </div>
                                    <span class="method-radio flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-white transition">
                                        <span class="method-radio-dot h-2 w-2 rounded-full bg-white opacity-0 transition"></span>
                                    </span>
                                </div>
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">After confirmation, continue with the selected payment provider.</p>
                    </div>

                    <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}">

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs text-gray-500">Minimum deposits amount is $50.00.</p>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors bg-cyan-500 text-white hover:bg-cyan-600 cursor-pointer">
                            <svg class="h-4 w-4" width="1em" height="1em" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor" d="m9 20.42l-6.21-6.21l2.83-2.83L9 14.77l9.88-9.89l2.83 2.83z" />
                            </svg>
                            Confirm payment
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white lg:col-span-1">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">Deposits Tips</h2>
                </div>

                <div class="space-y-4 p-5">
                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">Minimum amount</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">The minimum deposits amount is $50.00. Orders below this amount may not be accepted.</p>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">Payment redirect</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">After confirmation, you will be redirected to the selected payment channel to complete the transaction.</p>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">Need help?</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">If a paid order is not credited, contact support with the deposits order number.</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Records -->
        <section class="rounded-lg border border-gray-200 bg-white">
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
                        <h3 class="text-sm font-medium text-gray-950">Deposits Records</h3>
                        <p class="mt-1 text-xs text-gray-500">Latest client captcha orders.</p>
                    </div>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <a href="/wallet/deposits/records" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-950">
                        View All
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Order Number</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Method</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Amount</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Status</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Paid Time</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Time</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($pagination->items() as $item)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-5 py-4 text-sm font-medium text-gray-700">#{{ $item->order_no }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if(in_array($item->method, ['minx', 'mixpay'], true))
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                                            <svg class="h-5 w-5" viewBox="0 0 123 141" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="#164AFF" d="M5.8250618,10.9662284 C2.41795018,12.1722752 0,15.5711343 0,19.5181965 L0,77.189161 C0,107.559612 43.1933828,132.996235 57.591177,140.122875 C58.8001521,140.780719 60.3388477,141 61.5478228,141 C62.7567979,141 64.2954934,140.671078 65.5044685,140.122875 C80.0121696,133.105876 123.095646,107.559612 123.095646,77.189161 L123.095646,40.569195 L52.8651835,93.196691 C48.5788173,96.3762689 42.424035,95.1702222 39.7862712,90.4556756 L18.7940673,58.002053 C17.4751854,55.8092407 20.0030424,53.2875065 22.3110858,54.6031939 L43.6330101,69.2950366 L44.0726374,69.5143178 C46.0509603,70.5010834 48.4689104,70.5010834 50.5571401,69.5143178 L123.315459,31.5786644 L123.315459,19.6278371 C123.315459,15.6807749 120.897509,12.2819158 117.490397,11.075869 C99.5755847,4.05886954 82.6499334,0.00216671483 61.6577296,0.00216671483 C40.6655258,-0.107473902 23.7398745,3.94922892 5.8250618,10.9662284 Z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">MinxPay</p>
                                            <p class="text-xs text-gray-400">Payment channel</p>
                                        </div>
                                    @else
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                                            <svg class="h-5 w-5 text-blue-600" width="0.85em" height="1em" viewBox="0 0 256 302">
                                                <path d="M0 0h256v302H0z" fill="none" />
                                                <path fill="#27346a" d="M217.168 23.507C203.234 7.625 178.046.816 145.823.816h-93.52A13.39 13.39 0 0 0 39.076 12.11L.136 259.077c-.774 4.87 2.997 9.28 7.933 9.28h57.736l14.5-91.971l-.45 2.88c1.033-6.501 6.593-11.296 13.177-11.296h27.436c53.898 0 96.101-21.892 108.429-85.221c.366-1.873.683-3.696.957-5.477q-2.334-1.236 0 0c3.671-23.407-.025-39.34-12.686-53.765" />
                                                <path fill="#2790c3" d="M228.897 82.749c-12.328 63.32-54.53 85.221-108.429 85.221H93.024c-6.584 0-12.145 4.795-13.168 11.296L61.817 293.621c-.674 4.262 2.622 8.124 6.934 8.124h48.67a11.71 11.71 0 0 0 11.563-9.88l.474-2.48l9.173-58.136l.591-3.213a11.71 11.71 0 0 1 11.562-9.88h7.284c47.147 0 84.064-19.154 94.852-74.55c4.503-23.15 2.173-42.478-9.739-56.054c-3.613-4.112-8.1-7.508-13.327-10.28c-.283 1.79-.59 3.604-.957 5.477" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">PayPal</p>
                                            <p class="text-xs text-gray-400">Payment channel</p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm font-medium text-emerald-700">+${{ $item->amount }}</td>
                            <td class="px-5 py-4 text-sm">
                                @if($item->status == 0)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0a9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        Pending
                                    </span>
                                @elseif($item->status == 1)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13l4 4L19 7"/>
                                        </svg>
                                        Paid
                                    </span>
                                @elseif($item->status == 2)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Failed
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">
                                        Cancelled
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                @if($item->paid_at)
                                    <p class="text-gray-700">{{ $item->paid_at->format('M j, Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $item->paid_at->format('g:i A') }}</p>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                <p class="text-gray-700">{{ $item->created_at->format('M j, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $item->created_at->format('g:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <p class="text-sm font-medium text-gray-900">No deposits records yet</p>
                                    <p class="mt-1 text-sm text-gray-500">Your deposits history will appear here.</p>
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
