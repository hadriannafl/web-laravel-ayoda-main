<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit RAB Request 📝</h1>
        </div>
        <form action="{{ route('rab-list.update', ['rabId' => $dataRab->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">RAB # / Form Date / Period</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->id_rab}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataRab->form_date))}}" readonly>
                        </div>
                        <div>
                            <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('F Y', strtotime($dataRab->date_rab))}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">RAB Title / RAB Type / Company</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="rabName" name="rabName" class="form-input w-full px-2 py-1 read-only:bg-slate-200" minlength="10" maxlength="300" type="text" value="{{$dataRab->name_rab}}" required/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <select id="rabType" name="rabType" class="rabType form-select w-full px-2 py-1" required>
                                <option value="Advance Payment To Site" {{$dataRab->rab_type == 'Advance Payment To Site' ? 'selected':''}}>Advance Payment To Site</option>
                                <option value="Monthly" {{$dataRab->rab_type == 'Monthly' ? 'selected':''}}>Monthly</option>
                                <option value="Monthly Additional" {{$dataRab->rab_type == 'Monthly Additional' ? 'selected':''}}>Monthly Additional</option>
                                <option value="Project" {{$dataRab->rab_type == 'Project' ? 'selected':''}}>Project</option>
                                <option value="Project Additional" {{$dataRab->rab_type == 'Project Additional' ? 'selected':''}}>Project Additional</option>
                            </select>
                        </div>
                        <div>
                            <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->name}}" readonly/>
                            <input id="company" name="company"
                            class="company form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" 
                            value="{{$dataRab->id_company}}" readonly hidden/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3" id="benef" {{$dataRab->rab_type == 'Advance Payment To Site' ? '':'hidden'}}>
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Bank / Account / Name<span
                        class="text-rose-500">*</span></label>
                        <div>
                            <select style="width: 20.8rem; margin-right: 20px;" id="bank" name="bank" class="bank form-select w-full px-2 py-1">
                                <option value="" hidden>Select Bank</option>
                                @foreach ($bank as $bankir )
                                    <option value="{{$bankir->name}}" {{$dataRab->beneficiary_bank == $bankir->name ? 'selected' : ''}}>{{$bankir->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="number" name="number" class="number form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->beneficiary_acc}}" type="text" placeholder="Beneficiary Account"/>
                        </div>
                        <div>
                            <input id="account" name="account" style="width: 21.2rem;" class="account form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->beneficiary_name}}" type="text" placeholder="Beneficiary Account Name"/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Department / Created By / Approval Status</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->dept}}" type="text" readonly/>
                            <input id="department" name="department" value="{{$dataRab->division}}"
                            class="department form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden required readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->username}}" readonly>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->approvalstat}}" readonly/>
                        </div>
                </div>
                @if ($dataRab->remarks1 != null)
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1" for="remarks1">Remarks 1</label>
                    <textarea id="remarks1" name="remarks1" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataRab->remarks1}}</textarea>
                </div>
                @endif
                @if ($dataRab->remarks2 != null)
                <div>
                    <label class="block text-sm font-medium mb-1" for="remarks2">Remarks 2</label>
                    <textarea id="remarks2" name="remarks2" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataRab->remarks2}}</textarea>
                </div>
                @endif
                @if ($dataRab->remarks3 != null)
                <div>
                    <label class="block text-sm font-medium mb-1" for="remarks3">Remarks 3</label>
                    <textarea id="remarks3" name="remarks3" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataRab->remarks3}}</textarea>
                </div>
                @endif
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="text-sm font-medium mb-1 mt-1" for="task_id">Add RAB Item
                    </label>
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal" id="tambahItem">
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
                                        <div class="font-semibold text-slate-800">Add RAB Item</div>
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
                                            for="rabCalcType">Type<span
                                            class="text-rose-500">*</span>
                                        </label>
                                            <select id="rab_calc_type" name="rab_calc_type"
                                                class="rab_calc_type form-input w-full md:w-3/4 px-2 py-1">
                                                <option selected hidden value="">Select Type </option>
                                                <option value="Custom">Custom</option>
                                                <option value="FnB">FnB</option>
                                                <option value="Inventory">Inventory</option>
                                            </select>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="departements1" hidden>
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="unit">Department<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="category" name="category" value="{{$dataRab->dept}}"
                                        class="category form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="sub_departements1" hidden>
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="unit">Sub Department<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="detail" name="detail"
                                        class="detail form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="nama_product">RAB Item Name<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="nama_product" name="nama_product"
                                        class="nama_product form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required/>
                                        <div x-data="{ modalOpen: false }">
                                            <button type="button" hidden
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
                                                            <div class="font-semibold text-slate-800">Select
                                                                RAB Item</div>
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
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="units" hidden>
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="unit">Unit<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="unit" name="unit"
                                            class="unit form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" maxlength="20" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="quantitys" hidden>
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="qty">Qty<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="qty" name="qty"
                                            class="qty numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="product_price1" hidden>
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="product_price">@Budget<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="product_price" name="product_price"
                                            class="product_price numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <div class="flex flex-row mb-3" id="dayscount" hidden>
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="days">Days Count<span
                                            class="text-rose-500">*</span></label>
                                        <input type="text" id="days" name="days" class="days numeric-input text w-20 form-input" value="1" required/>
                                        <span class="mx-2 mt-2 text-black-500">Days</span>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="itemTotal1" hidden>
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="itemTotal">Total
                                        </label>
                                        <input id="itemTotal" name="itemTotal"
                                            class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly/>
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
                                                @click="modalOpen = false" id="addProduct">Add RAB Item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label style="width: 75rem;"></label>
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="button" id="rearrange">
                        <span class="xs:block ml-5 mr-5">Re-arrange</span>
                    </button>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr class="bg-slate-400">
                                <th class="text-sm text-center">Type</th>
                                <th class="text-sm text-center">Department</th>
                                <th class="text-sm text-center">Sub Department</th>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Qty</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">Price</th>
                                <th class="text-sm text-center">Total</th>
                                <th class="text-sm text-center">Remarks</th>
                                <th hidden class="text-sm text-center">Balance</th>
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">
                        </tbody>
                    </table>
                </div>
                {{-- <div id="tablenew" hidden>
                    <div class="flex flex-row md:flex-row mb-1 mt-3">
                        <label class="text-sm font-medium mb-1" for="task_id">RAB Item Added
                        </label>
                    </div>
                    <div class="flex flex-row md:flex-row">
                        <table class="tableProductAddBody2 table table-striped table-bordered mt-3"
                            style="width:100%" hidden>
                            <thead>
                                <tr>
                                    <th class="text-sm text-center">Type</th>
                                    <th class="text-sm text-center">Department</th>
                                    <th class="text-sm text-center">Sub Department</th>
                                    <th class="text-sm text-center">Inventory Name</th>
                                    <th class="text-sm text-center">Qty</th>
                                    <th class="text-sm text-center">Unit</th>
                                    <th class="text-sm text-center">Price</th>
                                    <th class="text-sm text-center">Total</th>
                                    <th class="text-sm text-center">Remarks</th>
                                    <th hidden class="text-sm text-center">Balance</th>
                                    <th class="text-sm text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tableProductAddBody2" id="tableProductAddBody2">
                            </tbody>
                        </table>
                    </div>
                </div> --}}
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    </label>
                    <input id="grandtotal" name="grandtotal" class="block grandtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right mr-20" type="text" 
                    value="{{number_format($dataRab->grandTotal, 0, '.', '.')}}" readonly required/>
                    <label class="md:w-1/12 text-sm font-medium text-white"></label>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" 
                    value="{{$dataRab->grandTotal}}" readonly required/>
                </div>
                    @if ($dataRab->approvalstat == "Draft")
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Save RAB Update</span>
                    </button> </center>
                    @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $('#rabType').on('change', function (e) {
            const rabType = $("#rabType option:selected").val();
            if (rabType == 'Advance Payment To Site') {
                $("#benef").attr("hidden", false);
                $("#bank").attr("required", true);
                $("#number").attr("required", true);
                $("#account").attr("required", true);
            } else {
                $("#benef").attr("hidden", true);
                $("#bank").attr("required", false);
                $("#number").attr("required", false);
                $("#account").attr("required", false);
            }
        })
        $(document).ready(function () {
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
            $('#department').on('change', function (e) {
                $('#assetInv').DataTable().ajax.reload();
            })

            $('#assetInv').on("click", ".btn-select", function () {
                const idAsset = $(this).data("id");
                const nameAsset = $(this).data("nama");
                const category = $(this).data("category");
                const sub_category = $(this).data("sub_category");
                const unitssss = $(this).data("unit");

                $("#rabItemId").val(idAsset);
                $("#nama_product").val(nameAsset);
                $("#category").val(category);
                $("#detail").val(sub_category);
                $("#unit").val(unitssss);
            });
        });

        $("#tambahItem").click(function () {
            $('#rearrange').attr('disabled', true);
        });

        // Event listener untuk #qty
        $('#qty').on('input', function() {
            calculateTotal();
        });

        // Event listener untuk #product_price
        $('#product_price').on('input', function() {
            calculateTotal();
        });

        $('#days').on('input', function() {
            calculateTotal();
        });

        function calculateTotal() {
            const qtyValue = $('#qty').val().replace(/\./g, '');
            const priceValue = $('#product_price').val().replace(/\./g, '');
            const daysValue = $('#days').val().replace(/\./g, '');

            if (qtyValue !== '' && priceValue !== '' && daysValue !== '') {
                const qty1 = parseFloat(qtyValue);
                const price1 = parseFloat(priceValue);
                const days1 = parseFloat(daysValue);

                const total1 = price1 * qty1 * days1;

                $('#itemTotal').val(divider(total1));
            } else {
                $('#itemTotal').val('0');
            }
        }

        $('#rab_calc_type').on('change', function () {
            const rab_calc_type = $(this).val();

            if (rab_calc_type == "Custom") {
                $('#unit').val('');
                $('#qty').val('');
                $('#nama_product').val('');
                $('#product_price').val('');
                $('#itemTotal').val('');
                $('#detail').val('');
                $('#days').val('1');
                $('#rabItemId').val('Custom');
                $('#quantitys').removeAttr('hidden');
                $('#units').removeAttr('hidden');
                $('#product_price1').removeAttr('hidden');
                $('#itemTotal1').removeAttr('hidden');
                $('#qty').attr('readonly', false);
                $('#unit').attr('readonly', false);
                $('#detail').attr('readonly', false);
                $('#category').attr('readonly', true);
                $('#nama_product').attr('readonly', false);
                $('#rabSelection').attr('hidden', true);
                $('#dayscount').attr('hidden', true );
                $('#departements1').attr('hidden', false);
                $('#sub_departements1').attr('hidden', false);
            }else if (rab_calc_type == "FnB") {
                $('#unit').val('');
                $('#qty').val('');
                $('#nama_product').val('');
                $('#product_price').val('');
                $('#itemTotal').val('');
                $('#detail').val('');
                $('#days').val('1');
                $('#rabItemId').val('FnB');
                $('#quantitys').removeAttr('hidden');
                $('#units').removeAttr('hidden');
                $('#dayscount').attr('hidden', false);
                $('#product_price1').removeAttr('hidden');
                $('#itemTotal1').removeAttr('hidden');
                $('#qty').attr('readonly', false);
                $('#unit').attr('readonly', false);
                $('#detail').attr('readonly', false);
                $('#category').attr('readonly', true);
                $('#nama_product').attr('readonly', false);
                $('#rabSelection').attr('hidden', true);
                $('#departements1').attr('hidden', false);
                $('#sub_departements1').attr('hidden', false);
            }else if (rab_calc_type == "Inventory") {
                $('#unit').val('');
                $('#qty').val('');
                $('#nama_product').val('');
                $('#product_price').val('');
                $('#itemTotal').val('');
                $('#detail').val('');
                $('#days').val('1');
                $('#quantitys').removeAttr('hidden');
                $('#units').removeAttr('hidden');
                $('#product_price1').removeAttr('hidden');
                $('#itemTotal1').removeAttr('hidden');
                $('#nama_product').attr('readonly', true);
                $('#nama_product').css('width', '58.5rem');
                $('#qty').attr('readonly', false);
                $('#unit').attr('readonly', true);
                $('#dayscount').attr('hidden', true);
                $('#rabSelection').attr('hidden', false);
                $('#departements1').attr('hidden', true);
                $('#sub_departements1').attr('hidden', true);
            }
        })

        let grandTotal = parseFloat($('#grandtotal1').val()) || 0;

        function calculateGrandTotal() {
            grandTotal = 0;
            $('.tableProductAddBody tbody tr').each(function() {
                const totalas = parseFloat($(this).find('input[name^="total_"]').val()) || 0;
                grandTotal += totalas;
                console.log(grandTotal);
            });
            updateGrandTotal();
        }

        $("#addProduct").click(function () {
            let productIdx = $('#tableProductAddBody tr').length-1;
            var id = $('#rabItemId').val();
            var type = $('#rab_calc_type').val();
            var idds = makeid(3);
            var category = $('#category').val();
            var detail = $('#detail').val();
            var name = $('#nama_product').val();
            var remarks = $('#remarks').val();
            var unit = $('#unit').val();
            var qty = $('#qty').val();
            var qty2 = $('#qty').val().replace(/\./g, '');
            var days = $('#days').val();
            var days2 = $('#days').val().replace(/\./g, '');
            var price = $('#product_price').val();
            var price2 = $('#product_price').val().replace(/\./g, '');
            qty = Math.floor(qty2);
            price = Math.floor(price2);
            var total1 = price*qty*days2;

            if (type == "Inventory") {
                var idExists = false;

                // console.log('Checking for id:', id);

                $('#tableProductAddBody tr').each(function () {
                    var existingIdElement = $(this).find('[name^="ids"]');
                    if (existingIdElement.length > 0) {
                        var existingId = existingIdElement.val();
                        // console.log('Existing ID:', existingId);
                        
                        if (id == existingId) {
                            idExists = true;
                            return false; // Exit the loop if the id is found
                        }

                    }
                });

                // console.log('idExists:', idExists);

                if (idExists || $('#tableProductAddBody').find(`[name*="[ids2]"][value="${id}"]`).length > 0) {
                    alert('Same Inventory Asset cannot be added again.');
                    return false;
                }
            }

            if (!id || !qty || isNaN(parseFloat(price)) || parseFloat(price) <= 0 || isNaN(parseFloat(qty)) || parseFloat(qty) <= 0) {
                return false;
            }
                // Update subtotal
                if (type == "Inventory") {
                    var tr = `<tr id="row-${productIdx}">
                            <td class="text-left">${type}</td>
                            <td class="text-left">${category}<textarea name="rows[${productIdx}][categorys]" hidden>${category}</textarea></td>
                            <td class="text-left">${detail}<textarea name="rows[${productIdx}][sub-categorys]" hidden>${detail}</textarea></td>
                            <td class="text-left">${name}<input name="rows[${productIdx}][ids2]" value="${id}" hidden/><textarea name="rows[${productIdx}][namesis]" hidden>${name}</textarea></td>
                            <td class="text-right">${divider(qty)}<input name="rows[${productIdx}][qtys]" value="${qty2}" hidden/></td>
                            <td class="text-center">${unit}<textarea name="rows[${productIdx}][units]" hidden>${unit}</textarea></td>
                            <td class="text-right">${divider(price)}<input name="rows[${productIdx}][prices]" value="${price2}" hidden/><textarea name="rows[${productIdx}][rabCalcTypes]" hidden>${type}</textarea></td>
                            <td class="text-right">${divider(total1)}<input name="total_${productIdx}" value="${total1}" hidden/><input name="rows[${productIdx}][totals]" value="${total1}" hidden/><input name="rows[${productIdx}][dayss]" value="${days2}" hidden/></td>
                            <td class="text-left">${remarks}<textarea name="rows[${productIdx}][remarkss]" hidden>${remarks}</textarea></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${productIdx}, ${total1}, ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button></td>
                        </tr>`;
                        // <button type="button" class="icon-tabler-arrow-up1 btn border-slate-200 hover:border-slate-300" ><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-up" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M18 11l-6 -6" /><path d="M6 11l6 -6" /></svg></button><button type="button" class="icon-tabler-arrow-down1 btn border-slate-200 hover:border-slate-300" ><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M18 13l-6 6" /><path d="M6 13l6 6" /> </svg></button>
                } else if(type == "FnB") {
                    var tr = `<tr id="row-${productIdx}">
                            <td class="text-left">${type}</td>
                            <td class="text-left">${category}<textarea name="rows[${productIdx}][categorys]" hidden>${category}</textarea></td>
                            <td class="text-left">${detail}<textarea name="rows[${productIdx}][sub-categorys]" hidden>${detail}</textarea></td>
                            <td class="text-left">${name}<input name="rows[${productIdx}][ids2]" value="${id}${idds}" hidden/><textarea name="rows[${productIdx}][namesis]" hidden>${name}</textarea></td>
                            <td class="text-right">${divider(qty)}<input name="rows[${productIdx}][qtys]" value="${qty2}" hidden/></td>
                            <td class="text-center">${unit}<textarea name="rows[${productIdx}][units]" hidden>${unit}</textarea></td>
                            <td class="text-right">${divider(price)}<input name="rows[${productIdx}][prices]" value="${price2}" hidden/><textarea name="rows[${productIdx}][rabCalcTypes]" hidden>${type}</textarea></td>
                            <td class="text-right">${divider(total1)}<input name="total_${productIdx}" value="${total1}" hidden/><input name="rows[${productIdx}][totals]" value="${total1}" hidden/><input name="rows[${productIdx}][dayss]" value="${days2}" hidden/></td>
                            <td class="text-left">${remarks}<textarea name="rows[${productIdx}][remarkss]" hidden>${remarks}</textarea></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${productIdx}, ${total1}, ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button></td>
                        </tr>`; 
                        // <button type="button" class="icon-tabler-arrow-up1 btn border-slate-200 hover:border-slate-300" ><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-up" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M18 11l-6 -6" /><path d="M6 11l6 -6" /></svg></button><button type="button" class="icon-tabler-arrow-down1 btn border-slate-200 hover:border-slate-300" ><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M18 13l-6 6" /><path d="M6 13l6 6" /> </svg></button>
                } else if(type == "Custom") {
                    var tr = `<tr id="row-${productIdx}">
                            <td class="text-left">${type}</td>
                            <td class="text-left">${category}<textarea name="rows[${productIdx}][categorys]" hidden>${category}</textarea></td>
                            <td class="text-left">${detail}<textarea name="rows[${productIdx}][sub-categorys]" hidden>${detail}</textarea></td>
                            <td class="text-left">${name}<input name="rows[${productIdx}][ids2]" value="${id}${idds}" hidden/><textarea name="rows[${productIdx}][namesis]" hidden>${name}</textarea></td>
                            <td class="text-right">${divider(qty)}<input name="rows[${productIdx}][qtys]" value="${qty2}" hidden/></td>
                            <td class="text-center">${unit}<textarea name="rows[${productIdx}][units]" hidden>${unit}</textarea></td>
                            <td class="text-right">${divider(price)}<input name="rows[${productIdx}][prices]" value="${price2}" hidden/><textarea name="rows[${productIdx}][rabCalcTypes]" hidden>${type}</textarea></td>
                            <td class="text-right">${divider(total1)}<input name="total_${productIdx}" value="${total1}" hidden/><input name="rows[${productIdx}][totals]" value="${total1}" hidden/><input name="rows[${productIdx}][dayss]" value="${days2}" hidden/></td>
                            <td class="text-left">${remarks}<textarea name="rows[${productIdx}][remarkss]" hidden>${remarks}</textarea></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${productIdx}, ${total1}, ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button></td>
                        </tr>`; 
                }

                calculateGrandTotal();
                $("#tableProductAddBody").append(tr);
                $('#rabItemId').val('');
                $('#detail').val('');
                $('#nama_product').val('');
                $('#remarks').val('');
                $('#unit').val('');
                $('#qty').val('');
                $('#days').val('1');
                $('#product_price').val('');
                $('#itemTotal').val('');
                $('#rab_calc_type').val('');
                $('#dayscount').attr('hidden', true);
                $('#quantitys').attr('hidden', true);
                $('#units').attr('hidden', true);
                $('#departements1').attr('hidden', true);
                $('#sub_departements1').attr('hidden', true);
                $('#product_price1').attr('hidden', true);
                $('#itemTotal1').attr('hidden', true);
                $('#nama_product').attr('readonly', true);
                $('#rabSelection').attr('hidden', true);
                $('#grandtotal').val(`${divider(grandTotal + total1)}`);
                $('#grandtotal1').val(grandTotal + total1);

                var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
                grandTotalRow.detach();
                $("#tableProductAddBody").append(grandTotalRow);
                updateProductIdxAttributes();

                $('#grandTotal1_text').text(`${divider(grandTotal + total1)}`);
        });
        
        function rabCalcTypes(iden, calcul) {
            // Check if the value is "FnB"
            if (calcul == 'FnB') {
                $(`#dayss2_${iden}`).attr('hidden', false);
            } else {
                $(`#dayss2_${iden}`).attr('hidden', true);
            }
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataRabItem?>;
        let tableRow = '';
        
        for (const value of dataProducts) {
            // var iden = makeid(3);
            var iden = dataProducts.indexOf(value);

            const prods = <?=$dataRabItem?>;
            var modal_content = '';

            $('.tableProductAddBody').on('input', '.rab-input', function() {
                updateTotals(this);
            });

            function updateTotals(ths) {
                const exp = $(ths).attr('id').split('_');
                let iden = '';
                if(exp.length > 1){
                    iden = exp[1];
                }
                const qty2 = parseFloat($(`#qty2_${iden}`).val()) || 0;
                const days2 = parseFloat($(`#days2_${iden}`).val()) || 1;
                const price2 = parseFloat($(`#product-price2_${iden}`).val()) || 0;
                const total2 = price2 * qty2 * days2;

                $(`#itemTotal_${iden}`).val(divider1(total2));
            }

            $("#rearrange").click(function () {
                $('#tambahItem').attr('disabled', true);
                $('.rowingsUp').attr('hidden', false);
                $('.rowingsDown').attr('hidden', false);
            });

            $.each(prods, function (i,item1) {
                if(value.idrec == item1.idrec){
                        modal_content += `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3" id="unit2" hidden>
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="unit2">Unit
                                                </label>
                                                <input id="unit2_${iden}" name="unit2"
                                                    class="unit2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${value.unit}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3" id="qty2">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="qty2">qty
                                                </label>
                                                <input id="qty2_${iden}" name="qty2" class="rab-input numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" data-iden="${iden}" value="${newDivider2(value.qty)}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="product-price2">@Budget
                                                </label>
                                                <input id="product-price2_${iden}" name="product-price2" class="rab-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="number" data-iden="${iden}" value="${newDivider2(value.amount)}"/>
                                            </div>
                                            <div class="flex flex-row mb-3" id="dayss2_${iden}">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="days">Days Count : </label>
                                                <input id="days2_${iden}" name="days2" class="rab-input form-input w-20" type="number" data-iden="${iden}" value="${newDivider2(value.days)}"/>
                                                <span class="mx-2 mt-2 text-black-500">Days</span>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="itemTotal">Total
                                                </label>
                                                <input id="itemTotal_${iden}" name="itemTotal"
                                                class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                type="text" value="${newDivider1(value.total)}" readonly/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="remarks">Remarks
                                                </label>
                                                <input id="remarks2_${iden}" name="remarks"
                                                    class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${value.remarks === 'null' ? '' : (value.remarks || '')}"/>
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

            tableRow += `<tr id=row-${iden}>
                            <td><input type="text" name="idrecss_${iden}" value="${value.idrec}" hidden/>${value.rab_calc_type}<input type="text" name="date_rab_${iden}" value="${value.date_rab}" hidden/><input type="text" name="approvalstat_${iden}" value="${value.approvalstat}" hidden/></td>
                            <td><input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="ids_${iden}" value="${value.id_rab_item}" hidden/><input type="text" name="offer_${iden}" value="${value.id_rab}" hidden/>${value.category === 'null' ? '' : (value.category || '')}<input type="text" name="cats_${iden}" id="cats_${iden}" value="${value.category}" hidden/></td>
                            <td><input type="text" name="m-currency_${iden}" id="m-currency_${iden}" value="${value.sub_category}" hidden/>${value.sub_category === 'null' ? '' : (value.sub_category || '')}<textarea type="text" name="remarks231_${iden}" id="remarks231_${iden}" hidden>${value.remarks}</textarea></td>
                            <td>${value.detail === 'null' ? '' : (value.detail || '')}<input type="text" name="details_${iden}" id="details_${iden}" value="${value.detail}" hidden/><input type="text" name="days1_${iden}" id="days1_${iden}" value="${value.days}" hidden/><input type="text" name="calcul_${iden}" id="calcul_${iden}" value="${value.rab_calc_type}" hidden/></td>
                            <td class="text-right"><input type="text" name="qty_${iden}" id="qty_${iden}" value="${newDivider2(value.qty)}" hidden/><span id="qty-text_${iden}">${newDivider1(value.qty)}</span></td>
                            <td class="text-center"><input type="text" name="units1_${iden}" id="units1_${iden}" value="${value.unit}" hidden/><span id="units1-text_${iden}">${value.unit}</span></td>
                            <td class="text-right"><input type="text" name="price_${iden}" id="price_${iden}" value="${newDivider2(value.amount)}" hidden/><span id="price-text_${iden}">${newDivider1(value.amount)}</span></td>
                            <td class="text-right"><input type="text" name="total_${iden}" id="total_${iden}" value="${newDivider2(value.total)}" hidden/><span id="total-text_${iden}">${newDivider1(value.total)}</span></td>
                            <td><textarea type="text" name="remarks1_${iden}" id="remarks1_${iden}" hidden>${value.remarks}</textarea><span id="remarks1-text_${iden}">${value.remarks === 'null' ? '' : (value.remarks || '')}</span><textarea type="text" name="status_${iden}" id="status_${iden}" hidden>${value.status}</textarea></td>
                            <td class="flex justify-center">
                <button type="button" onclick="deleteDataProduct('${iden}', ${value.total}, ${value.idrec})" class="btn btn-delete border-slate-200 hover:border-slate-300" > <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/></svg></button>                
                    <div x-data="{ modalOpen: false }">
                                <button class="ml-2 btn bg-emerald-500 hover:bg-emerald-600 text-white" type="button"
                                @click.prevent="modalOpen = true" aria-controls="feedback-modal" onclick="rabCalcTypes(${iden}, '${value.rab_calc_type}')">
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
                                                <div class="font-semibold text-slate-800">Edit Budget RAB Item</div>
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
                    <button hidden class="rowingsUp" type="button"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-up ml-3" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round"  onclick=\"moveRowUp(${iden})\">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 5l0 14" />
                        <path d="M18 11l-6 -6" />
                        <path d="M6 11l6 -6" />
                    </svg></button>
                    <button hidden class="rowingsDown" type="button"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-down ml-2" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round"  onclick=\"moveRowDown(${iden})\">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 5l0 14" />
                        <path d="M18 13l-6 6" />
                        <path d="M6 13l6 6" />
                    </svg></button>
                </td>
            </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);
        var grandTotalRow = `<tr class="grandTotalRow bg-slate-400">
            <td class="text-center font-bold text-lg" colspan="7">Grand Total</td>
            <td class="text-right font-bold text-lg"><span id="grandTotal1_text">${divider(grandTotal)}</span></td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);

        function moveRowUp(positionTableRow) {
            if (positionTableRow > 0) {
            const $currentRow = $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`);
            const $previousRow = $(`#tableProductAddBody tr[id="row-${positionTableRow - 1}"]`);

            swapRowData($currentRow, $previousRow);

            $currentRow.insertBefore($previousRow);
            // Update the productIdx attribute in the rows
            updateProductIdxAttributes();
            }
        }

        function moveRowDown(positionTableRow) {
            const rowCount = $('#tableProductAddBody tr').length;
            const $currentRow = $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`);
            const $nextRow = $(`#tableProductAddBody tr[id="row-${positionTableRow + 1}"]`);

            if (positionTableRow + 1 < rowCount - 1) {
                swapRowData($currentRow, $nextRow);
                $currentRow.insertAfter($nextRow);
                updateProductIdxAttributes();
            }
        }

        // Event listener for arrow-up button click
        $('#tableProductAddBody').one('click', '.icon-tabler-arrow-ups', function () {
            const positionTableRow = $(this).closest('tr').index();
            moveRowUp(positionTableRow);
        });

        // Event listener for arrow-down button click
        $('#tableProductAddBody').one('click', '.icon-tabler-arrow-downs', function () {
            const positionTableRow = $(this).closest('tr').index();
            moveRowDown(positionTableRow);
        });

        // Function to update the productIdx attribute in the rows
        function updateProductIdxAttributes() {
            $('#tableProductAddBody tr').each(function (index, element) {
                const newIndex = index;
                const productIdAttr = `rows[${newIndex}][ids]`;
                const idrecAttr = `rows[${newIndex}][idrec]`;
                        
                $(element).attr('id', `row-${newIndex}`);
                $(element).find(`[name*="[ids]"]`).attr('name', productIdAttr);
                $(element).find(`[name*="[idrecss]"]`).attr('name', idrecAttr);
            });
        }

        function updateProductIdxAttributes() {
            $('#tableProductAddBody tr').each(function (index, element) {
                const lastIndex = $('#tableProductAddBody tr').length -1;
                if(index < lastIndex){
                    const newIndex = index;
                    
                    $(element).attr('id', `row-${newIndex}`);

                    $(element).find('[onclick^="updateDataProduct"]').attr('onclick', `updateDataProduct(${newIndex})`);
                    $(element).find('.icon-tabler-arrow-up').attr('onclick', `moveRowUp(${newIndex})`);
                    $(element).find('.icon-tabler-arrow-down').attr('onclick', `moveRowDown(${newIndex})`);
                    let idrec = $(element).find('input[name*="idrecss_"]').val();
                    let total = $(element).find('input[name*="total_"]').val();
                    if(typeof total == 'undefined' && total == null){
                        total = $(element).find('td:eq(7)').find('input').val();
                    }
                    // console.log(idrec,total);
                    $(element).find('[onclick^="deleteDataProduct"]').attr('onclick', `deleteDataProduct(${newIndex}, ${total}, ${idrec})`);
                    $(element).find('input[name*="iden[]"]').val(newIndex)
                    
                    // data-iden
                    // Find and update all input fields with dynamic names
                    $(element).find('input, textarea').each(function () {
                        const oldName = $(this).attr('name');
                        let newName = oldName.replace(/rows\[\d+\]/, `rows[${newIndex}]`);
                        if(newName == oldName){
                            let exp = oldName.split('_');
                            if(exp.length > 1){
                                newName = exp[0]+'_'+newIndex;
                            }
                            // console.log(exp)
                        }
                        $(this).attr('name', newName);
                    });

                    $(element).find('input, span').each(function () {
                        const oldId = $(this).attr('id');
                        if(typeof oldId !== 'undefined' && oldId !== null){
                            let newId = oldId.replace(/rows\[\d+\]/, `rows[${newIndex}]`);
                            if(newId == oldId){
                                let exp = oldId.split('_');
                                if(exp.length > 1){
                                    newId = exp[0]+'_'+newIndex;
                                }
                                // console.log(exp)
                            }
                            $(this).attr('id', newId);
                            $(this).attr('data-iden', newIndex);
                        }

                    })

                    // const idrec = $(element).find('input[name*="idrecss_"]').val();
                    const nextidrec = $(element).next().find('input[name*="idrecss_"]').val();
                    const previdrec = $(element).prev().find('input[name*="idrecss_"]').val();
                    // if(typeof idrec != 'undefined' && idrec != null){
                    //     // console.log(nextidrec, $(element).find('.icon-tabler-arrow-down').parent())
                    //     if(typeof nextidrec == 'undefined' && nextidrec == null){
                    //         $(element).find('.icon-tabler-arrow-up').parent().show();
                    //         $(element).find('.icon-tabler-arrow-down').parent().hide();
                    //     }else{
                    //         $(element).find('.icon-tabler-arrow-up').parent().show();
                    //         $(element).find('.icon-tabler-arrow-down').parent().show();
                    //     }
                    // }else if(typeof previdrec != 'undefined' && previdrec != null){
                        //     $(element).find('.icon-tabler-arrow-up').parent().hide();
                        //     $(element).find('.icon-tabler-arrow-down').parent().show();
                        // }else{
                    //     $(element).find('.icon-tabler-arrow-up').parent().show();
                    //     $(element).find('.icon-tabler-arrow-down').parent().show();
                    // }
                    // console.log($(element))
                    // console.log($(element).next())

                }
            });
        }

                function swapRowData($row1, $row2) {
                    const idrec1 = $row1.find('[name^="idrecss_"]').val();
                    const idrec2 = $row2.find('[name^="idrecss_"]').val();

                    $row1.find('[name^="idrecss_"]').val(idrec2);
                    $row2.find('[name^="idrecss_"]').val(idrec1);

                    // ini buat yang udah ada idrecnya
                }

                function deleteDataProduct(positionTableRow, total, dataFromDatabase,  nullParam) {
                    const positionTableRowVariable = positionTableRow;
                    const dataFromDatabaseVariable = dataFromDatabase;
                    const csrf_token = $('meta[name="csrf-token"]').attr('content');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Want to Delete RAB Item!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (dataFromDatabaseVariable !== null) {
                                // Tandai baris yang dihapus dengan warna latar merah
                                $(`#row-${positionTableRowVariable}`).addClass('bg-red-100');
                                // Update status menjadi "Non Active"
                                // $(`#status_${positionTableRowVariable}`).val('Non Active');
                                // Simpan elemen baris yang akan dihapus
                                const $rowToDelete = $(`#tableProductAddBody tr#row-${positionTableRowVariable}`);
                                
                                // Hapus baris dari tabel
                                $rowToDelete.remove();
                                
                                // Panggil fungsi untuk menghapus data (misalnya, dari database)
                                handleDeleteRow(positionTableRowVariable, total);
                                calculateGrandTotal(); 
                            } else {
                                // Hapus baris jika data baru ditambahkan
                                $(`#tableProductAddBody tr#row-${positionTableRowVariable}`).remove();
                                
                                // Panggil fungsi untuk menghapus data (misalnya, dari database)
                                handleDeleteRow(positionTableRowVariable, total);
                                calculateGrandTotal(); 
                            }
                            Swal.fire({
                                icon : 'success',
                                title: 'Deleted!',
                                text: `RAB Item has been Deleted.`,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }

                function handleDeleteRow(positionTableRow, total) {
                    const parsedTotal = parseFloat(total) || 0;
                    grandTotal = Math.max(grandTotal - parsedTotal, 0);
                    calculateGrandTotal();
                    // Update the grandTotal fields
                    $('#grandtotal').val(newDivider1(grandTotal));
                    $('#grandtotal1').val(grandTotal);
                    updateGrandTotal();
                }

        function updateDataProduct(iden) {
            var remarks = $('#remarks2_'+iden).val();
            var remarksTextarea = $(`#row-${iden}`).find(`textarea[name="remarks1_${iden}"]`);
            // Update the textarea value in the current row
            remarksTextarea.val(remarks);
            $('#remarks1-text_'+iden).text(remarks);

            var unitss = $('#unit2_'+iden).val();
            $('#units1_'+iden).val(unitss);
            $('#units1_-ext_'+iden).text(unitss);

            var daysss = $('#days2_'+iden).val();
            $('#days1_'+iden).val(daysss);
            $('#days1-text_'+iden).text(daysss);
            
            var qty = parseFloat($('#qty2_' + iden).val()) || 0;
            var price = parseFloat($('#product-price2_' + iden).val()) || 0;
            var days = parseFloat($('#days2_' + iden).val()) || 0;
            var newTotal = price * qty * days;

            // Mengupdate nilai total pada input tersembunyi
            $('#total_' + iden).val(newTotal);

            // Memanggil fungsi untuk menghitung ulang grandTotal dan memperbarui tampilan
            calculateGrandTotal();
            updateGrandTotal();

            // Memperbarui nilai lain yang perlu diperbarui
            $('#qty_' + iden).val(qty);
            $('#qty-text_' + iden).text(newDivider1(qty));
            $('#price_' + iden).val(price);
            $('#price-text_' + iden).text(newDivider1(price));
            $('#total-text_' + iden).text(newDivider1(newTotal));
            $('#grandtotal').val(newDivider1(grandTotal));
            $('#grandtotal1').val(grandTotal);

            console.log(iden, qty, price, grandTotal, newTotal);
        }

        function updateGrandTotal() {
            $('#grandTotal1_text').text(`${divider(grandTotal)}`);
            $('#grandTotal1_text').val(`${grandTotal}`);
            $('#grandtotal').val(newDivider1(grandTotal));
            $('#grandtotal1').val(grandTotal);
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
    </script>
    @endsection
</x-app-layout>