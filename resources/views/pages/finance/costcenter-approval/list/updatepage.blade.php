<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit Cost Center 📝</h1>
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
        <form action="{{ route('cost-list.update', ['idCC' => $dataCC->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input id="company_id" name="company_id" class="company_id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$dataCC->company_id}}" readonly hidden/>
                <input id="idsupplier" name="idsupplier" class="idsupplier form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$dataCC->idsupplier}}" readonly hidden/>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Cost Center Form # / Form Date / Due Date</label>
                        <div style="width: 20.8rem;">
                            <input class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->idreqform}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-left: 20px;">
                            <input id="date" name="date" value="{{date('Y-m-d', strtotime($dataCC->datereq))}}" class="date selector w-full form-input px-2 py-1" data-date-format="YYYY/MM/DD" type="date" required/>
                        </div>
                        <div style="width: 20.8rem; margin-left: 20px;">
                            <input id="due_date" name="due_date" value="{{date('Y-m-d', strtotime($dataCC->due_date))}}" class="due_date selector form-input w-full px-2 py-1" data-date-format="YYYY/MM/DD" type="date" required/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Applicant / Payable Name / Company</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->username}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="applicant" name="applicant" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->applicant}}">
                        </div>
                        <div>
                            <input id="company" name="compannyName" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->company}}"/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Cost Center Description</label>
                        <div style="width: 65.3rem; margin-right: 30px;">
                            <input class="departmentName form-input w-full px-2 py-1 read-only:bg-slate-200" id="departmentName" name="departmentName" value="{{$dataCC->department}}" maxlength="1024"/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Bank / Account / Name</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <select id="bank" name="bank" class="bank form-select w-full px-2 py-1" type="text" required>
                                @foreach ($bank as $bankir )
                                    <option value="{{$bankir->id_bank}}" {{$bankir->id_bank == $dataCC->bank_account ? 'selected':''}}>{{$bankir->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="number" name="number" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->number_account}}"/>
                        </div>
                        <div>
                            <input id="account" name="account" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataCC->name_account}}"/>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file45">Attachment Document<span
                        class="text-rose-500">*</span></label>
                    <input id="file45" name="file45" class="file45 form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                    <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">File max size 12MB</div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Notes/ToP</label>
                    <textarea rows="3" id="notes" name="notes" class="notes form-input w-full px-2 py-1 read-only:bg-slate-200">{{$dataCC->note}}</textarea>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="DP">Previous DP / Reff#</label>
                        <div style="width: 24rem; margin-right: 41px;">
                            <input class="dp_view numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" id="dp_view" name="dp_view" value="{{number_format($dataCC->dp_amount, 0, ',', '.')}}"/>
                            <input class="dp_amount form-input w-full px-2 py-1 read-only:bg-slate-200" id="dp_amount" name="dp_amount" value="{{number_format($dataCC->dp_amount, 0, '', '')}}" hidden/>
                        </div>
                        <div>
                            <input style="width: 35rem;" class="dp_reff form-input w-full px-2 py-1 read-only:bg-slate-200" id="dp_reff" name="dp_reff" value="{{$dataCC->dp_reff}}"/>
                        </div>
                        <div>
                            <div x-data="{ modalOpen: false }">
                                <button type="button" id="costForm"
                                    class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                    @click.prevent="modalOpen = true">
                                    <svg class="w-4 h-4" viewBox="0 0 16 16"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path class="fill-current text-slate-200"
                                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                        <path class="fill-current text-slate-200"
                                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                                    </svg>
                                    <span></span>
                                </button>
                                <!-- Modal backdrop -->
                                <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                    x-show="modalOpen"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-out duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0" aria-hidden="true"
                                    x-cloak>
                                </div>
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
        
                                    <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
                                        @click.outside="modalOpen = false"
                                        @keydown.escape.window="modalOpen = false">
                                        <!-- Modal header -->
                                        <div class="px-5 py-3 border-b border-slate-200">
                                            <div class="flex justify-between items-center">
                                                <div class="font-semibold text-slate-800">Select Previous DP</div>
                                                <button type="button"
                                                    class="text-slate-400 hover:text-slate-500"
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
                                        <div class="modal-content text-xs px-5 py-4">
                                            <div class="flex flex-row text-xs">
                                                <label class="flex flex-row text-xs" hidden>
                                                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status">Status</p>
                                                    <select id="status" class="status form-select flex flex-row ml-3 mb-3 text-xs" name="status">
                                                        <option value="Form Printed" selected>Form Printed</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="costcenter-table"
                                                    class="table table-striped table-bordered text-xs"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Request Date</th>
                                                            <th class="text-center">Due Date</th>
                                                            <th class="text-center">Cost Center #</th>
                                                            <th class="text-center">Applicant</th>
                                                            <th class="text-center">Beneficiary</th>
                                                            <th class="text-center">Company</th>
                                                            <th class="text-center">Description</th>
                                                            <th class="text-center">Total Cost</th>
                                                            <th class="text-center">Notes</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
        
                                            <div class="space-y-3">
                                            </div>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="px-5 py-4 border-t border-slate-200">
                                            <div class="flex flex-wrap justify-end space-x-2">
                                                <button type="button"
                                                    class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                    @click="modalOpen = false">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file45">Previous DP Cost Center Document</label>
                    <input id="dp_file" name="dp_file" class="dp_file form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                    <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">File max size 12MB</div>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Add Cost Center Detail
                    </label>
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white btn-reimburse" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                            <svg class="w-4 h-4 fill-current  text-slate-200" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
                            <span></span>
                        </button>
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

                            <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
                            @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add Detail</div>
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
                                <div class="modal-content text-xs px-5 py-4">
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Cost Center Type <span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <select id="type" name="type" class="type form-select w-full md:w-3/4 px-2 py-1" style="width: 62rem">
                                                <option value="" selected hidden>Select Type</option>
                                            @foreach ( $dataType as $type)
                                                <option value="{{$type->id}}">{{$type->cost_type}}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" id="typeName" onchange="types(ths)" hidden/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="date_fact">Date<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="date_fact" name="date_fact" value="{{date('Y-m-d')}}"
                                        class="date_fact selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                                        required/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="price">Reff #
                                        </label>
                                        <input id="invoice" name="invoice"
                                            class="invoice form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="desc">Description <span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <textarea name="desc" id="desc" class="reimburse form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" maxlength="500"></textarea>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="qty">Qty<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="qty" name="qty"
                                            class="qty numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="unit">Unit Price<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="unit" name="unit"
                                            class="unit form-input extended-numeric-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"/>
                                    </div>
                                    <div class="flex flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Currency / Forex<span
                                            class="text-rose-500">*</span></label>
                                            <div style="width: 28rem; margin-right: 41px;">
                                                <input id="currencySelected" name="currencySelected"
                                                class="currencySelected form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden/>
                                                <select id="currency" name="currency"
                                                    class="currency form-select w-full px-2 py-1">
                                                    <option selected hidden value="">Select Currency</option>
                                                    @foreach ( $dataCurrency as $cur )
                                                    <option value="{{$cur->symbol}}" {{ $cur->symbol === 'IDR' ? 'selected' : '' }}>{{$cur->symbol}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <input style="width: 30rem;" id="forex" name="forex" class="forex form-input numeric-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="1" readonly/>
                                            </div>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="product_price1">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="product_price">Price<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="product_price" name="product_price"
                                            class="product_price extended-numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly/>
                                    </div>
                                    <div class="flex flex-row mb-3">
                                        <label class="text-sm font-medium mb-1 mt-1" for="vatType">Subtotal<span class="text-rose-500">*</span></label>
                                            <div class="mb-3" style="width: 51rem; margin-left: 16.3rem; margin-right: 2rem;">
                                                <input id="subtotal2" name="subtotal2"
                                                class="subtotal2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                type="text" hidden readonly/>
                                                <input id="subtotal" name="subtotal"
                                                    class="subtotal extended-numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200"
                                                    type="text" readonly/>
                                            </div>
                                            <div class="mb-3 mt-1">
                                                <input type="checkbox" class="form-checkbox" id="manualis"/>
                                                <span class="text-sm ml-2">Manual Input</span>
                                            </div>
                                    </div>
                                    <div class="flex flex-row mb-3">
                                        <label class="text-sm font-medium mb-1 mt-1" for="vatType">VAT/Rate/Total</label>
                                            <div class="mb-3" style="width: 6rem; margin-left: 14rem; margin-right: 2rem;">
                                                <select id="vatType" name="vatType" class="vatType form-select w-full px-2 py-1">
                                                    <option value="N/A" selected>N/A</option>
                                                    <option value="DB">DB</option>
                                                    <option value="Manual">Manual</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="vatt" hidden>
                                                <select id="vat" name="vat" style="width: 20rem;" class="vat form-input w-full px-2 py-1 ml-3" hidden>
                                                        <option value="" selected hidden>Select VAT</option>
                                                    @foreach ( $dataVat as $vat)
                                                        <option value="{{$vat->rate}}">{{$vat->name_vat}} {{$vat->rate}}%</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" id="vatName" name="vatName" style="width: 20rem; margin-left: 5px;" class="vatName form-input w-full px-2 py-1" onchange="vatName(ths)" hidden/>
                                            </div>
                                            <div class="mb-3" id="vatt_percent" hidden>
                                                <input type="number" id="vat_percent" name="vat_percent" style="width: 15rem;" class="vat_percent w-full px-2 py-1 form-input read-only:bg-slate-200 ml-3" readonly/>
                                            </div>
                                            <div class="mb-3" id="total_vatt" hidden>
                                                <input type="text" id="total_vat" name="total_vat" style="width: 15rem; margin-left: 10px;" class="total_vat numeric-input w-full md:w-3/4 px-2 py-1 form-input read-only:bg-slate-200 ml-3"/>
                                            </div>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="total">Total</label>
                                        <input id="total2" name="total2" class="total2 numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly/>
                                        <input id="total" name="total" class="total numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                    </div>
                                    <div class="flex flex-row mb-3">
                                        <label class="text-sm font-medium mb-1 mt-1" for="whtType">WHT/Rate/Norma/Total</label>
                                        <div class="mb-3" style="width: 8rem; margin-left: 10.5rem; margin-right: 10px;">
                                            <select id="whtType" name="whtType" class="whtType form-input w-full px-2 py-1">
                                                <option value="N/A" selected>N/A</option>
                                                <option value="DB">DB</option>
                                                <option value="Manual">Manual</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" id="whtt" hidden>
                                            <select id="wht" name="wht" style="width: 12rem;" class="wht form-input w-full px-2 py-1 ml-3" hidden>
                                                    <option value="" selected hidden>Select WHT</option>
                                                @foreach ( $dataWht as $wht)
                                                    <option value="{{$wht->id_wht}}">{{$wht->name_wht}} {{$wht->rate}}%</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" id="whtName" name="whtName" style="width: 12rem; margin-left: 5px;" class="whtName w-full px-2 py-1 form-input" onchange="whtName(ths)" hidden/>
                                        </div>
                                        <div class="mb-3" id="whtt_percent" hidden>
                                            <input type="text" id="wht_percent" name="wht_percent" style="width: 13rem;" class="wht_percent numeric1-input w-20 px-2 py-1 form-input read-only:bg-slate-200 ml-3" readonly/>
                                        </div>
                                        <div class="mb-3" id="normaa" hidden>
                                            <input type="number" id="norma" name="norma" style="width: 13rem;" class="norma w-20 px-2 py-1 form-input read-only:bg-slate-200 ml-3" readonly/>
                                        </div>
                                        <div class="mb-3" id="total_whtt" hidden>
                                            <input type="text" id="total_wht" name="total_wht" style="width: 13rem;" class="total_wht numeric-input w-40 px-2 py-1 form-input read-only:bg-slate-200 ml-3" readonly/>
                                        </div>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="gtotal">Cost Total</label>
                                        <input id="gtotal1" name="gtotal1" class="gtotal1 form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly/>
                                        <input id="gtotal" name="gtotal" class="gtotal numeric-input form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                    </div>
                                    <p id="uploaded" hidden>Uploaded</p>
                                    {{-- <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="remarks">Remarks
                                        </label>
                                        <input id="remarks" name="remarks"
                                            class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div> --}}
                                    <div class="space-y-3">
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                            <button type="button"
                                                class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click="modalOpen = false" id="addProduct">Add Detail</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="tableProductAddBody table table-bordered mt-2 mb-2" style="width:100%">
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
                            {{-- <th class="text-xs text-center">Remarks</th> --}}
                            <th class="text-xs text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="tableProductAddBody" id="tableProductAddBody">
                    </tbody>
                </table>
                <div class="flex flex-row mt-3" hidden>
                    <label class="block w-full md:w-3/4 text-sm font-medium mb-1" for="grandtotal">Grand Total Reimburse</label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200 text-right"
                        type="text" value="{{number_format($dataCC->gtotal, 0, ',', '.')}}"readonly />
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200 text-right"
                        type="text" value="{{number_format($dataCC->gtotal, 0, '', '')}}"readonly />
                    <input id="subtotal1" value="{{number_format($dataCC->subtotal, 0, '', '')}}" name="subtotal1" class="subtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                    <input id="total1" value="{{number_format($dataCC->total, 0, '', '')}}" name="total1" class="total1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                    <input id="gtotal_vat" value="{{number_format($dataCC->total_vat, 0, '', '')}}" name="gtotal_vat" class="gtotal_vat form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                    <input id="gtotal_wht" value="{{number_format($dataCC->total_wht, 0, '', '')}}" name="gtotal_wht" class="gtotal_wht form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                </div>

                @if ($dataCC->approvalstat == "Draft")
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Save Cost Center</span>
                </button> </center>
                @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $('#bank').select2();
        $('#type').select2();
        $('#vat').select2();
        $('#wht').select2();
        $('#bank').on('change', function () {
            const bank = $(this).val();

            if (bank == "1") {
                $('#bankirs').attr('hidden', true);
                $('#bankirs1').attr('hidden', true);
            }else{
                $('#bankirs').attr('hidden', false);
                $('#bankirs1').attr('hidden', false);
            }
        })
        $('#currency').on('change', function (e) {
            const curs = $(this).val();

            if (curs == 'IDR') {
                $("#forex").attr("readonly", true);
                $("#forex").val("1");
            }else{
                $("#forex").attr("readonly", false);
            }
        })
        $('#manualis').on('change', function(e) {
            var subtotal3 = $('#subtotal2').val();
            // Periksa apakah checkbox di-centang (checked) atau tidak (unchecked)
            if ($(this).is(':checked')) {
                // Jika checkbox di-centang, set atribut readonly menjadi false
                $('#subtotal').attr('readonly', false);
            } else {
                // Jika checkbox tidak di-centang, set atribut readonly menjadi true
                $('#subtotal').attr('readonly', true);
                $('#subtotal').val(divider(subtotal3));
            }
        });
        $('#vatType').on('change', function (e) {
            const vatType = $(this).val();
            const whtType = $('#whtType').val();
            const subtotalis = $('#subtotal').val();
            const subtotalisas = $('#subtotal2').val();
            const total = parseFloat($('#total').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            const totalWHT = parseFloat($('#total_wht').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            const grandTotal1 = total - totalWHT;

            if (vatType == 'N/A') {
                $("#vatt").attr("hidden", true);
                $("#vatt_percent").attr("hidden", true);
                $("#total_vatt").attr("hidden", true);
                $("#vat_percent").val('');
                $("#total_vat").val('0');
                $("#vatName").val('');
                $("#vatName").attr("hidden", true);
                $('#gtotal').val(divider(subtotalis));
                $('#gtotal1').val(subtotalisas);
                $("#total").val(subtotalis);
                $("#total2").val(subtotalisas);
                // $("#total").attr("readonly", true);
                // $("#gtotal").attr("readonly", true);
                $("#total_vat").attr("readonly", false);
                $("#vat_percent").attr("readonly", false);
            }else if(vatType == 'Manual') {
                $("#vatt").attr("hidden", true);
                $("#vatt_percent").attr("hidden", false);
                $("#total_vatt").attr("hidden", false);
                $("#vatName").attr("hidden", false);
                $("#total_vat").attr("readonly", false);
                $("#vatName").val('');
                $("#vat").attr("hidden", true);
                $("#vat_percent").attr("readonly", false);
                $('#gtotal').val(divider(grandTotal1));
            }else if(vatType == 'DB') {
                $("#vatt").attr("hidden", false);
                $("#vatt_percent").attr("hidden", false);
                $("#total_vatt").attr("hidden", false);
                $("#vatName").attr("hidden", true);
                $("#vat").attr("hidden", false);
                $("#total_vat").attr("readonly", true);
                $("#vat_percent").attr("readonly", true);
                $('#gtotal').val(divider(grandTotal1));
            }
        }) 
        $('#whtType').on('change', function (e) {
            const whtType = $(this).val();
            const subtotaliss = $('#subtotal').val();
            const totalis = $('#total').val();
            const totalisas = $('#total2').val();

            if (whtType == 'N/A') {
                $("#whtt").attr("hidden", true);
                $("#whtt_percent").attr("hidden", true);
                $("#total_whtt").attr("hidden", true);
                $("#normaa").attr("hidden", true);
                $("#total_wht").attr("readonly", true);
                $("#whtName").attr("hidden", true);
                $("#norma").val('');
                $("#wht_percent").val('');
                $("#total_wht").val('0');
                $("#whtName").val('');
                $("#gtotal").val(totalis);
                $("#gtotal1").val(totalisas);
                // $("#total").attr("readonly", true);
                // $("#gtotal").attr("readonly", true);
            }else if(whtType == 'Manual') {
                $("#whtt").attr("hidden", true);
                $("#whtt_percent").attr("hidden", false);
                $("#total_whtt").attr("hidden", false);
                $("#total_wht").attr("readonly", false);
                $("#whtName").attr("hidden", false);
                $("#wht").attr("hidden", true);
                $("#normaa").attr("hidden", false);
                $("#norma").attr("readonly", false);
                $("#wht_percent").attr("readonly", false);
            }else if(whtType == 'DB') {
                $("#whtt").attr("hidden", false);
                $("#whtt_percent").attr("hidden", false);
                $("#total_whtt").attr("hidden", false);
                $("#whtName").attr("hidden", true);
                $("#wht").attr("hidden", false);
                $("#normaa").attr("hidden", false);
                $("#total_wht").attr("readonly", true);
                $("#norma").attr("readonly", true);
                $("#wht_percent").attr("readonly", true);
            }
        })
        $(document).ready(function () {
            $('#costcenter-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "desc" ]],
                language: {
                    search: "Search Cost Center # : "
                },
                ajax: {
                    url: "{{ route('cost-list.getdata') }}",
                    data:function(d){
                        d.status = $("#status").val()
                        d.company_id = $("#company_id").val()
                        d.idsupplier = $("#idsupplier").val()
                    }
                },
                columns: [
                    {
                        data: "datereq",
                        name: "datereq"
                    },
                    {
                        data: "due_date",
                        name: "due_date"
                    },
                    {
                        data: "idreqform",
                        name: "idreqform"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "applicant",
                        name: "applicant"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "department",
                        name: "department"
                    },
                    {
                        data: "gtotal",
                        name: "gtotal"
                    },
                    {
                        data: "note",
                        name: "note"
                    },
                    {
                        data: "action2",
                        name: "action2"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 9] },
                    { className: 'text-right', targets: [7] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $(".status").on('change', function (e) {
                $('#costcenter-table').DataTable().ajax.reload();
            })
            $(".company_id").on('change', function (e) {
                $('#costcenter-table').DataTable().ajax.reload();
            })
            $(".idsupplier").on('change', function (e) {
                $('#costcenter-table').DataTable().ajax.reload();
            })
            $('#costcenter-table').on("click", ".btn-select", function () {
                const reff = $(this).data("reff");
                const getstotal = $(this).data("gtotal");
                const negativegetstotal = getstotal > 0 ? -getstotal : getstotal;
                            
                $("#dp_view").val(newDivider1(getstotal));
                $("#dp_amount").val(newDivider2(getstotal));
                $('#previousDP_text').text(newDivider1(negativegetstotal));
                $('#previousDP_text').val(newDivider1(negativegetstotal));
                $("#dp_reff").val(reff);
                updateGrandTotal();
                calculateGrandeTotal();
            });
        })

        let grandTotal = parseFloat($('#grandtotal1').val()) || 0;
        let substotal = parseFloat($('#subtotal1').val()) || 0;
        let totals = parseFloat($('#total1').val()) || 0;
        let gtotal_vat = parseFloat($('#gtotal_vat').val()) || 0;
        let gtotal_wht = parseFloat($('#gtotal_wht').val()) || 0;
        function calculatesGrandsTotal() {
            var substotal = 0;
            var totals = 0;
            var grandTotal = 0;
            var gtotal_vat = 0;
            var gtotal_wht = 0;
            $('.tableProductAddBody tbody tr').each(function() {
                const substotalas = parseFloat($(this).find('input[name^="subtotal1_"]').val()) || 0;
                const grandstotalas = parseFloat($(this).find('input[name^="paid_total_"]').val()) || 0;
                const totalslas = parseFloat($(this).find('input[name^="total1_"]').val()) || 0;
                const vatTotalas = parseFloat($(this).find('input[name^="total_vat1_"]').val()) || 0;
                const whtTotalas = parseFloat($(this).find('input[name^="total_wht1_"]').val()) || 0;
                // substotal += substotalas;
                // totals += totalslas;
                // grandTotal += grandstotalas;
                // gtotal_vat += vatTotalas;
                // gtotal_wht += whtTotalas;
                substotal += substotalas;
                totals += totalslas;
                grandTotal += grandstotalas;
                gtotal_vat += vatTotalas;
                gtotal_wht += whtTotalas;

                // console.log(substotal, totals, grandTotal, gtotal_vat, gtotal_wht);
            });
            $('#grandtotal').val(divider(Math.round(grandTotal)));
            $('#grandtotal1').val(Math.round(grandTotal));
            $('#subtotal1').val(Math.round(substotal));
            $('#total1').val(Math.round(totals));
            $('#gtotal_vat').val(Math.floor(gtotal_vat));
            $('#gtotal_wht').val(Math.floor(gtotal_wht));
            updateGrandTotal();
        }
        // $(document).ready(function () {
        //     $('#currency').on('change', function() {
        //         calculatePrice();
        //         calculateTotal();
        //         calculateVAT();
        //         calculateSubtotal();
        //         calculateWHT();
        //         calculateGrandTotal();
        //     });
        //     $('#type').on('change', function() {
        //         types(this);
        //     });
        //     $('#vat').on('change', function() {
        //         vatName(this);
        //         vatPercent(this);
        //         calculateVAT();
        //         calculateSubtotal();
        //         calculateGrandTotal();
        //     });
        //     $('#wht').on('change', function() {
        //         whtName(this);
        //         whtPercent(this);
        //         calculateWHT();
        //         calculateGrandTotal();
        //     });
        //     function types(ths) {
        //         const typeName1 = $('#type option:selected').text(); // Mengambil teks opsi terpilih
        //         $('#typeName').val(typeName1);
        //     }
        //     function vatName(ths) {
        //         const vatName1 = $('#vat option:selected').text(); // Mengambil teks opsi terpilih
        //         $('#vatName').val(vatName1);
        //     }
        //     function vatPercent(ths) {
        //         const vatPercent1 = $('#vat').val(); // Mengambil teks opsi terpilih
        //         $('#vat_percent').val(vatPercent1);
        //     }
        //     function whtName(ths) {
        //         const whtName1 = $('#wht option:selected').text(); // Mengambil teks opsi terpilih
        //         $('#whtName').val(whtName1);
        //     }
        //     function whtPercent(ths) {
        //         const whtId = $(ths).val(); // Mengambil nilai ID WHT yang dipilih
        //         const selectedWht = <?= json_encode($dataWht); ?>.find(wht => wht.id_wht == whtId); // Mencari WHT yang sesuai dengan ID yang dipilih
        //         if (selectedWht) {
        //             const whtRate = selectedWht.rate; // Mengambil nilai rate dari WHT yang dipilih
        //             $('#wht_percent').val(whtRate); // Setel nilai wht_percent dengan nilai rate yang sesuai
        //             const normaValue = selectedWht.norma; // Mengambil nilai norma dari WHT yang dipilih
        //             $('#norma').val(normaValue); // Setel nilai norma dengan nilai norma yang sesuai
        //         } else {
        //             $('#wht_percent').val(''); // Kosongkan nilai jika tidak ada WHT yang sesuai
        //             $('#norma').val(''); // Kosongkan nilai norma jika tidak ada WHT yang sesuai
        //         }
        //     }

        //     function calculatePrice() {
        //         const unitValue = parseFloat($('#unit').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const forexValue = parseFloat($('#forex').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const price5 = unitValue * forexValue;
        //         // const roundedPrice = Math.ceil(price5);
        //         $('#product_price').val(allinDivider(price5));
        //     }

        //     function calculateTotal() {
        //         const qtyValue = $('#qty').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
        //         const priceValue = $('#product_price').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
        //         const totalss1 = qtyValue * priceValue;
        //         const roundedTotal = totalss1;
        //         $('#subtotal2').val(roundedTotal);
        //         $('#subtotal').val(allinDivider(roundedTotal));
        //     }

        //     // function calculateVAT() {
        //     //     const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //     //     const vatPercent = parseFloat($('#vat_percent').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //     //     const totalVAT = Math.floor(subtotal * (vatPercent / 100)); // Memperbarui dengan Math.floor()
        //     //     $('#total_vat').val(allinDivider(totalVAT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
        //     // }
        //     function calculateVAT() {
        //         const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const vatPercent = parseFloat($('#vat_percent').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const totalVAT = subtotal * (vatPercent / 100); // Memperbarui dengan Math.floor()
        //         $('#total_vat').val(allinDivider(totalVAT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
        //     }

        //     function calculateSubtotal() {
        //         const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const totalVAT = parseFloat($('#total_vat').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const subtotals = subtotal + totalVAT;
        //         $('#total2').val(subtotals);
        //         $('#total').val(allinDivider(subtotals)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
        //         // $('#gtotal').val(subtotals));
        //     }

        //     // function calculateWHT() {
        //     //     const subtotal = parseFloat($('#subtotal2').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //     //     const normaPercent = parseFloat($('#norma').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //     //     const whtPercent = parseFloat($('#wht_percent').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //     //     const totalWHT = Math.floor((subtotal * (normaPercent / 100)) * (whtPercent / 100)); // Memperbarui dengan Math.floor()
        //     //     $('#total_wht').val(allinDivider(totalWHT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
        //     // }
        //     function calculateWHT() {
        //         const subtotal = parseFloat($('#subtotal2').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const normaPercent = parseFloat($('#norma').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const whtPercent = parseFloat($('#wht_percent').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const totalWHT = (subtotal * (normaPercent / 100)) * (whtPercent / 100); // Memperbarui dengan Math.floor()
        //         $('#total_wht').val(allinDivider(totalWHT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
        //     }

        //     function calculateGrandTotal() {
        //         const total = parseFloat($('#total2').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const totalWHT = parseFloat($('#total_wht').val().replace(/\./g, '').replace(/\./g, '').replace(/\,/g, '.')) || 0;
        //         const grandTotal = total - totalWHT;
        //         $('#gtotal1').val(grandTotal);
        //         $('#gtotal').val(allinDivider(grandTotal)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
        //     }

        //     // Memanggil fungsi perhitungan saat nilai input berubah
        //     $('#unit, #forex').on('input', function() {
        //         calculatePrice();
        //         calculateTotal();
        //         calculateVAT();
        //         calculateSubtotal();
        //         calculateWHT();
        //         calculateGrandTotal();
        //     });

        //     $('#qty, #product_price').on('input', function() {
        //         calculateTotal();
        //         calculateVAT();
        //         calculateSubtotal();
        //         calculateWHT();
        //         calculateGrandTotal();
        //     });

        //     $('#vat_percent, #subtotal').on('input', function() {
        //         calculateVAT();
        //         calculateSubtotal();
        //         calculateGrandTotal();
        //     });
        //     $('#total_vat').on('input', function() {
        //         calculateSubtotal();
        //         calculateGrandTotal();
        //     });

        //     $('#norma, #wht_percent, #subtotal').on('input', function() {
        //         calculateWHT();
        //         calculateGrandTotal();
        //     });
        //     $('#total_wht').on('input', function() {
        //         calculateGrandTotal();
        //     });
        //     $("#addProduct").click(function () {
        //         // var productIdx = makeid(3);
        //         let productIdx = $('#tableProductAddBody tr').length-1;
        //         var unit = $('#unit').val();
        //         var unit123 = $('#unit').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var forex = $('#forex').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var forex1 = $('#forex').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var currency = $('#currency').val();
        //         var qty = $('#qty').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var qty2 = $('#qty').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var price = $('#product_price').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var price2 = $('#product_price').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var type = $('#type').val();
        //         var date = $('#date_fact').val();
        //         var inovice = $('#invoice').val();
        //         var typeName = $('#typeName').val();
        //         var desc = $('#desc').val();
        //         var subtotal = $('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var subtotal1 = $('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var subtotal2 = $('#subtotal2').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var vat = $('#vatName').val();
        //         var vatPercent = $('#vat_percent').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
        //         var vatPercent1 = $('#vat_percent').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
        //         var totalVat = $('#total_vat').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var totalVat1 = $('#total_vat').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
        //         var totalis = $('#total').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var totalis1 = $('#total2').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var wht = $('#whtName').val();
        //         var whtPercent = $('#wht_percent').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
        //         var whtPercent1 = $('#wht_percent').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
        //         var norma = $('#norma').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
        //         var totalWht = $('#total_wht').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var totalWht1 = $('#total_wht').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
        //         var gtotal = $('#gtotal').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var gtotal1 = $('#gtotal').val().replace(/\./g, '').replace(/\,/g, '.');
        //         var gtotal2 = $('#gtotal1').val().replace(/\./g, '').replace(/\,/g, '.');
        //         // var remarks = $('#remarks').val();
        //         var MAX_CHANGE = 30000;
        //         // var file = $('#file')[0].files[0]; // Ambil file yang dipilih
        //         // var file1 = file ? file.name : ''; // Gunakan nama file atau kosongkan jika tidak ada file yang dipilih

        //         // var tr = "<tr id=\"row-" + productIdx + "\">\n" +
        //         //     "  <td class=\"text-left\">" + typeName + "<input type=\"hidden\" name = \"types" + productIdx + "\"value =" + type + "><input type=\"hidden\" name = \"ids[]\" value =" + productIdx + " class=\"hidden\"/></td>\n" +
        //         //     "  <td class=\"text-left\">" + desc + "<textarea name = \"reimburses" + productIdx + "\"hidden>" + desc + "</textarea></td>\n" +
        //         //     "  <td class=\"text-right\">" + `${divider(gtotal)}` + "<input type=\"hidden\" name = \"prices" + productIdx + "\" value =" + gtotal + "></td>\n" +
        //         //     "  <td class=\"text-left\">" + file1 + "</td>\n" +
        //             // "   <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(`" + productIdx + "`,`" + total + "`)\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
        //         // "</tr>";

        //         var invoiceExists = false;

        //         if (type === '' || desc === '' || subtotal === '' || date === '' || currency === '' || !qty || !price) {
        //             alert('Data Detail Cost Center Must Fill');
        //             return false;
        //         }

        //         if (inovice === '' || inovice === null || inovice === 'null') {
        //             invoiceExists = false; // Set invoiceExists ke false karena invoice tidak diisi
        //         } else {
        //             $('#invoiceDetail tr').each(function () {
        //                 var invoiceNumber = $(this).find('td:eq(0)').text().trim();
        //                 if (invoiceNumber === inovice) {
        //                     invoiceExists = true;
        //                     return false; // Menghentikan pencarian jika invoice ditemukan
        //                 }
        //             });
        //         }

        //         // Tidak menampilkan alert jika invoice null atau kosong
        //         if (invoiceExists) {
        //             alert('Invoice Already Exist');
        //         }
        //         var invoiceExists1 = $('#tableProductAddBody').find('textarea[name^="rows"][name$="[invoices]"]').filter(function() {
        //             return $(this).val() === inovice;
        //         }).length > 0;

        //         if (invoiceExists1) {
        //             alert('Invoice Already Added');
        //         }
        //         var bgColor = "";
        //         if (invoiceExists && invoiceExists1) {
        //             bgColor = "red"; // Jika invoice telah ada dan sudah ditambahkan, background color menjadi merah
        //         }
        //         if (subtotal1 < parseFloat(subtotal2) - parseFloat(MAX_CHANGE) || subtotal1 > parseFloat(subtotal2) + parseFloat(MAX_CHANGE)) {
        //             alert('The Subtotal cannot be less than ' + MAX_CHANGE + ' or more than ' + MAX_CHANGE + ' from the initial value');
        //             return false;
        //         }
        //         substotal += parseFloat(subtotal1)
        //         totals += parseFloat(totalis)
        //         grandTotal += parseFloat(gtotal1)
        //         gtotal_vat += parseFloat(totalVat1)
        //         gtotal_wht += parseFloat(totalWht1)
        //         var tr = "<tr id=\"row-" + productIdx + "\" style=\"background-color: " + bgColor + "\">\n" +
        //             "  <td class=\"text-xs text-right\">" + date + "<input type=\"date\" name = \"rows[" + productIdx + "][dates]\"value =" + date + " hidden></td>\n" +
        //             "  <td class=\"text-xs text-left\">" + typeName + "<input type=\"hidden\" name = \"rows[" + productIdx + "][types]\"value =" + type + "></td>\n" +
        //             "  <td class=\"text-xs text-left\">" + inovice + "<textarea name = \"rows[" + productIdx + "][invoices]\" hidden>" + inovice + "</textarea></td>\n" +
        //             // "<td class=\"text-xs text-left\">" + (invoiceExists ? 'Invoice Already Exist' : '') + (invoiceExists1 ? 'Invoice Already Added' : '') + "</td>\n" +
        //             "  <td class=\"text-xs text-left\">" + desc + "<textarea name = \"rows[" + productIdx + "][descs]\" hidden>" + desc + "</textarea></td>\n" +
        //             "  <td class=\"text-xs text-right\">" + qty + "<input type=\"hidden\" name = \"rows[" + productIdx + "][qtys]\" value =" + qty2 + "></td>\n" +
        //             "  <td class=\"text-xs text-right\">" + currency + " " + unit + "<input type=\"hidden\" name = \"rows[" + productIdx + "][units]\" value =" + unit123 + "></td>\n" +
        //             "  <td class=\"text-xs text-right\">" + forex + "<input type=\"hidden\" name = \"rows[" + productIdx + "][currencys]\" value =" + currency + "><input type=\"hidden\" name = \"rows[" + productIdx + "][forexs]\" value =" + forex1 + "></td>\n" +
        //             "  <td class=\"text-xs text-right\">" + price + "<input type=\"hidden\" name = \"rows[" + productIdx + "][prices]\" value =" + price2 + "></td>\n" +
        //             "  <td class=\"text-xs text-right\">" + subtotal + "<input type=\"hidden\" name = \"rows[" + productIdx + "][subtotals]\" value =" + subtotal1 + "><input type=\"hidden\" name = \"rows[" + productIdx + "][total_vats]\" value =" + totalVat1 + "></td>\n" +
        //             "  <td class=\"text-xs text-left\">" + vat + "<textarea name = \"rows[" + productIdx + "][vats]\" hidden>" + vat + "</textarea><input type=\"hidden\" name = \"rows[" + productIdx + "][totals]\" value =" + totalis + "></td>\n" +
        //             "  <td class=\"text-xs text-right\">" + totalVat + "<input type=\"hidden\" name = \"rows[" + productIdx + "][vat_percents]\" value =" + vatPercent + "></td>\n" +
        //             "  <td class=\"text-xs text-left\">" + wht + "<textarea name = \"rows[" + productIdx + "][whts]\" hidden>" + wht + "</textarea><input type=\"hidden\" name = \"rows[" + productIdx + "][normas]\" value =" + norma + "></td>\n" +
        //             "  <td class=\"text-xs text-right\">" + totalWht + "<input type=\"hidden\" name = \"rows[" + productIdx + "][wht_percents]\" value =" + whtPercent + "><input type=\"hidden\" name = \"rows[" + productIdx + "][total_whts]\" value =" + totalWht1 + "></td>\n" +
        //             "  <td class=\"text-xs text-right\">" + gtotal + "<input type=\"hidden\" name = \"rows[" + productIdx + "][gtotals]\" value =" + gtotal1 + "></td>\n" +
        //             // "  <td class=\"text-xs text-left\">" + remarks + "<textarea name = \"rows[" + productIdx + "][remarkss]\" hidden>" + remarks + "</textarea></td>\n" +
        //             "   <td class=\"text-xs text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(`" + productIdx + "`,`" + subtotal1 + "`,`" + totalis + "`,`" + gtotal1 + "`,`" + totalVat1 + "` ,`" + totalWht1 + "`)\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
        //             "</tr>";
        //         console.log(totalis);
                

        //         // formData.append('file'+productIdx, file);



        //         $('#type').val('');
        //         $('#type option:first').prop('selected', true);
        //         $('#type').val('').trigger('change'); 
        //         $('#manualis').prop('checked', false);
        //         $('#vatType').val('N/A');
        //         $('#whtType').val('N/A');
        //         $('#desc').val('');
        //         $('#invoice').val('');
        //         $('#remarks').val('');
        //         $('#file').val('');
        //         $('#unit').val('');
        //         $('#currency').val('IDR');
        //         $('#forex').val('1');
        //         $('#forex').attr('readonly', true);
        //         $('#qty').val('');
        //         $('#product_price').val('');
        //         $('#subtotal').val('');
        //         $('#subtotal').attr('readonly', true);
        //         $('#subtotal2').val('');
        //         $('#vat').val('');
        //         $('#vat option:first').prop('selected', true);
        //         $('#vat').val('').trigger('change'); 
        //         $('#vatName').val('');
        //         $('#vat_percent').val('');
        //         $('#total_vat').val('');
        //         $('#total').val('');
        //         $('#total2').val('');
        //         $('#wht').val('');
        //         $('#wht option:first').prop('selected', true);
        //         $('#wht').val('').trigger('change'); 
        //         $('#whtName').val('');
        //         $('#wht_percent').val('');
        //         $('#norma').val('');
        //         $('#total_wht').val('');
        //         $('#gtotal').val('');
        //         $('#gtotal1').val('');
        //         $("#vatt").attr("hidden", true);
        //         $("#vatt_percent").attr("hidden", true);
        //         $("#total_vatt").attr("hidden", true);
        //         $("#whtt").attr("hidden", true);
        //         $("#vatName").attr("hidden", true);
        //         $("#whtName").attr("hidden", true);
        //         $("#whtt_percent").attr("hidden", true);
        //         $("#normaa").attr("hidden", true);
        //         $("#total_whtt").attr("hidden", true);
        //         $("#total").attr("readonly", true);
        //         $("#gtotal").attr("readonly", true);
        //         $('#grandtotal').val(`${divider(grandTotal)}`);
        //         $('#grandtotal1').val(grandTotal);
        //         $('#subtotal1').val(substotal);
        //         $('#total1').val(totals);
        //         $('#gtotal_vat').val(gtotal_vat);
        //         $('#gtotal_wht').val(gtotal_wht);
        //         updateGrandTotal();
        //         calculateGrandeTotal();

                
        //         var totalRow = $('.totalRow').detach();
        //         var DPRow = $('.DPRow').detach();
        //         var gradTotalRow = $('.gradTotalRow').detach();

        //         $('#tableProductAddBody').append(tr).append(totalRow).append(DPRow).append(gradTotalRow);
        //     });
        // });
        $(document).ready(function () {
            $('#currency').on('change', function() {
                calculatePrice();
                calculateTotal();
                calculateVAT();
                calculateSubtotal();
                calculateWHT();
                calculateGrandTotal();
            });
            $('#type').on('change', function() {
                types(this);
            });
            $('#vat').on('change', function() {
                vatName(this);
                vatPercent(this);
                calculateVAT();
                calculateSubtotal();
                calculateGrandTotal();
            });
            $('#wht').on('change', function() {
                whtName(this);
                whtPercent(this);
                calculateWHT();
                calculateGrandTotal();
            });
            function types(ths) {
                const typeName1 = $('#type option:selected').text(); // Mengambil teks opsi terpilih
                $('#typeName').val(typeName1);
            }
            function vatName(ths) {
                const vatName1 = $('#vat option:selected').text(); // Mengambil teks opsi terpilih
                if (vatName1 == 'Select VAT') {
                    $('#vatName').val('');
                }else{
                    $('#vatName').val(vatName1);
                }
            }
            function vatPercent(ths) {
                const vatPercent1 = $('#vat').val(); // Mengambil teks opsi terpilih
                $('#vat_percent').val(vatPercent1);
            }
            function whtName(ths) {
                const whtName1 = $('#wht option:selected').text(); // Mengambil teks opsi terpilih
                if (whtName1 == 'Select WHT') {
                    $('#whtName').val('');
                }else{
                    $('#whtName').val(whtName1);
                }
            }
            function whtPercent(ths) {
                const whtId = $(ths).val(); // Mengambil nilai ID WHT yang dipilih
                const selectedWht = <?= json_encode($dataWht); ?>.find(wht => wht.id_wht == whtId); // Mencari WHT yang sesuai dengan ID yang dipilih
                if (selectedWht) {
                    const whtRate = selectedWht.rate; // Mengambil nilai rate dari WHT yang dipilih
                    $('#wht_percent').val(whtRate); // Setel nilai wht_percent dengan nilai rate yang sesuai
                    const normaValue = selectedWht.norma; // Mengambil nilai norma dari WHT yang dipilih
                    $('#norma').val(normaValue); // Setel nilai norma dengan nilai norma yang sesuai
                } else {
                    $('#wht_percent').val(''); // Kosongkan nilai jika tidak ada WHT yang sesuai
                    $('#norma').val(''); // Kosongkan nilai norma jika tidak ada WHT yang sesuai
                }
            }

            function calculatePrice() {
                const unitValue = parseFloat($('#unit').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const forexValue = parseFloat($('#forex').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const price5 = unitValue * forexValue;
                const roundedPrice = Math.round(price5);
                $('#product_price').val(allinDivider(roundedPrice));
            }

            function calculateTotal() {
                const qtyValue = $('#qty').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                const priceValue = $('#product_price').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                const totalss1 = qtyValue * priceValue;
                const roundedTotal = Math.round(totalss1);
                $('#subtotal2').val(roundedTotal);
                $('#subtotal').val(allinDivider(roundedTotal));
            }

            // function calculateVAT() {
            //     const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            //     const vatPercent = parseFloat($('#vat_percent').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            //     const totalVAT = Math.floor(subtotal * (vatPercent / 100)); // Memperbarui dengan Math.floor()
            //     $('#total_vat').val(allinDivider(totalVAT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
            // }
            function calculateVAT() {
                const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const vatPercent = parseFloat($('#vat_percent').val()) || 0;
                const totalVAT = subtotal * (vatPercent / 100); // Memperbarui dengan Math.floor()
                const roundedVAT = Math.floor(totalVAT);
                $('#total_vat').val(allinDivider(roundedVAT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
            }

            function calculateSubtotal() {
                const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const totalVAT = parseFloat($('#total_vat').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const subtotals = subtotal + totalVAT;
                $('#total2').val(subtotals);
                $('#total').val(allinDivider(subtotals)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
                // $('#gtotal').val(subtotals));
            }

            // function calculateWHT() {
            //     const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            //     const normaPercent = parseFloat($('#norma').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            //     const whtPercent = parseFloat($('#wht_percent').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            //     const totalWHT = Math.floor((subtotal * (normaPercent / 100)) * (whtPercent / 100)); // Memperbarui dengan Math.floor()
            //     $('#total_wht').val(allinDivider(totalWHT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
            // }
            function calculateWHT() {
                const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const normaPercent = parseFloat($('#norma').val()) || 0;
                const whtPercent = parseFloat($('#wht_percent').val()) || 0;
                const totalWHT = subtotal * (normaPercent / 100) * (whtPercent / 100); // Memperbarui dengan Math.floor()
                const roundedWHT = Math.floor(totalWHT);
                $('#total_wht').val(allinDivider(roundedWHT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
            }

            function calculateGrandTotal() {
                const total = parseFloat($('#total').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const totalWHT = parseFloat($('#total_wht').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const grandTotal = parseFloat(total - totalWHT);
                // const grandTotal = parseFloat((total - totalWHT).toFixed(4))
                // const roundedGrandTotal = Math.round((grandTotal + Number.EPSILON) * 1000) / 1000;
                $('#gtotal1').val(grandTotal);
                $('#gtotal').val(allinDivider(grandTotal)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
            }

            // Memanggil fungsi perhitungan saat nilai input berubah
            $('#unit, #forex').on('input', function() {
                calculatePrice();
                calculateTotal();
                calculateVAT();
                calculateSubtotal();
                calculateWHT();
                calculateGrandTotal();
            });

            $('#qty, #product_price').on('input', function() {
                calculateTotal();
                calculateVAT();
                calculateSubtotal();
                calculateWHT();
                calculateGrandTotal();
            });

            $('#vat_percent, #subtotal').on('input', function() {
                calculateVAT();
                calculateSubtotal();
                calculateGrandTotal();
            });
            $('#total_vat').on('input', function() {
                calculateSubtotal();
                calculateGrandTotal();
            });

            $('#norma, #wht_percent, #subtotal').on('input', function() {
                calculateWHT();
                calculateGrandTotal();
            });
            $('#total_wht').on('input', function() {
                calculateGrandTotal();
            });
            $("#addProduct").click(function () {
                // var productIdx = makeid(3);
                var prods = [];
                let productIdx = $('#tableProductAddBody tr').length-3;
                console.log(productIdx);
                var unit = $('#unit').val();
                var unit123 = $('#unit').val().replace(/\./g, '').replace(/\,/g, '.');
                var forex = $('#forex').val().replace(/\./g, '').replace(/\,/g, '.');
                var forex1 = $('#forex').val().replace(/\./g, '').replace(/\,/g, '.');
                var currency = $('#currency').val();
                var qty = $('#qty').val().replace(/\./g, '').replace(/\,/g, '.');
                var qty2 = $('#qty').val().replace(/\./g, '').replace(/\,/g, '.');
                var price = $('#product_price').val();
                var price2 = $('#product_price').val().replace(/\./g, '').replace(/\,/g, '.');
                var type = $('#type').val();
                var date = $('#date_fact').val();
                var invoice = $('#invoice').val();
                var typeName = $('#typeName').val();
                var desc = $('#desc').val();
                var subtotal = $('#subtotal').val();
                var subtotal1 = $('#subtotal').val().replace(/\./g, '').replace(/\,/g, '.');
                var subtotal2 = $('#subtotal2').val();
                var vatTypes = $('#vatType').val();
                var vats = $('#vat').val();
                var vat = $('#vatName').val();
                var vatPercent = $('#vat_percent').val() || 0;
                var vatPercent1 = $('#vat_percent').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                var totalVat = $('#total_vat').val().replace(/\./g, '').replace(/\,/g, '.');
                var totalVat1 = $('#total_vat').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                var totalis = $('#total').val().replace(/\./g, '').replace(/\,/g, '.');
                var totalis1 = $('#total2').val().replace(/\./g, '').replace(/\,/g, '.');
                var whtTypes = $('#whtType').val();
                var whts = $('#wht').val();
                var wht = $('#whtName').val();
                var whtPercent = $('#wht_percent').val() || 0;
                var whtPercent1 = $('#wht_percent').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                var norma = $('#norma').val() || 0;
                var totalWht = $('#total_wht').val().replace(/\./g, '').replace(/\,/g, '.');
                var totalWht1 = $('#total_wht').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                var gtotal = $('#gtotal').val();
                var gtotal1 = $('#gtotal').val().replace(/\./g, '').replace(/\,/g, '.');
                var gtotal2 = $('#gtotal1').val().replace(/\./g, '').replace(/\,/g, '.');
                // var remarks = $('#remarks').val();
                var MAX_CHANGE = 30000;
                // var file = $('#file')[0].files[0]; // Ambil file yang dipilih
                // var file1 = file ? file.name : ''; // Gunakan nama file atau kosongkan jika tidak ada file yang dipilih

                // var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                //     "  <td class=\"text-left\">" + typeName + "<input type=\"hidden\" name = \"types" + productIdx + "\"value =" + type + "><input type=\"hidden\" name = \"ids[]\" value =" + productIdx + " class=\"hidden\"/></td>\n" +
                //     "  <td class=\"text-left\">" + desc + "<textarea name = \"reimburses" + productIdx + "\"hidden>" + desc + "</textarea></td>\n" +
                //     "  <td class=\"text-right\">" + `${divider(gtotal)}` + "<input type=\"hidden\" name = \"prices" + productIdx + "\" value =" + gtotal + "></td>\n" +
                //     "  <td class=\"text-left\">" + file1 + "</td>\n" +
                    // "   <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(`" + productIdx + "`,`" + total + "`)\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
                // "</tr>";

                var invoiceExists = false;

                if (type === '' || desc === '' || subtotal === '' || date === '' || currency === '' || !qty || !price) {
                    alert('Data Detail Cost Center Must Fill');
                    return false;
                }

                if (invoice === '' || invoice === null || invoice === 'null') {
                    invoiceExists = false; // Set invoiceExists ke false karena invoice tidak diisi
                } else {
                    $('#invoiceDetail tr').each(function () {
                        var invoiceNumber = $(this).find('td:eq(0)').text().trim();
                        if (invoiceNumber === invoice) {
                            invoiceExists = true;
                            return false; // Menghentikan pencarian jika invoice ditemukan
                        }
                    });
                }

                // Tidak menampilkan alert jika invoice null atau kosong
                if (invoiceExists) {
                    alert('Invoice Already Exist');
                }
                var invoiceExists1 = $('#tableProductAddBody').find('textarea[name^="rows"][name$="[invoices]"]').filter(function() {
                    return $(this).val() === invoice;
                }).length > 0;

                if (invoiceExists1) {
                    alert('Invoice Already Added');
                }
                var bgColor = "";
                if (invoiceExists && invoiceExists1) {
                    bgColor = "red"; // Jika invoice telah ada dan sudah ditambahkan, background color menjadi merah
                }
                if (subtotal1 < parseFloat(subtotal2) - parseFloat(MAX_CHANGE) || subtotal1 > parseFloat(subtotal2) + parseFloat(MAX_CHANGE)) {
                    alert('The Subtotal cannot be less than ' + MAX_CHANGE + ' or more than ' + MAX_CHANGE + ' from the initial value');
                    
                    return false;
                }
                // substotal += Math.round(parseFloat(subtotal1));
                // totals += Math.round(parseFloat(totalis));
                // grandTotal += Math.round(parseFloat(gtotal1));
                // gtotal_vat += Math.floor(parseFloat(totalVat1));
                // gtotal_wht += Math.floor(parseFloat(totalWht1));
                $(document).ready(function () {
                    $(document).on('change', `[id^="type_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        const typeName2 = $(`#type_${productIdx} option:selected`).text();
                        $(`#typeName_${productIdx}`).val(typeName2);
                    });
                    $(document).on('change', `[id^="manualis_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        const subtotal321 = $(`#subtotal2_${productIdx}`).val();
                        // Periksa apakah checkbox di-centang (checked) atau tidak (unchecked)
                        if ($(this).is(':checked')) {
                            // Jika checkbox di-centang, set atribut readonly menjadi false
                            $(`#subtotal_${productIdx}`).attr('readonly', false);
                        } else {
                            // Jika checkbox tidak di-centang, set atribut readonly menjadi true
                            $(`#subtotal_${productIdx}`).attr('readonly', true);
                            $(`#subtotal_${productIdx}`).val(divider(subtotal321));
                        }
                    });
                    $(document).on('change', `[id^="currency_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        const curs1 = $(`#currency_${productIdx}`).val();

                        if (curs1 == 'IDR') {
                            $(`#forex_${productIdx}`).attr("readonly", true);
                            $(`#forex_${productIdx}`).val("1");
                        }else{
                            $(`#forex_${productIdx}`).attr("readonly", false);
                        }
                        calculatePrice(productIdx);
                        calculateTotal(productIdx);
                        calculateVAT(productIdx);
                        calculateSubtotal(productIdx);
                        calculateWHT(productIdx);
                        calculateGrandTotal(productIdx);
                    });
                    $(document).on('change', `[id^="vat_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        vatName(productIdx);
                        vatPercent(productIdx);
                        calculateVAT(productIdx);
                        calculateSubtotal(productIdx);
                        calculateGrandTotal(productIdx);
                    });

                    $(document).on('change', `[id^="wht_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        whtName(productIdx);
                        whtPercent(productIdx);
                        calculateWHT(productIdx);
                        calculateGrandTotal(productIdx);
                    });

                    function vatName(productIdx) {
                        const vatName1 = $(`#vat_${productIdx} option:selected`).text(); // Mengambil teks opsi terpilih
                        $(`#vatName_${productIdx}`).val(vatName1);
                    }

                    function vatPercent(productIdx) {
                        const vatPercent1 = $(`#vat_${productIdx}`).val(); // Mengambil teks opsi terpilih
                        $(`#vatpercent_${productIdx}`).val(vatPercent1);
                    }

                    function whtName(productIdx) {
                        const whtName1 = $(`#wht_${productIdx} option:selected`).text(); // Mengambil teks opsi terpilih
                        $(`#whtName_${productIdx}`).val(whtName1);
                    }

                    function whtPercent(productIdx) {
                        const whtId = $(`#wht_${productIdx}`).val(); // Mengambil nilai ID WHT yang dipilih
                        const selectedWht = <?= json_encode($dataWht); ?>.find(wht => wht.id_wht == whtId); // Mencari WHT yang sesuai dengan ID yang dipilih
                        if (selectedWht) {
                            const whtRate = selectedWht.rate; // Mengambil nilai rate dari WHT yang dipilih
                            $(`#wht_percent_${productIdx}`).val(whtRate); // Setel nilai wht_percent dengan nilai rate yang sesuai
                            const normaValue = selectedWht.norma; // Mengambil nilai norma dari WHT yang dipilih
                            $(`#norma_${productIdx}`).val(normaValue); // Setel nilai norma dengan nilai norma yang sesuai
                        } else {
                            $(`#wht_percent_${productIdx}`).val(''); // Kosongkan nilai jika tidak ada WHT yang sesuai
                            $(`#norma_${productIdx}`).val(''); // Kosongkan nilai norma jika tidak ada WHT yang sesuai
                        }
                    }
                    function calculatePrice(productIdx) {
                        const unitValue = $('#unit1_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                        const forexValue = $('#forex_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                        const price5 = unitValue * forexValue;
                        const roundedPrice = Math.round(price5);
                        $('#price_' + productIdx).val(allinDivider(roundedPrice));
                    }
                    function calculateTotal(productIdx) {
                        const qtyValue = parseFloat($('#qty_' + productIdx).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
                        const priceValue = parseFloat($('#price_' + productIdx).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
                        const total = qtyValue * priceValue;
                        const roundedTotal = Math.round(total);
                        $('#subtotal2_' + productIdx).val(roundedTotal);
                        $('#subtotal_' + productIdx).val(allinDivider(roundedTotal));
                    }
                    function calculateVAT(productIdx) {
                        const subtotal = parseFloat($('#subtotal_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                        const vatPercent = parseFloat($('#vatpercent_' + productIdx).val()) || 0;
                        const totalVAT = subtotal * (vatPercent / 100); // Memperbarui dengan Math.floor()
                        const roundedVAT = Math.floor(totalVAT);
                        $('#totalvat_' + productIdx).val(allinDivider(roundedVAT));
                    }
                    function calculateSubtotal(productIdx) {
                        const subtotal = parseFloat($('#subtotal_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                        const totalVAT = parseFloat($('#totalvat_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                        const subtotals = subtotal + totalVAT;
                        $('#total_' + productIdx).val(allinDivider(subtotals)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
                        // $('#gtotal').val(divider(subtotals));
                    }

                    function calculateWHT(productIdx) {
                        const subtotal = parseFloat($('#subtotal_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                        const normaPercent = parseFloat($('#norma_' + productIdx).val()) || 0;
                        const whtPercent = parseFloat($('#wht_percent_' + productIdx).val()) || 0;
                        const totalWHT = subtotal * (normaPercent / 100) * (whtPercent / 100); // Memperbarui dengan Math.floor()
                        const roundedWHT = Math.floor(totalWHT);
                        $('#total_wht_' + productIdx).val(allinDivider(roundedWHT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
                    }

                    function calculateGrandTotal(productIdx) {
                        const total = parseFloat($('#total_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                        const totalWHT = parseFloat($('#total_wht_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                        const grandTotal = parseFloat(total - totalWHT);
                        // const roundedGrandTotal = Math.round((grandTotal + Number.EPSILON) * 1000) / 1000;
                        $('#gtotal_' + productIdx).val(allinDivider(grandTotal)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
                    }

                    $(document).on('input', `[id^="unit1_"], [id^="forex_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        calculatePrice(productIdx);
                        calculateTotal(productIdx);
                        calculateVAT(productIdx);
                        calculateSubtotal(productIdx);
                        calculateWHT(productIdx);
                        calculateGrandTotal(productIdx);
                    });
                    $(document).on('input', `[id^="qty_"], [id^="price_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        calculateTotal(productIdx);
                        calculateVAT(productIdx);
                        calculateSubtotal(productIdx);
                        calculateWHT(productIdx);
                        calculateGrandTotal(productIdx);
                    });
                    $(document).on('input', `[id^="subtotal_"], [id^="vatpercent_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        calculateVAT(productIdx);
                        calculateSubtotal(productIdx);
                        calculateGrandTotal(productIdx);
                    });

                    $(document).on('input', `[id^="totalvat_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        calculateSubtotal(productIdx);
                        calculateGrandTotal(productIdx);
                    });

                    $(document).on('input', `[id^="wht_percent_"]`, function (e) {
                    const productIdx = this.id.split('_')[2];
                    calculateWHT(productIdx);
                    calculateGrandTotal(productIdx);
                });

                    $(document).on('input', `[id^="norma_"], [id^="subtotal_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        calculateWHT(productIdx);
                        calculateGrandTotal(productIdx);
                    });

                    $(document).on('input', `[id^="total_wht_"]`, function (e) {
                        const productIdx = this.id.split('_')[2];
                        calculateGrandTotal(productIdx);
                    });

                    $(document).on('change', `[id^="vatType_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        const vatType = $(this).val();
                        const subtotalis = $(`#subtotal_${productIdx}`).val();
                        const whtType = $(`#whtType_${productIdx}`).val();
                        const total = parseFloat($(`#total_${productIdx}`).val().replace(/\./g, '')) || 0;
                        const totalWHT = parseFloat($(`#total_wht_${productIdx}`).val().replace(/\./g, '')) || 0;
                        const grandTotal1 = total - totalWHT;

                        if (vatType == 'N/A') {
                            $(`#vatt_${productIdx}`).attr("hidden", true);
                            $(`#vatt_percent_${productIdx}`).attr("hidden", true);
                            $(`#total_vatt_${productIdx}`).attr("hidden", true);
                            $(`#vatName_${productIdx}`).attr("hidden", true);
                            $(`#vatpercent_${productIdx}`).val('0');
                            $(`#totalvat_${productIdx}`).val('0');
                            $(`#vatName_${productIdx}`).val('');
                            $(`#gtotal_${productIdx}`).val(divider(grandTotal1));
                            $(`#total_${productIdx}`).val(subtotalis);
                            $(`#total_${productIdx}`).attr("readonly", true);
                            $(`#gtotal_${productIdx}`).attr("readonly", true);
                            $(`#totalvat_${productIdx}`).attr("readonly", false);
                            $(`#vatpercent_${productIdx}`).attr("readonly", false);
                        }else if(vatType == 'Manual') {
                            $(`#vatt_${productIdx}`).attr("hidden", false);
                            $(`#vatt_percent_${productIdx}`).attr("hidden", false);
                            $(`#total_vatt_${productIdx}`).attr("hidden", false);
                            $(`#totalvat_${productIdx}`).attr("readonly", false);
                            $(`#vatName_${productIdx}`).attr("hidden", false);
                            $(`#vat_${productIdx}`).attr("hidden", true);
                            $(`#vatpercent_${productIdx}`).attr("readonly", false);
                            $(`#gtotal_${productIdx}`).val(divider(grandTotal1));
                        }else if(vatType == 'DB') {
                            $(`#vatt_${productIdx}`).attr("hidden", false);
                            $(`#vatt_percent_${productIdx}`).attr("hidden", false);
                            $(`#total_vatt_${productIdx}`).attr("hidden", false);
                            $(`#vatName_${productIdx}`).attr("hidden", true);
                            $(`#vat_${productIdx}`).attr("hidden", false);
                            $(`#totalvat_${productIdx}`).attr("readonly", true);
                            $(`#vatpercent_${productIdx}`).attr("readonly", true);
                            $(`#total_${productIdx}`).attr("readonly", true);
                            $(`#gtotal_${productIdx}`).attr("readonly", true);
                            $(`#gtotal_${productIdx}`).val(divider(grandTotal1));
                        }
                    });
                    $(document).on('change', `[id^="whtType_"]`, function (e) {
                        const productIdx = this.id.split('_')[1];
                        const whtType = $(this).val();
                        const subtotaliss = $(`#subtotal_${productIdx}`).val();
                        const totalisss1 = $(`#total_${productIdx}`).val();
                        if (whtType == 'N/A') {
                            $(`#whtt_${productIdx}`).attr("hidden", true);
                            $(`#whtt_percent_${productIdx}`).attr("hidden", true);
                            $(`#total_whtt_${productIdx}`).attr("hidden", true);
                            $(`#normaa_${productIdx}`).attr("hidden", true);
                            $(`#whtName_${productIdx}`).attr("hidden", true);
                            $(`#norma_${productIdx}`).val('0');
                            $(`#wht_percent_${productIdx}`).val('0');
                            $(`#total_wht_${productIdx}`).val('0');
                            $(`#whtName_${productIdx}`).val('');
                            $(`#gtotal_${productIdx}`).val(totalisss1);
                            $(`#total_${productIdx}`).attr("readonly", true);
                            $(`#gtotal_${productIdx}`).attr("readonly", true);
                        }else if(whtType == 'Manual') {
                            $(`#whtt_${productIdx}`).attr("hidden", false);
                            $(`#whtt_percent_${productIdx}`).attr("hidden", false);
                            $(`#total_whtt_${productIdx}`).attr("hidden", false);
                            $(`#total_wht_${productIdx}`).attr("readonly", false);
                            $(`#whtName_${productIdx}`).attr("hidden", false);
                            $(`#wht_${productIdx}`).attr("hidden", true);
                            $(`#normaa_${productIdx}`).attr("hidden", false);
                            $(`#norma_${productIdx}`).attr("readonly", false);
                            $(`#wht_percent_${productIdx}`).attr("readonly", false);
                        }else if(whtType == 'DB') {
                            $(`#whtt_${productIdx}`).attr("hidden", false);
                            $(`#whtt_percent_${productIdx}`).attr("hidden", false);
                            $(`#total_whtt_${productIdx}`).attr("hidden", false);
                            $(`#whtName_${productIdx}`).attr("hidden", true);
                            $(`#wht_${productIdx}`).attr("hidden", false);
                            $(`#normaa_${productIdx}`).attr("hidden", false);
                            $(`#total_wht_${productIdx}`).attr("readonly", true);
                            $(`#norma_${productIdx}`).attr("readonly", true);
                            $(`#wht_percent_${productIdx}`).attr("readonly", true);
                            $(`#total_${productIdx}`).attr("readonly", true);
                            $(`#gtotal_${productIdx}`).attr("readonly", true);
                        }
                    });
                });
                modal_content = `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Cost Center Type
                                                </label>
                                                <select id="type_${productIdx}" name="type" class="type form-select w-full md:w-3/4 px-2 py-1">
                                                    @foreach ( $dataType as $type)
                                                        <option value="{{$type->id}}" ${type == '{{$type->id}}' ? 'selected':''}>{{$type->cost_type}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" id="typeName_${productIdx}" onchange="types(ths)" value="${typeName}" hidden/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="date_fact">Date<span
                                                    class="text-rose-500">*</span>
                                                </label>
                                                <input id="date_fact2_${productIdx}" name="date_fact" value="${date}"
                                                class="date_fact form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="date"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="price">Reff #
                                                </label>
                                                <input id="plate2_${productIdx}" name="plate2"
                                                    class="plate2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${textToInputFormat(invoice === 'null' ? '' : (invoice || ''))}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="reimburse">Description
                                                </label>
                                                <textarea name="reimburse2" id="reimburse2_${productIdx}" class="reimburse2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3">${desc}</textarea>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="qty">Qty
                                                </label>
                                                <input id="qty_${productIdx}" name="qty"
                                                    class="qty cc-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${allinDivider(qty)}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="unit">Unit Price<span
                                                    class="text-rose-500">*</span>
                                                </label>
                                                <input id="unit1_${productIdx}" name="unit"
                                                    class="unit form-input cc-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="${allinDivider(unit123)}" type="text"/>
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Currency / Forex<span
                                                    class="text-rose-500">*</span></label>
                                                    <div style="width: 28rem; margin-right: 41px;">
                                                        <input id="currencySelected" name="currencySelected"
                                                        class="currencySelected form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden/>
                                                        <select id="currency_${productIdx}" name="currency"
                                                            class="currency form-select w-full px-2 py-1">
                                                            @foreach ( $dataCurrency as $cur )
                                                            <option value="{{$cur->symbol}}" ${currency == '{{$cur->symbol}}' ? 'selected':''}>{{$cur->symbol}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <input style="width: 30rem;" id="forex_${productIdx}" name="forex" class="forex form-input cc-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${allinDivider(forex)}" readonly/>
                                                    </div>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="price">Price
                                                </label>
                                                <input id="price_${productIdx}" name="price"
                                                    class="price cc-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${allinDivider(price2)}"/>
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <label class="text-sm font-medium mb-1 mt-1" for="vatType">Subtotal<span class="text-rose-500">*</span></label>
                                                    <div class="mb-3" style="width: 51rem; margin-left: 16.3rem; margin-right: 2rem;">
                                                        <input id="subtotal2_${productIdx}" name="subtotal2"
                                                        class="subtotal2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${subtotal1}" hidden readonly/>
                                                        <input id="subtotal_${productIdx}" name="subtotal"
                                                            class="subtotal extended-numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200"
                                                            type="text" value="${allinDivider(subtotal1)}" readonly/>
                                                    </div>
                                                    <div class="mb-3 mt-1">
                                                        <input type="checkbox" class="form-checkbox" id="manualis_${productIdx}"/>
                                                        <span class="text-sm ml-2">Manual Input</span>
                                                    </div>
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <label class="text-sm font-medium mb-1 mt-1" for="vatType">VAT/Rate/Total</label>
                                                <div class="mb-3" style="width: 8rem; margin-left: 14.3rem;">
                                                    <select id="vatType_${productIdx}" name="vatType" class="vatType form-select px-2 py-1">
                                                        <option value="N/A" ${vatTypes == 'N/A' ? 'selected':''}>N/A</option>
                                                        <option value="DB" ${vatTypes == 'DB' ? 'selected':''}>DB</option>
                                                        <option value="Manual" ${vatTypes == 'Manual' ? 'selected':''}>Manual</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3" id="vatt_${productIdx}" style="text-indent: 29px;" ${vatTypes == 'DB' ? '' : vatTypes == 'N/A' ? 'hidden' : vatTypes == 'Manual' ? 'hidden' : ''}>
                                                    <select id="vat_${productIdx}" name="vat" style="width: 23rem;" class="vat form-input w-full px-2 py-1">
                                                            <option value="" selected hidden>Select VAT</option>
                                                        @foreach ( $dataVat as $vat)
                                                            <option value="{{$vat->rate}}" ${vats == '{{$vat->rate}}' ? 'selected':''}>{{$vat->name_vat}} {{$vat->rate}}%</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" id="vatName_${productIdx}" name="vatName" style="width: 20rem; margin-left: 30px;" class="vatName form-input w-full px-2 py-1 ml-3" onchange="vatName(ths)" value="${textToInputFormat(vat === 'null' ? '' : (vat || ''))}" ${vatTypes == 'DB' ? 'hidden' : vatTypes == 'N/A' ? 'hidden' : vatTypes == 'Manual' ? '' : 'hidden'}/>
                                                </div>
                                                <div class="mb-3" id="vatt_percent_${productIdx}">
                                                    <input type="text" id="vatpercent_${productIdx}" name="vat_percent" style="width: 15rem;" class="vat_percent w-full px-2 py-1 form-input read-only:bg-slate-200 ml-5" value="${vatPercent}" ${vatTypes == 'DB' ? '' : vatTypes == 'N/A' ? 'hidden' : vatTypes == 'Manual' ? '' : 'hidden'} ${vatTypes == 'DB' ? 'readonly' : vatTypes == 'N/A' ? 'readonly' : vatTypes == 'Manual' ? '' : 'readonly'}/>
                                                </div>
                                                <div class="mb-3" id="total_vatt_${productIdx}">
                                                    <input type="text" id="totalvat_${productIdx}" name="total_vat" style="width: 15rem; margin-left: 10px;" class="total_vat numeric-input w-full md:w-3/4 px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${allinDivider(totalVat1)}" ${vatTypes == 'DB' ? '' : vatTypes == 'N/A' ? 'hidden' : vatTypes == 'Manual' ? '' : 'hidden'} ${vatTypes == 'DB' ? 'readonly' : vatTypes == 'N/A' ? 'readonly' : vatTypes == 'Manual' ? '' : 'readonly'}/>
                                                </div>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="total">Total
                                                </label>
                                                <input id="total_${productIdx}" name="total"
                                                class="total form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                type="text" value="${allinDivider(totalis)}" readonly/>
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <label class="text-sm font-medium mb-1 mt-1" for="whtType">WHT/Rate/Total</label>
                                                <div class="mb-3">
                                                    <select id="whtType_${productIdx}" name="whtType" style="width: 6rem; margin-left: 13.9rem;" class="whtType form-select w-full px-2 py-1">
                                                        <option value="N/A" ${whtTypes == 'N/A' ? 'selected':''}>N/A</option>
                                                        <option value="DB" ${whtTypes == 'DB' ? 'selected':''}>DB</option>
                                                        <option value="Manual" ${whtTypes == 'Manual' ? 'selected':''}>Manual</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3" id="whtt_${productIdx}" ${whtTypes == 'DB' ? '' : whtTypes == 'N/A' ? 'hidden' : whtTypes == 'Manual' ? 'hidden' : ''}>
                                                    <select id="wht_${productIdx}" name="wht" style="width: 15rem; margin-left: 30px;" class="wht form-input w-full px-2 py-1">
                                                            <option value="" selected hidden>Select WHT</option>
                                                        @foreach ( $dataWht as $wht)
                                                            <option value="{{$wht->id_wht}}" ${whts == '{{$wht->id_wht}}' ? 'selected':''}>{{$wht->name_wht}} {{$wht->rate}}%</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" id="whtName_${productIdx}" name="whtName" style="width: 15rem; margin-left: 30px;" class="whtName w-full px-2 py-1 form-input ml-3" onchange="whtName(ths)" value="${textToInputFormat(wht === 'null' ? '' : (wht || ''))}" ${whtTypes == 'DB' ? 'hidden' : whtTypes == 'N/A' ? 'hidden' : whtTypes == 'Manual' ? '' : 'hidden'}/>
                                                </div>
                                                <div class="mb-3" id="whtt_percent_${productIdx}">
                                                    <input type="text" id="wht_percent_${productIdx}" name="wht_percent" style="width: 12rem;" class="wht_percent px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${whtPercent}" ${whtTypes == 'DB' ? '' : whtTypes == 'N/A' ? 'hidden' : whtTypes == 'Manual' ? '' : 'hidden'} ${whtTypes == 'DB' ? 'readonly' : whtTypes == 'N/A' ? 'readonly' : whtTypes == 'Manual' ? '' : 'readonly'}/>
                                                </div>
                                                <div class="mb-3" id="normaa_${productIdx}">
                                                    <input type="number" id="norma_${productIdx}" name="norma" style="width: 12rem;" class="norma px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${norma}" ${whtTypes == 'DB' ? '' : whtTypes == 'N/A' ? 'hidden' : whtTypes == 'Manual' ? '' : 'hidden'} ${whtTypes == 'DB' ? 'readonly' : whtTypes == 'N/A' ? 'readonly' : whtTypes == 'Manual' ? '' : 'readonly'}/>
                                                </div>
                                                <div class="mb-3" id="total_whtt_${productIdx}">
                                                    <input type="text" id="total_wht_${productIdx}" name="total_wht" style="width: 12rem;" class="total_wht numeric-input px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${allinDivider(totalWht1)}" ${whtTypes == 'DB' ? '' : whtTypes == 'N/A' ? 'hidden' : whtTypes == 'Manual' ? '' : 'hidden'} ${whtTypes == 'DB' ? 'readonly' : whtTypes == 'N/A' ? 'readonly' : whtTypes == 'Manual' ? '' : 'readonly'}/>
                                                </div>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="gtotal">Cost Total</label>
                                                <input id="gtotal_${productIdx}" name="gtotal" class="gtotal form-input numeric-input md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="${allinDivider(gtotal1)}" type="text" readonly/>
                                            </div>

                                            <div class="space-y-3">
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="px-5 py-4 border-t border-slate-200">
                                                <div class="flex flex-wrap justify-end space-x-2">
                                                    <button type="button"
                                                        class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                        @click="modalOpen = false">Close</button>
                                                    <button type="button"
                                                        class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                        @click="modalOpen = false" onclick="updateDataProduct123('${productIdx}')">Update</button>
                                                </div>
                                            </div>
                                        </div>`
                prods.push({productIdx, date, type, invoice, desc, qty, unit123, forex, price2, subtotal1, vatTypes, vats, vat, vatPercent, totalVat1, whtTypes, whts, wht, whtPercent, totalWht1, gtotal1, modal_content});
                var tr = `<tr id="row-${productIdx}" style="background-color: ${bgColor};">
                    <td class="text-xs text-right"><span id="date-text_${productIdx}">${date}</span><input type="date" id="date_${productIdx}" name = "rows[${productIdx}][dates]" value = "${date}" hidden/></td>
                    <td class="text-xs text-left"><span id="type-text_${productIdx}">${typeName}</span><input type="hidden" id="types_${productIdx}" name = "rows[${productIdx}][types]" value = "${type}"/></td>
                    <td class="text-xs text-left"><span id="plate-text_${productIdx}">${invoice}</span><textarea name = "rows[${productIdx}][invoices]" hidden>${invoice}</textarea></td>
                    <td class="text-xs text-left"><span id="reimburse-text_${productIdx}">${desc}</span><textarea name = "rows[${productIdx}][descs]" hidden>${desc}</textarea></td>
                    <td class="text-xs text-right"><span id="qtys-text_${productIdx}">${allinDivider(qty)}</span><input type="hidden" id="qtys_${productIdx}" name = "rows[${productIdx}][qtys]" value = "${qty2}"/></td>
                    <td class="text-xs text-right"><span id="currencys-text_${productIdx}">${currency}</span> <span id="unit_price-text_${productIdx}">${allinDivider(unit123)}</span><input type="hidden" id="unit_price_${productIdx}" name = "rows[${productIdx}][units]" value = "${unit123}"/></td>
                    <td class="text-xs text-right"><span id="forex-text_${productIdx}">${allinDivider(forex)}</span><input type="hidden" id="currencys_${productIdx}" name = "rows[${productIdx}][currencys]" value = "${currency}"/><input type="hidden" id="forexs_${productIdx}" name = "rows[${productIdx}][forexs]" value = "${forex1}"/></td>
                    <td class="text-xs text-right"><span id="prices-text_${productIdx}">${allinDivider(price2)}</span><input type="hidden" id="prices_${productIdx}" name = "rows[${productIdx}][prices]" value ="${price2}"/></td>
                    <td class="text-xs text-right"><span id="subtotal1-text_${productIdx}">${allinDivider(subtotal1)}</span><input type="hidden" id="subtotal1_${productIdx}" name = "rows[${productIdx}][subtotals]" value = "${subtotal1}"/><input type="hidden" id="total_vat1_${productIdx}" name = "rows[${productIdx}][total_vats]" value = "${totalVat1}"/><input type="text" name="subtotal1_${productIdx}" id="subtotal123_${productIdx}" value="${subtotal1}" hidden/><input type="text" id="total_vat123_${productIdx}" name="total_vat1_${productIdx}" value="${totalVat1}" hidden/></td>
                    <td class="text-xs text-left"><span id="vat_type-text_${productIdx}">${vat}</span><textarea id="vat_type_${productIdx}" name = "rows[${productIdx}][vats]" hidden>${vat}</textarea><input type="hidden" id="total1_${productIdx}" name = "rows[${productIdx}][totals]" value = "${totalis}"/><input type="text" name="total1_${productIdx}" id="total123_${productIdx}" value="${totalis}" hidden/></td>
                    <td class="text-xs text-right"><span id="total_vat1-text_${productIdx}">${allinDivider(totalVat)}</span><input type="hidden" id="vat_percent1_${productIdx}" name = "rows[${productIdx}][vat_percents]" value = "${vatPercent}"/></td>
                    <td class="text-xs text-left"><span id="wht_type-text_${productIdx}">${wht}</span><textarea id="wht_type_${productIdx}" name = "rows[${productIdx}][whts]" hidden>${wht}</textarea><input type="hidden" id="norma1_${productIdx}" name = "rows[${productIdx}][normas]" value = "${norma}"/></td>
                    <td class="text-xs text-right"><span id="total_wht1-text_${productIdx}">${allinDivider(totalWht)}</span><input type="hidden" id="wht_percent1_${productIdx}" name = "rows[${productIdx}][wht_percents]" value = "${whtPercent}"/><input type="hidden" id="total_wht1_${productIdx}" name = "rows[${productIdx}][total_whts]" value = "${totalWht1}"/><input type="text" id="total_wht123_${productIdx}" name="total_wht1_${productIdx}" value="${totalWht1}" hidden/></td>
                    <td class="text-xs text-right"><span id="paid_total-text_${productIdx}">${allinDivider(gtotal1)}</span><input type="hidden" id="paid_total_${productIdx}" name = "rows[${productIdx}][gtotals]" value = "${gtotal1}"/><input type="text" name="paid_total_${productIdx}" id="paid_total123_${productIdx}" value="${gtotal1}" hidden/></td>
                    <td class="flex flex-row justify-center" style="display: flex; justify-content: center;">
                        <button type="button" onclick="deleteDataProduct(${productIdx}, ${subtotal1}, ${totalis}, ${gtotal1}, ${totalVat1}, ${totalWht1})" class="remove_button btn border-slate-200 hover:border-slate-300" > <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg> </button>
                        <div x-data="{ modalOpen: false }">
                                <button class="ml-2 btn bg-emerald-500 hover:bg-emerald-600 text-white" type="button"
                                @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>pen</title><g stroke-width="1" stroke-linecap="round" fill="none" stroke="#ffff" stroke-miterlimit="10" class="nc-icon-wrapper" stroke-linejoin="round"><line x1="10" y1="3" x2="13" y2="6" data-cap="butt" stroke="#ffff"></line> <polygon points="12,1 15,4 5,14 1,15 2,11 " data-cap="butt"></polygon> </g></svg>
                                    <span></span>
                                </button>
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

                                    <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
                                        @click.outside="modalOpen = false"
                                        @keydown.escape.window="modalOpen = false">
                                        <!-- Modal header -->
                                        <div class="px-5 py-3 border-b border-slate-200">
                                            <div class="flex justify-between items-center">
                                                <div class="font-semibold text-slate-800">Adjust Cost Detail</div>
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
                                        `+ prods.find(prod => prod.productIdx == productIdx).modal_content +`
                                    </div>
                                </div>
                            </div>
                    </td>
                    </tr>`;

                // formData.append('file'+productIdx, file);
                $('#type').val('');
                $('#type option:first').prop('selected', true);
                $('#type').val('').trigger('change'); 
                $('#manualis').prop('checked', false);
                $('#vatType').val('N/A');
                $('#whtType').val('N/A');
                $('#desc').val('');
                $('#invoice').val('');
                $('#remarks').val('');
                $('#file').val('');
                $('#unit').val('');
                $('#currency').val('IDR');
                $('#forex').val('1');
                $('#forex').attr('readonly', true);
                $('#qty').val('');
                $('#product_price').val('');
                $('#subtotal').val('');
                $('#subtotal').attr('readonly', true);
                $('#subtotal2').val('');
                $('#vat').val('');
                $('#vat option:first').prop('selected', true);
                $('#vat').val('').trigger('change'); 
                $('#vatName').val('');
                $('#vat_percent').val('');
                $('#total_vat').val('');
                $('#total').val('');
                $('#total2').val('');
                $('#wht').val('');
                $('#wht option:first').prop('selected', true);
                $('#wht').val('').trigger('change'); 
                $('#whtName').val('');
                $('#wht_percent').val('');
                $('#norma').val('');
                $('#total_wht').val('');
                $('#gtotal').val('');
                $('#gtotal1').val('');
                $("#vatt").attr("hidden", true);
                $("#vatt_percent").attr("hidden", true);
                $("#total_vatt").attr("hidden", true);
                $("#whtt").attr("hidden", true);
                $("#vatName").attr("hidden", true);
                $("#whtName").attr("hidden", true);
                $("#whtt_percent").attr("hidden", true);
                $("#normaa").attr("hidden", true);
                $("#total_whtt").attr("hidden", true);
                $("#total").attr("readonly", true);
                $("#gtotal").attr("readonly", true);
                $('#grandtotal').val(divider(parseFloat(grandTotal) + parseFloat(gtotal1)));
                $('#grandtotal1').val(parseFloat(grandTotal) + parseFloat(gtotal1));
                $('#subtotal1').val(parseFloat(substotal) + parseFloat(subtotal1));
                $('#total1').val(parseFloat(totals) + parseFloat(totalis));
                $('#gtotal_vat').val(parseFloat(gtotal_vat) + parseFloat(totalVat1));
                $('#gtotal_wht').val(parseFloat(gtotal_wht) + parseFloat(totalWht1));

                
                var totalRow = $('.totalRow').detach();
                var DPRow = $('.DPRow').detach();
                var gradTotalRow = $('.gradTotalRow').detach();
                

                $('#tableProductAddBody').append(tr).append(totalRow).append(DPRow).append(gradTotalRow);
                updateGrandTotal();
                calculatesGrandsTotal();
            });
        });
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
            var modal_content = '';
            $(document).on('change', `[id^="type_"]`, function (e) {
                const iden = this.id.split('_')[1];
                const typeName2 = $(`#type_${iden} option:selected`).text();
                $(`#typeName_${iden}`).val(typeName2);
            });
            $(document).on('change', `[id^="manualis_"]`, function (e) {
                const iden = this.id.split('_')[1];
                const subtotal321 = $(`#subtotal2_${iden}`).val();
                // Periksa apakah checkbox di-centang (checked) atau tidak (unchecked)
                if ($(this).is(':checked')) {
                    // Jika checkbox di-centang, set atribut readonly menjadi false
                    $(`#subtotal_${iden}`).attr('readonly', false);
                } else {
                    // Jika checkbox tidak di-centang, set atribut readonly menjadi true
                    $(`#subtotal_${iden}`).attr('readonly', true);
                    $(`#subtotal_${iden}`).val(divider(subtotal321));
                }
            });
            $(document).on('change', `[id^="currency_"]`, function (e) {
                const iden = this.id.split('_')[1];
                const curs1 = $(`#currency_${iden}`).val();

                if (curs1 == 'IDR') {
                    $(`#forex_${iden}`).attr("readonly", true);
                    $(`#forex_${iden}`).val("1");
                }else{
                    $(`#forex_${iden}`).attr("readonly", false);
                }
                calculatePrice(iden);
                calculateTotal(iden);
                calculateVAT(iden);
                calculateSubtotal(iden);
                calculateWHT(iden);
                calculateGrandTotal(iden);
            });
            $(document).on('change', `[id^="vat_"]`, function (e) {
                const iden = this.id.split('_')[1];
                vatName(this, iden);
                vatPercent(this, iden);
                calculateVAT(iden);
                calculateSubtotal(iden);
                calculateGrandTotal(iden);
            });
            $(document).on('change', `[id^="wht_"]`, function (e) {
                const iden = this.id.split('_')[1];
                whtName(this, iden);
                whtPercent(this, iden);
                calculateWHT(iden);
                calculateGrandTotal(iden);
            });
            function vatName(ths, iden) {
                const vatName1 = $(`#vat_${iden} option:selected`).text(); // Mengambil teks opsi terpilih
                $(`#vatName_${iden}`).val(vatName1);
            }
            function vatPercent(ths, iden) {
                const vatPercent1 = $(`#vat_${iden}`).val(); // Mengambil teks opsi terpilih
                $(`#vatpercent_${iden}`).val(vatPercent1);
            }
            function whtName(ths, iden) {
                const whtName1 = $(`#wht_${iden} option:selected`).text(); // Mengambil teks opsi terpilih
                $(`#whtName_${iden}`).val(whtName1);
            }
            function whtPercent(ths, iden) {
                const whtId = $(ths).val(); // Mengambil nilai ID WHT yang dipilih
                const selectedWht = <?= json_encode($dataWht); ?>.find(wht => wht.id_wht == whtId); // Mencari WHT yang sesuai dengan ID yang dipilih
                if (selectedWht) {
                    const whtRate = selectedWht.rate; // Mengambil nilai rate dari WHT yang dipilih
                    $(`#wht_percent_${iden}`).val(whtRate); // Setel nilai wht_percent dengan nilai rate yang sesuai
                    const normaValue = selectedWht.norma; // Mengambil nilai norma dari WHT yang dipilih
                    $(`#norma_${iden}`).val(normaValue); // Setel nilai norma dengan nilai norma yang sesuai
                } else {
                    $(`#wht_percent_${iden}`).val(''); // Kosongkan nilai jika tidak ada WHT yang sesuai
                    $(`#norma_${iden}`).val(''); // Kosongkan nilai norma jika tidak ada WHT yang sesuai
                }
            }
            function calculatePrice(iden) {
                const unitValue = $('#unit1_' + iden).val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                const forexValue = $('#forex_' + iden).val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                const price5 = unitValue * forexValue;
                const roundedPrice = Math.round(price5);
                $('#price_' + iden).val(allinDivider(roundedPrice));
            }
            function calculateTotal(iden) {
                const qtyValue = parseFloat($('#qty_' + iden).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
                const priceValue = parseFloat($('#price_' + iden).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
                const total = qtyValue * priceValue;
                const roundedTotal = Math.round(total);
                $('#subtotal2_' + iden).val(roundedTotal);
                $('#subtotal_' + iden).val(allinDivider(roundedTotal));
                // $('#subtotal2_' + iden).val(total.toFixed(0));
                // $('#subtotal_' + iden).val(total.toFixed(0));
            }
            // function calculateVAT(iden) {
            //     const subtotal = parseFloat($('#subtotal_' + iden).val().replace(/\./g, '')) || 0;
            //     const vatPercent = parseFloat($('#vatpercent_' + iden).val()) || 0;
            //     const totalVAT = Math.floor(subtotal * (vatPercent / 100)); // Memperbarui dengan Math.floor()
            //     $('#totalvat_' + iden).val(divider(totalVAT));
            // }
            function calculateVAT(iden) {
                const subtotal = parseFloat($('#subtotal_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const vatPercent = parseFloat($('#vatpercent_' + iden).val()) || 0;
                const totalVAT = subtotal * (vatPercent / 100); // Memperbarui dengan Math.floor()
                const roundedVAT = Math.floor(totalVAT);
                $('#totalvat_' + iden).val(allinDivider(roundedVAT));
            }
            function calculateSubtotal(iden) {
                const subtotal = parseFloat($('#subtotal_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const totalVAT = parseFloat($('#totalvat_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const subtotals = subtotal + totalVAT;
                $('#total_' + iden).val(allinDivider(subtotals)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
                // $('#gtotal').val(divider(subtotals));
            }

            // function calculateWHT(iden) {
            //     const subtotal = parseFloat($('#subtotal_' + iden).val().replace(/\./g, '')) || 0;
            //     const normaPercent = parseFloat($('#norma_' + iden).val()) || 0;
            //     const whtPercent = parseFloat($('#wht_percent_' + iden).val()) || 0;
            //     const totalWHT = Math.floor((subtotal * (normaPercent / 100)) * (whtPercent / 100)); // Memperbarui dengan Math.floor()
            //     $('#total_wht_' + iden).val(divider(totalWHT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
            // }
            function calculateWHT(iden) {
                const subtotal = parseFloat($('#subtotal_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const normaPercent = parseFloat($('#norma_' + iden).val()) || 0;
                const whtPercent = parseFloat($('#wht_percent_' + iden).val()) || 0;
                const totalWHT = subtotal * (normaPercent / 100) * (whtPercent / 100); // Memperbarui dengan Math.floor()
                const roundedWHT = Math.floor(totalWHT);
                $('#total_wht_' + iden).val(allinDivider(roundedWHT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
            }

            function calculateGrandTotal(iden) {
                const total = parseFloat($('#total_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const totalWHT = parseFloat($('#total_wht_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                const grandTotal = parseFloat(total - totalWHT);
                // const roundedGrandTotal = Math.round((grandTotal + Number.EPSILON) * 1000) / 1000;
                $('#gtotal_' + iden).val(allinDivider(grandTotal)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
            }

            $(document).on('input', `[id^="unit1_"], [id^="forex_"]`, function (e) {
                const iden = this.id.split('_')[1];
                calculatePrice(iden);
                calculateTotal(iden);
                calculateVAT(iden);
                calculateSubtotal(iden);
                calculateWHT(iden);
                calculateGrandTotal(iden);
            });
            $(document).on('input', `[id^="qty_"], [id^="price_"]`, function (e) {
                const iden = this.id.split('_')[1];
                calculateTotal(iden);
                calculateVAT(iden);
                calculateSubtotal(iden);
                calculateWHT(iden);
                calculateGrandTotal(iden);
            });
            $(document).on('input', `[id^="subtotal_"], [id^="vatpercent_"]`, function (e) {
                const iden = this.id.split('_')[1];
                calculateVAT(iden);
                calculateSubtotal(iden);
                calculateGrandTotal(iden);
            });

            $(document).on('input', `[id^="totalvat_"]`, function (e) {
                const iden = this.id.split('_')[1];
                calculateSubtotal(iden);
                calculateGrandTotal(iden);
            });

            $(document).on('input', `[id^="wht_percent_"]`, function (e) {
                const productIdx = this.id.split('_')[2];
                calculateWHT(productIdx);
                calculateGrandTotal(productIdx);
            });

            $(document).on('input', `[id^="norma_"], [id^="subtotal_"]`, function (e) {
                const iden = this.id.split('_')[1];
                calculateWHT(iden);
                calculateGrandTotal(iden);
            });

            $(document).on('input', `[id^="total_wht_"]`, function (e) {
                const iden = this.id.split('_')[2];
                calculateGrandTotal(iden);
            });

            $(document).on('change', `[id^="vatType_"]`, function (e) {
                const iden = this.id.split('_')[1];
                const vatType = $(this).val();
                const subtotalis = $(`#subtotal_${iden}`).val();
                const whtType = $(`#whtType_${iden}`).val();
                const total = parseFloat($(`#total_${iden}`).val().replace(/\./g, '')) || 0;
                const totalWHT = parseFloat($(`#total_wht_${iden}`).val().replace(/\./g, '')) || 0;
                const grandTotal1 = total - totalWHT;

                if (vatType == 'N/A') {
                    $(`#vatt_${iden}`).attr("hidden", true);
                    $(`#vatt_percent_${iden}`).attr("hidden", true);
                    $(`#total_vatt_${iden}`).attr("hidden", true);
                    $(`#vatName_${iden}`).attr("hidden", true);
                    $(`#vatpercent_${iden}`).val('0');
                    $(`#totalvat_${iden}`).val('0');
                    $(`#vatName_${iden}`).val('');
                    $(`#gtotal_${iden}`).val(divider(grandTotal1));
                    $(`#total_${iden}`).val(subtotalis);
                    $(`#total_${iden}`).attr("readonly", true);
                    $(`#gtotal_${iden}`).attr("readonly", true);
                    $(`#totalvat_${iden}`).attr("readonly", false);
                    $(`#vatpercent_${iden}`).attr("readonly", false);
                }else if(vatType == 'Manual') {
                    $(`#vatt_${iden}`).attr("hidden", false);
                    $(`#vatt_percent_${iden}`).attr("hidden", false);
                    $(`#total_vatt_${iden}`).attr("hidden", false);
                    $(`#totalvat_${iden}`).attr("readonly", false);
                    $(`#vatName_${iden}`).attr("hidden", false);
                    $(`#vat_${iden}`).attr("hidden", true);
                    $(`#vatpercent_${iden}`).attr("readonly", false);
                    $(`#gtotal_${iden}`).val(divider(grandTotal1));
                }else if(vatType == 'DB') {
                    $(`#vatt_${iden}`).attr("hidden", false);
                    $(`#vatt_percent_${iden}`).attr("hidden", false);
                    $(`#total_vatt_${iden}`).attr("hidden", false);
                    $(`#vatName_${iden}`).attr("hidden", true);
                    $(`#vat_${iden}`).attr("hidden", false);
                    $(`#totalvat_${iden}`).attr("readonly", true);
                    $(`#vatpercent_${iden}`).attr("readonly", true);
                    $(`#total_${iden}`).attr("readonly", true);
                    $(`#gtotal_${iden}`).attr("readonly", true);
                    $(`#gtotal_${iden}`).val(divider(grandTotal1));
                }
            });
            $(document).on('change', `[id^="whtType_"]`, function (e) {
                const iden = this.id.split('_')[1];
                const whtType = $(this).val();
                const subtotaliss = $(`#subtotal_${iden}`).val();
                const totalisss1 = $(`#total_${iden}`).val();
                if (whtType == 'N/A') {
                    $(`#whtt_${iden}`).attr("hidden", true);
                    $(`#whtt_percent_${iden}`).attr("hidden", true);
                    $(`#total_whtt_${iden}`).attr("hidden", true);
                    $(`#normaa_${iden}`).attr("hidden", true);
                    $(`#whtName_${iden}`).attr("hidden", true);
                    $(`#norma_${iden}`).val('0');
                    $(`#wht_percent_${iden}`).val('0');
                    $(`#total_wht_${iden}`).val('0');
                    $(`#whtName_${iden}`).val('');
                    $(`#gtotal_${iden}`).val(totalisss1);
                    $(`#total_${iden}`).attr("readonly", true);
                    $(`#gtotal_${iden}`).attr("readonly", true);
                }else if(whtType == 'Manual') {
                    $(`#whtt_${iden}`).attr("hidden", false);
                    $(`#whtt_percent_${iden}`).attr("hidden", false);
                    $(`#total_whtt_${iden}`).attr("hidden", false);
                    $(`#total_wht_${iden}`).attr("readonly", false);
                    $(`#whtName_${iden}`).attr("hidden", false);
                    $(`#wht_${iden}`).attr("hidden", true);
                    $(`#normaa_${iden}`).attr("hidden", false);
                    $(`#norma_${iden}`).attr("readonly", false);
                    $(`#wht_percent_${iden}`).attr("readonly", false);
                }else if(whtType == 'DB') {
                    $(`#whtt_${iden}`).attr("hidden", false);
                    $(`#whtt_percent_${iden}`).attr("hidden", false);
                    $(`#total_whtt_${iden}`).attr("hidden", false);
                    $(`#whtName_${iden}`).attr("hidden", true);
                    $(`#wht_${iden}`).attr("hidden", false);
                    $(`#normaa_${iden}`).attr("hidden", false);
                    $(`#total_wht_${iden}`).attr("readonly", true);
                    $(`#norma_${iden}`).attr("readonly", true);
                    $(`#wht_percent_${iden}`).attr("readonly", true);
                    $(`#total_${iden}`).attr("readonly", true);
                    $(`#gtotal_${iden}`).attr("readonly", true);
                }
            });
            $.each(prods, function (i,item1) {
                if(value.id == item1.id){
                        modal_content += `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Cost Center Type
                                                </label>
                                                <select id="type_${iden}" name="type" class="type form-select w-full md:w-3/4 px-2 py-1">
                                                    @foreach ( $dataType as $type)
                                                        <option value="{{$type->id}}" ${value.type == '{{$type->id}}' ? 'selected':''}>{{$type->cost_type}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" id="typeName_${iden}" onchange="types(ths)" value="${value.cost_type}" hidden/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="date_fact">Date<span
                                                    class="text-rose-500">*</span>
                                                </label>
                                                <input id="date_fact2_${iden}" name="date_fact" value="${value.date}"
                                                class="date_fact form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="date"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="price">Reff #
                                                </label>
                                                <input id="plate2_${iden}" name="plate2"
                                                    class="plate2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${textToInputFormat(value.invoice_number === 'null' ? '' : (value.invoice_number || ''))}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="reimburse">Description
                                                </label>
                                                <textarea name="reimburse2" id="reimburse2_${iden}" class="reimburse2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3">${value.desc}</textarea>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="qty">Qty
                                                </label>
                                                <input id="qty_${iden}" name="qty"
                                                    class="qty cc-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${allinDivider(value.qty)}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="unit">Unit Price<span
                                                    class="text-rose-500">*</span>
                                                </label>
                                                <input id="unit1_${iden}" name="unit"
                                                    class="unit form-input cc-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="${allinDivider(value.unit_price)}" type="text"/>
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Currency / Forex<span
                                                    class="text-rose-500">*</span></label>
                                                    <div style="width: 28rem; margin-right: 41px;">
                                                        <input id="currencySelected" name="currencySelected"
                                                        class="currencySelected form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden/>
                                                        <select id="currency_${iden}" name="currency"
                                                            class="currency form-select w-full px-2 py-1">
                                                            @foreach ( $dataCurrency as $cur )
                                                            <option value="{{$cur->symbol}}" ${value.currency == '{{$cur->symbol}}' ? 'selected':''}>{{$cur->symbol}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <input style="width: 30rem;" id="forex_${iden}" name="forex" class="forex form-input cc-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(value.forex)}" readonly/>
                                                    </div>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="price">Price
                                                </label>
                                                <input id="price_${iden}" name="price"
                                                    class="price cc-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${allinDivider(value.price)}"/>
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <label class="text-sm font-medium mb-1 mt-1" for="vatType">Subtotal<span class="text-rose-500">*</span></label>
                                                    <div class="mb-3" style="width: 51rem; margin-left: 16.3rem; margin-right: 2rem;">
                                                        <input id="subtotal2_${iden}" name="subtotal2"
                                                        class="subtotal2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${newDivider2(value.subtotal)}" hidden readonly/>
                                                        <input id="subtotal_${iden}" name="subtotal"
                                                            class="subtotal extended-numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200"
                                                            type="text" value="${allinDivider(value.subtotal)}" readonly/>
                                                    </div>
                                                    <div class="mb-3 mt-1">
                                                        <input type="checkbox" class="form-checkbox" id="manualis_${iden}"/>
                                                        <span class="text-sm ml-2">Manual Input</span>
                                                    </div>
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <label class="text-sm font-medium mb-1 mt-1" for="vatType">VAT/Rate/Total</label>
                                                <div class="mb-3" style="width: 8rem; margin-left: 14.3rem;">
                                                    <select id="vatType_${iden}" name="vatType" class="vatType form-select px-2 py-1">
                                                        <option value="N/A">N/A</option>
                                                        <option value="DB" selected>DB</option>
                                                        <option value="Manual">Manual</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3" id="vatt_${iden}" style="text-indent: 29px;">
                                                    <select id="vat_${iden}" name="vat" style="width: 23rem;" class="vat form-input w-full px-2 py-1">
                                                            <option value="" selected hidden>Select VAT</option>
                                                        @foreach ( $dataVat as $vat)
                                                            <option value="{{$vat->rate}}">{{$vat->name_vat}} {{$vat->rate}}%</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" id="vatName_${iden}" name="vatName" style="width: 20rem; margin-left: 30px;" class="vatName form-input w-full px-2 py-1 ml-3" onchange="vatName(ths)" value="${textToInputFormat(value.vat === 'null' ? '' : (value.vat || ''))}" hidden/>
                                                </div>
                                                <div class="mb-3" id="vatt_percent_${iden}">
                                                    <input type="text" id="vatpercent_${iden}" style="width: 15rem;" class="vat_percent w-full px-2 py-1 form-input read-only:bg-slate-200 ml-5" value="${newDivider(value.vat_percent)}" readonly/>
                                                </div>
                                                <div class="mb-3" id="total_vatt_${iden}">
                                                    <input type="text" id="totalvat_${iden}" name="total_vat" style="width: 15rem; margin-left: 10px;" class="total_vat numeric-input w-full md:w-3/4 px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${newDivider1(value.total_vat)}" readonly/>
                                                </div>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="total">Total
                                                </label>
                                                <input id="total_${iden}" name="total"
                                                class="total form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                type="text" value="${newDivider1(value.total)}" readonly/>
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <label class="text-sm font-medium mb-1 mt-1" for="whtType">WHT/Rate/Total</label>
                                                <div class="mb-3">
                                                    <select id="whtType_${iden}" name="whtType" style="width: 6rem; margin-left: 13.9rem;" class="whtType form-select w-full px-2 py-1">
                                                        <option value="N/A">N/A</option>
                                                        <option value="DB">DB</option>
                                                        <option value="Manual" selected>Manual</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3" id="whtt_${iden}">
                                                    <select id="wht_${iden}" name="wht" style="width: 15rem; margin-left: 30px;" class="wht form-input w-full px-2 py-1" hidden>
                                                            <option value="" selected hidden>Select WHT</option>
                                                        @foreach ( $dataWht as $wht)
                                                            <option value="{{$wht->id_wht}}">{{$wht->name_wht}} {{$wht->rate}}%</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" id="whtName_${iden}" name="whtName" style="width: 15rem; margin-left: 30px;" class="whtName w-full px-2 py-1 form-input ml-3" onchange="whtName(ths)" value="${textToInputFormat(value.wht === 'null' ? '' : (value.wht || ''))}"/>
                                                </div>
                                                <div class="mb-3" id="whtt_percent_${iden}">
                                                    <input type="text" id="wht_percent_${iden}" style="width: 12rem;" class="wht_percent px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${newDivider(value.wht_percent)}"/>
                                                </div>
                                                <div class="mb-3" id="normaa_${iden}">
                                                    <input type="number" id="norma_${iden}" name="norma" style="width: 12rem;" class="norma px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${newDivider(value.norma)}"/>
                                                </div>
                                                <div class="mb-3" id="total_whtt_${iden}">
                                                    <input type="text" id="total_wht_${iden}" name="total_wht" style="width: 12rem;" class="total_wht numeric-input px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${newDivider1(value.total_wht)}"/>
                                                </div>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="gtotal">Cost Total</label>
                                                <input id="gtotal_${iden}" name="gtotal" class="gtotal form-input numeric-input md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="${newDivider1(value.paid_total)}" type="text" readonly/>
                                            </div>

                                            <div class="space-y-3">
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="px-5 py-4 border-t border-slate-200">
                                                <div class="flex flex-wrap justify-end space-x-2">
                                                    <button type="button"
                                                        class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                        @click="modalOpen = false">Close</button>
                                                    <button type="button"
                                                        class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                        @click="modalOpen = false" onclick="updateDataProduct('${iden}')">Update</button>
                                                </div>
                                            </div>
                                        </div>`
                }
            })

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
                            <td class="flex flex-row justify-center" style="display: flex; justify-content: center;">
                <button type="button" onclick="deleteDataProduct123('${iden}', document.getElementById('paid_total_${iden}').value, document.getElementById('subtotal1_${iden}').value, document.getElementById('total1_${iden}').value, document.getElementById('total_vat1_${iden}').value, document.getElementById('total_wht1_${iden}').value, ${value.id})" class="btn btn-delete border-slate-200 hover:border-slate-300" > <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/></svg></button>                
                    <div x-data="{ modalOpen: false }">
                                <button class="ml-2 btn bg-emerald-500 hover:bg-emerald-600 text-white" type="button"
                                @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>pen</title><g stroke-width="1" stroke-linecap="round" fill="none" stroke="#ffff" stroke-miterlimit="10" class="nc-icon-wrapper" stroke-linejoin="round"><line x1="10" y1="3" x2="13" y2="6" data-cap="butt" stroke="#ffff"></line> <polygon points="12,1 15,4 5,14 1,15 2,11 " data-cap="butt"></polygon> </g></svg>
                                    <span></span>
                                </button>
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

                                    <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
                                        @click.outside="modalOpen = false"
                                        @keydown.escape.window="modalOpen = false">
                                        <!-- Modal header -->
                                        <div class="px-5 py-3 border-b border-slate-200">
                                            <div class="flex justify-between items-center">
                                                <div class="font-semibold text-sm text-slate-800">Edit Cost Center Detail</div>
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
                                        `+modal_content+`
                                    </div>
                                </div>
                    </div>
                </td>
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
            <td></td>
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
            <td></td>
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
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(gradTotalRow);

        function calculateGrandeTotal() {
            // Get the grand total from your calculation logic
            const grandTotal = parseFloat($('#grandTotal_text').text().replace(/\./g, '').replace(/\,/g, '.')) || 0;

            // Calculate the previous down payment as a negative value
            const previousDownPayment = parseFloat($('#dp_amount').val()) * -1 || 0;

            // Calculate the final grand total by subtracting the down payment
            const gratsTotal = grandTotal + previousDownPayment;

            // Round the grand total if necessary (you can change Math.ceil to Math.round if preferred)
            const roundedGratsTotal = Math.ceil(gratsTotal);

            // Update the displayed grand total
            $('#grandeTotal_text').text(divider(roundedGratsTotal));
            $('#grandeTotal_text').val(divider(roundedGratsTotal));

            // Update hidden input fields with the final values
            // $('#grandtotal').val(divider(roundedGratsTotal));
            // $('#grandtotal1').val(roundedGratsTotal);
        }

        // Event listener for input changes in dp_amount and dp_view
        $('#dp_amount, #dp_view').on('input', function() {
            // Get the value from dp_view and convert it to a float
            const dpview = parseFloat($('#dp_view').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;

            // Convert the down payment view to a negative value if positive
            const negativeDpView = dpview > 0 ? -dpview : dpview;

            // Update dp_amount with the formatted value from dp_view
            $('#dp_amount').val(dpview);

            // Update the previous down payment text and hidden input fields
            $('#previousDP_text').text(divider(negativeDpView));
            $('#previousDP_text').val(divider(negativeDpView));

            // Recalculate and update the grand total
            calculateGrandeTotal();
        });

        // Initial calculation to set the correct grand total on page load
        $(document).ready(function() {
            calculateGrandeTotal();
        });

        function deleteDataProduct(positionTableRow, paid_total, subtotal, total, total_vat, total_wht, dataFromDatabase) {
            const positionTableRowVariable = positionTableRow;
            const dataFromDatabaseVariable = dataFromDatabase;
            console.log(positionTableRow);
            const csrf_token = $('meta[name="csrf-token"]').attr('content');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Want to Delete this Detail Cost Center!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                                const $rowToDelete = $(`#tableProductAddBody tr#row-${positionTableRowVariable}`);
                                $rowToDelete.remove();
                                handleDeleteRow(positionTableRowVariable, paid_total, subtotal, total, total_vat, total_wht);
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Cost Detail has been Deleted.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                        }
                    });
        }
        function handleDeleteRow(positionTableRow, paid_total, subtotal, total, total_vat, total_wht) {
             // Remove the corresponding row using the id
            $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();
            calculatesGrandsTotal(); 
                
            //  // Update grandTotal if it's NaN
            // substotal = isNaN(substotal) ? 0 : substotal;
            // gtotal_vat = isNaN(gtotal_vat) ? 0 : gtotal_vat;
            // totals = isNaN(totals) ? 0 : totals;
            // gtotal_wht = isNaN(gtotal_wht) ? 0 : gtotal_wht;
            // grandTotal = isNaN(grandTotal) ? 0 : grandTotal;
            // // Ensure paid_total is a valid number
            // const parsedSubstotal = parseFloat(subtotal) || 0;
            // const parsedTotalVat = parseFloat(total_vat) || 0;
            // const parsedTotals = parseFloat(total) || 0;
            // const parsedTotalWht = parseFloat(total_wht) || 0;
            // const parsedGtotal = parseFloat(paid_total) || 0;
            //  // Update grandTotal after removing the row
            // substotal = parseFloat(substotal - parsedGtotal, 0);
            // gtotal_vat = parseFloat(gtotal_vat - parsedTotalVat, 0);
            // totals = parseFloat(totals - parsedSubstotal, 0);
            // gtotal_wht = parseFloat(gtotal_wht - parsedTotalWht, 0);
            // grandTotal = parseFloat(grandTotal - parsedTotals, 0);
                    
            // // Update the grandTotal fields
            // $('#grandtotal').val(newDivider1(grandTotal));
            // $('#subtotal1').val(substotal);
            // $('#total1').val(totals);
            // $('#gtotal_vat').val(gtotal_vat);
            // $('#gtotal_wht').val(gtotal_wht);
            // $('#grandtotal1').val(grandTotal);
            // updateGrandTotal();
            // calculatesGrandsTotal();
            updateGrandTotal(); 
        }
        function deleteDataProduct123(positionTableRow, paid_total, subtotal, total, total_vat, total_wht, dataFromDatabase) {
            const positionTableRowVariable = positionTableRow;
            const dataFromDatabaseVariable = dataFromDatabase;
            console.log(positionTableRow);
            const csrf_token = $('meta[name="csrf-token"]').attr('content');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Want to Delete this Detail Cost Center!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                                const $rowToDelete = $(`#tableProductAddBody tr#row-${positionTableRowVariable}`);
                                $rowToDelete.remove();
                                handleDeleteRow123(positionTableRowVariable, paid_total, subtotal, total, total_vat, total_wht);
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Cost Detail has been Deleted.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                        }
                    });
        }
        function handleDeleteRow123(positionTableRow, paid_total, subtotal, total, total_vat, total_wht) {
             // Remove the corresponding row using the id
            $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();
            calculatesGrandsTotal();
                
             // Update grandTotal if it's NaN
            // substotal = isNaN(substotal) ? 0 : substotal;
            // gtotal_vat = isNaN(gtotal_vat) ? 0 : gtotal_vat;
            // totals = isNaN(totals) ? 0 : totals;
            // gtotal_wht = isNaN(gtotal_wht) ? 0 : gtotal_wht;
            // grandTotal = isNaN(grandTotal) ? 0 : grandTotal;
            // Ensure paid_total is a valid number
            // const parsedSubstotal = parseFloat(subtotal) || 0;
            // const parsedTotalVat = parseFloat(total_vat) || 0;
            // const parsedTotals = parseFloat(total) || 0;
            // const parsedTotalWht = parseFloat(total_wht) || 0;
            // const parsedGtotal = parseFloat(paid_total) || 0;
            //  // Update grandTotal after removing the row
            // substotal = parseFloat(substotal - parsedSubstotal, 0);
            // gtotal_vat = parseFloat(gtotal_vat - parsedTotalVat, 0);
            // totals = parseFloat(totals - parsedTotals, 0);
            // gtotal_wht = parseFloat(gtotal_wht - parsedTotalWht, 0);
            // grandTotal = parseFloat(grandTotal - parsedGtotal, 0);
                    
            // // Update the grandTotal fields
            // $('#grandtotal').val(newDivider1(grandTotal));
            // $('#subtotal1').val(substotal);
            // $('#total1').val(totals);
            // $('#gtotal_vat').val(gtotal_vat);
            // $('#gtotal_wht').val(gtotal_wht);
            // $('#grandtotal1').val(grandTotal);
            updateGrandTotal();  
        }

        function updateDataProduct(iden) {
            // var remarks = $('#remarks2_'+iden).val();
            // var remarksTextarea = $(`#row-${iden}`).find(`textarea[name="remarks1_${iden}"]`);
            // Update the textarea value in the current row
            // remarksTextarea.val(remarks);
            // $('#remarks1-text_'+iden).text(remarks);

            var reimburse = $('#reimburse2_'+iden).val();
            var reimburseTextarea = $(`#row-${iden}`).find(`textarea[name="reimburse_${iden}"]`);
            // Update the textarea value in the current row
            reimburseTextarea.val(reimburse);
            $('#reimburse-text_'+iden).text(reimburse);

            var dates = $('#date_fact2_' + iden).val();
            $('#date_' + iden).val(dates);
            $('#date-text_' + iden).text(dates);

            var curesss = $('#currency_'+iden).val();
            $('#currencys_'+iden).val(curesss);
            $('#currencys-text_'+iden).text(curesss);

            var types = $('#type_'+iden).val();
            var typesName = $('#typeName_'+iden).val();
            $('#types_'+iden).val(types);
            $('#type-text_'+iden).text(typesName);

            var platess = $('#plate2_'+iden).val();
            $('#plate_'+iden).val(platess);
            $('#plate-text_'+iden).text(platess);

            var vatNames = $('#vatName_'+iden).val();
            $('#vat_type_'+iden).val(vatNames);
            $('#vat_type-text_'+iden).text(vatNames);

            var vatPercente = parseFloat($('#vatpercent_'+iden).val());
            $('#vat_percent1_'+iden).val(vatPercente);

            var whtNames = $('#whtName_'+iden).val();
            $('#wht_type_'+iden).val(whtNames);
            $('#wht_type-text_'+iden).text(whtNames);

            var whtPercente = parseFloat($('#wht_percent_'+iden).val());
            $('#wht_percent1_'+iden).val(whtPercente);

            var normas = parseFloat($('#norma_'+iden).val());
            $('#norma1_'+iden).val(normas);

            var MAX_CHANGE = 30000;
            
            var qtyss = parseFloat($('#qty_' + iden).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
            var unitPrice = parseFloat($('#unit1_' + iden).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
            var forexs = parseFloat($('#forex_' + iden).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
            var pricess = parseFloat($('#price_' + iden).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
            var subtotal1 = parseFloat($('#subtotal_' + iden).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
            var subtotal2 = parseFloat($('#subtotal2_' + iden).val()) || 0;
            var vatTotale = parseFloat($('#totalvat_'+iden).val().replace(/\./g, '').replace(/\,/g, '.'));
            var total1 = parseFloat($('#total_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            var whtTotale = parseFloat($('#total_wht_'+iden).val().replace(/\./g, '').replace(/\,/g, '.'));
            var gtotal1 = parseFloat($('#gtotal_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;

            // var moq = parseFloat($('#minimum_quantity_order2_' + iden).val()) || 0;
            var previousSubtotal = parseFloat($('#subtotal1_' + iden).val()) || 0;
            var previousVat = parseFloat($('#total_vat1_' + iden).val()) || 0;
            var previousTotal = parseFloat($('#total1_' + iden).val()) || 0;
            var previousWht = parseFloat($('#total_wht1_' + iden).val()) || 0;
            var previousGtotal = parseFloat($('#paid_total_' + iden).val()) || 0;

            if (subtotal1 < parseFloat(subtotal2) - parseFloat(MAX_CHANGE) || subtotal1 > parseFloat(subtotal2) + parseFloat(MAX_CHANGE)) {
                alert('The Subtotal cannot be less than ' + MAX_CHANGE + ' or more than ' + MAX_CHANGE + ' from the initial value');
                return false;
            }

            var subtotalDifference = subtotal1 - previousSubtotal;
            var vatDifference = vatTotale - previousVat;
            var totalDifference = total1 - previousTotal;
            var whtDifference = whtTotale - previousWht;
            var gtotalDifference = gtotal1 - previousGtotal;

            // Update grandTotal with the gtotal1 difference
            substotal += subtotalDifference;
            gtotal_vat += vatDifference;
            totals += totalDifference;
            gtotal_wht += whtDifference;
            grandTotal += gtotalDifference;
            // substotal += Math.round(parseFloat(subtotalDifference));
            // gtotal_vat += Math.floor(parseFloat(vatDifference));
            // totals += Math.round(parseFloat(totalDifference));
            // gtotal_wht += Math.floor(parseFloat(whtDifference));
            // grandTotal += Math.round(parseFloat(gtotalDifference));

            // Update nilai pada input #grandtotal
            // $('#grandtotal').val(newDivider1(grandTotal));
            // $('#grandtotal1').val(grandTotal);
            // $('#subtotal1').val(substotal);
            // $('#gtotal_vat').val(gtotal_vat);
            // $('#total1').val(totals);
            // $('#gtotal_wht').val(gtotal_wht);
            $('#grandtotal').val(newDivider1(Math.round(grandTotal)));
            $('#grandtotal1').val(Math.round(grandTotal));
            $('#subtotal1').val(Math.round(substotal));
            $('#total1').val(Math.round(totals));
            $('#gtotal_vat').val(Math.floor(gtotal_vat));
            $('#gtotal_wht').val(Math.floor(gtotal_wht));
            updateGrandTotal();
            calculateGrandeTotal();
            
            $('#qtys_' + iden).val(qtyss);
            $('#qtys-text_' + iden).text(allinDivider(qtyss));
            $('#unit_price_' + iden).val(unitPrice);
            $('#unit_price-text_' + iden).text(allinDivider(unitPrice));
            $('#forexs_' + iden).val(forexs);
            $('#forex-text_' + iden).text(allinDivider(forexs));
            $('#prices_' + iden).val(pricess);
            $('#prices-text_' + iden).text(allinDivider(pricess));
            $('#subtotal1_' + iden).val(subtotal1);
            $('#subtotal1-text_' + iden).text(allinDivider(subtotal1));
            $('#total_vat1_'+iden).val(vatTotale);
            $('#total_vat1-text_'+iden).text(allinDivider(vatTotale));
            $('#total1_' + iden).val(total1);
            $('#total_wht1_'+iden).val(whtTotale);
            $('#total_wht1-text_'+iden).text(allinDivider(whtTotale));
            $('#total1-text_' + iden).text(allinDivider(total1));
            $('#paid_total_' + iden).val(gtotal1);
            $('#paid_total-text_' + iden).text(allinDivider(gtotal1));
            calculatesGrandsTotal();
        }
        function updateDataProduct123(productIdx) {
            var reimburse = $('#reimburse2_'+productIdx).val();
            var reimburseTextarea = $(`#row-${productIdx}`).find(`textarea[name="rows[${productIdx}][descs]"]`);
                // Update the textarea value in the current row
            reimburseTextarea.val(reimburse);
            $('#reimburse-text_'+productIdx).text(reimburse);

            var dates = $('#date_fact2_' + productIdx).val();
            $('#date_' + productIdx).val(dates);
            $('#date-text_' + productIdx).text(dates);

            var curesss = $('#currency_'+productIdx).val();
            $('#currencys_'+productIdx).val(curesss);
            $('#currencys-text_'+productIdx).text(curesss);

            var types = $('#type_'+productIdx).val();
            var typesName = $('#typeName_'+productIdx).val();
            $('#types_'+productIdx).val(types);
            $('#type-text_'+productIdx).text(typesName);

            var platess = $('#plate2_'+productIdx).val();
            var platessTextarea = $(`#row-${productIdx}`).find(`textarea[name="rows[${productIdx}][invoices]"]`);
            platessTextarea.val(platess);
            $('#plate-text_'+productIdx).text(platess);

            var vatNames = $('#vatName_'+productIdx).val();
            $('#vat_type_'+productIdx).val(vatNames);
            $('#vat_type-text_'+productIdx).text(vatNames);

            var vatPercente = parseFloat($('#vatpercent_'+productIdx).val());
            $('#vat_percent1_'+productIdx).val(vatPercente);

            var whtNames = $('#whtName_'+productIdx).val();
            $('#wht_type_'+productIdx).val(whtNames);
            $('#wht_type-text_'+productIdx).text(whtNames);

            var whtPercente = parseFloat($('#wht_percent_'+productIdx).val());
            $('#wht_percent1_'+productIdx).val(whtPercente);

            var normas = parseFloat($('#norma_'+productIdx).val());
            $('#norma1_'+productIdx).val(normas);

            var MAX_CHANGE = 30000;
                
            var qtyss = parseFloat($('#qty_' + productIdx).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
            var unitPrice = parseFloat($('#unit1_' + productIdx).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
            var forexs = parseFloat($('#forex_' + productIdx).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
            var pricess = parseFloat($('#price_' + productIdx).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
            var subtotal1 = parseFloat($('#subtotal_' + productIdx).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
            var subtotal2 = parseFloat($('#subtotal2_' + productIdx).val()) || 0;
            var vatTotale = parseFloat($('#totalvat_'+productIdx).val().replace(/\./g, '').replace(/\,/g, '.'));
            var total1 = parseFloat($('#total_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            var whtTotale = parseFloat($('#total_wht_'+productIdx).val().replace(/\./g, '').replace(/\,/g, '.'));
            var gtotal1 = parseFloat($('#gtotal_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;

            // var moq = parseFloat($('#minimum_quantity_order2_' + productIdx).val()) || 0;
            var previousSubtotal = parseFloat($('#subtotal1_' + productIdx).val()) || 0;
            var previousVat = parseFloat($('#total_vat1_' + productIdx).val()) || 0;
            var previousTotal = parseFloat($('#total1_' + productIdx).val()) || 0;
            var previousWht = parseFloat($('#total_wht1_' + productIdx).val()) || 0;
            var previousGtotal = parseFloat($('#paid_total_' + productIdx).val()) || 0;

            if (subtotal1 < parseFloat(subtotal2) - parseFloat(MAX_CHANGE) || subtotal1 > parseFloat(subtotal2) + parseFloat(MAX_CHANGE)) {
                alert('The Subtotal cannot be less than ' + MAX_CHANGE + ' or more than ' + MAX_CHANGE + ' from the initial value');
                return false;
            }

            var subtotalDifference = subtotal1 - previousSubtotal;
            var vatDifference = vatTotale - previousVat;
            var totalDifference = total1 - previousTotal;
            var whtDifference = whtTotale - previousWht;
            var gtotalDifference = gtotal1 - previousGtotal;

            // Update grandTotal with the gtotal1 difference
            // substotal += Math.round(parseFloat(subtotalDifference));
            // gtotal_vat += Math.floor(parseFloat(vatDifference));
            // totals += Math.round(parseFloat(totalDifference));
            // gtotal_wht += Math.floor(parseFloat(whtDifference));
            // grandTotal += Math.round(parseFloat(gtotalDifference));
            substotal += subtotalDifference;
            gtotal_vat += vatDifference;
            totals += totalDifference;
            gtotal_wht += whtDifference;
            grandTotal += gtotalDifference;

            // Update nilai pada input #grandtotal
            // $('#grandtotal').val(newDivider1(grandTotal));
            // $('#grandtotal1').val(grandTotal);
            // $('#subtotal1').val(substotal);
            // $('#gtotal_vat').val(gtotal_vat);
            // $('#total1').val(totals);
            // $('#gtotal_wht').val(gtotal_wht);
            $('#grandtotal').val(newDivider1(Math.round(grandTotal)));
            $('#grandtotal1').val(Math.round(grandTotal));
            $('#subtotal1').val(Math.round(substotal));
            $('#total1').val(Math.round(totals));
            $('#gtotal_vat').val(Math.floor(gtotal_vat));
            $('#gtotal_wht').val(Math.floor(gtotal_wht));
            updateGrandTotal();
            calculateGrandeTotal();
            $('#qtys_' + productIdx).val(qtyss);
            $('#qtys-text_' + productIdx).text(allinDivider(qtyss));
            $('#unit_price_' + productIdx).val(unitPrice);
            $('#unit_price-text_' + productIdx).text(allinDivider(unitPrice));
            $('#forexs_' + productIdx).val(forexs);
            $('#forex-text_' + productIdx).text(allinDivider(forexs));
            $('#prices_' + productIdx).val(pricess);
            $('#prices-text_' + productIdx).text(allinDivider(pricess));
            $('#subtotal1_' + productIdx).val(subtotal1);
            $('#subtotal123_' + productIdx).val(subtotal1);
            $('#subtotal1-text_' + productIdx).text(allinDivider(subtotal1));
            $('#total_vat1_'+productIdx).val(vatTotale);
            $('#total_vat123_'+productIdx).val(vatTotale);
            $('#total_vat1-text_'+productIdx).text(allinDivider(vatTotale));
            $('#total1_' + productIdx).val(total1);
            $('#total123_' + productIdx).val(total1);
            $('#total_wht1_'+productIdx).val(whtTotale);
            $('#total_wht123_'+productIdx).val(whtTotale);
            $('#total_wht1-text_'+productIdx).text(allinDivider(whtTotale));
            $('#total1-text_' + productIdx).text(allinDivider(total1));
            $('#paid_total_' + productIdx).val(gtotal1);
            $('#paid_total123_' + productIdx).val(gtotal1);
            $('#paid_total-text_' + productIdx).text(allinDivider(gtotal1));
            calculatesGrandsTotal();
        }
        // $(document).ready(function() {
        //     // Event handler untuk perubahan pada vatType
        //     $(document).on('change', `[id^="vatType_"]`, function (e) {
        //         const selectedVatType = $(this).val();
        //         $('[id^="vatType_"]').each(function() {
        //             const iden = this.id.split('_')[1];
        //             $(this).val(selectedVatType);
        //             updateVatType(iden, selectedVatType);
        //         });
        //     });

        //     // Event handler untuk perubahan pada whtType
        //     $(document).on('change', `[id^="whtType_"]`, function (e) {
        //         const selectedWhtType = $(this).val();
        //         $('[id^="whtType_"]').each(function() {
        //             const iden = this.id.split('_')[1];
        //             $(this).val(selectedWhtType);
        //             updateWhtType(iden, selectedWhtType);
        //         });
        //     });

        //     function updateVatType(iden, vatType) {
        //         const subtotalis = $(`#subtotal_${iden}`).val();
        //         const whtType = $(`#whtType_${iden}`).val();
        //         const total = parseFloat($(`#total_${iden}`).val().replace(/\./g, '')) || 0;
        //         const totalWHT = parseFloat($(`#total_wht_${iden}`).val().replace(/\./g, '')) || 0;
        //         const grandTotal1 = total - totalWHT;

        //         if (vatType == 'N/A') {
        //             $(`#vatt_${iden}`).attr("hidden", true);
        //             $(`#vatt_percent_${iden}`).attr("hidden", true);
        //             $(`#total_vatt_${iden}`).attr("hidden", true);
        //             $(`#vatName_${iden}`).attr("hidden", true);
        //             $(`#total_${iden}`).attr("readonly", true);
        //             $(`#gtotal_${iden}`).attr("readonly", true);
        //             $(`#totalvat_${iden}`).attr("readonly", false);
        //             $(`#vatpercent_${iden}`).attr("readonly", false);
        //         } else if (vatType == 'Manual') {
        //             $(`#vatt_${iden}`).attr("hidden", false);
        //             $(`#vatt_percent_${iden}`).attr("hidden", false);
        //             $(`#total_vatt_${iden}`).attr("hidden", false);
        //             $(`#totalvat_${iden}`).attr("readonly", false);
        //             $(`#vatName_${iden}`).attr("hidden", false);
        //             $(`#vat_${iden}`).attr("hidden", true);
        //             $(`#vatpercent_${iden}`).attr("readonly", false);
        //             $(`#gtotal_${iden}`).val(divider(grandTotal1));
        //         } else if (vatType == 'DB') {
        //             $(`#vatt_${iden}`).attr("hidden", false);
        //             $(`#vatt_percent_${iden}`).attr("hidden", false);
        //             $(`#total_vatt_${iden}`).attr("hidden", false);
        //             $(`#vatName_${iden}`).attr("hidden", true);
        //             $(`#vat_${iden}`).attr("hidden", false);
        //             $(`#totalvat_${iden}`).attr("readonly", true);
        //             $(`#vatpercent_${iden}`).attr("readonly", true);
        //             $(`#total_${iden}`).attr("readonly", true);
        //             $(`#gtotal_${iden}`).attr("readonly", true);
        //             $(`#gtotal_${iden}`).val(divider(grandTotal1));
        //         }
        //     }

        //     function updateWhtType(iden, whtType) {
        //         const subtotaliss = $(`#subtotal_${iden}`).val();
        //         const totalisss1 = $(`#total_${iden}`).val();
        //         if (whtType == 'N/A') {
        //             $(`#whtt_${iden}`).attr("hidden", true);
        //             $(`#whtt_percent_${iden}`).attr("hidden", true);
        //             $(`#total_whtt_${iden}`).attr("hidden", true);
        //             $(`#normaa_${iden}`).attr("hidden", true);
        //             $(`#whtName_${iden}`).attr("hidden", true);
        //             $(`#gtotal_${iden}`).val(totalisss1);
        //             $(`#total_${iden}`).attr("readonly", true);
        //             $(`#gtotal_${iden}`).attr("readonly", true);
        //         } else if (whtType == 'Manual') {
        //             $(`#whtt_${iden}`).attr("hidden", false);
        //             $(`#whtt_percent_${iden}`).attr("hidden", false);
        //             $(`#total_whtt_${iden}`).attr("hidden", false);
        //             $(`#total_wht_${iden}`).attr("readonly", false);
        //             $(`#whtName_${iden}`).attr("hidden", false);
        //             $(`#wht_${iden}`).attr("hidden", true);
        //             $(`#normaa_${iden}`).attr("hidden", false);
        //             $(`#norma_${iden}`).attr("readonly", false);
        //             $(`#wht_percent_${iden}`).attr("readonly", false);
        //         } else if (whtType == 'DB') {
        //             $(`#whtt_${iden}`).attr("hidden", false);
        //             $(`#whtt_percent_${iden}`).attr("hidden", false);
        //             $(`#total_whtt_${iden}`).attr("hidden", false);
        //             $(`#whtName_${iden}`).attr("hidden", true);
        //             $(`#wht_${iden}`).attr("hidden", false);
        //             $(`#normaa_${iden}`).attr("hidden", false);
        //             $(`#total_wht_${iden}`).attr("readonly", true);
        //             $(`#norma_${iden}`).attr("readonly", true);
        //             $(`#wht_percent_${iden}`).attr("readonly", true);
        //             $(`#total_${iden}`).attr("readonly", true);
        //             $(`#gtotal_${iden}`).attr("readonly", true);
        //         }
        //     }
        // });

        // $(document).ready(function() {
        //     // Event handler untuk perubahan pada vatType
        //     $(document).on('change', `[id^="vatType_"]`, function (e) {
        //         const selectedVatType = $(this).val();
        //         $('[id^="vatType_"]').each(function() {
        //             const productIdx = this.id.split('_')[1];
        //             $(this).val(selectedVatType);
        //             updateVatType(productIdx, selectedVatType);
        //         });
        //     });

        //     // Event handler untuk perubahan pada whtType
        //     $(document).on('change', `[id^="whtType_"]`, function (e) {
        //         const selectedWhtType = $(this).val();
        //         $('[id^="whtType_"]').each(function() {
        //             const productIdx = this.id.split('_')[1];
        //             $(this).val(selectedWhtType);
        //             updateWhtType(productIdx, selectedWhtType);
        //         });
        //     });

        //     function updateVatType(productIdx, vatType) {
        //         const subtotalis = $(`#subtotal_${productIdx}`).val();
        //         const whtType = $(`#whtType_${productIdx}`).val();
        //         const total = parseFloat($(`#total_${productIdx}`).val().replace(/\./g, '')) || 0;
        //         const totalWHT = parseFloat($(`#total_wht_${productIdx}`).val().replace(/\./g, '')) || 0;
        //         const grandTotal1 = total - totalWHT;

        //         if (vatType == 'N/A') {
        //             $(`#vatt_${productIdx}`).attr("hidden", true);
        //             $(`#vatt_percent_${productIdx}`).attr("hidden", true);
        //             $(`#total_vatt_${productIdx}`).attr("hidden", true);
        //             $(`#vatName_${productIdx}`).attr("hidden", true);
        //             $(`#total_${productIdx}`).attr("readonly", true);
        //             $(`#gtotal_${productIdx}`).attr("readonly", true);
        //             $(`#totalvat_${productIdx}`).attr("readonly", false);
        //             $(`#vatpercent_${productIdx}`).attr("readonly", false);
        //         } else if (vatType == 'Manual') {
        //             $(`#vatt_${productIdx}`).attr("hidden", false);
        //             $(`#vatt_percent_${productIdx}`).attr("hidden", false);
        //             $(`#total_vatt_${productIdx}`).attr("hidden", false);
        //             $(`#totalvat_${productIdx}`).attr("readonly", false);
        //             $(`#vatName_${productIdx}`).attr("hidden", false);
        //             $(`#vat_${productIdx}`).attr("hidden", true);
        //             $(`#vatpercent_${productIdx}`).attr("readonly", false);
        //             $(`#gtotal_${productIdx}`).val(divider(grandTotal1));
        //         } else if (vatType == 'DB') {
        //             $(`#vatt_${productIdx}`).attr("hidden", false);
        //             $(`#vatt_percent_${productIdx}`).attr("hidden", false);
        //             $(`#total_vatt_${productIdx}`).attr("hidden", false);
        //             $(`#vatName_${productIdx}`).attr("hidden", true);
        //             $(`#vat_${productIdx}`).attr("hidden", false);
        //             $(`#totalvat_${productIdx}`).attr("readonly", true);
        //             $(`#vatpercent_${productIdx}`).attr("readonly", true);
        //             $(`#total_${productIdx}`).attr("readonly", true);
        //             $(`#gtotal_${productIdx}`).attr("readonly", true);
        //             $(`#gtotal_${productIdx}`).val(divider(grandTotal1));
        //         }
        //     }

        //     function updateWhtType(productIdx, whtType) {
        //         const subtotaliss = $(`#subtotal_${productIdx}`).val();
        //         const totalisss1 = $(`#total_${productIdx}`).val();
        //         if (whtType == 'N/A') {
        //             $(`#whtt_${productIdx}`).attr("hidden", true);
        //             $(`#whtt_percent_${productIdx}`).attr("hidden", true);
        //             $(`#total_whtt_${productIdx}`).attr("hidden", true);
        //             $(`#normaa_${productIdx}`).attr("hidden", true);
        //             $(`#whtName_${productIdx}`).attr("hidden", true);
        //             $(`#gtotal_${productIdx}`).val(totalisss1);
        //             $(`#total_${productIdx}`).attr("readonly", true);
        //             $(`#gtotal_${productIdx}`).attr("readonly", true);
        //         } else if (whtType == 'Manual') {
        //             $(`#whtt_${productIdx}`).attr("hidden", false);
        //             $(`#whtt_percent_${productIdx}`).attr("hidden", false);
        //             $(`#total_whtt_${productIdx}`).attr("hidden", false);
        //             $(`#total_wht_${productIdx}`).attr("readonly", false);
        //             $(`#whtName_${productIdx}`).attr("hidden", false);
        //             $(`#wht_${productIdx}`).attr("hidden", true);
        //             $(`#normaa_${productIdx}`).attr("hidden", false);
        //             $(`#norma_${productIdx}`).attr("readonly", false);
        //             $(`#wht_percent_${productIdx}`).attr("readonly", false);
        //         } else if (whtType == 'DB') {
        //             $(`#whtt_${productIdx}`).attr("hidden", false);
        //             $(`#whtt_percent_${productIdx}`).attr("hidden", false);
        //             $(`#total_whtt_${productIdx}`).attr("hidden", false);
        //             $(`#whtName_${productIdx}`).attr("hidden", true);
        //             $(`#wht_${productIdx}`).attr("hidden", false);
        //             $(`#normaa_${productIdx}`).attr("hidden", false);
        //             $(`#total_wht_${productIdx}`).attr("readonly", true);
        //             $(`#norma_${productIdx}`).attr("readonly", true);
        //             $(`#wht_percent_${productIdx}`).attr("readonly", true);
        //             $(`#total_${productIdx}`).attr("readonly", true);
        //             $(`#gtotal_${productIdx}`).attr("readonly", true);
        //         }
        //     }
        // });

        function updateGrandTotal() {
            var substotal = 0;
            var totals = 0;
            var grandTotal = 0;
            var gtotal_vat = 0;
            var gtotal_wht = 0;
            $('.tableProductAddBody tbody tr').each(function() {
                const substotalas = parseFloat($(this).find('input[name^="subtotal1_"]').val()) || 0;
                const grandstotalas = parseFloat($(this).find('input[name^="paid_total_"]').val()) || 0;
                const totalslas = parseFloat($(this).find('input[name^="total1_"]').val()) || 0;
                const vatTotalas = parseFloat($(this).find('input[name^="total_vat1_"]').val()) || 0;
                const whtTotalas = parseFloat($(this).find('input[name^="total_wht1_"]').val()) || 0;
                substotal += substotalas;
                totals += totalslas;
                grandTotal += grandstotalas;
                gtotal_vat += vatTotalas;
                gtotal_wht += whtTotalas;

                // console.log(substotal, totals, grandTotal, gtotal_vat, gtotal_wht);
            });
            // $('#grandtotal').val(divider(grandTotal));
            // $('#grandtotal1').val(grandTotal);
            // $('#subtotal1').val(substotal);
            // $('#total1').val(totals);
            // $('#gtotal_vat').val(gtotal_vat);
            // $('#gtotal_wht').val(gtotal_wht);
            $('#grandtotal').val(divider(Math.round(grandTotal)));
            $('#grandtotal1').val(Math.round(grandTotal));
            $('#subtotal1').val(Math.round(substotal));
            $('#total1').val(Math.round(totals));
            $('#gtotal_vat').val(Math.floor(gtotal_vat));
            $('#gtotal_wht').val(Math.floor(gtotal_wht));
            // Perbarui teks dan nilai input sesuai dengan nilai global yang diperbarui
            $('#subtotal_text').text(divider(Math.round(substotal)));
            $('#vatTotal_text').text(divider(Math.floor(gtotal_vat)));
            $('#whtTotal_text').text(divider(Math.floor(gtotal_wht)));
            $('#grandTotal_text').text(divider(Math.round(grandTotal)));
            $('#grandeTotal_text').text(divider(Math.round(grandTotal)));

            // Jika diperlukan, juga perbarui nilai input
            $('#subtotal_text').val(divider(Math.round(substotal)));
            $('#vatTotal_text').val(divider(Math.floor(gtotal_vat)));
            $('#whtTotal_text').val(divider(Math.floor(gtotal_wht)));
            $('#grandTotal_text').val(divider(Math.round(grandTotal)));
            $('#grandeTotal_text').val(divider(Math.round(grandTotal)));
        }
    </script>
    @endsection
</x-app-layout>