<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Vehicle - Edit 🗄️
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
                        <th class="text-center">Action</th>
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
                    },
                    {
                        data: "action",
                        name: "action"
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

            $('#vehicle').on("click", ".btn-modal", function () {
                const id_vehicle = $(this).data('id_vehicle');
                const vehicle = $(this).data('vehicle');
                const vehicle_type = $(this).data('vehicle_type');
                const engine_number = $(this).data('engine_number');
                const frame_number = $(this).data('frame_number');
                const active_date = $(this).data('active_date');
                const id_company = $(this).data('id_company');

                $.ajax({
                    type: "GET",
                    url: `/data-master/m-vehicle/getdata/${id_vehicle}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/data-master/m-vehicle/update/${id_vehicle}">
                                <input type="hidden" name="_token" value="${csrf_token}" />
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                                            <label class="block text-sm font-medium mb-1" for="company">Company<span
                                                    class="text-rose-500">*</span></label>
                                            <select id="company" name="company" type="text" class="company form-select w-full px-2 py-1" required>
                                                @foreach ($dataChildCompany as $company)
                                                    <option value="{{ $company->id_company }}" ${id_company == '{{ $company->id_company }}' ? 'selected' : ''}>{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                            @else
                                                <label class="block text-sm font-medium mb-1" for="company">Company<span
                                                    class="text-rose-500">*</span></label>
                                                <select id="companyTest" name="companyTest"
                                                    class="companyTest form-select w-full px-2 py-1 read-only:bg-slate-200" disabled required>
                                                        <option value="{{$fixCompany->id_company}}" selected>{{$fixCompany->name}}</option>
                                                </select>
                                                <input id="company" name="company"
                                                class="company form-input w-full px-2 py-1 read-only:bg-slate-200" type="text"
                                                value="{{$fixCompany->id_company}}" readonly hidden/>
                                            @endif
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="vehicle_type">Vehicle Type<span
                                                    class="text-rose-500">*</span></label>
                                            <select id="vehicle_type" name="vehicle_type" type="text" class="vehicle_type form-select w-full px-2 py-1" required>
                                                <option value="Car" ${vehicle_type == 'Car' ? 'selected' : ''}>Car</option>
                                                <option value="Dump Truk" ${vehicle_type == 'Dump Truk' ? 'selected' : ''}>Dump Truk</option>
                                                <option value="Light Vehicle" ${vehicle_type == 'Light Vehicle' ? 'selected' : ''}>Light Vehicle</option>
                                                <option value="Motorcycle" ${vehicle_type == 'Motorcycle' ? 'selected' : ''}>Motorcycle</option>
                                                <option value="Tug Boat" ${vehicle_type == 'Tug Boat' ? 'selected' : ''}>Tug Boat</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="vehicle_number">Vehicle Number<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="vehicle_number" name="vehicle_number" type="text" class="vehicle_number form-input w-full px-2 py-1" value="${vehicle}" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="engine_number">Engine Number<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="engine_number" name="engine_number" type="text" class="engine_number form-input w-full px-2 py-1" value="${engine_number}" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="frame_number">Frame Number<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="frame_number" name="frame_number" type="text" class="frame_number form-input w-full px-2 py-1" value="${frame_number}" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="active_date">Active Date<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="active_date" name="active_date" type="date" class="active_date form-input w-full px-2 py-1" value="${active_date}" required/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="px-5 py-4 border-t border-slate-200">
                                    <div class="flex flex-wrap justify-end space-x-2">
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Cancel</button>
                                        <button type="submit" id="submit"
                                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Update</button>
                                    </div>
                                </div>
                            </form>
                        `);
                    },
                });
            });
        });
    </script>
    @endsection
</x-app-layout>