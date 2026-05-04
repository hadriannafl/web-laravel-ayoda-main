<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New RAB Beneficiary Bank 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form action="{{route('rabbank.create')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="external">Company<span
                        class="text-rose-500">*</span>
                    </label>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                        <select id="company_id" name="company_id"
                            class="company_id form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Company</option>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{$company->id_company}}">{{$company->name}}</option>
                        @endforeach
                        </select>
                    @else
                        <input id="company_id" name="company_id"
                            class="company_id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{ Auth::user()->company_id}}" readonly required hidden/>
                        <input id="companies" name="companies"
                        class="companies form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$dataChildCompany->name}}" required readonly/>
                    @endif
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id_bank">Beneficiary Bank<span
                        class="text-rose-500">*</span></label>
                    <select style="width: 66rem;" id="id_bank" name="id_bank" class="id_bank form-select w-full px-2 py-1" required>
                        <option value="" selected>Select Bank</option>
                        @foreach ($bank as $bank)
                            <option value="{{$bank->id_bank}}">{{$bank->name}}</option>
                        @endforeach
                    </select>  
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="beneficiary_acc">Beneficiary Account<span
                        class="text-rose-500">*</span></label>
                    <input id="beneficiary_acc" name="beneficiary_acc" type="text" class="beneficiary_acc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="beneficiary_name">Beneficiary Account Name<span
                        class="text-rose-500">*</span></label>
                    <input id="beneficiary_name" name="beneficiary_name" type="text" class="beneficiary_name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="desc">Description<span
                        class="text-rose-500">*</span></label>
                    <textarea id="desc" name="desc" type="text" class="desc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3" required></textarea>
                </div>

                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Create Beneficiary Bank</span>
                </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>
    $('#id_bank').select2();
</script>
@endsection
</x-app-layout>