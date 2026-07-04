@extends('member_setting.layout')

@section('title', 'Reset Payment Password')

@section('main')
    <section class="border border-gray-200 bg-white rounded-lg">
        <div class="border-b border-gray-100 px-5 py-4">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                        <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 0 1 2 2m4 0a6 6 0 0 1-7.743 5.743L11 17H9v2H7v2H3v-4.586l6.257-6.257A6 6 0 1 1 21 9Z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-medium text-gray-900">Reset Payment Password</h3>
                        <p class="text-sm text-gray-500">Verify your account email before setting a new payment password.</p>
                    </div>
                </div>
                <a href="/settings/payment-password" class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-cyan-700 sm:w-auto">
                    Back
                </a>
            </div>
        </div>

        <form method="POST" class="max-w-2xl space-y-6 px-5 py-5">
            <div class="rounded-lg bg-blue-50 px-4 py-3">
                <p class="text-xs font-medium uppercase tracking-wide text-cyan-700">Verification Email</p>
                <p class="mt-1 text-sm font-medium text-gray-900">{{ $member->email }}</p>
                <p class="mt-1 text-xs text-gray-500">A verification code will be sent to this email address.</p>
                <a href="/settings/forgot-payment-password/send-code" class="mt-3 inline-flex text-sm font-medium text-cyan-600 transition-colors hover:text-cyan-700">
                    Send verification code
                </a>
            </div>

            <div class="grid grid-cols-1 gap-2">
                <label for="verification_code" class="block text-sm font-medium text-gray-700">Verification Code</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z"/>
                        </svg>
                    </div>
                    <input id="verification_code" type="text" name="verification_code" placeholder="Enter verification code" value="{{ $old['verification_code'] ?? '' }}" class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                </div>
                <p class="ml-1 text-xs text-gray-400">The code is valid for 10 minutes.</p>
            </div>

            <div class="grid grid-cols-1 gap-2">
                <label for="password" class="block text-sm font-medium text-gray-700">New Payment Password</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 0 0-8 0v4m-2 0h12a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2Z"/>
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" placeholder="Enter new payment password" class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Payment Password</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 0 0-8 0v4m-2 0h12a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2Z"/>
                        </svg>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm new payment password" class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                </div>
            </div>

            <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}">

            <div class="flex flex-col gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-gray-400">After resetting your password, please use your new payment password.</p>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto cursor-pointer">
                    Reset Payment Password
                </button>
            </div>
        </form>
    </section>
@endsection
