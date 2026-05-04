<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master RAB Beneficiary Bank - Edit 🗄️
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
                        <th class="text-center">Beneficiary Bank</th>
                        <th class="text-center">Beneficiary Account</th>
                        <th class="text-center">Beneficiary Account Name</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Action</th>
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
                    url: "{{ route('rabbank.getdata') }}",
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
                        data: "beneficiary_bank",
                        name: "beneficiary_bank"
                    },
                    {
                        data: "beneficiary_acc",
                        name: "beneficiary_acc"
                    },
                    {
                        data: "beneficiary_name",
                        name: "beneficiary_name"
                    },
                    {
                        data: "desc",
                        name: "desc"
                    },
                    {
                        data: "action",
                        name: "action"
                    }
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1, 2] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $(".company").on('change', function (e) {
                e.preventDefault();
                $('#cidsBank').DataTable().ajax.reload();
            })

            $('#cidsBank').on("click", ".btn-modal", function () {
                const id_cidb = $(this).data('id_cidb');
                const id_bank = $(this).data('id_bank');
                const id_company = $(this).data('id_company');
                const bank_acc = $(this).data('bank_acc');
                const acc_holder = $(this).data('acc_holder');
                const desc = $(this).data('desc');

                $.ajax({
                    type: "GET",
                    url: `/data-master/m-rabbank/getdata/${id_cidb}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/data-master/m-rabbank/update/${id_cidb}">
                                <input type="hidden" name="_token" value="${csrf_token}" />
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="company_id1">Company<span class="text-rose-500">*</span></label>
                                                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                                                    <select id="company_id1" name="company_id1" class="company_id1 form-select w-full px-2 py-1" required>
                                                        @foreach ($dataChildCompany as $company)
                                                            <option value="{{$company->id_company}}" ${id_company == '{{$company->id_company}}' ? 'selected':''}>{{$company->name}}</option>
                                                        @endforeach
                                                        </select>
                                                @else
                                                    <input id="company_id1" name="company_id1" class="company_id1 form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{ Auth::user()->company_id}}" readonly required hidden/>
                                                    <input id="companies" name="companies" class="companies form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataChildCompany->name}}" required readonly/>
                                                @endif
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="id_bank1">Beneficiary Bank<span
                                                    class="text-rose-500">*</span></label>
                                            <select id="id_bank1" name="id_bank1" type="text" class="id_bank1 form-input w-full px-2 py-1" required>
                                                @foreach ($bank as $bank)
                                                    <option value="{{$bank->id_bank}}" ${id_bank == '{{$bank->id_bank}}' ? 'selected':''}>{{$bank->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="beneficiary_acc1">Beneficiary Account<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="beneficiary_acc1" name="beneficiary_acc1" type="text" class="beneficiary_acc1 form-input w-full px-2 py-1" value="${bank_acc}" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="beneficiary_name1">Beneficiary Account Name<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="beneficiary_name1" name="beneficiary_name1" type="text" class="beneficiary_name1 form-input w-full px-2 py-1" value="${acc_holder}" required/>
                                        </div>
                                        <div>
                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="desc1">Description<span
                                                class="text-rose-500">*</span></label>
                                            <textarea id="desc1" name="desc1" type="text" class="desc1 form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" rows="3" required>${desc}</textarea>
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