<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Reimburse Approval 2 To - Edit 🗄️
                </h1>
            </div>
        </div>

        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <a href="{{route('reimburseapprovalto.editpage')}}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white text-xs mb-3">
                    Master Reimburse Approval 1 To - Edit
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
                        <th class="text-center">Action</th>
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
                    url: "{{ route('reimburseapproval2to.getdata') }}",
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
                    },
                    {
                        data: "action",
                        name: "action"
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
            $('#approvalto').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const company = $(this).data('id_company');

                $.ajax({
                    type: "GET",
                    url: `/data-master/m-reimburseapproval2to/getdata/${id}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/data-master/m-reimburseapproval2to/update/${id}">
                                <input type="hidden" name="_token" value="${csrf_token}" />
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="bank1">Company<span
                                                    class="text-rose-500">*</span></label>
                                            <select id="company" name="company" class="company form-select w-full px-2 py-1" required>
                                                <option selected hidden value="">Select Company</option>
                                                @foreach ($dataChildCompany as $company)
                                                <option value="{{$company->id_company}}" ${company == '{{$company->id_company}}' ? 'selected':''}>{{$company->name}}</option>
                                                @endforeach
                                            </select>
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