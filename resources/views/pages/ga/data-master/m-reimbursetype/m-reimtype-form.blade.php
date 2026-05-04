<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Master Reimbursement Type 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form action="{{route('reimburse-type.create')}}" method="post">
                @csrf
                        <div class="flex justify-between flex-col md:flex-row">
                            <label class="block text-sm font-medium mb-1" for="type">Reimbursement Type Name<span
                                    class="text-rose-500">*</span></label>
                            <input id="type" name="type" type="text"
                                class="type form-input w-full md:w-3/4 px-2 py-1"
                                required/>
                        </div>
                        <div class="flex justify-between flex-col md:flex-row mt-3">
                            <label class="block text-sm font-medium mb-1" for="coa">Chart Of Account (COA)<span
                                    class="text-rose-500">*</span></label>
                            <input id="coa" name="coa"
                                class="coa form-input w-full md:w-3/4 px-2 py-1" required/>
                        </div>
                
                    <center>
                        <button type="submit" id="submit" class="btn-sm bg-emerald-500 hover:bg-emerald-600 text-white mt-5">Create</button>
                    </center>
            </form>
        </div>
    </div>

</div>
</x-app-layout>