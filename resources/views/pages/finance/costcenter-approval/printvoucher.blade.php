<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Print Cost Center Form 💳
                </h1>
            </div>
        </div>

         <!-- label -->
        <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                {{-- <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status" hidden>Request Status :</p>
                <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status" hidden>
                    <option value="HQ 2 Approved" selected>HQ 2 Approved</option>
                </select>   --}}
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
                            <option value="{{ $company->id_company }}" {{ Auth::user()->company_id == $company->id_company ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @endif
                    {{-- @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="department">Department :</p>
                    <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                        <option value="" selected>All</option>
                        @foreach ($department as $dept)
                            <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @endif --}}
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="approval" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Request Date</th>
                        <th class="text-center">Due Date</th>
                        <th class="text-center">Cost Center #</th>
                        <th class="text-center">Applicant</th>
                        <th class="text-center">Beneficiary</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Total Cost</th>
                        <th class="text-center">Notes</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Last Updated At</th>
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
                "order": [[ 1, "desc" ]],
                language: {
                    search: "Search Cost Center # : "
                },
                ajax: {
                    url: "{{ route('cost-list.getprintvoucher') }}",
                    data:function(d){
                        d.company = $("#company").val()
                        d.department = $("#department").val()
                    }
                },
                columns: [
                    {
                        data: "datereq",
                        name: "datereq"
                    },
                    {
                        data: "due_date",
                        name: "due_date"
                    },
                    {
                        data: "idreqform",
                        name: "idreqform"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "applicant",
                        name: "applicant"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "department",
                        name: "department"
                    },
                    {
                        data: "gtotal",
                        name: "gtotal"
                    },
                    {
                        data: "note",
                        name: "note"
                    },
                    {
                        data: "approvalstat",
                        name: "approvalstat"
                    },
                    {
                        data: "updated_at",
                        name: "updated_at"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 10] },
                    { className: 'text-right', targets: [7] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $(".company").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })
            $(".department").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })

            $('#approval').on("click", ".btn-print",  function () {
                const id = $(this).data("id");
                const no = $(this).data("no");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Print Cost Center Form',
                    text: `Cost Center Form #${no}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Print Form!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: `/finance/costcenter-approval/list/signatureupdate/${id}`,
                            success: function(_response){
                                const {message } = _response;
                                if(_response.st == '1'){
                                    var idRec = _response.id;
                                    urlRedirect = `/finance/costcenter-approval/list/print/`+idRec;
                                    // window.open(urlRedirect, '_blank') = urlRedirect;
                                    window.open(urlRedirect, '_blank');
                                
                                    window.location.href = '/finance/costcenter-approval/printvoucher';
                                } else if(_response.st == '0'){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Unsuccessfully!',
                                        confirmButtonColor: '#3085d6',
                                        text: 'Cost Center Already Printed.',
                                        message
                                    })
                                }
                            },
                            error: function (data) {
                                console.info("error: ", data)
                            }
                        })

                    }
                })
            });
        });
    </script>
    @endsection
</x-app-layout>