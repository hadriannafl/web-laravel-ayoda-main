<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    List Employee - Delete 🗄️
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
                        data: "action1",
                        name: "action1"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 3, 5] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $('#company').on('change', function (e) {
                $('#employees').DataTable().ajax.reload();
            })

            $('#employees').on("click", ".btn-delete",  function () {
                const id = $(this).data("id");
                const first_name = $(this).data("first_name");
                const last_name = $(this).data("last_name");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Want to Delete Data Employee ${first_name} ${last_name}!`,
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