<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Form Purchase Request Inventory Asset📝</h1>
        </div>
        {{-- <div class="px-5 py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
                <p class="flex flex-row ml-1">On Budget</p>
                <div class="rounded-full bg-red-500 columns-1 h-5 w-5 ml-5"></div>
                <p class="flex flex-row ml-1">Over Budget</p>
            </div>
        </div> --}}

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('purchase-request.createga') }}" id="form_create1">
                @csrf
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">PR Date<span
                        class="text-rose-500">*</span></label>
                    <input id="date" name="date"
                        class="date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{date('Y-m-d')}}" data-date-format="YYYY/MM/DD" type="date" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="pr_title">PR Title<span
                        class="text-rose-500">*</span></label>
                    <input id="pr_title" name="pr_title"
                        class="pr_title form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id">User (Applicant)<span
                        class="text-rose-500">*</span></label>
                    <input id="name" name="name"
                        class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->username}}" readonly/>
                    <input id="id" name="id"
                        class="id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->employee_id}}" readonly hidden/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="company">Company<span
                        class="text-rose-500">*</span>
                    </label>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                        <select id="company1" name="company1"
                            class="company1 form-select w-full md:w-3/4 px-2 py-1" required>
                            <option selected hidden value="">Select Company</option>
                            @foreach ( $dataChildCompany as $company )
                                <option value="{{$company->id_company}}">{{$company->name}}</option>
                            @endforeach
                        </select>
                        <input id="company" name="company"
                        class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly hidden/>
                    @else
                        <select id="companyTest" name="companyTest"
                            class="companyTest form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" disabled required>
                                <option value="{{$dataChildCompany->id_company}}" selected>{{$dataChildCompany->name}}</option>
                        </select>
                        <input id="company" name="company"
                        class="company form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$dataChildCompany->id_company}}" readonly hidden/>
                    @endif
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="level">Request Level<span
                        class="text-rose-500">*</span>
                    </label>
                    <select id="level" name="level"
                        class="level form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Level</option>
                        <option value="Normal">Normal</option>
                        <option value="Important">Important</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="req">Delivery Date<span
                        class="text-rose-500">*</span></label>
                    <input id="req" name="req"
                        class="req selector form-input w-full md:w-3/4 px-2 py-1" value="{{date('Y-m-d')}}" data-date-format="YYYY/MM/DD" type="date" required/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="Rab123">RAB<span
                        class="text-rose-500">*</span>
                    </label>
                    <input class="idRab form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="idRab" name="idRab" readonly hidden required>
                    <input class="Rab123 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="Rab123" name="Rab123" required readonly>
                    <input class="departs form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="departs" name="departs" required readonly hidden>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <div x-data="{ modalOpen: false }">
                        <button type="button"
                            class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white rabSelector"
                            @click.prevent="modalOpen = true" disabled>
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
                                @keydown.escape.window="modalOpen = false"
                                >
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Select
                                            RAB</div>
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
                                        <label class="flex flex-row text-xs">
                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3" for="department">Department :</p>
                                            <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                                                <option value="" selected>All</option>
                                                @foreach ($department as $dept)
                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="rabItem"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Period</th>
                                                    <th class="text-center">RAB #</th>
                                                    <th class="text-center">RAB Type</th>
                                                    <th class="text-center">RAB Title</th>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Department</th>
                                                    <th class="text-center">Budget</th>
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
                    @else
                    <div x-data="{ modalOpen: false }">
                        <button type="button"
                            class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white rabSelector"
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
                                @keydown.escape.window="modalOpen = false"
                                >
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Select
                                            RAB</div>
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
                                        <label class="flex flex-row text-xs">
                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3" for="department">Department :</p>
                                            <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                                                <option value="" selected>All</option>
                                                @foreach ($department as $dept)
                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="rabItem"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Period</th>
                                                    <th class="text-center">RAB #</th>
                                                    <th class="text-center">RAB Type</th>
                                                    <th class="text-center">RAB Title</th>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Department</th>
                                                    <th class="text-center">Budget</th>
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
                    @endif
                </div>
                <div class="flex flex-col md:flex-row mt-3" id="periodeRAB1">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="period1">RAB Period<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="period1" name="period1" class="period1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                </div>
                <div class="flex flex-col md:flex-row mt-3" id="periodeRAB" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="period">RAB Period<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="period" name="period" class="period form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                </div>
                <div class="flex md:flex-row mt-3">
                    <label class="block w-1/4 text-sm"></label>
                    <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white mr-5" id="changeRab" hidden>Change RAB</button>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="currency">Currency<span
                        class="text-rose-500">*</span></label>
                    <select id="currency" name="currency"
                        class="currency form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Currency</option>
                        @foreach ( $dataCurrency as $cur )
                        <option value="{{$cur->symbol}}">{{$cur->symbol}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="payment_by">Payment Source<span
                        class="text-rose-500">*</span></label>
                    <select id="payment_by" name="payment_by"
                        class="payment_by form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Payment</option>
                        <option value="HO">HO</option>
                        <option value="SITE">SITE</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="notes form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        rows="3"></textarea>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="vendor">Delivery To<span
                        class="text-rose-500">*</span></label>
                        <input id="id_warehouse" name="id_warehouse"
                        class="id_warehouse form-input w-full md:w-3/4 px-2 py-1" type="text" hidden required/>
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
                                            Delivery Address</div>
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
                                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                                    <div class="flex flex-row justify-start text-xs" hidden>
                                        <label class="flex flex-row text-xs">
                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="categoryFilter">Filter Company :</p>
                                            <select id="company2" name="company2"
                                                class="company2 flex flex-row ml-3 mb-3 text-xs" required>
                                                <option selected hidden value="">Select Company</option>
                                                @foreach ( $dataChildCompany as $company )
                                                    <option value="{{$company->id_company}}">{{$company->name}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    @else
                                    <select id="companyTest1" name="companyTest1"
                                        class="companyTest1 form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" disabled required hidden>
                                            <option value="{{$dataChildCompany->id_company}}" selected>{{$dataChildCompany->name}}</option>
                                    </select>
                                    <input id="company2" name="company2"
                                    class="company2 form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                    value="{{$dataChildCompany->id_company}}" readonly hidden/>
                                    @endif
                                    <div class="table-responsive">
                                        <table id="delivery-address" class="table table-striped table-bordered text-xs" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Address</th>
                                                    <th class="text-center">City</th>
                                                    <th class="text-center">Province</th>
                                                    <th class="text-center">Country</th>
                                                    <th class="text-center">Pos Code</th>
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
                <div class="flex justify-between flex-col md:flex-row mt-3" id="pic1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="pic">Delivery PIC<span
                        class="text-rose-500">*</span></label>
                    <input id="pic" name="pic"
                        class="pic form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="phone1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="phone">Delivery Phone Number<span
                        class="text-rose-500">*</span></label>
                    <input id="phone" name="phone"
                        class="phone form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="address1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="address">Delivery Address<span
                        class="text-rose-500">*</span></label>
                    <textarea id="address" name="address" class="address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        rows="3" readonly></textarea>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="city1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="city">Delivery City<span
                        class="text-rose-500">*</span></label>
                    <input id="city" name="city"
                        class="city form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="province1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="province">Delivery Province<span
                        class="text-rose-500">*</span></label>
                    <input id="province" name="province"
                        class="province form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="country1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="country">Delivery Country<span
                        class="text-rose-500">*</span></label>
                    <input id="country" name="country"
                        class="country form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="zip1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="zip_code">Delivery POS Code<span
                        class="text-rose-500">*</span></label>
                    <input id="zip_code" name="zip_code"
                        class="zip_code form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Add Purchase Detail<span
                    class="text-rose-500">*</span>
                    </label>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn btn-rab bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal1" disabled>
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
                            @click.outside="modalOpen = false"
                            @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add Purchase Detail</div>
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
                                            for="nama_product">Asset Name<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="nama_product" name="nama_product" style="width: 58.5rem;"
                                        class="nama_product form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required/>
                                        <div x-data="{ modalOpen: false }">
                                            <button type="button"
                                                class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click.prevent="modalOpen = true"
                                                aria-controls="feedback-modal">
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
                                            <div id="feedback-modal-content"
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
                                                            <div class="font-semibold text-slate-800">Select RAB Item</div>
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
                                                        <div class="flex justify-end">
                                                            <button class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3" id="selectAllRAB" @click="modalOpen = false" type="button">Add All Item</button>
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table id="assetInv"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">RAB #</th>
                                                                        <th class="text-center">Type</th>
                                                                        <th class="text-center">Department</th>
                                                                        <th class="text-center">Sub Department</th>
                                                                        <th class="text-center">Inventory Name</th>
                                                                        <th class="text-center">Qty</th>
                                                                        <th class="text-center">Unit</th>
                                                                        <th class="text-center">Price</th>
                                                                        <th class="text-center">Total</th>
                                                                        <th class="text-center">Balance</th>
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
                                        <input id="assetId" name="assetId"
                                            class="assetId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                        <input id="rabId" name="rabId"
                                            class="rabId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                        <input id="budget" name="budget"
                                            class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="order_quantity">Order Qty
                                        </label>
                                        <input id="order_quantity" name="order_quantity"
                                            class="order_quantity numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="unit">Unit<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="unit" name="unit"
                                            class="unit form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" maxlength="20" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="product_price">@Price
                                        </label>
                                        <input id="product_price" name="product_price"
                                            class="product_price numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="itemTotal1">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="itemTotal">Total
                                        </label>
                                        <input id="itemTotal" name="itemTotal"
                                            class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="remarks">Remarks
                                        </label>
                                        <input id="remarks" name="remarks"
                                            class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                            <button type="button"
                                                class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click="modalOpen = false" id="addProduct">Add Asset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div x-data="{ modalOpen: false }" id="modalForm">
                        <button class="ml-2 btn btn-rab bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal1" disabled>
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
                            @click.outside="modalOpen = false"
                            @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add Purchase Detail</div>
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
                                            for="nama_product">Asset Name<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="nama_product" name="nama_product" style="width: 58.5rem;"
                                        class="nama_product form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required/>
                                        <div x-data="{ modalOpen: false }">
                                            <button type="button"
                                                class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click.prevent="modalOpen = true"
                                                aria-controls="feedback-modal">
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
                                                            <div class="font-semibold text-slate-800">Select RAB Item</div>
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
                                                        <div class="flex justify-end">
                                                            <button class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3" id="selectAllRAB" @click="modalOpen = false" type="button">Add All Item</button> 
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table id="assetInv"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">RAB #</th>
                                                                        <th class="text-center">Type</th>
                                                                        <th class="text-center">Department</th>
                                                                        <th class="text-center">Sub Department</th>
                                                                        <th class="text-center">Inventory Name</th>
                                                                        <th class="text-center">Qty</th>
                                                                        <th class="text-center">Unit</th>
                                                                        <th class="text-center">Price</th>
                                                                        <th class="text-center">Total</th>
                                                                        <th class="text-center">Balance</th>
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
                                        <input id="assetId" name="assetId"
                                            class="assetId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                        <input id="rabId" name="rabId"
                                            class="rabId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                        <input id="budget" name="budget"
                                            class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="order_quantity">Order Qty
                                        </label>
                                        <input id="order_quantity" name="order_quantity"
                                            class="order_quantity numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="unit">Unit<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="unit" name="unit"
                                            class="unit form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" maxlength="20" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="product_price">@Price
                                        </label>
                                        <input id="product_price" name="product_price"
                                            class="product_price numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="itemTotal1">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="itemTotal">Total
                                        </label>
                                        <input id="itemTotal" name="itemTotal"
                                            class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="remarks">Remarks
                                        </label>
                                        <input id="remarks" name="remarks"
                                            class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                            <button type="button"
                                                class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click="modalOpen = false" id="addProduct">Add Asset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Quantity</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">@Price</th>
                                <th class="text-sm text-center">Total</th>
                                <th class="text-sm text-center">Remarks</th>
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="subtotal">Subtotal<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="subtotal" name="subtotal" type="text" class="subtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-16" required readonly/>
                    <input id="subtotal1" name="subtotal1" type="text" class="subtotal1 form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right" required readonly hidden/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="discount">Discount (IDR)<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="discount" name="discount" class="discount form-input md:w-1/4 px-2 py-1 ml-16" value="0" onchange="calculateDisc()" type="text" required/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="total">Total<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="total" name="total" type="text" class="total form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-16" required readonly/>
                    <input id="total1" name="total1" type="text" class="total1 form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right" required readonly hidden/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="ppn">PPN (IDR)<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="ppn" name="ppn" class="ppn form-input md:w-1/4 px-2 py-1 ml-16" value="0" onchange="calculateDisc()" type="text" required/>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/2 text-sm font-medium mb-1" for="grandtotal">Grand Total<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right flex justify-end" type="text" readonly required/>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="deliveryCharge">Delivery Charge (IDR)<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="deliveryCharge" name="deliveryCharge" class="deliveryCharge form-input md:w-1/4 px-2 py-1 ml-16" type="text" value="0" required/>
                </div>

                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create Purchase Request</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
    $('#approval_to').select2();
    $('#company1').on('change', function (e) {
        const site = $('#company1').val();
        if ($('#company1').val() !== null) {
            $('#company').val(site);
            $('#company2').val(site);
            $('#delivery-address').DataTable().ajax.reload();
            $('#rabItem').DataTable().ajax.reload();
        }
        $(".rabSelector").attr("disabled", false);
    })
    // $('#department').on('change', function (e) {
    //     const deptsName = $("#department option:selected").text();
    //     $('#rabItem').DataTable().ajax.reload();
    //     $("#department").attr("hidden", true);
    //     $("#deptSelected").val(deptsName);
    //     $("#deptSelected").attr("hidden", false);
    //     $("#clearDept").attr("hidden", false);
    // })
    $('#changeRab').on('click', function () {
        $(".rabSelector").attr("disabled", false);
        $("#changeRab").attr("hidden", true);
        $(".btn-rab").attr("disabled", true);
        $("#selectAllRAB").attr("disabled", false);
        $("#Rab123").val('');
        $("#period1").val('');

        // Clear the table rows and reset subtotal
        $('#tableProductAddBody').empty();
        productIdx = 0;
        subtotal = 0;
        $('#grandtotal').val(`${divider(subtotal)}`);
        $('#grandtotal1').val(subtotal);
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="4">Grand Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(subtotal)}</span></td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);
    });
