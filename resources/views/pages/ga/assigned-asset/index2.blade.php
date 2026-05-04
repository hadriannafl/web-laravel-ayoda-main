<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Assigned Request Approval 2
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="assigned-request" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Form Date</th>
                        <th class="text-center">Assigned Asset Code</th>
                        <th class="text-center">Type Assigned</th>
                        <th class="text-center">Requested By</th>
                        <th class="text-center">Approval Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
         $(document).ready(function () {
            $('#assigned-request').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: false,
                    stateServe: true,
                    "order": [[ 0, "desc" ]],
                    language: {
                        search: "Search Assigned ID : "
                    },
                    ajax: {
                        url: "{{ route('assigned-approvalga2.getdata') }}"
                    },
                    columns: [
                    {
                        data: "borrow_date",
                        name: "borrow_date"
                    },
                    {
                        data: "idassign",
                        name: "idassign"
                    },
                    {
                        data: "type_assign",
                        name: "type_assign"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "approvalstat",
                        name: "approvalstat"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 4, 5] },
                    ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
                });
        });
    </script>
    @endsection
</x-app-layout>