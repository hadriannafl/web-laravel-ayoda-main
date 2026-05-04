<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Leave Allowance ✨
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="flex flex-row">
            <p class="flex flex-row text-2xl text-slate-500 mb-2">Your Leaves Allowance : 12 days</p>
        </div>
        <div class="table-responsive">
            <table id="allowance" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Leaves Request #</th>
                        <th class="text-center">Employee</th>
                        <th class="text-center">Start Leave</th>
                        <th class="text-center">End Leave</th>
                        <th class="text-center">Leave Days</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Notes</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#allowance').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                bFilter: false,
                "order": [[ 0, "desc" ]],
                ajax: {
                    url: "{{ route('leaveallow.getdata') }}"
                },
                columns: [
                    {
                        data: "id",
                        name: "id"
                    },
                    {
                        data: "employee",
                        name: "employee"
                    },
                    {
                        data: "periode_from",
                        name: "periode_from"
                    },
                    {
                        data: "periode_to",
                        name: "periode_to"
                    },
                    {
                        data: "leave_days",
                        name: "leave_days"
                    },
                    {
                        data: "category",
                        name: "category"
                    },
                    {
                        data: "description",
                        name: "description"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 2, 3, 4, 7] },
                    { className: 'text-right', targets: [] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $('#allowance').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const date = $(this).data('date');
                const from = $(this).data("from");
                const to = $(this).data("to");
                const employee = $(this).data("employee");
                const desc = $(this).data("desc");
                const status = $(this).data("stat");
                const image = $(this).data("image");
                const approve1_stat = $(this).data("approve1_stat");
                const approve1_name = $(this).data("approve1_name");
                const approve2_stat = $(this).data("approve2_stat");
                const approve2_name = $(this).data("approve2_name");

                $.ajax({
                    type: "GET",
                    url: `/hr/leavallow/getdetail/${id}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="number">Leave Request #</label>
                                        <input id="number" class="number form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${id}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="number">Form Date</label>
                                        <input id="number" class="number form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${date}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="date">Employee</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${employee}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="number">Start Leave</label>
                                        <input id="number" class="number form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${from}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">End Leave</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${to}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="by">Status Leave</label>
                                        <input id="by" class="by form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="by">Approval 1 Status</label>
                                        <input id="by" class="by form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="by">Approval 2 Status</label>
                                        <input id="by" class="by form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${status}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="address">Delivery Address</label>
                                        <textarea rows="4" id="address" class="address form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${desc}</textarea>
                                    </div>
                                    <div class="mt-3 text-left">
                                        <label class="text-sm font-medium mb-1">Document Uploaded :</label>
                                        <a href="/hr/leaverequest/leaverequest-all/document/${id}" target="_blank" class="text-sm font-medium ml-5 text-blue-500 underline">View Document</a>
                                    </div>
                            </div>
                        `); 
                    },
                });
            });
        });
    </script>
    @endsection
</x-app-layout>