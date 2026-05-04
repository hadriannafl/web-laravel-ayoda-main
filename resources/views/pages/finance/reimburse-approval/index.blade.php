<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Reimburse Approval 1 💳
                </h1>
            </div>
        </div>
        <div class="flex flex-row text-xs mb-3">
            <div class="flex flex-row text-xs mb-3">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3" for="department">Request Status :</p>
                <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                    <option value="">All</option>
                    <option value="Waiting Approval 1" selected>Waiting Approval 1</option>
                    <option value="HQ 1 Approved">HQ 1 Approved</option>
                    <option value="Payment Proof">Payment Proof</option>
                    <option value="HQ 1 Denied">HQ 1 Denied</option>
                    <option value="HQ 2 Denied">HQ 2 Denied</option>
                    <option value="Canceled">Canceled</option>
                </select>
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="company">Company :</p>
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company">
                        <option value="" selected>All</option>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    {{-- <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="department">Department :</p>
                    <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                        @foreach ($department as $dept)
                            <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                        @endforeach
                    </select> --}}
                    {{-- @else
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company" hidden>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}" {{ Auth::user()->company_id == $company->id_company ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select> --}}
                    {{-- <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                        @foreach ($department as $dept)
                            <option value="{{ $dept->name }}" {{ Auth::user()->role_name == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select> --}}
                @endif
            </div>
        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table id="approval" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Request Date</th>
                        <th class="text-center">Reimburse Request #</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Total Reimburse</th>
                        <th class="text-center">Notes</th>
                        <th class="text-center">Status</th>
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
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search : "
                },
                ajax: {
                    url: "{{ route('reimburse-approval.getdata') }}",
                    data:function(d){
                        d.status = $("#status").val()
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
                        data: "idreqform",
                        name: "idreqform"
                    },
                    {
                        data: "employee",
                        name: "employee"
                    },
                    {
                        data: "companyName",
                        name: "companyName"
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
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1] },
                    { className: 'text-right', targets: [5] },
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
            $(".status").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })
            $('#approval').on("click", ".btn-cancel",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Cancel Reimburse Request!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel Request!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: `/ga/reimburse-approval/cancel/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        icon : 'success',
                                        title: 'Success!',
                                        text: `Reimburse Request has been Canceled.`,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                    window.location.reload(true);
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