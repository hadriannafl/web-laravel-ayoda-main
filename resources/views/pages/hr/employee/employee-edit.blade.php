<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    List Employee - Edit 🗄️
                </h1>
            </div>
        </div>
        <div class="flex flex-row mb-3">
            @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="company123">Company :</p>
                <select id="company" class="company flex flex-row ml-3 mb-3 text-xs" name="company">
                    <option value="">All</option>
                    @foreach ( $company as $companys)
                    <option value="{{$companys->id_company}}">{{$companys->name}}</option>
                    @endforeach
                </select>
            @else
                <input id="company" name="company"
                class="company form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                value="{{Auth::user()->company_id}}" readonly hidden/>
            @endif
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="employees" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Employee ID</th>
                        {{-- <th class="text-center">NIK</th> --}}
                        <th class="text-center">Day Of Birth</th>
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
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#employees').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 2, "asc" ]],
                language: {
                    search: "Search Employee:"
                },
                ajax: {
                    url: "{{ route('employee.getdata') }}",
                    data:function(d){                    
                        d.company = $("#company").val()
                    }
                },
                columns: [
                    {
                        data: "idemployee",
                        name: "idemployee"
                    },
                    // {
                    //     data: "nik",
                    //     name: "nik"
                    // },
                    {
                        data: "DoB",
                        name: "DoB"
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
                    { className: 'text-center', targets: [0, 1, 3, 5] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $('#company').on('change', function (e) {
                $('#employees').DataTable().ajax.reload();
            })

            $('#employees').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const nik = $(this).data('nik');
                const first_name = $(this).data('first_name');
                const last_name = $(this).data('last_name');
                const DoB = $(this).data('DoB');
                console.log('DoB:', DoB);
                const gender = $(this).data('gender');
                const company = $(this).data('company');
                const department = $(this).data('department');
                const title_structural = $(this).data('title_structural');
                const position = $(this).data('position');

                $.ajax({
                    type: "GET",
                    url: `/hr/employee/getdata/${id}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/hr/employee/update/${id}">
                                <input type="hidden" name="_token" value="${csrf_token}"/>
                            <div class="px-5 py-4">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="nik1">NIK<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="nik1" name="nik1" type="text" value="${nik}"
                                                class="nik1 form-input w-full px-2 py-1 read-only:bg-slate-200"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="first_name1">First Name<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="first_name1" name="first_name1" type="text" value="${first_name}"
                                                class="first_name1 form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="last_name1">Last Name<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="last_name1" name="last_name1" type="text" value="${last_name}"
                                                class="last_name1 form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="DoB1">Day Of Birth<span class="text-rose-500">*</span></label>
                                            <input id="DoB1" name="DoB1" type="date"
                                                class="DoB1 form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="gender1">Gender<span
                                                    class="text-rose-500">*</span></label>
                                                    <select name="gender1" id="gender1" class="gender1 form-input w-full px-2 py-1" required>
                                                        <option value="F" ${gender == 'F' ? 'selected':''}>Female</option>
                                                        <option value="M" ${gender == 'M' ? 'selected':''}>Male</option>
                                                    </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="company1">Company<span
                                                    class="text-rose-500">*</span></label>
                                            <select name="company1" id="company1" class="company1 form-input w-full px-2 py-1" required>
                                                @foreach ($company as $item)
                                                    <option value="{{$item->id_company}}" ${company == '{{$item->id_company}}' ? 'selected':''}>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="type1">Employee Type<span
                                                    class="text-rose-500">*</span></label>
                                                    <select name="type1" id="type1" class="type1 form-input w-full px-2 py-1" required>
                                                        <option value="F" ${gender == 'KONTRAK' ? 'selected':''}>KONTRAK</option>
                                                        <option value="M" ${gender == 'PERMANEN' ? 'selected':''}>PERMANEN</option>
                                                    </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="department1">Department<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="department1" name="department1" type="text" value="${department}"
                                                class="department1 form-input w-full px-2 py-1 read-only:bg-slate-200" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="structure1">Structural Title<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="structure1" name="structure1" type="text" value="${title_structural}"
                                                class="structure1 form-input w-full px-2 py-1 read-only:bg-slate-200" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="position1">Position<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="position1" name="position1" type="text" value="${position}"
                                                class="position1 form-input w-full px-2 py-1" required/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm btn-update bg-red-500 hover:bg-red-600 text-white">Terminate</button>
                                            <button type="submit"
                                                class="btn-sm btn-update bg-indigo-500 hover:bg-indigo-600 text-white">Update</button>
                                        </div>
                                    </div>
                            </form>
                        `);
                    },
                });
            });

            $('#employees').on("click", ".btn-delete",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Delete Data Employee!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: `/hr/employee/delete/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        icon : 'success',
                                        title: 'Deleted!',
                                        text: `Data Employee has been Deleted.`,
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
        });
    </script>
    @endsection
</x-app-layout>