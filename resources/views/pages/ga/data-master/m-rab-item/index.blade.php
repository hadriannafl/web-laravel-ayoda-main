<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master RAB Item 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="master-rab" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Sub Department</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Chart Of Account (COA)</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#master-rab').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "desc" ]],
                language: {
                    search: "Search RAB Item:"
                },
                ajax: {
                    url: "{{ route('master-rab.getdata') }}"
                },
                columns: [
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "department",
                        name: "department"
                    },
                    {
                        data: "sub_department",
                        name: "sub_department"
                    },
                    {
                        data: "detail",
                        name: "detail"
                    },
                    {
                        data: "coa",
                        name: "coa"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
        });
    </script>
    @endsection
</x-app-layout>