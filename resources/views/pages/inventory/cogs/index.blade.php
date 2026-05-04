<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Inventory COGS 📋
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="cogs" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Inventory Code</th>
                        <th class="text-center">Inventory Name</th>
                        <th class="text-center">Previous COGS (IDR)</th>
                        <th class="text-center">Current COGS (IDR)</th>
                        <th class="text-center">PO Currency</th>
                        <th class="text-center">PO Min Price</th>
                        <th class="text-center">PO Max Price</th>
                        <th class="text-center">Currency Last PO</th>
                        <th class="text-center">Price Last PO</th>
                        <th class="text-center">Date Last PO</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#cogs').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                language: {
                    search: "Search Inventory Name: "
                },
                ajax: {
                    url: "{{ route('cogs.getdata') }}"
                },
                columns: [
                    {
                        data: "idinventory",
                        name: "idinventory"
                    },
                    {
                        data: "inventory_name",
                        name: "inventory_name"
                    },
                    {
                        data: "cogs_previous",
                        name: "cogs_previous"
                    },
                    {
                        data: "cogs_now",
                        name: "cogs_now"
                    },
                    {
                        data: "currency",
                        name: "currency"
                    },
                    {
                        data: "min_po",
                        name: "min_po"
                    },
                    {
                        data: "max_po",
                        name: "max_po"
                    },
                    {
                        data: "currency_last_purchase",
                        name: "currency_last_purchase"
                    },
                    {
                        data: "last_purchase_price",
                        name: "last_purchase_price"
                    },
                    {
                        data: "last_purchase_date",
                        name: "last_purchase_date"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [ 4, 7, 9] },
                    { className: 'text-right', targets: [ 2, 3, 5, 6, 8 ] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
        });
    </script>
    @endsection
</x-app-layout>