<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    PO Pre System List 💳
                </h1>
            </div>
        </div>
         <!-- Table -->
        <div class="flex flex-row text-xs">
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
        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table id="po-presystem" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">PO Date</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">PO #</th>
                        <th class="text-center">PO Title</th>
                        <th class="text-center">Invoice #</th>
                        <th class="text-center">RAB #</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Amount DUe</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>

    @section('js-page')
    <script>
         $(document).ready(function () {
            $('#po-presystem').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "desc" ]],
                language: {
                    search: "Search : "
                },
                ajax: {
                    url: "{{ route('po-presystem.getdata') }}",
                    data:function(d){
                        d.company = $("#company").val()
                    }
                },
                columns: [
                    {
                        data: "date_po",
                        name: "date_po"
                    },
                    {
                        data: "companyName",
                        name: "companyName"
                    },
                    {
                        data: "no_po",
                        name: "no_po"
                    },
                    {
                        data: "po_title",
                        name: "po_title"
                    },
                    {
                        data: "no_invoice",
                        name: "no_invoice"
                    },
                    {
                        data: "no_rab",
                        name: "no_rab"
                    },
                    {
                        data: "first_name",
                        name: "first_name"
                    },
                    {
                        data: "amount_due",
                        name: "amount_due"
                    },
                    {
                        data: "action2",
                        name: "action2"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0] },
                    { className: 'text-right', targets: [7] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $(".company").on('change', function (e) {
                e.preventDefault();
                $('#po-presystem').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>