@extends('layouts.app')

@section('title', 'Docs')

@section('content')
    <div class="bg-white text-slate-950">
        <section class="border-b border-slate-200">
            <div class="container mx-auto px-4 py-12 sm:px-6 lg:px-8">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-cyan-600">API Documentation</p>
                    <div class="mt-4 grid gap-6 lg:grid-cols-[1fr_auto] lg:items-end">
                        <div>
                            <h1 class="text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">Build with Verify Worker</h1>
                            <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-600">
                                Submit CAPTCHA tasks, query results, and manage balance with a small set of JSON endpoints.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            @isset($member)
                                <a href="/secret" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-5 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                    API Keys
                                </a>
                            @else
                                <a href="/auth/signup" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-cyan-500 px-5 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                    Create Account
                                </a>
                            @endisset
                            <a href="/pricing" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition-colors duration-200 hover:border-cyan-500 hover:text-cyan-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                Pricing
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 py-10 lg:grid-cols-[220px_1fr]">
                <aside class="hidden lg:block">
                    <nav class="sticky top-24 space-y-1 text-sm">
                        @foreach ([
                            ['Overview', '#overview'],
                            ['Authentication', '#authentication'],
                            ['Create Task', '#create-task'],
                            ['Task Types', '#task-types'],
                            ['Query Result', '#query-result'],
                            ['Balance', '#balance'],
                            ['Errors', '#errors'],
                        ] as [$label, $href])
                            <a href="{{ $href }}" class="block rounded-lg px-3 py-2 font-medium text-slate-600 transition-colors duration-200 hover:bg-slate-50 hover:text-cyan-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-offset-2 motion-reduce:transition-none">
                                {{ $label }}
                            </a>
                        @endforeach
                    </nav>
                </aside>

                <main class="min-w-0 space-y-10">
                    <section id="overview" class="scroll-mt-24 rounded-xl border border-slate-200 bg-white p-6">
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Overview</h2>
                        <p class="mt-3 text-base leading-7 text-slate-600">
                            All API responses are JSON. Create a task, store the returned <code class="rounded bg-slate-100 px-1.5 py-0.5 text-sm text-slate-800">order_no</code>, then query the result or receive it through your callback URL.
                        </p>

                        <div class="mt-6 grid gap-4 sm:grid-cols-3">
                            @foreach ([
                                ['Base path', '/api/solve/{type}'],
                                ['Method', 'POST'],
                                ['Auth', 'Bearer API key'],
                            ] as [$label, $value])
                                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                    <div class="text-sm font-medium text-slate-500">{{ $label }}</div>
                                    <div class="mt-2 break-all font-mono text-sm font-semibold text-slate-950">{{ $value }}</div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section id="authentication" class="scroll-mt-24 rounded-xl border border-slate-200 bg-white p-6">
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Authentication</h2>
                        <p class="mt-3 text-base leading-7 text-slate-600">
                            Include your API key in the Authorization header. API keys can be generated from your account secrets page.
                        </p>
                        <div class="mt-5 overflow-hidden rounded-lg bg-slate-950">
                            <div class="border-b border-white/10 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Header</div>
                            <pre class="overflow-x-auto p-4 text-sm leading-6 text-slate-200"><code>Authorization: Bearer API_KEY</code></pre>
                        </div>
                    </section>

                    <section id="create-task" class="scroll-mt-24 rounded-xl border border-slate-200 bg-white p-6">
                        <div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
                            <div>
                                <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Create Task</h2>
                                <p class="mt-3 text-base leading-7 text-slate-600">
                                    Choose a task type and submit the required fields. The response returns an order number.
                                </p>
                            </div>
                            <div class="overflow-hidden rounded-lg bg-slate-950">
                                <div class="border-b border-white/10 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Image text example</div>
                                <pre class="overflow-x-auto p-4 text-sm leading-6 text-slate-200"><code>curl -X POST \
  -H "Authorization: Bearer API_KEY" \
  -d "image=data:image/jpeg;base64,..." \
  -d "min_length=4" \
  -d "max_length=8" \
  {{ $host ?? '' }}/api/solve/image_text</code></pre>
                            </div>
                        </div>

                        <div class="mt-5 overflow-hidden rounded-lg border border-slate-200">
                            <div class="grid bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 sm:grid-cols-3">
                                <div>Response field</div>
                                <div class="hidden sm:block">Type</div>
                                <div class="hidden sm:block">Description</div>
                            </div>
                            @foreach ([
                                ['success', 'boolean', 'Whether the request was accepted.'],
                                ['code', 'integer', '0 means success; non-zero means an error.'],
                                ['data.order_no', 'string', 'Order number used to query the result.'],
                            ] as [$field, $type, $description])
                                <div class="grid border-t border-slate-200 px-4 py-3 text-sm sm:grid-cols-3">
                                    <div class="font-mono font-medium text-slate-950">{{ $field }}</div>
                                    <div class="text-slate-600">{{ $type }}</div>
                                    <div class="text-slate-600">{{ $description }}</div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section id="task-types" class="scroll-mt-24 rounded-xl border border-slate-200 bg-white p-6">
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Task Types</h2>
                        <p class="mt-3 text-base leading-7 text-slate-600">
                            Each task type uses the same authorization and response shape, with different request fields.
                        </p>

                        <div class="mt-6 grid gap-4 md:grid-cols-2">
                            @foreach ([
                                ['image_text', 'Image Captcha', 'Base64 image text recognition.'],
                                ['image_math', 'Math Captcha', 'Arithmetic questions rendered as images.'],
                                ['image_click', 'Click Captcha', 'Object or grid selection challenges.'],
                                ['recaptcha_v2', 'reCAPTCHA v2', 'Token workflow using site key and page URL.'],
                                ['recaptcha_v3', 'reCAPTCHA v3', 'Score/action based token workflow.'],
                                ['turnstile', 'Turnstile', 'Cloudflare Turnstile token workflow.'],
                                ['gee_test', 'GeeTest', 'GeeTest challenge token workflow.'],
                                ['rotate_captcha', 'Rotate Captcha', 'Image rotation and orientation tasks.'],
                            ] as [$type, $title, $copy])
                                <div class="rounded-lg border border-slate-200 bg-white p-4">
                                    <div class="font-mono text-sm font-semibold text-cyan-700">{{ $type }}</div>
                                    <h3 class="mt-2 text-base font-semibold text-slate-950">{{ $title }}</h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section id="query-result" class="scroll-mt-24 rounded-xl border border-slate-200 bg-white p-6">
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Query Result</h2>
                        <p class="mt-3 text-base leading-7 text-slate-600">
                            Query by <code class="rounded bg-slate-100 px-1.5 py-0.5 text-sm text-slate-800">order_no</code> until the task is complete, or use a callback URL when creating the task.
                        </p>
                        <div class="mt-5 grid gap-4 lg:grid-cols-2">
                            <div class="overflow-hidden rounded-lg bg-slate-950">
                                <div class="border-b border-white/10 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Request</div>
                                <pre class="overflow-x-auto p-4 text-sm leading-6 text-slate-200"><code>curl -X POST \
  -H "Authorization: Bearer API_KEY" \
  -d "order_no={order_no}" \
  {{ $host ?? '' }}/api/solve/result</code></pre>
                            </div>
                            <div class="overflow-hidden rounded-lg bg-slate-950">
                                <div class="border-b border-white/10 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Response</div>
                                <pre class="overflow-x-auto p-4 text-sm leading-6 text-emerald-200"><code>{
  "success": true,
  "code": 0,
  "data": {
    "status": "success",
    "result": "AB12CD",
    "cost": 0.001
  }
}</code></pre>
                            </div>
                        </div>
                    </section>

                    <section id="balance" class="scroll-mt-24 rounded-xl border border-slate-200 bg-white p-6">
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Query Balance</h2>
                        <p class="mt-3 text-base leading-7 text-slate-600">
                            Use the balance endpoint before high-volume submissions to verify available funds.
                        </p>
                        <div class="mt-5 overflow-hidden rounded-lg bg-slate-950">
                            <div class="border-b border-white/10 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Request</div>
                            <pre class="overflow-x-auto p-4 text-sm leading-6 text-slate-200"><code>curl -X POST \
  -H "Authorization: Bearer API_KEY" \
  {{ $host ?? '' }}/api/solve/balance</code></pre>
                        </div>
                    </section>

                    <section id="errors" class="scroll-mt-24 rounded-xl border border-slate-200 bg-white p-6">
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Error Codes</h2>
                        <p class="mt-3 text-base leading-7 text-slate-600">
                            Non-zero codes indicate that the request failed or cannot be processed.
                        </p>
                        <div class="mt-5 overflow-hidden rounded-lg border border-slate-200">
                            @foreach ([
                                ['400', 'Incorrect request parameters'],
                                ['401', 'Unauthorized, invalid API key'],
                                ['402', 'Insufficient balance'],
                                ['429', 'Too many requests'],
                                ['500', 'Server error'],
                            ] as [$code, $message])
                                <div class="grid border-t border-slate-200 px-4 py-3 text-sm first:border-t-0 sm:grid-cols-[120px_1fr]">
                                    <div><span class="rounded-md bg-slate-100 px-2 py-1 font-mono font-semibold text-slate-950">{{ $code }}</span></div>
                                    <div class="mt-2 text-slate-600 sm:mt-0">{{ $message }}</div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
@endsection
