<x-authentication-layout>
    <h1 class="flex flex-row">
        <a href = '/'><img src="{{ asset('images/left-arrow.png') }}" width="100" height="50" alt="Task 01" class="pointer"></a> 
        <a class="text-sm text-slate-800 font-bold mt-10 ml-3" href = '/'>Back to Login Page</a>
    </h1>
    <h1 class="text-3xl text-slate-800 font-bold mb-6">{{ __('Reset your Password') }}</h1>
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif
    <!-- Form -->
    <form method="POST" action="{{ route('forgot.password') }}">
        @csrf
        <div>
            <x-jet-label for="email">{{ __('Email Login') }}<span class="text-rose-500">*</span></x-jet-label>
            <x-jet-input id="email" type="email" name="email" :value="old('email')" required autofocus />                
        </div>
        <div class="flex justify-end mt-6">
            <x-jet-button>
                {{ __('Send Reset Link') }}
            </x-jet-button>
        </div>
    </form>
    {{-- @php
        // Ambil token dari parameter URL
        $resetToken = isset($resetToken) ? $resetToken : request()->query('token');
        $checkToken = DB::table('reset_password')->select('is_active', 'expired_at')->where('token', $resetToken)->first();
    @endphp

    @if ($checkToken && $checkToken->is_active === 0)
        <script>
            Swal.fire({
                title: 'Success',
                text: 'Successfully Reset Password',
                icon: 'success',
                confirmButtonText: 'Oke'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/';
                }
            });
        </script>
    @endif --}}
    <x-jet-validation-errors class="mt-4" /> 
</x-authentication-layout>
