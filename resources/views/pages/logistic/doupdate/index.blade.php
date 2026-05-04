<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Delivery Orders - Update 📦
                </h1>
            </div>
        </div>

        <label class="flex flex-row text-xs">
            <p class="flex flex-row text-slate-800 mb-3 text-sm" for="status">Delivery Order Status :</p>
            <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                <option value="">All</option>
                <option value="1">Shipping in Progress</option>
                <option value="2">All Delivered - CONFIRMED</option>
                <option value="301">Delivery Confirmed - Waiting Payment</option>
                <option value="302">Partially Damage/Lost - DAMAGE/LOST</option>
                <option value="303">All Lost Delivery - DAMAGE/LOST</option>
                <option value="4">Payment Information Received</option>
                <option value="5">Finished Payment Verified</option>
            </select>
        </label>

        <div class="table-responsive">
            <table id="delivery-orders" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Date</th>
                        <th class="text-center">DO#</th>
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
            $('#delivery-orders').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                language: {
                    search: "Search DO Number:"
                },
                ajax: {
                    url: "{{ route('do-update.getdata') }}",
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
                        data: "do_number",
                        name: "do_number"
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
                        data: "name_status",
                        name: "name_status"
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
                    { className: 'text-center', targets: [0, 1, 2, 3, 7 ] },
                ],  lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]]
                
            });
            $(".status").on('change', function (e) {
                e.preventDefault();
                $('#delivery-orders').DataTable().ajax.reload();
            })

            $('#delivery-orders').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const code = $(this).data("code");
                const number = $(this).data("number");
                const date = $(this).data("date");
                const by = $(this).data("by");
                const address = $(this).data("address");
                const status = $(this).data("stat");
                const photo1 = $(this).data("photo1");
                const photo2 = $(this).data("photo2");

                $.ajax({
                    type: "GET",
                    url: `/logistic/doupdate/getdetail/${code}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="code">Order Code</label>
                                        <input id="code" class="code form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${code}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="number">Delivery Order Number</label>
                                        <input id="number" class="number form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${number}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Status</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="date">Delivery Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${date}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="by">Delivery By</label>
                                        <input id="by" class="by form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${by}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="address">Delivery Address</label>
                                        <textarea rows="4" id="address" class="address form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${address}</textarea>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div class="${photo1 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">AWB DO :</label>
                                            <a href="/logistic/doupdate/photo1/${code}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                        </div>
                                        <div></div>
                                        <div class="${photo2 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Signed By :</label>
                                            <a href="/logistic/doupdate/photo2/${code}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                        </div>
                                    </div>
                                <div class="table-responsive mt-4">
                                    <label class="block text-sm font-medium text-center mb-1" for="address">Delivery Product Items</label>
                                    <table class="table table-striped table-bordered detail-delivery-orders"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Product Code</th>
                                                <th class="text-sm text-center">Product Name</th>
                                                <th class="text-sm text-center">Batch No</th>
                                                <th class="text-sm text-center">Qty</th>
                                                <th class="text-sm text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `); 
                        let tableRow = '';
                        for (const value of response) {
                            tableRow += `<tr>
                                            <td class="text-center">${value.product_code}</td>
                                            <td>${value.product_name}</td>
                                            <td class="text-center">${value.batch_no}</td>
                                            <td class="text-center">${value.qty}</td>
                                            <td class="text-center">${value.status_order}</td>
                                        </tr>`;
                        }

                        $(".detail-delivery-orders").find('tbody').append(tableRow);
                    },
                });
                // <form method="post" class="form_do_update" enctype="multipart/form-data" action="/logistic/doupdate/${id}">
                //                     <input type="hidden" name="_token" value="${csrf_token}" />
                //                     <div class="grid md:grid-cols-3 gap-3 mt-3">
                //                         <div>
                //                             <label class="block text-sm font-medium mb-1" for="file">AWB DO Upload:</label>
                //                             <input name="photo1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/*" onchange="loadFileMultiple(event, 'output1-${id}')" required />
                //                             <img id="output1-${id}" style="max-width: 300px; max-height: 150px"/>
                //                         </div>
                //                         <div></div>
                //                         <div>
                //                             <label class="block text-sm font-medium mb-1" for="file">Signed DO Upload:</label>
                //                             <input name="photo2" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/*" onchange="loadFileMultiple(event, 'output2-${id}')" required />
                //                             <img id="output2-${id}" style="max-width: 300px; max-height: 150px"/>
                //                         </div>
                //                     </div>
                //                     <div class="grid md:grid-cols-3 gap-3 mt-3">
                //                             <input type="submit" value="Delivery Confirmed" name="status" class="btn-sm bg-green-500 hover:bg-green-600 text-white" />
                //                             <input type="submit" value="Partially Delivered" name="status" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" />
                //                             <input type="submit" value="Lost in Delivery" name="status" class="btn-sm bg-red-400 border-slate-200 hover:bg-red-500 text-white" />
                //                     </div>
                //                 </form>
            });


            // $("#delivery-orders").on("click", ".btn-update-do", function () {
            //     const id = $(this).data('id');
            //     const status = $(this).data('status');

            //     $(".form_do_update").attr("action", `/logistic/doupdate/${status}/${id}`);
                
            //     setTimeout(() => {
            //         $(".form_do_update").submit();
            //     }, 1000);
            // });
        });
    </script>
    @endsection
</x-app-layout>