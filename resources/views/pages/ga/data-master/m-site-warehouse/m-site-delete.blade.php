<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Site Warehouse - Delete 🗄️
                </h1>
            </div>
        </div>
        <div class="table-responsive">
            <table id="site-warehouse" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Warehouse Name</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">City</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">POS Code</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#site-warehouse').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "asc" ]],
                language: {
                    search: "Search Site Warehouse:"
                },
                ajax: {
                    url: "{{ route('m-site-warehouse.getdata') }}"
                },
                columns: [
                    {
                        data: "w_name",
                        name: "w_name"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "w_address",
                        name: "w_address"
                    },
                    {
                        data: "w_city",
                        name: "w_city"
                    },
                    {
                        data: "w_country",
                        name: "w_country"
                    },
                    {
                        data: "w_zipcode",
                        name: "w_zipcode"
                    },
                    {
                        data: "action1",
                        name: "action1"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [5] },
                    { className: 'flex justify-center', targets: [6] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#site-warehouse').on("click", ".btn-delete",  function () {
                const id = $(this).data("id");
                const name = $(this).data("name");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure',
                    text: `Want to Delete ${name}?`,
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
                            url: `/data-master/m-site-warehouse/delete/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: `${name} has been Deleted.`,
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