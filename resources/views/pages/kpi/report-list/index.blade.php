<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    BD - Weekly Report ALL 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 mt-1 text-sm" for="year">Year :</p>
                    <select id="year" class="year flex flex-row ml-3 mb-3 text-xs" name="year">
                        <option value="">All</option>
                        <option value="2022" {{ date('Y') == '2022' ? 'selected' : '' }}>2022</option>
                        <option value="2023" {{ date('Y') == '2023' ? 'selected' : '' }}>2023</option>
                        <option value="2024" {{ date('Y') == '2024' ? 'selected' : '' }}>2024</option>
                        <option value="2025" {{ date('Y') == '2025' ? 'selected' : '' }}>2025</option>
                        <option value="2026" {{ date('Y') == '2026' ? 'selected' : '' }}>2026</option>
                        <option value="2027" {{ date('Y') == '2027' ? 'selected' : '' }}>2027</option>
                    </select>
                
                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '200')
                <p class="flex flex-row text-slate-800 mb-3 ml-3 mt-2 text-xs" for="salesname">Sales Representative :</p>
                    <select class="salesname ml-3 mb-3 text-xs" id="salesname" name="salesname">
                        <option value="">All</option>
                        @foreach ($dataUsers as $user )
                        <option value="{{$user->username}}">{{$user->username}}</option>
                        @endforeach
                    </select>
                @endif
            </label>
        </div>
        @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '200')
            <div class="table-responsive">
                <table id="total" class="table table-striped table-bordered text-xs" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Sales Representative</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Notes</th>
                            <th class="text-center">Attachment 1</th>
                            <th class="text-center">Attachment 2</th>
                            <th class="text-center">Attachment 3</th>
                            <th class="text-center">Updated At</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endif
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#total').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "searching": false,
                "order": [[ 1, "desc" ]],
                ajax: {
                    url: "{{ route('report-list.getdata') }}",
                    data:function(d){
                        d.year = $("#year").val()
                        d.salesname = $("#salesname").val()
                    }
                },
                columns: [
                    {
                        data: "add_by",
                        name: "add_by"
                    },
                    {
                        data: "date",
                        name: "date"
                    },
                    {
                        data: "notes",
                        name: "notes"
                    },
                    {
                        data: "action1",
                        name: "action1"
                    },
                    {
                        data: "action2",
                        name: "action2"
                    },
                    {
                        data: "action3",
                        name: "action3"
                    },
                    {
                        data: "updated_at",
                        name: "updated_at"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1, 3, 4, 5,  6] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $(".salesname").on('change', function (e) {
                $('#total').DataTable().ajax.reload();
            })
            $(".year").on('change', function (e) {
                $('#total').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>