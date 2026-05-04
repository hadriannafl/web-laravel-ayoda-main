<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Payment 💳
                </h1>
            </div>
        </div>

        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-sm text-slate-800 mb-3 mt-2" for="lastentry">FROM :</p>
                <input id="min" class="text-sm flex flex-row ml-3 mb-3" type="date"/>
                <p class="flex flex-row text-sm text-slate-800 mb-3 ml-5 mt-2" for="lastentry">TO :</p>
                <input id="max" class="text-sm flex flex-row ml-3 mb-3" type="date"/>
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="company">Company :</p>
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company">
                        <option value="" selected>All</option>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                @else
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company" hidden>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}" {{ Auth::user()->company_id == $company->id_company ? ' selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                @endif
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="status">Status :</p>
                <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                    <option value="">All</option>
                    <option value="A/P">A/P</option>
                    <option value="Paid">Paid</option>
                    <option value="Partial">Partial</option>
                </select>  
                <button id="btn-search" class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-5 mb-3" type="button">
                    <span class="xs:block">Search</span>
                </button>
                {{-- <input type="text" id="balance" name="balance" class="balance bg-slate-200 form-input flex flex-row ml-3 mb-3 text-xs" value="0" readonly hidden/> --}}
            </label>
        </div>
        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <a href="{{ route('form.payment') }}" class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>&nbsp; New Payment</a> 
            </label>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="payment" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Due Date</th>
                        <th class="text-center">Form Date</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Reff #</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">VAT</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">WHT</th>
                        <th class="text-center">Balance A/P</th>
                        <th class="text-center">Applicant</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>  
        // Get today's date
        const today = new Date();

        // Function to format date to YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Calculate date 30 days ago
        const minDate = new Date(today);
        minDate.setDate(minDate.getDate() - 30);

        // Calculate date 3 days from now
        const maxDate = new Date(today);
        maxDate.setDate(maxDate.getDate() + 3);

        // Set the initial values for the input fields
        document.getElementById('min').value = formatDate(minDate);
        document.getElementById('max').value = formatDate(maxDate);

        // Calculate the max allowed date which is 3 months after min date
        const maxAllowedDate = new Date(minDate);
        maxAllowedDate.setMonth(maxAllowedDate.getMonth() + 3);

        const btnSearch = document.getElementById('btn-search');

        // Function to validate dates and toggle button state
        function validateDates() {
            const minInputDate = new Date(document.getElementById('min').value);
            const maxInputDate = new Date(document.getElementById('max').value);
            const newMaxAllowedDate = new Date(minInputDate);
            newMaxAllowedDate.setMonth(newMaxAllowedDate.getMonth() + 3);

            if (maxInputDate > newMaxAllowedDate || minInputDate > maxInputDate) {
                alert(`The "TO" date must be within 3 months of the "FROM" date, and cannot be earlier than the "FROM" date.`);
                btnSearch.disabled = true;
            } else {
                btnSearch.disabled = false;
            }
        }

        // Add event listeners to the input fields
        document.getElementById('min').addEventListener('change', function () {
            const minInputDate = new Date(this.value);
            const maxInputDate = new Date(document.getElementById('max').value);

            if (maxInputDate > maxAllowedDate || minInputDate > maxInputDate || minInputDate < maxInputDate) {
                validateDates();
            } else {
                btnSearch.disabled = false;
            }
        });

        document.getElementById('max').addEventListener('change', function () {
            validateDates();
        });

        // Initial validation
        validateDates();
         $(document).ready(function () {
            $('#payment').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Payment: "
                },
                ajax: {
                    url: "{{ route('payment-list.getdata') }}",
                    data:function(d){
                        d.from = $("#min").val()
                        d.to = $("#max").val()
                        d.company = $("#company").val()
                        d.status = $("#status").val()
                    }
                },
                columns: [
                    {
                        data: "due_date",
                        name: "due_date"
                    },
                    {
                        data: "date",
                        name: "date"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "id_costpayment",
                        name: "id_costpayment"
                    },
                    {
                        data: "subtotal",
                        name: "subtotal"
                    },
                    {
                        data: "vat",
                        name: "vat"
                    },
                    {
                        data: "total",
                        name: "total"
                    },
                    {
                        data: "wht",
                        name: "wht"
                    },
                    {
                        data: "balance",
                        name: "balance"
                    },
                    {
                        data: "created_by",
                        name: "created_by"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 10] },
                    { className: 'text-right', targets: [4, 5, 6, 7, 8] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $("#btn-search").on("click", function () {
                $('#payment').DataTable().ajax.reload();
            });

            $('#payment').on("click", ".btn-modal", function () {
                const id = $(this).data("id");
                const id_cp = $(this).data('id_cp');
                const company = $(this).data("company");
                const form_type = $(this).data("form_type");
                const date = $(this).data("date");
                const due_date = $(this).data("due_date");
                const status = $(this).data("status");
                const applicant = $(this).data("applicant");
                const currency = $(this).data("currency");
                const crate = $(this).data("crate");
                const subtotal = $(this).data("subtotal");
                const vat = $(this).data("vat");
                const total = $(this).data("total");
                const wht = $(this).data("wht");
                const total_paid = $(this).data("total_paid");
                const approved_total = $(this).data("approved_total");
                const dp_amount = $(this).data("dp_amount");
                const beneficiary_bank = $(this).data("beneficiary_bank");
                const beneficiary_name = $(this).data("beneficiary_name");
                const beneficiary_acc = $(this).data("beneficiary_acc");
                const balance = $(this).data("balance");
                const balance_wht = $(this).data("balance_wht");
                const created_by = $(this).data("created_by");

                $.ajax({
                    type: "GET",
                    url: `/finance/payment/list/getdatadetail/${id}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Form Date / Due Date / Reff #</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${date}" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${due_date}" readonly>
                                                </div>
                                                <div>
                                                    <input id="id_cp" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${id_cp}" readonly/>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Form Type / Status / Created By</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${form_type}" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${status}" readonly>
                                                </div>
                                                <div>
                                                    <input id="created_by" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${created_by}" readonly/>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Applicant / Company / Beneficiary Bank</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${applicant}" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="company" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${company}" readonly/>
                                                </div>
                                                <div>
                                                    <div style="width: 30rem;">
                                                        <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="${beneficiary_bank}" type="text" readonly/>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Name / Account / Currency</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="${beneficiary_bank == 'Cash' ? beneficiary_name : ''}" type="text" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${beneficiary_bank == 'Cash' ? beneficiary_acc : ''}" readonly>
                                                </div>
                                                <div>
                                                    <input id="benef_acc" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${currency}" readonly/>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Cross Rate / WHT / 'G.Total A/P'</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="total_amount" value="${newDivider1(crate)}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="total_paid" value="${newDivider1(balance_wht)}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly>
                                                </div>
                                                <div>
                                                    <input id="balance" value="${newDivider1(total_paid)}" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                                </div>
                                        </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Cost/Reimburse Detail</label>
                                    </div>
                                    <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-xs text-center">Date</th>
                                                <th class="text-xs text-center">Type</th>
                                                <th class="text-xs text-center">Reff#</th>
                                                <th class="text-xs text-center">Description</th>
                                                <th class="text-xs text-center">Subtotal</th>
                                                <th class="text-xs text-center">VAT Type</th>
                                                <th class="text-xs text-center">VAT</th>
                                                <th class="text-xs text-center">WHT Type</th>
                                                <th class="text-xs text-center">WHT</th>
                                                <th class="text-xs text-center">Total Paid</th>
                                                <th class="text-xs text-center">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                            </div>
                        `); 
                        let tableRow = '';
                        if (form_type == 'Cost Center') {
                            for (const value of response) {
                                tableRow += `<tr>
                                    <td class="text-center text-xs">${value.date}</td>
                                    <td class="text-xs">${value.cost_type}</td>
                                    <td class="text-xs text-center">${value.invoice_number === 'null' ? '' : (value.invoice_number || '')}</td>
                                    <td class="text-xs">${value.desc}</td>
                                    <td class="text-xs text-right">${newDivider1(value.subtotal)}</td>
                                    <td class="text-xs">${value.vat === 'null' ? '' : (value.vat || '')}</td>
                                    <td class="text-xs text-right">${newDivider1(value.total_vat)}</td>
                                    <td class="text-xs">${value.wht === 'null' ? '' : (value.wht || '')}</td>
                                    <td class="text-xs text-right">${newDivider1(value.total_wht)}</td>
                                    <td class="text-xs text-right">${newDivider1(value.paid_total)}</td>
                                    <td class="text-xs">${value.remarks === 'null' ? '' : (value.remarks || '')}</td>
                                            </tr>`;
                            }
                        } else if (form_type == 'Reimburse') {
                            for (const value of response) {
                                tableRow += `<tr>
                                    <td class="text-center text-xs">${value.date}</td>
                                    <td class="text-xs">${value.reimburse_type}</td>
                                    <td class="text-xs text-center">${value.no_vehicle === 'null' ? '' : (value.no_vehicle || '')}</td>
                                    <td class="text-xs">${value.reimburse_to}</td>
                                    <td class="text-xs text-right">${newDivider1(value.subtotal)}</td>
                                    <td class="text-xs">${value.vat === 'null' ? '' : (value.vat || '')}</td>
                                    <td class="text-xs text-right">${newDivider1(value.total_vat)}</td>
                                    <td class="text-xs">${value.wht === 'null' ? '' : (value.wht || '')}</td>
                                    <td class="text-xs text-right">${newDivider1(value.total_wht)}</td>
                                    <td class="text-xs text-right">${newDivider1(value.paid_total)}</td>
                                    <td class="text-xs">${value.remarks === 'null' ? '' : (value.remarks || '')}</td>
                                            </tr>`;
                            }
                        } else if (form_type == 'RAB') {
                            for (const value of response) {
                                tableRow += `<tr>
                                    <td class="text-center text-xs">${value.date_rab}</td>
                                    <td class="text-xs">${value.rab_calc_type}</td>
                                    <td class="text-xs text-center">${value.id_rab === 'null' ? '' : (value.id_rab || '')}</td>
                                    <td class="text-xs">${value.name_rab_detail}</td>
                                    <td class="text-xs text-right">${newDivider1(value.total)}</td>
                                    <td class="text-xs">-</td>
                                    <td class="text-xs text-right">0</td>
                                    <td class="text-xs">-</td>
                                    <td class="text-xs text-right">0</td>
                                    <td class="text-xs text-right">${newDivider1(value.total)}</td>
                                    <td class="text-xs">${value.remarks === 'null' ? '' : (value.remarks || '')}</td>
                                            </tr>`;
                            }
                        } else if (form_type == 'PO') {
                            for (const value of response) {
                                tableRow += `<tr>
                                    <td class="text-center text-xs">${value.date_po}</td>
                                    <td class="text-xs">PO Pre System</td>
                                    <td class="text-xs text-center">${value.no_po === 'null' ? '' : (value.no_po || '')}</td>
                                    <td class="text-xs">${value.po_title}</td>
                                    <td class="text-xs text-right">${newDivider1(value.total)}</td>
                                    <td class="text-xs">-</td>
                                    <td class="text-xs text-right">${newDivider1(value.ppn)}</td>
                                    <td class="text-xs">-</td>
                                    <td class="text-xs text-right">${newDivider1(value.wht)}</td>
                                    <td class="text-xs text-right">${newDivider1(value.amount_due)}</td>
                                    <td class="text-xs">-</td>
                                            </tr>`;
                            }
                        }
                        $(".tableProductAddBody").find('tbody').append(tableRow);
                        if (form_type == 'Cost Center') {
                            if (dp_amount == 0) {
                                var grandTotalRow = `<tr class="totalRow">  
                                    <td class="text-center font-bold text-sm" colspan="4">Grand Total Cost Center</td>
                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(subtotal)}</td>
                                    <td></td>
                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(vat)}</td>
                                    <td></td>
                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(wht)}</td>
                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(total_paid)}</td>
                                    <td></td>
                                </tr>`;
                            }else{
                                var grandTotalRow = `<tr class="totalRow">   
                                    <td class="text-center font-bold text-sm" colspan="4">Total Cost Center</td>
                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(subtotal)}</td>
                                    <td></td>
                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(vat)}</td>
                                    <td></td>
                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(wht)}</td>
                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(total_paid)}</td>
                                    <td></td>
                                </tr>
                                <tr class="DPRow">
                                    <td class="text-center font-bold text-sm" colspan="4">Previous DP</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right font-bold text-sm" id="previousDP_text">-${newDivider1(dp_amount)}</td>
                                    <td></td>
                                </tr>
                                <tr class="gradTotalRow">
                                    <td class="text-center font-bold text-sm" colspan="4">Grand Total Cost Center</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right font-bold text-sm" id="grandeTotal_text">${newDivider1(balance)}</td>
                                    <td></td>
                                </tr>`;
                            }
                        }else if (form_type == 'Reimburse'){
                            var grandTotalRow = `<tr>
                                                    <td class="text-center font-bold text-sm" colspan="6">Grand Total</td>
                                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(vat)}</td>
                                                    <td></td>
                                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(wht)}</td>
                                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(total_paid)}</td>
                                                    <td></td>
                                                </tr>
                                                <tr ${approved_total == 0 ? 'hidden' : ''}>
                                                    <td class="text-center font-bold text-sm" colspan="6">Approved Paid</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-right font-bold text-sm">${newDivider1(approved_total)}</td>   
                                                    <td></td>
                                                </tr>`;
                        }else if (form_type == 'RAB'){
                            var grandTotalRow = `<tr>
                                                    <td class="text-center font-bold text-sm" colspan="6">Grand Total</td>
                                                    <td class="text-right font-bold text-sm" id="grandTotal_text"></td>
                                                    <td></td>
                                                    <td class="text-right font-bold text-sm" id="grandTotal_text"></td>
                                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(total_paid)}</td>
                                                    <td></td>
                                                </tr>`;
                        }else if (form_type == 'PO'){
                            var grandTotalRow = `<tr>
                                                    <td class="text-center font-bold text-sm" colspan="6">Grand Total</td>
                                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(vat)}</td>
                                                    <td></td>
                                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(wht)}</td>
                                                    <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(approved_total)}</td>
                                                    <td></td>
                                                </tr>`;
                        }
                        $(".tableProductAddBody").append(grandTotalRow);
                    },
                });
            });

            $('#payment').on("click", ".btn-pay", function () {
                const id = $(this).data("id");
                const id_cp = $(this).data('id_cp');
                const company = $(this).data("company");
                const form_type = $(this).data("form_type");
                const date = $(this).data("date");
                const due_date = $(this).data("due_date");
                const status = $(this).data("status");
                const applicant = $(this).data("applicant");
                const currency = $(this).data("currency");
                const crate = $(this).data("crate");
                const subtotal = $(this).data("subtotal");
                const vat = $(this).data("vat");
                const total = $(this).data("total");
                const wht = $(this).data("wht");
                const total_paid = $(this).data("total_paid");
                const approved_total = $(this).data("approved_total");
                const dp_amount = $(this).data("dp_amount");
                const beneficiary_bank = $(this).data("beneficiary_bank");
                const beneficiary_name = $(this).data("beneficiary_name");
                const beneficiary_acc = $(this).data("beneficiary_acc");
                const balance = $(this).data("balance");
                const balance_wht = $(this).data("balance_wht");
                const created_by = $(this).data("created_by");

                $.ajax({
                    type: "GET",
                    url: `/finance/payment/list/paydetail/${id}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Form Date / Due Date / Reff #</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${date}" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${due_date}" readonly>
                                                </div>
                                                <div>
                                                    <input id="id_cp" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${id_cp}" readonly/>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Form Type / Status / Created By</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${form_type}" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${status}" readonly>
                                                </div>
                                                <div>
                                                    <input id="created_by" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${created_by}" readonly/>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Applicant / Company / Beneficiary Bank</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${applicant}" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="company" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${company}" readonly/>
                                                </div>
                                                <div>
                                                    <div style="width: 30rem;">
                                                        <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="${beneficiary_bank}" type="text" readonly/>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Name / Account / Currency</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="${beneficiary_bank == 'Cash' ? beneficiary_name : ''}" type="text" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${beneficiary_bank == 'Cash' ? beneficiary_acc : ''}" readonly>
                                                </div>
                                                <div>
                                                    <input id="benef_acc" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${currency}" readonly/>
                                                </div>
                                        </div>
                                        <div class="flex flex-row mb-3 mt-3">
                                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Cross Rate / WHT / 'G.Total A/P'</label>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="total_amount" value="${newDivider1(crate)}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                                </div>
                                                <div style="width: 30rem; margin-right: 20px;">
                                                    <input id="total_paid" value="${newDivider1(balance_wht)}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly>
                                                </div>
                                                <div>
                                                    <input id="balance" value="${newDivider1(total_paid)}" style="width: 30rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                                </div>
                                        </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Payment History Detail</label>
                                    </div>
                                    <table class="table table-bordered mt-1 mb-2 tableProductAddBody1" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-xs text-center">Payment Date</th>
                                                <th class="text-xs text-center">Payment Voucher #</th>
                                                <th class="text-xs text-center">Payee Bank</th>
                                                <th class="text-xs text-center">Payee Number</th>
                                                <th class="text-xs text-center">Amount</th>
                                                <th class="text-xs text-center">Bank Charge</th>
                                                <th class="text-xs text-center">Duty Stamp Charge</th>
                                                <th class="text-xs text-center">Others Charge</th>
                                                <th class="text-xs text-center">Previous Payment</th>
                                                <th class="text-xs text-center">Amount Paid</th>
                                                <th class="text-xs text-center">Payment Status</th>
                                                <th class="text-xs text-center">Attachment</th>
                                                <th class="text-xs text-center">Invoice Attachment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                            </div>
                        `); 
                        let tableRow = '';
                        let totalAmount = 0;
                        for (const value of response) {
                            const rowStyle = value.aktif === 'Canceled' ? 'style="background-color: red;"' : '';
                            tableRow += `<tr ${rowStyle}>
                                <td class="text-right text-xs">${value.payment_date}</td>
                                <td class="text-xs text-center">${value.id_payment}</td>
                                <td class="text-xs">${value.payee_bank === 'null' ? '' : (value.payee_bank || 'Cash')}</td>
                                <td class="text-xs">${value.payee_number === 'null' ? '' : (value.payee_number || 'Cash')}</td>
                                <td class="text-xs text-right">${newDivider1(value.amount_paid)}</td>
                                <td class="text-xs text-right">${newDivider1(value.bank_charge)}</td>
                                <td class="text-xs text-right">${newDivider1(value.duty_stamp_charge)}</td>
                                <td class="text-xs text-right">${newDivider1(value.other_charge)}</td>
                                <td class="text-xs text-right">${value.previous_payment === null || value.previous_payment === 'null' || value.previous_payment === '0' ? '0' : (newDivider1(value.previous_payment) || '0')}</td>
                                <td class="text-xs text-right">${newDivider1(value.total_amount)}</td>
                                <td class="text-xs text-center">${value.aktif}</td>
                                <td class="text-xs text-center">
                                    <a href="/finance/payment/list/viewfile/${value.idrec}" target="_blank" class="btn btn-sm btn-print text-sm text-white bg-sky-500 hover:bg-sky-600 ml-1" ${value.file_stat == '1' ? '':'hidden'}>
                                        View Attachment
                                    </a>
                                </td>
                            </tr>`;
                            totalAmount = value.totalasAmount;
                            totalAmount1 = value.totalasPaid;
                        }
                        $(".tableProductAddBody1").find('tbody').append(tableRow);

                        var grandTotalRow1 = `<tr>
                                                <td class="text-center font-bold text-sm" colspan="4">Total</td>
                                                <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(totalAmount)}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right font-bold text-sm" id="grandTotal_text">${newDivider1(totalAmount1)}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>`;
                        $(".tableProductAddBody1").find('tbody').append(grandTotalRow1);
                    },
                });
            });

            $('#payment').on("click", ".btn-cancel",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Return This Form to Draft?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Return to Draft!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: `/finance/payment/list/return/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        icon : 'success',
                                        title: 'Success!',
                                        text: `Form Has Been Returned to Draft.`,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                    window.location.reload(true);
                                }else if (status == 2) {
                                    Swal.fire({
                                        icon : 'error',
                                        title: 'Cannot Return This Form!',
                                        text: `This Form Links to a PV.`,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function (data) {
                                console.info("error: ", data)
                            }
                        })

                    }
                })
            });
        });
    </script>
    @endsection
</x-app-layout>