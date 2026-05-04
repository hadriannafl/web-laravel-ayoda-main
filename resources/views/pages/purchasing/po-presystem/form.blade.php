<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">PO Pre System Form 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('po-presystem.create') }}" id="myForm">
                @csrf
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                <div class="flex justify-between flex-col md:flex-row">
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
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1"
                        for="company">Company<span
                        class="text-rose-500">*</span>
                    </label>
                        <input id="companyTest" name="companyTest" class="companyTest form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$fixCompany->name}}" readonly required>
                        <input id="company" name="company"
                        class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$fixCompany->id_company}}" readonly hidden/>
                </div>
                @endif
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="date_po">PO Date<span
                        class="text-rose-500">*</span></label>
                    <input id="date_po" name="date_po" value="{{date('Y-m-d')}}"
                        class="date_po selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="due_date">Due Date<span
                        class="text-rose-500">*</span></label>
                    <input id="due_date" name="due_date" value="{{date('Y-m-d')}}"
                        class="due_date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="employee1">User Request<span
                        class="text-rose-500">*</span>
                    </label>
                    <input class="idemployee form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="idemployee" name="idemployee" hidden readonly/>
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
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1">PO # / Invoice # / RAB #<span class="text-rose-500">*</span></label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="no_po" name="no_po" class="no_po form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Purchase Order #" required/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="no_invoice" name="no_invoice" class="no_invoice form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Invoice #" required/>
                        </div>
                        <div>
                            <input id="no_rab" style="width: 21.2rem;" name="no_rab" class="no_rab form-input w-full px-2 py-1 read-only:bg-slate-200" placeholder="RAB #" type="text" required/>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="reff">PO title<span class="text-rose-500">*</span>
                    </label>
                    <input id="po_title" name="po_title" class="po_title form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1"
                        for="idsupplier">Supplier<span
                        class="text-rose-500">*</span>
                    </label>
                        <select id="idsupplier" name="idsupplier"
                            class="idsupplier form-select w-full md:w-3/4 px-2 py-1" required>
                            <option selected hidden value="">Select Supplier </option>
                            @foreach ( $supplier as $item )
                                <option value="{{$item->idsupplier}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Upload Attachment PO<span
                        class="text-rose-500">*</span>&nbsp;: </label>
                    <input id="file" name="file" class="file form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                    <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">File max size 12MB</div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Currency / Exchange Rate<span
                        class="text-rose-500">*</span></label>
                        <div style="width: 31rem; margin-right: 41px;">
                            <input id="currencySelected" name="currencySelected"
                            class="currencySelected form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden/>
                            <select id="currency" name="currency"
                                class="currency form-select w-full px-2 py-1" required>
                                <option selected hidden value="">Select Currency</option>
                                @foreach ( $currency as $cur )
                                <option value="{{$cur->currency}}">{{$cur->symbol}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <input id="crate" name="crate" style="width: 31.7rem;" class="crate form-input numeric-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="1" readonly required/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1">Total / VAT / Grand Total<span class="text-rose-500">*</span></label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="total" name="total" class="total numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Total" required/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="ppn" name="ppn" class="ppn numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" placeholder="VAT" type="text" required/>
                        </div>
                        <div>
                            <input id="gtotal" style="width: 21.2rem;" name="gtotal" class="gtotal numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Grand Total" required readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1">WHT / Amount Due<span class="text-rose-500">*</span></label>
                        <div style="width: 31rem; margin-right: 41px;">
                            <input id="wht" name="wht" class="wht numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="WHT" required/>
                        </div>
                        <div>
                            <input id="amount_due" style="width: 31.7rem;" name="amount_due" class="amount_due numeric-input form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Amount Due" required readonly/>
                        </div>
                </div>
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Submit PO Pre System</span>
                </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script> 
$('#idsupplier').select2();
$('#department').on('change', function (e) {
    $('#assetInv').DataTable().ajax.reload();
})
$('#clearCompany').on('click', function () {
    $("#company").attr("hidden", false);
    $("#companyTest").attr("hidden", true);
    $("#companyTest").val('');

    $('#detail_employee').attr('hidden', true);
    $("#employee").val('');
    $("#employee1").val('');
    $("#department1").val('');
    $("#division").val('');
    $("#department1").attr("readonly", true);
    $("#division").attr("readonly", true);
    $('#employees-button').attr('disabled', true);

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
    $('#company').on('change', function (e) {
        const compName = $("#company option:selected").text();
        $("#company").attr("hidden", true);
        $("#clearCompany").attr("hidden", false);
        $("#companyTest").attr("hidden", false);
        $("#companyTest").val(compName);
        $('#employee-table').DataTable().ajax.reload();
        $('#employees-button').attr('disabled', false);
    })
    $('#employee-table').on("click", ".btn-select", function () {
        const id = $(this).data("id");
        const name = $(this).data("nama");
        const company = $(this).data("company");
        const company_name = $(this).data("company_name");
        const department1 = $(this).data("department");
        const position = $(this).data("position");
                        
        $('#detail_employee').removeAttr('hidden');
        $("#idemployee").val(id);
        $("#employee1").val(name);
        $("#department1").val(department1);
        $("#division").val(position);
        $("#department1").attr("readonly", true);
        $("#division").attr("readonly", true);
    });
});
$('#currency').on('change', function (e) {
    const curs = $(this).val();

    if (curs == 'IDR') {
        $("#crate").attr("readonly", true);
        $("#crate").val("1");
    }else{
        $("#crate").attr("readonly", false);
    }
})
function calculateGrandTotal() {
    const total = parseFloat($('#total').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
    const VAT = parseFloat($('#ppn').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
    const grandtotal = total + VAT;
    const roundedGrandTotal = Math.ceil(grandtotal);
    $('#gtotal').val(divider(roundedGrandTotal)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
    // $('#gtotal').val(divider(subtotals));
}
function calculateAmountDue() {
    const gtotal = parseFloat($('#gtotal').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
    const WHT = parseFloat($('#wht').val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
    const amountDue = gtotal - WHT;
    const roundedAmountDue = Math.ceil(amountDue);
    $('#amount_due').val(divider(roundedAmountDue)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
}

$('#total, #gtotal, #ppn').on('input', function() {
    calculateGrandTotal();
    calculateAmountDue();
});

$('#gtotal, #wht, #amount_due').on('input', function() {
    calculateGrandTotal();
    calculateAmountDue();
});
$('#ppn').on('change', function() {
    calculateGrandTotal();
    calculateAmountDue();
});
$('#wht').on('change', function() {
    calculateGrandTotal();
    calculateAmountDue();
});
$('#myForm').submit(function (e, params) {
            e.preventDefault();
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
                    if (_response.st == '1') {
                        Swal.fire({
                            title: 'Success',
                            text: 'PO Pre System has been Created',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                urlRedirect = '/purchasing/po-presystem/request';
                                window.open(urlRedirect, '_self');
                            }else {
                                urlRedirect = '/purchasing/po-presystem/request';
                                window.open(urlRedirect, '_self');
                            }
                        });
                        urlRedirect = '/purchasing/po-presystem/request';
                        window.open(urlRedirect, '_self');
                        // Swal.fire({
                        //     title: 'Success',
                        //     text: 'Reimburse #' + RRID + ' Has Been Created',
                        //     icon: 'success',
                        //     showCancelButton: false,
                        //     confirmButtonText: 'Ok',
                        //     cancelButtonText: 'No, cancel'
                        // }).then((result) => {
                        //     if (result.isConfirmed) {
                        //         Swal.close();
                        //     }else {
                        //         Swal.close();
                        //     }
                        // });
                    }else if (_response.st == '2') {
                        Swal.fire({
                            title: 'File to Large',
                            text: 'Please Compress File',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }else {
                                Swal.close();
                            }
                        });
                    }else if (_response.st == '3') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Invoice Already Exist',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }else {
                                Swal.close();
                            }
                        });
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