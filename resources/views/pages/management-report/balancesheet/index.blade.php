<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Fin - Balance Sheet 📓
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="balancesheet" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th>Balance Sheet - Period</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#balancesheet').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                sort: false,
                language: {
                    search: "Search Balance Sheet Date: "
                },
                ajax: {
                    url: "{{ route('bs.getdata') }}"
                },
                columns: [
                    {
                        data: "bs_date",
                        name: "bs_date"
                    },
                    {
                        data: "upload_user",
                        name: "upload_user"
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