<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New M. Input Fixed Asset 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('fixedasset.create') }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Form Date :<span
                        class="text-rose-500">*</span></label>
                    <input id="date" name="date"
                    class="date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                    Value="{{date('Y-m-d')}}" required/>
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
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="vendor">Select Warehouse<span
                        class="text-rose-500">*</span></label>
                    <input id="wid" name="wid"
                    class="wid form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                    type="text" readonly required hidden/>
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
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="wname1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="address">Warehouse Name<span
                        class="text-rose-500">*</span></label>
                    <input id="wname" name="wname"
                        class="wname form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" readonly required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="address1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="address">Warehouse Address<span
                        class="text-rose-500">*</span></label>
                    <textarea id="address" name="address" class="address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        rows="3" readonly></textarea>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="city1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="city">Warehouse City<span
                        class="text-rose-500">*</span></label>
                    <input id="city" name="city"
                        class="city form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="province1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="province">Warehouse Province<span
                        class="text-rose-500">*</span></label>
                    <input id="province" name="province"
                        class="province form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="country1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="country">Warehouse Country<span
                        class="text-rose-500">*</span></label>
                    <input id="country" name="country"
                        class="country form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" id="zip1" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="zip_code">Warehouse POS Code<span
                        class="text-rose-500">*</span></label>
                    <input id="zip_code" name="zip_code"
                        class="zip_code form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="purchdate">Purchase Date :<span
                        class="text-rose-500">*</span></label>
                    <input id="purchdate" name="purchdate"
                    class="purchdate selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                    Value="{{date('Y-m-d')}}" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="currency">Currency</label>
                    <select id="currency" name="currency"
                        class="currency form-select w-full md:w-3/4 px-2 py-1">
                        <option selected hidden value="">Select Currency</option>
                        @foreach ( $dataCurrency as $cur )
                        <option value="{{$cur->symbol}}">{{$cur->symbol}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="invoice_number">Invoice Number</label>
                    <input id="invoice_number" name="invoice_number"
                        class="invoice_number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="invoice_pdf">Invoice PDF</label>
                    <input id="invoice_pdf" name="invoice_pdf"
                        class="invoice_pdf form-input w-full md:w-3/4 px-2 py-1"
                        type="file" accept="application/pdf"/>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Add List Fixed Asset<span
                    class="text-rose-500">*</span>
                    </label>
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
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
                                        <div class="font-semibold text-slate-800">Add List Fixed Asset</div>
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
                                        type="text" readonly required />
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
                                                            <div class="font-semibold text-slate-800">Select
                                                                Asset</div>
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
                                                            <table id="assetInv"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Asset Code</th>
                                                                        <th class="text-center">Name</th>
                                                                        <th class="text-center">Unit</th>
                                                                        <th class="text-center">Category</th>
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
                                            type="text" readonly required hidden />
                                        <input id="rabId" name="rabId"
                                            class="rabId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly required hidden />
                                        <input id="budget" name="budget"
                                            class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="order_quantity">Quantity<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="order_quantity" name="order_quantity"
                                            class="order_quantity numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" />
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
                                            for="product_price">Price<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="product_price" name="product_price"
                                            class="product_price numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" />
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="itemTotal1">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="itemTotal">Total
                                        </label>
                                        <input id="itemTotal" name="itemTotal"
                                            class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mt-3 mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="desc">Detail</label>
                                        <textarea name="desc" id="desc" class="form-input w-full md:w-3/4 px-2 py-1" rows="3"></textarea>
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
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">Quantity</th>
                                <th class="text-sm text-center">Price</th>
                                <th class="text-sm text-center">Total</th> 
                                <th class="text-sm text-center">Detail</th> 
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="totalAmount">Qty Total</label>
                    <label class="text-sm font-medium mb-1 ml-32">:</label>
                    <label class="w-36 text-sm font-medium mb-1 text-white" for="discount2idr">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                    </label>
                    <input id="qtyTotall" name="qtyTotall" class="qtyTotall form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 text-right" type="text" readonly required/>
                    <label class="md:w-1/12 text-sm font-medium text-white"></label>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="totalAmount">Grand Total</label>
                    <label class="text-sm font-medium mb-1 ml-32">:</label>
                    <label class="w-36 text-sm font-medium mb-1 text-white" for="discount2idr">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 text-right" type="text" readonly required/>
                    <label class="md:w-1/12 text-sm font-medium text-white"></label>
                </div>
                <input id="qtyTotal" name="qtyTotal" class="qtyTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required hidden/>
                <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required hidden/>
                    <div class="flex flex-row justify-center">
                        <div x-data="{ modalOpen: false }">
                                <button type="button"
                                    class="ml-2 btn bg-sky-500 hover:bg-sky-600 text-white mt-5"
                                    @click.prevent="modalOpen = true"
                                    aria-controls="feedback-modal9127387">
                                    <span>View All List Fixed Asset</span>
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
                                <div id="feedback-modal9127387"
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
                                                <div class="font-semibold text-slate-800 text-sm">View All List Fixed Asset</div>
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
                                             <!-- label -->
                                             <div class="flex flex-row mb-3">
                                                <div class="rounded-full bg-sky-500 columns-1 h-5 w-5"></div>
                                                <p class="flex flex-row ml-1 text-sm font-medium">Ready</p>
                                                <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
                                                <p class="flex flex-row ml-1 text-sm font-medium">In Use/Assigned</p>
                                            </div>
                                            <div class="flex flex-row text-xs mb-3">
                                                <label class="flex flex-row text-xs">
                                                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status123">Available Status :</p>
                                                    <select id="status123" class="status123 flex flex-row ml-3 mb-3 text-xs" name="status123">
                                                        <option value="">All</option>
                                                        <option value="Y">Ready</option>
                                                        <option value="N">In Use/Assigned</option>
                                                    </select>
                                                <label class="flex flex-row text-xs">
                                                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="status1234">Status Condition :</p>
                                                    <select id="status1234" class="status1234 flex flex-row ml-3 mb-3 text-xs" name="status1234">
                                                        <option value="">All</option>
                                                        <option value="Ready">Ready</option>
                                                        <option value="In Use/Assigned">In Use/Assigned</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Need Reapair">Need Reapair</option>
                                                        <option value="Broken">Broken</option>
                                                        <option value="Discar">Discar</option>
                                                        <option value="Sold">Sold</option>
                                                    </select>
                                                
                                                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                                                <label class="flex flex-row text-xs">
                                                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="company123">Company :</p>
                                                    <select id="company123" class="company123 flex flex-row ml-3 mb-3 text-xs" name="company123">
                                                        <option value="">All</option>
                                                        @foreach ( $dataChildCompany as $company)
                                                        <option value="{{$company->id_company}}">{{$company->name}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input id="company123" name="company123"
                                                    class="company123 form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                                    value="{{$dataChildCompany->id_company}}" readonly hidden/>
                                                @endif
                                            </div>
                                            <div class="table-responsive">
                                                <table id="office-inventory12" class="table table-striped table-bordered text-xs" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="text-center">Fixed Asset Code</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Company</th>
                                                            <th class="text-center">Warehouse Address</th>
                                                            <th class="text-center">Detail</th>
                                                            <th class="text-center">Available</th>
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
                        <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5 ml-3" type="submit" id="create_offer">
                            <span class="xs:block ml-5 mr-5">Save M. Input Fixed Asset</span>
                        </button>
                    </div>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
    $('#company1').on('change', function (e) {
        const site = $('#company1').val();
        if ($('#company1').val() !== null) {
            $('#company').val(site);
            $('#company2').val(site);
            $('#delivery-address').DataTable().ajax.reload();
            $('#assetInv').DataTable().ajax.reload();
        }
    })
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
    $('#assetInv').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,
        language: {
            search: "Search Asset Code: "
            },
        ajax: {
            url: "{{ route('fixedasset.invfixasset') }}"
        },
        columns: [
            {
                data: "idassets",
                name: "idassets"
            },
            {
                data: "name",
                name: "name"
            },
            {
                data: "unit",
                name: "unit"
            },
            {
                data: "category",
                name: "category"
            },
            {
                data: "action",
                name: "action"
            },
            ],
            columnDefs: [
                { className: 'text-center', targets: [0, 2, 4] },
            ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
    });
});
$('#assetInv').on("click", ".btn-select", function () {
    const idAsset = $(this).data("id");
    const nameAsset = $(this).data("nama");
    const unit = $(this).data("unit");
                
    $("#assetId").val(idAsset);
    $("#nama_product").val(nameAsset);
    $("#unit").val(unit);
});

