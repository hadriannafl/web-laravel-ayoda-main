<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Confirm Payment 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('payment-list.confirm', ['payId' => $dataCPDetail->idrec]) }}" id="myForm">
                @csrf
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Form Date / Due Date / Reff #</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->date}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->due_date}}" readonly>
                        </div>
                        <div>
                            <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->id_costpayment}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Form Type / Status / Company</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->form_type}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->status}}" readonly>
                        </div>
                        <div>
                            <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->company}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Bank / Name / Account</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            @if ($dataCP->beneficiary_bank != null)
                                <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataCP->beneficiary_bank}}" type="text" readonly/>
                            @else
                                <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="Cash" type="text" readonly/>
                            @endif
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->beneficiary_name}}" readonly>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->beneficiary_acc}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Total Amount / Total Paid / Balance</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="total_amount" value="{{number_format($dataCP->total_paid, 0, ',', '.')}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="total_paid" value="{{number_format($totalPaid, 0, ',', '.')}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly>
                        </div>
                        <div>
                            <input id="balance" value="{{number_format($dataCP->balance, 0, ',', '.')}}" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                            <input id="balancex" value="{{number_format($dataCP->balance, 0, '', '')}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly>
                            <input id="balance_whtt" value="{{number_format($dataCP->balance_wht, 0, '', '')}}" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly/>
                        </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium"
                        for="desc">Description</label>
                    <textarea name="desc" id="desc" rows="3" class="desc form-input w-full px-2 py-1 bg-slate-100" readonly>{{$dataCPDetail->remarks}}</textarea>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Payment Detail</label>
                </div>
                <table class="table table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                    <thead>
                        <tr class="bg-slate-400">
                            <th class="text-sm text-center" style="font-size: 10px; width: 7px;">REFF #</th>
                            <th class="text-sm text-center" style="font-size: 10px; width: 78px;">REFF DATE</th>
                            <th class="text-sm text-center" style="font-size: 10px; width: 250px;">DESCRIPTION</th>
                            <th class="text-sm text-center" style="font-size: 10px; width: 150px;">AMOUNT</th>
                            <th class="text-sm text-center" style="font-size: 10px;">PREVIOUS PAYMENT</th>
                            <th class="text-sm text-center" style="font-size: 10px;">AMOUNT PAID</th>
                        </tr>
                    </thead>
                    <tbody style="font-family: Arial, Helvetica, sans-serif;">
                        @foreach ($dataCPdetail1 as $items)
                            <tr>
                                <td class="text-sm text-left" style="font-size: 13px;">{{$items->id_costpayment}}</td>
                                <td class="text-sm text-right" style="font-size: 13px;">{{date('d F y', strtotime($items->dateForm))}}</td>
                                <td class="text-sm text-left" style="font-size: 13px;">{{$items->remarks}}</td>
                                <td class="text-sm text-right" style="font-size: 13px;">{{number_format($items->amount_paid, 0, ',', '.')}}</td>
                                <td class="text-sm text-right" style="font-size: 13px;">{{number_format($items->previous_payment, 0, ',', '.')}}</td>
                                <td class="text-sm text-right" style="font-size: 13px;">{{number_format($items->amount_paid, 0, ',', '.')}}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-slate-400">
                            <td class="text-sm text-center font-bold" style="font-size: 13px;" colspan="5">SUBTOTAL</td>
                            <td class="text-sm text-right font-bold" style="font-size: 13px;" colspan="2">{{$dataCPDetail->currency}} {{number_format($mathPayment->beforeRoundings, 0, ',', '.')}}</td>
                        </tr>
                        <tr class="bg-slate-400">
                            <td class="text-sm text-center font-bold" style="font-size: 13px;" colspan="5">ROUNDING</td>
                            @if ($dataCPDetail->rounding != 0)
                            <td class="text-sm text-right font-bold" style="font-size: 13px;" colspan="2">{{$dataCPDetail->currency}} -{{number_format($mathPayment->rounds, 0, ',', '.')}}</td>
                            @else
                            <td class="text-sm text-right font-bold" style="font-size: 13px;" colspan="2">{{$dataCPDetail->currency}} {{number_format($mathPayment->rounds, 0, ',', '.')}}</td>
                            @endif
                        </tr>
                        <tr class="bg-slate-400">
                            <td class="text-sm text-center font-bold" style="font-size: 13px;" colspan="5">BANK CHARGE</td>
                            <td class="text-sm text-right font-bold" style="font-size: 13px;" colspan="2">{{$dataCPDetail->currency}} {{number_format($mathPayment->charges, 0, ',', '.')}}</td>
                        </tr>
                        <tr class="bg-slate-400">
                            <td class="text-sm text-center font-bold" style="font-size: 13px;" colspan="5">DUTY STAMP CHARGE</td>
                            <td class="text-sm text-right font-bold" style="font-size: 13px;" colspan="2">{{$dataCPDetail->currency}} {{number_format($mathPayment->dutys, 0, ',', '.')}}</td>
                        </tr>
                        <tr class="bg-slate-400">
                            <td class="text-sm text-center font-bold" style="font-size: 13px;" colspan="5">OTHER CHARGE</td>
                            <td class="text-sm text-right font-bold" style="font-size: 13px;" colspan="2">{{$dataCPDetail->currency}} {{number_format($mathPayment->others, 0, ',', '.')}}</td>
                        </tr>
                        <tr class="bg-slate-400">
                            <td class="text-sm text-center font-bold" style="font-size: 13px;" colspan="5">TOTAL</td>
                            <td class="text-sm text-right font-bold" style="font-size: 13px;" colspan="2">{{$dataCPDetail->currency}} {{number_format($mathPayment->totals_amount, 0, ',', '.')}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex flex-row justify-center">
                    <div x-data="{ modalOpen: false }">
                        <button type="button" class="btn btn-sm text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1 mt-3 mb-5" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal"
                        >View Detail</button>
                        
                        <!-- Modal backdrop -->
                        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                            x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-out duration-100"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            aria-hidden="true" x-cloak></div>
                        <!-- Modal dialog -->
                        <div id="feedback-modal"
                            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                            role="dialog" aria-modal="true" x-show="modalOpen"
                            x-transition:enter="transition ease-in-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in-out duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
                            <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full"
                                @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800 text-sm">View Payment Detail</div>
                                        <button type="button" class="text-slate-400 hover:text-slate-500"
                                            @click="modalOpen = false">
                                            <div class="sr-only">Close</div>
                                            <svg class="w-4 h-4 fill-current">
                                                <path
                                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <!-- Modal content -->
                                <div class="modal-content text-xs">
                                    <div class="px-5">
                                        <div class="text-sm">
                                            <div class="font-medium text-slate-800 mb-3"></div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Form Date / Due Date / Reff #</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->date}}" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->due_date}}" readonly>
                                                </div>
                                                <div>
                                                    <input id="id_cp" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->id_costpayment}}" readonly/>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Form Type / Status / Created By</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->form_type}}" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->status}}" readonly>
                                                </div>
                                                <div>
                                                    <input id="created_by" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->created_by}}" readonly/>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Applicant / Company / Beneficiary Bank</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->applicant}}" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="company" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->company}}" readonly/>
                                                </div>
                                                <div>
                                                    <div style="width: 30rem;">
                                                        @if ($dataCP->beneficiary_bank != null)
                                                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataCP->beneficiary_bank}}" type="text" readonly/>
                                                        @else
                                                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="Cash" type="text" readonly/>
                                                        @endif
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Name / Account / Currency</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataCP->beneficiary_name}}" type="text" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->beneficiary_acc}}" readonly>
                                                </div>
                                                <div>
                                                    <input id="benef_acc" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->currency}}" readonly/>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Cross Rate / WHT / 'G.Total A/P'</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="total_amount" value="{{number_format($dataCP->crate, 0, ',', '.')}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="total_paid" value="{{number_format($dataCP->wht, 0, ',', '.')}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly>
                                                </div>
                                                <div>
                                                    <input id="balance" value="{{number_format($dataCP->total_paid, 0, ',', '.')}}" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Total Amount / Total Paid / Balance</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="total_amount" value="{{number_format($dataCP->total_paid, 0, ',', '.')}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="total_paid" value="{{number_format($totalPaid, 0, ',', '.')}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly>
                                                </div>
                                                <div>
                                                    <input id="balance" value="{{number_format($dataCP->balance, 0, ',', '.')}}" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                                    <input id="balancex" value="{{number_format($dataCP->balance, 0, '', '')}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly>
                                                    <input id="balance_whtt" value="{{number_format($dataCP->balance_wht, 0, '', '')}}" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly/>
                                                </div>
                                        </div>
                                            <div class="mt-3">
                                                <label class="block text-sm font-medium mb-1 text-left" for="notes">Payment Detail</label>
                                            </div>
                                            <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-xs text-center">Date</th>
                                                        <th class="text-xs text-center">Type</th>
                                                        <th class="text-xs text-center">Reff#</th>
                                                        <th class="text-xs text-center">Description</th>
                                                        <th class="text-xs text-center">Subtotal</th>
                                                        <th class="text-xs text-center">VAT Type</th>
                                                        <th class="text-xs text-center">VAT</th>
                                                        <th class="text-xs text-center">WHT Type</th>
                                                        <th class="text-xs text-center">WHT</th>
                                                        <th class="text-xs text-center">Total Paid</th>
                                                        <th class="text-xs text-center">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($dataCP->form_type == 'Cost Center')
                                                        @foreach($dataDetailCP as $item) 
                                                            <tr>
                                                                <td class="text-xs text-center">{{$item->date}}</td>
                                                                <td class="text-xs">{{$item->cost_type}}</td>
                                                                <td class="text-xs text-center">{{$item->invoice_number == 'null' ? '' : ($item->invoice_number || '')}}</td>
                                                                <td class="text-xs">{{$item->desc}}</td>
                                                                <td class="text-xs text-right">{{number_format($item->subtotal, 0, ',', '.')}}</td>
                                                                <td class="text-xs">{{$item->vat == 'null' ? '' : ($item->vat || '')}}</td>
                                                                <td class="text-xs text-right">{{number_format($item->total_vat, 0, ',', '.')}}</td>
                                                                <td class="text-xs">{{$item->wht == 'null' ? '' : ($item->wht || '')}}</td>
                                                                <td class="text-xs text-right">{{number_format($item->total_wht, 0, ',', '.')}}</td>
                                                                <td class="text-xs text-right">{{number_format($item->paid_total, 0, ',', '.')}}</td>
                                                                <td class="text-xs">{{$item->remarks == 'null' ? '' : ($item->remarks || '')}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @elseif ($dataCP->form_type == 'Reimburse')
                                                        @foreach($dataDetailCP as $item1) 
                                                            <tr>
                                                                <td class="text-xs text-center">{{$item1->date}}</td>
                                                                <td class="text-xs">{{$item1->reimburse_type}}</td>
                                                                <td class="text-xs text-center">{{$item1->no_vehicle == 'null' ? '' : ($item1->no_vehicle || '')}}</td>
                                                                <td class="text-xs">{{$item1->reimburse_to}}</td>
                                                                <td class="text-xs text-right">{{number_format($item1->subtotal, 0, ',', '.')}}</td>
                                                                <td class="text-xs">{{$item1->vat == 'null' ? '' : ($item1->vat || '')}}</td>
                                                                <td class="text-xs text-right">{{number_format($item1->total_vat, 0, ',', '.')}}</td>
                                                                <td class="text-xs">{{$item1->wht == 'null' ? '' : ($item1->wht || '')}}</td>
                                                                <td class="text-xs text-right">{{number_format($item1->total_wht, 0, ',', '.')}}</td>
                                                                <td class="text-xs text-right">{{number_format($item1->paid_total, 0, ',', '.')}}</td>
                                                                <td class="text-xs">{{$item1->remarks == 'null' ? '' : ($item1->remarks || '')}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @elseif ($dataCP->form_type == 'RAB')
                                                        @foreach($dataDetailCP as $item2) 
                                                            <tr>
                                                                <td class="text-center text-xs">{{$item2->date_rab}}</td>
                                                                <td class="text-xs">{{$item2->rab_calc_type}}</td>
                                                                <td class="text-xs text-center">{{$item2->id_rab}}</td>
                                                                <td class="text-xs">${value.name_rab_detail}{{$item2->name_rab_detail}}</td>
                                                                <td class="text-xs text-right">{{number_format($item2->total, 0, ',', '.')}}</td>
                                                                <td class="text-xs">-</td>
                                                                <td class="text-xs text-right">0</td>
                                                                <td class="text-xs">-</td>
                                                                <td class="text-xs text-right">0</td>
                                                                <td class="text-xs text-right">{{number_format($item2->total, 0, ',', '.')}}</td>
                                                                <td class="text-xs">{{$item2->remarks}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @elseif ($dataCP->form_type == 'PO')
                                                        @foreach($dataDetailCP as $item3) 
                                                            <tr>
                                                                <td class="text-xs text-center">{{$item3->date_po}}</td>
                                                                <td class="text-xs">PO Pre System</td>
                                                                <td class="text-xs text-center">{{$item3->no_po == 'null' ? '' : ($item3->no_po || '')}}</td>
                                                                <td class="text-xs">{{$item3->po_title}}</td>
                                                                <td class="text-xs text-right">{{number_format($item3->total, 0, ',', '.')}}</td>
                                                                <td class="text-xs">-</td>
                                                                <td class="text-xs text-right">{{number_format($item3->ppn, 0, ',', '.')}}</td>
                                                                <td class="text-xs">-</td>
                                                                <td class="text-xs text-right">{{number_format($item3->wht, 0, ',', '.')}}</td>
                                                                <td class="text-xs text-right">{{number_format($item3->amount_due, 0, ',', '.')}}</td>
                                                                <td class="text-xs">-</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    <tr>
                                                        <td class="text-center font-bold text-sm" colspan="6">Grand Total</td>
                                                        <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCP->vat, 0, ',', '.')}}</td>
                                                        <td></td>
                                                        <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCP->wht, 0, ',', '.')}}</td>
                                                        <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCP->total_paid, 0, ',', '.')}}</td>
                                                        <td></td>
                                                    </tr>
                                                    @if ($dataCP->approved_total != 0)
                                                    <tr>
                                                        <td class="text-center font-bold text-sm" colspan="6">Approved Paid</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right font-bold text-sm">{{number_format($dataCP->approved_total, 0, ',', '.')}}</td>   
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="px-5 py-4 border-t border-slate-200">
                                    <div class="flex flex-wrap justify-end space-x-2">
                                        <button type="button" class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="files">Upload Payment Attachment<span class="text-rose-500">*</span></label>
                    <input id="files" name="files" class="files form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                    <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">File max size 12MB</div>
                </div>
                {{-- <div class="flex justify-between flex-col md:flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="files">Payee Date<span class="text-rose-500">*</span></label>
                    <input id="payee_date" name="payee_date" value="{{date('Y-m-d')}}" class="payee_date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date" required/>
                </div> --}}
                <div class="flex justify-between flex-col md:flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="files">Bank Date<span class="text-rose-500">*</span></label>
                    <input id="bank_date" name="bank_date" value="{{date('Y-m-d')}}" class="bank_date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="files">Transaction #/Cheque #/Giro #<span class="text-rose-500">*</span></label>
                    <input id="transactions" name="transactions" class="transactions form-input w-full md:w-3/4 px-2 py-1" type="text" maxlength="500" required/>
                </div>
                @if ($dataCPDetail->aktifyn == 'F')
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_form">
                        <span class="xs:block ml-5 mr-5">Submit Payment Attachment</span>
                    </button> </center>
                @endif
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>
        $('#myForm').submit(function (e, params) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            console.log(formData, $(this).attr('action'));
            $.ajax({
                url      : $(this).attr('action'),
                type     : 'POST',
                dataType : 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(_response){
                    if (_response.st == '1') {
                    // var RRID = _response.id;
                    urlRedirect = '/finance/payment/list/confirmpaymentlist';
                    window.open(urlRedirect, '_self');
                    // Swal.fire({
                    //     title: 'Success',
                    //     text: 'Reimburse #' + RRID + ' Has Been Created',
                    //     icon: 'success',
                    //     showCancelButton: false,
                    //     confirmButtonText: 'Ok',
                    //     cancelButtonText: 'No, cancel'
                    // }).then((result) => {
                    //     if (result.isConfirmed) {
                    //         Swal.close();
                    //     }else {
                    //         Swal.close();
                    //     }
                    // });
                }else if (_response.st == '2') {
                        Swal.fire({
                            title: 'File to Large',
                            text: 'Please Compress File',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }else {
                                Swal.close();
                            }
                        });
                    }else if (_response.st == '3') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Payment Already Submitted',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }else {
                                Swal.close();
                            }
                        });
                    }
                },
                    error: function(){
                    alert('Terjadi kesalahan');
                }
            });
        })
</script>
@endsection
</x-app-layout>