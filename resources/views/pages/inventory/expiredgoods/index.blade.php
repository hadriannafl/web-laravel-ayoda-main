<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Inventory Expired Goods ⌛
                </h1>
            </div>
        </div>


        <!-- Table -->
        <div class="flex flex-row">
            <div class="flex flex-row rounded-full bg-black h-5 w-5"></div>
            <p class="flex flex-row ml-1"><=30 Days</p>
            <div class="rounded-full bg-red-500 md:break-after-column h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">31 - 180 Days</p>
            <div class="rounded-full bg-yellow-200 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">181 - 365 Days</p>
            <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">>365 Days</p>
        </div>
        <div class="table-responsive mt-3">
            <table id="expiredgoods" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Inventory Code</th>
                        <th class="text-center">Inventory Name</th>
                        <th class="text-center">Batch No</th>
                        <th class="text-center">Expired Date</th>
                        <th class="text-center">Quantity</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#expiredgoods').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                language: {
                    search: "Search Inventory Name:"
                },
                ajax: {
                    url: "{{ route('expiredgoods.getdata') }}"
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "idinv",
                        name: "idinv"
                    },
                    {
                        data: "description",
                        name: "description"
                    },
                    {
                        data: "batch",
                        name: "batch"
                    },
                    {
                        data: "expdate",
                        name: "expdate"
                    },
                    {
                        data: "qty",
                        name: "qty"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [3, 4] },
                    { className: 'text-right', targets: [5] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]]
            });
        });
    </script>
    @endsection
</x-app-layout>