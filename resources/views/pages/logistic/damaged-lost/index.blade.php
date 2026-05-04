<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Delivery Order - Damage/Lost 📦
                </h1>
            </div>
        </div>

        <label class="flex flex-row text-xs">
            <p class="flex flex-row text-slate-800 mb-3 text-sm" for="status">Damage/Lost Status :</p>
            <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                <option value="">All</option>
                <option value="302">Partially Damage/Lost - DAMAGE/LOST</option>
                <option value="303">All Lost Delivery - DAMAGE/LOST</option>
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
                    url: "{{ route('damage-lost.getdata') }}",
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
                    url: `/logistic/damage-lost/getdetail/${number}`,
                    success: function (response) {

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
                                <div class="table-responsive mt-4">
                                    <label class="block text-sm font-medium text-center mb-1" for="address">Damage/Lost Product Items</label>
                                    <table class="table table-striped table-bordered detail-delivery-orders"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Product Code</th>
                                                <th class="text-sm text-center">Product Name</th>
                                                <th class="text-sm text-center">Batch No</th>
                                                <th class="text-sm text-center">Qty</th>
                                                <th class="text-sm text-center">Status</th>
                                                <th class="text-sm text-center">Damaged Qty</th>
                                                <th class="text-sm text-center">Lost Qty</th>
                                                <th class="text-sm text-center">Action</th>
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
                                            <td class="text-center">${value.qty_damaged}</td>
                                            <td class="text-center">${value.qty_lost}</td>
                                            <td class="flex flex-row justify-center">
                                            
                <div x-data="{ modalOpen: false }">
                    <button type="button" class="btn bg-emerald-500 hover:bg-emerald-600 text-white" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                        View Image</button>
                    <!-- Modal backdrop -->
                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                        x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-out duration-100"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        aria-hidden="true" x-cloak></div>
                    <!-- Modal dialog -->
                    <div id="feedback-modal" class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6" role="dialog" aria-modal="true" x-show="modalOpen"
                        x-transition:enter="transition ease-in-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
                    <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full" @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                    <!-- Modal header -->
                    <div class="px-5 py-3 border-b border-slate-200">
                        <div class="flex justify-between items-center">
                            <div class="font-semibold text-slate-800">View Damage/Lost Image</div>
                                    <button type="button" class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                                <!-- Modal content -->
                                <div class="px-5 py-4">
                                    <div class="px-5">
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div></div>
                                        <div class="${value.damage1 && value.lost1 == 1 ? '' : 'hidden'}">
                                            <label class="text-sm font-medium mb-1">Product Damaged/Lost Image Not Uploaded Yet :</label>
                                        </div>
                                        <div></div>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div class="${value.damage1 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Damaged Image 1 :</label>
                                            <a href="/logistic/damage-lost/photo1/${value.do_number}/${value.batch_no}/${value.product_code}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${value.photo_damage1_name}" width="259" height="142" alt="Product Image" />
                                        </div>
                                        <div></div>
                                        <div class="${value.damage2 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Damaged Image 2 :</label>
                                            <a href="/logistic/damage-lost/photo2/${value.do_number}/${value.batch_no}/${value.product_code}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${value.photo_damage2_name}" width="259" height="142" alt="Product Image" />
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div class="${value.lost1 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Damaged Image 1 :</label>
                                            <a href="/logistic/damage-lost/photo3/${value.do_number}/${value.batch_no}/${value.product_code}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${value.photo_lost1_name}" width="259" height="142" alt="Product Image" />
                                        </div>
                                        <div></div>
                                        <div class="${value.lost2 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Damaged Image 2 :</label>
                                            <a href="/logistic/damage-lost/photo4/${value.do_number}/${value.batch_no}/${value.product_code}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${value.photo_lost2_name}" width="259" height="142" alt="Product Image" />
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="px-5 py-4 border-t border-slate-200">
                                    <div class="flex flex-wrap justify-end space-x-2">
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Cancel</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                                        </td>
                                        </tr>`;
                        }

                        $(".detail-delivery-orders").find('tbody').append(tableRow);
                    },
                });
            });
        });
    </script>
    @endsection
</x-app-layout>