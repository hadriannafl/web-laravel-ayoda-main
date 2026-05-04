        <x-app-layout>
            <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                <!-- Page header -->
                <div class="sm:flex sm:justify-between sm:items-center mb-5">
                    <!-- Left: Title -->
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                            Sales Invoice 🧾
                        </h1>
                    </div>
                </div>
        
                <label class="flex flex-row text-xs">
                    <p class="flex flex-row text-slate-800 mb-3 text-sm" for="status">Delivery Status :</p>
                    <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                        <option value="">All</option>
                        <option value="1">Shipping in Progress</option>
                        <option value="2">AWB / Shipping Information Uploaded</option>
                        <option value="301">Delivery Confirmed - Waiting Payment</option>
                        <option value="302">Partially Delivered - Please Follow Up</option>
                        <option value="303">Lost in Delivery - Please Follow Up</option>
                        <option value="4">Payment Information Received</option>
                        <option value="5">Finished Payment Verified</option>
                    </select>
                </label>
        
                <div class="table-responsive mt-3">
                    <table id="sales-invoice" class="table table-striped table-bordered text-xs" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Inv#</th>
                                <th class="text-center">Tracking Code</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Delivery By</th>
                                <th class="text-center">status</th>
                                <th class="text-center">Last Updated</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        
            @section('js-page')
            <script>
                $(document).ready(function () {
                    $('#sales-invoice').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: false,
                        stateServe: true,
                        language: {
                            search: "Search Invoice Number:"
                        },
                        ajax: {
                            url: "{{ route('invoice.getdata') }}",
                            data:function(d){
                             d.status = $("#status").val()
                            }
                        },
                        columns: [
                            {
                                data: "label",
                                name: "label"
                            },
                            {
                                data: "created_at",
                                name: "created_at"
                            },
                            {
                                data: "inv_number",
                                name: "inv_number"
                            },
                            {
                                data: "code",
                                name: "code"
                            },
                            {
                                data: "company",
                                name: "company"
                            },
                            {
                                data: "delivery_by",
                                name: "delivery_by"
                            },
                            {
                                data: "status_name",
                                name: "status_name"
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
                            { className: 'text-center', targets: [0, 1, 2, 3, 7, 8 ] },
                        ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]]
                    });
                    $(".status").on('change', function (e) {
                     e.preventDefault();
                    $('#sales-invoice').DataTable().ajax.reload();
                    })
                });
            </script>
            @endsection
        </x-app-layout>