$(document).ready(function () {
    $('#delivery-address').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,                
        "order": [[ 0, "asc" ]],
        language: {
            search: "Search Address:"
        },
        ajax: {
            url: "{{ route('delivery.address') }}",
            data:function(d){                    
                d.company2 = $("#company2").val()
            }
        },
        columns: [
            {
                data: "name",                    
                name: "name"
            },
            {                    
                data: "w_address",
                name: "w_address"
            },
            {
                data: "w_city",
                name: "w_city"
            },
            {
                data: "w_province",
                name: "w_province"
            },
            {
                data: "w_country",
                name: "w_country"
            },
            {
                data: "w_zipcode",
                name: "w_zipcode"
            },
            {
                data: "action",
                name: "action"
            },
        ],
        columnDefs: [
            { className: 'text-center', targets: [5, 6] }
        ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
    });
    // $('#vendor-table').DataTable({
    //     responsive: true,
    //                 processing: true,
    //                 serverSide: false,
    //                 stateServe: true,
    //                 "order": [[ 2, "asc" ]],
    //                 language: {
    //                     search: "Search Vendor:"
    //                 },
    //                 ajax: {
    //                     url: "{{ route('vendor.select') }}"
    //                 },
    //                 columns: [
    //                     {
    //                         data: "initials",
    //                         name: "initials"
    //                     },
    //                     {
    //                         data: "company_type",
    //                         name: "company_type"
    //                     },
    //                     {
    //                         data: "name",
    //                         name: "name"
    //                     },
    //                     {
    //                         data: "address",
    //                         name: "address"
    //                     },
    //                     {
    //                         data: "phone",
    //                         name: "phone"
    //                     },
    //                     {
    //                         data: "status",
    //                         name: "status"
    //                     },
    //                     {
    //                         data: "action",
    //                         name: "action"
    //                     },
    //                 ],
    //                 columnDefs: [
    //                     { className: 'text-center', targets: [0, 1, 4] },
    //                 ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
    // });
    $('#assetInv').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,
        "order": [[ 3, "asc" ]],
        language: {
            search: "Search: "
            },
        ajax: {
            url: "{{ route('purchase-list.selectrabdetail') }}",
            data:function(d){                    
                d.idRab = $("#idRab").val()
            }
        },
        columns: [
            {
                data: "id_rab",
                name: "id_rab"
            },
            {
                data: "rab_calc_type",
                name: "rab_calc_type"
            },
            {
                data: "category",
                name: "category"
            },
            {
                data: "sub_category",
                name: "sub_category"
            },
            {
                data: "name_rab_detail",
                name: "name_rab_detail"
            },
            {
                data: "qty",
                name: "qty"
            },
            {
                data: "unit",
                name: "unit"
            },
            {
                data: "amount",
                name: "amount"
            },
            {
                data: "total",
                name: "total"
            },
            {
                data: "balance",
                name: "balance"
            },
            {
                data: "action",
                name: "action"
            },
            ],
            columnDefs: [
                { className: 'text-right', targets: [5, 7, 8] },
                { className: 'text-center', targets: [0, 6, 9] }
            ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
    });
    $('#rabItem').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,
        "order": [[ 1, "desc" ]],
        language: {
        search: "Search RAB #:"
        },
        ajax: {
            url: "{{ route('purchase-list.selectrab') }}",
            data:function(d){
                d.company = $("#company").val()
                d.department = $("#department").val()
            }
        },
        columns: [
            {
                data: "date_rab",
                name: "date_rab"
            },
            {
                data: "id_rab",
                name: "id_rab"
            },
            {
                data: "rab_type",
                name: "rab_type"
            },
            {
                data: "name_rab",
                name: "name_rab"
            },
            {
                data: "name",
                name: "name"
            },
            {
                data: "deptName",
                name: "deptName"
            },
            {
                data: "gtotal",
                name: "gtotal"
            },
            {
                data: "action",
                name: "action"
            },
        ],
            columnDefs: [
            { className: 'text-center', targets: [0, 1, 7] },
            { className: 'text-right', targets: [6] },
        ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
    });
    $('#company').on('change', function (e) {
        $('#rabItem').DataTable().ajax.reload();
    })
    $('#department').on('change', function (e) {
        $('#rabItem').DataTable().ajax.reload();
    })
    // $('#pr_type').on('change', function (e) {
    //     $('#rabItem').DataTable().ajax.reload();
    // })
});
// $('#vendor-table').on("click", ".btn-select", function () {
//     const id = $(this).data("id_vendor");
//     const name = $(this).data("name_vendor");
//     const type = $(this).data("type");
//     const phone = $(this).data("phone");
//     var nama = type + ' ' + name + ' - ' + phone
                
