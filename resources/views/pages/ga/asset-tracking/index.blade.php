<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Asset Tracking 🖥️
                </h1>
            </div>
        </div>

        <div class="flex flex-row mb-3">
            <div class="rounded-full bg-yellow-200 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Pending</p>
            <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Approved</p>
            <div class="rounded-full bg-red-500 md:break-after-column h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Denied</p>
            <div class="rounded-full md:break-after-column h-5 w-5 ml-5" style="background-color: grey"></div>
            <p class="flex flex-row ml-1">Complete</p>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="purchase-order" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Date PO</th>
                        <th class="text-center">Purchase Order #</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Notes</th>
                        <th class="text-center">Grand Total</th>
                        <th class="text-center">Created By</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Remarks By</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
         $(document).ready(function () {
            $('#purchase-order').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "desc" ]],
                language: {
                    search: "Search Purchase Order # : "
                },
                ajax: {
                    url: "{{ route('purchase-order.getdata') }}"
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "datepo",
                        name: "datepo"
                    },
                    {
                        data: "idpo",
                        name: "idpo"
                    },
                    {
                        data: "category",
                        name: "category"
                    },
                    {
                        data: "notes",
                        name: "notes"
                    },
                    {
                        data: "gtotal",
                        name: "gtotal"
                    },
                    {
                        data: "addedby",
                        name: "addedby"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                    {
                        data: "remarks_by",
                        name: "remarks_by"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 7] },
                    { className: 'text-right', targets: [5] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $('#purchase-order').on("click", ".btn-modal", function () {
                const idpo = $(this).data('idpo');
                const datepo = $(this).data("datepo");
                const squotation = $(this).data("squotation");
                const idsupplier = $(this).data("idsupplier");
                const status = $(this).data("status");
                const notes = $(this).data("notes");
                const deliverydate = $(this).data("deliverydate");
                const idwarehouse = $(this).data("idwarehouse");
                const category = $(this).data("category");
                const currency = $(this).data("currency");
                const crossrate = $(this).data("crossrate");
                const pterm = $(this).data("pterm");
                const subtotal = $(this).data("subtotal");
                const pvat = $(this).data("pvat");
                const avat = $(this).data("avat");
                const gtotal = $(this).data("gtotal");
                const addedby = $(this).data("addedby");
                const remarks = $(this).data("remarks");
                const name = $(this).data("name");

                $.ajax({
                    type: "GET",
                    url: `/purchasing/purchase-approval/getProduct/${idpo}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Purchase Order #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${idpo}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Status</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Purchase Order Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${datepo}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Request By</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${addedby}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Supplier</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${name}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Delivery Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${deliverydate}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Remarks By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${currency}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Exchange Rate</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${divider(crossrate)}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Payment Term</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${pterm} Days" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">PO Notes</label>
                                        <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${notes}</textarea>
                                    </div>
                                    <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">No</th>
                                                <th class="text-sm text-center">Product Code</th>
                                                <th class="text-sm text-center">Product Name</th>
                                                <th class="text-sm text-center">Unit</th>
                                                <th class="text-sm text-center">Quantity</th>
                                                <th class="text-sm text-center">Price</th>
                                                <th class="text-sm text-center">Total</th>
                                                <th class="text-sm text-center">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="subtotal">Subtotal</label>
                                        <input id="subtotal" class="subtotal form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${currency} ${divider(subtotal)}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="pvat">PPN (%)</label>
                                        <input id="pvat" class="pvat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${pvat}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="avat">PPN (Count)</label>
                                        <input id="avat" class="avat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${avat}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="gtotal">Grand Total</label>
                                        <input id="gtotal" class="gtotal form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${currency} ${divider(gtotal)}" disabled readonly />
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="block text-sm font-medium mb-1 text-left" for="remarks">Remarks</label>
                                    <textarea rows="4" id="remarks" name="remarks" class="remarks form-input w-full px-2 py-1 read-only:bg-slate-200"
                                    type="text" readonly>${remarks}</textarea>
                                </div>
                            </div>
                        `); 
                        let tableRow = '';
                            for (const value of response) {
                                tableRow += `<tr>
                                                <td class="text-center">${value.no}</td>
                                                <td class="text-center">${value.code}</td>
                                                <td>${value.name}</td>
                                                <td class="text-center">${value.unit}</td>
                                                <td class="text-center">${value.quantity}</td>
                                                <td class="text-center">${value.price}</td>
                                                <td class="text-center">${value.total}</td>
                                                <td class="text-center">${value.balance}</td>
                                            </tr>`;
                            }
                        $(".tableProductAddBody").find('tbody').append(tableRow);
                    },
                });
            });
        });
    </script>
    @endsection
</x-app-layout>