<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Visiting Report 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 mt-2 text-sm" for="status">Report Stage :</p>
                <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                    <option value="">All</option>
                    <option value="Call">Call</option>
                    <option value="Visit">Visit</option>
                    <option value="Meeting">Meeting</option>
                </select>
                <a class="ml-10 btn bg-indigo-500 hover:bg-indigo-600 text-white text-xs @if(Route::is('visiting.form')){{ '!text-indigo-500' }}@endif mb-3"
                    href="{{ route('visiting.form') }}">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="ml-2 text-xs">Create New Visiting Report</span>
                </a>
            </label>
        </div>
        <div class="table-responsive">
            <table id="visiting" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Visiting Report #</th>
                        <th class="text-center">Sales Representative</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Visiting Stage</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#visiting').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                order: [[1, 'desc']],
                language: {
                    search: "Search Visiting Report #: "
                },
                ajax: {
                    url: "{{ route('visiting.getdata') }}",
                    data:function(d){
                        d.status = $("#status").val()
                    }
                },
                columns: [
                    {
                        data: "date_time",
                        name: "date_time"
                    },
                    {
                        data: "id_report",
                        name: "id_report"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "stage",
                        name: "stage"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 4] },
                    { className: 'flex justify-center', targets: [5] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $(".status").on('change', function (e) {
                e.preventDefault();
                $('#visiting').DataTable().ajax.reload();
            })
            $('#visiting').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const id_report = $(this).data('id_report');
                const username = $(this).data('username');
                const stage = $(this).data("stage");
                const notulens = $(this).data("notulens");
                const name = $(this).data("name");
                const file_name = $(this).data("file_name");
                const file = $(this).data("file");
                const date_time = $(this).data("date_time");

                $.ajax({
                    type: "GET",
                    url: `/tasks/visiting-report/visiting-single/getdetail/${id_report}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Visiting Report #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${id_report}" disabled readonly/>
                                        <input id="id_1" class="id_1 form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${id}" disabled readonly hidden/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="stage">Stage</label>
                                        <input id="stage" class="stage form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${stage}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Incident Date and Time</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${date_time}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Visiting By</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${username}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Customer</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${name}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Visiting Remarks</label>
                                        <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${notulens}</textarea>
                                    </div>
                                <div class="grid md:grid-cols-3 gap-3 mt-3">
                                    <div class="mt-3 mb-5 text-left ${file == 1 ? 'hidden' : ''}">
                                        <label class="text-sm font-medium mb-1">Attachment File :</label>
                                        <a href="/tasks/visiting-report/viewfile/${id_report}" target="_blank" class="text-sm font-medium ml-5 text-blue-500 underline">View File</a>
                                        <input id="file" name="file" class="file read-only:bg-slate-200 px-auto py-1 ml-5" type="text"
                                        readonly disabled value="${file_name}"/>
                                    </div>
                                </div>
                                <div class="table-responsive mt-3">
                                    <label class="block text-sm font-medium mb-1" for="address">Next Follow Up</label>
                                    <table class="table table-striped table-bordered follow-up-table"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">#</th>
                                                <th class="text-sm text-center">Incident Report ID</th>
                                                <th class="text-sm text-center">Date and Time Name</th>
                                                <th class="text-sm text-center">Stage</th>
                                                <th class="text-sm text-center">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `); 
                        let tableRow = '';
                        let row = 0;
                        for (const value of response) {
                            row++
                            tableRow += `<tr>
                                            <td class="text-center">${row}</td>
                                            <td class="text-center">${value.follow_report}</td>
                                            <td class="text-center">${value.date_time}</td>
                                            <td class="text-center">${value.stage}</td>
                                            <td class="text-left">${value.notulens}</td>
                                        </tr>`;
                        }
                       $(".follow-up-table").find('tbody').append(tableRow);
                    },
                });
            });
            $('#visiting').on("click", ".btn-edit", function () {
                const id = $(this).data('id');
                const id_report = $(this).data('id_report');
                const username = $(this).data('username');
                const stage = $(this).data("stage");
                const notulens = $(this).data("notulens");
                const name = $(this).data("name");
                const file_name = $(this).data("file_name");
                const file = $(this).data("file");
                const date_time = $(this).data("date_time");

                $.ajax({
                    type: "GET",
                    url: `/tasks/visiting-report/visiting-single/getdata/${id_report}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="form_do_update" enctype="multipart/form-data" action="/tasks/visiting-report/visiting-single/followup">
                                <input type="hidden" name="_token" value="${csrf_token}" />
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="sales_id">Incident Report #<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="id_report" name="id_report" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${id_report}" readonly required/>
                                            <input id="id_report1" name="id_report1" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${id}" readonly required hidden/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="username">Visiting By<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="username" name="username" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${username}" readonly required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="date1">Date<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="date1" name="date1"
                                                class=" date1 form-input w-full px-2 py-1" type="datetime-local"
                                                required value="${date_time}" />
                                        </div>
                                        <div>
                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                for="status">Status :
                                            </label>
                                            <select id="status" name="status"
                                                class="status form-select w-full px-2 py-1" required>
                                                    <option value="Call" ${status == 'Call' ? 'selected' : ''}>Call</option>
                                                    <option value="Visit" ${status == 'Visit' ? 'selected' : ''}>Visit</option>
                                                    <option value="Meeting" ${status == 'Meeting' ? 'selected' : ''}>Meeting</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="followup">Remarks<span
                                                    class="text-rose-500">*</span></label>
                                            <textarea id="followup" name="followup"
                                                class="followup form-input w-full px-2 py-1" rows="3"
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Cancel</button>
                                            <button type="submit"
                                                class="btn-sm btn-update bg-indigo-500 hover:bg-indigo-600 text-white">Follow Up</button>
                                        </div>
                                    </div>
                            </form>
                        `);
                    },
                });
            });
        });
    </script>
    @endsection
</x-app-layout>