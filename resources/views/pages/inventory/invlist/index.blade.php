<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Inventory Stock 📋
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="invlist" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Product Code</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Ready Goods</th>
                        <th class="text-center">Purchase Order (in Transit)</th>
                        <th class="text-center">Sales Order (awaiting Delivery)</th>
                        <th class="text-center">Nett Goods</th>
                        <th class="text-center">Damage/Quarantine Goods</th>
                        <th class="text-center">Last Update Stock</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#invlist').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                language: {
                    search: "Search Product Name: "
                },
                ajax: {
                    url: "{{ route('invlist.getdata') }}"
                },
                columns: [
                    {
                        data: "code",
                        name: "code"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "unit",
                        name: "unit"
                    },
                    {
                        data: "global_stock",
                        name: "global_stock"
                    },
                    {
                        data: "purchased",
                        name: "purchased"
                    },
                    {
                        data: "reserved_so",
                        name: "reserved_so"
                    },
                    {
                        data: "nett_stock",
                        name: "nett_stock"
                    },
                    {
                        data: "broken_stock",
                        name: "broken_stock"
                    },
                    {
                        data: "stock_lastupdated",
                        name: "stock_lastupdated"
                    },
                ],
                columnDefs: [
                    { className: 'text-right', targets: [3, 4, 5, 6, 7] },
                    { className: 'text-center', targets: [2, 8] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
        });
    </script>
    @endsection
</x-app-layout>