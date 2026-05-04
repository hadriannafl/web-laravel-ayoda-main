<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    AR - Days All Customer 🤝
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="ar-days-finance" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Paid Invoice Count</th>
                        <th>Paid Invoice Total</th>
                        <th>Paid - Min Days</th>
                        <th>Paid - Max Days</th>
                        <th>Days Sale Outstanding</th>
                        <th>Unpaid Invoice Count</th>
                        <th>Unpaid Invoice Total</th>
                        <th>Unpaid - Max Days</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#ar-days-finance').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                language: {
                    search: "Search Customer Name: "
                },
                ajax: {
                    url: "{{ route('ar-days-finance.getdata') }}"
                },
                columns: [
                    {
                        data: "custname",
                        name: "custname"
                    },
                    {
                        data: "paidinvc",
                        name: "paidinvc"
                    },
                    {
                        data: "paidinvt",
                        name: "paidinvt"
                    },
                    {
                        data: "paidmin",
                        name: "paidmin"
                    },
                    {
                        data: "paidmax",
                        name: "paidmax"
                    },
                    {
                        data: "dso",
                        name: "dso"
                    },
                    {
                        data: "unpaidinvc",
                        name: "unpaidinvc"
                    },
                    {
                        data: "unpaidinvt",
                        name: "unpaidinvt"
                    },
                    {
                        data: "unpaidmaxd",
                        name: "unpaidmaxd"
                    },
                ],
                columnDefs: [
                    { className: 'text-right', targets: [2, 7] },
                    { className: 'text-center', targets: [1, 3, 4, 5, 6, 8] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
        });
    </script>
    @endsection
</x-app-layout>