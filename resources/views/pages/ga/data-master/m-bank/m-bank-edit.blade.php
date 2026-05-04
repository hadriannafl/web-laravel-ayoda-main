<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Bank - Edit 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
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
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#banks').on("click", ".btn-modal", function () {
                const id_bank = $(this).data('id_bank');
                const bank = $(this).data('bank');

                $.ajax({
                    type: "GET",
                    url: `/data-master/m-bank/getdata/${id_bank}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/data-master/m-bank/update/${id_bank}">
                                <input type="hidden" name="_token" value="${csrf_token}" />
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="bank1">Bank<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="bank1" name="bank1" type="text" class="bank1 form-input w-full px-2 py-1" value="${bank}" required/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="px-5 py-4 border-t border-slate-200">
                                    <div class="flex flex-wrap justify-end space-x-2">
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Cancel</button>
                                        <button type="submit" id="submit"
                                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Update</button>
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