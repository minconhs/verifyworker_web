@extends('layouts.main')

@section('title', 'Api Secret')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">API Secret Keys</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">API Secret Keys</h1>
            <p class="text-sm text-gray-500">Manage your API keys, webhooks and IP whitelists.</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <a href="/secret/create" class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/>
                </svg>
                Create Secret
            </a>
            <a href="/console" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Console
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="space-y-6 sm:space-y-8">
        <!-- Filter Section -->
        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-5">
                <h2 class="text-base font-medium text-gray-900">Filter Records</h2>
            </div>
            <form method="get" class="grid gap-4 px-6 py-5 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <label for="code" class="mb-2 block text-sm font-medium text-gray-700">Secret Key</label>
                    <input id="code" name="code" type="text" class="block w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Enter Secret Key" value="{{ $old['code'] ?? '' }}">
                </div>

                <div>
                    <label for="hook_url" class="mb-2 block text-sm font-medium text-gray-700">Hook Url</label>
                    <input id="hook_url" name="hook_url" type="text" class="block w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Enter Hook Url" value="{{ $old['hook_url'] ?? '' }}">
                </div>

                <div>
                    <label for="white_ip" class="mb-2 block text-sm font-medium text-gray-700">White Address</label>
                    <input id="white_ip" name="white_ip" type="text" class="block w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Enter White Address" value="{{ $old['white_ip'] ?? '' }}">
                </div>

                <div class="flex items-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 -mx-6 -mb-5 md:col-span-2 xl:col-span-3">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors bg-cyan-500 text-white hover:bg-cyan-600 cursor-pointer">
                        <svg class="h-4 w-4" width="1em" height="1em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
                        </svg>
                        Search
                    </button>

                    <a href="/secret" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700 cursor-pointer">
                        <svg class="h-4 w-4" width="2em" height="2em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2v2a8 8 0 1 0 5.135 1.865L15 8V2h6l-2.447 2.447A9.98 9.98 0 0 1 22 12" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </section>

        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white" id="secret_section">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Secret Content</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">White Address</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Remark</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($pagination->items() as $item)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-5 py-4">
                                <span class="block font-mono text-xs font-medium text-gray-900">{{ $item->code }}</span>
                                @if(!empty($item->hook_url))
                                    <span class="mt-1 block text-xs text-gray-500">{{ $item->hook_url }}</span>
                                @else
                                    <span class="mt-1 block text-xs text-gray-400">No hook URL</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if($item->white_ip)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-mono rounded-full border bg-gray-50 text-gray-600 border-gray-200">{{ $item->white_ip }}</span>
                                @else
                                    <span class="text-xs text-gray-400 italic">All IPs allowed</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 min-w-50">
                                <span class="inline-flex items-center truncate text-sm text-gray-600">{{ $item->remark ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center">
                                    <a href="/secret/delete/{{ $item->id }}" title="Delete" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-16">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <p class="text-sm font-medium text-gray-900">No API secrets yet</p>
                                    <p class="mt-1 text-sm text-gray-500">Your API keys will appear here after they are created.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between gap-4 border-t border-gray-200 px-6 py-4 text-sm text-gray-500">
                <p>Total {{ $pagination->total() }} records</p>
                @include('components.paginator', ['$pagination' => $pagination])
            </div>
        </section>
    </div>
@endsection
