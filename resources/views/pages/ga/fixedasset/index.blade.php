<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Serial Number Fixed Asset Detail 📝</h1>
        </div>
        <!-- label -->
        <div class="flex flex-row mb-3">
            <div class="rounded-full bg-sky-500 columns-1 h-5 w-5"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">Ready</p>
            <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">In Use/Assigned</p>
            <div class="rounded-full bg-pink-500 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">Good</p>
            <div class="rounded-full bg-yellow-200 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">Need Repair</p>
            <div class="rounded-full bg-red-500 md:break-after-column h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">Broken</p>
            <div class="rounded-full bg-black md:break-after-column h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">Discard</p>
            <div class="rounded-full columns-1 h-5 w-5 ml-5" style="background-color: grey"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">Sold</p>
        </div>
        <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status123">Status Available :</p>
                <select id="status123" class="status123 flex flex-row ml-3 mb-3 text-xs" name="status123">
                    <option value="">All</option>
                    <option value="Y">Ready</option>
                    <option value="N">In Use/Assigned</option>
                </select>
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="status1234">Status Condition :</p>
                <select id="status1234" class="status1234 flex flex-row ml-3 mb-3 text-xs" name="status1234">
                    <option value="">All</option>
                    <option value="Ready">Ready</option>
                    <option value="In Use/Assigned">In Use/Assigned</option>
                    <option value="Good">Good</option>
                    <option value="Need Reapair">Need Reapair</option>
                    <option value="Broken">Broken</option>
                    <option value="Discar">Discar</option>
                    <option value="Sold">Sold</option>
                </select>
            
            @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="company123">Company :</p>
                <select id="company123" class="company123 flex flex-row ml-3 mb-3 text-xs" name="company123">
                    <option value="">All</option>
                    @foreach ( $dataChildCompany as $company)
                    <option value="{{$company->id_company}}">{{$company->name}}</option>
                    @endforeach
                </select>
            @else
                <input id="company123" name="company123"
                class="company123 form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                value="{{$dataChildCompany->id_company}}" readonly hidden/>
            @endif
        </div>
        <div class="px-5 py-4">
            <div class="space-y-3">
                <div class="table-responsive">
                    <table id="office-inventory12" class="table table-striped table-bordered text-xs" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Purchase Date</th>
                                <th class="text-center">Serial Number Fixed Asset #</th>
                                <th class="text-center">Manual Code</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Sub Department</th>
                                <th class="text-center">Asset Code</th>
                                <th class="text-center">Asset Name</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">Site Warehouse</th>
                                <th class="text-center">Available Status</th>
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
        $('#office-inventory12').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: false,
                    stateServe: true,
                    "order": [[ 1, "desc" ]],
                    language: {
                        search: "Search Fixed Asset Code : "
                    },
                    ajax: {
                        url: "{{ route('fixedasset.getdata') }}",
                        data:function(d){                    
                            d.status123 = $("#status123").val()
                            d.status1234 = $("#status1234").val()
                            d.company123 = $("#company123").val()
                        }
                    },
                    columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "purchase_date",
                        name: "purchase_date"
                    },
                    {
                        data: "idfa",
                        name: "idfa"
                    },
                    {
                        data: "m_id_code",
                        name: "m_id_code"
                    },
                    {
                        data: "category",
                        name: "category"
                    },
                    {
                        data: "sub_category",
                        name: "sub_category"
                    },
                    {
                        data: "idassets",
                        name: "idassets"
                    },
                    {
                        data: "assetName",
                        name: "assetName"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "warehouse",
                        name: "warehouse"
                    },
                    {
                        data: "avail",
                        name: "avail"
                    },
                    {
                        data: "action2",
                        name: "action2"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1] },
                    ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
                });

                $('#status123').on('change', function (e) {
                    $('#office-inventory12').DataTable().ajax.reload();
                })

                $('#status1234').on('change', function (e) {
                    $('#office-inventory12').DataTable().ajax.reload();
                })
                $('#company123').on('change', function (e) {
                    $('#office-inventory12').DataTable().ajax.reload();
                })

                $('#office-inventory12').on("click", ".btn-delete",  function () {
                    const idassets = $(this).data('id');
                    $("input[name!='_token']").val("");
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Want to Delete this Fixed Asset!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                },
                                type: "DELETE",
                                url: `/ga/fixedasset/delete/${idassets}`,
                                success: function (response) {
                                    console.info("response: ", response)
                                    const { status, message } = response;
                                    if (status == 1) {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: `Fixed Assets has been Deleted.`,
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