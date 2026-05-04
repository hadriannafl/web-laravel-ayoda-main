<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Reimbursement Form 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('reimburse-request.create') }}" id="form_create">
                @csrf
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Request Date<span
                        class="text-rose-500">*</span></label>
                    <input id="date" name="date"
                    class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    Value="{{date('Y/m/d')}}" required readonly/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="employee1">Employee<span
                        class="text-rose-500">*</span>
                    </label>
                    <input class="employee form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="employee" name="employee" hidden readonly/>
                    <input class="employee1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="employee1" name="employee1" required readonly/>
                    <div x-data="{ modalOpen: false }">
                        <button type="button"
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
                                        <div class="font-semibold text-slate-800">Select
                                            Employee</div>
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
                                    <div class="table-responsive">
                                        <div class="flex flex-row text-xs mb-3">
                                            {{-- @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') --}}
                                                    <label class="flex flex-row text-xs">
                                                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="company12">Company :</p>
                                                        <select id="company12" class="company12 flex flex-row ml-3 mb-3 text-xs" name="company12">
                                                            <option value="">All</option>
                                                            @foreach ( $dataChildCompany as $company)
                                                            <option value="{{$company->id_company}}">{{$company->name}}</option>
                                                            @endforeach
                                                        </select>
                                                {{-- @else
                                                    <input id="company12" name="company12"
                                                    class="company12 form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                                    value="{{$dataChildCompany->id_company}}" readonly hidden/>
                                                @endif --}}
                                            </div>
                                        <table id="employee-table"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Employee ID</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Gender</th>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Employee Type</th>
                                                    <th class="text-center">Department</th>
                                                    <th class="text-center">Structural Title</th>
                                                    <th class="text-center">Position</th>
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
                <div id="detail_employee" hidden>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Company (Reimburse Charged to)<span
                            class="text-rose-500">*</span></label>
                        <input id="companyId" name="companyId"
                            class="companyId form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden/>
                        <select id="company55" class="company55 flex form-select w-full md:w-3/4 px-2 py-1" name="company55" hidden>
                            <option value="" hidden>Select Company</option>
                            @foreach ( $dataChildCompany2 as $company)
                                <option value="{{$company->name}}">{{$company->name}}</option>
                            @endforeach
                        </select>
                        <input id="company" name="company"
                            class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                    </div>
                    <div class="flex md:flex-row mt-3">
                        <label class="block w-1/4 text-sm"></label>
                        <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white mr-5" id="changeCompany">Change Company</button>
                    </div>
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Department / Position<span
                            class="text-rose-500">*</span></label>
                            <div style="width: 31rem; margin-right: 41px;">
                                <input id="department" name="department" class="department form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Department"/>
                            </div>
                            <div>
                                <input id="division" name="division" style="width: 31.7rem;" class="division form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Position"/>
                            </div>
                    </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Currency / Exchange Rate<span
                        class="text-rose-500">*</span></label>
                        <div style="width: 31rem; margin-right: 41px;">
                            <input id="currencySelected" name="currencySelected"
                            class="currencySelected form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden/>
                            <select id="currency" name="currency"
                                class="currency form-select w-full px-2 py-1" required>
                                <option selected hidden value="">Select Currency</option>
                                @foreach ( $dataCurrency as $cur )
                                <option value="{{$cur->symbol}}" {{$cur->symbol == 'IDR' ? 'selected' : ''}}>{{$cur->symbol}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <input id="crate" name="crate" style="width: 31.7rem;" class="crate form-input numeric-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="1" readonly required/>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="bank">Payment To Beneficiary By<span
                        class="text-rose-500">*</span></label>
                    <select id="bank" name="bank" class="bank form-select w-full md:w-3/4 px-2 py-1" required>
                        <option value="" hidden>Select Bank</option>
                        @foreach ($bank as $bankir )
                            <option value="{{$bankir->id_bank}}">{{$bankir->name}}</option>
                        @endforeach
                    </select>
                    <input id="bank12" name="bank12" class="bank12 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden/>
                </div>
                <div id="bankirs" hidden>
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Account / Beneficiary Account Name<span
                            class="text-rose-500">*</span></label>
                            <div style="width: 31rem; margin-right: 41px;">
                                <input id="number" name="number" class="number form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Beneficiary Account"/>
                            </div>
                            <div>
                                <input id="account" name="account" style="width: 31.7rem;" class="account form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Beneficiary Account Name"/>
                            </div>
                    </div>
                    <div class="flex md:flex-row mt-3">
                        <label class="block w-1/4 text-sm"></label>
                        <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white mr-5" id="editBenef">Edit Acc Beneficiary</button>
                    </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file45">Attachment Supporting Document<span
                        class="text-rose-500">*</span></label>
                    <input id="file45" name="file45" class="file45 form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                    <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">File max size 12MB</div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="description">Notes<span class="text-rose-500">*</span></label>
                    <textarea id="notes" name="notes" class="notes form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        rows="3" required></textarea>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Add Reimburse Detail <span
                    class="text-rose-500">*</span>
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
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Reimburse Type <span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <select id="type" name="type" class="type form-select w-full md:w-3/4 px-2 py-1" style="width: 62rem">
                                                <option value="" selected hidden>Select Type</option>
                                            @foreach ( $dataType as $type)
                                                <option value="{{$type->id}}">{{$type->reimburse_type}}</option>
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
                                            for="price">Vehicle Number
                                        </label>
                                        <input id="plate" name="plate"
                                            class="plate form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="reimburse">Description <span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <textarea name="reimburse" id="reimburse" class="reimburse form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3"></textarea>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="subtotal">Subtotal<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="subtotal" name="subtotal"
                                            class="subtotal numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <div class="flex flex-row mb-3">
                                        <label class="text-sm font-medium mb-1 mt-1" for="vatType">VAT/Rate/Total</label>
                                            <div class="mb-3" style="width: 6rem; margin-left: 14.3rem; margin-right: 2rem;">
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
                                        <input id="total" name="total" class="total form-input numeric-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                    </div>
                                    <div class="flex flex-row mb-3">
                                        <label class="text-sm font-medium mb-1 mt-1" for="whtType">WHT/Rate/Norma/Total</label>
                                        <div class="mb-3" style="width: 8rem; margin-left: 10.7rem; margin-right: 10px;">
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
                                            <input type="number" id="wht_percent" name="wht_percent" style="width: 13rem;" class="wht_percent w-20 px-2 py-1 form-input read-only:bg-slate-200 ml-3" readonly/>
                                        </div>
                                        <div class="mb-3" id="normaa" hidden>
                                            <input type="number" id="norma" name="norma" style="width: 13rem;" class="norma w-20 px-2 py-1 form-input read-only:bg-slate-200 ml-3" readonly/>
                                        </div>
                                        <div class="mb-3" id="total_whtt" hidden>
                                            <input type="text" id="total_wht" name="total_wht" style="width: 13rem;" class="total_wht numeric-input w-40 px-2 py-1 form-input read-only:bg-slate-200 ml-3" readonly/>
                                        </div>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="gtotal">Reimburse Total</label>
                                        <input id="gtotal" name="gtotal" class="gtotal form-input numeric-input md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="remarks">Remarks
                                        </label>
                                        <input id="remarks" name="remarks"
                                            class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <p id="uploaded" hidden>Uploaded</p>
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
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-xs text-center">Date</th>
                                <th class="text-xs text-center">Reimburse Type</th>
                                <th class="text-xs text-center">Vehicle Number</th>
                                <th class="text-xs text-center">Reimburse Description</th>
                                <th class="text-xs text-center">Subtotal</th>
                                <th class="text-xs text-center">VAT Type</th>
                                <th class="text-xs text-center">VAT</th>
                                <th class="text-xs text-center">WHT Type</th>
                                <th class="text-xs text-center">WHT</th>
                                <th class="text-xs text-center">Reimburse Total</th>
                                <th class="text-xs text-center">Remarks</th>
                                <th class="text-xs text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/2 text-sm font-medium mb-1" for="totalAmount">Grand Total (IDR)<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/3 px-2 py-1 read-only:bg-slate-200 text-right" type="text" readonly required/>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden required/>
                    <input id="subtotal1" name="subtotal1" class="subtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden required/>
                    <input id="total1" name="total1" class="total1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden required/>
                    <input id="gtotal_vat" name="gtotal_vat" class="gtotal_vat form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden required/>
                    <input id="gtotal_wht" name="gtotal_wht" class="gtotal_wht form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden required/>
                </div>
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_reimburse">
                        <span class="xs:block ml-5 mr-5">Create Reimburse Request</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>
    $('#bank').select2();
    $('#type').select2();
    $('#vat').select2();
    $('#wht').select2();
$('#changeCompany').on('click', function () {
    $("#company55").attr("hidden", false);
    $("#company").attr("hidden", true);
    $("#company").val('');
    $("#department").attr("readonly", false);
    $("#division").attr("readonly", false);
})
$('#editBenef').on('click', function () {
    $("#account").attr("readonly", false);
    $("#number").attr("readonly", false);
    $("#editBenef").attr("hidden", true);
})
$('#company55').on('change', function (e) {
        const selectedCompanyName = $(this).val(); // Mendapatkan nama perusahaan yang dipilih
        const selectedCompany = {!! json_encode($dataChildCompany2) !!} // Mendapatkan data seluruh perusahaan
            .find(company => company.name === selectedCompanyName); // Mencari objek perusahaan berdasarkan nama yang dipilih

        if (selectedCompany) {
            $("#companyId").val(selectedCompany.id_company); // Mengatur nilai input companyId menjadi id_company dari perusahaan yang dipilih
            $("#company").val(selectedCompanyName); // Mengatur nilai input company menjadi nama perusahaan yang dipilih
        }
    });
// $('#user_type').on('change', function (e) {
//     const usType = $(this).val();

//     if (usType == 'External') {
//         $("#extern").attr("hidden", false);
//         $("#compannyReimburse").attr("hidden", false);
//         $("#intern").attr("hidden", true);
//     }else if(usType == 'Internal') {
//         $("#extern").attr("hidden", true);
//         $("#compannyReimburse").attr("hidden", true);
//         $("#intern").attr("hidden", false);
//     }
// }) 
$('#vatType').on('change', function (e) {
    const vatType = $(this).val();
    const whtType = $('#whtType').val();
    const subtotalis = $('#subtotal').val();
    const total = parseFloat($('#total').val().replace(/\./g, '')) || 0;
    const totalWHT = parseFloat($('#total_wht').val().replace(/\./g, '')) || 0;
    const grandTotal1 = total - totalWHT;

    if (vatType == 'N/A') {
        $("#vatt").attr("hidden", true);
        $("#vatt_percent").attr("hidden", true);
        $("#total_vatt").attr("hidden", true);
        $("#total_vat").attr("readonly", true);
        $("#vat_percent").val('');
        $("#total_vat").val('');
        $("#vatName").val('');
        $("#vatName").attr("hidden", true);
        $('#gtotal').val(divider(grandTotal1));
        $("#total").val(subtotalis);
        $("#total").attr("readonly", true);
        $("#gtotal").attr("readonly", true);
        $("#total_vat").attr("readonly", false);
        $("#vat_percent").attr("readonly", false);
    }else if(vatType == 'Manual') {
        $("#vatt").attr("hidden", true);
        $("#vatt_percent").attr("hidden", false);
        $("#total_vatt").attr("hidden", false);
        $("#total_vat").attr("readonly", true);
        $("#vatName").attr("hidden", false);
        $("#vatName").val('');
        $("#vat").attr("hidden", true);
        $("#vat_percent").attr("readonly", false);
        $("#total").attr("readonly", true);
        $("#gtotal").attr("readonly", true);
        $('#gtotal').val(divider(grandTotal1));
    }else if(vatType == 'DB') {
        $("#vatt").attr("hidden", false);
        $("#vatt_percent").attr("hidden", false);
        $("#total_vatt").attr("hidden", false);
        $("#vatName").attr("hidden", true);
        $("#vat").attr("hidden", false);
        $("#total_vat").attr("readonly", true);
        $("#vat_percent").attr("readonly", true);
        $("#total").attr("readonly", true);
        $("#gtotal").attr("readonly", true);
        $('#gtotal').val(divider(grandTotal1));
    }
}) 
$('#whtType').on('change', function (e) {
    const whtType = $(this).val();
    const subtotaliss = $('#subtotal').val();
    const totalis = $('#total').val();

    if (whtType == 'N/A') {
        $("#whtt").attr("hidden", true);
        $("#whtt_percent").attr("hidden", true);
        $("#total_whtt").attr("hidden", true);
        $("#total_wht").attr("readonly", true);
        $("#normaa").attr("hidden", true);
        $("#norma").val('');
        $("#wht_percent").val('');
        $("#total_wht").val('');
        $("#whtName").val('');
        $("#gtotal").val(totalis);
        $("#total").attr("readonly", true);
        $("#gtotal").attr("readonly", true);
    }else if(whtType == 'Manual') {
        $("#whtt").attr("hidden", true);
        $("#whtt_percent").attr("hidden", false);
        $("#total_whtt").attr("hidden", false);
        $("#total_wht").attr("readonly", true);
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
        $("#total").attr("readonly", true);
        $("#gtotal").attr("readonly", true);
    }
})   

$('#currency').on('change', function (e) {
    const curs = $(this).val();

    if (curs == 'IDR') {
        $("#crate").attr("readonly", true);
        $("#crate").val("1");
    }else{
        $("#crate").attr("readonly", false);
    }
    $(".btn-reimburse").attr("disabled", false);
})
// $('#clearCur').on('click', function () {
//     $(".btn-reimburse").attr("disabled", true);
//     $("#currency").attr("hidden", false);
//     $("#currency").val('');
//     $("#currencySelected").val('');
//     $("#currencySelected").attr("hidden", true);

//     // Clear the table rows and reset subtotal
//     $('#tableProductAddBody').empty();
//     subtotal = 0;
//     $('#grandtotal').val(`${divider(subtotal)}`);
//     $('#grandtotal1').val(subtotal);
//     var grandTotalRow = `<tr class="grandTotalRow">
//             <td class="text-center font-bold text-lg" colspan="6">Grand Total Reimburse</td>
//             <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(subtotal)}</span></td>
//             <td></td>
//             <td></td>
//         </tr>`;
//         $("#tableProductAddBody").append(grandTotalRow);
// });
    $(document).ready(function () {
        $('#employee-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: false,
            stateServe: true,
            "order": [[ 1, "asc" ]],
            language: {
                        search: "Search Employee : "
                    },
                    ajax: {
                        url: "{{ route('assigned-asset.employee') }}",
                            data:function(d){                    
                                d.company12 = $("#company12").val()
                            }
                    },
                    columns: [
                        {
                            data: "idemployee",
                            name: "idemployee"
                        },
                        {
                            data: "first_name",
                            name: "first_name"
                        },
                        {
                            data: "gen",
                            name: "gen"
                        },
                        {
                            data: "company",
                            name: "company"
                        },
                        {
                            data: "employee_type",
                            name: "employee_type"
                        },
                        {
                            data: "department",
                            name: "department"
                        },
                        {
                            data: "title_structural",
                            name: "title_structural"
                        },
                        {
                            data: "position",
                            name: "position"
                        },
                        {
                            data: "action",
                            name: "action"
                        },
                    ],
                    columnDefs: [
                        { className: 'text-center', targets: [0, 2, 8] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
        });
        $('#company12').on('change', function (e) {
            $('#employee-table').DataTable().ajax.reload();
        })
        $('#employee-table').on("click", ".btn-select", function () {
            const id = $(this).data("id");
            const name = $(this).data("nama");
            const company = $(this).data("company");
            const company_name = $(this).data("company_name");
            const department = $(this).data("department");
            const position = $(this).data("position");
            const bank_name = $(this).data("bank_name");
            const bank_acc_num = $(this).data("bank_acc_num");
            const bank_acc_name = $(this).data("bank_acc_name");
                        
            $('#bankirs').removeAttr('hidden');
            $('#detail_employee').removeAttr('hidden');
            $("#employee").val(id);
            $("#employee1").val(name);
            $("#companyId").val(company);
            $("#company").val(company_name);
            $("#department").val(department);
            $("#division").val(position);
            $("#number").val(bank_acc_num);
            $("#account").val(bank_acc_name);
            $("#number").attr("readonly", true);
            $("#account").attr("readonly", true);
            $("#company55").attr("hidden", true);
            $("#company").attr("hidden", false);
            $("#department").attr("readonly", true);
            $("#division").attr("readonly", true);
            $("#bank option").each(function () {
                if ($(this).text().toLowerCase() === bank_name.toLowerCase()) {
                    $(this).prop('selected', true).trigger('change');
                }
            });
        });
    })

    $('#bank').on('change', function () {
        const bank = $(this).val();

        if (bank == "1") {
            $('#bankirs').attr('hidden', true);
            $('#number').attr('required', false);
            $('#account').attr('required', false);
        }else{
            $('#bankirs').attr('hidden', false);
            $('#number').attr('required', true);
            $('#account').attr('required', true);
        }
    })

    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    // data product
    var substotal = 0;
    var totals = 0;
    var grandstotal = 0;
    var vatTotal = 0;
    var whtTotal = 0;
    let productIdx = 0;
    var formData = new FormData();
    $(document).ready(function () {
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
            $('#vatName').val(vatName1);
        }
        function vatPercent(ths) {
            const vatPercent1 = $('#vat').val(); // Mengambil teks opsi terpilih
            $('#vat_percent').val(vatPercent1);
        }
        function whtName(ths) {
            const whtName1 = $('#wht option:selected').text(); // Mengambil teks opsi terpilih
            $('#whtName').val(whtName1);
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

        function calculateVAT() {
            const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '')) || 0;
            const vatPercent = parseFloat($('#vat_percent').val()) || 0;
            const totalVAT = Math.floor(subtotal * (vatPercent / 100)); // Memperbarui dengan Math.floor()
            $('#total_vat').val(divider(totalVAT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
        }

        function calculateSubtotal() {
            const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '')) || 0;
            const totalVAT = parseFloat($('#total_vat').val().replace(/\./g, '')) || 0;
            const subtotals = subtotal + totalVAT;
            $('#total').val(divider(subtotals)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
            // $('#gtotal').val(divider(subtotals));
        }

        function calculateWHT() {
            const subtotal = parseFloat($('#subtotal').val().replace(/\./g, '')) || 0;
            const normaPercent = parseFloat($('#norma').val()) || 0;
            const whtPercent = parseFloat($('#wht_percent').val()) || 0;
            const totalWHT = Math.floor((subtotal * (normaPercent / 100)) * (whtPercent / 100)); // Memperbarui dengan Math.floor()
            $('#total_wht').val(divider(totalWHT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
        }

        function calculateGrandTotal() {
            const total = parseFloat($('#total').val().replace(/\./g, '')) || 0;
            const totalWHT = parseFloat($('#total_wht').val().replace(/\./g, '')) || 0;
            const grandTotal = total - totalWHT;
            $('#gtotal').val(divider(grandTotal)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
        }

        // Memanggil fungsi perhitungan saat nilai input berubah
        $('#vat_percent, #subtotal').on('input', function() {
            calculateVAT();
            calculateSubtotal();
            calculateGrandTotal();
        });

        $('#norma, #wht_percent, #subtotal').on('input', function() {
            calculateWHT();
            calculateGrandTotal();
        });

        $("#addProduct").click(function () {
            // var productIdx = makeid(3);
            console.log(productIdx)
            var type = $('#type').val();
            var date = $('#date_fact').val();
            var plate = $('#plate').val();
            var typeName = $('#typeName').val();
            var reimburse = $('#reimburse').val();
            var subtotal = $('#subtotal').val();
            var subtotal1 = $('#subtotal').val().replace(/\./g, '');
            var vat = $('#vatName').val();
            var vatPercent = $('#vat_percent').val() || 0;
            var vatPercent1 = $('#vat_percent').val().replace(/\./g, '') || 0;
            var totalVat = $('#total_vat').val();
            var totalVat1 = $('#total_vat').val().replace(/\./g, '') || 0;
            var totalis = $('#total').val().replace(/\./g, '');
            var wht = $('#whtName').val();
            var whtPercent = $('#wht_percent').val() || 0;
            var whtPercent1 = $('#wht_percent').val().replace(/\./g, '') || 0;
            var norma = $('#norma').val() || 0;
            var totalWht = $('#total_wht').val();
            var totalWht1 = $('#total_wht').val().replace(/\./g, '') || 0;
            var gtotal = $('#gtotal').val();
            var gtotal1 = $('#gtotal').val().replace(/\./g, '');
            var remarks = $('#remarks').val();
            // var file = $('#file')[0].files[0]; // Ambil file yang dipilih
            // var file1 = file ? file.name : ''; // Gunakan nama file atau kosongkan jika tidak ada file yang dipilih

            // var tr = "<tr id=\"row-" + productIdx + "\">\n" +
            //     "  <td class=\"text-left\">" + typeName + "<input type=\"hidden\" name = \"types" + productIdx + "\"value =" + type + "><input type=\"hidden\" name = \"ids[]\" value =" + productIdx + " class=\"hidden\"/></td>\n" +
            //     "  <td class=\"text-left\">" + reimburse + "<textarea name = \"reimburses" + productIdx + "\"hidden>" + reimburse + "</textarea></td>\n" +
            //     "  <td class=\"text-right\">" + `${divider(price)}` + "<input type=\"hidden\" name = \"prices" + productIdx + "\" value =" + price + "></td>\n" +
            //     "  <td class=\"text-left\">" + file1 + "</td>\n" +
                // "   <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(`" + productIdx + "`,`" + total + "`)\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
            // "</tr>";

            if (type === '' || reimburse === '' || date === '') {
                alert('Data Detail Reimbursement Must Fill');
                return false;
            }
            if (subtotal1 === '' || substotal === '') {
                alert('Subtotal cannot be null value');
                return false;
            }

            substotal += parseFloat(subtotal1)
            totals += parseFloat(totalis)
            grandstotal += parseFloat(gtotal1)
            vatTotal += parseFloat(totalVat1)
            whtTotal += parseFloat(totalWht1)
            var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                "  <td class=\"text-xs text-left\">" + date + "<input type=\"date\" name = \"rows[" + productIdx + "][dates]\"value =" + date + " hidden></td>\n" +
                "  <td class=\"text-xs text-left\">" + typeName + "<input type=\"hidden\" name = \"rows[" + productIdx + "][types]\"value =" + type + "></td>\n" +
                "  <td class=\"text-xs text-left\">" + plate + "<textarea name = \"rows[" + productIdx + "][plates]\" hidden>" + plate + "</textarea></td>\n" +
                "  <td class=\"text-xs text-left\">" + reimburse + "<textarea name = \"rows[" + productIdx + "][reimburses]\" hidden>" + reimburse + "</textarea></td>\n" +
                "  <td class=\"text-xs text-right\">" + subtotal + "<input type=\"hidden\" name = \"rows[" + productIdx + "][subtotals]\" value =" + subtotal1 + "><input type=\"hidden\" name = \"rows[" + productIdx + "][total_vats]\" value =" + totalVat1 + "></td>\n" +
                "  <td class=\"text-xs text-left\">" + vat + "<textarea name = \"rows[" + productIdx + "][vats]\" hidden>" + vat + "</textarea><input type=\"hidden\" name = \"rows[" + productIdx + "][totals]\" value =" + totalis + "></td>\n" +
                "  <td class=\"text-xs text-right\">" + totalVat + "<input type=\"hidden\" name = \"rows[" + productIdx + "][vat_percents]\" value =" + vatPercent + "></td>\n" +
                "  <td class=\"text-xs text-left\">" + wht + "<textarea name = \"rows[" + productIdx + "][whts]\" hidden>" + wht + "</textarea><input type=\"hidden\" name = \"rows[" + productIdx + "][normas]\" value =" + norma + "></td>\n" +
                "  <td class=\"text-xs text-right\">" + totalWht + "<input type=\"hidden\" name = \"rows[" + productIdx + "][wht_percents]\" value =" + whtPercent + "><input type=\"hidden\" name = \"rows[" + productIdx + "][total_whts]\" value =" + totalWht1 + "></td>\n" +
                "  <td class=\"text-xs text-right\">" + gtotal + "<input type=\"hidden\" name = \"rows[" + productIdx + "][gtotals]\" value =" + gtotal1 + "></td>\n" +
                "  <td class=\"text-xs text-left\">" + remarks + "<textarea name = \"rows[" + productIdx + "][remarkss]\" hidden>" + remarks + "</textarea></td>\n" +
                "   <td class=\"text-xs text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(`" + productIdx + "`,`" + subtotal1 + "`,`" + totalis + "`,`" + gtotal1 + "`,`" + totalVat1 + "` ,`" + totalWht1 + "`)\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
                "</tr>";

            $("#tableProductAddBody").append(tr);

            // formData.append('file'+productIdx, file);



            $('#type').val('');
            $('#type option:first').prop('selected', true);
            $('#type').val('').trigger('change');
            $('#vatType').val('N/A');
            $('#whtType').val('N/A');
            $('#reimburse').val('');
            $('#plate').val('');
            $('#remarks').val('');
            $('#file').val('');
            $('#subtotal').val('');
            $('#vat').val('');
            $('#vat option:first').prop('selected', true);
            $('#vat').val('').trigger('change'); 
            $('#vatName').val('');
            $('#vat_percent').val('');
            $('#total_vat').val('');
            $('#total').val('');
            $('#wht').val('');
            $('#wht option:first').prop('selected', true);
            $('#wht').val('').trigger('change'); 
            $('#whtName').val('');
            $('#wht_percent').val('');
            $('#norma').val('');
            $('#total_wht').val('');
            $('#gtotal').val('');
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
            $('#grandtotal').val(`${divider(grandstotal)}`);
            $('#grandtotal1').val(grandstotal);
            $('#subtotal1').val(substotal);
            $('#total1').val(totals);
            $('#gtotal_vat').val(vatTotal);
            $('#gtotal_wht').val(whtTotal);
            updateGrandTotal();

            productIdx++;
            
            var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
            grandTotalRow.detach();
            $("#tableProductAddBody").append(grandTotalRow);
        });
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-sm" colspan="6">Grand Total Reimburse</td>
            <td class="text-right font-bold text-sm" id="vatTotal_text"><span id="vatTotal_text">${divider(vatTotal)}</span></td>
            <td></td>
            <td class="text-right font-bold text-sm" id="whtTotal_text"><span id="whtTotal_text">${divider(whtTotal)}</span></td>
            <td class="text-right font-bold text-sm" id="grandTotal_text"><span id="grandTotal_text">${divider(grandstotal)}</span></td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);
    });
    function updateGrandTotal() {
        $('#vatTotal_text').text(`${divider(vatTotal)}`);
        $('#vatTotal_text').val(`${divider(vatTotal)}`);
        $('#whtTotal_text').text(`${divider(whtTotal)}`);
        $('#whtTotal_text').val(`${divider(whtTotal)}`);
        $('#grandTotal_text').text(`${divider(grandstotal)}`);
        $('#grandTotal_text').val(`${divider(grandstotal)}`);
    }
    function deleteDataProduct(row, subtotal1, totalis, gtotal1, totalVat1, totalWht1) {
        substotal -= subtotal1;
        totals -= totalis;
        grandstotal -= gtotal1;
        vatTotal -= totalVat1;
        whtTotal -= totalWht1;
        $('#row-'+row).remove();
        formData.delete('file'+row);
        $('#grandtotal').val(`${divider(grandstotal)}`);
        $('#grandtotal1').val(grandstotal);
        $('#subtotal1').val(substotal);
        $('#total1').val(totals);
        $('#gtotal_vat').val(vatTotal);
        $('#gtotal_wht').val(whtTotal);
        updateGrandTotal();
    }
    $('#form_create').submit(function (e, params) {
        e.preventDefault();
        $("#create_reimburse").prop('disabled', true);
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
                    urlRedirect = '/ga/reimburse-approval/list';
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
                        title: 'Reimburse Not Create',
                        text: 'Reimburse Detail or Grand Total must fill',
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
                }else if (_response.st == '4') {
                    Swal.fire({
                        title: 'Reimburse Not Create',
                        text: 'First row Subtotal cannot be 0 value',
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
    document.getElementById('form_create').addEventListener('submit', function(event) {
        var employee1 = document.getElementById('employee1').value.trim();

        if (!employee1 || employee1 === '' || employee1.toLowerCase() === 'null') {
            alert('Employee Must Fill"');
            event.preventDefault();
        }
    });
</script>
@endsection
</x-app-layout>