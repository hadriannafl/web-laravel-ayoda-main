<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Create New Project Proposal 📝</h1>
        </div>

        <form action="{{ route('proyek-single.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="border-t border-slate-200">

                <!-- Components -->
                <div class="space-y-8">

                    <!-- Input Types -->
                    <div class="px-5 py-4">
                        <div class="space-y-3">
                            <div class="flex flex-col md:flex-row">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Company Name
                                    :
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
                            <div class="flex flex-col md:flex-row">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="pic">Company PIC :
                                </label>
                                <select class="pic form-select md:w-1/2" id="pic" name="pic" required>
                                    <option></option>
                                </select>
                                <button id="btn-pic" type="button"
                                class="ml-2 btn btn-pic bg-indigo-500 hover:bg-indigo-600 text-white">
                                    <a href="{{ route('proyek-single.pic') }}">
                                            <svg class="w-4 h-4 fill-current  text-slate-200" viewBox="0 0 16 16">
                                                <path
                                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                            </svg>
                                        <span></span>
                                    </a>
                                </button>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name">Project :
                                </label>
                                <input id="name" name="name"
                                    class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                    required />
                            </div>
                            <div class="flex justify-between flex-col md:flex-row">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="description">Proposal
                                    Description :
                                </label>
                                <textarea id="description" name="description"
                                    class="description form-input w-full md:w-3/4 px-2 py-1" rows="3"></textarea>
                            </div>
                            <div class="flex flex-row md:flex-row">
                                <label class="block text-sm font-medium mb-1" for="task_id">Product Offered :
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
                                            @click.outside="modalOpen = false"
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
                                                    <input id="nama_product" name="nama_product"
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
                                                                        <div class="font-semibold text-slate-800">Search
                                                                            Product</div>
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
                                                                        <table id="proyek1"
                                                                            class="table table-striped table-bordered text-xs"
                                                                            style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">Product Code
                                                                                    </th>
                                                                                    <th class="text-center">Product Name
                                                                                    </th>
                                                                                    <th class="text-center">Unit</th>
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
                                                    <input id="productId" name="productId"
                                                        class="productId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" readonly required hidden />
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
                                                        type="number" value="0"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="status_product">Status :
                                                    </label>
                                                    <select id="status_product" name="status_product" class="status_product form-select w-full md:w-3/4 px-2 py-1">
                                                        <option selected value="Open">Open</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Lost">Lost</option>
                                                        <option value="Won">Won</option>
                                                    </select>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="product_note">Notes :
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
                                            <th class="text-sm text-center">Notes</th>
                                            <th class="text-sm text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableProductAddBody" id="tableProductAddBody">

                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="actions">Project
                                    Stage :
                                </label>
                                <select id="actions" name="actions"
                                    class="actions form-select w-full md:w-3/4 px-2 py-1" required>
                                    <option value="" selected hidden>Select Stage</option>
                                    <option value="1">1. Documentation / Sampling or Quotation</option>
                                    <option value="2">2. Formulation In Progress</option>
                                    <option value="3">3. Stable Formula & Pending Approval</option>
                                    <option value="4">4. Pilot</option>
                                    <option value="5">5. Marketing Approved</option>
                                    <option value="6">6. Industrial Batches</option>
                                    <option value="7">7. Launching</option>
                                </select>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="status">Status :
                                </label>
                                <select id="status" name="status" class="status form-select w-full md:w-3/4 px-2 py-1" required>
                                    <option selected value="1">Open</option>
                                    <option value="0">Pending</option>
                                    <option value="2">Lost</option>
                                    <option value="3">Won</option>
                                </select>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Date :
                                </label>
                                <input id="date" name="date" class="date form-input px-2 py-1" type="date" required/>
                            </div>
                            <div class="flex flex-col justify-between md:flex-row">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes">Proposal
                                    Note :
                                </label>
                                <textarea id="notes" name="notes" class="notes form-input w-full md:w-3/4 px-2 py-1"
                                    rows="3"></textarea>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Attachment
                                    Upload
                                    (PDF) :
                                </label>
                                <input id="file" name="file" class="form-input w-full md:w-3/4 px-2 py-1" type="file"
                                    accept="application/pdf" />
                            </div>
                            <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit">
                                    <span class="xs:block ml-5 mr-5">Create Proposal</span>
                                </button> </center>
                            <div class="space-y-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @section('js-page')
    <script>
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
                    url: "{{ route('create-single.getcompany') }}"
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

                $.ajax({
                    type: "GET",
                    url: `/tasks/proyek/proyek-single/selectcompany/${idCompany}`,
                    success: function (response) {
                        let picList = '';
                        for (const value of response.listCompanyPic) {
                            picList += `<option value="${value.id}" ${value.id == pic ? 'selected' : ''}>${value.name} (${value.phone_number_1} / ${value.phone_number_2} / ${value.email})</option>`;
                        }
                        // let salesList = '';
                        // for (const value of response.salesList) {
                        //     salesList += `<option value="${value.id}" ${value.id == sales ? 'selected' : ''}>${value.username} (${value.sales_id})</o ption>`;
                        // }
                        $(".idCompany").val(idCompany);
                        $(".company").val(company);
                        $(".sales").val(sales);
                        $(".pic").append(picList);

                        $(".btn-pic").attr("disabled", false);
                    }
                });
            });
        });

        let tableRow = '';
        let productIdx = 0;
        
        for (const value of tableRow) {
            console.info(value)
            tableRow += "<tr id=\"row-" + productIdx + "\">\n" +
                    "                                    <td class=\"text-left\">" + name + "<input type=\"hidden\" name = \"rows[" + productIdx + "][ids]\"value =" + id + "></td>\n" +
                    "                                    <td class=\"text-center\">" + currency + "<input type=\"hidden\" name = \"rows[" + productIdx + "][currencys]\" value =" + currency + "></td>\n" +
                    "                                    <td class=\"text-right\">" + `${divider(price)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][prices]\" value =" + price + "></td>\n" +
                    "                                    <td class=\"text-center\">" + moq + "<input type=\"hidden\" name = \"rows[" + productIdx + "][moqs]\" value =" + moq + "></td>\n" +
                    "                                    <td class=\"text-center\">" + oq + "<input type=\"hidden\" name = \"rows[" + productIdx + "][oqs]\" value =" + oq + "></td>\n" +
                    "                                    <td class=\"text-center\">" + status + "<input type=\"hidden\" name = \"rows[" + productIdx + "][status]\" value =" + status + "></td>\n" +
                    "                                    <td class=\"text-center\">" + notes + "<input type=\"hidden\" name = \"rows[" + productIdx + "][notes]\" value =" + notes + "></td>\n" +
                "   <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + value.id + ")\" class=\"btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + " </td>"
            "</tr>";
            productIdx++;

        }
        $("#tableProductAddBody").append(tableRow);

        function deleteDataProduct(positionTableRow, dataFromDatabase) {
            const positionTableRowVariable = positionTableRow

                $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();

            console.info('positionTableRowVariable: ', positionTableRowVariable)
        }

        // data product
        $(document).ready(function () {
            $('#proyek1').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                language: {
                    search: "Search Product Name: "
                },
                ajax: {
                    url: "{{ route('create-single.getproduct') }}"
                },
                columns: [
                    {
                        data: "code",
                        name: "code"
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
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 2, 3] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $('#proyek1').on("click", ".btn-select", function () {
                const productId = $(this).data("id_product");
                const name = $(this).data("nama_product");


                $(".productId").val(productId);
                $(".nama_product").val(name);
            });

            let productIdx = 0;
            $("#addProduct").click(function () {
                var id = $('#productId').val();
                var name = $('#nama_product').val();
                var currency = $('#currency').val();
                var price = $('#product_price').val();
                var moq = $('#minimum_quantity_order').val();
                var oq = $('#order_quantity').val();
                var status = $('#status_product').val();
                var notes = $('#product_note').val();

                var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                    "                                    <td class=\"text-left\">" + name + "<input type=\"hidden\" name = \"rows[" + productIdx + "][ids]\"value =" + id + "></td>\n" +
                    "                                    <td class=\"text-center\">" + currency + "<input type=\"hidden\" name = \"rows[" + productIdx + "][currencys]\" value =" + currency + "></td>\n" +
                    "                                    <td class=\"text-right\">" + `${divider(price)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][prices]\" value =" + price + "></td>\n" +
                    "                                    <td class=\"text-center\">" + moq + "<input type=\"hidden\" name = \"rows[" + productIdx + "][moqs]\" value =" + moq + "></td>\n" +
                    "                                    <td class=\"text-center\">" + oq + "<input type=\"hidden\" name = \"rows[" + productIdx + "][oqs]\" value =" + oq + "></td>\n" +
                    "                                    <td class=\"text-center\">" + status + "<input type=\"hidden\" name = \"rows[" + productIdx + "][status]\" value =" + status + "></td>\n" +
                    "                                    <td class=\"text-center\">" + notes + "<input type=\"hidden\" name = \"rows[" + productIdx + "][notes]\" value =" + notes + "></td>\n" +
                    "   <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + null + ")\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + " </td>"
                "                                </tr>";

                if (name === '' || price === '' || currency === '' || moq === '' || oq === '') {
                    return false;
                }
                
                $("#tableProductAddBody").append(tr);
                function tableProductAddBody(tableProductAddBody) {
                    $('#tableProductAddBody').remove();
                }

                $('#productId').val('');
                $('#nama_product').val('');
                $('#currency').val('');
                $('#product_price').val('');
                $('#minimum_quantity_order').val('');
                $('#order_quantity').val('');
                $('#status_product').val('');
                $('#product_note').val('');
                productIdx++;
            });

        });

    </script>
    @endsection
</x-app-layout>