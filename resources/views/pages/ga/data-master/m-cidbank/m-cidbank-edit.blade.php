<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master CID Bank - Edit 🗄️
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
                    },
                    {
                        data: "action",
                        name: "action"
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

            $('#cidsBank').on("click", ".btn-modal", function () {
                const id_cidb = $(this).data('id_cidb');
                const id_bank = $(this).data('id_bank');
                const id_company = $(this).data('id_company');
                const cidbank = $(this).data('cidbank');
                const bank_acc = $(this).data('bank_acc');
                const acc_holder = $(this).data('acc_holder');
                const pv_code = $(this).data('pv_code');

                $.ajax({
                    type: "GET",
                    url: `/data-master/m-cidbank/getdata/${id_cidb}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/data-master/m-cidbank/update/${id_cidb}">
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
                                            <label class="block text-sm font-medium mb-1" for="id_bank1">Bank<span
                                                    class="text-rose-500">*</span></label>
                                            <select id="id_bank1" name="id_bank1" type="text" class="id_bank1 form-input w-full px-2 py-1" required>
                                                @foreach ($bank as $bank)
                                                    <option value="{{$bank->id_bank}}" ${id_bank == '{{$bank->id_bank}}' ? 'selected':''}>{{$bank->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="cidbank1">Bank CID<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="cidbank1" name="cidbank1" type="text" class="cidbank1 form-input w-full px-2 py-1" value="${cidbank}" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="bank_acc1">Bank Account<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="bank_acc1" name="bank_acc1" type="text" class="bank_acc1 form-input w-full px-2 py-1" value="${bank_acc}" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="acc1_holder">Bank Account Holder<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="acc1_holder" name="acc1_holder" type="text" class="acc1_holder form-input w-full px-2 py-1" value="${acc_holder}" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="pv_code1">PV Code</label>
                                            <input id="pv_code1" name="pv_code1" type="text" class="pv_code1 form-input w-full px-2 py-1" value="${pv_code}"/>
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