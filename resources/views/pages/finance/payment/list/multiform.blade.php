<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Payment Form 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('payment-list.create') }}" id="myForm">
                @csrf
                <div class="flex flex-col md:flex-row mb-3">
                    <label class="text-sm font-medium mb-1" for="task_id">Add Payment<span
                    class="text-rose-500">*</span>
                    </label>
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn btn-pay bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
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
                            @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add Payment</div>
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
                                    <div class="flex flex-row">
                                        @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3" for="company">Company :</p>
                                            <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company">
                                                <option value="" selected>All</option>
                                                @foreach ($dataChildCompany as $company)
                                                    <option value="{{ $company->id_company }}">{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company" hidden>
                                                @foreach ($dataChildCompany as $company)
                                                    <option value="{{ $company->id_company }}" {{ Auth::user()->company_id == $company->id_company ? ' selected' : '' }}>{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="status">Status :</p>
                                        <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                                            <option value="A/P" selected>A/P</option>
                                            <option value="Partial">Partial</option>
                                        </select>  
                                    </div>
                                    <div class="table-responsive">
                                        <table id="payment" class="table table-striped table-bordered text-xs" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Due Date</th>
                                                    <th class="text-center">Form Date</th>
                                                    <th class="text-center">Form Type</th>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Reff #</th>
                                                    <th class="text-center">Beneficiary</th>
                                                    <th class="text-center">Balance A/P</th>
                                                    <th class="text-center">Applicant</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
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
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn btn-payment bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal" hidden>
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
                            @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add Payment</div>
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
                                    <div class="flex flex-row" hidden>
                                        <input id="stats" name="stats" style="width: 14rem;" class="stats form-input w-full px-2 py-1 read-only:bg-slate-200" readonly/>
                                        <input id="id_company" name="id_company" style="width: 14rem;" class="id_company form-input w-full px-2 py-1 read-only:bg-slate-200" readonly/>
                                        <input id="idsupplier" name="idsupplier" style="width: 14rem;" class="idsupplier form-input w-full px-2 py-1 read-only:bg-slate-200" readonly/>
                                        <input id="beneficiary" name="beneficiary" style="width: 14rem;" class="beneficiary form-input w-full px-2 py-1 read-only:bg-slate-200" readonly/>
                                        <input id="formstypes" name="formstypes" style="width: 14rem;" class="formstypes form-input w-full px-2 py-1 read-only:bg-slate-200" readonly/>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="payments" class="table table-striped table-bordered text-xs" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Due Date</th>
                                                    <th class="text-center">Form Date</th>
                                                    <th class="text-center">Form Type</th>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Reff #</th>
                                                    <th class="text-center">Beneficiary</th>
                                                    <th class="text-center">Balance A/P</th>
                                                    <th class="text-center">Applicant</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                            {{-- <button type="button"
                                                class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click="modalOpen = false" id="addProduct">Add Payment</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-data="{ modalOpen: false }">
                        <!-- Modal backdrop -->
                        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
                            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true"
                            x-cloak></div>
                        <!-- Modal dialog -->
                        <div id="feedback-modal123"
                            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                            role="dialog" aria-modal="true" x-show="modalOpen"
                            x-transition:enter="transition ease-in-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in-out duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
                            <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add Description</div>
                                    </div>
                                </div>
                                <!-- Modal content -->
                                <div class="modal-content text-xs">
                                    <div class="px-5 py-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-slate-800 mb-3"></div>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="username1">Description<span
                                                        class="text-rose-500">*</span></label>
                                                <textarea id="remarks" name="remarks" type="text" class="remarks form-input w-full px-2 py-1" rows="3"></textarea>
                                            </div>
                                         </div>
                                     </div>
                                     <!-- Modal footer -->
                                         <div class="px-5 py-4 border-t border-slate-200">
                                             <div class="flex flex-wrap justify-end space-x-2">
                                                 <button type="button"
                                                    class="btn btn-sm btn-update bg-indigo-500 hover:bg-indigo-600 text-white">Add Description</button>
                                             </div>
                                         </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-data="{ modalOpen: false }">
                        <!-- Modal backdrop -->
                        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
                            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true"
                            x-cloak></div>
                        <!-- Modal dialog -->
                        <div id="feedback-modal456"
                            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                            role="dialog" aria-modal="true" x-show="modalOpen"
                            x-transition:enter="transition ease-in-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in-out duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
                            <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add Description</div>
                                    </div>
                                </div>
                                <!-- Modal content -->
                                <div class="modal-content text-xs">
                                    <div class="px-5 py-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-slate-800 mb-3"></div>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="username1">Description<span
                                                        class="text-rose-500">*</span></label>
                                                <textarea id="remarks123" name="remarks123" type="text" class="remarks123 form-input w-full px-2 py-1" rows="3"></textarea>
                                            </div>
                                         </div>
                                     </div>
                                     <!-- Modal footer -->
                                         <div class="px-5 py-4 border-t border-slate-200">
                                             <div class="flex flex-wrap justify-end space-x-2">
                                                 <button type="button"
                                                    class="btn btn-sm btn-update1 bg-indigo-500 hover:bg-indigo-600 text-white">Add Description</button>
                                             </div>
                                         </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="single_costpayment" name="single_costpayment" style="width: 14rem;" class="single_costpayment form-input w-full px-2 py-1 read-only:bg-slate-200" hidden readonly/>
                <input id="grandtotal1" name="grandtotal1" style="width: 14rem;" class="grandtotal1 form-input w-full px-2 py-1 read-only:bg-slate-200" hidden readonly/>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr class="bg-slate-400">
                                <th class="text-sm text-center">Company</th>
                                <th class="text-sm text-center">Reff #</th>
                                <th class="text-sm text-center">Beneficiary</th>
                                <th class="text-sm text-center">Description</th>
                                <th class="text-sm text-center">Invoice Amount</th>
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                {{-- <div class="flex flex-row mb-3 mt-3">
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
                </div> --}}
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
                    </select>
                    @else
                    <input id="company_id" name="company_id" class="company_id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{ Auth::user()->company_id}}" readonly required hidden/>
                    <input id="companies" name="companies"
                    class="companies form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    value="{{$dataChildCompany1->name}}" required readonly/>
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
                            <input id="payment_type" name="payment_type" class="payment_type form-input w-full px-2 py-1 read-only:bg-slate-200" value="A/P" required readonly/>
                        </div>
                        <div>
                            <input id="currency" name="currency" style="width: 14rem;" class="currency form-input w-full px-2 py-1 read-only:bg-slate-200" value="" required readonly/>
                        </div>
                        <div>
                            <input id="amount" name="amount" style="width: 14rem; margin-left: 41px; margin-right: 30px;" class="amount numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" required/>
                            <input id="balances" name="balances" class="balances form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly/>
                            <input id="approves" name="approves" class="approves form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly/>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" id="fullAmount">Full Amount</button>
                        </div>
                        <div>
                            <input id="lessRounding" name="lessRounding" style="width: 13rem; margin-left: 20px;" class="lessRounding extended-numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="0"/>
                            <input id="balancessx" name="balancessx" class="balancessx form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly/>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="payfrom">Payment To Beneficiary By<span class="text-rose-500">*</span></label>
                    <select id="payfrom" name="payfrom" class="payfrom selector form-select w-full md:w-3/4 px-2 py-1" disabled required>
                        <option value="" selected hidden>Select Bank Company</option>
                        @foreach ($cidBank as $cid)
                            <option value="{{ $cid->id_cidb }}" 
                                    data-id_company="{{ $cid->id_company }}" 
                                    data-cidbank="{{ $cid->cidbank }}" 
                                    data-bank_acc="{{ $cid->bank_acc }}"
                                    data-bank_name="{{ $cid->bankName }}"
                                    data-pv_code="{{ $cid->pv_code }}">
                                    @if ($cid->pv_code == null)                                        
                                        {{ $cid->bankName }} | {{ $cid->cidbank }} | {{ $cid->bank_acc }}
                                    @else                                        
                                        {{ $cid->bankName }} | {{ $cid->cidbank }} | {{ $cid->pv_code == null ? '':$cid->pv_code }} | {{ $cid->bank_acc }}
                                    @endif
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
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Approved By / Released By<span
                        class="text-rose-500">*</span></label>
                        <div style="width: 31rem; margin-right: 40px;">
                            <input id="approved_by" name="approved_by" class="approved_by form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Approved By" required/>
                        </div>
                        <div>
                            <input id="released_by" name="released_by" style="width: 31.7rem;" class="released_by form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Released By" required/>
                        </div>
                </div>
                {{-- <div class="flex justify-between flex-col md:flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks">Description<span class="text-rose-500">*</span></label>
                    <input id="remarks" name="remarks" class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"/>
                </div> --}}
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_form">
                        <span class="xs:block ml-5 mr-5">Create Payment</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>
    let subtotal = 0;
    let approved = 0;
    let rowIdx = 0;
    function calculateGrandTotal() {
        subtotal = 0;
        $('.tableProductAddBody tbody tr').each(function() {
            const totalas = parseFloat($(this).find('input[name^="rows["][name*="][totals]"]').val()) || 0;
            subtotal += totalas;
        });
        $('#grandTotal_text').text(`${divider(subtotal)}`);
        $('#grandTotal_text').val(`${divider(subtotal)}`);
        $("#balances").val(subtotal);
        $("#grandtotal1").val(subtotal);
        $("#amount").val(divider(subtotal)); 
        calculateBalance();
        updateGrandTotal();
    }
    function updateGrandTotal() {
        subtotal = 0;
        $('.tableProductAddBody tbody tr').each(function() {
            const totalas = parseFloat($(this).find('input[name^="rows["][name*="][totals]"]').val()) || 0;
            subtotal += totalas;
        });
        $('#grandTotal_text').text(`${divider(subtotal)}`);
        $('#grandTotal_text').val(`${divider(subtotal)}`);
        $("#balances").val(subtotal);
        $("#grandtotal1").val(subtotal);
        $("#amount").val(divider(subtotal)); 
    }
    $('#fullAmount').on('click', function () {
        $("#amount").val(divider(subtotal)); 
        $("#lessRounding").val('0'); 
    });
    $(document).ready(function () {
        $('#payment').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Payment: "
                },
                ajax: {
                    url: "{{ route('payment.select') }}",
                    data:function(d){
                        d.company = $("#company").val(),
                        d.status = $("#status").val()
                    }
                },
                columns: [
                    {
                        data: "due_date",
                        name: "due_date"
                    },
                    {
                        data: "date",
                        name: "date"
                    },
                    {
                        data: "form_type",
                        name: "form_type"
                    },
                    {
                        data: "companyName",
                        name: "companyName"
                    },
                    {
                        data: "id_costpayment",
                        name: "id_costpayment"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "balance",
                        name: "balance"
                    },
                    {
                        data: "created_by",
                        name: "created_by"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 8] },
                    { className: 'text-right', targets: [6] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
        $(".status").on('change', function (e) {
            $('#payment').DataTable().ajax.reload();
        })
        $(".company").on('change', function (e) {
            $('#payment').DataTable().ajax.reload();
        })
        $('#payment').on("click", ".btn-select", function () {
            var prods = [];
            const id = $(this).data("id");
            const id_costpayment = $(this).data("id_costpayment");
            const id_company = $(this).data("id_company");
            const company_name = $(this).data("company_name");
            const company = $(this).data("company");
            const idsupplier = $(this).data("idsupplier");
            const form_type = $(this).data("form_type");
            const beneficiary_bank = $(this).data("beneficiary_bank");
            const beneficiary_name = $(this).data("beneficiary_name");
            const beneficiary_acc = $(this).data("beneficiary_acc");
            const approved_total_raw = $(this).data("approved_total");
            const approved_total = Math.floor(approved_total_raw);
            const balance_raw = $(this).data("balance");
            const balance = Math.floor(balance_raw);
            // const department = $(this).data("department");
            // const name_rab = $(this).data("name_rab");
            // const po_title = $(this).data("po_title");
            // const note = $(this).data("note");
            const department = event.target.getAttribute('data-department');
            const name_rab = event.target.getAttribute('data-name_rab');
            const po_title = event.target.getAttribute('data-po_title');
            const note = event.target.getAttribute('data-note');
            const status = $(this).data("status");
            const currency = $(this).data("currency");
            const crate = $(this).data("crate");
            
            $(".btn-pay").attr("hidden", true);
            $(".btn-payment").attr("hidden", false);
            $("#stats").val(status);
            $("#id_company").val(id_company);
            const userCompanyId = '{{ Auth::user()->company_id }}';
            if (userCompanyId == '0' || userCompanyId == '999' || userCompanyId == '888') {
                let options = `<option selected hidden value="">Select Company</option>`;
                if (id_company == '1') {
                    options = '<option selected hidden value="">Select Company</option><option value="{{$dataHeadCompany->id_company}}">{{$dataHeadCompany->name}}</option>';
                } else {
                    options += `<option value="{{$dataHeadCompany->id_company}}">{{$dataHeadCompany->name}}</option><option value="${id_company}">${company_name}</option>`;   
                }
                
                $("#company_id").html(options); // Update the options in the select element
            }
            $("#idsupplier").val(idsupplier);
            $("#beneficiary").val(beneficiary_acc);
            $("#formstypes").val(form_type);
            $("#currency").val(currency);
            $("#single_costpayment").val(id_costpayment);
            $('#payments').DataTable().ajax.reload();
            if ($('#tableProductAddBody').find(`[name*="[ids]"][value="${id_costpayment}"]`).length > 0) {
                alert('Same Payment cannot be added again.');
                return false;
            }
                
            subtotal += balance;
            approved += approved_total;
                
            prods.push({rowIdx, id, id_costpayment, id_company, company_name, company, idsupplier, form_type, beneficiary_bank, beneficiary_name, beneficiary_acc, approved_total, balance, department, name_rab, status});
            if (form_type == 'Cost Center') {
                $(document).on('input', `[id^="invoice-amount_"]`, function (e) {
                    const rowIdx = this.id.split('_')[1];
                    const subtotal = parseFloat($('#invoice-amount_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                    $('#itemTotal_' + rowIdx).val(allinDivider(subtotal));
                });
                var tr = `<tr id="row-${rowIdx}">
                            <td class="text-left">${company_name}<textarea name="rows[${rowIdx}][namesis]" hidden>${company_name}</textarea></td>
                            <td class="text-left"><span id="qtys-text_${rowIdx}">${id_costpayment}</span><input name="rows[${rowIdx}][ids]" value="${id_costpayment}" hidden/><input name="rows[${rowIdx}][crates]" value="${crate}" hidden/></td>
                            <td class="text-left"><textarea name="rows[${rowIdx}][companys]" hidden>${company}</textarea><span id="companys-text_${rowIdx}">${company}</span></td>
                            <td class="text-left"><span id="prices-text_${rowIdx}">${department}</span><textarea name="rows[${rowIdx}][descs]" hidden>${department}</textarea></td>
                            <td class="text-right"><span id="totals-text_${rowIdx}">${divider(balance)}</span><input id="totals_${rowIdx}" name="rows[${rowIdx}][totals]" value="${newDivider2(balance)}" hidden/><input id="balances_${rowIdx}" name="rows[${rowIdx}][balances]" value="${newDivider2(balance)}" hidden/></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${rowIdx}, ${balance}, ${approved_total}, '${id_costpayment}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button>
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
                                                <div class="font-semibold text-slate-800">Adjust Payment Detail</div>
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
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="unit">Description<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <textarea id="desc_${rowIdx}" name="desc"
                                                        class="desc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="500" rows="3">${department}</textarea>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="invoice-amount">Nominal Amount
                                                    </label>
                                                    <input id="invoice-amount_${rowIdx}" name="invoice-amount" class="form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}"/>
                                                    <input id="budget_${rowIdx}" name="budget" class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}" readonly hidden/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Invoice Amount
                                                    </label>
                                                    <input id="itemTotal_${rowIdx}" name="itemTotal"
                                                    class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                    type="text" value="${newDivider1(balance)}" readonly/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct('${rowIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>`;
            }else if (form_type == 'Reimburse') {
                $(document).on('input', `[id^="invoice-amount_"]`, function (e) {
                    const rowIdx = this.id.split('_')[1];
                    const subtotal = parseFloat($('#invoice-amount_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                    $('#itemTotal_' + rowIdx).val(allinDivider(subtotal));
                });
                var tr = `<tr id="row-${rowIdx}">
                            <td class="text-left">${company_name}<textarea name="rows[${rowIdx}][namesis]" hidden>${company_name}</textarea></td>
                            <td class="text-left"><span id="qtys-text_${rowIdx}">${id_costpayment}</span><input name="rows[${rowIdx}][ids]" value="${id_costpayment}" hidden/><input name="rows[${rowIdx}][crates]" value="${crate}" hidden/></td>
                            <td class="text-left"><textarea name="rows[${rowIdx}][companys]" hidden>${company}</textarea><span id="companys-text_${rowIdx}">${company}</span></td>
                            <td class="text-left"><span id="prices-text_${rowIdx}">${note}</span><textarea name="rows[${rowIdx}][descs]" hidden>${note}</textarea></td>
                            <td class="text-right"><span id="totals-text_${rowIdx}">${divider(balance)}</span><input id="totals_${rowIdx}" name="rows[${rowIdx}][totals]" value="${newDivider2(balance)}" hidden/><input id="balances_${rowIdx}" name="rows[${rowIdx}][balances]" value="${newDivider2(balance)}" hidden/></td>
                            <td class="text-center flex flex-row justify-center">
                                <button type="button" onclick="deleteDataProduct(${rowIdx}, ${balance}, ${approved_total}, '${id_costpayment}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300"><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"><path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/></svg></button>
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
                                                    <div class="font-semibold text-slate-800">Adjust Payment Detail</div>
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
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="unit">Description<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <textarea id="desc_${rowIdx}" name="desc"
                                                        class="desc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="500" rows="3">${note}</textarea>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="invoice-amount">Nominal Amount
                                                    </label>
                                                    <input id="invoice-amount_${rowIdx}" name="invoice-amount" class="form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}"/>
                                                    <input id="budget_${rowIdx}" name="budget" class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}" readonly hidden/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Invoice Amount
                                                    </label>
                                                    <input id="itemTotal_${rowIdx}" name="itemTotal"
                                                    class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                    type="text" value="${newDivider1(balance)}" readonly/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct('${rowIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </td>
                        </tr>`;
            }else if(form_type == 'RAB'){
                $(document).on('input', `[id^="invoice-amount_"]`, function (e) {
                    const rowIdx = this.id.split('_')[1];
                    const subtotal = parseFloat($('#invoice-amount_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                    $('#itemTotal_' + rowIdx).val(allinDivider(subtotal));
                });
                var tr = `<tr id="row-${rowIdx}">
                            <td class="text-left">${company_name}<textarea name="rows[${rowIdx}][namesis]" hidden>${company_name}</textarea></td>
                            <td class="text-left"><span id="qtys-text_${rowIdx}">${id_costpayment}</span><input name="rows[${rowIdx}][ids]" value="${id_costpayment}" hidden/><input name="rows[${rowIdx}][crates]" value="${crate}" hidden/></td>
                            <td class="text-left"><textarea name="rows[${rowIdx}][companys]" hidden>${company}</textarea><span id="companys-text_${rowIdx}">${company}</span></td>
                            <td class="text-left"><span id="prices-text_${rowIdx}">${name_rab}</span><textarea name="rows[${rowIdx}][descs]" hidden>${name_rab}</textarea></td>
                            <td class="text-right"><span id="totals-text_${rowIdx}">${divider(balance)}</span><input id="totals_${rowIdx}" name="rows[${rowIdx}][totals]" value="${newDivider2(balance)}" hidden/><input id="balances_${rowIdx}" name="rows[${rowIdx}][balances]" value="${newDivider2(balance)}" hidden/></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${rowIdx}, ${balance}, ${approved_total}, '${id_costpayment}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button>
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
                                                <div class="font-semibold text-slate-800">Adjust Payment Detail</div>
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
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="unit">Description<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <textarea id="desc_${rowIdx}" name="desc"
                                                        class="desc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="500" rows="3">${name_rab}</textarea>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="invoice-amount">Nominal Amount
                                                    </label>
                                                    <input id="invoice-amount_${rowIdx}" name="invoice-amount" class="form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}"/>
                                                    <input id="budget_${rowIdx}" name="budget" class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}" readonly hidden/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Invoice Amount
                                                    </label>
                                                    <input id="itemTotal_${rowIdx}" name="itemTotal"
                                                    class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                    type="text" value="${newDivider1(balance)}" readonly/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct('${rowIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>`;
            }else if(form_type == 'PO'){
                $(document).on('input', `[id^="invoice-amount_"]`, function (e) {
                    const rowIdx = this.id.split('_')[1];
                    const subtotal = parseFloat($('#invoice-amount_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                    $('#itemTotal_' + rowIdx).val(allinDivider(subtotal));
                });
                var tr = `<tr id="row-${rowIdx}">
                            <td class="text-left">${company_name}<textarea name="rows[${rowIdx}][namesis]" hidden>${company_name}</textarea></td>
                            <td class="text-left"><span id="qtys-text_${rowIdx}">${id_costpayment}</span><input name="rows[${rowIdx}][ids]" value="${id_costpayment}" hidden/><input name="rows[${rowIdx}][crates]" value="${crate}" hidden/></td>
                            <td class="text-left"><textarea name="rows[${rowIdx}][companys]" hidden>${company}</textarea><span id="companys-text_${rowIdx}">${company}</span></td>
                            <td class="text-left"><span id="prices-text_${rowIdx}">${po_title}</span><textarea name="rows[${rowIdx}][descs]" hidden>${po_title}</textarea></td>
                            <td class="text-right"><span id="totals-text_${rowIdx}">${divider(balance)}</span><input id="totals_${rowIdx}" name="rows[${rowIdx}][totals]" value="${newDivider2(balance)}" hidden/><input id="balances_${rowIdx}" name="rows[${rowIdx}][balances]" value="${newDivider2(balance)}" hidden/></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${rowIdx}, ${balance}, ${approved_total}, '${id_costpayment}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button>
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
                                                <div class="font-semibold text-slate-800">Adjust Payment Detail</div>
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
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="unit">Description<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <textarea id="desc_${rowIdx}" name="desc"
                                                        class="desc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="500" rows="3">${po_title}</textarea>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="invoice-amount">Nominal Amount
                                                    </label>
                                                    <input id="invoice-amount_${rowIdx}" name="invoice-amount" class="form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}"/>
                                                    <input id="budget_${rowIdx}" name="budget" class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}" readonly hidden/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Invoice Amount
                                                    </label>
                                                    <input id="itemTotal_${rowIdx}" name="itemTotal"
                                                    class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                    type="text" value="${newDivider1(balance)}" readonly/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct('${rowIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>`;
            }
            if (subtotal != approved) {
                $("#lessRounding").attr("readonly", true);
            } else {
                $("#lessRounding").attr("readonly", false);
            }
            $('#remarks').val('');
            $("#amount").val(divider(subtotal));
            $("#approves").val(newDivider2(approved));
            $("#lessRounding").val('0');
            var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
            grandTotalRow.detach();
            $("#tableProductAddBody").append(tr).append(grandTotalRow);
            updateGrandTotal();
            calculateGrandTotal();
            rowIdx++;
        });
        $('#payments').DataTable({
            responsive: true,
            processing: true,
            serverSide: false,
            stateServe: true,
            "order": [[ 0, "asc" ]],
            language: {
                search: "Search Payment: "
            },
            ajax: {
                url: "{{ route('select.payment') }}",
                data:function(d){
                    d.formstypes = $("#formstypes").val(),
                    d.stats = $("#stats").val(),
                    d.id_company = $("#id_company").val(),
                    d.idsupplier = $("#idsupplier").val(),
                    d.beneficiary = $("#beneficiary").val()
                }
            },
            columns: [
                {
                    data: "due_date",
                    name: "due_date"
                },
                {
                    data: "date",
                    name: "date"
                },
                {
                    data: "form_type",
                    name: "form_type"
                },
                {
                    data: "companyName",
                    name: "companyName"
                },
                {
                    data: "id_costpayment",
                    name: "id_costpayment"
                },
                {
                    data: "company",
                    name: "company"
                },
                {
                    data: "balance",
                    name: "balance"
                },
                {
                    data: "created_by",
                    name: "created_by"
                },
                {
                    data: "action",
                    name: "action"
                },
            ],
            columnDefs: [
                { className: 'text-center', targets: [0, 1, 8] },
                { className: 'text-right', targets: [6] },
            ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
        });
        $('#payments').on("click", ".btn-select1", function () {
            var prods = [];
            const id = $(this).data("id");
            const id_costpayment = $(this).data("id_costpayment");
            const id_company = $(this).data("id_company");
            const company_name = $(this).data("company_name");
            const company = $(this).data("company");
            const idsupplier = $(this).data("idsupplier");
            const form_type = $(this).data("form_type");
            const beneficiary_bank = $(this).data("beneficiary_bank");
            const beneficiary_name = $(this).data("beneficiary_name");
            const beneficiary_acc = $(this).data("beneficiary_acc");
            const approved_total_raw = $(this).data("approved_total");
            const approved_total = Math.floor(approved_total_raw);
            const balance_raw = $(this).data("balance");
            const balance = Math.floor(balance_raw);
            const department = event.target.getAttribute('data-department');
            const name_rab = event.target.getAttribute('data-name_rab');
            const po_title = event.target.getAttribute('data-po_title');
            const note = event.target.getAttribute('data-note');
            const status = $(this).data("status");
            const currency = $(this).data("currency");
            const crate = $(this).data("crate");

                        
            if ($('#tableProductAddBody').find(`[name*="[ids]"][value="${id_costpayment}"]`).length > 0) {
                alert('Same Payment cannot be added again.');
                return false;
            }
                
            subtotal += balance;
            approved += approved_total;
                
            prods.push({rowIdx, id, id_costpayment, id_company, company_name, company, idsupplier, form_type, beneficiary_bank, beneficiary_name, beneficiary_acc, approved_total, balance, department, name_rab, status});
            if (form_type == 'Cost Center') {
                $(document).on('input', `[id^="invoice-amount_"]`, function (e) {
                    const rowIdx = this.id.split('_')[1];
                    const subtotal = parseFloat($('#invoice-amount_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                    $('#itemTotal_' + rowIdx).val(allinDivider(subtotal));
                });
                var tr = `<tr id="row-${rowIdx}">
                            <td class="text-left">${company_name}<textarea name="rows[${rowIdx}][namesis]" hidden>${company_name}</textarea></td>
                            <td class="text-left"><span id="qtys-text_${rowIdx}">${id_costpayment}</span><input name="rows[${rowIdx}][ids]" value="${id_costpayment}" hidden/><input name="rows[${rowIdx}][crates]" value="${crate}" hidden/></td>
                            <td class="text-left"><textarea name="rows[${rowIdx}][companys]" hidden>${company}</textarea><span id="companys-text_${rowIdx}">${company}</span></td>
                            <td class="text-left"><span id="prices-text_${rowIdx}">${department}</span><textarea name="rows[${rowIdx}][descs]" hidden>${department}</textarea></td>
                            <td class="text-right"><span id="totals-text_${rowIdx}">${divider(balance)}</span><input id="totals_${rowIdx}" name="rows[${rowIdx}][totals]" value="${newDivider2(balance)}" hidden/><input id="balances_${rowIdx}" name="rows[${rowIdx}][balances]" value="${newDivider2(balance)}" hidden/></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${rowIdx}, ${balance}, ${approved_total}, '${id_costpayment}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button>
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
                                                <div class="font-semibold text-slate-800">Adjust Payment Detail</div>
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
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="unit">Description<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <textarea id="desc_${rowIdx}" name="desc"
                                                        class="desc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="500" rows="3">${department}</textarea>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="invoice-amount">Nominal Amount
                                                    </label>
                                                    <input id="invoice-amount_${rowIdx}" name="invoice-amount" class="form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}"/>
                                                    <input id="budget_${rowIdx}" name="budget" class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}" readonly hidden/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Invoice Amount
                                                    </label>
                                                    <input id="itemTotal_${rowIdx}" name="itemTotal"
                                                    class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                    type="text" value="${newDivider1(balance)}" readonly/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct('${rowIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>`;
            }else if (form_type == 'Reimburse') {
                $(document).on('input', `[id^="invoice-amount_"]`, function (e) {
                    const rowIdx = this.id.split('_')[1];
                    const subtotal = parseFloat($('#invoice-amount_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                    $('#itemTotal_' + rowIdx).val(allinDivider(subtotal));
                });
                var tr = `<tr id="row-${rowIdx}">
                            <td class="text-left">${company_name}<textarea name="rows[${rowIdx}][namesis]" hidden>${company_name}</textarea></td>
                            <td class="text-left"><span id="qtys-text_${rowIdx}">${id_costpayment}</span><input name="rows[${rowIdx}][ids]" value="${id_costpayment}" hidden/><input name="rows[${rowIdx}][crates]" value="${crate}" hidden/></td>
                            <td class="text-left"><textarea name="rows[${rowIdx}][companys]" hidden>${company}</textarea><span id="companys-text_${rowIdx}">${company}</span></td>
                            <td class="text-left"><span id="prices-text_${rowIdx}">${note}</span><textarea name="rows[${rowIdx}][descs]" hidden>${note}</textarea></td>
                            <td class="text-right"><span id="totals-text_${rowIdx}">${divider(balance)}</span><input id="totals_${rowIdx}" name="rows[${rowIdx}][totals]" value="${newDivider2(balance)}" hidden/><input id="balances_${rowIdx}" name="rows[${rowIdx}][balances]" value="${newDivider2(balance)}" hidden/></td>
                            <td class="text-center flex flex-row justify-center">
                                <button type="button" onclick="deleteDataProduct(${rowIdx}, ${balance}, ${approved_total}, '${id_costpayment}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300"><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"><path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/></svg></button>
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
                                                    <div class="font-semibold text-slate-800">Adjust Payment Detail</div>
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
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="unit">Description<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <textarea id="desc_${rowIdx}" name="desc"
                                                        class="desc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="500" rows="3">${note}</textarea>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="invoice-amount">Nominal Amount
                                                    </label>
                                                    <input id="invoice-amount_${rowIdx}" name="invoice-amount" class="form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}"/>
                                                    <input id="budget_${rowIdx}" name="budget" class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}" readonly hidden/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Invoice Amount
                                                    </label>
                                                    <input id="itemTotal_${rowIdx}" name="itemTotal"
                                                    class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                    type="text" value="${newDivider1(balance)}" readonly/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct('${rowIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            </td>
                        </tr>`;
            }else if(form_type == 'RAB'){
                $(document).on('input', `[id^="invoice-amount_"]`, function (e) {
                    const rowIdx = this.id.split('_')[1];
                    const subtotal = parseFloat($('#invoice-amount_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                    $('#itemTotal_' + rowIdx).val(allinDivider(subtotal));
                });
                var tr = `<tr id="row-${rowIdx}">
                            <td class="text-left">${company_name}<textarea name="rows[${rowIdx}][namesis]" hidden>${company_name}</textarea></td>
                            <td class="text-left"><span id="qtys-text_${rowIdx}">${id_costpayment}</span><input name="rows[${rowIdx}][ids]" value="${id_costpayment}" hidden/><input name="rows[${rowIdx}][crates]" value="${crate}" hidden/></td>
                            <td class="text-left"><textarea name="rows[${rowIdx}][companys]" hidden>${company}</textarea><span id="companys-text_${rowIdx}">${company}</span></td>
                            <td class="text-left"><span id="prices-text_${rowIdx}">${name_rab}</span><textarea name="rows[${rowIdx}][descs]" hidden>${name_rab}</textarea></td>
                            <td class="text-right"><span id="totals-text_${rowIdx}">${divider(balance)}</span><input id="totals_${rowIdx}" name="rows[${rowIdx}][totals]" value="${newDivider2(balance)}" hidden/><input id="balances_${rowIdx}" name="rows[${rowIdx}][balances]" value="${newDivider2(balance)}" hidden/></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${rowIdx}, ${balance}, ${approved_total}, '${id_costpayment}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button>
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
                                                <div class="font-semibold text-slate-800">Adjust Payment Detail</div>
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
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="unit">Description<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <textarea id="desc_${rowIdx}" name="desc"
                                                        class="desc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="500" rows="3">${name_rab}</textarea>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="invoice-amount">Nominal Amount
                                                    </label>
                                                    <input id="invoice-amount_${rowIdx}" name="invoice-amount" class="form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}"/>
                                                    <input id="budget_${rowIdx}" name="budget" class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}" readonly hidden/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Invoice Amount
                                                    </label>
                                                    <input id="itemTotal_${rowIdx}" name="itemTotal"
                                                    class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                    type="text" value="${newDivider1(balance)}" readonly/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct('${rowIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>`;
            }else if(form_type == 'PO'){
                $(document).on('input', `[id^="invoice-amount_"]`, function (e) {
                    const rowIdx = this.id.split('_')[1];
                    const subtotal = parseFloat($('#invoice-amount_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                    $('#itemTotal_' + rowIdx).val(allinDivider(subtotal));
                });
                var tr = `<tr id="row-${rowIdx}">
                            <td class="text-left">${company_name}<textarea name="rows[${rowIdx}][namesis]" hidden>${company_name}</textarea></td>
                            <td class="text-left"><span id="qtys-text_${rowIdx}">${id_costpayment}</span><input name="rows[${rowIdx}][ids]" value="${id_costpayment}" hidden/><input name="rows[${rowIdx}][crates]" value="${crate}" hidden/></td>
                            <td class="text-left"><textarea name="rows[${rowIdx}][companys]" hidden>${company}</textarea><span id="companys-text_${rowIdx}">${company}</span></td>
                            <td class="text-left"><span id="prices-text_${rowIdx}">${po_title}</span><textarea name="rows[${rowIdx}][descs]" hidden>${po_title}</textarea></td>
                            <td class="text-right"><span id="totals-text_${rowIdx}">${divider(balance)}</span><input id="totals_${rowIdx}" name="rows[${rowIdx}][totals]" value="${newDivider2(balance)}" hidden/><input id="balances_${rowIdx}" name="rows[${rowIdx}][balances]" value="${newDivider2(balance)}" hidden/></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${rowIdx}, ${balance}, ${approved_total}, '${id_costpayment}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button>
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
                                                <div class="font-semibold text-slate-800">Adjust Payment Detail</div>
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
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="unit">Description<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <textarea id="desc_${rowIdx}" name="desc"
                                                        class="desc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="500" rows="3">${po_title}</textarea>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="invoice-amount">Nominal Amount
                                                    </label>
                                                    <input id="invoice-amount_${rowIdx}" name="invoice-amount" class="form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}"/>
                                                    <input id="budget_${rowIdx}" name="budget" class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(balance)}" readonly hidden/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Invoice Amount
                                                    </label>
                                                    <input id="itemTotal_${rowIdx}" name="itemTotal"
                                                    class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                    type="text" value="${newDivider1(balance)}" readonly/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct('${rowIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>`;
            }

            $('#remarks').val('');
            $("#amount").val(divider(subtotal));
            $("#approves").val(newDivider2(approved));
            $("#amount").attr("readonly", true);
            if ($("#tableProductAddBody tr[id^='row-']").length > 0 && subtotal != approved) {
                $("#lessRounding").attr("readonly", true);
            } else {
                $("#lessRounding").attr("readonly", false);
            }
            $("#lessRounding").val('0');
            var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
            grandTotalRow.detach();
            $("#tableProductAddBody").append(tr).append(grandTotalRow);
            updateGrandTotal();
            calculateGrandTotal();
            rowIdx++;
        });
    })
    var grandTotalRow = `<tr class="grandTotalRow bg-slate-400">
            <td class="text-center font-bold text-lg" colspan="4">To Be Paid</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(subtotal)}</span></td>
            <td></td>
        </tr>`;
    $("#tableProductAddBody").append(grandTotalRow);
    function deleteDataProduct(positionTableRow, balance, approved_total, id_costpayment) {
        const positionTableRowVariable = positionTableRow
        // subtotal -= balance;
        // approved -= approved_total;
        // $("#amount").val(divider(subtotal));
        // $("#approves").val(newDivider2(approved));
        $("#lessRounding").val('0');
        $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();
        if ($("#tableProductAddBody tr[id^='row-']").length === 0) {
            $(".btn-payment").attr("hidden", true);
            $(".btn-pay").attr("hidden", false);
            $("#lessRounding").val('0');
            $("#remarks").val('');
            $("#lessRounding").attr("readonly", false);
        }
        if ($("#tableProductAddBody tr[id^='row-']").length === 1) {
            if (subtotal != approved) {
                $("#lessRounding").attr("readonly", true);
                $("#amount").attr("readonly", false);
            } else {
                $("#lessRounding").attr("readonly", false);
                $("#amount").attr("readonly", false);
            }
        }
        calculateGrandTotal();
        updateGrandTotal();
    }

    function updateDataProduct(rowIdx) {
        var description = $('#desc_'+rowIdx).val();
        var descriptionTextarea = $(`#row-${rowIdx}`).find(`textarea[name="rows[${rowIdx}][descs]"]`);
        // Update the textarea value in the current row
        descriptionTextarea.val(description);
        $('#prices-text_'+rowIdx).text(description);

        var amount = parseFloat($('#invoice-amount_'+rowIdx).val().replace(/\./g, '').replace(/,/g, '.'));
        var budget = parseFloat($('#budget_'+rowIdx).val().replace(/\./g, '').replace(/,/g, '.'));

        if (amount > budget) {
            alert('Error, Invoice Amount exceeds limit');
            return false;
        }
        $('#totals_'+rowIdx).val(amount);
        $('#totals-text_'+rowIdx).text(allinDivider(amount));
        $("#amount").val(allinDivider(amount)); 
        calculateGrandTotal();
        updateGrandTotal();
    }

    $('#payment_type').on('change', function () {
        const payment_type = $(this).val();
        const balances_whtt = $('#balance_whtt').val();
        const balancess = $('#balancex').val();
        const currencyValue = $('#currency').val();

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
            var paymentType = document.getElementById('payment_type').value;
            var balance = parseFloat(subtotal);
            var approvas = parseFloat(approved);
            var balances = parseFloat($('#balances').val().replace(/\./g, '')) || 0;
            var balanceWHT = parseFloat(subtotal);

            // Menghapus titik pemisah ribuan dari nilai input
            var amountInputValue = document.getElementById('amount').value.replace(/\./g, '');
            var lessInputValue = document.getElementById('lessRounding').value.replace(/\./g, '');
            var lessRoundings = parseFloat(lessInputValue);
            var amount = parseFloat(amountInputValue);

            if (amount > balance) {
                alert("Amount cannot exceed the balance.");
                $('#create_form').attr('disabled', true);
                previousAmount = amountInputValue;
                previousLessRounding = lessInputValue;
                // Kembalikan nilai input ke nilai sebelumnya
                document.getElementById('amount').value = addThousandSeparator(previousAmount);
            } else if (lessRoundings > amount) {
                alert("Less round cannot exceed the amount.");
                $('#create_form').attr('disabled', true);
                document.getElementById('lessRounding').value = addThousandSeparator(previousLessRounding);
            } else if(amount !== approvas){
                $("#lessRounding").attr("readonly", true);
                $("#lessRounding").val('0');
                $('#create_form').attr('disabled', false);
            } else if(amount === approvas){
                $("#lessRounding").attr("readonly", false);
                $('#create_form').attr('disabled', false);
            } else {
                // Jika nilai tidak melebihi batas, update nilai sebelumnya
                previousAmount = amountInputValue;
                previousLessRounding = lessInputValue;
                $('#create_form').attr('disabled', false);
            }
            // else if (paymentType === 'WHT' && amount > balanceWHT) {
            //     alert("Amount cannot exceed the balance WHT.");
            //     $('#create_form').attr('disabled', true);
            //     previousAmount = amountInputValue;
            //     previousLessRounding = lessInputValue;
            //     // Kembalikan nilai input ke nilai sebelumnya
            //     document.getElementById('amount').value = addThousandSeparator(previousAmount);
            // } 
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
                previousBalance = parseFloat(subtotal);
            } else {
                previousBalance = parseFloat(subtotal);
            }
            calculateBalance();
            rounding();
        });
    });

    function calculateBalance() {
        const payment_type = $('#payment_type').val();
        const amount = parseFloat($('#amount').val().replace(/\./g, '')) || 0;

        let balance;

        // Gunakan saldo sebelumnya untuk perhitungan saldo baru
        if (payment_type === 'A/P') {
            balance = subtotal; // gunakan langsung nilai subtotal
        } else {
            // Mengambil nilai dari input balance_wht
            balance = parseFloat($('#balance_wht').val().replace(/\./g, '')) || 0;
        }

        // Hitung saldo baru berdasarkan saldo sebelumnya dan jumlah pembayaran
        const totalAmount = Math.floor(balance - amount);

        // Update nilai di elemen balances
        $('#balances').val(totalAmount);
        $('#balances').text(totalAmount); // Jika elemen balances adalah teks, bukan input
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
        $("#create_form").prop('disabled', true);
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
                }else if (_response.st === '3') {
                    alert("Amount must be full value if Payment are more than one");
                }else if (_response.st === '4') {
                    alert("One of payment are already paid or insufficient balance. Please Refresh The Page");
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