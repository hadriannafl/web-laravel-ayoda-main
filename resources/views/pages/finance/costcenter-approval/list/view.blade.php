<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">View Cost Center 📝</h1>
        </div>
        @if ($dataCC->cost_file != null)
            <div class="py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('cost-list.costfile', ['idCC' => $dataCC->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Cost Center</a>
                    @if ($dataCC->dp_file != null)
                    <a href="{{ route('cost-list.costfiledp', ['idCC' => $dataCC->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Previous DP</a>
                    @endif
                </div>
            </div>
        @endif
        <div class="flex flex-row mb-3 mt-3">
            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Cost Center Form # / Form Date / Due Date</label>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->idreqform}}" readonly/>
                </div>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataCC->datereq))}}" readonly>
                </div>
                <div>
                    <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataCC->due_date))}}" readonly/>
                </div>
        </div>
        <div class="flex flex-row mb-3 mt-3">
            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Applicant / Payable Name / Company</label>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->username}}" readonly/>
                </div>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->applicant}}" readonly>
                </div>
                <div>
                    <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->company}}" readonly/>
                </div>
        </div>
        <div class="flex flex-row mb-3 mt-3">
            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Cost Center Description</label>
                <div style="width: 65.3rem; margin-right: 30px;">
                    <input class="departmentName form-input w-full px-2 py-1 read-only:bg-slate-200" id="departmentName" name="departmentName" value="{{$dataCC->department}}" readonly/>
                </div>
        </div>
        <div class="flex flex-row mb-3 mt-3">
            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Bank / Account / Name</label>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataCC->bank}}" type="text" readonly/>
                </div>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->number_account}}" readonly>
                </div>
                <div>
                    <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->name_account}}" readonly/>
                </div>
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
        {{-- <ul class="mt-3" x-data="{ open: {{ in_array(Request::segment(1), ['#0']) ? 1 : 0 }} }">
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
                            <div>
                                <label class="block text-sm font-medium mb-1" for="currency">Approved 2 By</label>
                                <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                    type="text" value="{{$dataCC->approved2by}}" disabled
                                    readonly />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="approve1_stat">Approved 1 Date</label>
                                <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                    type="text" value="{{$dataCC->approval1_date}}" disabled readonly />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="approve1_stat">Approved 2 Date</label>
                                <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                    type="text" value="{{$dataCC->approval2_date}}" disabled readonly />
                            </div>
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
                        <div>
                            <label class="block text-sm font-medium mb-1 text-left" for="notes">Remarks 2</label>
                            <textarea rows="3" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                            type="text" disabled readonly>{{$dataCC->remarks2}}</textarea>
                        </div>
                    </ul>
                </div>
        </ul> --}}
            <div class="mt-3">
                <label class="block text-sm font-medium mb-1 text-left" for="notes">Cost Center Detail</label>
            </div>
            <table class="table table-bordered mt-2 mb-2" style="width:100%">
                <thead>
                    <tr class="bg-slate-400">
                        <th class="text-xs text-center">Date</th>
                        <th class="text-xs text-center">Cost Type</th>
                        <th class="text-xs text-center">Reff #</th>
                        <th class="text-xs text-center">Description</th>
                        <th class="text-xs text-center">Qty</th>
                        <th class="text-xs text-center">Unit Price</th>
                        <th class="text-xs text-center">Forex</th>
                        <th class="text-xs text-center">Price</th>
                        <th class="text-xs text-center">Invoice Amount</th>
                        <th class="text-xs text-center">VAT Type</th>
                        <th class="text-xs text-center">VAT</th>
                        <th class="text-xs text-center">WHT Type</th>
                        <th class="text-xs text-center">WHT</th>
                        <th class="text-xs text-center">Amount Paid</th>
                    </tr>
                </thead>
                <tbody class="tableProductAddBody" id="tableProductAddBody">
                    {{-- @foreach ($CCDetail as $item)
                        <tr>
                            <td class="text-xs text-center">{{$item->date}}</td>
                            <td class="text-xs text-left">{{$item->cost_type}}</td>
                            @if ($item->invoice_number == 'null')
                            <td></td>
                            @else
                            <td class="text-xs text-center">{{$item->invoice_number}}</td>
                            @endif
                            <td class="text-xs text-left">{{$item->desc}}</td>
                            <td class="text-xs text-right">{{number_format($item->qty, 2, ',', '.')}}</td>
                            <td class="text-xs text-right">{{$item->currency}} {{number_format($item->unit_price, 2, ',', '.')}}</td>
                            <td class="text-xs text-right">{{number_format($item->forex, 0, ',', '.')}}</td>
                            <td class="text-xs text-right">{{number_format($item->price, 2, ',', '.')}}</td>
                            <td class="text-xs text-right">{{number_format($item->subtotal, 0, ',', '.')}}</td>
                            <td class="text-xs text-left">{{$item->vat}}</td>
                            <td class="text-xs text-right">{{number_format($item->total_vat, 0, ',', '.')}}</td>
                            <td class="text-xs text-left">{{$item->wht}}</td>
                            <td class="text-xs text-right">{{number_format($item->total_wht, 0, ',', '.')}}</td>
                            <td class="text-xs text-right">{{number_format($item->paid_total, 0, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    <tr class="totalRow">                    
                        @if ($dataCC->dp_amount != 0)
                        <td class="text-center font-bold text-sm" colspan="8">Total Cost Center</td>
                        @else
                        <td class="text-center font-bold text-sm" colspan="8">Grand Total Cost Center</td>
                        @endif
                        <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCC->subtotal, 0, ',', '.')}}</td>
                        <td></td>
                        <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCC->total_vat, 0, ',', '.')}}</td>
                        <td></td>
                        <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCC->total_wht, 0, ',', '.')}}</td>
                        <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCC->gtotal, 0, ',', '.')}}</td>
                    </tr>
                    @if ($dataCC->dp_amount != 0)
                    <tr class="DPRow">
                        <td class="text-center font-bold text-sm" colspan="8">Previous DP</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right font-bold text-sm" id="previousDP_text">-{{number_format($dataCC->dp_amount, 0, ',', '.')}}</td>
                    </tr>
                    <tr class="gradTotalRow">
                        <td class="text-center font-bold text-sm" colspan="8">Grand Total Cost Center</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right font-bold text-sm" id="grandeTotal_text">{{number_format($dataCC->grandeTotal, 0, ',', '.')}}</td>
                    </tr>
                    @endif --}}
                    {{-- @if ($dataCC->approved_total != null)
                    <tr class="grandTotalRow">
                        <td class="text-center font-bold text-sm" colspan="9">Cost Paid</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right font-bold text-sm">{{number_format($dataCC->approved_total, 0, ',', '.')}}</td>  
                    </tr>
                    @endif --}}
                </tbody>
            </table>
            <div class="flex flex-row mt-3" hidden>
                <label class="block w-full md:w-3/4 text-sm font-medium mb-1" for="approve1_stat">Grand Total Cost Center</label>
                <input id="approve1_stat" class="approve1_stat form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200 text-right"
                    type="text" value="{{number_format($dataCC->gtotal, 0, ',', '.')}}"readonly />
            </div>
            <div class="grid md:grid-cols-3 gap-3 mt-3">
                
            </div>
        </div>
    </div>

    @section('js-page')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$CCDetail?>;
        let tableRow = '';
        for (const value of dataProducts) {
            // var iden = makeid(3);
            var iden = dataProducts.indexOf(value);

            const prods = <?=$CCDetail?>;

            tableRow += `<tr id=row-${iden} class="text-xs">
                            <td class="text-right"><span id="date-text_${iden}">${value.date}</span><input type="text" name="idrecss_${iden}" value="${value.id}" hidden/><input type="text" name="iden[]" value="${iden}" hidden/></td>
                            <td><span id="type-text_${iden}">${value.cost_type}</span><input type="text" name="idreqform_${iden}" value="${value.idreqform}" hidden/><input type="text" name="date_${iden}" id="date_${iden}" value="${value.date}" hidden/><input type="text" name="types_${iden}" id="types_${iden}" value="${value.type}" hidden/></td>
                            <td class="text-center"><input type="text" name="plate_${iden}" id="plate_${iden}" value="${value.invoice_number}" hidden/><span id="plate-text_${iden}">${value.invoice_number === 'null' ? '' : (value.invoice_number || '')}</span></td>
                            <td><textarea name="reimburse_${iden}" id="reimburse_${iden}" hidden>${value.desc}</textarea><span id="reimburse-text_${iden}">${value.desc}</span></td>
                            <td class="text-right"><input type="text" name="qtys_${iden}" id="qtys_${iden}" value="${value.qty}" hidden/><span id="qtys-text_${iden}">${allinDivider(value.qty)}</span></td>
                            <td class="text-right"><span id="currencys-text_${iden}">${value.currency}</span> <span id="unit_price-text_${iden}">${allinDivider(value.unit_price)}</span><input type="text" name="unit_price_${iden}" id="unit_price_${iden}" value="${value.unit_price}" hidden/></td>
                            <td class="text-right"><span id="forex-text_${iden}">${allinDivider(value.forex)}</span><input type="text" name="forexs_${iden}" id="forexs_${iden}" value="${value.forex}" hidden/><input type="text" name="currencys_${iden}" id="currencys_${iden}" value="${value.currency}" hidden/></td>
                            <td class="text-right"><input type="text" name="prices_${iden}" id="prices_${iden}" value="${value.price}" hidden/><span id="prices-text_${iden}">${allinDivider(value.price)}</span></td>
                            <td class="text-right"><input type="text" name="subtotal1_${iden}" id="subtotal1_${iden}" value="${value.subtotal}" hidden/><span id="subtotal1-text_${iden}">${allinDivider(value.subtotal)}</span><input type="text" name="total1_${iden}" id="total1_${iden}" value="${value.total}" hidden/></td>
                            <td><textarea name="vat_type_${iden}" id="vat_type_${iden}" hidden>${value.vat}</textarea><span id="vat_type-text_${iden}">${value.vat === 'null' ? '' : (value.vat || '')}</span></span><input type="text" name="vat_percent1_${iden}" id="vat_percent1_${iden}" value="${value.vat_percent}" hidden/></td>
                            <td class="text-right"><input type="text" name="total_vat1_${iden}" id="total_vat1_${iden}" value="${value.total_vat}" hidden/><span id="total_vat1-text_${iden}">${allinDivider(value.total_vat)}</span></td>
                            <td><textarea name="wht_type_${iden}" id="wht_type_${iden}" hidden>${value.wht}</textarea><span id="wht_type-text_${iden}">${value.wht === 'null' ? '' : (value.wht || '')}</span></span><input type="text" name="wht_percent1_${iden}" id="wht_percent1_${iden}" value="${value.wht_percent}" hidden/></td>
                            <td class="text-right"><input type="text" name="total_wht1_${iden}" id="total_wht1_${iden}" value="${value.total_wht}" hidden/><span id="total_wht1-text_${iden}">${allinDivider(value.total_wht)}</span><input type="text" name="norma1_${iden}" id="norma1_${iden}" value="${value.norma}" hidden/></td>
                            <td class="text-right"><input type="text" name="paid_total_${iden}" id="paid_total_${iden}" value="${value.paid_total}" hidden/><span id="paid_total-text_${iden}">${allinDivider(value.paid_total)}</span><textarea name="status_${iden}" id="status_${iden}" hidden>${value.status}</textarea></td>
                    
           </tr>`;
        }
        $("#tableProductAddBody").append(tableRow);
        var totalRow = `<tr class="totalRow bg-slate-400">
            <td class="text-center font-bold text-lg" colspan="8">Total Cost Center</td>
            <td class="text-right font-bold text-lg" id="subtotal_text">{{number_format($dataCC->subtotal, 0, ',', '.')}}</td>
            <td></td>
            <td class="text-right font-bold text-lg" id="vatTotal_text">{{number_format($dataCC->total_vat, 0, ',', '.')}}</td>
            <td></td>
            <td class="text-right font-bold text-lg" id="whtTotal_text">{{number_format($dataCC->total_wht, 0, ',', '.')}}</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text">{{number_format($dataCC->gtotal, 0, ',', '.')}}</td>
        </tr>`;
        $("#tableProductAddBody").append(totalRow);
        var DPRow = `<tr class="DPRow bg-slate-400">
            <td class="text-center font-bold text-lg" colspan="8">Previous DP</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right font-bold text-lg" id="previousDP_text"><span id="previousDP_text">-{{number_format($dataCC->dp_amount, 0, ',', '.')}}</span></td>
        </tr>`;
        $("#tableProductAddBody").append(DPRow);
        var gradTotalRow = `<tr class="gradTotalRow bg-slate-400">
            <td class="text-center font-bold text-lg" colspan="8">Grand Total Cost Center</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right font-bold text-lg" id="grandeTotal_text"><span id="grandeTotal_text">{{number_format($dataCC->grandeTotal, 0, ',', '.')}}</span></td>
        </tr>`;
        $("#tableProductAddBody").append(gradTotalRow);
    </script>
    @endsection
</x-app-layout>