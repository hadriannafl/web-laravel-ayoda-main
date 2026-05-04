<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master PR Approval 2 To - List 🗄️
                </h1>
            </div>
        </div>

        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <a href="{{route('prapproval1toonly')}}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white text-xs mb-3">
                    Master PR Approval 1 To - List
                </a>
                <a href="{{route('prapproval3toonly')}}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white text-xs mb-3 ml-5">
                    Master PR Approval 3 To - List
                </a>
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                        <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="company">Company :</p>
                        <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company">
                            <option value="" selected>All</option>
                            <option value="0">Dua Delapan Ayoda HQ</option>
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
            <table id="approvalto" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Username</th>
                        <th class="text-center">email</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Company Site</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#approvalto').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search:"
                },
                ajax: {
                    url: "{{ route('prapproval2to.getdata') }}",
                    data:function(d){
                        d.company = $("#company").val()
                    }
                },
                columns: [
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "email",
                        name: "email"
                    },
                    {
                        data: "role_name",
                        name: "role_name"
                    },
                    {
                        data: "companyName",
                        name: "companyName"
                    }
                ],
                columnDefs: [
                    { className: 'text-center', targets: [] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $(".company").on('change', function (e) {
                e.preventDefault();
                $('#approvalto').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>