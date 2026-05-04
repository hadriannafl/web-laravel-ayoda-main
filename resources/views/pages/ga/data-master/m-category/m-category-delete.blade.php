<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Category Inventory - Delete 🗄️
                </h1>
            </div>
        </div>

        <div class="table-responsive">
            <table id="category-table" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Category's Name</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#category-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Category:"
                },
                ajax: {
                    url: "{{ route('m-category.getdata') }}"
                },
                columns: [
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "action2",
                        name: "action2"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [] },
                    { className: 'flex justify-center', targets: [1] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#category-table').on("click", ".btn-delete",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Delete Category!",
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
                            url: `/data-master/m-category/delete/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: `Category has been Deleted.`,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                    $(`.btn-delete[data-id="${id}"]`).closest('tr').remove();
                                    window.location.reload(true);
                                }else {
                                    Swal.fire({
                                        title: 'Unsuccessfully!',
                                        text: `There Are Sub Category Still Active.`,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
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