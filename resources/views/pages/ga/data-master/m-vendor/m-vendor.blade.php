<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Vendor Preference Inventory Asset 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <a href="{{route('m-vendor.form')}}" class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>&nbsp; Create New Vendor Preference
                </a>
                @if (Auth::user()->role_name == 'IT' || Auth::user()->role_name == 'Administrator')
                <label class="flex flex-row text-xs">
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="dept">Department</p>
                    <select id="dept" class="dept form-select flex flex-row ml-3 mb-3 text-xs" name="dept">
                        <option value="0">All</option>
                        <option value="1">Purchasing</option>
                        <option value="2">Finance</option>
                    </select>
                </label>
                @elseif (Auth::user()->role_name == 'Finance')
                    <input type="text" id="dept" name="dept" class="dept form-input" value="2" readonly hidden/>
                @elseif (Auth::user()->role_name == 'Purchasing')
                <input type="text" id="dept" name="dept" class="dept form-input" value="1" readonly hidden/>
                @endif
            </label>
        </div>
        <div class="table-responsive">
            <table id="vendors" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Vendor's Type</th>
                        <th class="text-center">Vendor's Name</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">City</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">Contact Phone</th>
                        <th class="text-center">POS Code</th>
                        <th class="text-center">NPWP ID</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#vendors').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 2, "asc" ]],
                language: {
                    search: "Search Vendor:"
                },
                ajax: {
                    url: "{{ route('m-vendor.getdata') }}",
                    data:function(d){
                        d.dept = $("#dept").val()
                    }
                },
                columns: [
                    {
                        data: "company_type",
                        name: "company_type"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "address",
                        name: "address"
                    },
                    {
                        data: "city",
                        name: "city"
                    },
                    {
                        data: "country",
                        name: "country"
                    },
                    {
                        data: "phone",
                        name: "phone"
                    },
                    {
                        data: "zip_code",
                        name: "zip_code"
                    },
                    {
                        data: "npwp_id",
                        name: "npwp_id"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 5, 6, 8] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $("#dept").on('change', function (e) {
                e.preventDefault();
                $('#vendors').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>