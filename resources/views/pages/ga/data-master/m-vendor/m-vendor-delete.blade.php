<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Vendor Preference - Delete 🗄️
                </h1>
            </div>
        </div>
        <div class="flex flex-row text-xs">
            @if (Auth::user()->role_name == 'IT' || Auth::user()->role_name == 'Administrator')
                <label class="flex flex-row text-xs">
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="dept">Department</p>
                    <select id="dept" class="dept form-select flex flex-row ml-3 mb-3 text-xs" name="dept">
                        <option value="0">All</option>
                        <option value="1">Purchasing</option>
                        <option value="2">Finance</option>
                    </select>
                </label>
            @elseif (Auth::user()->role_name == 'Finance')
                <input type="text" id="dept" name="dept" class="dept form-input" value="2" readonly hidden/>
            @elseif (Auth::user()->role_name == 'Purchasing')
            <input type="text" id="dept" name="dept" class="dept form-input" value="1" readonly hidden/>
            @endif
        </div>
        <div class="table-responsive">
            <table id="vendors" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Vendor's Type</th>
                        <th class="text-center">Vendor's Name</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">City</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">Contact Phone</th>
                        <th class="text-center">POS Code</th>
                        <th class="text-center">NPWP ID</th>
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
            $('#vendors').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 2, "asc" ]],
                language: {
                    search: "Search Vendor:"
                },
                ajax: {
                    url: "{{ route('m-vendor.getdata') }}",
                    data:function(d){
                        d.dept = $("#dept").val()
                    }
                },
                columns: [
                    {
                        data: "company_type",
                        name: "company_type"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "address",
                        name: "address"
                    },
                    {
                        data: "city",
                        name: "city"
                    },
                    {
                        data: "country",
                        name: "country"
                    },
                    {
                        data: "phone",
                        name: "phone"
                    },
                    {
                        data: "zip_code",
                        name: "zip_code"
                    },
                    {
                        data: "npwp_id",
                        name: "npwp_id"
                    },
                    {
                        data: "status",
                        name: "status"
                    },                    
                    {
                        data: "action1",
                        name: "action1"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 5, 6, 8] },
                    { className: 'flex justify-center', targets: [9] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $("#dept").on('change', function (e) {
                e.preventDefault();
                $('#vendors').DataTable().ajax.reload();
            })

            $('#vendors').on("click", ".btn-delete",  function () {
                const id = $(this).data("id");
                const type = $(this).data('type');
                const name = $(this).data('name');
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Want to Delete ${type} ${name}!`,
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
                            url: `/data-master/m-vendor/delete/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: `${type} ${name} has been Deleted.`,
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