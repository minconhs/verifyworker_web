@extends('layouts.main')

@section('title', 'Create Ticket')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <a href="/ticket" class="text-gray-400 hover:text-cyan-600 transition-colors">Support Tickets</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Create Ticket</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Create Ticket</h1>
            <p class="text-sm text-gray-500">Create a new support request for account, wallet, or task issues.</p>
        </div>
        <a href="/ticket" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Tickets
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        @if($error)
            @include('components.wrong', ['message' => $error, 'margin' => true])
        @endif

        @if($success)
            @include('components.success', ['message' => $success, 'margin' => true])
        @endif

        <!-- Overview -->
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-5 py-4">
                <div>
                    <h2 class="text-base font-medium text-gray-900">Create Support Ticket</h2>
                    <p class="mt-1 text-sm text-gray-500">Share enough context so support can understand and resolve the issue faster.</p>
                </div>
            </div>

            <div class="p-5">
                <form method="POST" action="/ticket/create" class="space-y-5">
                        <div>
                            <label for="subject" class="mb-2 block text-sm font-medium text-gray-700">Subject <span class="text-red-500">*</span></label>
                            <input id="subject" type="text" name="subject" maxlength="100"
                                   class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20"
                                   placeholder="Enter a brief summary of your issue" value="{{ $old['subject'] ?? '' }}" autocomplete="off" required>
                            <p class="mt-2 text-xs text-gray-400">Maximum 100 characters.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="category" class="mb-2 block text-sm font-medium text-gray-700">Category</label>
                                <select id="category" name="category" class="block w-full appearance-none rounded-lg border border-gray-200 bg-white py-3 pl-4 pr-10 text-sm text-gray-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%239ca3af%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
                                    <option value="general" {{ ($old['category'] ?? 'general') == 'general' ? 'selected' : '' }}>General Question</option>
                                    <option value="technical" {{ ($old['category'] ?? '') == 'technical' ? 'selected' : '' }}>Technical Issue</option>
                                    <option value="billing" {{ ($old['category'] ?? '') == 'billing' ? 'selected' : '' }}>Billing &amp; Payment</option>
                                    <option value="account" {{ ($old['category'] ?? '') == 'account' ? 'selected' : '' }}>Account Issue</option>
                                    <option value="other" {{ ($old['category'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div>
                                <label for="priority" class="mb-2 block text-sm font-medium text-gray-700">Priority</label>
                                <select id="priority" name="priority"
                                        class="block w-full appearance-none rounded-lg border border-gray-200 bg-white py-3 pl-4 pr-10 text-sm text-gray-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20"
                                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%239ca3af%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
                                    <option value="low" {{ ($old['priority'] ?? '') == 'low' ? 'selected' : '' }}>Low - General inquiry</option>
                                    <option value="medium" {{ ($old['priority'] ?? 'medium') == 'medium' ? 'selected' : '' }}>Medium - Non-critical issue</option>
                                    <option value="high" {{ ($old['priority'] ?? '') == 'high' ? 'selected' : '' }}>High - Service affected</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="description" class="mb-2 block text-sm font-medium text-gray-700">Description <span class="text-red-500">*</span></label>
                            <textarea id="description" name="description" rows="9" maxlength="2000" class="block w-full resize-y rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Please describe the issue, error message, affected service, and steps to reproduce." required>{{ $old['description'] ?? '' }}</textarea>
                            <p class="mt-2 text-xs text-gray-400">Maximum 2000 characters.</p>
                        </div>

                        <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}">

                        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-xs text-gray-400">Required fields are marked with <span class="text-red-500">*</span>.</p>
                            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-cyan-600 cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Submit Ticket
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-5 py-4">
                <h2 class="text-base font-medium text-gray-900">Ticket Notes</h2>
            </div>

            <div class="grid gap-4 px-5 py-5 sm:grid-cols-2">
                <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900">What to include</h3>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-600">Include the affected service, error message, unexpected result, and steps already tried.</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50">
                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900">High priority</h3>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-600">Use high priority when a service is blocked, payment is affected, or account access is unavailable.</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-50">
                            <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900">Medium priority</h3>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-600">Use medium priority for non-critical issues where work can continue with a workaround.</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-100">
                            <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 14h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900">Low priority</h3>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-600">Use low priority for general questions, minor issues, or requests that do not block current work.</p>
                </div>
            </div>
        </section>
    </div>
@endsection
