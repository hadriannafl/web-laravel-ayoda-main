<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Bank - Delete 🗄️
                </h1>
            </div>
        </div>

        <div class="table-responsive">
            <table id="banks" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Bank Name</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#banks').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                language: {
                    search: "Search Bank:"
                },
                ajax: {
                    url: "{{ route('bank.getdata') }}"
                },
                columns: [
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "action1",
                        name: "action1"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#banks').on("click", ".btn-delete",  function () {
                const id_bank = $(this).data("id_bank");
                const bank = $(this).data("bank");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Want to Delete ${bank}!`,
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
                            url: `/data-master/m-bank/delete/${id_bank}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: `${bank} has been Deleted.`,
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