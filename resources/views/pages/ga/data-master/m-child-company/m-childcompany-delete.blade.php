<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Child Company - Delete 🗄️
                </h1>
            </div>
        </div>

        <div class="table-responsive">
            <table id="child-company" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Initials</th>
                        <th class="text-center">Logo</th>
                        <th class="text-center">Company Type</th>
                        <th class="text-center">Company Name</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">City</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">POS Code</th>
                        <th class="text-center">NPWP ID</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#child-company').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 3, "asc" ]],
                language: {
                    search: "Search Company:"
                },
                ajax: {
                    url: "{{ route('child-company.getdata') }}"
                },
                columns: [
                    {
                        data: "initials",
                        name: "initials"
                    },
                    {
                        data: "logo",
                        name: "logo"
                    },
                    {
                        data: "company_type",
                        name: "company_type"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "country",
                        name: "country"
                    },
                    {
                        data: "city",
                        name: "city"
                    },
                    {
                        data: "address",
                        name: "address"
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
                        data: "action1",
                        name: "action1"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 7] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#child-company').on("click", ".btn-delete",  function () {
                const id_company = $(this).data("id_company");
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
                            url: `/data-master/m-child-company/delete/${id_company}`,
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