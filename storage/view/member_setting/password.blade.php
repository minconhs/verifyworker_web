@extends('member_setting.layout')

@section('title', 'Change Password')

@section('main')
    <section class="border border-gray-200 bg-white rounded-lg">
        <div class="border-b border-gray-100 px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-medium text-gray-900">Change Password</h3>
                    <p class="text-sm text-gray-500">Change your account password regularly to keep your account secure.</p>
                </div>
            </div>
        </div>
        <form method="POST" class="max-w-2xl space-y-5 px-5 py-5">
            <div class="space-y-5">
                <!-- Current Password -->
                <div class="grid grid-cols-1 gap-2">
                    <div>
                        <label for="old_password" class="mb-2 block text-sm font-medium text-gray-700">Old Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="old_password" placeholder="Enter old password" value="{{ $old['old_password'] ?? '' }}" class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>
                    </div>
                    <div class="ml-1">
                        <p class="text-xs text-gray-400">Please enter your old password to confirm your identity before changing to a new password.</p>
                    </div>
                </div>
                <!-- New Password -->
                <div class="grid grid-cols-1 gap-2">
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-700">New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password" placeholder="Enter new password" class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>
                    </div>
                    <div class="ml-1">
                        <p class="text-xs text-gray-400">For added security, your new password should be at least 8 characters long, and ideally include both letters and numbers.</p>
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div class="grid grid-cols-1 gap-2">
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password_confirmation" placeholder="Confirm new Password" class="w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>
                    </div>
                    <div class="ml-1">
                        <p class="text-xs text-gray-400">Please re-enter the new password to confirm it. This helps prevent typos and ensures you remember the new password correctly.</p>
                    </div>
                </div>
            </div>

            <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}">

            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-gray-400">You may need to sign in again after changing your password.</p>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto cursor-pointer">
                    Save Changes
                </button>
            </div>
        </form>
    </section>
@endsection
