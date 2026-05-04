<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto" x-data="calendar" x-init="initCalendar">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-4">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"><span class="coba"
                        x-text="`${monthNames[month]} ${year}`"></span> ✨</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Previous month button -->
                <button
                    class="btn px-2.5 bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600 disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed"
                    :disabled="month === 0 ? true : false" @click="month--; getDays()">
                    <span class="sr-only">Previous month</span><wbr />
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 16 16">
                        <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z" />
                    </svg>
                </button>

                <!-- Next month button -->
                <button
                    class="btn px-2.5 bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600 disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed"
                    :disabled="month === 11 ? true : false" @click="month++; getDays()">
                    <span class="sr-only">Next month</span><wbr />
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 16 16">
                        <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                    </svg>
                </button>

                <hr class="w-px h-full bg-slate-200 mx-1" /> 

                <div x-data="{ modalOpen: false }">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" @click.prevent="modalOpen = true"
                    aria-controls="feedback-modal">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>Create Product Offering</button>
                    
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
                        @keydown.escape.window="modalOpen = false">
                            <!-- Modal header -->
                            <div class="px-5 py-3 border-b border-slate-200">
                                <div class="flex justify-between items-center">
                                    <div class="font-semibold text-slate-800">Create Product Offering</div>
                                    <button class="text-slate-400 hover:text-slate-500"
                                        @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <form action="{{ route('offering.create') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <!-- Modal content -->
                                <div class="modal-content">
                                
                                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Company Name :<span
                                            class="text-rose-500">*</span>
                                            </label>
                                            <input id="company" name="company"
                                                class="company form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                type="text" readonly required />
                                            <div x-data="{ modalOpen: false }">
                                                <button type="button" class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                    @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                                    <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                        <path class="fill-current text-slate-200"
                                                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                                        <path class="fill-current text-slate-200"
                                                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
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
                                                                <div class="font-semibold text-slate-800">Search Company</div>
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
                                                            <div class="table-responsive">
                                                                <table id="proyek"
                                                                    class="table table-striped table-bordered text-xs"
                                                                    style="width:100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center">Company ID</th>
                                                                            <th class="text-center">Company Name</th>
                                                                            <th class="text-center">Status</th>
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
                                        <input id="idCompany" name="idCompany"
                                            class="idCompany form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200" type="text"
                                            readonly required hidden />
                                        <input id="sales" name="sales"
                                            class="sales form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200" type="text"
                                            hidden />
                                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="pic">PIC :<span
                                            class="text-rose-500">*</span>
                                            </label>
                                            <select class="pic form-select md:w-1/2" id="pic" name="pic" required>
                                                <option></option>
                                            </select>
                                            <select class="pics form-select md:w-1/2" id="pics" name="pics" hidden>
                                            </select>
                                            <div x-data="{ modalOpen: false }">
                                                <button id="btn-pic" type="button"
                                                    class="ml-2 btn btn-pic bg-indigo-500 hover:bg-indigo-600 text-white"  @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                                            <svg class="w-4 h-4 fill-current  text-slate-200" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                                            </svg>
                                                        <span></span>
                                                    </a>
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
                                                                <div class="font-semibold text-slate-800">Create New PIC</div>
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
                                                            <div class="table-responsive">
                                                                <div class="flex justify-between flex-col md:flex-row mb-3 mt-3">
                                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                        for="name_pic">Name :<span class="text-rose-500">*</span>
                                                                    </label>
                                                                    <input id="name_pic" name="name_pic"
                                                                        class="name_pic form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                        type="text"/>
                                                                </div>
                                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                        for="phone_number_1">Dept. / Position :<span class="text-rose-500">*</span>
                                                                    </label>
                                                                    <input id="phone_number_1" name="phone_number_1"
                                                                        class="phone_number_1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                        type="text"/>
                                                                </div>
                                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                        for="phone_number_2">Phone Number :<span class="text-rose-500">*</span>
                                                                    </label>
                                                                    <input id="phone_number_2" name="phone_number_2"
                                                                        class="phone_number_2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                        type="text"/>
                                                                </div>
                                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                        for="email">Email :<span class="text-rose-500">*</span>
                                                                    </label>
                                                                    <input id="email" name="email"
                                                                        class="email form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                        type="email"/>
                                                                </div>
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
                                                                <button type="button" id="btn-new"
                                                                    class="btn-new btn-sm bg-indigo-500 hover:bg-indigo-600 text-slate-100"
                                                                    @click="modalOpen = false">Create New PIC</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-row md:flex-row ml-5 mb-3">
                                            <label class="block text-sm font-medium mb-1" for="task_id">Product : <span
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
                                                                <div class="font-semibold text-slate-800">Add Product</div>
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
                                                                    for="nama_product">Product Name :
                                                                </label>
                                                                <select class="form-select text-sm" id="proyek1" name="proyek1" style="width: 62rem" onchange="myFunction(this)">
                                                                    <option class="" value="">Select Product</option>
                                                                     @foreach ($dataProduct as $dataProduct)
                                                                        <option class="" value="{{ $dataProduct->id }}">{{ $dataProduct->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <p id="nama_product" hidden></p>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="currency">Currency :
                                                                </label>
                                                                <select id="currency" name="currency"
                                                                    class="currency form-select w-full md:w-3/4 px-2 py-1">
                                                                    <option selected hidden>Set Currency</option>
                                                                    @foreach ($dataCurrency as $dataCurrency)
                                                                        <option class="" value="{{ $dataCurrency->currency }}">{{ $dataCurrency->symbol }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="product_price">Product Price :
                                                                </label>
                                                                <input id="product_price" name="product_price"
                                                                    class="product_price form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                    type="number" value="0"/>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="minimum_quantity_order">Minimum Order Qty :
                                                                </label>
                                                                <input id="minimum_quantity_order" name="minimum_quantity_order"
                                                                    class="minimum_quantity_order form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                    type="number" value="0"/>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="order_quantity">Order Qty :
                                                                </label>
                                                                <input id="order_quantity" name="order_quantity"
                                                                    class="order_quantity form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                    type="number"value="0"/>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="status_product">Status :
                                                                </label>
                                                                <select id="status_product" name="status_product" class="status_product form-select w-full md:w-3/4 px-2 py-1">
                                                                    <option selected value="Promoting">Promoting</option>
                                                                    <option value="Offering">Offering</option>
                                                                    <option value="Request Document">Request Document</option>
                                                                    <option value="Won">Won</option>
                                                                    <option value="Pending">Pending</option>
                                                                    <option value="Lost">Lost</option>
                                                                </select>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="nama_product">Request Document to :
                                                                </label>
                                                                <select class="form-select text-sm" id="users" name="users" style="width: 62rem" onchange="prdoductRequest(this)">
                                                                    <option class="" value="" selected>Select User</option>
                                                                    <option class="" value="">Not Request</option>
                                                                     @foreach ($dataUsers as $users)
                                                                        <option class="" value="{{ $users->id }}">{{ $users->username }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <p id="request_to" hidden>Not Request</p>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="document_note">Notes Document :
                                                                </label>
                                                                <textarea id="document_note" name="document_note"
                                                                    class="document_note form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                    type="text" rows="2"></textarea>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="nama_product">Request Sample to :
                                                                </label>
                                                                <select class="form-select text-sm" id="users1" name="users1" style="width: 62rem" onchange="prdoductRequest1(this)">
                                                                    <option class="" value="" selected>Select User</option>
                                                                    <option class="" value="">Not Request</option>
                                                                     @foreach ($dataUsers as $users)
                                                                        <option class="" value="{{ $users->id }}">{{ $users->username }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <p id="request_to1" hidden>Not Request</p>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="sample_note">Notes Sample :
                                                                </label>
                                                                <textarea id="sample_note" name="sample_note"
                                                                    class="sample_note form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                    type="text" rows="2"></textarea>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="product_note">Notes Product :
                                                                </label>
                                                                <textarea id="product_note" name="product_note"
                                                                    class="product_note form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                    type="text" rows="2"></textarea>
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
                                                                        class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                                        @click="modalOpen = false" id="addProduct"
                                                                        data-id_product="' . $dataProduct->id . '"
                                                                        data-nama_product="' . $dataProduct->name . '"
                                                                        data-task-id="' . $dataProduct->task_id . '"
                                                                        data-task="' . $dataProduct->task . '"
                                                                        data-product_price="' . $dataProduct->price . '"
                                                                        data-currency="' . $dataProduct->m_currency . '"
                                                                        data-minimum_quantity_order="' . $dataProduct->minimum_order_qty . '"
                                                                        data-order_quantity="' . $dataProduct->order_qty . '">Add
                                                                        Product</button>
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
                                                        <th class="text-sm text-center">Product Name</th>
                                                        <th class="text-sm text-center">Currency</th>
                                                        <th class="text-sm text-center">Price</th>
                                                        <th class="text-sm text-center">Minimun Order Qty</th>
                                                        <th class="text-sm text-center">Quantity</th>
                                                        <th class="text-sm text-center">Status</th>
                                                        <th class="text-sm text-center">Notes Product</th>
                                                        <th class="text-sm text-center">Document Request To</th>
                                                        <th class="text-sm text-center">Notes Document</th>
                                                        <th class="text-sm text-center">Sample Request To</th>
                                                        <th class="text-sm text-center">Notes Sample</th>
                                                        <th class="text-sm text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tableProductAddBody" id="tableProductAddBody">
            
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="offeringTag">Offering Tag :<span
                                            class="text-rose-500">*</span>
                                            </label>
                                            <select class="offeringTag form-select md:w-1/2" id="offeringTag" name="offeringTag" required>
                                                <option value="" hidden>Select Here</option>
                                                @foreach ($offeringTags as $offeringTag)
                                                <option value="{{ $offeringTag->id }}">{{ $offeringTag->color_tag }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name">Start Date :<span
                                                class="text-rose-500">*</span></label>
                                            <input id="start_date" name="start_date" class="start_date form-input px-2 py-1"
                                                type="datetime-local" required />
                                        </div>
                                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name">End Date :<span
                                                class="text-rose-500">*</span></label>
                                            <input id="end_date" name="end_date" class="end_date form-input px-2 py-1"
                                                type="datetime-local" required />
                                        </div>
                                        <div class="flex flex-col justify-between md:flex-row ml-5 mb-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes">Note :
                                           <span class="text-rose-500">*</span></label>
                                            <textarea id="notes" name="notes" class="notes form-input w-full md:w-3/4 px-2 py-1"
                                                rows="3" required></textarea>
                                        </div>
                                        <div class="space-y-3">
                                        </div>
                                    
                                </div>
                                <!-- Modal footer -->
                                <div class="px-5 py-4 border-t border-slate-200">
                                    <div class="flex flex-wrap justify-end space-x-2">
                                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">
                                            Close
                                        </button>
                                        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit" id="create_offer">
                                            <span class="xs:block ml-5 mr-5">Create Product Offering</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- @endif --}}

            </div>

        </div>
       <!-- Filters and view buttons -->
       <div class="sm:flex sm:justify-between sm:items-center mb-4">

           <!-- Filters  -->
           <div class="mb-4 sm:mb-0 mr-2">
               <ul class="flex flex-wrap items-center ml-1">
                   @foreach ($offeringTags as $offeringTag)
                   <li class="m-1">
                       <button class="btn-sm bg-white border-slate-200 hover:border-slate-300 text-slate-500">
                           <div class="w-1 h-3.5 {!! $offeringTag->value_color !!} shrink-0"></div>
                           <span class="ml-1.5">{{ $offeringTag->color_tag }}</span>
                       </button>
                   </li>
                   @endforeach
               </ul>
           </div>
       </div>

        <!-- Calendar table -->
        <div class="bg-white rounded-sm shadow overflow-hidden" x-cloak>

            <!-- Days of the week -->
            <div class="grid grid-cols-7 gap-px border-b border-slate-200">
                <template x-for="(day, index) in dayNames" :key="index">
                    <div class="px-1 py-3">
                        <div class="text-slate-500 text-sm font-medium text-center lg:hidden"
                            x-text="day.substring(0,3)"></div>
                        <div class="text-slate-500 text-sm font-medium text-center hidden lg:block" x-text="day"></div>
                    </div>
                </template>
            </div>

            <!-- Day cells -->
            <div class="grid grid-cols-7 gap-px bg-slate-200 day-cells">
                <!-- Diagonal stripes pattern -->
                <svg class="sr-only">
                    <defs>
                        <pattern id="stripes" patternUnits="userSpaceOnUse" width="5" height="5"
                            patternTransform="rotate(135)">
                            <line class="stroke-current text-slate-200 opacity-50" x1="0" y="0" x2="0" y2="5"
                                stroke-width="2" />
                        </pattern>
                    </defs>
                </svg>
                <!-- Empty cells (previous month) -->
                <template x-for="blankday in startingBlankDays">
                    <div class="bg-slate-50 h-20 sm:h-28 lg:h-36">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                            <rect width="100%" height="100%" fill="url(#stripes)" />
                        </svg>
                    </div>
                </template>
                <!-- Days of the current month -->
                <template x-for="(day, dayIndex) in daysInMonth" :key="dayIndex">
                    <div class="relative bg-white h-20 sm:h-28 lg:h-36 overflow-hidden">
                        <div class="h-full flex flex-col justify-between">
                            <!-- Events -->
                            <div class="grow flex flex-col relative p-0.5 sm:p-1.5 overflow-hidden" > 
                                <div x-data="{ modalOpen: false }">
                                    <template x-for="event in getEvents(day)">
                                        <button target="#event" id="event" class="btn-event relative w-full text-left mb-1" @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                            <div class="px-2 py-0.5 rounded overflow-hidden" :class="{
                                                    'text-white bg-sky-500': event.eventColor=== 'bg-sky-500',
                                                    'text-white bg-indigo-500': event.eventColor === 'bg-indigo-500',
                                                    'text-white bg-emerald-500': event.eventColor === 'bg-emerald-500',
                                                    'text-white bg-rose-500': event.eventColor === 'bg-rose-500',
                                                    'text-white bg-blue-600': event.eventColor === 'bg-blue-600',
                                                    'text-white bg-red-600': event.eventColor === 'bg-red-600',
                                                    'text-white bg-purple-600': event.eventColor === 'bg-purple-600',
                                                    'text-white bg-amber-600': event.eventColor === 'bg-amber-600',
                                                    'text-white bg-cyan-600': event.eventColor === 'bg-cyan-600',
                                                    'text-white bg-pink-600': event.eventColor === 'bg-pink-600',
                                                    'text-white bg-fuchsia-600': event.eventColor === 'bg-fuchsia-600'
                                                }">
                                                {{-- Calendar ID --}}
                                                <div class="id hidden" x-text="event.id"></div>
                                                <div class="add_by hidden" x-text="event.add_by"></div>
                                                <!-- Event name -->
                                                <div class="text-xs font-semibold truncate" x-text="event.eventName"></div>
                                                <div class="text-xs font-semibold truncate" x-text="event.eventPIC"></div>
                                                <!-- Event time -->
                                                <div class="text-xs uppercase truncate hidden sm:block">
                                                    <!-- Start date -->
                                                    <template x-if="event.eventStart">
                                                        <span
                                                            x-text="event.eventStart.toLocaleTimeString([], {hour12: true, hour: 'numeric', minute:'numeric'})"></span>
                                                    </template>
                                                    <!-- End date -->
                                                    <template x-if="event.eventEnd">
                                                        <span>
                                                            - <span
                                                                x-text="event.eventEnd.toLocaleTimeString([], {hour12: true, hour: 'numeric', minute:'numeric'})"></span>
                                                        </span>
                                                    </template>
                                                </div>
                                            </div>
                                        </button>
                                        <!-- Modal backdrop -->
                                            <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                            x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-out duration-100"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            aria-hidden="true" x-cloak></div>
                                    </template>
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
                                                        <div class="font-semibold text-slate-800">View Offering Product</div>
                                                        <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                                            <div class="sr-only">Close</div>
                                                            <svg class="w-4 h-4 fill-current">
                                                                <path
                                                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <form method="post" class="form_offering_update">
                                                    @csrf
                                                    <!-- Modal content -->
                                                    <div class="modal-content">
                                                    
                                                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                            <input type="hidden" name="id_offering" class="id-offering"/>
                                                            <input type="hidden" name="offering_id" class="offering-id"/>
                                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company1">Company Name :<span
                                                            class="text-rose-500">*</span>
                                                            </label>
                                                            <input id="company1" name="company1"
                                                                class="company1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                                type="text" readonly required />
                                                        </div>
                                                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="pic1">PIC :<span
                                                            class="text-rose-500">*</span>
                                                            </label>
                                                            <input id="pic1" name="pic1"
                                                            class="pic1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                            type="text" readonly required />
                                                            <input id="picId" name="picId"
                                                            class="picId form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                            type="text" hidden readonly required />
                                                        </div>
                                                        <div class="flex flex-row md:flex-row ml-5 mb-3">
                                                            <label class="block text-sm font-medium mb-1" for="task_id">Product : <span
                                                            class="text-rose-500">*</span>
                                                            </label>
                                                        </div>
                                                        <div class="flex flex-row md:flex-row table-content">
                                                           
                                                        </div>
                                                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="offeringTag1">Offering Tag :<span
                                                            class="text-rose-500">*</span>
                                                            </label>
                                                            <select id="offeringTag1" name="offeringTag1" class="offeringTag1 form-select w-full md:w-1/2 px-2 py-1">
                                                                <option selected disabled hidden>Select Here</option>
                                                                @foreach ($offeringTags as $offeringTag)
                                                                <option value="{{ $offeringTag->id }}" {{ $offeringTag->id ? ' selected' : '' }}>{{ $offeringTag->color_tag }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                            {{-- <form method="post" class="form_offering_schedule">
                                                                @csrf --}}
                                                                <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="start_time1">Start Date :<span
                                                                        class="text-rose-500">*</span></label>
                                                                    <input id="start_time1" name="start_time1" class="start_time1 form-input px-2 py-1"
                                                                        type="datetime-local" required />
                                                                </div>
                                                                <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="end_time1">End Date :<span
                                                                        class="text-rose-500">*</span></label>
                                                                    <input id="end_time1" name="end_time1" class="end_time1 form-input px-2 py-1"
                                                                        type="datetime-local" required />
                                                                    <div class="btn-action1"></div>
                                                            {{-- </form> --}}
                                                            </div>
                                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes1">Note :<span
                                                                class="text-rose-500">*</span>
                                                                </label>
                                                                <textarea id="notes1" name="notes1"
                                                                    class="notes1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                                    type="text" rows="3"></textarea>
                                                            </div>
                                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notulens">Meeting Result :<span
                                                                class="text-rose-500">*</span>
                                                                </label>
                                                                <textarea id="notulens" name="notulens"
                                                                    class="notulens form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                                    type="text"rows="3"></textarea>
                                                            </div>
                                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="add_by1">Add By :<span
                                                                class="text-rose-500">*</span>
                                                                </label>
                                                                <input id="add_by1" name="add_by1"
                                                                    class="add_by1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                                    type="text" readonly required />
                                                            </div>
                                                            <div class="space-y-3">
                                                            </div>
                                                    
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="px-5 py-4 border-t border-slate-200 btn-action">
                                                            
                                                        </div>
                                                </form>
                                            </div>
                                            <!--<span class="oke" x-text="event.eventStart.toISOString().split('T')[0]"></span>-->
                                        </div>
                                    </div>
                                <div class="absolute bottom-0 left-0 right-0 h-4 bg-gradient-to-t from-white to-transparent pointer-events-none"
                                    aria-hidden="true"></div>
                            </div>
                            <!-- Cell footer -->
                            <div class="flex justify-between items-center p-0.5 sm:p-1.5">
                                <!-- More button (if more than 2 events) -->
                                <template x-if="getEvents(day).length">
                                        <div class="ok">
                                            {{-- <span class="offering-date" x-text="dayIndex"></span> --}}
                                            <span class="hidden offering-date" x-text="`${year}-${monthNames.indexOf(monthNames[month]) + 1}-${day}`"></span>
                                            <a
                                                target="_blank"
                                                class="pointer offering-detail text-xs text-slate-500 font-medium whitespace-nowrap text-center sm:py-0.5 px-0.5 sm:px-2 border border-slate-200 rounded"
                                                onclick="test(this)">
                                                <span class="pointer hidden">+</span><span x-text="getEvents(day).length"></span>
                                                <span class="pointer md:inline">Offerings Activity</span>
                                            </a>
                                            <script>
                                                function test(ths) {
                                                    let url = new URL(window.location.href);
                                                    let urlRedirect;
                                                    let offeringDate = $(ths).parent().children('.offering-date').text();
                                                    if (url.search) {
                                                        urlRedirect = url.pathname + '/offeringdetail' + url.search + '&start_time=' + offeringDate;
                                                    } else {
                                                            urlRedirect = url.pathname + '/offeringdetail?start_time=' + offeringDate;
                                                    }
                                                    console.log(urlRedirect);
                                                    window.open(urlRedirect, '_blank') = urlRedirect;
                                                }
                                                $(document).ready(function () {
                                                    
                                                    // let url = new URL(window.location.href);
                                                    // let urlRedirect;
                                                    // const offeringDate = $('.offering-date').text();
                                                    // if (url.search) {
                                                        //     urlRedirect = url.pathname + '/offeringdetail' + url.search + '&start_time=' + offeringDate;
                                                        // } else {
                                                            //     urlRedirect = url.pathname + '/offeringdetail?start_time=' + offeringDate;
                                                            // }
                                                    // $('.offering-detail'). on('click', function(){
                                                    //             // 
                                                    //             console.log(`${day}`);
                                                    //     console.log($('.offering-date')); 
                                                    // });
                                                    // $('.offering-detail').attr('href', urlRedirect);
                                                })
                                            </script>
                                        </div>
                                </template>
                                <!-- Day number -->
                                <button
                                    class="inline-flex ml-auto w-6 h-6 items-center justify-center text-xs sm:text-sm font-medium text-center rounded-full hover:bg-indigo-100"
                                    :class="{'text-indigo-500': isToday(day) }" x-text="day"></button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Empty cells (next month) -->
                <template x-for="blankday in endingBlankDays">
                    <div class="bg-slate-50 h-20 sm:h-28 lg:h-36">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                            <rect width="100%" height="100%" fill="url(#stripes)" />
                        </svg>
                    </div>
                </template>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            var dataOffering = [];
            var items = {};
            @foreach ($dataOffering as $item)
                items = {
                    add_by:"{{$item->add_by}}",
                    id: "{{ $item->id }}",
                    eventName: "{{ $item->company_id }}",
                    eventPIC: "{{ $item->name }}",
                    eventStart: new Date("{{ $item->start_time }}"),
                    eventEnd: new Date("{{ $item->end_time }}"),
                    eventColor: "{!! $item->value_color !!}"
                };
                dataOffering.push(items);
            @endforeach

            
            Alpine.data('calendar', () => ({
                month: null,
                year: null,
                daysInMonth: [],
                startingBlankDays: [],
                endingBlankDays: [],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                events: dataOffering,

                initCalendar() {
                    const today = new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.getDays();
                },

                isToday(date) {
                    const today = new Date();
                    const day = new Date(this.year, this.month, date);
                    return today.toDateString() === day.toDateString() ? true : false;
                },

                getEvents(date) {
                    return this.events.filter(e => new Date(e.eventStart.getFullYear(), e.eventStart.getMonth(), e.eventStart.getDate() ).getTime() <= new Date(this.year, this.month, date).getTime() && new Date(e.eventEnd.getFullYear(), e.eventEnd.getMonth(), e.eventEnd.getDate() ).getTime() >= new Date(this.year, this.month, date).getTime());
                },

                getDays() {
                    const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                    // starting empty cells (previous month)
                    const startingDayOfWeek = new Date(this.year, this.month).getDay();
                    let startingBlankDaysArray = [];
                    for (let i = 1; i <= startingDayOfWeek; i++) {
                        startingBlankDaysArray.push(i);
                    }


                    // ending empty cells (next month)
                    const endingDayOfWeek = new Date(this.year, this.month + 1, 0).getDay();
                    let endingBlankDaysArray = [];
                    for (let i = 1; i < 7 - endingDayOfWeek; i++) {
                        endingBlankDaysArray.push(i);
                    }

                    // current month cells
                    let daysArray = [];
                    for (let i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.startingBlankDays = startingBlankDaysArray;
                    this.endingBlankDays = endingBlankDaysArray;
                    this.daysInMonth = daysArray;
                }
            }));

        });
    </script>

    @section('js-page')
    <script>
        function deleteDataProduct(positionTableRow, dataFromDatabase) {
            const positionTableRowVariable = positionTableRow

                $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();

            console.info('positionTableRowVariable: ', positionTableRowVariable)
        }

        $(document).ready(function () {

            $('.day-cells').on("click", ".btn-event", function () {
                const offeringId = $(this).children().children().html();

                $(".form_offering_update").attr('action', `/tasks/offering/productoffering/offeringupdate/${offeringId}`);
                $(".form_offering_schedule").attr('action', `/tasks/offering/productoffering/offeringreschedule/${offeringId}`);
                $("input[name!='_token']").val("");
                
                $.ajax({
                    type: "GET",
                    url: `/tasks/offering/productoffering/getupdate/${offeringId}`,
                    success: function (response) {
                        $(".id-offering").val(offeringId);
                        $(".offering-id").val(response.dataOfferings.id_offerings);
                        $(".company1").val(response.dataOfferings.company_id);
                        $(".pic1").val(response.dataOfferings.name);
                        $(".picId").val(response.dataOfferings.pic);
                        $(".offeringTag1").val(response.dataOfferings.id_offering_color);
                        $(".start_time1").val(response.dataOfferings.start_time);
                        $(".end_time1").val(response.dataOfferings.end_time);
                        $(".start_time2").val(response.dataOfferings.start_time);
                        $(".end_time2").val(response.dataOfferings.end_time);
                        $(".notes1").val(response.dataOfferings.notes);
                        $(".add_by1").val(response.dataOfferings.username);
                        $(".notulens").val(response.dataOfferings.notulens);
                        
                        const add_by = response.dataOfferings.add_by;
                        const auth_user = {{ Auth::user()->id  }};
                        
                        if (add_by == auth_user) {
                            const btn_action = `<div class="flex flex-wrap justify-end space-x-2">
                                <button type="button" data-id_offering="${response.dataOfferings.id}"
                                    class="btn-sm bg-red-400 border-slate-200 hover:border-slate-300 text-white btn-delete">
                                    Delete
                                </button>
                                <input type="submit" value="update" id="btn_update" name="status" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"/>
                            </div>`;
                            $('.btn-action').html(btn_action);
                        } else{ 
                            $('.btn-action').empty();
                        }

                        if (add_by == auth_user) {
                            const btn_action1 = `<input type="submit" id="btn_reschedule" value="Reschedule" name="status" class="btn-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-3"/>
                            `;
                            $('.btn-action1').html(btn_action1);
                        } else{ 
                            $('.btn-action1').empty();
                        }
                    }
                });
                    
                $.ajax({
                    type: "GET",
                    url: `/tasks/offering/productoffering/getdetail/${offeringId}`,
                    success: function (response) {

                        $(".table-content").html(`<table class="table table-striped table-bordered mt-3 tableProductAddBody1"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-sm text-center">Product Name</th>
                                                                        <th class="text-sm text-center">Currency</th>
                                                                        <th class="text-sm text-center">Price</th>
                                                                        <th class="text-sm text-center">Minimun Order Qty</th>
                                                                        <th class="text-sm text-center">Quantity</th>
                                                                        <th class="text-sm text-center">Status</th>
                                                                        <th class="text-sm text-center">Document Status</th>
                                                                        <th class="text-sm text-center">Sample Status</th>
                                                                        <th class="text-sm text-center">Notes</th>
                                                                        <th class="text-sm text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                            
                                                                </tbody>
                                                            </table>`);
                        let tableRow = '';
                        for (const value of response) {
                            tableRow = `<tr>
                                            <td><input type="text" name="rows1[m_currency1]" value="${value.product}" hidden/> <input type="text" name="rows1[m_currency1]" value="${value.product_id}" hidden/>${value.product_name}</td>
                                            <td class="text-center"><input type="text" name="rows1[m_currency1]" value="${value.m_currency}" hidden/>${value.m_currency}</td>
                                            <td class="text-right"><input type="text" name="rows1[price1]" value="${value.price}" hidden/>${value.price}</td>
                                            <td class="text-right"><input type="text" name="rows1[moqty1]" value="${value.moqty}" hidden/>${value.moqty}</td>
                                            <td class="text-right"><input type="text" name="rows1[qty1]" value="${value.qty}" hidden/>${value.qty}</td>
                                            <td class="text-center"><input type="text" name="rows1[status1]" value="${value.status}" hidden/>${value.status}</td>
                                            <td class="text-center"><input type="text" name="rows1[documentstatus1]" value="${value.rnd_flag}" hidden/>${value.rnd_flag}</td>
                                            <td class="text-center"><input type="text" name="rows1[samplestatus1]" value="${value.flag_sample}" hidden/>${value.flag_sample}</td>
                                            <td><input type="text" name="rows1[notes1]" value="${value.notes}" hidden/>${value.notes}</td>
                                            <td class="text-center flex flex-row justify-center">
                    <div x-data="{ modalOpen: false }">
                        <button type="button" class="btn bg-emerald-500 hover:bg-emerald-600 text-white" @click.prevent="modalOpen = true"
                            aria-controls="feedback-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>img</title><g stroke-width="1" stroke-linejoin="round" fill="none" stroke="#ffff" stroke-linecap="round" class="nc-icon-wrapper"><polyline points="0.5 12.5 3.5 9.5 5.5 11.5 10.5 6.5 15.5 11.5" stroke="#ffff"></polyline><path d="M14,15.5H2A1.5,1.5,0,0,1,.5,14V2A1.5,1.5,0,0,1,2,.5H14A1.5,1.5,0,0,1,15.5,2V14A1.5,1.5,0,0,1,14,15.5Z"></path><circle cx="5" cy="5" r="1.5" stroke="#ffff"></circle></g></svg></button>
                        <!-- Modal backdrop -->
                        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                            x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-out duration-100"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            aria-hidden="true" x-cloak></div>
                        <!-- Modal dialog -->
                        <div id="feedback-modal" class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6" role="dialog" aria-modal="true" x-show="modalOpen"
                            x-transition:enter="transition ease-in-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in-out duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
                        <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full" @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                        <!-- Modal header -->
                        <div class="px-5 py-3 border-b border-slate-200">
                            <div class="flex justify-between items-center">
                                <div class="font-semibold text-slate-800">View Offering Product Offering Image</div>
                                        <button type="button" class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                            <div class="sr-only">Close</div>
                                            <svg class="w-4 h-4 fill-current">
                                                <path
                                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <form action="{{route('calendar.createschedule')}}" method="post">
                                    @csrf
                                    <!-- Modal content -->
                                    <div class="px-5 py-4">
                                        <div class="px-5">
                                        <div class="grid md:grid-cols-3 gap-3 mt-3">
                                            <div></div>
                                            <div class="${value.photo2 == 1 ? '' : 'hidden'}">
                                                <label class="text-sm font-medium mb-1">Product Offering Image Not Uploaded Yet</label>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="grid md:grid-cols-3 gap-3 mt-3">
                                            <div class="${value.photo1 == 1 ? 'hidden' : ''}">
                                                <label class="text-sm font-medium mb-1">Product Offering Image 1 :</label>
                                                <a href="/tasks/offering/productoffering/photo1/${value.id_offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                                <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${value.img_1}" width="259" height="142" alt="Product Image" />
                                            </div>
                                            <div></div>
                                            <div class="${value.photo2 == 1 ? 'hidden' : ''}">
                                                <label class="text-sm font-medium mb-1">Product Offering Image 2 :</label>
                                                <a href="/tasks/offering/productoffering/photo2/${value.id_offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                                <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${value.img_2}" width="259" height="142" alt="Product Image" />
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ modalOpen: false }">
                        <button type="button" class="btn bg-purple-500 hover:bg-purple-600 text-white ml-3" @click.prevent="modalOpen = true"
                            aria-controls="feedback-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>file text</title><g stroke-width="1" stroke-linecap="round" stroke="#ffff" stroke-miterlimit="10" fill="none" class="nc-icon-wrapper w-4 h-4" stroke-linejoin="round"><line x1="4.5" y1="11.5" x2="11.5" y2="11.5" stroke="#ffff"></line> 
                                <line x1="4.5" y1="8.5" x2="11.5" y2="8.5" stroke="#ffff"></line> <line x1="4.5" y1="5.5" x2="6.5" y2="5.5" stroke="#ffff"></line> <polygon points="9.5,0.5 1.5,0.5 1.5,15.5 14.5,15.5 14.5,5.5 "></polygon> <polyline points="9.5,0.5 9.5,5.5 14.5,5.5 "></polyline></g>
                            </svg></button>
                        <!-- Modal backdrop -->
                        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                            x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-out duration-100"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            aria-hidden="true" x-cloak></div>
                        <!-- Modal dialog -->
                        <div id="feedback-modal" class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6" role="dialog" aria-modal="true" x-show="modalOpen"
                            x-transition:enter="transition ease-in-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in-out duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
                        <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full" @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                        <!-- Modal header -->
                        <div class="px-5 py-3 border-b border-slate-200">
                            <div class="flex justify-between items-center">
                                <div class="font-semibold text-slate-800">View Product Offering Document</div>
                                        <button type="button" class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                            <div class="sr-only">Close</div>
                                            <svg class="w-4 h-4 fill-current">
                                                <path
                                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                    <!-- Modal content -->
                                    <div class="px-5 py-4">
                                        <div class="px-5">
                                        <div class="grid md:grid-cols-3 gap-3 mt-3">
                                            <div></div>
                                            <div class="${value.photo2 == 1 ? '' : 'hidden'}">
                                                <label class="text-sm font-medium mb-1">Product Offering Document Not Uploaded Yet</label>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="grid md:grid-cols-3 gap-3 mt-3">
                                            <div class="${value.photo1 == 1 ? 'hidden' : ''}">
                                                <label class="text-sm font-medium mb-1">Product Offering Document 1 :</label>
                                                <a href="/tasks/offering/productoffering/file1/${value.id_offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Document</a>
                                            </div>
                                            <div></div>
                                            <div class="${value.photo2 == 1 ? 'hidden' : ''}">
                                                <label class="text-sm font-medium mb-1">Product Offering Document 2 :</label>
                                                <a href="/tasks/offering/productoffering/file2/${value.id_offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Document</a>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Cancel</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    </td>
                                        </tr>`;
                            $(".tableProductAddBody1").find('tbody').append(tableRow);
                        }
                    }
                });

                $('.btn-action').on("click", ".btn-delete",  function () {
                    const id_offering = $(this).data("id_offering");
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Want to Delete Product Offering!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                },
                                type: "DELETE",
                                url: `/tasks/offering/productoffering/offeringdelete/${id_offering}`,
                                success: function (response) {
                                    console.info("response: ", response)
                                    const { status, message } = response;
                                    if (status == 1) {
                                        Swal.fire(
                                            'Deleted!',
                                            'Your Offering has been deleted.',
                                            message
                                        )
                                        window.location.reload(true);
                                    }
                                },
                                error: function (data) {
                                    console.info("error: ", data)
                                }
                            })

                        }
                    })
                });
                $('#start_time1').on('change', function () {
                    var sdate= new Date($(this).val());
                    var edate= new Date($("#end_time1").val());
                    // alert(edate);

                    if (edate < sdate && edate != '') {
                        alert('End date cannot be before start date!');
                        document.getElementById('btn_update').disabled = true;
                        document.getElementById('btn_reschedule').disabled = true;
                    } else {
                        document.getElementById('btn_update').disabled = false;
                        document.getElementById('btn_reschedule').disabled = false;
                    }
                });
            
                $('#end_time1').on('change', function () {
                    var edate= new Date($(this).val());
                    var sdate= new Date($("#start_time1").val());
                        
                    if (edate < sdate && edate != '') {
                        alert('End date cannot be before Start date!');
                        document.getElementById('btn_update').disabled = true;
                        document.getElementById('btn_reschedule').disabled = true;
                    } else {
                        document.getElementById('btn_update').disabled = false;
                        document.getElementById('btn_reschedule').disabled = false;
                    }
                });
            });
        });

         // data Companies
         $(document).ready(function () {
            $('#proyek').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                order: [[1, 'asc']],
                language: {
                    search: "Search Customer Name: "
                },
                ajax: {
                    url: "{{ route('create.getcompany') }}"
                },
                columns: [
                    {
                        data: "company_id",
                        name: "company_id"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "status_name",
                        name: "status_name"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [2, 3] },
                    {
                        target: 0,
                        visible: false,
                        searchable: false,
                    }
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            
            $(".btn-pic").attr("disabled", true);

            $('#proyek').on("click", ".btn-select", function () {
                const idCompany = $(this).data("id");
                const company = $(this).data("nama");
                const sales = $(this).data("sales");
                const pic = $(this).data("pic");

                // $(".sales").empty();
                $(".pic").empty();
                $(".pics").empty();

                $.ajax({
                    type: "GET",
                    url: `/tasks/proyek/proyek-all/selectcompany/${idCompany}`,
                    success: function (response) {
                        let picList = '';
                        let pic1 = '';
                        for (const value of response.listCompanyPic) {
                            picList += `<option value="${value.id}" ${value.id == pic ? 'selected' : ''}>${value.name} (${value.phone_number_1} / ${value.phone_number_2})</option>`;
                            pic1 += `<option value="${value.id}" ${value.id == pic ? 'selected' : ''}>${value.id}</option>`;
                        }
                        // let salesList = '';
                        // for (const value of response.salesList) {
                        //     salesList += `<option value="${value.id}" ${value.id == sales ? 'selected' : ''}>${value.username} (${value.sales_id})</o ption>`;
                        // }
                        $(".idCompany").val(idCompany);
                        $(".company").val(company);
                        $(".sales").val(sales);
                        $(".pics").append(pic1);
                        $(".pic").append(picList);

                        $(".btn-pic").attr("disabled", false);
                    }
                });
            });
        });

        let piclist = '';
        $(".btn-new").click(function () {
            var namePIC = $('#name_pic').val(); 
            var dept = $('#phone_number_1').val(); 
            var phone = $('#phone_number_2').val(); 
            var email = $('#email').val(); 

            piclist += `<option value="99" selected>${namePIC} (${dept} / ${phone} / ${email})</option>`;

            $(".pic").append(piclist);

        });

            function myFunction(selTag) {
                var x = selTag.options[selTag.selectedIndex].text;
                document.getElementById("nama_product").innerHTML = x;
                name = x;
            }
            function prdoductRequest(userTag) {
                var x1 = userTag.options[userTag.selectedIndex].text;
                document.getElementById("request_to").innerHTML = x1;
                request1 = x1;  
            }
            function prdoductRequest1(userTag) {
                var x2 = userTag.options[userTag.selectedIndex].text;
                document.getElementById("request_to1").innerHTML = x2;
                lala = x2;
            }

            // data product
        $(document).ready(function () {

            $('#proyek1').select2();
            $('#users').select2();
            $('#users1').select2();

            let productIdx = 0;
            $("#addProduct").click(function () {
                var id = $('#proyek1').val();
                var name = $('#nama_product').text();
                var currency = $('#currency').val();
                var price = $('#product_price').val();
                var moq = $('#minimum_quantity_order').val();
                var oq = $('#order_quantity').val();
                var status = $('#status_product').val();
                var notes = $('#product_note').val();
                var request = $('#users').val();
                var request1 = $('#request_to').text();
                var request3 = $('#users1').val();
                var lala = $('#request_to1').text();
                var document = $('#document_note').val();
                var sample = $('#sample_note').val();
            
                var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                    "  <td class=\"text-left\">" + name + "<input type=\"hidden\" name = \"rows[" + productIdx + "][ids]\"value =" + id + "><input type=\"hidden\" name = \"rows[" + productIdx + "][rnd_flag]\" value =\"No\"></td>\n" +
                    "  <td class=\"text-center\">" + currency + "<input type=\"hidden\" name = \"rows[" + productIdx + "][currencys]\" value =" + currency + "><input type=\"hidden\" name = \"rows[" + productIdx + "][sample_flag]\" value =\"No\"></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(price)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][prices]\" value =" + price + "><input type=\"hidden\" name = \"rows[" + productIdx + "][shows]\" value =\"Y\"></td>\n" +
                    "  <td class=\"text-right\">" + moq + "<input type=\"hidden\" name = \"rows[" + productIdx + "][moqs]\" value =" + moq + "></td>\n" +
                    "  <td class=\"text-right\">" + oq + "<input type=\"hidden\" name = \"rows[" + productIdx + "][oqs]\" value =" + oq + "></td>\n" +
                    "  <td class=\"text-center\">" + status + "<textarea name = \"rows[" + productIdx + "][status]\" hidden>" + status + "</textarea></td>\n" +
                    "  <td class=\"text-left\">" + notes + "<textarea name = \"rows[" + productIdx + "][notes]\" hidden>" + notes + "</textarea></td>\n" +
                    "  <td class=\"text-center\">" + request1 + "<input type=\"hidden\" name = \"rows[" + productIdx + "][request]\" value =" + request + "></td>\n" +
                    "  <td class=\"text-left\">" + document + "<textarea name = \"rows[" + productIdx + "][document]\" hidden>" + document + "</textarea></td>\n" +
                    "  <td class=\"text-center\">" + lala + "<input type=\"hidden\" name = \"rows[" + productIdx + "][request1]\" value =" + request3 + "></td>\n" +
                    "  <td class=\"text-left\">" + sample + "<textarea name = \"rows[" + productIdx + "][sample]\" hidden>" + sample + "</textarea></td>\n" +
                    "   <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + null + ")\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
                "</tr>";

                if (name === '' || price === '' || currency === '') {
                    return false;
                }
                $("#tableProductAddBody").append(tr);
                function tableProductAddBody(tableProductAddBody) {
                    $('#tableProductAddBody').remove();
                }

                $('#proyek1').val(id);
                $('#nama_product').val(name);
                $('#currency').val(currency);
                $('#product_price').val('');
                $('#minimum_quantity_order').val('');
                $('#order_quantity').val('');
                $('#status_product').val('Promoting');
                $('#product_note').val('');
                $('#document_note').val('');
                $('#sample_note').val('');
                productIdx++;

                
            });
        });

        $('#start_date').on('change', function () {
            var sdate= new Date($(this).val());
            var edate= new Date($("#end_date").val());
            // alert(edate);

            if (edate < sdate) {
                alert('End date cannot be before start date!');
                document.getElementById('create_offer').disabled = true;
            } else {
                document.getElementById('create_offer').disabled = false;
            }
        });
    
        $('#end_date').on('change', function () {
            var edate= new Date($(this).val());
            var sdate= new Date($("#start_date").val());
                
            if (edate < sdate) {
                alert('End date cannot be before Start date!');
                document.getElementById('create_offer').disabled = true;
            } else {
                document.getElementById('create_offer').disabled = false;
            }
        });
    </script>
    @endsection
</x-app-layout>