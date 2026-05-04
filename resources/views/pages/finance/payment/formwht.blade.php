<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Payment WHT Form 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('payment-list.create', ['cpId' => $dataCP->idrec]) }}" id="myForm">
                @csrf
                <div class="grid md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1"
                            for="date">Form Date</label>
                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCP->date}}" readonly/>
                    </div>
                    @if ($dataCP->due_date != null)
                        <div>
                            <label class="block text-sm font-medium mb-1"
                                for="date">Due Date</label>
                            <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                type="text" value="{{$dataCP->due_date}}" disabled readonly/>
                        </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium mb-1"
                            for="id_cp">Payment Form #</label>
                        <input id="id_cp" class="id_cp form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCP->id_costpayment}}"value="${id_cp}" readonly/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="form_type">Form Type</label>
                        <input id="form_type" class="form_type form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCP->form_type}}" readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="status">Status</label>
                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCP->status}}" readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="company">Company</label>
                        <input id="company" class="company form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCP->company}}"value="${company}" readonly />
                    </div>
                    @if ($dataCP->beneficiary_bank != null)
                        <div>
                            <label class="block text-sm font-medium mb-1" for="beneficiary_bank">Beneficiary Bank</label>
                            <input id="beneficiary_bank" class="beneficiary_bank form-input w-full px-2 py-1 bg-slate-100"
                                type="text" value="{{$dataCP->beneficiary_bank}}" readonly />
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium mb-1" for="beneficiary_bank">Beneficiary Bank</label>
                            <input id="beneficiary_bank" class="beneficiary_bank form-input w-full px-2 py-1 bg-slate-100"
                                type="text" value="Cash" readonly />
                        </div>
                    @endif
                    @if ($dataCP->beneficiary_acc != null)
                        <div>
                            <label class="block text-sm font-medium mb-1" for="beneficiary_name">Beneficiary Name</label>
                            <input id="beneficiary_name" class="beneficiary_name form-input w-full px-2 py-1 bg-slate-100"
                                type="text" value="{{$dataCP->beneficiary_name}}" readonly />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="beneficiary_acc">Beneficiary Account</label>
                            <input id="beneficiary_acc" class="beneficiary_acc form-input w-full px-2 py-1 bg-slate-100"
                                type="text" value="{{$dataCP->beneficiary_acc}}" readonly />
                        </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium mb-1" for="balance">Balance</label>
                        <input id="balance" class="balance form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{number_format($dataCP->balance, 0, ',', '.')}}" readonly/>
                        <input id="balancex" class="balancex form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{number_format($dataCP->balance, 0, '', '')}}" readonly hidden/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="balance_wht">Balance WHT</label>
                        <input id="balance_wht" class="balance_wht form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{number_format($dataCP->balance_wht, 0, ',', '.')}}" readonly/>
                        <input id="balance_whtt" name="balance_whtt" class="balance_whtt form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{number_format($dataCP->balance_wht, 0, '', '')}}" readonly hidden/>
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
                                        <div class="grid md:grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-sm font-medium mb-1"
                                                    for="date">Form Date</label>
                                                <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{$dataCP->date}}" disabled readonly/>
                                            </div>
                                            @if ($dataCP->due_date != null)
                                                <div>
                                                    <label class="block text-sm font-medium mb-1"
                                                        for="date">Due Date</label>
                                                    <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                                        type="text" value="{{$dataCP->due_date}}" disabled readonly/>
                                                </div>
                                            @endif
                                            <div>
                                                <label class="block text-sm font-medium mb-1"
                                                    for="id_cp">Payment Form #</label>
                                                <input id="id_cp" class="id_cp form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{$dataCP->id_costpayment}}" disabled readonly/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="form_type">Form Type</label>
                                                <input id="form_type" class="form_type form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{$dataCP->form_type}}" disabled readonly />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="status">Status</label>
                                                <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{$dataCP->status}}" disabled readonly />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="created_by">Created By</label>
                                                <input id="created_by" class="created_by form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{$dataCP->created_by}}" disabled readonly />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="applicant">Applicant</label>
                                                <input id="applicant" class="applicant form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{$dataCP->applicant}}" disabled readonly />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="company">Company</label>
                                                <input id="company" class="company form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{$dataCP->company}}" disabled readonly />
                                            </div>
                                            @if ($dataCP->beneficiary_bank != null)
                                                <div>
                                                    <label class="block text-sm font-medium mb-1" for="beneficiary_bank">Beneficiary Bank</label>
                                                    <input id="beneficiary_bank" class="beneficiary_bank form-input w-full px-2 py-1 bg-slate-100"
                                                        type="text" value="{{$dataCP->beneficiary_bank}}" readonly />
                                                </div>
                                            @else
                                                <div>
                                                    <label class="block text-sm font-medium mb-1" for="beneficiary_bank">Beneficiary Bank</label>
                                                    <input id="beneficiary_bank" class="beneficiary_bank form-input w-full px-2 py-1 bg-slate-100"
                                                        type="text" value="Cash" readonly />
                                                </div>
                                            @endif
                                            @if ($dataCP->beneficiary_acc != null)
                                                <div>
                                                    <label class="block text-sm font-medium mb-1" for="beneficiary_name">Beneficiary Name</label>
                                                    <input id="beneficiary_name" class="beneficiary_name form-input w-full px-2 py-1 bg-slate-100"
                                                        type="text" value="{{$dataCP->beneficiary_name}}" readonly />
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium mb-1" for="beneficiary_acc">Beneficiary Account</label>
                                                    <input id="beneficiary_acc" class="beneficiary_acc form-input w-full px-2 py-1 bg-slate-100"
                                                        type="text" value="{{$dataCP->beneficiary_acc}}" readonly />
                                                </div>
                                            @endif
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="currency1">Currency</label>
                                                <input id="currency1" class="currency1 form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{$dataCP->currency}}" disabled
                                                    readonly />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="crate">Cross Rate</label>
                                                <input id="crate" class="crate form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{number_format($dataCP->crate, 0, ',', '.')}}"
                                                    readonly />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="wht">WHT</label>
                                                <input id="wht" class="wht form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{number_format($dataCP->wht, 0, ',', '.')}}" readonly />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="total_paid">G.Total A/P</label>
                                                <input id="total_paid" class="total_paid form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{number_format($dataCP->total_paid, 0, ',', '.')}}" readonly />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="balance">Balance</label>
                                                <input id="balance" class="balance form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{number_format($dataCP->balance, 0, ',', '.')}}" readonly />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="balance_wht">Balance WHT</label>
                                                <input id="balance_wht" class="balance_wht form-input w-full px-2 py-1 bg-slate-100"
                                                    type="text" value="{{number_format($dataCP->balance_wht, 0, ',', '.')}}" readonly />
                                            </div>
                                        </div>
                                            <div class="mt-3">
                                                <label class="block text-sm font-medium mb-1 text-left" for="notes">Cost/Reimburse Detail</label>
                                            </div>
                                            <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-xs text-center">Date</th>
                                                        <th class="text-xs text-center">Cost/Reimburse Type</th>
                                                        <th class="text-xs text-center">Invoice/Vehicle Number</th>
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
                                                    @else
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
                                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">
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
                        @foreach ($dataChildCompany as $company)
                            <option value="{{$company->id_company}}">{{$company->name}}</option>
                        @endforeach
                    </select>
                    @else
                    <input id="company_id" name="company_id"
                        class="company_id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{ Auth::user()->company_id}}" readonly required hidden/>
                    <input id="companies" name="companies"
                    class="companies form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    Value="{{$dataChildCompany->name}}" required readonly/>
                    @endif
                </div>
                <div class="flex flex-row mt-3">
                    <label class="text-sm font-medium mt-1" for="vatType">Payment Type / Currency / Amount<span class="text-rose-500">*</span></label>
                        <div style="width: 17.1rem; margin-left: 6.7rem; margin-right: 41px;">
                            <select id="payment_type" name="payment_type" class="payment_type form-select w-full px-2 py-1" required>
                                <option selected hidden value="">Select Payment Type</option>
                                <option value="A/P">A/P</option>
                                <option value="WHT">WHT</option>
                            </select>
                        </div>
                        <div>
                            <select id="currency" name="currency" style="width: 17.1rem;" class="currency form-select w-full px-2 py-1" required>
                                <option selected hidden value="">Select Currency</option>
                                @foreach ($dataCurrency as $currency)
                                    <option value="{{$currency->symbol}}">{{$currency->currency}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <input id="amount" name="amount" style="width: 17.1rem; margin-left: 41px; margin-right: 41px;" class="amount numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                            <input id="balances" name="balances" class="balances form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden/>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" id="fullAmount" hidden>Full Amount</button>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="payment_from">Payee Type<span
                        class="text-rose-500">*</span></label>
                    <select id="payment_from" name="payment_from" class="payment_from form-select w-full md:w-3/4 px-2 py-1" type="text" required>
                        <option value="" hidden>Select Payment</option>
                        <option value="Cash">Cash</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Cheque/Giro">Cheque/Giro</option>
                        <option value="Others">Others</option>
                    </select>
                    
                </div>
                <div id="payments" hidden>
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Company ID / Payee Bank / (Acc# / Transfer Reff# / Cheque# / Giro#)<span
                            class="text-rose-500">*</span></label>
                            <div style="width: 20.8rem; margin-right: 20px;">
                                <input id="companyID" name="companyID" class="companyID form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Company ID"/>
                            </div>
                            <div style="width: 20.8rem; margin-right: 20px;">
                                <input id="payee_bank" name="payee_bank" class="payee_bank form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Payee Bank"/>
                            </div>
                            <div>
                                <input id="payee_acc" name="payee_acc" style="width: 21.2rem;" class="payee_acc form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Acc# / Transfer Reff# / Cheque# / Giro#"/>
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
                <div id="npwps" hidden>
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
                </div>
                <div class="flex flex-row mt-3">
                    <label class="text-sm font-medium mb-1 mt-1" for="byby">Checked By / Approved By / Released By<span class="text-rose-500">*</span></label>
                        <div style="width: 20rem; margin-left: 4.3rem; margin-right: 41px;">
                            <input id="checked_by" name="checked_by" class="checked_by form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Checked By"/>
                        </div>
                        <div>
                            <input id="approved_by" name="approved_by" style="width: 20rem;" class="approved_by form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Approved By"/>
                        </div>
                        <div>
                            <input id="released_by" name="released_by" style="width: 20rem; margin-left: 41px;" class="released_by form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Released By"/>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks">Description</label>
                    <textarea id="remarks" name="remarks" class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3"></textarea>
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
    $('#payment_from').on('change', function () {
        const payment = $(this).val();

        if (payment == "Cash") {
            $('#payments').attr('hidden', true);
            $('#payee_bank').attr('required', false);
            $('#payee_acc').attr('required', false);
        }else{
            $('#payments').attr('hidden', false);
            $('#payee_bank').attr('required', true);
            $('#payee_acc').attr('required', true);
        }
    })
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
    // $('#amount').on('change', function () {
    //     const amount = $('#amount').val();
    //     if (!amount) {
    //         $('#create_form').attr('disabled', true);
    //     }else {
    //         $('#create_form').attr('disabled', false);
    //     }
    // })
    var previousAmount = null;
    var previousBalance = null;

    document.addEventListener("DOMContentLoaded", function() {
        // Fungsi untuk menampilkan alert jika melebihi batas
        function checkAmountLimit() {
            console.log("Checking amount limit...");
            var paymentType = document.getElementById('payment_type').value;
            var balance = parseFloat("{{$dataCP->balance}}");
            var balanceWHT = parseFloat("{{$dataCP->balance_wht}}");

            // Menghapus titik pemisah ribuan dari nilai input
            var amountInputValue = document.getElementById('amount').value.replace(/\./g, '');
            var amount = parseFloat(amountInputValue);

            if (paymentType === 'A/P' && amount > balance) {
                alert("Amount cannot exceed the balance.");
                // Kembalikan nilai input ke nilai sebelumnya
                document.getElementById('amount').value = addThousandSeparator(previousAmount);
            } else if (paymentType === 'WHT' && amount > balanceWHT) {
                alert("Amount cannot exceed the balance WHT.");
                // Kembalikan nilai input ke nilai sebelumnya
                document.getElementById('amount').value = addThousandSeparator(previousAmount);
            } else {
                // Jika nilai tidak melebihi batas, update nilai sebelumnya
                previousAmount = amountInputValue;
            }
        }

        // Tambahkan event listener untuk perubahan pada input amount
        document.getElementById('amount').addEventListener('input', function() {
            checkAmountLimit();
            calculateBalance(); // Panggil fungsi perhitungan saldo setelah perubahan amount
        });

        // Tambahkan event listener untuk perubahan pada tipe pembayaran
        $('#payment_type').on('change', function() {
            // Update saldo sebelumnya berdasarkan tipe pembayaran yang baru
            if ($(this).val() === 'A/P') {
                previousBalance = parseFloat("{{$dataCP->balance}}");
            } else {
                previousBalance = parseFloat("{{$dataCP->balance_wht}}");
            }
            calculateBalance(); // Panggil fungsi perhitungan saldo setelah perubahan tipe pembayaran
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
        const totalAmount = Math.floor(previousBalance - amount);
        $('#balances').val(totalAmount);
    }

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
                if (_response.st == '0') {
                    alert("A/P Already Paid or insufficient balance. Please Refresh The Page");
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