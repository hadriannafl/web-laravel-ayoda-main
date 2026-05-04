<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Days Inventory Outstanding - DOI 📋
                </h1>
            </div>
        </div>

        <label class="flex flex-row text-xs justify-end mt-2 mb-3">
            <p class="flex flex-row text-slate-800 mt-1 mr-3 text-sm" for="year">Year :</p>
                <select id="year" class="year flex flex-row text-xs" name="year">
                    <option value="" selected>All</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                    <option value="2032">2032</option>
                    <option value="2033">2033</option>
                    <option value="2034">2034</option>
                    <option value="2035">2035</option>
                </select>
        </label>

        <!-- Table -->
        <div class="table-responsive text-xs">
            <table id="doi" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Month</th>
                        <th class="text-center">COGS (Monthly) IDR</th>
                        <th>COGS (YtD) IDR</th>
                        <th class="text-center">Inventory (Monthly Average) IDR</th>
                        <th class="text-center">Turnover (Monthly)</th>
                        <th class="text-center">DOI (Monthly)</th>
                        <th class="text-center">Turnover (YtD)</th>
                        <th class="text-center">DOI (Days Ratio)</th>
                        <th class="text-center">DOI (Monthly YtD)</th>
                        <th class="text-center">Year</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#doi').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 9, "desc" ]],
                "searching": false,
                ajax: {
                    url: "{{ route('doi.getdata') }}",
                    data:function(d){
                        d.year = $("#year").val()
                    }
                },
                columns: [
                    {
                        data: "month",
                        name: "month",
                    },
                    {
                        data: "cogsm",
                        name: "cogsm"
                    },
                    {
                        data: "cogsy",
                        name: "cogsy"
                    },
                    {
                        data: "invma",
                        name: "invma"
                    },
                    {
                        data: "turnoverm",
                        name: "turnoverm"
                    },
                    {
                        data: "doim",
                        name: "doim"
                    },
                    {
                        data: "turnovery",
                        name: "turnovery"
                    },
                    {
                        data: "doidr",
                        name: "doidr"
                    },
                    {
                        data: "doimy",
                        name: "doimy"
                    },
                    {
                        data: "year",
                        name: "year"
                    },
                ],
                columnDefs: [
                    { className: 'text-right', targets: [1, 2, 3, 4, 5, 6, 7, 8] },
                    { className: 'text-center', targets: [9] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $(".year").on('change', function (e) {
                $('#doi').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>