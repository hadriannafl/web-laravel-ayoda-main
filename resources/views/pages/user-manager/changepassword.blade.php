<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Change User Password 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" id="myForm" enctype="multipart/form-data" action="{{ route('user-manager.update1', ['userId' => $dataUser->id]) }}">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1" for="pass1">Old Password<span class="text-rose-500">*</span></label>
                    <input id="pass1" name="pass1" type="password" class="w_name form-input w-full px-2 py-1" minlength="8" required
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+" title="Password harus mengandung kombinasi huruf kapital, huruf kecil, dan angka"/>
                    <span class="text-rose-500">Password must contain capital, lowercase and numbers and min. 8 chars</span>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="pass2">New Password<span class="text-rose-500">*</span></label>
                    <input id="pass2" name="pass2" type="password" class="w_name form-input w-full px-2 py-1" minlength="8" required
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+" title="Password harus mengandung kombinasi huruf kapital, huruf kecil, dan angka"/>
                    <span class="text-rose-500">Password must contain capital, lowercase and numbers and min. 8 chars</span>
                </div>

                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Change Password</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
</script>
@endsection
</x-app-layout>