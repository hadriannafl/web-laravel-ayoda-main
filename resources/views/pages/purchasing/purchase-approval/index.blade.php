<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Purchase Request Approval 1 💳
                </h1>
            </div>
        </div>

        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status">Show All Status :</p>
                <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                    <option value="Yes">No</option>
                    <option value="No">Yes</option>
                </select>
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
                    <option value="" selected>All</option>
                    @foreach ($dataChildCompany as $company)
                        <option value="{{ $company->id_company }}" {{Auth::user()->company_id == $company->id_company ? 'selected':''}}>{{ $company->name }}</option>
                    @endforeach
                </select>
                @endif
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="department">Department :</p>
                    <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                        <option value="" selected>All</option>
                        @foreach ($department as $dept)
                            <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="approval" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">PR Date</th>
                        <th class="text-center">Delivery Date</th>
                        <th class="text-center">Purchase Request #</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Request Level</th>
                        <th class="text-center">Applicant</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Approved Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
         $(document).ready(function () {
            $('#approval').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "desc" ]],
                language: {
                    search: "Search Purchase Request # : "
                },
                ajax: {
                    url: "{{ route('purchase-approvalga.getdata') }}",
                    data:function(d){
                        d.status = $("#status").val()
                        d.company = $("#company").val()
                        d.department = $("#department").val()
                    }
                },
                columns: [
                    {
                        data: "pr_date",
                        name: "pr_date"
                    },
                    {
                        data: "delivery_date",
                        name: "delivery_date"
                    },
                    {
                        data: "idreqform",
                        name: "idreqform"
                    },
                    {
                        data: "companyName",
                        name: "companyName"
                    },
                    {
                        data: "departmentName",
                        name: "departmentName"
                    },
                    {
                        data: "reqlevel",
                        name: "reqlevel"
                    },
                    {
                        data: "applicant",
                        name: "applicant"
                    },
                    {
                        data: "approvalstat",
                        name: "approvalstat"
                    },
                    {
                        data: "approvaldate",
                        name: "approvaldate"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 5, 8, 9] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $(".status").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })
            $(".company").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })
            $(".department").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })

            $('#approval').on("click", ".btn-modal", function () {
                const idpr = $(this).data('idpr');
                const datepr = $(this).data("datepr");
                const applicant = $(this).data("applicant");
                const loc = $(this).data("loc");
                const reqlevel = $(this).data("reqlevel");
                const note = $(this).data("note");
                const daterequired = $(this).data("daterequired");
                const approvaldate = $(this).data("approvaldate");
                const approvalstat = $(this).data("approvalstat");
                const approved1by = $(this).data("approved1by");
                const approval1_status = $(this).data("approval1_status");
                const remarks1 = $(this).data("remarks1");
                const gtotal = $(this).data("gtotal");
                const currency = $(this).data("currency");

                $.ajax({
                    type: "GET",
                    url: `/ga/purchase-approval/getProduct/${idpr}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Purchase Request #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${idpr}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Request Status</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approvalstat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Request Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${datepr}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Applicant</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${applicant}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Location</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${loc}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Required Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${daterequired}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Request Level</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${reqlevel}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval Status 1</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approval1_status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval 1 By</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approved1by}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Notes</label>
                                        <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${note}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Inventory Request :</label>
                                    </div>
                                    <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Item Name</th>
                                                <th class="text-sm text-center">Unit</th>
                                                <th class="text-sm text-center">Quantity</th>
                                                <th class="text-sm text-center">Price</th>
                                                <th class="text-sm text-center">Total</th>
                                                <th class="text-sm text-center">Category</th>
                                                <th class="text-sm text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="gtotal">Grand Total</label>
                                        <input id="gtotal" class="gtotal form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${currency} ${divider(gtotal)}" disabled readonly />
                                    </div>
                                </div>
                            </div>
                        `); 
                        let tableRow = '';
                            for (const value of response) {
                                tableRow += `<tr>
                                                <td>${value.name}</td>
                                                <td class="text-center">${value.unit}</td>
                                                <td class="text-center">${divider(value.qty)}</td>
                                                <td class="text-center">${divider(value.price)}</td>
                                                <td class="text-center">${divider(value.total)}</td>
                                                <td class="text-center">${value.category}</td>
                                                <td class="text-center flex flex-row justify-center">
                        <a href="/ga/office-inventory/file/${value.idassets}" target="_blank" class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white
                        ${value.pdf == 1 ? 'hidden' : ''}">
                            View File
                        </a>

                        <a href="/ga/office-inventory/photo/${value.idassets}" target="_blank" class="btn btn-sm bg-sky-500 hover:bg-sky-600 text-white ml-3 
                        ${value.image == 1 ? 'hidden' : ''}">
                        View Image
                        </a>

                    </td>
                                            </tr>`;
                            }
                        $(".tableProductAddBody").find('tbody').append(tableRow);
                    },
                });
            });

            $('#approval').on("click", ".btn-approve", function () {
                const idpr = $(this).data('idpr');
                const datepr = $(this).data("datepr");
                const applicant = $(this).data("applicant");
                const loc = $(this).data("loc");
                const reqlevel = $(this).data("reqlevel");
                const note = $(this).data("note");
                const daterequired = $(this).data("daterequired");
                const approvaldate = $(this).data("approvaldate");
                const approvalstat = $(this).data("approvalstat");
                const approved1by = $(this).data("approved1by");
                const approval1_status = $(this).data("approval1_status");
                const gtotal = $(this).data("gtotal");
                const currency = $(this).data("currency");

                $.ajax({
                    type: "GET",
                    url: `/ga/purchase-approval/getProduct/${idpr}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $(".modal-content").html(`
                        <div class="px-5">
                            <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Purchase Request #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${idpr}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Request Status</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approvalstat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Request Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${datepr}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Applicant</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${applicant}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Location</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${loc}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Required Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${daterequired}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Request Level</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${reqlevel}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval Status 1</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approval1_status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval 1 By</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approved1by}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Notes</label>
                                        <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${note}</textarea>
                                    </div>
                                    <div class="mt-1">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Inventory Request :</label>
                                    </div>
                                    <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Item Name</th>
                                                <th class="text-sm text-center">Unit</th>
                                                <th class="text-sm text-center">Quantity</th>
                                                <th class="text-sm text-center">Price</th>
                                                <th class="text-sm text-center">Total</th>
                                                <th class="text-sm text-center">Category</th>
                                                <th class="text-sm text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div class="grid md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="gtotal">Grand Total</label>
                                            <input id="gtotal" class="gtotal form-input w-full px-2 py-1 bg-slate-100"
                                                type="text" value="${currency} ${divider(gtotal)}" disabled readonly />
                                        </div>
                                    </div>
                                    <form method="post" enctype="multipart/form-data" action="/ga/purchase-approval/updateapprove/${idpr}">
                                        <input type="hidden" name="_token" value="${csrf_token}" />
                                        <div class="mt-2">
                                            <label class="block text-sm font-medium mb-1 text-left" for="remarks1">Remarks 1</label>
                                            <textarea rows="4" id="remarks1" name="remarks1" class="remarks1 form-input w-full px-2 py-1"
                                            type="text"></textarea>
                                        </div>
                                        <div class="grid md:grid-cols-3 gap-3">
                                            <div></div>
                                            <input type="submit" value="Approve" name="status" class="btn-sm bg-emerald-500 hover:bg-emerald-600 text-white mt-3" />
                                            <div></div>
                                        </div>
                                    </form>
                        </div>
                        `); 
                        let tableRow = '';
                            for (const value of response) {
                                tableRow += `<tr>
                                                <td>${value.name}</td>
                                                <td class="text-center">${value.unit}</td>
                                                <td class="text-center">${divider(value.qty)}</td>
                                                <td class="text-center">${divider(value.price)}</td>
                                                <td class="text-center">${divider(value.total)}</td>
                                                <td class="text-center">${value.category}</td>
                                                <td class="text-center flex flex-row justify-center">
                        <a href="/ga/office-inventory/file/${value.idassets}" target="_blank" class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white
                        ${value.pdf == 1 ? 'hidden' : ''}">
                            View File
                        </a>

                        <a href="/ga/office-inventory/photo/${value.idassets}" target="_blank" class="btn btn-sm bg-sky-500 hover:bg-sky-600 text-white ml-3 
                        ${value.image == 1 ? 'hidden' : ''}">
                        View Image
                        </a>

                    </td>
                                            </tr>`;
                            }
                        $(".tableProductAddBody").find('tbody').append(tableRow);
                    },
                });
            });

            $('#approval').on("click", ".btn-denied", function () {
                const idpr = $(this).data('idpr');
                const datepr = $(this).data("datepr");
                const applicant = $(this).data("applicant");
                const loc = $(this).data("loc");
                const reqlevel = $(this).data("reqlevel");
                const note = $(this).data("note");
                const daterequired = $(this).data("daterequired");
                const approvaldate = $(this).data("approvaldate");
                const approvalstat = $(this).data("approvalstat");
                const approved1by = $(this).data("approved1by");
                const approval1_status = $(this).data("approval1_status");
                const gtotal = $(this).data("gtotal");
                const currency = $(this).data("currency");

                $.ajax({
                    type: "GET",
                    url: `/ga/purchase-approval/getProduct/${idpr}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $(".modal-content").html(`
                        <div class="px-5">
                            <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Purchase Request #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${idpr}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Approval Status</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approvalstat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Request Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${datepr}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Applicant</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${applicant}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Location</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${loc}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Required Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${daterequired}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Request Level</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${reqlevel}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval 1 Status</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approval1_status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval 1 By</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approved1by}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Notes</label>
                                        <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${note}</textarea>
                                    </div>
                                    <div class="mt-1">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Inventory Request :</label>
                                    </div>
                                    <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Item Name</th>
                                                <th class="text-sm text-center">Unit</th>
                                                <th class="text-sm text-center">Quantity</th>
                                                <th class="text-sm text-center">Price</th>
                                                <th class="text-sm text-center">Total</th>
                                                <th class="text-sm text-center">Category</th>
                                                <th class="text-sm text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="gtotal">Grand Total</label>
                                        <input id="gtotal" class="gtotal form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${currency} ${divider(gtotal)}" disabled readonly />
                                    </div>
                                </div>
                                    <form method="post" enctype="multipart/form-data" action="/ga/purchase-approval/updatedenied/${idpr}">
                                        <input type="hidden" name="_token" value="${csrf_token}"/>
                                        <div class="mt-2">
                                            <label class="block text-sm font-medium mb-1 text-left" for="remarks1">Remarks 1</label>
                                            <textarea rows="4" id="remarks1" name="remarks1" class="remarks1 form-input w-full px-2 py-1"
                                            type="text"></textarea>
                                        </div>
                                        <div class="grid md:grid-cols-3 gap-3">
                                            <div></div>
                                            <input type="submit" value="Denied" name="status" class="btn-sm bg-red-400 border-slate-200 hover:bg-red-500 text-white mt-3" />
                                            <div></div>
                                        </div>
                                    </form>

                            </div>
                        `); 
                        let tableRow = '';
                            for (const value of response) {
                                tableRow += `<tr>
                                                <td>${value.name}</td>
                                                <td class="text-center">${value.unit}</td>
                                                <td class="text-center">${divider(value.qty)}</td>
                                                <td class="text-center">${divider(value.price)}</td>
                                                <td class="text-center">${divider(value.total)}</td>
                                                <td class="text-center">${value.category}</td>
                                                <td class="text-center flex flex-row justify-center">
                        <a href="/ga/office-inventory/file/${value.idassets}" target="_blank" class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white
                        ${value.pdf == 1 ? 'hidden' : ''}">
                            View File
                        </a>

                        <a href="/ga/office-inventory/photo/${value.idassets}" target="_blank" class="btn btn-sm bg-sky-500 hover:bg-sky-600 text-white ml-3 
                        ${value.image == 1 ? 'hidden' : ''}">
                        View Image
                        </a>

                    </td>
                                            </tr>`;
                            }
                        $(".tableProductAddBody").find('tbody').append(tableRow);
                    },
                });
            });

            $('#approval').on("click", ".btn-delete",  function () {
                const idpr = $(this).data("idpr");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Cancel Request Status!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: `/purchasing/purchase-approval/cancel/${idpr}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        icon : 'success',
                                        title: 'Success!',
                                        text: `Request Status has been Canceled.`,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
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

            // <div class="grid md:grid-cols-3 gap-3 mt-3">
            //                         <div class="${file == 1 ? '' : 'hidden'}">
            //                             <label class="text-sm font-medium mb-1">Purchase Request Document Not Uploaded Yet</label>
            //                         </div>
            //                     </div>
            //                     <div class="grid md:grid-cols-3 gap-3 mt-3">
            //                         <div class="${file == 1 ? 'hidden' : ''}">
            //                             <label class="text-sm font-medium mb-1">Purchase Request Document :</label>
            //                             <a href="/ga/purchase-approval/viewfile/${idpr}" target="_blank" class="text-sm font-medium ml-5">View Document</a>
            //                         </div>
            //                     </div>
        });
    </script>
    @endsection
</x-app-layout>