$('#delivery-address').on("click", ".btn-select", function () {
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

    $('#wname1').removeAttr('hidden');
    $('#address1').removeAttr('hidden');
    $('#city1').removeAttr('hidden');
    $('#province1').removeAttr('hidden');
    $('#country1').removeAttr('hidden');
    $('#zip1').removeAttr('hidden');
});

// data product
    let qtyTotal = 0;
    let subtotal = 0;
    let productIdx = 0;
    $(document).ready(function () {
         // Event listener untuk #order_quantity
        $('#order_quantity').on('input', function() {
            calculateTotal();
        });

        // Event listener untuk #product_price
        $('#product_price').on('input', function() {
            calculateTotal();
        });

        // Fungsi untuk menghitung total dan mengisikan nilai ke #itemTotal
        function calculateTotal() {
            const qtyValue = $('#order_quantity').val().replace(/\./g, ''); // Menghapus titik pemisah ribuan
            const priceValue = $('#product_price').val().replace(/\./g, ''); // Menghapus titik pemisah ribuan

            // Memastikan kedua input telah diisi
            if (qtyValue !== '' && priceValue !== '') {
                // Mengonversi input ke bilangan bulat
                const qty = parseFloat(qtyValue);
                const price1 = parseFloat(priceValue);

                // Mengonversi bilangan bulat ke string dengan titik pemisah ribuan
                const formattedQty = divider(qty);
                const formattedPrice = divider(price1);

                // Menghitung total
                const total1 = qty * price1;

                // Mengisikan nilai total1 ke #itemTotal dengan format ribuan
                $('#itemTotal').val(divider(total1));
            } else {
                // Jika salah satu atau kedua input kosong, set nilai #itemTotal menjadi 0
                $('#itemTotal').val('0');
            }
        }

        $("#addProduct").click(function () {
            var id = $('#assetId').val();
            var id_rab = $('#rabId').val();
            var name = $('#nama_product').val();
            var price = $('#product_price').val();
            var price2 = $('#product_price').val().replace(/\./g, '');
            var oq = parseFloat($('#order_quantity').val());
            var oq1 = $('#order_quantity').val().replace(/\./g, '');
            var unit = $('#unit').val();
            var desc = $('#desc').val();
            var total = price2 * oq1;

            if ($('#tableProductAddBody').find(`[name*="[ids]"][value="${id}"]`).length > 0) {
                    alert('Same Inventory Asset cannot be added again.');
                    return false;
                }
            
            if (!id || !oq || isNaN(parseFloat(price)) || parseFloat(price) <= 0 || isNaN(parseFloat(oq)) || parseFloat(oq) <= 0 ) {
                return false;
            }
            subtotal += total;
            qtyTotal += oq;
            
                var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                "  <td class=\"text-left\">" + name + "<input type=\"hidden\" name = \"rows[" + productIdx + "][ids]\"value =" + id + "></td>\n" +
                "  <td class=\"text-center\">" + unit + "<textarea name = \"rows[" + productIdx + "][units]\" hidden>" + unit + "</textarea></td>\n" +
                "  <td class=\"text-right\">" + `${divider(oq)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][oqs]\" value =" + oq1 + "></td>\n" +
                "  <td class=\"text-right\">" + `${divider(price)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][prices]\" value =" + price2 + "></td>\n" +
                "  <td class=\"text-right\">" + `${divider(total)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][totals]\" value =" + total + "></td>\n" +
                "  <td class=\"text-left\">" + desc + "<textarea name = \"rows[" + productIdx + "][descs]\" hidden>" + desc + "</textarea></td>\n" +
                "  <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + total + "," + oq + "," + null + ")\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
                "</tr>";

            $("#tableProductAddBody").append(tr);

            $('#assetId').val('');
            $('#nama_product').val('');
            $('#unit').val('');
            $('#product_price').val('');
            $('#order_quantity').val('');
            $('#itemTotal').val('');
            $('#desc').val('');
            $('#grandtotal').val(`${divider(subtotal)}`);
            $('#qtyTotall').val(`${divider(qtyTotal)}`);
            $('#grandtotal1').val(subtotal);
            $('#qtyTotal').val(qtyTotal);
            updateGrandTotal();

            productIdx++;
            var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
                grandTotalRow.detach();
                $("#tableProductAddBody").append(grandTotalRow);
            var grandTotalRow1 = $("#tableProductAddBody").find('.grandTotalRow1');
                grandTotalRow1.detach();
                $("#tableProductAddBody").append(grandTotalRow1);
        });
    });
    var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="2">Qty Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(qtyTotal)}</span></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>`;
    $("#tableProductAddBody").append(grandTotalRow);
    var grandTotalRow1 = `<tr class="grandTotalRow1">
            <td class="text-center font-bold text-lg" colspan="2">Grand Total</td>
            <td></td>
            <td></td>
            <td class="text-right font-bold text-lg" id="grandTotal_text1"><span id="grandTotal_text1">${divider(subtotal)}</span></td>
            <td></td>
            <td></td>
        </tr>`;
    $("#tableProductAddBody").append(grandTotalRow1);

    function updateGrandTotal() {
        $('#grandTotal_text').text(`${divider(qtyTotal)}`);
        $('#grandTotal_text').val(`${divider(qtyTotal)}`);
        $('#grandTotal_text1').text(`${divider(subtotal)}`);
        $('#grandTotal_text1').val(`${divider(subtotal)}`);
    }
    
    function deleteDataProduct(positionTableRow, total, oq) {
        const positionTableRowVariable = positionTableRow
        subtotal -= total;
        qtyTotal -= oq;
        $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();

        $('#grandtotal').val(`${divider(subtotal)}`);
        $('#qtyTotall').val(`${divider(qtyTotal)}`);
        $('#grandtotal1').val(`${subtotal}`);
        $('#qtyTotal').val(`${qtyTotal}`);
        updateGrandTotal();
    }

$(document).ready(function() {
    $('#office-inventory12').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "asc" ]],
                language: {
                    search: "Search Fixed Asset Code : "
                },
                ajax: {
                    url: "{{ route('fixedasset.getdata') }}",
                        data:function(d){                    
                            d.status123 = $("#status123").val()
                            d.status1234 = $("#status1234").val()
                            d.company123 = $("#company123").val()
                        }
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "idfa",
                        name: "idfa"
                    },
                    {
                        data: "assetName",
                        name: "assetName"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "warehouse",
                        name: "warehouse"
                    },
                    {
                        data: "detail",
                        name: "detail"
                    },
                    {
                        data: "avail",
                        name: "avail"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1, 6] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $('#status123').on('change', function (e) {
                $('#office-inventory12').DataTable().ajax.reload();
            })
            $('#status1234').on('change', function (e) {
                $('#office-inventory12').DataTable().ajax.reload();
            })
            $('#company123').on('change', function (e) {
                $('#office-inventory12').DataTable().ajax.reload();
            })
            
});
</script>
@endsection
</x-app-layout>