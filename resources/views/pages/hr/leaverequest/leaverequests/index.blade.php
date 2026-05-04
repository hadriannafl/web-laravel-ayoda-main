<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Leave Request 🗓️
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
        </div>

        <a class="mb-3 btn bg-purple-500 hover:bg-purple-600 text-white text-xs @if(Route::is('leaverequest.form')){{ '!text-indigo-500' }}@endif mb-3"
                    href="{{ route('leaverequests.form') }}">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="ml-2 text-xs">Create Leave Request</span>
        </a>

        <!-- Table -->
        <div class="table-responsive">
            <table id="request" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Form Date</th>
                        <th class="text-center">Leave Request #</th>
                        <th class="text-center">Employee</th>
                        <th class="text-center">Start Leave</th>
                        <th class="text-center">End Leave</th>
                        <th class="text-center" hidden>Leave Days</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Notes</th>
                        <th class="text-center">Approval 1 Status</th>
                        <th class="text-center">Approval 2 Status</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#request').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "desc" ]],
                language: {
                    search: "Search : "
                },
                ajax: {
                    url: "{{ route('leaverequests.getdata') }}"
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "created_at",
                        name: "created_at"
                    },
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
                        data: "category",
                        name: "category"
                    },
                    {
                        data: "description",
                        name: "description"
                    },
                    {
                        data: "approval1_status",
                        name: "approval1_status"
                    },
                    {
                        data: "approval2_status",
                        name: "approval2_status"
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
                    { className: 'text-center', targets: [0, 1, 2, 4, 6, 11] },
                    { className: 'text-right', targets: [] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $('#request').on("click", ".btn-modal", function () {
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
                const approve1_notes = $(this).data("approve1_notes");
                const approve2_notes = $(this).data("approve2_notes");
                const file_name = $(this).data("file_name");

                $.ajax({
                    type: "GET",
                    url: `/hr/leaverequest/leaverequests/getdetail/${id}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Leave Request #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${id}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Form Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${date}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="employee">Employee</label>
                                        <input id="employee" class="employee form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${employee}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Status Leave</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval 1 Status</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approve1_stat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve2_stat">Approval 2 Status</label>
                                        <input id="approve2_stat" class="approve2_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approve2_stat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_name">Approval 1 name</label>
                                        <input id="approve1_name" class="approve1_name form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approve1_name}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve2_name">Approval 2 name</label>
                                        <input id="approve2_name" class="approve2_name form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approve2_name}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="description">Notes</label>
                                        <textarea rows="4" id="description" name="description" class="description form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${desc}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="approve1_notes">Approve 1 Notes</label>
                                        <textarea rows="4" id="approve1_notes" class="approve1_notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${approve1_notes}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="approve2_notes">Approve 2 Notes</label>
                                        <textarea rows="4" id="approve2_notes" class="approve2_notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${approve2_notes}</textarea>
                                    </div>
                                    <div class="mt-3 mb-5 text-left ${image == 1 ? 'hidden' : ''}">
                                        <label class="text-sm font-medium mb-1">Document Uploaded :</label>
                                        <a href="/hr/leaverequest/leaverequests/document/${id}" target="_blank" class="text-sm font-medium ml-5 text-blue-500 underline">View Document</a>
                                        <input id="file" name="file" class="file read-only:bg-slate-200 px-auto py-1 ml-5" type="text"
                                        readonly disabled value="${file_name}" />
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