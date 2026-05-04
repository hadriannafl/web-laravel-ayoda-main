<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master CID Bank 🗄️
                </h1>
            </div>
        </div>

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
            </label>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="cidsBank" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Company</th>
                        <th class="text-center">Bank Name</th>
                        <th class="text-center">Bank CID</th>
                        <th class="text-center">Bank Account</th>
                        <th class="text-center">Bank Account Holder</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#cidsBank').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search:"
                },
                ajax: {
                    url: "{{ route('cidbank.getdata') }}",
                    data:function(d){
                        d.company = $("#company").val()
                    }
                },
                columns: [
                    {
                        data: "companyName",
                        name: "companyName"
                    },
                    {
                        data: "bankName",
                        name: "bankName"
                    },
                    {
                        data: "cidbank",
                        name: "cidbank"
                    },
                    {
                        data: "bank_acc",
                        name: "bank_acc"
                    },
                    {
                        data: "acc_holder",
                        name: "acc_holder"
                    }
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1, 3] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $(".company").on('change', function (e) {
                e.preventDefault();
                $('#cidsBank').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>