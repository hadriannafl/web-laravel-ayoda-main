<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Print Form Outbound Inventory 💳
                </h1>
            </div>
        </div>
        <!-- label -->
        <div class="flex flex-row text-xs mb-3">
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3" for="company">Company :</p>
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company">
                        <option value="" selected>All</option>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                @else
                    <input id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company" value="{{Auth::user()->company_id}}" hidden/>
                @endif
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="approval" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Form Date</th>
                        <th class="text-center">Outbound #</th>
                        <th class="text-center">User Request</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Warehouse</th>
                        <th class="text-center">Total Qty</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
         $(document).ready(function () {
            $('#approval').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "desc" ]],
                language: {
                    search: "Search RAB # : "
                },
                ajax: {
                    url: "{{ route('outbound-inventory.getdataprint') }}",
                    data:function(d){
                        d.company = $("#company").val()
                    }
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "date",
                        name: "date"
                    },
                    {
                        data: "id_outbound",
                        name: "id_outbound"
                    },
                    {
                        data: "first_name",
                        name: "first_name"
                    },
                    {
                        data: "companyName",
                        name: "companyName"
                    },
                    {
                        data: "w_name",
                        name: "w_name"
                    },
                    {
                        data: "total_qty",
                        name: "total_qty"
                    },
                    {
                        data: "approvalstat",
                        name: "approvalstat"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1, 7, 8] },
                    { className: 'text-right', targets: [6] }
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $(".company").on('change', function (e) {
                $('#approval').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>