//     $("#vendor").val(nama);
//     $("#vendor1").val(id);
// });

$('#assetInv').on("click", ".btn-select", function () {
    const idAsset = $(this).data("id_item");
    const nameAsset = $(this).data("nama");
    const budget = $(this).data("budget");
    const price = $(this).data("amount");
    const qty = $(this).data("qty");
    const total = $(this).data("total");
    const unit = $(this).data("unit");
    const rab = $(this).data("id");
                
    $("#assetId").val(idAsset);
    $("#rabId").val(rab);
    $("#nama_product").val(nameAsset);
    $('#product_price').val(newDivider1(price));
    $('#order_quantity').val(newDivider1(qty));
    $('#itemTotal').val(newDivider1(total));
    $("#budget").val(parseFloat(budget));
    $("#unit").val(unit);
});

$('#delivery-address').on("click", ".btn-select", function () {
    const id = $(this).data("id");
    const address = $(this).data("address");
    const city = $(this).data("city");
    const province = $(this).data("province");
    const country = $(this).data("country");
    const zip_code = $(this).data("zip_code");

    $("#id_warehouse").val(id);
    $("#address").val(address);
    $("#city").val(city);
    $("#province").val(province);
    $("#country").val(country);
    $("#zip_code").val(zip_code);

    $('#pic1').removeAttr('hidden');
    $('#phone1').removeAttr('hidden');
    $('#address1').removeAttr('hidden');
    $('#city1').removeAttr('hidden');
    $('#province1').removeAttr('hidden');
    $('#country1').removeAttr('hidden');
    $('#zip1').removeAttr('hidden');
});

