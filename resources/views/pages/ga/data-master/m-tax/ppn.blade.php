<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master PPN 🗄️
                </h1>
            </div>
        </div>

        <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                <a href="{{ route('ppn.form') }}" class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>&nbsp; New PPN Type</a> 
            </label>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="ppn-table" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">PPN Name</th>
                        <th class="text-center">Rate (%)</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Created By</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#ppn-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search PPN:"
                },
                ajax: {
                    url: "{{ route('ppn.getdata') }}"
                },
                columns: [
                    {
                        data: "name_ppn",
                        name: "name_ppn"
                    },
                    {
                        data: "rate",
                        name: "rate"
                    },
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "username",
                        name: "username"
                    }
                ],
                columnDefs: [
                    { className: 'text-center', targets: [2] },
                    { className: 'text-right', targets: [1] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
        });
    </script>
    @endsection
</x-app-layout>