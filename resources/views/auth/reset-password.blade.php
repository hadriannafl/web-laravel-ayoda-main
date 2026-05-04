<x-authentication-layout>
    <x-jet-validation-errors class="mb-4" />
    <h1 class="text-3xl text-slate-800 font-bold mb-6">{{ __('New Password') }} ✨</h1>
    <form method="POST" action="{{ route('update.password') }}">
        @csrf

        <input type="hidden" name="token" value="{{ request()->get('token') }}">

        {{-- <div class="block">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
        </div> --}}

        <div class="mt-4">
            <x-jet-label for="password" value="{{ __('Password') }}" />
            <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" minlength="8" required
            pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}" title="Password harus mengandung kombinasi huruf kapital, huruf kecil, angka dan simbol"/>
        </div>

        <div class="mt-4">
            <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" minlength="8" required
            pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}" title="Password harus mengandung kombinasi huruf kapital, huruf kecil, angka dan simbol"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button>
                {{ __('Reset Password') }}
            </x-jet-button>
        </div>
    </form>
</x-authentication-layout>