$('#rabItem').on("click", ".btn-select", function () {
    const id = $(this).data("id");
    const title = $(this).data("title");
    const period = $(this).data("period");
    const division = $(this).data("division");
    const periodDate = new Date(period);

    // Dapatkan nama bulan dalam format 'F'
    const month = new Intl.DateTimeFormat('en-US', { month: 'long' }).format(periodDate);

    // Dapatkan tahun dalam format 'Y'
    const year = periodDate.getFullYear();

    var value = id + '-' + title + '-' + month + ' ' + year;
    var value12 = month + ' ' + year; 
                
    $("#period1").val(value12);
    $("#period").val(period);
    // $('#periodeRAB1').attr('hidden', false);
    // $('#periodeRAB').attr('hidden', true);
    $("#Rab123").val(value);
    $("#idRab").val(id);
    $("#departs").val(division);
    $('#assetInv').DataTable().ajax.reload();
    $(".btn-rab").attr("disabled", false);
    $(".rabSelector").attr("disabled", true);
    $("#changeRab").attr("hidden", false);
});

function calculateDisc() {
    let finalAmount = subtotal; // Pastikan variable 'subtotal' sudah didefinisikan dan memiliki nilai sebelumnya
    if ($('#discount').val()) {
        finalAmount = finalAmount - parseFloat($('#discount').val());
        $('#total').val(`${divider(finalAmount)}`);
        $('#total1').val(finalAmount);
        $('#grandtotal').val(`${divider(finalAmount)}`);
        $('#grandtotal1').val(finalAmount);
    }
    if ($('#ppn').val()) {
        finalAmount = finalAmount + parseFloat($('#ppn').val());
        $('#grandtotal').val(`${divider(finalAmount)}`);
        $('#grandtotal1').val(finalAmount);
    }
}

    // data product
    var usedBudgets = {};
    let subtotal = 0;
    function calculateGrandTotal() {
        var subtotal = 0;
        $('.tableProductAddBody tbody tr').each(function() {
            const totalas = parseFloat($(this).find('input[name^="rows"][name$="[totals]"]').val()) || 0;
            subtotal += totalas;
            console.log(subtotal);
        });
        $('#grandtotal').val(divider(Math.round(subtotal)));
        $('#grandtotal1').val(Math.round(subtotal));
        updateGrandTotal();
    }
    $(document).ready(function () {
        $('#order_quantity, #product_price').on('input', function() {
            calculateTotal();
        });

        function calculateTotal() {
            const qtyValue = $('#order_quantity').val().replace(/\./g, '').replace(/\,/g, '.');
            const priceValue = $('#product_price').val().replace(/\./g, '').replace(/\,/g, '.');

            if (qtyValue !== '' && priceValue !== '') {
                const qty = parseFloat(qtyValue);
                const price1 = parseFloat(priceValue);

                const totalss1 = qty * price1;
                const total1 = Math.round(totalss1);

                $('#itemTotal').val(divider(total1));
            } else {
                $('#itemTotal').val('0');
            }
        }

        $("#selectAllRAB").click(function () {
            var prods = [];
            // Get the DataTable instance
            var table = $('#assetInv').DataTable();
            $('[aria-controls="feedback-modal1"]').click();
            $(".btn-rab").attr("disabled", true);

            $(document).on('input', `[id^="qty_"], [id^="price_"]`, function (e) {
                const rowIdx = this.id.split('_')[1];
                calculatesTotal(rowIdx);
            });

            function calculatesTotal(rowIdx) {
                const qtysValue = $('#qty_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.');
                const pricesValue = $('#price_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.');

                if (qtysValue !== '' && pricesValue !== '') {
                    const qtys = parseFloat(qtysValue);
                    const prices = parseFloat(pricesValue);

                    const totalss = qtys * prices;
                    const totals = Math.round(totalss);

                    $('#itemTotal_' + rowIdx).val(divider(totals));
                } else {
                    $('#itemTotal_' + rowIdx).val('0');
                }
            }
            
            // Loop through each row in the DataTable
            table.rows().every(function (rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                var id_item = data.id_rab_item;
                var id_rab = data.id_rab;
                var name = data.name_rab_detail;
                var budget = data.balance.replace(/\./g, '').replace(/\,/g, '.');
                var price = data.amount;
                var price2 = data.amount.replace(/\./g, '').replace(/\,/g, '.');
                var oq = data.qty;
                var oq1 = data.qty.replace(/\./g, '').replace(/\,/g, '.');
                var unit = data.unit;  
                var remarks = '';
                var totalas = price2 * oq1;
                var total = Math.round(totalas);
                var budgetss = Math.round(budget);

                if (parseFloat(budget) === 0) {
                    return; // Skip adding this row if the budget is 0
                }

                if ($('#tableProductAddBody').find(`[name*="[ids]"][value="${id_item}"]`).length > 0) {
                    alert('Same Inventory Asset cannot be added again.');
                    return false;
                }
                
                subtotal += budgetss;
                            modal_content = `<div class="modal-content text-xs px-5 py-4">
                                                <input id="assetId_${rowIdx}" name="assetId"
                                                        class="assetId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${id_item}" readonly hidden/>
                                                    <input id="rabId_${rowIdx}" name="rabId"
                                                        class="rabId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${id_rab}" readonly hidden/>
                                                    <input id="budget_${rowIdx}" name="budget"
                                                        class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${budget}" readonly hidden/>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="order_quantity">Order Qty
                                                    </label>
                                                    <input id="qty_${rowIdx}" name="order_quantity"
                                                        class="order_quantity numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${oq}"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="unit">Unit<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <input id="unit_${rowIdx}" name="unit"
                                                        class="unit form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="20" value="${unit}" readonly/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="product_price">@Price
                                                    </label>
                                                    <input id="price_${rowIdx}" name="product_price"
                                                        class="product_price numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${price}"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3" id="itemTotal1">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Total
                                                    </label>
                                                    <input id="itemTotal_${rowIdx}" name="itemTotal"
                                                        class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${divider(budget)}" readonly/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="remarks">Remarks
                                                    </label>
                                                    <input id="remarks_${rowIdx}" name="remarks"
                                                        class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="${remarks}"
                                                        type="text"/>
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
                                            </div>`
                prods.push({rowIdx, id_item, id_rab, name, price, price2, oq, oq1, unit, remarks, budget, total, modal_content});
                var tr = `<tr id="row-${rowIdx}">
                            <td class="text-left">${name}<input name="rows1[${rowIdx}][ids]" value="${id_item}" hidden/><textarea name="rows1[${rowIdx}][namesis]" hidden>${name}</textarea></td>
                            <td class="text-right"><span id="qtys-text_${rowIdx}">${allinDivider(oq1)}</span><input id="qtys_${rowIdx}" name="rows1[${rowIdx}][qtys]" value="${oq1}" hidden/></td>
                            <td class="text-center"><textarea name="rows1[${rowIdx}][units]" hidden>${unit}</textarea><span id="units-text_${rowIdx}">${unit}</span></td>
                            <td class="text-right"><span id="prices-text_${rowIdx}">${allinDivider(price2)}</span><input id="prices_${rowIdx}" name="rows1[${rowIdx}][prices]" value="${price2}" hidden/><input name="rows1[${rowIdx}][rowIdx]" value="${newDivider2(budget)}" hidden/></td>
                            <td class="text-right"><span id="totals-text_${rowIdx}">${divider(budget)}</span><input id="totals_${rowIdx}" name="rows1[${rowIdx}][totals]" value="${budget}" hidden/></td>
                            <td class="text-left"><span id="remarkss-text_${rowIdx}">${remarks}</span><textarea id="remarkss_${rowIdx}" name="rows1[${rowIdx}][remarkss]" hidden>${remarks}</textarea></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${rowIdx}, ${total}, '${id_rab}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button>
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
                                                <div class="font-semibold text-slate-800">Adjust Purchase Detail</div>
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
                                        `+ prods.find(prod => prod.rowIdx == rowIdx).modal_content +`
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>`;
                
                $("#tableProductAddBody").append(tr);
            });

            $('#assetId').val('');
            $('#nama_product').val('');
            $('#unit').val('');
            $('#product_price').val('0');
            $('#order_quantity').val('0');
            $('#itemTotal').val('0');
            $('#remarks').val('');
            $('#grandtotal').val(divider(parseFloat(subtotal)));
            $('#grandtotal1').val(parseFloat(subtotal));
            $('#budget').val(``);
            updateGrandTotal();

            calculateDisc();

            var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
            grandTotalRow.detach();
            $("#tableProductAddBody").append(grandTotalRow);
        });

        $("#addProduct").click(function () {
            var prods = [];
            let productIdx = $('#tableProductAddBody tr').length-1;
            var id = $('#assetId').val();
            var id_rab = $('#rabId').val();
            var name = $('#nama_product').val();
            var budget = $("#budget").val();
            var price = $('#product_price').val();
            var price2 = $('#product_price').val().replace(/\./g, '').replace(/\,/g, '.');
            var oq = $('#order_quantity').val();
            var oq1 = $('#order_quantity').val().replace(/\./g, '').replace(/\,/g, '.');
            var unit = $('#unit').val();
            var remarks = $('#remarks').val();
            var totalas = price2 * oq1;
            var total = Math.round(totalas);

            if (!usedBudgets[id_rab]) {
                usedBudgets[id_rab] = {};
            } 
            if (!usedBudgets[id_rab][id]) {
                usedBudgets[id_rab][id] = 0;
            } 

            var remainingBudget = $('#budget').val() - usedBudgets[id_rab][id];

            if (total > remainingBudget) {
                alert('Over Budget canot added.');
                return false;
            }

            console.log($('#tableProductAddBody').find(`[name*="[ids]"][value="${id}"]`));
                // Check if the product with the same id already exists for Inventory type
                if ($('#tableProductAddBody').find(`[name*="[ids]"][value="${id}"]`).length > 0) {
                    alert('Same Inventory Asset cannot be added again.');
                    return false;
                }

            if (name === '' || price2 === '0' || price2 === '' || oq1 === '0' || oq1 === '') {
                return false;
            }
            // usedBudgets[id_rab][id] += total;
            subtotal += total;
                $(document).on('input', `[id^="qty_"], [id^="price_"]`, function (e) {
                    const productIdx = this.id.split('_')[1];
                    calculatesTotal(productIdx);
                });

                function calculatesTotal(productIdx) {
                    const qtysValue = $('#qty_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.');
                    const pricesValue = $('#price_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.');

                    if (qtysValue !== '' && pricesValue !== '') {
                        const qtys = parseFloat(qtysValue);
                        const prices = parseFloat(pricesValue);

                        const totalss = qtys * prices;
                        const totals = Math.round(totalss);

                        $('#itemTotal_' + productIdx).val(divider(totals));
                    } else {
                        $('#itemTotal_' + productIdx).val('0');
                    }
                }
                modal_content = `<div class="modal-content text-xs px-5 py-4">
                                                <input id="assetId_${productIdx}" name="assetId"
                                                        class="assetId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${id}" readonly hidden/>
                                                    <input id="rabId_${productIdx}" name="rabId"
                                                        class="rabId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${id_rab}" readonly hidden/>
                                                    <input id="budget_${productIdx}" name="budget"
                                                        class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${budget}" readonly hidden/>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="order_quantity">Order Qty
                                                    </label>
                                                    <input id="qty_${productIdx}" name="order_quantity"
                                                        class="order_quantity numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${oq}"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="unit">Unit<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <input id="unit_${productIdx}" name="unit"
                                                        class="unit form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="20" value="${unit}" readonly/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="product_price">@Price
                                                    </label>
                                                    <input id="price_${productIdx}" name="product_price"
                                                        class="product_price numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${price}"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3" id="itemTotal1">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Total
                                                    </label>
                                                    <input id="itemTotal_${productIdx}" name="itemTotal"
                                                        class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${divider(total)}" readonly/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="remarks">Remarks
                                                    </label>
                                                    <input id="remarks_${productIdx}" name="remarks"
                                                        class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="${remarks}"
                                                        type="text"/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct('${productIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>`
                prods.push({productIdx, id, id_rab, name, price, price2, oq, oq1, unit, remarks, total, modal_content});
                var tr = `<tr id="row-${productIdx}">
                            <td class="text-left">${name}<input name="rows[${productIdx}][ids]" value="${id}" hidden/><textarea name="rows[${productIdx}][namesis]" hidden>${name}</textarea></td>
                            <td class="text-right"><span id="qtys-text_${productIdx}">${allinDivider(oq1)}</span><input id="qtys_${productIdx}" name="rows[${productIdx}][qtys]" value="${oq1}" hidden/></td>
                            <td class="text-center"><span id="units-text_${productIdx}">${unit}</span><textarea id="units_${productIdx}" name="rows[${productIdx}][units]" hidden>${unit}</textarea></td>
                            <td class="text-right"><span id="prices-text_${productIdx}">${allinDivider(price2)}</span><input id="prices_${productIdx}" name="rows[${productIdx}][prices]" value="${price2}" hidden/><input name="rows[${productIdx}][budgets]" value="${budget}" hidden/></td>
                            <td class="text-right"><span id="totals-text_${productIdx}">${allinDivider(total)}</span><input id="totals_${productIdx}" name="rows[${productIdx}][totals]" value="${total}" hidden/></td>
                            <td class="text-left"><span id="remarkss-text_${productIdx}">${remarks}</span><textarea id="remarkss_${productIdx}" name="rows[${productIdx}][remarkss]" hidden>${remarks}</textarea></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${productIdx}, ${total}, '${id_rab}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button>
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
                                                <div class="font-semibold text-slate-800">Adjust Purchase Detail</div>
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

            $("#tableProductAddBody").append(tr);

            $('#assetId').val('');
            $('#nama_product').val('');
            $('#unit').val('');
            $('#product_price').val('0');
            $('#order_quantity').val('0');
            $('#itemTotal').val('0');
            $('#remarks').val('');
            $('#grandtotal').val(divider(parseFloat(subtotal)));
            $('#grandtotal1').val(parseFloat(subtotal));
            $('#budget').val(``);
            $("#selectAllRAB").attr("disabled", true);
            updateGrandTotal();

            calculateDisc();

            var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
            grandTotalRow.detach();
            $("#tableProductAddBody").append(grandTotalRow);
        });
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="4">Grand Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(subtotal)}</span></td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);
    });

    function updateDataProduct(rowIdx) {
        var remarks = $('#remarks_'+rowIdx).val();
        var remarksTextarea = $(`#row-${rowIdx}`).find(`textarea[name="rows[${rowIdx}][remarkss]"]`);
        // Update the textarea value in the current row
        remarksTextarea.val(remarks);
        $('#remarkss-text_'+rowIdx).text(remarks);
            
        var budgeet = parseFloat($('#budget_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var qty = parseFloat($('#qty_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var price = parseFloat($('#price_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var itemTotal = parseFloat($('#itemTotal_' + rowIdx).val()) || 0;
        var tots = price * qty;
        var newTotal = Math.round(tots);

        if (newTotal > budgeet) {
            alert('Over Budget canot update.');
            return false;
        }

        // Mengupdate nilai total pada input tersembunyi
        $('#totals_' + rowIdx).val(newTotal);

        // Memanggil fungsi untuk menghitung ulang grandTotal dan memperbarui tampilan
        calculateGrandTotal();
        updateGrandTotal();

        // Memperbarui nilai lain yang perlu diperbarui
        $('#qtys_' + rowIdx).val(qty);
        $('#qtys-text_' + rowIdx).text(allinDivider(qty));
        $('#prices_' + rowIdx).val(price);
        $('#prices-text_' + rowIdx).text(allinDivider(price));
        $('#totals-text_' + rowIdx).text(newDivider1(newTotal));
        // $('#grandtotal').val(newDivider1(subtotal));
        // $('#grandtotal1').val(subtotal);

        console.log(rowIdx, qty, price, subtotal, newTotal);
    }
    
    function updateDataProduct(productIdx) {
        var remarks = $('#remarks_'+productIdx).val();
        var remarksTextarea = $(`#row-${productIdx}`).find(`textarea[name="rows[${productIdx}][remarkss]"]`);
        // Update the textarea value in the current row
        remarksTextarea.val(remarks);
        $('#remarkss-text_'+productIdx).text(remarks);
            
        var budgeet = parseFloat($('#budget_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var qty = parseFloat($('#qty_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var price = parseFloat($('#price_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var itemTotal = parseFloat($('#itemTotal_' + productIdx).val()) || 0;
        var tots = price * qty;
        var newTotal = Math.round(tots);

        if (newTotal > budgeet) {
            alert('Over Budget canot update.');
            return false;
        }

        // Mengupdate nilai total pada input tersembunyi
        $('#totals_' + productIdx).val(newTotal);

        // Memanggil fungsi untuk menghitung ulang grandTotal dan memperbarui tampilan
        calculateGrandTotal();
        updateGrandTotal();

        // Memperbarui nilai lain yang perlu diperbarui
        $('#qtys_' + productIdx).val(qty);
        $('#qtys-text_' + productIdx).text(allinDivider(qty));
        $('#prices_' + productIdx).val(price);
        $('#prices-text_' + productIdx).text(allinDivider(price));
        $('#totals-text_' + productIdx).text(newDivider1(newTotal));
        // $('#grandtotal').val(newDivider1(subtotal));
        // $('#grandtotal1').val(subtotal);

        console.log(productIdx, qty, price, subtotal, newTotal);
    }
        function updateGrandTotal() {
            var subtotal = 0;
            $('.tableProductAddBody tbody tr').each(function() {
                const totalas = parseFloat($(this).find('input[name^="rows"][name$="[totals]"]').val()) || 0;
                subtotal += totalas;
                console.log(subtotal);
            });
            $('#grandtotal').val(divider(Math.round(subtotal)));
            $('#grandtotal1').val(Math.round(subtotal));
            
            $('#grandTotal_text').text(`${divider(Math.round(subtotal))}`);
            $('#grandTotal_text').val(`${divider(Math.round(subtotal))}`);
        }

        function moveRowUp(positionTableRow) {
            const $currentRow = $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`);
            const $previousRow = $(`#tableProductAddBody tr[id="row-${positionTableRow - 1}"]`);

            $currentRow.insertBefore($previousRow);
            // Update the productIdx attribute in the rows
            updateProductIdxAttributes();
        }

        // Function to move row down
        function moveRowDown(positionTableRow) {
            const $currentRow = $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`);
            const $nextRow = $(`#tableProductAddBody tr[id="row-${positionTableRow + 1}"]`);

            if ($nextRow.hasClass('grandTotalRow')) {
                // Jangan izinkan pemindahan jika baris berikutnya adalah grandTotalRow
                return;
            }

            $currentRow.insertAfter($nextRow);
            // Update the productIdx attribute in the rows
            updateProductIdxAttributes();
        }

        // Event listener for arrow-up button click
        $('#tableProductAddBody').one('click', '.icon-tabler-arrow-up', function () {
            const positionTableRow = $(this).closest('tr').index();
            if (positionTableRow > 0) {
                moveRowUp(positionTableRow);
            }
        });

        $('#tableProductAddBody').one('click', '.icon-tabler-arrow-down', function () {
            const positionTableRow = $(this).closest('tr').index();
            const rowCount = $('#tableProductAddBody tr').length;
            // Periksa apakah baris yang dipilih adalah baris sebelum grandTotalRow
            if (positionTableRow < rowCount - 2) { // Kurangi 2 karena grandTotalRow ada di posisi rowCount - 1
                moveRowDown(positionTableRow);
            }
        });
    
    function deleteDataProduct(positionTableRow, total, id_rab) {
        const positionTableRowVariable = positionTableRow
        const id_rab_deleted = id_rab;
        subtotal -= total;
        $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();
        if (usedBudgets[id_rab_deleted]) {
            usedBudgets[id_rab_deleted] -= total;
        }
        // $('#subtotal').val(`${divider(subtotal)}`);
        $('#grandtotal').val(`${divider(subtotal)}`);
        $('#grandtotal1').val(`${subtotal}`);
        // $('#subtotal1').val(`${subtotal}`);
        if ($("#tableProductAddBody tr[id^='row-']").length === 0) {
            $(".btn-rab").attr("disabled", false);
            $("#selectAllRAB").attr("disabled", false);
        }
        updateGrandTotal();

        var remainingBudget = $('#budget').val() - usedBudgets[id_rab_deleted];
        var status = "";

        if (total > remainingBudget) {
            status = '<div class="flex flex-row mt-2 justify-center"><div class="rounded-full bg-red-500 columns-1 h-5 w-5"></div></div>';
        } else if (total <= remainingBudget) {
            status = '<div class="flex flex-row mt-2 justify-center"><div class="rounded-full bg-green-700 columns-1 h-5 w-5"></div></div>';
        } else if (isNaN(remainingBudget)) {
            status = '<label class="text-left">No Budget</label>';
        }

        // Memperbarui status budget pada baris yang sesuai
        $(`#tableProductAddBody tr[id="row-${positionTableRow}"] .text-center:eq(1)`).html(status);
    }

    function updateProductIdxAttributes() {
        $('#tableProductAddBody tr').each(function (index, element) {
            const newIndex = index;

            // Update attributes
            $(element).attr('id', `row-${newIndex}`);
            $(element).find('.icon-tabler-arrow-up').attr('onclick', `moveRowUp(${newIndex})`);
            $(element).find('.icon-tabler-arrow-down').attr('onclick', `moveRowDown(${newIndex})`);
            $(element).find('[onclick^="deleteDataProduct"]').attr('onclick', `deleteDataProduct(${newIndex}, ${$(element).find('[name*="[totals]"]').val()})`);

            // Find and update all input fields with dynamic names
            $(element).find('input, textarea').each(function () {
                const oldName = $(this).attr('name');
                const newName = oldName.replace(/rows\[\d+\]/, `rows[${newIndex}]`);
                $(this).attr('name', newName);
            });
        });
    }

    document.getElementById('form_create1').addEventListener('submit', function(event) {
        // Check if the form is valid
        if (!this.checkValidity()) {
            event.preventDefault(); // Stop the form submission if not valid
            return;
        }

        // Disable the submit button to prevent double clicks
        document.getElementById('create_offer').disabled = true;
        
        // Optionally, change the button text to indicate it's processing
        document.getElementById('create_offer').innerHTML = "Processing...";
    });

</script>
@endsection
</x-app-layout>