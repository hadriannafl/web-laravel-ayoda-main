<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Child Company 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="child-company" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Initials</th>
                        <th class="text-center">Logo</th>
                        <th class="text-center">Company Type</th>
                        <th class="text-center">Company Name</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">City</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">POS Code</th>
                        <th class="text-center">NPWP ID</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#child-company').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 3, "asc" ]],
                language: {
                    search: "Search Company:"
                },
                ajax: {
                    url: "{{ route('child-company.getdata') }}"
                },
                columns: [
                    {
                        data: "initials",
                        name: "initials"
                    },
                    {
                        data: "logo",
                        name: "logo"
                    },
                    {
                        data: "company_type",
                        name: "company_type"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "country",
                        name: "country"
                    },
                    {
                        data: "city",
                        name: "city"
                    },
                    {
                        data: "address",
                        name: "address"
                    },
                    {
                        data: "zip_code",
                        name: "zip_code"
                    },
                    {
                        data: "npwp_id",
                        name: "npwp_id"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 7] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
        });
    </script>
    @endsection
</x-app-layout>