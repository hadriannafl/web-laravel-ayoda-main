<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Global Sales Achievement Detail 📓
                </h1>
            </div>
        </div>

        <label class="flex flex-row text-xs justify-start mt-2 mb-3">
            <p class="flex flex-row text-slate-800 mt-1 mr-3 text-sm" for="year1">Year :</p>
                <select id="year1" class="year1 flex flex-row text-xs" name="year1">
                    <option value="2020" {{ date('Y') == '2020' ? 'selected' : '' }}>2020</option>
                    <option value="2021" {{ date('Y') == '2021' ? 'selected' : '' }}>2021</option>
                    <option value="2022" {{ date('Y') == '2022' ? 'selected' : '' }}>2022</option>
                    <option value="2023" {{ date('Y') == '2023' ? 'selected' : '' }}>2023</option>
                    <option value="2024" {{ date('Y') == '2024' ? 'selected' : '' }}>2024</option>
                    <option value="2025" {{ date('Y') == '2025' ? 'selected' : '' }}>2025</option>
                    <option value="2026" {{ date('Y') == '2026' ? 'selected' : '' }}>2026</option>
                    <option value="2027" {{ date('Y') == '2027' ? 'selected' : '' }}>2027</option>
                    <option value="2028" {{ date('Y') == '2028' ? 'selected' : '' }}>2028</option>
                    <option value="2029" {{ date('Y') == '2029' ? 'selected' : '' }}>2029</option>
                    <option value="2030" {{ date('Y') == '2030' ? 'selected' : '' }}>2030</option>
                    <option value="2031" {{ date('Y') == '2031' ? 'selected' : '' }}>2031</option>
                    <option value="2032" {{ date('Y') == '2032' ? 'selected' : '' }}>2032</option>
                    <option value="2033" {{ date('Y') == '2033' ? 'selected' : '' }}>2033</option>
                    <option value="2034" {{ date('Y') == '2034' ? 'selected' : '' }}>2034</option>
                    <option value="2035" {{ date('Y') == '2035' ? 'selected' : '' }}>2035</option>
                </select>
        </label>

        <!-- Table -->
        <div class="table-responsive">
            <table id="globalSalesDetail" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Sales Name</th>
                        <th class="text-center">Realized</th>
                        <th class="text-center">Budget</th>
                        <th class="text-center">Achievement %</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@section('js-page')
<script>
    $(document).ready(function () {
        $('#globalSalesDetail').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "sort": false,
                language: {
                    search: "Search Sales Name # : "
                },
                ajax: {
                    url: "{{ route('dashboard.percent1') }}",
                    data:function(d){
                        d.year1 = $("#year1").val()
                    }
                },
                columns: [
                    {
                        data: "periode",
                        name: "periode"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "r_sales",
                        name: "r_sales"
                    },
                    {
                        data: "b_sales",
                        name: "b_sales"
                    },
                    {
                        data: "percent",
                        name: "percent"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 4] },
                    { className: 'text-right', targets: [2, 3] },
                ],lengthMenu: [[12], [12]]
            });
            $(".year1").on('change', function (e) {
                $('#globalSalesDetail').DataTable().ajax.reload();
            })
    });
</script>
@endsection
</x-app-layout>