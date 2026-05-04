<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Assigned Request Approval
                </h1>
            </div>
        </div>
        <div class="flex flex-row text-xs mb-3">
            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="typeRequest">Type Request :</p>
                <select id="typeRequest" class="typeRequest flex flex-row ml-3 mb-3 text-xs" name="typeRequest">
                    <option value="">All</option>
                    <option value="Assign">Assign</option>
                    <option value="Return">Return</option>
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
                        <option value="{{ $company->id_company }}" {{Auth::user()->company_id == $company->id_company ? 'Selected':''}}>{{ $company->name }}</option>
                    @endforeach
                </select>
                @endif
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="assigned-request" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Form Date</th>
                        <th class="text-center">Assigned Asset Code</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Assigned/Return</th>
                        <th class="text-center">Requested By</th>
                        <th class="text-center">Approval Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
         $(document).ready(function () {
            $('#assigned-request').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: false,
                    stateServe: true,
                    "order": [[ 0, "desc" ]],
                    language: {
                        search: "Search Assigned ID : "
                    },
                    ajax: {
                        url: "{{ route('assigned-approvalga.getdata') }}",
                        data:function(d){                    
                            d.typeRequest = $("#typeRequest").val()
                            d.company = $("#company").val()
                        }
                    },
                    columns: [
                    {
                        data: "borrow_date",
                        name: "borrow_date"
                    },
                    {
                        data: "idassign",
                        name: "idassign"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "type_assign",
                        name: "type_assign"
                    },
                    {
                        data: "name",
                        name: "name"
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
                    { className: 'text-center', targets: [0, 1, 3, 5, 6] },
                    ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
                });
                $('#typeRequest').on('change', function (e) {
                    $('#assigned-request').DataTable().ajax.reload();
                })
                $('#company').on('change', function (e) {
                    $('#assigned-request').DataTable().ajax.reload();
                })
        });
    </script>
    @endsection
</x-app-layout>