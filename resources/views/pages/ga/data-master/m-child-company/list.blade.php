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
        <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                <a href="{{route('child-company.form')}}" class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>&nbsp; Create New Child Company
                </a>
            </label>
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