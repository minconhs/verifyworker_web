@extends('member_setting.layout')

@section('title', 'Notice Settings')

@section('main')
    <section class="border border-gray-200 bg-white rounded-lg">
        <div class="border-b border-gray-100 px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-medium text-gray-900">Notification Settings</h3>
                    <p class="text-sm text-gray-500">Choose how account and task notifications are delivered</p>
                </div>
            </div>
        </div>

        <form method="POST" class="max-w-3xl space-y-6 px-5 py-5">
            <div class="space-y-6">
                <section>
                    <h4 class="mb-3 text-sm font-medium text-gray-900">Notification Channels</h4>
                    <div class="space-y-3">
                        <label class="flex items-center justify-between gap-4 rounded-lg border border-gray-200 bg-white p-4">
                            <span class="min-w-0">
                                <span class="block text-sm font-medium text-gray-900">Email</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Send notices to your account email</span>
                            </span>
                            <span class="relative flex items-center justify-center w-4 h-4">
                                <input type="hidden" name="channel_email" value="0">
                                <input type="checkbox" name="channel_email" value="1" class="peer appearance-none w-4 h-4 border border-gray-300 rounded checked:bg-cyan-500 checked:border-cyan-500 focus:outline-none" {{ $setting->channel_email ? 'checked' : '' }}>
                                <svg viewBox="0 0 14 14" class="absolute w-4 h-4 text-white invisible peer-checked:visible" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8L6 11L11 3.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                        </label>
                    </div>
                </section>

                <section>
                    <h4 class="mb-3 text-sm font-medium text-gray-900">Notice Types</h4>
                    <div class="divide-y divide-gray-100 rounded-lg border border-gray-200">
                        <label class="flex items-center justify-between gap-4 p-4">
                            <span class="min-w-0">
                                <span class="block text-sm font-medium text-gray-900">Security alerts</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Password, email, API key, and login activity</span>
                            </span>
                            <span class="relative flex items-center justify-center w-4 h-4">
                                <input type="hidden" name="notice_security" value="0">
                                <input type="checkbox" name="notice_security" value="1" class="peer appearance-none w-4 h-4 border border-gray-300 rounded checked:bg-cyan-500 checked:border-cyan-500 focus:outline-none" {{ $setting->notice_security ? 'checked' : '' }}>
                                <svg viewBox="0 0 14 14" class="absolute w-4 h-4 text-white invisible peer-checked:visible" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8L6 11L11 3.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                        </label>

                        <label class="flex items-center justify-between gap-4 p-4">
                            <span class="min-w-0">
                                <span class="block text-sm font-medium text-gray-900">Product releases</span>
                                <span class="block text-xs text-gray-500 mt-0.5">New features, API updates, and platform improvements</span>
                            </span>
                            <span class="relative flex items-center justify-center w-4 h-4">
                                <input type="hidden" name="notice_product" value="0">
                                <input type="checkbox" name="notice_product" value="1" class="peer appearance-none w-4 h-4 border border-gray-300 rounded checked:bg-cyan-500 checked:border-cyan-500 focus:outline-none" {{ $setting->notice_product ? 'checked' : '' }}>
                                <svg viewBox="0 0 14 14" class="absolute w-4 h-4 text-white invisible peer-checked:visible" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8L6 11L11 3.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                        </label>

                        <label class="flex items-center justify-between gap-4 p-4">
                            <span class="min-w-0">
                                <span class="block text-sm font-medium text-gray-900">Policy changes</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Terms, privacy, pricing, and account rule updates</span>
                            </span>
                            <span class="relative flex items-center justify-center w-4 h-4">
                                <input type="hidden" name="notice_policy" value="0">
                                <input type="checkbox" name="notice_policy" value="1" class="peer appearance-none w-4 h-4 border border-gray-300 rounded checked:bg-cyan-500 checked:border-cyan-500 focus:outline-none" {{ $setting->notice_policy ? 'checked' : '' }}>
                                <svg viewBox="0 0 14 14" class="absolute w-4 h-4 text-white invisible peer-checked:visible" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8L6 11L11 3.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                        </label>

                        <label class="flex items-center justify-between gap-4 p-4">
                            <span class="min-w-0">
                                <span class="block text-sm font-medium text-gray-900">Event notices</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Campaigns, rewards, promotions, and community events</span>
                            </span>
                            <span class="relative flex items-center justify-center w-4 h-4">
                                <input type="hidden" name="notice_event" value="0">
                                <input type="checkbox" name="notice_event" value="1" class="peer appearance-none w-4 h-4 border border-gray-300 rounded checked:bg-cyan-500 checked:border-cyan-500 focus:outline-none" {{ $setting->notice_event ? 'checked' : '' }}>
                                <svg viewBox="0 0 14 14" class="absolute w-4 h-4 text-white invisible peer-checked:visible" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8L6 11L11 3.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                        </label>
                    </div>
                </section>
            </div>

            <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}">

            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-gray-400">Notification preferences apply to future messages.</p>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto cursor-pointer">
                    Save Settings
                </button>
            </div>
        </form>
    </section>
@endsection
