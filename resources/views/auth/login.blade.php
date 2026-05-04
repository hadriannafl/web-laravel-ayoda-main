<x-authentication-layout>
    <h1 class="text-3xl text-slate-800 font-bold mb-6">Welcome to {{ $CRM_ISS->nilai }}✨</h1>
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif   
    <!-- Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="email" name="email" :value="old('email')" required autofocus />                
            </div>
            <div>
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" type="password" name="password" required autocomplete="current-password" />                
            </div>
            {{-- <div>
                <input type="checkbox" name="remember" id="remember"/> 
                <label for="remember-me">Remember me</label>
            </div> --}}
        </div>
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <div class="mr-1">
                    <a class="text-sm underline hover:no-underline" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                </div>
            @endif            
            <x-jet-button class="ml-3">
                {{ __('Sign in') }}
            </x-jet-button>            
        </div>
    </form>
    <x-jet-validation-errors class="mt-4"/>    
    <!-- Demo Login -->
    <div class="pt-5 mt-6 border-t border-slate-200">
        <p class="text-sm text-slate-500 mb-3 text-center">Coba demo aplikasi ini:</p>
        <div class="flex gap-2">
            <button type="button" onclick="fillDemo('demo@ayoda.com','demo1234')"
                class="w-full py-2 px-3 text-sm font-medium rounded border border-indigo-300 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                Demo Admin
            </button>
            <button type="button" onclick="fillDemo('sales@ayoda.com','demo1234')"
                class="w-full py-2 px-3 text-sm font-medium rounded border border-emerald-300 text-emerald-600 bg-emerald-50 hover:bg-emerald-100 transition">
                Demo Sales
            </button>
        </div>
    </div>
    <script>
        function fillDemo(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
    {{-- <center>
        <a class="btn form-input w-full bg-indigo-500 hover:bg-indigo-600 text-white text-xs mb-3" href="{{ route('tracking') }}">
            <span class="ml-2 text-xl">Update Delivery Order</span>
        </a>
    </center> --}}
</x-authentication-layout>
