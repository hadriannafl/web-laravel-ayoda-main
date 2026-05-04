<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit Purchase Request 📝</h1>
        </div>
        <form action="{{ route('purchase-list.update', ['idPR' => $dataPR->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Purchase Request # / PR Date / PR Title</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->idreqform}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataPR->pr_date))}}" readonly>
                        </div>
                        <div>
                            <input id="pr_title" style="width: 21.2rem;" name="pr_title" class="pr_title form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->pr_title}}"/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Applicant / Company / Request Level</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->applicant}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->companyName}}" readonly>
                        </div>
                        <div>
                            <select id="level" name="level" style="width: 21.2rem;"
                            class="level form-select w-full px-2 py-1">
                            <option value="Normal" {{$dataPR->reqlevel == 'Normal' ? 'selected':''}}>Normal</option>
                            <option value="Important" {{$dataPR->reqlevel == 'Important' ? 'selected':''}}>Important</option>
                            <option value="Urgent" {{$dataPR->reqlevel == 'Urgent' ? 'selected':''}}>Urgent</option>
                            </select>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Delivery Date / RAB / Currency</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataPR->delivery_date))}}" readonly>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_acc" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->id_rab}}-{{$dataPR->name_rab}}-{{date('F Y', strtotime($dataPR->rab_date))}}" readonly/>
                            <input class="idRab form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="idRab" name="idRab" value="{{$dataPR->id_rab}}" readonly hidden required>
                        </div>
                        <div>
                            <select id="currency" name="currency" style="width: 21.2rem;"
                                class="currency form-select w-full px-2 py-1" required>
                                @foreach ( $dataCurrency as $cur )
                                <option value="{{$cur->symbol}}" {{$cur->symbol == $dataPR->currency ? 'selected':''}}>{{$cur->symbol}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Payment Source / PIC / Phone Number</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <select id="payment_by" name="payment_by"
                                class="payment_by form-select w-full px-2 py-1" required>
                                <option value="HO" {{$dataPR->payment_by == 'HO' ? 'selected':''}}>HO</option>
                                <option value="SITE" {{$dataPR->payment_by == 'SITE' ? 'selected':''}}>SITE</option>
                            </select>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="pic" name="pic" class="pic form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->pic}}" required/>
                        </div>
                        <div>
                            <input id="phone" name="phone" style="width: 21.2rem;" class="phone form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->phone}}" required/>
                        </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1" for="address">Address</label>
                    <textarea id="address" name="address" class="address form-input w-full px-2 py-1 read-only:bg-slate-200"
                        rows="3" readonly>{{$dataPR->delivery_address}}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="notes form-input w-full px-2 py-1 read-only:bg-slate-200"
                        rows="3">{{$dataPR->note}}</textarea>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Add Purchase Detail<span
                    class="text-rose-500">*</span>
                    </label>
                    <div x-data="{ modalOpen: false }" id="modalForm">
                        <button class="ml-2 btn btn-rab bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal1">
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
                                                            <button class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3" id="selectAllRAB" @click="modalOpen = false" type="button" disabled>Add All Item</button> 
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
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Asset Code</th>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Quantity</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">@Price</th>
                                <th class="text-sm text-center">Currency</th>
                                <th class="text-sm text-center">Total</th>
                                <th class="text-sm text-center">Remakrs</th>
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row md:flex-row" hidden>
                    <table class="tableProductAddBody23 table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Asset Code</th>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Quantity</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">@Price</th>
                                <th class="text-sm text-center">Currency</th>
                                <th class="text-sm text-center">Total</th>
                                <th class="text-sm text-center">Remakrs</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody23" id="tableProductAddBody23">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="subtotal">Subtotal
                    </label>
                    <input id="subtotal" name="subtotal" type="text" class="subtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-36" value="{{number_format($dataPR->subtotal, 0, '.', '.')}}" readonly/>
                    <input id="subtotal1" name="subtotal1" type="text" class="subtotal1 form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-36" value="{{number_format($dataPR->subtotal, 0, '', '')}}" readonly hidden/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="discount">Discount (IDR)
                    </label>
                    <input id="discount" name="discount" class="discount form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 ml-36" type="text" onchange="calculateDisc()" value="{{number_format($dataPR->discount, 0, '', '')}}"/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="total">Total
                    </label>
                    <input id="total" name="total" type="text" class="total form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-36" value="{{number_format($dataPR->total, 0, '.', '.')}}" readonly/>
                    <input id="total1" name="total1" type="text" class="total1 form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-36" value="{{number_format($dataPR->total, 0, '', '')}}" readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="ppn">PPN (IDR)
                    </label>
                    <input id="ppn" name="ppn" class="ppn form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 ml-36" type="text" onchange="calculateDisc()" value="{{number_format($dataPR->ppn, 0, '', '')}}"/>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/2 text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input w-full md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right" type="text" 
                    value="{{number_format($dataPR->gtotal, 0, '.', '.')}}" required readonly/>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-36" type="text" 
                    value="{{number_format($dataPR->gtotal, 0, '', '')}}" required readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="deliveryCharge">Delivery Charge (IDR)
                    </label>
                    <input id="deliveryCharge" name="deliveryCharge" class="deliveryCharge form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 ml-36" type="text" value="{{number_format($dataPR->delivery_charge, 0, '', '')}}"/>
                </div>
                @if ($dataPR->approvalstat == 'Draft')
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Save Purchase Request</span>
                </button> </center>
                @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
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
        });

        function calculateDisc() {
            let finalAmount = grandTotal; // Pastikan variable 'subtotal' sudah didefinisikan dan memiliki nilai sebelumnya
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

        let grandTotal = parseFloat($('#grandtotal1').val()) || 0;
        var usedBudgets = {};
        function calculateGrandTotal() {
            grandTotal = 0;
            $('.tableProductAddBody tbody tr').each(function() {
                const totalas = parseFloat($(this).find('input[name^="total_"]').val()) || 0;
                grandTotal += totalas;
            });
            $('#grandtotal').val(divider(Math.round(grandTotal)));
            $('#grandtotal1').val(Math.round(grandTotal));
            updateGrandTotal();
        }
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

                if (parseFloat(budget) === 0) {
                    return; // Skip adding this row if the budget is 0
                }

                if ($('#tableProductAddBody').find(`[name*="[ids]"][value="${id_item}"]`).length > 0) {
                    alert('Same Inventory Asset cannot be added again.');
                    return false;
                }
                
                // subtotal += total;
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
                                                            @click="modalOpen = false" onclick="updateDataProduct2('${rowIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>`
                prods.push({rowIdx, id_item, id_rab, name, price, price2, oq, oq1, unit, remarks, budget, total, modal_content});
                var tr = `<tr id="row-${rowIdx}">
                            <td class="text-center">${id_item}</td>
                            <td class="text-left">${name}<input name="rows1[${rowIdx}][ids]" value="${id_item}" hidden/><textarea name="rows1[${rowIdx}][namesis]" hidden>${name}</textarea></td>
                            <td class="text-right"><span id="qtys-text_${rowIdx}">${allinDivider(oq1)}</span><input id="qtys_${rowIdx}" name="rows1[${rowIdx}][qtys]" value="${oq1}" hidden/></td>
                            <td class="text-center"><textarea name="rows1[${rowIdx}][units]" hidden>${unit}</textarea><span id="units-text_${rowIdx}">${unit}</span></td>
                            <td class="text-right"><span id="prices-text_${rowIdx}">${allinDivider(price2)}</span><input id="prices_${rowIdx}" name="rows1[${rowIdx}][prices]" value="${price2}" hidden/><input name="rows1[${rowIdx}][rowIdx]" value="${newDivider2(budget)}" hidden/></td>
                            <td class="text-center">{{$dataPR->currency}}</td>
                            <td class="text-right"><span id="totals-text_${rowIdx}">${divider(budget)}</span><input id="total_${rowIdx}" name="total_${rowIdx}" value="${budget}" hidden/><input id="totals_${rowIdx}" name="rows1[${rowIdx}][totals]" value="${total}" hidden/></td>
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
            calculateGrandTotal();
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
            var count = budget + totalas;
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

            var idExists = false;

                // console.log('Checking for id:', id);

                $('#tableProductAddBody tr').each(function () {
                    var existingIdElement = $(this).find('[name^="ids"]');
                    if (existingIdElement.length > 0) {
                        var existingId = existingIdElement.val();
                        
                        if (id == existingId) {
                            idExists = true;
                            return false; // Exit the loop if the id is found
                        }

                    }
                });
                if (idExists || $('#tableProductAddBody').find(`[name*="[ids2]"][value="${id}"]`).length > 0) {
                    alert('Same Inventory Asset cannot be added again.');
                    return false;
                }

            console.log($('#tableProductAddBody').find(`[name*="[ids2]"][value="${id}"]`));
                // Check if the product with the same id already exists for Inventory type
                if ($('#tableProductAddBody').find(`[name*="[ids2]"][value="${id}"]`).length > 0) {
                    alert('Same Inventory Asset cannot be added again.');
                    return false;
                }

            if (name === '' || price2 === '0' || price2 === '' || oq1 === '0' || oq1 === '') {
                return false;
            }
            // usedBudgets[id_rab][id] += total;
            grandTotal += total;
                function calculateBalance(productIdx) {
                    const itemTotal = parseFloat($('#itemTotal_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                    const budget = parseFloat($('#count_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
                    const budgetTotal = parseFloat(budget - itemTotal);
                    // const roundedGrandTotal = Math.round((grandTotal + Number.EPSILON) * 1000) / 1000;
                    $('#budget_' + productIdx).val(allinDivider(budgetTotal)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
                }
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
                                                    <input id="count_${productIdx}" name="count"
                                                        class="count form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${budget}" readonly hidden/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct1('${productIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>`
                prods.push({productIdx, id, id_rab, name, price, price2, oq, oq1, unit, remarks, total, modal_content});
                var tr = `<tr id="row-${productIdx}">
                            <td class="text-center">${id}</td>
                            <td class="text-left">${name}<input name="rows[${productIdx}][ids2]" value="${id}" hidden/><textarea name="rows[${productIdx}][namesis]" hidden>${name}</textarea></td>
                            <td class="text-right"><span id="qtys-text_${productIdx}">${allinDivider(oq1)}</span><input id="qtys_${productIdx}" name="rows[${productIdx}][qtys]" value="${oq1}" hidden/></td>
                            <td class="text-center"><span id="units-text_${productIdx}">${unit}</span><textarea id="units_${productIdx}" name="rows[${productIdx}][units]" hidden>${unit}</textarea></td>
                            <td class="text-right"><span id="prices-text_${productIdx}">${allinDivider(price2)}</span><input id="prices_${productIdx}" name="rows[${productIdx}][prices]" value="${price2}" hidden/><input name="rows[${productIdx}][budgets]" value="${budget}" hidden/></td>
                            <td class="text-center">{{$dataPR->currency}}</td>
                            <td class="text-right"><span id="totals-text_${productIdx}">${divider(total)}</span><input id="total_${productIdx}" name="total_${productIdx}" value="${total}" hidden/><input id="totals_${productIdx}" name="rows[${productIdx}][totals]" value="${total}" hidden/></td>
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
            calculateGrandTotal();

            $('#assetId').val('');
            $('#nama_product').val('');
            $('#unit').val('');
            $('#product_price').val('0');
            $('#order_quantity').val('0');
            $('#itemTotal').val('0');
            $('#remarks').val('');
            $('#grandtotal').val(`${divider(grandTotal)}`);
            $('#grandtotal1').val(grandTotal);
            $('#budget').val(``);
            $("#selectAllRAB").attr("disabled", true);
            updateGrandTotal();

            calculateDisc();

            var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
            grandTotalRow.detach();
            $("#tableProductAddBody").append(grandTotalRow);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$PRDetail?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {
            // var iden = makeid(3);
            var iden = dataProducts.indexOf(value);

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

            $('.tableProductAddBody').on('input', '.pr-input', function() {
                updateTotals(this);
            });

            const prods = <?=$PRDetail?>;
            var modal_content = '';
            $.each(prods, function (i,item1) {
                if(value.idassets == item1.idassets){
                    modal_content += `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="qty2">Quantity
                                                </label>
                                                <input id="qty2_${iden}" name="qty2" class="pr-input numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" data-iden="${iden}" value="${newDivider2(value.qty)}"/>
                                                <input id="count_${iden}" name="count" class="count form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(value.counts)}" readonly hidden/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="product_price2">@Price
                                                </label>
                                                <input id="product-price2_${iden}" name="product-price2" class="pr-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="number" data-iden="${iden}" value="${newDivider2(value.price)}"/>
                                                <input id="budget_${iden}" name="budget" class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="${newDivider2(value.rabBalance)}" readonly hidden/>
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
                                                    type="text" value="${value.remarks == null ? '' : value.remarks}" />
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

            tableRow += `<tr id=row-${iden}>
                            <td class="text-center"><input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="ids_${iden}" value="${value.idassets}" hidden/> <input type="text" name="idPR_${iden}" value="${value.idreqform}" hidden/>${value.idassets}</td>
                            <td>${value.name_rab_detail}<input type="text" name="idrec_${iden}" value="${value.id}" hidden/><input type="text" name="unit_${iden}" value="${value.unit}" hidden/><input type="text" name="createdat_${iden}" value="${value.created_at}" hidden/></td>
                            <td class="text-right"><input type="text" name="qty_${iden}" id="qty_${iden}" value="${newDivider2(value.qty)}" hidden/><span id="qty_text_${iden}">${newDivider1(value.qty)}</span></td>
                            <td class="text-center">${value.unit}<textarea name="status_${iden}" id="status_${iden}" hidden>${value.status}</textarea><input type="text" id="newbalances_${iden}" name="newbalances_${iden}" value="${newDivider2(value.balance_rab)}" hidden/></td>
                            <td class="text-right"><input type="text" name="price_${iden}" id="price_${iden}" value="${newDivider2(value.price)}" hidden/><span id="price_text_${iden}">${newDivider1(value.price)}</span></td>
                            <td class="text-center">{{$dataPR->currency}}<input type="text" name="id_rab_${iden}" value="${value.id_rab}" hidden/><input type="text" id="balanciaga_${iden}" name="balanciaga_${iden}" value="${newDivider2(value.balance_rab)}" hidden/></td>
                            <td class="text-right"><input type="text" name="total_${iden}" id="total_${iden}" value="${newDivider2(value.total)}" hidden/><input type="text" id="totalia_${iden}" name="totalia_${iden}" value="${newDivider2(value.total)}" hidden/><span id="total_text_${iden}">${newDivider1(value.total)}</span></td>
                            <td><textarea name="remarks1_${iden}" id="remarks1_${iden}" hidden>${value.remarks}</textarea><span id="remarks1_text_${iden}">${value.remarks === 'null' ? '' : (value.remarks || '')}</span></td>
                            <td class="flex justify-center">
                            <button type="button" onclick="deleteDataProduct('${iden}', ${value.total}, ${value.id})" class="btn btn-delete border-slate-200 hover:border-slate-300" > <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/></svg></button>                             
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
                                        @keydown.escape.window="modalOpen = false">
                                        <!-- Modal header -->
                                        <div class="px-5 py-3 border-b border-slate-200">
                                            <div class="flex justify-between items-center">
                                                <div class="font-semibold text-slate-800">Edit Detail Purchase Request</div>
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
        $(".tableProductAddBody").find('tbody').append(tableRow);
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="6">Grand Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">{{number_format($dataPR->gtotal, 0, '.', '.')}}</span></td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);

        function updateDataProduct2(rowIdx) {
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

            if (newTotal >= budgeet) {
                alert('Over Budget canot update.');
                return false;
            }

            // Mengupdate nilai total pada input tersembunyi
            $('#totals_' + rowIdx).val(newTotal);
            $('#total_' + rowIdx).val(newTotal);

            // Memanggil fungsi untuk menghitung ulang grandTotal dan memperbarui tampilan
            calculateGrandTotal();
            updateGrandTotal();

            // Memperbarui nilai lain yang perlu diperbarui
            $('#qtys_' + rowIdx).val(qty);
            $('#qtys-text_' + rowIdx).text(allinDivider(qty));
            $('#prices_' + rowIdx).val(price);
            $('#prices-text_' + rowIdx).text(allinDivider(price));
            $('#totals-text_' + rowIdx).text(newDivider1(newTotal));

            console.log(rowIdx, qty, price, subtotal, newTotal);
        }

        function updateDataProduct(iden) {
            var remarks = $('#remarks2_'+iden).val();
            $('#remarks1_'+iden).val(remarks);
            $('#remarks1_text_'+iden).text(remarks);
            
            var itemTotal = parseFloat($('#itemTotal_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            var count = parseFloat($('#count_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            var budget = parseFloat($('#budget_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
            var qty = parseFloat($('#qty2_' + iden).val()) || 0;
            var price = parseFloat($('#product-price2_' + iden).val()) || 0;
            var tots = parseFloat(price*qty) || 0;
            var total = Math.round(tots);

            if (budget != 0 && itemTotal <= count) {
                $('#total_' + iden).val(total);
            }else if (budget != 0 && itemTotal > count) {
                alert('Over Budget cannot update.');
                return false;
            }else if (budget == 0 && itemTotal <= count) {
                $('#total_' + iden).val(total);
            }else if (budget == 0 && itemTotal > count) {
                alert('Over Budget cannot update.');
                return false;
            }

            calculateGrandTotal();
            updateGrandTotal();

            $('#qty_' + iden).val(qty);
            $('#qty_text_' + iden).text(newDivider1(qty));
            $('#price_' + iden).val(price);
            $('#price_text_' + iden).text(newDivider1(price));
            $('#total_' + iden).val(total);
            $('#total_text_' + iden).text(newDivider1(total));
        }

        function updateDataProduct1(productIdx) {
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
            $('#total_' + productIdx).val(newTotal);

            // Memanggil fungsi untuk menghitung ulang grandTotal dan memperbarui tampilan
            calculateGrandTotal();
            updateGrandTotal();

            // Memperbarui nilai lain yang perlu diperbarui
            $('#qtys_' + productIdx).val(qty);
            $('#qtys-text_' + productIdx).text(allinDivider(qty));
            $('#prices_' + productIdx).val(price);
            $('#prices-text_' + productIdx).text(allinDivider(price));
            $('#totals-text_' + productIdx).text(newDivider1(newTotal));
            $('#grandtotal').val(newDivider1(grandTotal));
            $('#grandtotal1').val(grandTotal);

            // console.log(productIdx, qty, price, grandTotal, newTotal);
        }

        function updateGrandTotal() {
            $('#grandTotal_text').text(`${divider(grandTotal)}`);
            $('#grandTotal_text').val(`${divider(grandTotal)}`);
        }
        
        function deleteDataProduct(positionTableRow, total, dataFromDatabase) {
            const positionTableRowVariable = positionTableRow;
            const dataFromDatabaseVariable = dataFromDatabase;
            const csrf_token = $('meta[name="csrf-token"]').attr('content');
            
            console.log('grandTotal before:', grandTotal);
            console.log('total:', total);
            console.log('dataFromDatabaseVariable:', dataFromDatabaseVariable);
            console.log('positionTableRowVariable:', positionTableRowVariable);

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Want to Delete Purchase Detail!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                         // Remove the corresponding row using the iden
                         $(`#tableProductAddBody tr[id="row-${positionTableRowVariable}"]`).remove();
                            // Update grandTotal after removing the row
                            grandTotal -= parseFloat(total);    
                                        // Update the grandTotal field
                            $('#grandtotal').val(newDivider1(grandTotal));
                            $('#grandtotal1').val(grandTotal);
                            Swal.fire({
                                icon : 'success',
                                title: 'Deleted!',
                                text: `Purchase Detail has been Deleted.`,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                            if ($("#tableProductAddBody tr[id^='row-']").length === 0) {
                                $(".btn-rab").attr("disabled", false);
                                $("#selectAllRAB").attr("disabled", false);
                            }
                            calculateGrandTotal();
                            updateGrandTotal();
                    }
                });

            console.info('grandTotal after:', grandTotal);
            console.info('positionTableRowVariable: ', positionTableRowVariable);
            console.info('dataFromDatabaseVariable: ', dataFromDatabaseVariable);
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

        const dataProducts123 = <?=$PRDetail1?>;
        let tableRow123 = '';
        
        for (const value123 of dataProducts123) {
            // var iden = makeid(3);
            var idenas = dataProducts123.indexOf(value123);

            tableRow123 += `<tr id=row-${idenas}>
                            <td class="text-center"><input type="text" name="idenas[]" value="${idenas}" hidden/><input type="text" name="ids123_${idenas}" value="${value123.id_rab_item}" hidden/> <input type="text" name="idPR123_${idenas}" value="${value123.id_rab}" hidden/>${value123.id_rab_item}</td>
                            <td>${value123.name_rab_detail}<input type="text" name="idrec123_${idenas}" value="${value123.id}" hidden/><input type="text" name="unit123_${idenas}" value="${value123.unit}" hidden/><input type="text" name="createdat123_${idenas}" value="${value123.created_at}" hidden/></td>
                            <td class="text-right"><input type="text" name="qty123_${idenas}" id="qty_${idenas}" value="${newDivider2(value123.qty)}" hidden/><span id="qty_text_${idenas}">${newDivider1(value123.qty)}</span></td>
                            <td class="text-center">${value123.unit}<textarea name="status123_${idenas}" id="status_${idenas}" hidden>${value123.status}</textarea><input type="text" id="newbalances_${idenas}" name="newbalances123_${idenas}="${newDivider2(value123.balance)}" hidden/></td>
                            <td class="text-right"><input type="text" name="price123_${idenas}" id="price_${idenas}" value="${newDivider2(value123.amount)}" hidden/><span id="price_text_${idenas}">${newDivider1(value123.amount)}</span></td>
                            <td class="text-center">{{$dataPR->currency}}<input type="text" name="id_rab123_${idenas}" value="${value123.id_rab}" hidden/><input type="text" id="balanciaga123_${idenas}" name="balanciaga123_${idenas}" value="${newDivider2(value123.balance)}" hidden/></td>
                            <td class="text-right"><input type="text" name="total123_${idenas}" id="total_${idenas}" value="${value123.totalias !== null ? newDivider2(value123.totalias) : 0}" hidden/><input type="text" id="totalia_${idenas}" name="totalia123_${idenas}" value="${value123.totalias !== null ? newDivider2(value123.totalias) : 0}" hidden/><span id="total_text_${idenas}">${value123.totalias !== null ? newDivider1(value123.totalias) : 0}</span></td>
                            <td><textarea name="remarks1123_${idenas}" id="remarks1_${idenas}" hidden>${value123.remarks}</textarea><span id="remarks1_text_${idenas}">${value123.remarks === 'null' ? '' : (value123.remarks || '')}</span></td>
                                        </tr>`;
        }
        $(".tableProductAddBody23").find('tbody').append(tableRow123);
    </script>
    @endsection
</x-app-layout>