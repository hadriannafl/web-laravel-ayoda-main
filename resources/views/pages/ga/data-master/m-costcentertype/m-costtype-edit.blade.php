<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Cost Center Type - Edit 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="costcenter-type" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Reimbursement</th>
                        <th class="text-center">Chart Of Account (COA)</th>
                        <th class="text-center">Added By</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Updated At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#costcenter-type').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 3, "desc" ]],
                language: {
                    search: "Search Type:"
                },
                ajax: {
                    url: "{{ route('costcenter-type.getdata') }}"
                },
                columns: [
                    {
                        data: "cost_type",
                        name: "cost_type"
                    },
                    {
                        data: "coa",
                        name: "coa"
                    },
                    {
                        data: "add_by",
                        name: "add_by"
                    },
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "updated_at",
                        name: "updated_at"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [3, 4] },
                    { className: 'flex justify-center', targets: [5] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#costcenter-type').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const type = $(this).data('type');
                const coa = $(this).data('coa');

                $.ajax({
                    type: "GET",
                    url: `/data-master/m-costcentertype/getdata/${id}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/data-master/m-costcentertype/update/${id}">
                                <input type="hidden" name="_token" value="${csrf_token}" />
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="type1">Cost Center Type Name<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="type1" name="type1" type="text" value="${type}"
                                                class=" type1 form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="coa1">Chart Of Account (COA)<span
                                                    class="text-rose-500">*</span></label>
                                            <textarea id="coa1" name="coa1"
                                                class=" coa form-input w-full px-2 py-1" rows="3"
                                                required>${coa}</textarea>
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
                                                class="btn-sm btn-update bg-indigo-500 hover:bg-indigo-600 text-white">Edit</button>
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