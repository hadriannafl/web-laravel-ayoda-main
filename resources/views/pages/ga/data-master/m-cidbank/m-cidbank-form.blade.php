<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Bank CID 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form action="{{route('cidbank.create')}}" enctype="multipart/form-data" method="post">
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
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id_bank">Bank<span
                        class="text-rose-500">*</span></label>
                    <select style="width: 66rem;" id="id_bank" name="id_bank" class="id_bank form-select w-full px-2 py-1" required>
                        <option value="" selected>Select Bank</option>
                        @foreach ($bank as $bank)
                            <option value="{{$bank->id_bank}}">{{$bank->name}}</option>
                        @endforeach
                    </select>  
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="cidbank">Bank CID<span
                        class="text-rose-500">*</span></label>
                    <input id="cidbank" name="cidbank" type="text" class="cidbank form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="bank_acc">Bank Account<span
                        class="text-rose-500">*</span></label>
                    <input id="bank_acc" name="bank_acc" type="text" class="bank_acc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="acc_holder">Bank Account Holder<span
                        class="text-rose-500">*</span></label>
                    <input id="acc_holder" name="acc_holder" type="text" class="acc_holder form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="pv_code">PV Code</label>
                    <input id="pv_code" name="pv_code" type="text" class="pv_code form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"/>
                </div>

                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Create CID Bank</span>
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