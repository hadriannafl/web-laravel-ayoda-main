<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Attendance List ⭐
                </h1>
            </div>
        </div>

        <!-- Table -->
            <label class="flex flex-row">
                <p class="flex flex-row text-sm text-slate-800 mb-3 mt-2" for="lastentry">FROM :</p>
                <input id="min" class="flex flex-row ml-3 mb-3" type="date"/>
                <p class="flex flex-row text-sm text-slate-800 mb-3 ml-3 mt-2" for="lastentry">TO :</p>
                <input id="max" class="text-sm flex flex-row ml-3 mb-3" type="date"/>
                <button id="btn-search" class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3 mb-3" type="button">
                    <span class="xs:block">Search</span>
                </button>
            </label>
        <div class="table-responsive">
            <table id="attendance" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Clock In</th>
                        <th class="text-center">Clock Out</th>
                        <th class="text-center">Total Work Hours</th>
                        <th class="text-center">Late</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>

         $(document).ready(function () {
            $('#attendance').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                order:[0, 'DESC'],
                language: {
                    search: "Search: "
                },
                ajax: {
                    url: "{{ route('attandance.getdata') }}",
                    data: function (d) {
                        d.from = $("#min").val(),
                        d.to = $("#max").val()
                    }
                },
                columns: [
                    {
                        data: "lastentry",
                        name: "lastentry"
                    },
                    {
                        data: "sdate",
                        name: "sdate"
                    },
                    {
                        data: "edate",
                        name: "edate"
                    },
                    {
                        data: "hourcalc",
                        name: "hourcalc"
                    },
                    {
                        data: "latecalc",
                        name: "latecalc"
                    }
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 4] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $("#btn-search").on("click", function () {
                $('#attendance').DataTable().ajax.reload();
            });
        });
    </script>
    @endsection
</x-app-layout>