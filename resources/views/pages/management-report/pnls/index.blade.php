<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Fin - Profit and Lost 🪙
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="pnls" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Profit & Loss - Period</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#pnls').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                sort: false,
                language: {
                    search: "Search PNL-Date: "
                },
                ajax: {
                    url: "{{ route('pnls.getdata') }}"
                },
                columns: [
                    {
                        data: "pnl_date",
                        name: "pnl_date"
                    },
                    {
                        data: "report_status",
                        name: "report_status"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
        });
    </script>
    @endsection
</x-app-layout>