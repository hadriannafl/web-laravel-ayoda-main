<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Reimbursement Type 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="reimburse-type" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Reimbursement</th>
                        <th class="text-center">Chart Of Account (COA)</th>
                        <th class="text-center">Added By</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Updated At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#reimburse-type').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 3, "desc" ]],
                language: {
                    search: "Search Type:"
                },
                ajax: {
                    url: "{{ route('reimburse-type.getdata') }}"
                },
                columns: [
                    {
                        data: "reimburse_type",
                        name: "reimburse_type"
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
                ],
                columnDefs: [
                    { className: 'text-center', targets: [3, 4] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
        });
    </script>
    @endsection
</x-app-layout>