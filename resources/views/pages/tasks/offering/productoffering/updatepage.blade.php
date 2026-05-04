<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Update Offering Product 📝</h1>
        </div>
        <form action="{{ route('update.offering', ['offeringId' => $dataOffering->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="px-5 py-4">
                <div class="space-y-3">
                    <input type="hidden" name="id_offering" value="{{$dataOffering->id}}"/>
                    <input type="hidden" name="offering_id" value="{{$dataOffering->id_offerings}}"/>
                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Company Name :<span
                            class="text-rose-500">*</span>
                            </label>
                            <input id="company" name="company"
                                class="company form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                type="text" value="{{$dataOffering->company_id}}" readonly required />
                        </div>
                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="pic">PIC :<span
                            class="text-rose-500">*</span>
                            </label>
                            <input id="pic" name="pic"
                            class="pic form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                            type="text" value="{{$dataOffering->name}}" readonly required />
                            <input id="pics" name="pics"
                            class="pics form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                            type="text" value="{{$dataOffering->pic}}" hidden readonly required />
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
                                                    type="number" value="0"/>
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
                                                    <option class="" value="">Select User</option>
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
                                                    <option class="" value="">Select User</option>
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
                            <table id="tableProductAddBody" class="tableProductAddBody table table-striped table-bordered mt-3"
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
                            <select class="offeringTag w-full form-select md:w-1/2" id="offeringTag" name="offeringTag">
                                <option selected disabled hidden>Select Here</option>
                                @foreach ($offeringTags as $offeringTag)
                                <option value="{{ $offeringTag->id }}"{{ $offeringTag->id == $dataOffering->id_offering_color ? ' selected' : '' }}>{{ $offeringTag->color_tag }}
                                </option>
                                @endforeach
                            </select>
                        </div>  
                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name">Start Date :<span
                                class="text-rose-500">*</span></label>
                            <input id="start_date" name="start_date" class="start_date form-input px-2 py-1"
                                type="datetime-local" value="{{$dataOffering->start_time}}" required />
                        </div>
                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name">End Date :<span
                                class="text-rose-500">*</span></label>
                            <input id="end_date" name="end_date" class="end_date form-input px-2 py-1"
                                type="datetime-local" value="{{$dataOffering->end_time}}" required />
                        </div>
                        <div class="flex flex-col justify-between md:flex-row ml-5 mb-3">
                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes">Note :
                           <span class="text-rose-500">*</span></label>
                            <textarea id="notes" name="notes" class="notes form-input w-full md:w-3/4 px-2 py-1"
                                rows="3" required>{{$dataOffering->notes}}</textarea>
                        </div>
                        <div class="flex flex-col justify-between md:flex-row ml-5 mb-3">
                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notulens">Meeting Result :
                           <span class="text-rose-500">*</span></label>
                            <textarea id="notulens" name="notulens" class="notulens form-input w-full md:w-3/4 px-2 py-1"
                                rows="3" required>{{$dataOffering->notulens}}</textarea>
                        </div>

                        <div class="space-y-3">
                        </div>
                </div>
                @if ($dataOffering->add_by == Auth::user()->id)
                    <div class="flex flex-row justify-center">
                        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5 mr-5" type="submit" id="create_offer">
                            <span class="xs:block ml-5 mr-5">Update Offering Product</span>
                        </button> 
            </form>
                        <div x-data="{ modalOpen: false }">
                            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="button"
                                @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                    <path
                                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                </svg>
                                <span class="xl:block ml-5 mr-5">Add To Project Proposal</span>
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
                                            <div class="font-semibold text-slate-800">Add To Project Proposal</div>
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
                                        <form action="{{ route('offering.addproject') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id_offering" value="{{$dataOffering->id}}"/>
                                            <input type="hidden" name="offering_id" value="{{$dataOffering->id_offerings}}"/>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Company Name :<span
                                                class="text-rose-500">*</span>
                                                </label>
                                                <input id="company1" name="company1"
                                                    class="company1 form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                    type="text" value="{{$dataOffering->company_id}}" readonly required />
                                                <input id="companyId" name="companyId"
                                                    class="companyId form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                    type="text" value="{{$dataOffering->com_id}}" readonly required hidden/>
                                            </div>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="pic">Company PIC :<span
                                                class="text-rose-500">*</span>
                                                </label>
                                                <input id="pic1" name="pic1"
                                                class="pic1 form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                type="text" value="{{$dataOffering->name}}" readonly required />
                                                <input id="pics1" name="pics1"
                                                class="pics1 form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                type="text" value="{{$dataOffering->pic}}" hidden readonly required />
                                            </div>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name">Project Name :
                                                </label>
                                                <input id="name" name="name"
                                                    class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                                    required />
                                            </div>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="description">Proposal
                                                    Description :
                                                </label>
                                                <textarea id="description" name="description"
                                                    class="description form-input w-full md:w-3/4 px-2 py-1" rows="3">{{$dataOffering->notes}}</textarea>
                                            </div>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block text-sm font-medium mb-1" for="task_id">Product Offered :
                                                </label>
                                            </div>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <table id="tableAddProject" class="tableAddProject table table-striped table-bordered mt-3"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-sm text-center">Check</th>
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
                                                    <tbody class="tableAddProject" id="tableAddProject">
                    
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
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
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="status">Status :
                                                </label>
                                                <select id="status" name="status" class="status form-select w-full md:w-3/4 px-2 py-1" required>
                                                    <option selected value="1">Open</option>
                                                    <option value="0">Pending</option>
                                                    <option value="2">Lost</option>
                                                    <option value="3">Won</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Date :
                                                </label>
                                                <input id="date" name="date" class="date form-input px-2 py-1" type="date" value="{{ date('Y-m-d', strtotime($dataOffering->end_time)) }}" required/>
                                            </div>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes">Proposal
                                                    Note :
                                                </label>
                                                <textarea id="notes1" name="notes1" class="notes1 form-input w-full md:w-3/4 px-2 py-1"
                                                    rows="3">{{$dataOffering->notulens}}</textarea>
                                            </div>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Attachment
                                                    Upload
                                                    (PDF) :
                                                </label>
                                                <input id="file" name="file" class="form-input w-full md:w-3/4 px-2 py-1" type="file"
                                                    accept="application/pdf" />
                                            </div>

                                            <div class="space-y-3">
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="px-5 py-4 border-t border-slate-200">
                                                <div class="flex flex-wrap justify-end space-x-2">
                                                    <button type="button"
                                                        class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                        @click="modalOpen = false">Close</button>
                                                    <button type="submit"
                                                        class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                        id="addProposal">Add To Project Proposal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
    </div>

    @section('js-page')
    <script>
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

        $(document).ready(function () {

         $('#proyek1').select2();  
         $('#users').select2(); 
         $('#users1').select2();

            $("#addProduct").click(function () {
                var id = $('#proyek1').val();
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

                var tr = " <tr id=\"row-" + productIdx + "\">\n" +
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
                    "   <td class=\"text-center\">" + "<button onclick=\"deleteDataProduct(" + productIdx + "," + null + ")\" class=\"btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + " </td>"
                "</tr>";

                if (name === '' || price === '' || currency === '') {
                    return false;
                }

                $(".tableProductAddBody").find('tbody').append(tr);

                $('#id_product').val('');
                $('#currency').val('Set Currency');
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
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataOfferingProducts?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {
            var iden = makeid(3);
            // console.log(String(value.product_id).length);
            // const dataProducts = <?=$dataOfferingProducts?>;
            const datahistories = <?=$dataOfferingProducts?>;
            var tbl_modal = '';
            $.each(datahistories, function (i,item) {
                if(value.product_id == item.product_id){
                    tbl_modal += `<tr>
                        <td class="text-center" hidden><input type="text" name="lili" value="${item.product_id}" hidden/>${item.product_id}</td>
                        <td class="text-center">${item.product_code} </td>
                        <td class="text-left">${item.product_name} </td>
                        <td class="text-center">${item.m_currency}</td>
                        <td class="text-right">${item.price}</td>
                        <td class="text-right">${item.moqty}</td>
                        <td class="text-right">${item.qty}</td>
                        <td class="text-left">${item.status}</td>
                        <td class="text-left">${item.notes}</td>
                        <td class="text-left">${item.notes_document}</td>
                        <td class="text-left">${item.notes_sample}</td>
                        <td hidden>${item.id_offerings}</td>
                    </tr>`
                }
                // console.log(item)
            })

            const prods = <?=$dataOfferingProducts?>;
            var modal_content = '';
            $.each(prods, function (i,item1) {
                if(value.product_id == item1.product_id){
                    modal_content += `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="currency2">Currency :
                                                </label>
                                                <select id="currency2_${iden}" name="currency2"
                                                    class="currency2 form-select w-full md:w-3/4 px-2 py-1">
                                                    <option selected hidden>Set Currency</option>
                                                    <option value="AUD" ${value.m_currency == "AUD" ? ' selected' : '' }>AUD</option>
                                                    <option value="EUR" ${value.m_currency == "EUR" ? ' selected' : '' }>EUR</option>
                                                    <option value="GBP" ${value.m_currency == "GBP" ? ' selected' : '' }>GBP</option>
                                                    <option value="IDR" ${value.m_currency == "IDR" ? ' selected' : '' }>IDR</option>
                                                    <option value="JPY" ${value.m_currency == "JPY" ? ' selected' : '' }>JPY</option>
                                                    <option value="SGD" ${value.m_currency == "SGD" ? ' selected' : '' }>SGD</option>
                                                    <option value="USD" ${value.m_currency == "USD" ? ' selected' : '' }>USD</option>
                                                </select>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="product_price2">Product Price :
                                                </label>
                                                <input id="product_price2_${iden}" name="product_price2"
                                                    class="product_price2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="number" value="${value.price}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="minimum_quantity_order2">Minimum Order Qty :
                                                </label>
                                                <input id="minimum_quantity_order2_${iden}" name="minimum_quantity_order2"
                                                    class="minimum_quantity_order2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="number" value="${value.moqty}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="order_quantity2">Order Qty :
                                                </label>
                                                <input id="order_quantity2_${iden}" name="order_quantity2"
                                                    class="order_quantity2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="number" value="${value.qty}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="status_product2">Status :
                                                </label>
                                                <select id="status_product2_${iden}" name="status_product2" class="status_product2 form-select w-full md:w-3/4 px-2 py-1">
                                                    <option selected value="Promoting" ${value.status == "Promoting" ? ' selected' : '' }>Promoting</option>
                                                    <option value="Offering" ${value.status == "Offering" ? ' selected' : '' }>Offering</option>
                                                    <option value="Request Document" ${value.status == "Request Document" ? ' selected' : '' }>Request Document</option>
                                                    <option value="Won" ${value.status == "Won" ? ' selected' : '' }>Won</option>
                                                    <option value="Pending" ${value.status == "Pending" ? ' selected' : '' }>Pending</option>
                                                    <option value="Lost" ${value.status == "Lost" ? ' selected' : '' }>Lost</option>
                                                    <option value="Deleted" ${value.status == "Deleted" ? ' selected' : '' }>Deleted</option>
                                                </select>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="document_note2">Notes Document :
                                                </label>
                                                <textarea id="document_note2_${iden}" name="document_note2"
                                                    class="document_note2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" rows="2">${value.notes_document}</textarea>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="sample_note2">Notes Sample :
                                                </label>
                                                <textarea id="sample_note2_${iden}" name="sample_note2"
                                                    class="sample_note2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" rows="2">${value.notes_sample}</textarea>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="product_note2">Notes :
                                                </label>
                                                <textarea id="product_note2_${iden}" name="product_note2"
                                                    class="product_note2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" rows="2">${value.notes}</textarea>
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
                // console.log(item)
            })

            console.log(tbl_modal);
            tableRow += `<tr id=row1-productIdx>
                            <td><input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="ids_${iden}" value="${value.product_id}" hidden/> <input type="text" name="offer_${iden}" value="${value.id_offerings}" hidden/>${value.product_name}</td>
                            <td class="text-center"><input type="text" name="m_currency_${iden}" id="m_currency_${iden}" value="${value.m_currency}" hidden/> <input type="text" name="rnd_user_${iden}" id="rnd_user_${iden}" value="${value.rnd_user_id}" hidden/><span id="m_currency_text_${iden}">${value.m_currency}</span></td>
                            <td class="text-right"><input type="text" name="price_${iden}" id="price_${iden}" value="${value.price}" hidden/> <input type="text" name="rnd_flag_${iden}" id="rnd_flag_${iden}" value="${value.rnd_flag}" hidden/><span id="price_text_${iden}">${value.price}</span></td>
                            <td class="text-right"><input type="text" name="moqty_${iden}" id="moqty_${iden}" value="${value.moqty}" hidden/> <input type="datetime-local" name="document_date_${iden}" id="document_date_${iden}" value="${value.document_date}" hidden/><span id="moqty_text_${iden}">${value.moqty}</span></td>
                            <td class="text-right"><input type="text" name="qty_${iden}" id="qty_${iden}" value="${value.qty}" hidden/> <input type="text" name="document_sent_by_${iden}" id="document_sent_by_${iden}" value="${value.document_sent_by}" hidden/><span id="qty_text_${iden}">${value.qty}</span></td>
                            <td class="text-center"><input type="text" name="status_${iden}" id="status_${iden}" value="${value.status}" hidden/> <input type="text" name="sample_user_id_${iden}" id="sample_user_id_${iden}" value="${value.sample_user_id}" hidden/><span id="status_text_${iden}">${value.status}</span></td>
                            <td class="text-left"><input type="text" name="notes_${iden}" id="notes_${iden}" value="${value.notes}" hidden/> <input type="text" name="flag_sample_${iden}" id="flag_sample_${iden}" value="${value.flag_sample}" hidden/><span id="notes_text_${iden}">${value.notes}</span></td>
                            <td class="text-center"><input type="text" name="doc_${iden}" id="doc_${iden}" value="" hidden/> <input type="text" name="sample_delivery_date_${iden}" id="sample_delivery_date_${iden}" value="${value.sample_delivery_date}" hidden/><span id="username_text_${iden}">${value.username}</span></td>
                            <td class="text-left"><input type="text" name="notes2_${iden}"id="notes2_${iden}" value="${value.notes_document}" hidden/> <input type="text" name="sample_delivery_reff_${iden}" id="sample_delivery_reff_${iden}" value="${value.sample_delivery_reff}" hidden/><span id="notes2_text_${iden}">${value.notes_document}</span></td>
                            <td class="text-center"><input type="text" name="sample_${iden}" id="sample_${iden}" value="" hidden/><input type="text" name="img_1_${iden}" id="img_1_${iden}" value="${value.img_1}" hidden/>${value.sample}</td>
                            <td class="text-left"><input type="text" name="notes3_${iden}" id="notes3_${iden}" value="${value.notes_sample}" hidden/><input type="text" name="img_2_${iden}" id="img_2_${iden}" value="${value.img_2}" hidden/><input type="text" name="show_product_${iden}" id="show_product_${iden}" value="${value.show_product}" hidden/><span id="notes3_text_${iden}">${value.notes_sample}</span></td>
                            <td class="block mx-auto flex flex-row mt-2">
                <button type="button" onclick="deleteDataProduct(productIdx,${value.id})" class="btn border-slate-200 hover:border-slate-300" > <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/></svg></button>
                
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
                                                <div class="font-semibold text-slate-800">Update Product Offering</div>
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

                <div x-data="{ modalOpen: false }">
                    <button type="button" class="btn bg-purple-500 hover:bg-purple-600 text-white ml-3" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>file text</title><g stroke-width="1" stroke-linecap="round" stroke="#ffff" stroke-miterlimit="10" fill="none" class="nc-icon-wrapper w-4 h-4" stroke-linejoin="round"><line x1="4.5" y1="11.5" x2="11.5" y2="11.5" stroke="#ffff"></line> 
                            <line x1="4.5" y1="8.5" x2="11.5" y2="8.5" stroke="#ffff"></line> <line x1="4.5" y1="5.5" x2="6.5" y2="5.5" stroke="#ffff"></line> <polygon points="9.5,0.5 1.5,0.5 1.5,15.5 14.5,15.5 14.5,5.5 "></polygon> <polyline points="9.5,0.5 9.5,5.5 14.5,5.5 "></polyline></g>
                        </svg></button>
                            <!-- Modal backdrop -->
                            <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
                                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true"
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
                                    @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                    <!-- Modal header -->
                                    <div class="px-5 py-3 border-b border-slate-200">
                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-slate-800">Product History</div>
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
                                            <table id="proyek1" class="table table-striped table-bordered text-xs"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" hidden>Product ID</th>
                                                        <th class="text-center">Code Product</th>
                                                        <th class="text-center">Product Name</th>
                                                        <th class="text-center">Currency</th>
                                                        <th class="text-center">Price</th>
                                                        <th class="text-center">Minimum Order Quantity</th>
                                                        <th class="text-center">Order Quantity</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Notes</th>
                                                        <th class="text-center">Notes Document</th>
                                                        <th class="text-center">Notes Sample</th>
                                                        <th class="text-center" hidden>Project ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   `+tbl_modal+`
                                                </tbody>
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
                </td>
                                        </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);

        function updateDataProduct(iden) {
            var currency = $('#currency2_'+iden).val();
            $('#m_currency_'+iden).val(currency);
            $('#m_currency_text_'+iden).text(currency);

            var price = $('#product_price2_'+iden).val();
            $('#price_'+iden).val(price);
            $('#price_text_'+iden).text(price);

            var moq = $('#minimum_quantity_order2_'+iden).val();
            $('#moqty_'+iden).val(moq);
            $('#moqty_text_'+iden).text(moq);

            var oq = $('#order_quantity2_'+iden).val();
            $('#qty_'+iden).val(oq);
            $('#qty_text_'+iden).text(oq);

            var status = $('#status_product2_'+iden).val();
            $('#status_'+iden).val(status);
            $('#status_text_'+iden).text(status);

            var document = $('#document_note2_'+iden).val();
            $('#notes2_'+iden).val(document);
            $('#notes2_text_'+iden).text(document);

            var sample = $('#sample_note2_'+iden).val();
            $('#notes3_'+iden).val(sample);
            $('#notes3_text_'+iden).text(sample);
            
            var notes = $('#product_note2_'+iden).val();
            $('#notes_'+iden).val(notes);
            $('#notes_text_'+iden).text(notes);
            console.log(iden,currency,price,moq,oq,status,document,sample,notes);
            console.log($('#m_currency_'+iden))
            console.log($('#m_currency_'+iden).val())

            
        }

        function deleteDataProduct(positionTableRow, dataFromDatabase) {
            const positionTableRowVariable = positionTableRow
            const dataFromDatabaseVariable = dataFromDatabase
            const csrf_token = $('meta[name="csrf-token"]').attr('content');

            if (dataFromDatabaseVariable !== null) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to change Status Product to Deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: `/tasks/offering/productoffering/deleteproduct/${dataFromDatabaseVariable}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your product status is deleted.',
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

            } else if (dataFromDatabaseVariable === null) {

                $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();

            }

            console.info('positionTableRowVariable: ', positionTableRowVariable)
            console.info('dataFromDatabaseVariable: ', dataFromDatabaseVariable)
        }

        function makeid(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
        
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProductsProject =  <?=$dataOfferingProducts?>;
        let tableRowProject = '';
        
        for (const value1 of dataProductsProject) {
            var idens = makeid(3);

            const prods1 = <?=$dataOfferingProducts?>;
            var modal_content1 = '';
            $.each(prods1, function (i,item2) {
                if(value1.product_id == item2.product_id){
                    modal_content1 += `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="currency3">Currency :
                                                </label>
                                                <select id="currency3_${idens}" name="currency3"
                                                    class="currency3 form-select w-full md:w-3/4 px-2 py-1">
                                                    <option selected hidden>Set Currency</option>
                                                    <option value="AUD" ${value1.m_currency == "AUD" ? ' selected' : '' }>AUD</option>
                                                    <option value="EUR" ${value1.m_currency == "EUR" ? ' selected' : '' }>EUR</option>
                                                    <option value="GBP" ${value1.m_currency == "GBP" ? ' selected' : '' }>GBP</option>
                                                    <option value="IDR" ${value1.m_currency == "IDR" ? ' selected' : '' }>IDR</option>
                                                    <option value="JPY" ${value1.m_currency == "JPY" ? ' selected' : '' }>JPY</option>
                                                    <option value="SGD" ${value1.m_currency == "SGD" ? ' selected' : '' }>SGD</option>
                                                    <option value="USD" ${value1.m_currency == "USD" ? ' selected' : '' }>USD</option>
                                                </select>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="product_price3">Product Price :
                                                </label>
                                                <input id="product_price3_${idens}" name="product_price3"
                                                    class="product_price3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="number" value="${value1.price}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="minimum_quantity_order3">Minimum Order Qty :
                                                </label>
                                                <input id="minimum_quantity_order3_${idens}" name="minimum_quantity_order3"
                                                    class="minimum_quantity_order3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="number" value="${value1.moqty}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="order_quantity3">Order Qty :
                                                </label>
                                                <input id="order_quantity3_${idens}" name="order_quantity3"
                                                    class="order_quantity3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="number" value="${value1.qty}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="status_product3">Status :
                                                </label>
                                                <select id="status_product3_${idens}" name="status_product3" class="status_product3 form-select w-full md:w-3/4 px-2 py-1">
                                                    <option selected value="Promoting" ${value1.status == "Promoting" ? ' selected' : '' }>Promoting</option>
                                                    <option value="Offering" ${value1.status == "Offering" ? ' selected' : '' }>Offering</option>
                                                    <option value="Request Document" ${value1.status == "Request Document" ? ' selected' : '' }>Request Document</option>
                                                    <option value="Won" ${value1.status == "Won" ? ' selected' : '' }>Won</option>
                                                    <option value="Pending" ${value1.status == "Pending" ? ' selected' : '' }>Pending</option>
                                                    <option value="Lost" ${value1.status == "Lost" ? ' selected' : '' }>Lost</option>
                                                    <option value="Deleted" ${value1.status == "Deleted" ? ' selected' : '' }>Deleted</option>
                                                </select>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="product_note3">Notes :
                                                </label>
                                                <textarea id="product_note3_${idens}" name="product_note3"
                                                    class="product_note3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" rows="2">${value1.notes}</textarea>
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
                                                        @click="modalOpen = false" onclick="updateDataProduct1('${idens}')">Update</button>
                                                </div>
                                            </div>
                                        </div>`
                }
            })

            tableRowProject += `<tr id=row1-productIdx>
                            <td class="text-center"><input class="mt-1" type="checkbox" id="check_${idens}" name="check_${idens}" value="1"/></td>
                            <td><input type="text" name="idens[]" value="${idens}" hidden/><input type="text" name="ids1_${idens}" value="${value1.product_id}" hidden/><input type="text" name="ids2" value="${value1.product_id}" hidden/>${value1.product_name}</td>
                            <td class="text-center"><input type="text" name="m_currency1_${idens}" id="m_currency1_${idens}" value="${value1.m_currency}" hidden/><span id="m_currency1_text_${idens}">${value1.m_currency}</span></td>
                            <td class="text-right"><input type="text" name="price1_${idens}" id="price1_${idens}" value="${value1.price}" hidden/><span id="price1_text_${idens}">${value1.price}</span></td>
                            <td class="text-right"><input type="text" name="moqty1_${idens}" id="moqty1_${idens}" value="${value1.moqty}" hidden/><span id="moqty1_text_${idens}">${value1.moqty}</span></td>
                            <td class="text-right"><input type="text" name="qty1_${idens}" id="qty1_${idens}" value="${value1.qty}" hidden/><span id="qty1_text_${idens}">${value1.qty}</span></td>
                            <td class="text-center"><input type="text" name="status1_${idens}" id="status1_${idens}" value="${value1.status}" hidden/><span id="status1_text_${idens}">${value1.status}</span></td>
                            <td class="text-left"><input type="text" name="notes1_${idens}" id="notes1_${idens}" value="${value1.notes}" hidden/><span id="notes1_text_${idens}">${value1.notes}</span></td>
                            <td class="block text-center justify-center flex flex-row">
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
                                                <div class="font-semibold text-slate-800">Update Product Offering</div>
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
                                        `+modal_content1+`
                                    </div>
                                </div>
                        </div>    
                                </td>
                                        </tr>`;
        }
        $(".tableAddProject").find('tbody').append(tableRowProject);

        function updateDataProduct1(idens) {
            var currency1 = $('#currency3_'+idens).val();
            $('#m_currency1_'+idens).val(currency1);
            $('#m_currency1_text_'+idens).text(currency1);

            var price1 = $('#product_price3_'+idens).val();
            $('#price1_'+idens).val(price1);
            $('#price1_text_'+idens).text(price1);

            var moq1 = $('#minimum_quantity_order3_'+idens).val();
            $('#moqty1_'+idens).val(moq1);
            $('#moqty1_text_'+idens).text(moq1);

            var oq1 = $('#order_quantity3_'+idens).val();
            $('#qty1_'+idens).val(oq1);
            $('#qty1_text_'+idens).text(oq1);

            var status1 = $('#status_product3_'+idens).val();
            $('#status1_'+idens).val(status1);
            $('#status1_text_'+idens).text(status1);
            
            var notes1 = $('#product_note3_'+idens).val();
            $('#notes1_'+idens).val(notes1);
            $('#notes1_text_'+idens).text(notes1);
            console.log(idens,currency1,price1,moq1,oq1,status1,notes1);
            console.log($('#m_currency1_'+idens))
            console.log($('#m_currency1_'+idens).val())   
        }
        
    </script>
    @endsection
</x-app-layout>