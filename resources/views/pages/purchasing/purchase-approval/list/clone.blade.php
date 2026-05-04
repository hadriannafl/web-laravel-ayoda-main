<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Clone Purchase Request 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('purchase-list.clone', ['idPR' => $dataPR->idrec]) }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="idRab">RAB # :</label>
                    <input id="idRab" name="idRab" value="{{$dataPR->idreqform}}"
                        class="idRab form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1" for="date">PR Title<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1 ml-9">:</label>
                    <input id="pr_title" name="pr_title" value="{{$dataPR->pr_title}}" class="pr_title form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="date">PR Date<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1 ml-9">:</label>
                    <input id="date" name="date" value="{{date('Y-m-d')}}"
                        class="date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="req">Delivery Date<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1 ml-9">:</label>
                    <input id="req" name="req" value="{{date('Y-m-d')}}"
                        class="req selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>

                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Clone Purchase Request</span>
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