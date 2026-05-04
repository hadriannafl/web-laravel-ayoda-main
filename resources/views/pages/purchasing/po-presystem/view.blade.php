<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">PO Pre System View 📝</h1>
        </div>
    @if ($dataPO->file != null)
        <div class="px-5 py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <a href="{{ route('po-presystem.viewfile', ['idPO' => $dataPO->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment PO</a>
            </div>
        </div>
    @endif

    <div class="px-5 py-4">
        <div class="space-y-3">
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1"
                        for="company">Company<span
                        class="text-rose-500">*</span>
                    </label>
                        <input id="company" name="company"
                            class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$dataPO->companyName}}" readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1" for="date_po">PO Date<span
                        class="text-rose-500">*</span></label>
                    <input id="date_po" name="date_po" value="{{date('Y-m-d',strtotime( $dataPO->date_po))}}" class="date_po selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" readonly/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="employee1">User Request<span
                        class="text-rose-500">*</span>
                    </label>
                    <input class="employee1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" id="employee1" name="employee1" value="{{$dataPO->first_name}} {{$dataPO->last_name}}" readonly/>
                </div>
                <div id="detail_employee" hidden>
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Department / Position<span
                            class="text-rose-500">*</span></label>
                            <div style="width: 31rem; margin-right: 41px;">
                                <input id="department1" name="department1" class="department1 form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPO->department}}" type="text" readonly/>
                            </div>
                            <div>
                                <input id="division" style="width: 31.7rem;" name="division" class="division form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPO->position}}" type="text" readonly/>
                            </div>
                    </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1">PO # / Invoice # / RAB #<span class="text-rose-500">*</span></label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="no_po" name="no_po" class="no_po form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPO->no_po}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="no_invoice" name="no_invoice" class="no_invoice form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPO->no_invoice}}" readonly/>
                        </div>
                        <div>
                            <input id="no_rab" style="width: 21.2rem;" name="no_rab" class="no_rab form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPO->no_rab}}" type="text" readonly/>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="reff">PO title<span class="text-rose-500">*</span>
                    </label>
                    <input id="po_title" name="po_title" class="po_title form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$dataPO->po_title}}" type="text" readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1"
                        for="idsupplier">Supplier<span
                        class="text-rose-500">*</span>
                    </label>
                        <input id="idsupplier" name="idsupplier" value="{{$dataPO->vendorName}}" class="idsupplier form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" readonly/>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Currency / Exchange Rate<span
                        class="text-rose-500">*</span></label>
                        <div style="width: 31rem; margin-right: 41px;">
                            <input id="currency" name="currency" value="{{$dataPO->currency}}" class="currency form-input w-full px-2 py-1 read-only:bg-slate-200" readonly/>
                        </div>
                        <div>
                            <input id="crate" name="crate" style="width: 31.7rem;" value="{{number_format($dataPO->crate, 0, ',', '.')}}" class="crate form-input numeric-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="1" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1">Total / VAT / Grand Total<span class="text-rose-500">*</span></label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="total" name="total" class="total numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{number_format($dataPO->total, 0, ',', '.')}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="ppn" name="ppn" class="ppn numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{number_format($dataPO->ppn, 0, ',', '.')}}" type="text" readonly/>
                        </div>
                        <div>
                            <input id="gtotal" style="width: 21.2rem;" name="gtotal" class="gtotal numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{number_format($dataPO->gtotal, 0, ',', '.')}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1">WHT / Amount Due<span class="text-rose-500">*</span></label>
                        <div style="width: 31rem; margin-right: 41px;">
                            <input id="wht" name="wht" class="wht numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{number_format($dataPO->wht, 0, ',', '.')}}" readonly/>
                        </div>
                        <div>
                            <input id="amount_due" style="width: 31.7rem;" name="amount_due" class="amount_due numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{number_format($dataPO->amount_due, 0, ',', '.')}}" readonly/>
                        </div>
                </div>
        </div>
    </div>

</div>
@section('js-page')
<script> 
</script>
@endsection
</x-app-layout>