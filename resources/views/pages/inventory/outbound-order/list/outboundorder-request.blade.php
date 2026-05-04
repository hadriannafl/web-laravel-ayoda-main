<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Outbound Inventory List 💳
                </h1>
            </div>
        </div>

        <div class="flex flex-row mb-3">
            <div class="rounded-ful columns-1 h-5 w-5" style="background-color: grey; border-radius: 50%;"></div>
            <p class="flex flex-row ml-1">Draft</p>
            <div class="rounded-full bg-yellow-200 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Site Approved</p>
            <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Approved</p>
            <div class="rounded-full bg-red-500 md:break-after-column h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Denied/Canceled</p>
            <div class="rounded-full bg-sky-500 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Printed</p>
        </div>

          <!-- label -->
          <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                <a href="{{ route('outbound') }}" class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>&nbsp; New Outbound Inventory</a> 
            </label>

            <label class="flex flex-row text-xs ml-5">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status">Request Status :</p>
                <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                    <option value="">All</option>
                    <option value="Approved">Approved</option>
                    <option value="Canceled">Canceled</option>
                    <option value="Denied">Denied</option>
                    <option value="Draft">Draft</option>
                    <option value="Printed">Printed</option>
                    <option value="Site Approved">Site Approved</option>
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
                            <option value="{{ $company->id_company }}" {{ Auth::user()->company_id == $company->id_company ? ' selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @endif
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="approval" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Form Date</th>
                        <th class="text-center">Outbound #</th>
                        <th class="text-center">User Request</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Warehouse</th>
                        <th class="text-center">Total Qty</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
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
                    search: "Search RAB # : "
                },
                ajax: {
                    url: "{{ route('outbound-inventory.getdata') }}",
                    data:function(d){
                        d.status = $("#status").val()
                        d.company = $("#company").val()
                    }
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "date",
                        name: "date"
                    },
                    {
                        data: "id_outbound",
                        name: "id_outbound"
                    },
                    {
                        data: "first_name",
                        name: "first_name"
                    },
                    {
                        data: "companyName",
                        name: "companyName"
                    },
                    {
                        data: "w_name",
                        name: "w_name"
                    },
                    {
                        data: "total_qty",
                        name: "total_qty"
                    },
                    {
                        data: "approvalstat",
                        name: "approvalstat"
                    },
                    {
                        data: "action1",
                        name: "action1"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1, 7, 8] },
                    { className: 'text-right', targets: [6] }
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $(".status").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })
            $(".company").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })
            $('#approval').on("click", ".btn-cancel",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Cancel Outbound Inventory!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel Outbound!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: `/inventory/outbound-inventory/cancel/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        icon : 'success',
                                        title: 'Success!',
                                        text: `Outbound Inventory has been Canceled.`,
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