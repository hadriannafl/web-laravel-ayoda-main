<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Inbound Inventory List 📝</h1>
        </div>
        <div class="flex flex-row text-xs mb-3">
            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status">Request Status :</p>
            <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                <option value="">All</option>
                <option value="Scheduled">Scheduled</option>
                <option value="Received">Received</option>
            </select>
            <label class="flex flex-row text-xs ml-5">
            @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="company">Company :</p>
                <select id="company" class="company flex flex-row ml-3 mb-3 text-xs" name="company">
                    <option value="">All</option>
                    @foreach ( $dataChildCompany as $company)
                    <option value="{{$company->id_company}}">{{$company->name}}</option>
                    @endforeach
                </select>
            @else
                <input id="company" name="company"
                class="company form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                value="{{$dataChildCompany->id_company}}" readonly hidden/>
            @endif
        </div>
        <div class="px-5 py-4">
            <div class="space-y-3">
                <div class="table-responsive">
                    <table id="inbound-inventory" class="table table-striped table-bordered text-xs" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Form Date</th>
                                <th class="text-center">Inbound #</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">Warehouse</th>
                                <th class="text-center">Received Date</th>
                                <th class="text-center">Total Qty</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @section('js-page')
    <script>  
    $(document).ready(function() {
        $('#inbound-inventory').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: false,
                    stateServe: true,
                    "order": [[ 1, "asc" ]],
                    language: {
                        search: "Search : "
                    },
                    ajax: {
                        url: "{{ route('inbound-inventory.getdata') }}",
                        data:function(d){                    
                            d.company = $("#company").val()
                        }
                    },
                    columns: [
                    {
                        data: "date",
                        name: "date"
                    },
                    {
                        data: "id_inbound",
                        name: "id_inbound"
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
                        data: "received_date",
                        name: "received_date"
                    },
                    {
                        data: "total_qty",
                        name: "total_qty"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 4, 6] },
                    { className: 'text-right', targets: [5] },
                    ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
                });
                $('#company').on('change', function (e) {
                    $('#inbound-inventory').DataTable().ajax.reload();
                })
                $('#status').on('change', function (e) {
                    $('#inbound-inventory').DataTable().ajax.reload();
                })
    });
    </script>
    @endsection
    </x-app-layout>