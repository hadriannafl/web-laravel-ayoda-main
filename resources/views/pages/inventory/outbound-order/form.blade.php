<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Outbound Inventory Form 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('outbound-inventory.create') }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1" for="formDate">Date Outbound<span
                        class="text-rose-500">*</span></label>
                    <input id="formDate" name="formDate" value="{{date('Y-m-d')}}"
                        class="formDate selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1"
                        for="company">Company<span
                        class="text-rose-500">*</span>
                    </label>
                        <select id="company" name="company"
                            class="company form-select w-full md:w-3/4 px-2 py-1" required>
                            <option selected hidden value="">Select Company </option>
                            @foreach ( $dataChildCompany as $company )
                                <option value="{{$company->id_company}}">{{$company->name}}</option>
                            @endforeach
                        </select>
                        <input id="companyTest" name="companyTest"
                            class="companyTest form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" hidden readonly/>
                </div>
                <div class="flex md:flex-row mt-3">
                    <label class="block w-1/4 text-sm"></label>
                    <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white mr-5" id="clearCompany" hidden>Change Company</button>
                </div>
                @else
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1"
                        for="company">Company<span
                        class="text-rose-500">*</span>
                    </label>
                        <select id="companyTest" name="companyTest"
                            class="companyTest form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" disabled required>
                                <option value="{{$fixCompany->id_company}}" selected>{{$fixCompany->name}}</option>
                        </select>
                        <input id="company" name="company"
                        class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$fixCompany->id_company}}" readonly hidden/>
                </div>
                @endif
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="vendor">Select Warehouse<span
                        class="text-rose-500">*</span></label>
                    <input id="wid" name="wid"
                    class="wid form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                    type="text" readonly required hidden/>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <div x-data="{ modalOpen: false }">
                        <button type="button"
                            class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                            @click.prevent="modalOpen = true" id="btn-warehouse" style="margin-left: 5.2rem;" disabled>
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
                                            Warehouse Address</div>
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
                                        <table id="warehouseTable" class="table table-striped table-bordered text-xs" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Warehouse</th>
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
                    @else
                    <div x-data="{ modalOpen: false }">
                        <button type="button"
                            class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                            @click.prevent="modalOpen = true" id="btn-warehouse" style="margin-left: 5.2rem;">
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
                                            Warehouse Address</div>
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
                                        <table id="warehouseTable" class="table table-striped table-bordered text-xs" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Warehouse</th>
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
                    @endif
                </div>
                <div id="wdress" hidden>
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Warehouse Name / Address / City</label>
                            <div style="width: 20.8rem; margin-right: 20px;">
                                <input id="wname" name="wname" class="wname form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                            </div>
                            <div style="width: 20.8rem; margin-right: 20px;">
                                <textarea id="address" name="address" class="address form-input w-full px-2 py-1 read-only:bg-slate-200" rows="3" readonly></textarea>
                            </div>
                            <div>
                                <input id="city" style="width: 21.2rem;" name="city" class="city form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                            </div>
                    </div>
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Warehouse Province / Country / POS Code</label>
                            <div style="width: 20.8rem; margin-right: 20px;">
                                <input id="province" name="province" class="province form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                            </div>
                            <div style="width: 20.8rem; margin-right: 20px;">
                                <input id="country" name="country" class="country form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                            </div>
                            <div>
                                <input id="zip_code" style="width: 21.2rem;" name="zip_code" class="zip_code form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                            </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="employee1">User Request<span
                        class="text-rose-500">*</span>
                    </label>
                    <input class="employee form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="employee" name="employee" hidden readonly/>
                    <input class="employee1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="employee1" name="employee1" readonly/>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <div x-data="{ modalOpen: false }">
                        <button type="button" id="employees-button" disabled
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
                    @else
                        <div x-data="{ modalOpen: false }">
                            <button type="button" id="employees-button"
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
                    @endif
                </div>
                <div id="detail_employee" hidden>
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Department / Position<span
                            class="text-rose-500">*</span></label>
                            <div style="width: 31rem; margin-right: 41px;">
                                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                                <input id="userCompany" name="userCompany"
                                class="userCompany form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="1" hidden readonly/>
                                @else
                                <input id="userCompany" name="userCompany"
                                class="userCompany form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="{{Auth::user()->company_id}}" hidden readonly/>
                                @endif
                                <input id="department1" name="department1" class="department1 form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                            </div>
                            <div>
                                <input id="division" style="width: 31.7rem;" name="division" class="division form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                            </div>
                    </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="reff">Reff Delivery #<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="reff" name="reff" class="reff form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="courier_name">Courier Name<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="courier_name" name="courier_name" class="courier_name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="employee1">Vehicle #<span
                        class="text-rose-500">*</span>
                    </label>
                    <input class="vehicle form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="vehicle" name="vehicle" readonly/>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <div x-data="{ modalOpen: false }">
                        <button type="button" id="vehicles-button" disabled
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
                                            Vehicle</div>
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
                                    <label class="flex flex-row">
                                        <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3" for="vehicle_type">Vehicle Type :</p>
                                        <select id="vehicle_type" class="vehicle_type flex flex-row mb-3 text-xs" style="width: 10rem" name="vehicle_type">
                                            <option value="" selected hidden>Select Vehicle</option>
                                            <option value="Car">Car</option>
                                            <option value="Dump Truk">Dump Truk</option>
                                            <option value="Light Vehicle">Light Vehicle</option>
                                            <option value="Motorcycle">Motorcycle</option>
                                            <option value="Tug Boat">Tug Boat</option>
                                        </select>
                                    </label>
                                    <div class="table-responsive">
                                        <table id="vehicles" class="table table-striped table-bordered text-xs" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Vehicle Type</th>
                                                    <th class="text-center">Vehicle Number</th>
                                                    <th class="text-center">Engine Number</th>
                                                    <th class="text-center">Frame Number</th>
                                                    <th class="text-center">Active Date</th>
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
                            <button type="button" id="employees-button"
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
                                        <label class="flex flex-row">
                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3" for="vehicle_type">Vehicle Type :</p>
                                            <select id="vehicle_type" class="vehicle_type flex flex-row mb-3 text-xs" style="width: 10rem" name="vehicle_type">
                                                <option value="" selected hidden>Select Vehicle</option>
                                                <option value="Car">Car</option>
                                                <option value="Dump Truk">Dump Truk</option>
                                                <option value="Light Vehicle">Light Vehicle</option>
                                                <option value="Motorcycle">Motorcycle</option>
                                                <option value="Tug Boat">Tug Boat</option>
                                            </select>
                                        </label>
                                        <div class="table-responsive">
                                            <table id="vehicles" class="table table-striped table-bordered text-xs" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Company</th>
                                                        <th class="text-center">Vehicle Type</th>
                                                        <th class="text-center">Vehicle Number</th>
                                                        <th class="text-center">Engine Number</th>
                                                        <th class="text-center">Frame Number</th>
                                                        <th class="text-center">Active Date</th>
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
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="notes form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        rows="3"></textarea>
                </div>
                <div class="flex flex-col md:flex-row mb-3 mt-3">
                    <label class="text-sm font-medium mb-1" for="task_id">Add Outbound Inventory<span
                    class="text-rose-500">*</span>
                    </label>
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn btn-rab bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
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
                                        <div class="font-semibold text-slate-800">Add Inventory Outbound</div>
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
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="nama_product">Inventory Name<span class="text-rose-500">*</span></label>
                                        <input id="nama_product" name="nama_product"
                                        class="nama_product form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required/>
                                        <div x-data="{ modalOpen: false }">
                                            <button type="button"
                                                class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click.prevent="modalOpen = true" id="rabSelection"
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
                                                            <div class="font-semibold text-slate-800 text-sm">Select Inventory</div>
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
                                                        <div class="flex flex-row text-xs mb-3">
                                                            <label class="flex flex-row text-xs">
                                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="department">Department :</p>
                                                            <select id="department" name="department" class="department flex flex-row ml-3 mb-3 text-xs">
                                                                <option selected value="">All</option>
                                                                @foreach ( $department as $depts )
                                                                    <option value="{{$depts->id}}">{{$depts->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table id="assetInv"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Department</th>
                                                                        <th class="text-center">Sub Department</th>
                                                                        <th class="text-center">Inventory Name</th>
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
                                        <input id="rabItemId" name="rabItemId"
                                            class="rabItemId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" hidden readonly required/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="quantitys">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="qty">Qty<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="qty" name="qty"
                                            class="qty numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="units">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="unit">Unit<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="unit" name="unit"
                                            class="unit form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" maxlength="20" readonly/>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                            <button type="button"
                                                class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click="modalOpen = false" id="addProduct">Add Outbound Item</button>
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
                                <th class="text-sm text-center">Inventory Code</th>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Qty</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="totalAmount">Grand Total</label>
                    <label class="text-sm font-medium mb-1 ml-32">:</label>
                    <label class="w-36 text-sm font-medium mb-1 text-white" for="discount2idr">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 text-right" type="text" readonly required/>
                    <label class="md:w-1/12 text-sm font-medium text-white"></label>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required hidden/>
                </div>
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Submit Outbound Inventory</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script> 
$('#department').on('change', function (e) {
    $('#assetInv').DataTable().ajax.reload();
})
$('#clearCompany').on('click', function () {
    $("#company").attr("hidden", false);
    $("#companyTest").attr("hidden", true);
    $("#companyTest").val('');
    $("#vehicle").val('');

    $('#btn-warehouse').attr('disabled', true);
    $('#employees-button').attr('disabled', true);
    $('#vehicles-button').attr('disabled', true);

    $('#detail_employee').attr('hidden', true);
    $("#employee").val('');
    $("#employee1").val('');
    $("#department1").val('');
    $("#division").val('');
    $("#department1").attr("readonly", true);
    $("#division").attr("readonly", true);

    $("#wid").val('');
    $("#wname").val('');
    $("#address").val('');
    $("#city").val('');
    $("#province").val('');
    $("#country").val('');
    $("#zip_code").val('');

    $('#wdress').attr('hidden', true);
    $("#clearCompany").attr("hidden", true);
});
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
                    d.company = $("#company").val()
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
    $('#warehouseTable').DataTable({
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
                d.company = $("#company").val()
            }
        },
        columns: [
            {
                data: "name",                    
                name: "name"
            },
            {                    
                data: "w_name",
                name: "w_name"
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
            { className: 'text-center', targets: [6, 7] }
        ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
    });
    $('#company').on('change', function (e) {
        const compName = $("#company option:selected").text();
        $("#company").attr("hidden", true);
        $("#clearCompany").attr("hidden", false);
        $("#companyTest").attr("hidden", false);
        $("#companyTest").val(compName);
        $('#employee-table').DataTable().ajax.reload();
        $('#warehouseTable').DataTable().ajax.reload();
        $('#vehicles').DataTable().ajax.reload();
        $('#btn-warehouse').attr('disabled', false);
        $('#employees-button').attr('disabled', false);
        $('#vehicles-button').attr('disabled', false);
    })
    $('#employee-table').on("click", ".btn-select", function () {
        const id = $(this).data("id");
        const name = $(this).data("nama");
        const company = $(this).data("company");
        const company_name = $(this).data("company_name");
        const department1 = $(this).data("department");
        const position = $(this).data("position");
                        
        $('#detail_employee').removeAttr('hidden');
        $("#employee").val(id);
        $("#employee1").val(name);
        $("#department1").val(department1);
        $("#division").val(position);
        $("#department1").attr("readonly", true);
        $("#division").attr("readonly", true);
    });
    $('#warehouseTable').on("click", ".btn-select", function () {
        const id = $(this).data("id");
        const address = $(this).data("address");
        const city = $(this).data("city");
        const province = $(this).data("province");
        const country = $(this).data("country");
        const zip_code = $(this).data("zip_code");
        const wname = $(this).data("wname");

        $("#wid").val(id);
        $("#wname").val(wname);
        $("#address").val(address);
        $("#city").val(city);
        $("#province").val(province);
        $("#country").val(country);
        $("#zip_code").val(zip_code);

        $('#wdress').removeAttr('hidden');
    });
    $('#assetInv').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,
        "order": [[ 0, "asc" ], [ 1, "asc" ], [ 2, "asc" ]],
        ajax: {
            url: "{{ route('purchase.invasset') }}",
            data:function(d){
                d.department = $("#department").val()
            }
        },
        columns: [
            {
                data: "category",
                name: "category"
            },
            {
                data: "sub_category",
                name: "sub_category"
            },
            {
                data: "name",
                name: "name"
            },
            {
                data: "action",
                name: "action"
            },
            ],
            columnDefs: [
                { className: 'text-center', targets: [3] }
            ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
    });
    $('#vehicles').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,
        language: {
            search: "Search:"
        },
        ajax: {
            url: "{{ route('vehicle.getdata') }}",
            data:function(d){
                d.company = $("#company").val()
                d.vehicle_type = $("#vehicle_type").val()
            }
        },
        columns: [
            {
                data: "name",
                name: "name"
            },
            {
                data: "vehicle_type",
                name: "vehicle_type"
            },
            {
                data: "vehicle_number",
                name: "vehicle_number"
            },
            {
                data: "engine_number",
                name: "engine_number"
            },
            {
                data: "frame_number",
                name: "frame_number"
            },
            {
                data: "active_date",
                name: "active_date"
            },
            {
                data: "action2",
                name: "action2"
            }
        ],
        columnDefs: [
            { className: 'text-center', targets: [2, 3, 4, 5] },
            ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
        });
        $(".vehicle_type").on('change', function (e) {
            e.preventDefault();
            $('#vehicles').DataTable().ajax.reload();
        })
        $('#vehicles').on("click", ".btn-select", function () {
            const vehicle_number = $(this).data("vehicle_number");

            $("#vehicle").val(vehicle_number);
        });
});

