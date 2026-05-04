<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Edit Inbound Inventory 💳
                </h1>
            </div>
        </div>

        <div class="flex flex-row mb-3">
            <div class="rounded-ful columns-1 h-5 w-5" style="background-color: grey; border-radius: 50%;"></div>
            <p class="flex flex-row ml-1">Draft</p>
            <div class="rounded-full bg-yellow-200 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Site Approved</p>
            <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Approved</p>
            <div class="rounded-full bg-red-500 md:break-after-column h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Denied/Canceled</p>
            <div class="rounded-full bg-sky-500 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Printed</p>
        </div>

          <!-- label -->
          <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status">Request Status :</p>
                <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                    <option value="">All</option>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Received">Received</option>
                </select>
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="company">Company :</p>
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
        </div>

        <!-- Table -->
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
                data: "action1",
                name: "action1"
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