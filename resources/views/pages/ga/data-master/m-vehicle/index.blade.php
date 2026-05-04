<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Vehicle 🗄️
                </h1>
            </div>
        </div>

        <!-- label -->
        <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3" for="company">Company :</p>
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company">
                        <option value="" selected>All</option>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @else
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company" hidden>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}" {{ Auth::user()->company_id == $company->id_company ? ' selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @endif
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="vehicle_type">Vehicle Type :</p>
                    <select id="vehicle_type" class="vehicle_type flex flex-row mb-3 text-xs" style="width: 10rem" name="vehicle_type">
                        <option value="" selected hidden>Select Vehicle</option>
                        <option value="Car">Car</option>
                        <option value="Dump Truk">Dump Truk</option>
                        <option value="Light Vehicle">Light Vehicle</option>
                        <option value="Motorcycle">Motorcycle</option>
                        <option value="Tug Boat">Tug Boat</option>
                    </select>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="vehicle" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Company</th>
                        <th class="text-center">Vehicle Type</th>
                        <th class="text-center">Vehicle Number</th>
                        <th class="text-center">Engine Number</th>
                        <th class="text-center">Frame Number</th>
                        <th class="text-center">Active Date</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#vehicle').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                language: {
                    search: "Search:"
                },
                ajax: {
                    url: "{{ route('vehicle.getdata') }}",
                    data:function(d){
                        d.company = $("#company").val()
                        d.vehicle_type = $("#vehicle_type").val()
                    }
                },
                columns: [
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "vehicle_type",
                        name: "vehicle_type"
                    },
                    {
                        data: "vehicle_number",
                        name: "vehicle_number"
                    },
                    {
                        data: "engine_number",
                        name: "engine_number"
                    },
                    {
                        data: "frame_number",
                        name: "frame_number"
                    },
                    {
                        data: "active_date",
                        name: "active_date"
                    }
                ],
                columnDefs: [
                    { className: 'text-center', targets: [2, 3, 4, 5] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $(".company").on('change', function (e) {
                e.preventDefault();
                $('#vehicle').DataTable().ajax.reload();
            })
            $(".vehicle_type").on('change', function (e) {
                e.preventDefault();
                $('#vehicle').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>