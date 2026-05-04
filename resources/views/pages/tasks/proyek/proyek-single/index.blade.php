<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Project Proposal 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 mt-2 text-sm" for="status">Project Status :</p>
                <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                    <option value="">All</option>
                    <option value="1">Open</option>
                    <option value="0">Pending</option>
                    <option value="2">Lost</option>
                    <option value="3">Won</option>
                </select>
                {{-- <p class="flex flex-row text-slate-800 mb-3 ml-3 text-xs" for="salesname">Sales Representative :</p>
                <select class="salesname ml-3 mb-3 text-xs" id="salesname" name="salesname">
                    <option value="">All</option>
                    @foreach ($dataUsers as $user )
                    <option value="{{$user->id}}">{{$user->username}}</option>
                    @endforeach
                </select> --}}
                <a class="ml-10 btn bg-indigo-500 hover:bg-indigo-600 text-white text-xs @if(Route::is('proyek.form')){{ '!text-indigo-500' }}@endif mb-3"
                    href="{{ route('proyek-single.form') }}">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="ml-2 text-xs">Create New Proposal</span>
                </a>
            </label>
        </div>
        <div class="table-responsive">
            <table id="proyek" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Project</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Stage</th>
                        <th class="text-center">Sales Representative</th>
                        <th class="text-center">Project Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#proyek').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                order: [[1, 'desc']],
                language: {
                    search: "Search Customer Name: "
                },
                ajax: {
                    url: "{{ route('proyek-single.getdata') }}",
                    data:function(d){
                        d.status = $("#status").val()
                        d.salesname = $("#salesname").val()
                    }
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
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "companyname",
                        name: "companyname"
                    },
                    {
                        data: "stage_name",
                        name: "stage_name"
                    },
                    {
                        data: "salesname",
                        name: "salesname"
                    },
                    {
                        data: "status_name",
                        name: "status_name"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [5] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });


            $(".status").on('change', function (e) {
                e.preventDefault();
                $('#proyek').DataTable().ajax.reload();
            })
            $(".salesname").on('change', function (e) {
                e.preventDefault();
                $('#proyek').DataTable().ajax.reload();
            })

            // $('#proyek').on("click", ".btn-update", function () {
            //     const companyId = $(this).data("company-id");
            //     const company = $(this).data("company");
            //     const pic = $(this).data("company-pic-id");
            //     const sales = $(this).data("sales");
            //     const project = $(this).data("project");
            //     const description = $(this).data("description");
            //     const notes = $(this).data("notes");
            //     const status = $(this).data("status");
            //     const file = $(this).data("file");

            //     $(".pic").empty();
            //     $(".sales").empty();

            //     $.ajax({
            //         type: "GET",
            //         url: `/tasks/proyek/getupdate/${companyId}`,
            //         success: function (response) {
            //             let picList = '';
            //             for (const value of response.companyPicList) {
            //                 picList += `<option value="${value.id}" ${value.id == pic ? 'selected' : ''}>${value.name} (${value.phone_number_1} / ${value.phone_number_2})</option>`;
            //             }
            //             let salesList = '';
            //             for (const value of response.salesList) {
            //                 salesList += `<option value="${value.id}" ${value.id == sales ? 'selected' : ''}>${value.username}</option>`;
            //             }

            //             $(".company").val(company);
            //             $(".pic").append(picList);
            //             $(".sales").append(salesList);
            //             $(".project-name").val(project);
            //             $(".description").val(description);
            //             $(".notes").val(notes);
            //             $(".file").val(file);
            //         }
            //     });
            // });
        });
    </script>
    @endsection
</x-app-layout>