$('#assetInv').on("click", ".btn-select", function () {
    const idAsset = $(this).data("id");
    const nameAsset = $(this).data("nama");
    const category = $(this).data("category");
    const sub_category = $(this).data("sub_category");
    const unitssss = $(this).data("unit");

    $("#rabItemId").val(idAsset);
    $("#nama_product").val(nameAsset);
    $("#unit").val(unitssss);
});
    // data product
    let productIdx = 0;
    let subtotal = 0;
    $(document).ready(function () {
        $("#addProduct").click(function () {
            var id = $('#rabItemId').val();
            var name = $('#nama_product').val();
            var unit = $('#unit').val();
            var qty = $('#qty').val();
            var qty2 = $('#qty').val().replace(/\./g, '').replace(/\,/g, '.');
            var total = parseFloat(qty2);

            // Check if the product with the same id already exists for Inventory type
            if ($('#tableProductAddBody').find(`[name*="[ids]"][value="${id}"]`).length > 0) {
                alert('Same Inventory Asset cannot be added again.');
                return false;
            }

            if (name === '' || qty2 === '' || !unit || !name || !qty2) {
                alert('Data Inventory Outbound Must Fill.');
                return false;
            }
                // Update subtotal
                subtotal += total;
                    var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                    "  <td class=\"text-left\">" + id + "<input type=\"hidden\" name = \"rows[" + productIdx + "][ids]\"value =" + id + "></td>\n" +
                    "  <td class=\"text-left\">" + name + "<textarea name = \"rows[" + productIdx + "][namesis]\" hidden>" + name + "</textarea></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(qty)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][qtys]\" value =" + qty2 + "></td>\n" +
                    "  <td class=\"text-center\">" + unit + "<textarea name = \"rows[" + productIdx + "][units]\" hidden>" + unit + "</textarea></td>\n" +
                    "  <td class=\"text-center flex flex-row justify-center\">" +
                    "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + total + "," + null + ")\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" ><svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg></button></td>\n" +
                    "</tr>";   

                $("#tableProductAddBody").append(tr);

                $('#rabItemId').val('');
                $('#nama_product').val('');
                $('#unit').val('');
                $('#qty').val('');
                $('#grandtotal').val(`${divider(subtotal)}`);
                $('#grandtotal1').val(subtotal);
                updateGrandTotal();

                productIdx++;
                var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
                grandTotalRow.detach();
                $("#tableProductAddBody").append(grandTotalRow);
        });
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="2">Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(subtotal)}</span></td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);
    });
    function updateGrandTotal() {
        $('#grandTotal_text').text(`${divider(subtotal)}`);
        $('#grandTotal_text').val(`${divider(subtotal)}`);
    }
    function deleteDataProduct(positionTableRow, total) {
        subtotal -= total;

        $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();

        // Update the grand total
        $('#grandtotal').val(`${divider(subtotal)}`);
        $('#grandtotal1').val(subtotal);
        updateGrandTotal();

        console.info('positionTableRow: ', positionTableRow);
    }
</script>
@endsection
</x-app-layout>