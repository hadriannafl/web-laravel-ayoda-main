<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">List Assigned Asset Request 📝</h1>
        </div>
        <div class="flex flex-row mb-3">
            <div class="rounded-full columns-1 h-5 w-5" style="background-color: grey"></div>
            <p class="flex flex-row ml-1">Requested</p>
            <div class="rounded-full bg-yellow-200 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Approved</p>
            <div class="rounded-full bg-red-500 md:break-after-column h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Denied</p>
            <div class="rounded-full bg-sky-500 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Printed</p>
            <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Received</p>
        </div>
        <!-- label -->
        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status123">Request Status :</p>
                <select id="status123" class="status123 flex flex-row ml-3 mb-3 text-xs" name="status123">
                    <option value="">All</option>
                    <option value="Requested">Requested</option>
                    <option value="Approved">Approved</option>
                    <option value="Denied">Denied</option>
                    <option value="Printed">Printed</option>
                    <option value="Received">Received</option>
                </select>
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="typeRequest">Type Request :</p>
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
        <div class="px-5 py-4">
            <div class="space-y-3">
                <div class="table-responsive">
                    <table id="assigned-request" class="table table-striped table-bordered text-xs" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
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
        </div>

    </div>
    @section('js-page')
    <script>  
    $(document).ready(function() {
        $('#assigned-request').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: false,
                    stateServe: true,
                    "order": [[ 1, "desc" ]],
                    language: {
                        search: "Search Assigned ID : "
                    },
                    ajax: {
                        url: "{{ route('assigned-asset.getdata') }}",
                        data:function(d){                    
                            d.status123 = $("#status123").val()
                            d.typeRequest = $("#typeRequest").val()
                            d.company = $("#company").val()
                        }
                    },
                    columns: [
                    {
                        data: "label",
                        name: "label"
                    },
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
                    { className: 'text-center', targets: [1, 2, 4, 6] },
                    ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
                });

                $('#status123').on('change', function (e) {
                    $('#assigned-request').DataTable().ajax.reload();
                })
                $('#typeRequest').on('change', function (e) {
                    $('#assigned-request').DataTable().ajax.reload();
                })
                $('#company').on('change', function (e) {
                    $('#assigned-request').DataTable().ajax.reload();
                })
                $('#assigned-request').on("click", ".btn-cancel",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Cancel Assigned Request!",
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
                            url: `/ga/assigned-asset/cancel/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        icon : 'success',
                                        title: 'Success!',
                                        text: `Assigned Request has been Canceled.`,
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