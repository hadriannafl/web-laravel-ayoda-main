<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    List Employee 🗄️
                </h1>
            </div>
        </div>
        <div class="flex flex-row mb-3">
            @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="company123">Company :</p>
                <select id="company" class="company flex flex-row ml-3 mb-3 text-xs" name="company">
                    <option value="">All</option>
                    @foreach ( $company as $companys)
                    <option value="{{$companys->id_company}}">{{$companys->name}}</option>
                    @endforeach
                </select>
            @else
                <input id="company" name="company"
                class="company form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                value="{{Auth::user()->company_id}}" readonly hidden/>
            @endif
        </div>

        <div class="table-responsive">
            <table id="employees" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Employee ID</th>
                        {{-- <th class="text-center">NIK</th> --}}
                        <th class="text-center">Day Of Birth</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Gender</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Employee Type</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Structural Title</th>
                        <th class="text-center">Position</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#employees').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 2, "asc" ]],
                language: {
                    search: "Search Employee:"
                },
                ajax: {
                    url: "{{ route('employee.getdata') }}",
                    data:function(d){                    
                        d.company = $("#company").val()
                    }
                },
                columns: [
                    {
                        data: "idemployee",
                        name: "idemployee"
                    },
                    // {
                    //     data: "nik",
                    //     name: "nik"
                    // },
                    {
                        data: "DoB",
                        name: "DoB"
                    },
                    {
                        data: "first_name",
                        name: "first_name"
                    },
                    {
                        data: "gen",
                        name: "gen"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "employee_type",
                        name: "employee_type"
                    },
                    {
                        data: "department",
                        name: "department"
                    },
                    {
                        data: "title_structural",
                        name: "title_structural"
                    },
                    {
                        data: "position",
                        name: "position"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 3, 5] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $('#company').on('change', function (e) {
                $('#employees').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>