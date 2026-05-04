<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Payment Form 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('payment-list.create', ['cpId' => $dataCP->idrec]) }}" id="myForm">
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
                <div class="flex flex-row justify-center">
                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1 mt-3 mb-5" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" type="button">View Detail</button>
                        
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
                                        <button class="text-slate-400 hover:text-slate-500" type="button"
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
                                                <label class="block text-sm font-medium mb-1 text-left" for="notes">Cost/Reimburse Detail</label>
                                            </div>
                                            <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-xs text-center">Date</th>
                                                        <th class="text-xs text-center">Type</th>
                                                        @if ($dataCP->form_type == 'RAB')
                                                        <th class="text-xs text-center">RAB #</th>
                                                        <th class="text-xs text-center">Inventory Asset</th>
                                                        @else
                                                        <th class="text-xs text-center">Invoice/Vehicle Number</th>
                                                        <th class="text-xs text-center">Description</th>
                                                        @endif
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
                                                                <td class="text-xs text-center">{{'Y F'($item->date)}}</td>
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
                                                    @elseif($dataCP->form_type == 'Reimburse')
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
                                                                <td class="text-xs text-center">{{date('Y F', strtotime($item2->date))}}</td>
                                                                <td class="text-xs">{{$item2->cost_type}}</td>
                                                                <td class="text-xs text-center">{{$dataCP->id_costpayment}}</td>
                                                                <td class="text-xs">{{$item2->desc}}</td>
                                                                <td class="text-xs text-right">{{number_format($item2->paid_total, 0, ',', '.')}}</td>
                                                                <td class="text-xs">-</td>
                                                                <td class="text-xs text-right">0</td>
                                                                <td class="text-xs">-</td>
                                                                <td class="text-xs text-right">0</td>
                                                                <td class="text-xs text-right">{{number_format($item2->paid_total, 0, ',', '.')}}</td>
                                                                <td class="text-xs">{{$item2->remarks == 'null' ? '' : ($item2->remarks || '')}}</td>
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
                <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="dates">Form Date<span class="text-rose-500">*</span></label>
                    <input id="dates" name="dates" value="{{date('Y-m-d')}}" class="dates selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company_id">Paid By<span class="text-rose-500">*</span></label>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <select id="company_id" name="company_id"
                        class="company_id form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Company</option>
                        <option value="{{$dataHeadCompany->id_company}}">{{$dataHeadCompany->name}}</option>
                        @if ($dataCP->id_company == '1' || $dataCP->id_company == '0')
                        <option value="{{ $dataChildCompany->id_company }}" hidden>{{ $dataChildCompany->name }}</option>
                        @else
                        <option value="{{ $dataChildCompany->id_company }}">{{ $dataChildCompany->name }}</option>
                        @endif
                    </select>
                    @else
                    <input id="company_id" name="company_id" class="company_id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{ Auth::user()->company_id}}" readonly required hidden/>
                    <input id="companies" name="companies"
                    class="companies form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    value="{{$dataChildCompany->name}}" required readonly/>
                    {{-- <select id="company_id" name="company_id"
                        class="company_id form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Company</option>
                        <option value="{{$dataHeadCompany->id_company}}">{{$dataHeadCompany->name}}</option>
                        <option value="{{$dataChildCompany->id_company}}">{{$dataChildCompany->name}}</option>
                    </select> --}}
                    @endif
                </div>
                <div class="flex flex-row mt-3">
                    <label class="text-sm font-medium mt-1" for="vatType">Payment Type / Currency / Amount/ Less Rounding<span class="text-rose-500">*</span></label>
                        <div style="width: 10rem; margin-left: 2px; margin-right: 30px;">
                            {{-- <select id="payment_type" name="payment_type" class="payment_type form-select w-full px-2 py-1" required>
                                <option value="A/P" selected>A/P</option>
                            </select> --}}
                            <input id="payment_type" name="payment_type" class="payment_type form-input w-full px-2 py-1 read-only:bg-slate-200" value="A/P" required readonly/>
                        </div>
                        <div>
                            {{-- <select id="currency" name="currency" style="width: 17.1rem;" class="currency form-select w-full px-2 py-1" required>
                                <option selected hidden value="">Select Currency</option>
                                @foreach ($dataCurrency as $currency)
                                    <option value="{{$currency->symbol}}" {{$dataCP->currency == $currency->symbol ? 'selected':''}}>{{$currency->currency}}</option>
                                @endforeach
                            </select> --}}
                            <input id="currency" name="currency" style="width: 14rem;" class="currency form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataCP->currency}}" required readonly/>
                        </div>
                        <div>
                            <input id="amount" name="amount" style="width: 14rem; margin-left: 41px; margin-right: 30px;" class="amount numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" required/>
                            <input id="balances" name="balances" class="balances form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{number_format($dataCP->balance, 0, '', '')}}" type="text" hidden readonly/>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" id="fullAmount">Full Amount</button>
                        </div>
                        <div>
                            <input id="lessRounding" name="lessRounding" style="width: 13rem; margin-left: 20px;" class="lessRounding numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="0"/>
                            <input id="balancessx" name="balancessx" class="balancessx form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly/>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="payfrom">Payment To Beneficiary By<span class="text-rose-500">*</span></label>
                    <select id="payfrom" name="payfrom" class="payfrom selector form-select w-full md:w-3/4 px-2 py-1" disabled>
                        <option value="" selected>Select Bank Company</option>
                        @foreach ($cidBank as $cid)
                            <option value="{{ $cid->id_cidb }}" 
                                    data-id_company="{{ $cid->id_company }}" 
                                    data-cidbank="{{ $cid->cidbank }}" 
                                    data-bank_acc="{{ $cid->bank_acc }}"
                                    data-bank_name="{{ $cid->bankName }}">
                                {{ $cid->bankName }} | {{ $cid->cidbank }} | {{ $cid->bank_acc }}
                            </option>
                        @endforeach
                    </select>
                    <input id="selectedBanks" name="selectedBanks" class="selectedBanks form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden required readonly/>
                </div>
                <div id="payments">
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Bank Company / Bank CID / Bank Account<span
                            class="text-rose-500">*</span></label>
                            <div style="width: 20.8rem; margin-right: 20px;">
                                <input id="payee_bank" name="payee_bank" class="payee_bank form-input w-full px-2 py-1 read-only:bg-slate-200" placeholder="Bank Company" type="text" required readonly/>
                            </div>
                            <div style="width: 20.8rem; margin-right: 20px;">
                                <input id="companyID" name="companyID" class="companyID form-input w-full px-2 py-1 read-only:bg-slate-200" placeholder="Bank CID" required readonly>
                            </div>
                            <div>
                                <input id="payee_acc" name="payee_acc" style="width: 21.2rem;" class="payee_acc form-input w-full px-2 py-1 read-only:bg-slate-200" placeholder="Bank Account" required readonly/>
                            </div>
                    </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="payment_date">Payment Date<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="payment_date" name="payment_date" value="{{date('Y-m-d')}}"
                    class="payment_date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                    required/>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="text-sm font-medium mb-1 mt-1" for="vatType">Bank Charge / Duty Stamp Charge / Other Charge</label>
                        <div style="width: 20rem; margin-left: 1.1rem; margin-right: 41px;">
                            <input id="bank_charge" name="bank_charge" class="bank_charge numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" value="0" type="text"/>
                        </div>
                        <div>
                            <input id="duty_stamp_charge" name="duty_stamp_charge" style="width: 20rem;" class="duty_stamp_charge numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" value="0" type="text"/>
                        </div>
                        <div>
                            <input id="other_charge" name="other_charge" style="width: 20rem; margin-left: 41px;" class="other_charge numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" value="0" type="text"/>
                        </div>
                </div>
                {{-- <div id="npwps" hidden>
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="text-sm font-medium mt-1" for="npwp">NPWP ID / NPWP Name<span class="text-rose-500">*</span></label>
                            <div style="width: 31rem; margin-left: 11.6rem; margin-right: 41px;">
                                @if ($dataCP->npwp_id == null)
                                <input id="npwp" name="npwp" class="npwp form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" required/>
                                @else
                                <input id="npwp" name="npwp" class="npwp form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->npwp_id}}" readonly/>
                                @endif
                            </div>
                            <div>
                                @if ($dataCP->npwp_name == null)
                                <input id="npwp_name" name="npwp_name" style="width: 31.5rem;" class="npwp_name form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" required/>
                                @else
                                <input id="npwp_name" name="npwp_name" style="width: 31.5rem;" class="npwp_name form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCP->npwp_name}}" readonly/>
                                @endif
                            </div>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_address">NPWP Address<span class="text-rose-500">*</span></label>
                        @if ($dataCP->npwp_address == null)
                        <textarea id="npwp_address" name="npwp_address" class="npwp_address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" required></textarea>
                        @else
                        <textarea id="npwp_address" name="npwp_address" class="npwp_address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" readonly>{{$dataCP->npwp_address}}</textarea>
                        @endif
                    </div>
                </div> --}}
                <div class="flex flex-row mt-3">
                    <label class="text-sm font-medium mb-1 mt-1" for="byby">Checked By / Approved By / Released By<span class="text-rose-500">*</span></label>
                        <div style="width: 20rem; margin-left: 4.3rem; margin-right: 41px;">
                            <input id="checked_by" name="checked_by" class="checked_by form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Checked By" required/>
                        </div>
                        <div>
                            <input id="approved_by" name="approved_by" style="width: 20rem;" class="approved_by form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Approved By" required/>
                        </div>
                        <div>
                            <input id="released_by" name="released_by" style="width: 20rem; margin-left: 41px;" class="released_by form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Released By" required/>
                        </div>
                </div>
                {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file45">Attachment Document<span
                        class="text-rose-500">*</span></label>
                    <input id="file45" name="file45" class="file45 form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf" required/>
                </div> --}}
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks">Description<span class="text-rose-500">*</span></label>
                    <textarea id="remarks" name="remarks" class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" required></textarea>
                </div>
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_form">
                        <span class="xs:block ml-5 mr-5">Create Payment</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>
    $('#fullAmount').on('click', function () {
        $("#amount").val('{{number_format($dataCP->balance, 0, ',', '.')}}');   
    });
    $('#payment_type').on('change', function () {
        const payment_type = $(this).val();
        const balances_whtt = $('#balance_whtt').val();
        const balancess = $('#balancex').val();
        const currencyValue = '{{$dataCP->currency}}';

        if (payment_type == "WHT") {
            if (balances_whtt == '0') {
                $('#npwps').attr('hidden', true);
                $('#npwp').attr('required', false);
                $('#npwp_name').attr('required', false);
                $('#npwp_address').attr('required', false);
                $('#amount').attr('readonly', true);
                $('#amount').val('');
                $('#fullAmount').attr('hidden', true);
                $('#create_form').attr('disabled', true);
                alert("WHT Already Paid.");
                $('#currency option[value="' + currencyValue + '"]').prop('selected', true);
            } else {
                $('#npwps').attr('hidden', false);
                $('#npwp').attr('required', true);
                $('#npwp_name').attr('required', true);
                $('#npwp_address').attr('required', true);
                $('#create_form').attr('disabled', false);
                $('#fullAmount').attr('hidden', true);
                $('#amount').attr('readonly', true);
                $('#amount').val('');
                $('#amount').val(divider1(balances_whtt));   
                $('#currency option[value="' + currencyValue + '"]').prop('selected', true);
            }
        }else{
            if (balancess == '0') {
                $('#npwps').attr('hidden', true);
                $('#npwp').attr('required', false);
                $('#npwp_name').attr('required', false);
                $('#npwp_address').attr('required', false);
                $('#amount').attr('readonly', true);
                $('#amount').val('');
                $('#fullAmount').attr('hidden', false);
                $('#create_form').attr('disabled', true);
                $('#currency option[value="' + currencyValue + '"]').prop('selected', true);
                alert("A/P Already Paid.");
            } else {
                $('#npwps').attr('hidden', true);
                $('#npwp').attr('required', false);
                $('#npwp_name').attr('required', false);
                $('#npwp_address').attr('required', false);
                $('#amount').attr('readonly', false);
                $('#amount').val('');
                $('#fullAmount').attr('hidden', false);
                $('#create_form').attr('disabled', false);
                $('#currency option[value="' + currencyValue + '"]').prop('selected', true);
            }
        }
    })

    $(document).ready(function() {
        // Initialize select2 for payfrom
        // $('#payfrom').select2();

        // Function to filter payfrom options based on selected company
        function filterPayFromOptions(companyId) {
            $('#payfrom').prop('disabled', false).find('option').each(function() {
                var optionCompanyId = $(this).data('id_company');
                if (optionCompanyId == companyId || optionCompanyId == "") {
                    $(this).select2().show();
                } else {
                    $(this).select2().hide();
                }
            });
            $('#payfrom').val('').trigger('change');
        }

        // Function to populate input fields based on selected payfrom option
        function populatePayeeFields(selectedOption) {
            $('#payee_bank').val(selectedOption.data('bank_name'));
            $('#companyID').val(selectedOption.data('cidbank'));
            $('#payee_acc').val(selectedOption.data('bank_acc'));
        }

        // Check the logged-in user's company_id
        var userCompanyId = {{ Auth::user()->company_id }};

        if (userCompanyId == 0 || userCompanyId == 888 || userCompanyId == 999) {
            // Enable company select field if user has special company_id
            $('#company_id').on('change', function() {
                var selectedCompanyId = $(this).val();
                filterPayFromOptions(selectedCompanyId);
            });
        } else {
            // If user has a specific company_id, filter options directly and enable payfrom
            filterPayFromOptions(userCompanyId);
            $('#payfrom').prop('disabled', false);
        }

        // Event listener for payfrom selection change
        $('#payfrom').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            if (selectedOption.val() !== "") {
                populatePayeeFields(selectedOption);
            }
        });
    });
    
    var previousAmount = null;
    var previousBalance = null;
    var previousLessRounding = null;

    document.addEventListener("DOMContentLoaded", function() {
        function checkAmountLimit() {
            console.log("Checking amount limit...");
            var paymentType = document.getElementById('payment_type').value;
            var balance = parseFloat("{{$dataCP->balance}}");
            var balances = parseFloat($('#balances').val().replace(/\./g, '')) || 0;
            var balanceWHT = parseFloat("{{$dataCP->balance_wht}}");

            // Menghapus titik pemisah ribuan dari nilai input
            var amountInputValue = document.getElementById('amount').value.replace(/\./g, '');
            var lessInputValue = document.getElementById('lessRounding').value.replace(/\./g, '');
            var lessRoundings = parseFloat(lessInputValue);
            var amount = parseFloat(amountInputValue);

            if (paymentType === 'A/P' && amount > balance) {
                alert("Amount cannot exceed the balance.");
                $('#create_form').attr('disabled', true);
                // Kembalikan nilai input ke nilai sebelumnya
                document.getElementById('amount').value = addThousandSeparator(previousAmount);
            } else if (paymentType === 'A/P' && lessRoundings > balances) {
                alert("Less round cannot exceed the balances.");
                $('#create_form').attr('disabled', true);
                document.getElementById('lessRounding').value = addThousandSeparator(previousLessRounding);
            } else if (paymentType === 'WHT' && amount > balanceWHT) {
                alert("Amount cannot exceed the balance WHT.");
                $('#create_form').attr('disabled', true);
                // Kembalikan nilai input ke nilai sebelumnya
                document.getElementById('amount').value = addThousandSeparator(previousAmount);
            } else {
                // Jika nilai tidak melebihi batas, update nilai sebelumnya
                previousAmount = amountInputValue;
                previousLessRounding = lessInputValue;
                $('#create_form').attr('disabled', false);
            }
        }

        // Tambahkan event listener untuk perubahan pada input amount
        document.getElementById('amount').addEventListener('input', function() {
            checkAmountLimit();
            calculateBalance();
        });
        document.getElementById('lessRounding').addEventListener('input', function() {
            checkAmountLimit();
            calculateBalance();
        });
        document.getElementById('fullAmount').addEventListener('click', function() {
            checkAmountLimit();
            calculateBalance();
        });
        $('#payment_type').on('change', function() {
            if ($(this).val() === 'A/P') {
                previousBalance = parseFloat("{{$dataCP->balance}}");
            } else {
                previousBalance = parseFloat("{{$dataCP->balance_wht}}");
            }
            calculateBalance();
            rounding();
        });
    });

    function calculateBalance() {
        const payment_type = $('#payment_type').val();
        const amount = parseFloat($('#amount').val().replace(/\./g, '')) || 0;

        let balanceField, balance;

        // Gunakan saldo sebelumnya untuk perhitungan saldo baru
        if (payment_type === 'A/P') {
            balanceField = $('#balance');
        } else {
            balanceField = $('#balance_wht');
        }

        // Menghapus titik pemisah ribuan dari nilai balance
        balance = parseFloat(balanceField.val().replace(/\./g, '')) || 0;

        // Hitung saldo baru berdasarkan saldo sebelumnya dan jumlah pembayaran
        const totalAmount = Math.floor(balance - amount);
        $('#balances').val(totalAmount);
    }

    function rounding() {
        const lessRounding = parseFloat($('#lessRounding').val().replace(/\./g, '')) || 0;
        const balances = parseFloat($('#balances').val()) || 0;

        const totsAmount = Math.floor(balances - lessRounding);
        $('#balancessx').val(totsAmount);
    }

    $('#lessRounding').on('input', function() {
        rounding();
    });


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
                if (_response.st === '1') {
                    window.location.href = '/finance/payment/list';
                }else if (_response.st === '0') {
                    alert("A/P Already Paid or insufficient balance. Please Refresh The Page");
                }else if (_response.st === '2') {
                    alert("Amount cannot 0 value");
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