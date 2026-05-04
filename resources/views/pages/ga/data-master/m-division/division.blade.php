<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Division 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="division-table" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Department</th>
                        <th class="text-center">Division</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#division-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Division:"
                },
                ajax: {
                    url: "{{ route('m-division.getdata', ['deptId' => $dataDepartment1->idrec]) }}"
                },
                columns: [
                    {
                        data: "name_brand",
                        name: "name_brand"
                    },
                    {
                        data: "name",
                        name: "name"
                    }
                ],
                columnDefs: [
                    { className: 'text-center', targets: [] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
        });
    </script>
    @endsection
</x-app-layout>