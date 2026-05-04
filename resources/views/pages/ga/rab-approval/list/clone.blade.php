<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Clone RAB Request 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('rab-list.clone', ['rabId' => $dataRab->idrec]) }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row" hidden>
                    <label class="text-sm font-medium mb-1" for="idRab">RAB #</label>
                    <input id="idRab" name="idRab" value="{{$dataRab->id_rab}}"
                        class="idRab form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1" for="rabName">RAB Title<span
                        class="text-rose-500">*</span></label>
                    <input id="rabName" name="rabName" value="{{$dataRab->name_rab}}"
                        class="rabName form-input w-full md:w-3/4 px-2 py-1" minlength="10" type="text" maxlength="100" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="formDate">Form Date<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1 ml-2">:</label>
                    <input id="formDate" name="formDate" value="{{date('Y-m-d')}}"
                        class="formDate selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="periode">RAB Period<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1">:</label>
                    <input id="periode" name="periode" value="{{date('Y-m-d')}}"
                        class="periode selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>

                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Clone RAB Request</span>
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