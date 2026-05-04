<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Inventory Aging 🕒
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="invaging" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">As Of Date</th>
                        <th rowspan="2" class="text-center">Inventory Code</th>
                        <th rowspan="2" class="text-center">Inventory Name</th>
                        <th colspan="5" class="text-center">Inventory Aging Days</th>
                        <th rowspan="2">Opening Balance / Adjustment</th>
                        <th rowspan="2">Total in Stock</th>
                    </tr>
                    <tr>
                        <th>
                            <= 30 Days</th>
                        <th>31 - 60 Days</th>
                        <th>61 - 90 Days</th>
                        <th>91 - 120 Days</th>
                        <th>> 121 Days</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#invaging').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                language: {
                    search: "Search Inventory Name: "
                },
                ajax: {
                    url: "{{ route('invaging.getdata') }}"
                },
                columns: [
                    {
                        data: "aging_date",
                        name: "aging_date"
                    },
                    {
                        data: "idinventory",
                        name: "idinventory"
                    },
                    {
                        data: "inventory_name",
                        name: "inventory_name"
                    },
                    {
                        data: "d0",
                        name: "d0"
                    },
                    {
                        data: "d30",
                        name: "d30"
                    },
                    {
                        data: "d60",
                        name: "d60"
                    },
                    {
                        data: "d90",
                        name: "d90"
                    },
                    {
                        data: "d120",
                        name: "d120"
                    },
                    {
                        data: "open_balance",
                        name: "open_balance"
                    },
                    {
                        data: "total",
                        name: "total"
                    },
                ],
                columnDefs: [
                    { className: 'text-right', targets: [3, 4, 5, 6, 7, 8, 9] },
                    { className: 'text-center', targets: [0, 1] },
                ], 
                lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
        });
    </script>
    @endsection
</x-app-layout>