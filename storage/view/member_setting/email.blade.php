@extends('member_setting.layout')

@section('title', 'Change Email')

@section('main')
    <section class="border border-gray-200 bg-white rounded-lg">
        <div class="border-b border-gray-100 px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-medium text-gray-900">Email Address</h3>
                    <p class="text-sm text-gray-500">Update your email address for account notifications and password recovery</p>
                </div>
            </div>
        </div>
        <form method="POST" class="max-w-2xl space-y-5 px-5 py-5">
            <div class="space-y-5">
                <!-- Current Email -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Current Email</label>
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $member->email }}</p>
                        </div>
                    </div>
                </div>
                <!-- New Email -->
                <div class="grid grid-cols-1 gap-2 mt-4">
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-700">New Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" placeholder="Enter new email address" value="{{ $old['email'] ?? '' }}" class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>
                    </div>
                    <div class="ml-1">
                        <p class="text-xs text-gray-400">We'll send a verification code to this email address to confirm the change.</p>
                    </div>
                </div>

                <!-- Login Password Confirmation -->
                <div class="grid grid-cols-1 gap-2 mt-4">
                    <div>
                        <label for="email_change_password" class="mb-2 block text-sm font-medium text-gray-700">Login Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password" placeholder="Enter your login password to confirm" class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>
                    </div>
                    <div class="ml-1">
                        <p class="text-xs text-gray-400">This is required to verify your identity and prevent unauthorized email changes.</p>
                    </div>
                </div>
            </div>

            <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}">

            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-gray-400">A confirmation step may be required after submitting.</p>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto cursor-pointer">
                    Send Reset Link
                </button>
            </div>
        </form>
    </section>
@endsection
