<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Incident Report - List 📓
                </h1>
            </div>
        </div>

        <div class="flex flex-row mb-3">
            <div class="rounded-full bg-yellow-200 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Pending</p>
            <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Open</p>
            <div class="rounded-full md:break-after-column h-5 w-5 ml-5" style="background-color: grey"></div>
            <p class="flex flex-row ml-1">Close</p>
        </div>

        <label class="flex flex-row text-xs mt-3 ml-5">
            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status">Incident Report Status :</p>
            <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                <option value="">All</option>
                <option value="Pending">Pending</option>
                <option value="Open">Open</option>
                <option value="Close">Close</option>
            </select>
        </label>

        <!-- Table -->
        <div class="table-responsive">
            <table id="incident-report" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Incident Date</th>
                        <th class="text-center">Incident Report #</th>
                        <th class="text-center">Subject</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Location</th>
                        <th class="text-center">Report By</th>
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
            $('#incident-report').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "desc" ]],
                language: {
                    search: "Search Incident Report # : "
                },
                ajax: {
                    url: "{{ route('incident.getdata') }}",
                    data:function(d){
                        d.status = $("#status").val()
                    }
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "date_time",
                        name: "date_time"
                    },
                    {
                        data: "id_report",
                        name: "id_report"
                    },
                    {
                        data: "subject",
                        name: "subject"
                    },
                    {
                        data: "category",
                        name: "category"
                    },
                    {
                        data: "dept",
                        name: "dept"
                    },
                    {
                        data: "location",
                        name: "location"
                    },
                    {
                        data: "add_by",
                        name: "add_by"
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
                    { className: 'text-center', targets: [0, 2, 4, 7, 8] },
                    { className: 'flex justify-center', targets: [9] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $(".status").on('change', function (e) {
                e.preventDefault();
                $('#incident-report').DataTable().ajax.reload();
            })

            $('#incident-report').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const id_report = $(this).data('id_report');
                const subject = $(this).data('subject');
                const category = $(this).data("category");
                const dept = $(this).data("dept");
                const location = $(this).data("location");
                const status = $(this).data("status");
                const cronology = $(this).data("cronology");
                const division_involve = $(this).data("division_involve");
                const person_involve = $(this).data("person_involve");
                const add_by = $(this).data("add_by");
                const date_time = $(this).data("date_time");
                const file1 = $(this).data("file1");
                const file2 = $(this).data("file2");
                const file3 = $(this).data("file3");
                const img1 = $(this).data("img1");
                const img2 = $(this).data("img2");
                const img3 = $(this).data("img3");
                const img_1 = $(this).data("img_1");
                const img_2 = $(this).data("img_2");
                const img_3 = $(this).data("img_3");
                const file = $(this).data("file");
                const img = $(this).data("img");

                $.ajax({
                    type: "GET",
                    url: `/incident-report/getdetail/${id}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Incident Report #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${id_report}" disabled readonly/>
                                        <input id="id_1" class="id_1 form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${id}" disabled readonly hidden/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Status</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Incident Date and Time</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${date_time}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Report By</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${add_by}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Department</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${dept}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Category</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${category}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Division Involve</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${division_involve}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Person Involve</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${person_involve}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Location</label>
                                        <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${location}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Cronology</label>
                                        <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${cronology}</textarea>
                                    </div>
                                <div class="grid md:grid-cols-3 gap-3 mt-3">
                                    <div class="${file1 == 1 ? 'hidden' : ''}">
                                        <label class="text-sm font-medium mb-1">Attachment File 1 :</label>
                                        <a href="/incident-report/file1/${id_report}" target="_blank" class="text-sm font-medium ml-5">View File</a>
                                    </div>
                                    <div class="${file2 == 1 ? 'hidden' : ''}">
                                        <label class="text-sm font-medium mb-1">Attachment File 2 :</label>
                                        <a href="/incident-report/file2/${id_report}" target="_blank" class="text-sm font-medium ml-5">View File</a>
                                    </div>
                                    <div class="${file3 == 1 ? 'hidden' : ''}">
                                        <label class="text-sm font-medium mb-1">Attachment File 3 :</label>
                                        <a href="/incident-report/file3/${id_report}" target="_blank" class="text-sm font-medium ml-5">View File</a>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3 mt-3">
                                    <div class="${img1 == 1 ? 'hidden' : ''}">
                                        <label class="text-sm font-medium mb-1">Report Image 1 :</label>
                                        <a href="/incident-report/img1/${id_report}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                        <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${img_1}" width="259" height="142" alt="Report Image" />
                                    </div>
                                    <div class="${img2 == 1 ? 'hidden' : ''}">
                                        <label class="text-sm font-medium mb-1">Report Image 2 :</label>
                                        <a href="/incident-report/img2/${id_report}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                        <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${img_2}" width="259" height="142" alt="Report Image" />
                                    </div>
                                    <div class="${img3 == 1 ? 'hidden' : ''}">
                                        <label class="text-sm font-medium mb-1">Report Image 3 :</label>
                                        <a href="/incident-report/img3/${id_report}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                        <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${img_3}" width="259" height="142" alt="Report Image" />
                                    </div>
                                </div>
                                <div class="table-responsive mt-3">
                                    <label class="block text-sm font-medium mb-1" for="address">Follow Up</label>
                                    <table class="table table-striped table-bordered follow-up-table"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Incident Report #</th>
                                                <th class="text-sm text-center">Date and Time Name</th>
                                                <th class="text-sm text-center">Report By</th>
                                                <th class="text-sm text-center">Follow Up</th>
                                                <th class="text-sm text-center">Uploaded File</th>
                                                <th class="text-sm text-center">Uploaded Image</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `); 
                        let tableRow = '';
                        for (const value of response) {
                            tableRow += `<tr>
                                <td class="text-center"><input type="text" name="id2" id="id2" value="${value.follow_upId}" hidden/>${value.id_report}</td>
                                            <td class="text-center">${value.date}</td>
                                            <td class="text-center">${value.username}</td>
                                            <td>${value.follow_up}</td>
                                            <td class="text-center"><a ${value.files == 1 ? 'hidden' : ''} href="/incident-report/filefollowup/${value.follow_upId}" target="_blank" class="btn btn-sm text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1">View File</a></td>
                                            <td class="text-center"><a <a ${value.images == 1 ? 'hidden' : ''} href="/incident-report/imgfollowup/${value.follow_upId}" target="_blank" class="btn btn-sm text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1">View Image</a></td>
                                        </tr>`;
                        }

                        $(".follow-up-table").find('tbody').append(tableRow);
                    },
                });
            });

            $('#incident-report').on("click", ".btn-edit", function () {
                const id = $(this).data('id');
                const id_report = $(this).data('id_report');
                const subject = $(this).data('subject');
                const category = $(this).data("category");
                const dept = $(this).data("dept");
                const location = $(this).data("location");
                const status = $(this).data("status");
                const cronology = $(this).data("cronology");
                const division_involve = $(this).data("division_involve");
                const person_involve = $(this).data("person_involve");
                const add_by = $(this).data("add_by");
                const date_time = $(this).data("date_time");
                const file1 = $(this).data("file1");
                const file2 = $(this).data("file2");
                const file3 = $(this).data("file3");
                const img1 = $(this).data("img1");
                const img2 = $(this).data("img2");
                const img3 = $(this).data("img3");
                const img_1 = $(this).data("img_1");
                const img_2 = $(this).data("img_2");
                const img_3 = $(this).data("img_3");
                const file = $(this).data("file");
                const img = $(this).data("img");

                $.ajax({
                    type: "GET",
                    url: `/incident-report/list/getdata/${id_report}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="form_do_update" enctype="multipart/form-data" action="/incident-report/followup">
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
                                            <label class="block text-sm font-medium mb-1" for="username">Report By<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="username" name="username" class="form-input w-full px-2 py-1" type="text" value="${add_by}" required/>
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
                                                    <option value="Open" ${status == 'Open' ? 'selected' : ''}>Open</option>
                                                    <option value="Pending" ${status == 'Pending' ? 'selected' : ''}>Pending</option>
                                                    <option value="Close" ${status == 'Close' ? 'selected' : ''}>Close</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="followup">Follow Up<span
                                                    class="text-rose-500">*</span></label>
                                            <textarea id="followup" name="followup"
                                                class="followup form-input w-full px-2 py-1" rows="3"
                                                required></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="filefollowup">Upload Attachment File</label>
                                            <input id="filefollowup" name="filefollowup" type="file"
                                                class="filefollowup form-input w-full px-2 py-1" accept="application/pdf"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="imagefollowup">Upload Attachment Image</label>
                                            <input id="imagefollowup" name="imagefollowup" type="file"
                                                class="imagefollowup form-input w-full px-2 py-1" accept="image/jpeg"/>
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