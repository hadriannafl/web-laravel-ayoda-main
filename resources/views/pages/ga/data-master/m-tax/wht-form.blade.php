<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New WHT Type 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form action="{{route('wht.create')}}" method="post">
                @csrf
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name_wht">WHT Name<span
                        class="text-rose-500">*</span></label>
                    <input id="name_wht" name="name_wht" type="text" class="name_wht form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="rate">WHT Rate<span
                        class="text-rose-500">*</span></label>
                    <input id="rate" name="rate" class="rate form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" maxlength="4" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="norma">Norma Rate<span
                        class="text-rose-500">*</span></label>
                    <input id="norma" name="norma" class="norma form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" maxlength="4" required/>
                </div>

                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create WHT Type</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
</x-app-layout>