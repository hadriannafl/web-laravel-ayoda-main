<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Form RAB Request 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('rab.createga') }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="text-sm font-medium mb-1"
                        for="company">Company<span
                        class="text-rose-500">*</span>
                    </label>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                        <select id="company" name="company"
                            class="company form-select w-full md:w-3/4 px-2 py-1" required>
                            <option selected hidden value="">Select Company </option>
                            @foreach ( $dataChildCompany as $company )
                                <option value="{{$company->id_company}}">{{$company->name}}</option>
                            @endforeach
                        </select>
                    @else
                        <select id="companyTest" name="companyTest"
                            class="companyTest form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" disabled required>
                                <option value="{{$fixCompany->id_company}}" selected>{{$fixCompany->name}}</option>
                        </select>
                        <input id="company" name="company"
                        class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$fixCompany->id_company}}" readonly hidden/>
                    @endif
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1" for="formDate">Form Date<span
                        class="text-rose-500">*</span></label>
                    <input id="formDate" name="formDate" value="{{date('Y-m-d')}}"
                        class="formDate selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="periode">RAB Period<span
                        class="text-rose-500">*</span></label>
                    <input id="periode" name="periode" value="{{date('Y-m')}}"
                        class="periode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="month"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id" hidden>User</label>
                    <input id="name" name="name"
                        class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->username}}" readonly hidden/>
                    <input id="id" name="id"
                        class="id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->employee_id}}" readonly hidden/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="rabName">RAB Title<span
                        class="text-rose-500">*</span></label>
                    <input id="rabName" name="rabName"
                        class="rabName form-input w-full md:w-3/4 px-2 py-1" type="text" maxlength="100" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1"
                        for="rabType">RAB Type<span
                        class="text-rose-500">*</span>
                    </label>
                        <select id="rabType" name="rabType"
                            class="rabType form-select w-full md:w-3/4 px-2 py-1" required>
                            <option selected hidden value="">Select Type</option>
                            <option value="Advance Payment To Site">Advance Payment To Site</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Monthly Additional">Monthly Additional</option>
                            <option value="Project">Project</option>
                            <option value="Project Additional">Project Additional</option>
                        </select>
                </div>
                <div id="benef" hidden>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="payfrom">RAB Beneficiary Bank<span class="text-rose-500">*</span></label>
                        <select id="payfrom" name="payfrom" class="payfrom selector form-select w-full md:w-3/4 px-2 py-1" disabled>
                            <option value="" hidden selected>Select Beneficiary Bank</option>
                            @foreach ($cidBank as $cid)
                                <option value="{{ $cid->id_benef }}" 
                                        data-id_company="{{ $cid->id_company }}" 
                                        data-cidbank="{{ $cid->beneficiary_name }}" 
                                        data-bank_acc="{{ $cid->beneficiary_acc }}"
                                        data-bank_name="{{ $cid->beneficiary_bank }}"
                                        data-desc="{{ $cid->desc }}">
                                    {{ $cid->beneficiary_bank }} | {{ $cid->beneficiary_name }} | {{ $cid->beneficiary_acc }} | {{ $cid->desc }}
                                </option>
                            @endforeach
                        </select>
                        <input id="selectedBanks" name="selectedBanks" class="selectedBanks form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" hidden required readonly/>
                    </div>
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Bank / Account / Name<span
                            class="text-rose-500">*</span></label>
                            <div>
                                <select style="width: 20rem;" id="bank" name="bank" class="bank form-select w-full px-2 py-1" required>
                                    <option value="" hidden>Select Bank</option>
                                    @foreach ($bank as $bankir )
                                        <option value="{{$bankir->name}}">{{$bankir->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="width: 20rem; margin-right: 25.5px; margin-left:25.5px;">
                                <input id="number" name="number" class="number form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Beneficiary Account" required/>
                            </div>
                            <div>
                                <input id="account" name="account" style="width: 22rem;" class="account form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Beneficiary Account Name" required/>
                            </div>
                    </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1"
                        for="department">Department<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="deptSelected" name="deptSelected"
                    class="deptSelected form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden/>
                    <select id="department" name="department"
                        class="department form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Department</option>
                        @foreach ( $department as $depts )
                            <option value="{{$depts->id}}">{{$depts->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex md:flex-row mt-3">
                    <label class="block w-1/4 text-sm"></label>
                    <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white mr-5" id="clearDept">Change Department</button>
                </div>
                <div class="flex flex-col md:flex-row mb-3 mt-3">
                    <label class="text-sm font-medium mb-1" for="task_id">Add RAB Item<span
                    class="text-rose-500">*</span>
                    </label>
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn btn-rab bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal" disabled>
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
                                                <option value="FnB">Food and Beverages</option>
                                                <option value="Inventory">Inventory</option>
                                            </select>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="departements1" hidden>
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="unit">Department<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="category" name="category"
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
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
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
                        <span class="xs:block ml-5 mr-5">Save Form RAB Request</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>
$('#bank').select2();
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
$('#department').on('change', function (e) {
    const deptsName = $("#department option:selected").text();
    $('#assetInv').DataTable().ajax.reload();
    $(".btn-rab").attr("disabled", false);
    $("#department").attr("hidden", true);
    $("#deptSelected").val(deptsName);
    $("#deptSelected").attr("hidden", false);
    // $("#clearDept").attr("hidden", false);
})
$('#clearDept').on('click', function () {
    $(".btn-rab").attr("disabled", true);
    $("#department").attr("hidden", false);
    $("#department").val('');
    $("#deptSelected").val('');
    $("#deptSelected").attr("hidden", true);

    // Clear the table rows and reset subtotal
    $('#tableProductAddBody').empty();
    productIdx = 0;
    subtotal = 0;
    $('#grandtotal').val(`${divider(subtotal)}`);
    $('#grandtotal1').val(subtotal);
    var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="6">Grand Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(subtotal)}</span></td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);
});
$(document).ready(function() {
    // Function to filter payfrom options based on selected company
    function filterPayFromOptions(companyId) {
        $('#payfrom').prop('disabled', false).find('option').each(function() {
            var optionCompanyId = $(this).data('id_company'); // Corrected the data attribute selector
            if (optionCompanyId == companyId || optionCompanyId == "" || companyId == 0 || companyId == 888 || companyId == 999) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $('#payfrom').val('').trigger('change'); // Reset the select to prompt the user to pick again
    }

    // Function to populate input fields based on selected payfrom option
    function populatePayeeFields(selectedOption) {
        var bankName = selectedOption.data('bank_name');
        $('#bank').val(bankName).trigger('change');
        $('#number').val(selectedOption.data('bank_acc'));
        $('#account').val(selectedOption.data('cidbank'));
    }

    // Check the logged-in user's company_id
    var userCompanyId = {{ Auth::user()->company_id }};

    if (userCompanyId == 0 || userCompanyId == 888 || userCompanyId == 999) {
        // Enable company select field if user has special company_id
        $('#company').on('change', function() {
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
});

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
    // data product
    let productIdx = 0;
    let subtotal = 0;
    $(document).ready(function () {
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


        const $department = {!! json_encode($department) !!};
        $('#department').on('change', function () {
            const selectedDepartmentId = $(this).val();

            // Assuming $department is an array with objects having 'id' and 'name' properties
            const selectedDepartment = $department.find(dept => dept.id == selectedDepartmentId);

            if (selectedDepartment) {
                $('#category').val(selectedDepartment.name);
            } else {
                $('#category').val('');
            }
        });
        $('#rab_calc_type').on('change', function () {
            const rab_calc_type = $(this).val();

            if (rab_calc_type == "Custom") {
                $('#unit').val('');
                $('#qty').val('');
                $('#product_price').val('');
                $('#nama_product').val('');
                $('#itemTotal').val('');
                $('#detail').val('');
                $('#nama_product').val('');
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
                $('#dayscount').attr('hidden', true);
                $('#departements1').attr('hidden', false);
                $('#sub_departements1').attr('hidden', false);
            }else if (rab_calc_type == "FnB") {
                $('#unit').val('');
                $('#qty').val('');
                $('#product_price').val('');
                $('#itemTotal').val('');
                $('#detail').val('');
                $('#nama_product').val('');
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
        $("#addProduct").click(function () {
            var id = $('#rabItemId').val();
            var type = $('#rab_calc_type').val();
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
            var total = price2 * qty2 * days2;

            if (type == "Inventory") {
                console.log($('#tableProductAddBody').find(`[name*="[ids]"][value="${id}"]`));
                // Check if the product with the same id already exists for Inventory type
                if ($('#tableProductAddBody').find(`[name*="[ids]"][value="${id}"]`).length > 0) {
                    alert('Same Inventory Asset cannot be added again.');
                    return false;
                }
            } else {
                // Check if the product with the same id already exists for other types
                if ($('#tableProductAddBody').find(`[name*="[ids_$(iden)]"][value="${id}"]`).length > 0) {
                    alert('Same Asset cannot be added again.');
                    return false;
                }
            }

            if (name === '' || price2 === '' || qty2 === '' || !unit || !total || !name || !price || !qty) {
                    // subtotal == 0;
                    return false;
                }
                // Update subtotal
                subtotal += total;
                console.log(productIdx)
                if (type == "Inventory") {
                    var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                    "  <td class=\"text-left\">" + category + "<textarea name = \"rows[" + productIdx + "][categorys]\" hidden>" + category + "</textarea></td>\n" +
                    "  <td class=\"text-left\">" + detail + "<textarea name = \"rows[" + productIdx + "][sub_categorys]\" hidden>" + detail + "</textarea></td>\n" +
                    "  <td class=\"text-left\">" + name + "<input type=\"hidden\" name = \"rows[" + productIdx + "][ids]\"value =" + id + "><textarea name = \"rows[" + productIdx + "][namesis]\" hidden>" + name + "</textarea></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(qty)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][qtys]\" value =" + qty2 + "></td>\n" +
                    "  <td class=\"text-center\">" + unit + "<textarea name = \"rows[" + productIdx + "][units]\" hidden>" + unit + "</textarea></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(price)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][prices]\" value =" + price2 + "><textarea name = \"rows[" + productIdx + "][rabCalcTypes]\" hidden>" + type + "</textarea></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(total)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][totals]\" value =" + total + "><input type=\"hidden\" name = \"rows[" + productIdx + "][dayss]\" value =" + days2 + "></td>\n" +
                    // "  <td class=\"text-right\">" + `${divider(oq1)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][oqs]\" value =" + oq1 + "></td>\n" +
                    "  <td class=\"text-left\">" + remarks + "<textarea name = \"rows[" + productIdx + "][remarkss]\" hidden>" + remarks + "</textarea></td>\n" +
                    "  <td class=\"text-center flex flex-row justify-center\">" +
                    "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + total + "," + null + ")\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" ><svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg></button><button type=\"button\" class=\"icon-tabler-arrow-up1 btn border-slate-200 hover:border-slate-300\" ><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-tabler icon-tabler-arrow-up\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"#2c3e50\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M12 5l0 14\" /><path d=\"M18 11l-6 -6\" /><path d=\"M6 11l6 -6\" /></svg></button><button type=\"button\" class=\"icon-tabler-arrow-down1 btn border-slate-200 hover:border-slate-300\" ><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-tabler icon-tabler-arrow-down\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"#2c3e50\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M12 5l0 14\" /><path d=\"M18 13l-6 6\" /><path d=\"M6 13l6 6\" /> </svg></button></td>\n" +
                    "</tr>";   
                } else if(type == "FnB") {
                    var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                    "  <td class=\"text-left\">" + category + "<textarea name = \"rows[" + productIdx + "][categorys]\" hidden>" + category + "</textarea></td>\n" +
                    "  <td class=\"text-left\">" + detail + "<textarea name = \"rows[" + productIdx + "][sub_categorys]\" hidden>" + detail + "</textarea></td>\n" +
                    "  <td class=\"text-left\">" + name + "<input type=\"hidden\" name = \"rows[" + productIdx + "][ids]\"value =" + id + "" + productIdx + "><textarea name = \"rows[" + productIdx + "][namesis]\" hidden>" + name + "</textarea></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(qty)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][qtys]\" value =" + qty2 + "></td>\n" +
                    "  <td class=\"text-center\">" + unit + "<textarea name = \"rows[" + productIdx + "][units]\" hidden/>" + unit + "</textarea></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(price)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][prices]\" value =" + price2 + "><textarea name = \"rows[" + productIdx + "][rabCalcTypes]\" hidden>" + type + "</textarea></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(total)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][totals]\" value =" + total + "><input type=\"hidden\" name = \"rows[" + productIdx + "][dayss]\" value =" + days2 + "></td>\n" +
                    // "  <td class=\"text-right\">" + `${divider(oq1)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][oqs]\" value =" + oq1 + "></td>\n" +
                    "  <td class=\"text-left\">" + remarks + "<textarea name = \"rows[" + productIdx + "][remarkss]\" hidden>" + remarks + "</textarea></td>\n" +
                    "  <td class=\"text-center flex flex-row justify-center\">" +
                    "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + total + "," + null + ")\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" ><svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg></button><button type=\"button\" class=\"icon-tabler-arrow-up1 btn border-slate-200 hover:border-slate-300\" ><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-tabler icon-tabler-arrow-up\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"#2c3e50\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M12 5l0 14\" /><path d=\"M18 11l-6 -6\" /><path d=\"M6 11l6 -6\" /></svg></button><button type=\"button\" class=\"icon-tabler-arrow-down1 btn border-slate-200 hover:border-slate-300\" ><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-tabler icon-tabler-arrow-down\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"#2c3e50\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M12 5l0 14\" /><path d=\"M18 13l-6 6\" /><path d=\"M6 13l6 6\" /> </svg></button></td>\n" +
                    "</tr>";  
                } else if(type == "Custom") {
                    var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                    "  <td class=\"text-left\">" + category + "<textarea name = \"rows[" + productIdx + "][categorys]\" hidden>" + category + "</textarea></td>\n" +
                    "  <td class=\"text-left\">" + detail + "<textarea name = \"rows[" + productIdx + "][sub_categorys]\" hidden>" + detail + "</textarea></td>\n" +
                    "  <td class=\"text-left\">" + name + "<input type=\"hidden\" name = \"rows[" + productIdx + "][ids]\"value =" + id + "" + productIdx + "><textarea name = \"rows[" + productIdx + "][namesis]\" hidden>" + name + "</textarea></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(qty)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][qtys]\" value =" + qty2 + "></td>\n" +
                    "  <td class=\"text-center\">" + unit + "<textarea name = \"rows[" + productIdx + "][units]\" hidden>" + unit + "</textarea></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(price)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][prices]\" value =" + price2 + "><textarea name = \"rows[" + productIdx + "][rabCalcTypes]\" hidden>" + type + "</textarea></td>\n" +
                    "  <td class=\"text-right\">" + `${divider(total)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][totals]\" value =" + total + "><input type=\"hidden\" name = \"rows[" + productIdx + "][dayss]\" value =" + days2 + "></td>\n" +
                    // "  <td class=\"text-right\">" + `${divider(oq1)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][oqs]\" value =" + oq1 + "></td>\n" +
                    "  <td class=\"text-left\">" + remarks + "<textarea name = \"rows[" + productIdx + "][remarkss]\" hidden>" + remarks + "</textarea></td>\n" +
                    "  <td class=\"text-center flex flex-row justify-center\">" +
                    "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + total + "," + null + ")\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" ><svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg></button><button type=\"button\" class=\"icon-tabler-arrow-up1 btn border-slate-200 hover:border-slate-300\" ><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-tabler icon-tabler-arrow-up\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"#2c3e50\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M12 5l0 14\" /><path d=\"M18 11l-6 -6\" /><path d=\"M6 11l6 -6\" /></svg></button><button type=\"button\" class=\"icon-tabler-arrow-down1 btn border-slate-200 hover:border-slate-300\" ><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-tabler icon-tabler-arrow-down\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"#2c3e50\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M12 5l0 14\" /><path d=\"M18 13l-6 6\" /><path d=\"M6 13l6 6\" /> </svg></button></td>\n" +
                    "</tr>";  
                }

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
                $('#grandtotal').val(`${divider(subtotal)}`);
                $('#grandtotal1').val(subtotal);
                updateGrandTotal();

                productIdx++;
                // productIdx++;
                var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
                grandTotalRow.detach();
                $("#tableProductAddBody").append(grandTotalRow);
        });
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="6">Grand Total</td>
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

    // "<button type=\"button\" class=\"icon-tabler-arrow-up1 btn border-slate-200 hover:border-slate-300\" ><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-tabler icon-tabler-arrow-up\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"#2c3e50\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M12 5l0 14\" /><path d=\"M18 11l-6 -6\" /><path d=\"M6 11l6 -6\" /></svg></button>" +
    // "<button type=\"button\" class=\"icon-tabler-arrow-down1 btn border-slate-200 hover:border-slate-300\" ><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-tabler icon-tabler-arrow-down\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"#2c3e50\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M12 5l0 14\" /><path d=\"M18 13l-6 6\" /><path d=\"M6 13l6 6\" /> </svg></button>" +
    function deleteDataProduct(positionTableRow, total) {
        subtotal -= total;

        // Remove the row with the specified position
        $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();

        // Update the productIdx attribute in the remaining rows
        updateProductIdxAttributes();

        // Update the grand total
        $('#grandtotal').val(`${divider(subtotal)}`);
        $('#grandtotal1').val(subtotal);
        updateGrandTotal();

        console.info('positionTableRow: ', positionTableRow);
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
</script>
@endsection
</x-app-layout>