@extends('layouts.main')

@section('title', 'Create Secret')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <a href="/secret" class="text-gray-400 hover:text-cyan-600 transition-colors">Api Secret</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Create API Secret</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Create API Secret</h1>
            <p class="text-sm text-gray-500">Create a new API secret for client integrations.</p>
        </div>
        <a href="/secret" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to API Secret
        </a>
    </div>
@endsection

@section('content')

    @if($error)
        @include('components.wrong', ['message' => $error, 'margin' => true])
    @endif

    @if($success)
        @include('components.success', ['message' => $success, 'margin' => true])
    @endif

    <section class="rounded-lg border border-gray-200 bg-white" id="secret_section">
        <div class="px-5 py-5">
            <form action="/secret/create" method="POST" class="space-y-5">
                <div>
                    <label for="hook_url" class="mb-2 block text-sm font-medium text-gray-700">Hook URL</label>
                    <input type="url" id="hook_url" name="hook_url" value="{{ $old['hook_url'] ?? '' }}" placeholder="https://example.com/webhook" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                    <p class="mt-1.5 text-xs text-gray-400">Receive task result callbacks at this URL.</p>
                </div>

                <div>
                    <label for="white_ip" class="mb-2 block text-sm font-medium text-gray-700">White IP</label>
                    <textarea id="white_ip" name="white_ip" rows="4" placeholder="192.168.1.1" class="w-full resize-y rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">{{ $old['white_ip'] ?? '' }}</textarea>
                    <p class="mt-1.5 text-xs text-gray-400">Only one IP address is currently supported.</p>
                </div>

                <div>
                    <label for="remark" class="mb-2 block text-sm font-medium text-gray-700">Remark</label>
                    <input type="text" id="remark" name="remark" value="{{ $old['remark'] ?? '' }}" placeholder="this is optional" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                </div>

                <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}">

                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-gray-400">Restrict API access when possible.</p>
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto">
                        Create Secret
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
