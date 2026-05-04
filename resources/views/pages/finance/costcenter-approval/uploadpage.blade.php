<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            @if ($dataCC->approvalstat == 'Payment Proof' || $dataCC->approvalstat == 'Form Printed')
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Upload Cost Center Payment 📝</h1>
            @else
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit Cost Center Payment 📝</h1>
            @endif
        </div>
        @if ($dataCC->cost_file != null)
            <div class="py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('cost-list.costfile', ['idCC' => $dataCC->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Cost Center</a>
                </div>
            </div>
        @endif
        <form action="{{ route('cost-list.submitpay', ['idCC' => $dataCC->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="grid md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1"
                            for="id">Cost Center Form #</label>
                        <input id="id" class="form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->idreqform}}" disabled readonly/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1"
                            for="date">Request Date</label>
                        <input id="date" class=" form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{date('d F Y', strtotime($dataCC->datereq))}}" disabled readonly/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Applicant</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->applicant}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Company</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->company}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Description</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->department}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Currency</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->currency}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Payment To Beneficiary By</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->bank}}" disabled readonly />
                    </div>
                    @if ($dataCC->bank != 'Cash')
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Bank Account</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->number_account}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Beneficiary Account Name</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->name_account}}" disabled readonly />
                    </div>
                    @endif
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Notes/ToP</label>
                    <textarea rows="3" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                    type="text" disabled readonly>{{$dataCC->note}}</textarea>
                </div>
                @if ($dataCC->payment_file != null)
                    <div class="flex md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1 mt-2" for="remarks1">Cost Center Payment Uploaded</label>
                        <a href="{{ route('cost-list.paymentfile', ['idCC' => $dataCC->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Cost Center Payment Uploaded</a>
                    </div>
                @endif
                <ul class="mt-3" x-data="{ open: {{ in_array(Request::segment(1), ['#0']) ? 1 : 0 }} }">
                    <a class="block text-sm font-medium truncate transition duration-150 @if(in_array(Request::segment(1), ['#0'])){{ 'hover:text-indigo-500' }}@endif"
                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex justify-center">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">View More Detail</span>
                                </div>
                                <!-- Icon -->
                                <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 mt-1">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                    </a>
                        <div class="">
                            <ul class="mt-3 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Status Request</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="{{$dataCC->approvalstat}}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Approved 1 By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="{{$dataCC->approved1by}}" disabled
                                            readonly />
                                    </div>
                                    {{-- <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Approved 2 By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="{{$dataCC->approved2by}}" disabled
                                            readonly />
                                    </div> --}}
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approved 1 Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="{{$dataCC->approval1_date}}" disabled readonly />
                                    </div>
                                    {{-- <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approved 2 Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="{{$dataCC->approval2_date}}" disabled readonly />
                                    </div> --}}
                                    @if ($dataCC->approvalstat == 'Complete')
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Payment Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="{{$dataCC->payment_date}}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Payment Proof By</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="{{$dataCC->payment_proof_by}}" disabled readonly />
                                    </div>
                                        @if ($dataCC->payment_proof_by != 'Cash')
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="approve1_stat">Bank Name</label>
                                            <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                                type="text" value="{{$dataCC->proof_bank_name}}" disabled readonly />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="approve1_stat">Acc# / Transfer Reff# / Cheque# / Giro#</label>
                                            <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                                type="text" value="{{$dataCC->transfer_number}}" disabled readonly />
                                        </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Remarks 1</label>
                                    <textarea rows="3" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                    type="text" disabled readonly>{{$dataCC->remarks1}}</textarea>
                                </div>
                                {{-- <div>
                                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Remarks 2</label>
                                    <textarea rows="3" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                    type="text" disabled readonly>{{$dataCC->remarks2}}</textarea>
                                </div> --}}
                            </ul>
                        </div>
                </ul>
                    <div class="mt-3">
                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Cost Center Detail</label>
                    </div>
                    <table class="table table-striped table-bordered mt-2 mb-2" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-xs text-center">Date</th>
                                <th class="text-xs text-center">Cost Type</th>
                                <th class="text-xs text-center">Reff #</th>
                                <th class="text-xs text-center">Description</th>
                                <th class="text-xs text-center">Subtotal</th>
                                <th class="text-xs text-center">VAT Type</th>
                                <th class="text-xs text-center">VAT</th>
                                <th class="text-xs text-center">WHT Type</th>
                                <th class="text-xs text-center">WHT</th>
                                <th class="text-xs text-center">Cost Total</th>
                                <th class="text-xs text-center">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">
                            @foreach ($CCDetail as $item)
                                <tr>
                                    <td class="text-xs text-center">{{$item->date}}</td>
                                    <td class="text-xs text-left">{{$item->cost_type}}</td>
                                    @if ($item->invoice_number == 'null')
                                    <td></td>
                                    @else
                                    <td class="text-xs text-center">{{$item->invoice_number}}</td>
                                    @endif
                                    <td class="text-xs text-left">{{$item->desc}}</td>
                                    <td class="text-xs text-right">{{number_format($item->subtotal, 0, ',', '.')}}</td>
                                    <td class="text-xs text-left">{{$item->vat}}</td>
                                    <td class="text-xs text-right">{{number_format($item->total_vat, 0, ',', '.')}}</td>
                                    <td class="text-xs text-left">{{$item->wht}}</td>
                                    <td class="text-xs text-right">{{number_format($item->total_wht, 0, ',', '.')}}</td>
                                    <td class="text-xs text-right">{{number_format($item->paid_total, 0, ',', '.')}}</td>
                                    @if ($item->remarks == 'null')
                                    <td></td>
                                    @else
                                    <td class="text-xs text-left">{{$item->remarks}}</td>
                                    @endif
                                </tr>
                            @endforeach
                            <tr class="grandTotalRow">
                                <td class="text-center font-bold text-sm" colspan="6">Grand Total Cost Center</td>
                                <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCC->total_vat, 0, ',', '.')}}</td>
                                <td></td>
                                <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCC->total_wht, 0, ',', '.')}}</td>
                                <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCC->gtotal, 0, ',', '.')}}</td>
                                <td></td>
                            </tr>
                            @if ($dataCC->approved_total != null)
                            <tr class="grandTotalRow">
                                <td class="text-center font-bold text-sm" colspan="6">Cost Paid</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right font-bold text-sm">{{number_format($dataCC->approved_total, 0, ',', '.')}}</td>   
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="flex flex-row mt-3" hidden>
                        <label class="block w-full md:w-3/4 text-sm font-medium mb-1" for="approve1_stat">Grand Total Cost Center</label>
                        <input id="approve1_stat" class="approve1_stat form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200 text-right"
                            type="text" value="{{number_format($dataCC->gtotal, 0, ',', '.')}}"readonly />
                    </div>

                <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="payment_date">Payment Date<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="payment_date" name="payment_date" value="{{date('Y-m-d')}}"
                    class="payment_date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                    required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="payment_proof_by">Payment To Beneficiary By<span
                        class="text-rose-500">*</span></label>
                    <select id="payment_proof_by" name="payment_proof_by" class="payment_proof_by form-select w-full md:w-3/4 px-2 py-1" type="text" required>
                        <option value="" hidden>Select Type</option>
                        <option value="Cash">Cash</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Cheque/Giro">Cheque/Giro</option>
                        {{-- @foreach ($bank as $bankir )
                            <option value="{{$bankir->id_bank}}">{{$bankir->name}}</option>
                        @endforeach --}}
                    </select>
                    
                </div>
                <div id="bankirs" hidden>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="proof_bank_name">Bank Name<span
                            class="text-rose-500">*</span></label>
                        <input id="proof_bank_name" name="proof_bank_name"
                            class="proof_bank_name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="transfer_number">Acc# / Transfer Reff# / Cheque# / Giro#<span
                            class="text-rose-500">*</span></label>
                        <input id="transfer_number" name="transfer_number"
                            class="transfer_number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                    </div>
                </div>

                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file45">Upload Cost Payment<span
                        class="text-rose-500">*</span></label>
                    <input id="file45" name="file45" class="file45 form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf" required/>
                </div>

                @if ($dataCC->approvalstat == "Payment Proof" || $dataCC->approvalstat == "Form Printed" || $dataCC->approvalstat == "Complete")
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Submit Cost Payment</span>
                </button> </center>
                @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $('#payment_proof_by').on('change', function () {
            const bank = $(this).val();

            if (bank == "Cash") {
                $('#bankirs').attr('hidden', true);
                $('#proof_bank_name').attr('required', false);
                $('#transfer_number').attr('required', false);
            }else{
                $('#bankirs').attr('hidden', false);
                $('#proof_bank_name').attr('required', true);
                $('#transfer_number').attr('required', true);
            }
        })
    </script>
    @endsection
</x-app-layout>