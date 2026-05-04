<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit Outbound Inventory 📝</h1>
        </div>
        <form action="{{ route('outbound-inventory.update', ['outboundId' => $dataOutbound->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Outbound # / Date Outbound / Company</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->id_outbound}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataOutbound->date))}}" readonly>
                        </div>
                        <div>
                            <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('F Y', strtotime($dataOutbound->companyName))}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Warehouse Name / Address / City</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataOutbound->w_name}}" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <textarea id="address" name="address" class="address form-input w-full px-2 py-1 read-only:bg-slate-200" rows="3" readonly>{{$dataOutbound->w_address}}</textarea>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->w_city}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Warehouse Province / Country / POS Code</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataOutbound->w_province}}" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->w_country}}" readonly>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->w_zipcode}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">User Request / Department / Position</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->first_name}} {{$dataOutbound->last_name}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->department}}" readonly>
                        </div>
                        <div>
                            <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->position}}" readonly/>
                            <input id="company" name="company"
                            class="company form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" 
                            value="{{$dataOutbound->id_company}}" readonly hidden/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Reff # / Courier Name / Vehicle #</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->reff}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->courier_name}}" readonly>
                        </div>
                        <div>
                            <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->vehicle}}" readonly/>
                            <input id="company" name="company"
                            class="company form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" 
                            value="{{$dataOutbound->id_company}}" readonly hidden/>
                        </div>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="text-sm font-medium mb-1 mt-1" for="task_id">Add Outbound Inventory
                    </label>
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn btn-rab bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                            <svg class="w-4 h-4 fill-current  text-slate-200" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
                            <span></span>
                        </button>
                        <!-- Modal backdrop -->
                        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                            x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-out duration-100"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            aria-hidden="true" x-cloak></div>
                        <!-- Modal dialog -->
                        <div id="feedback-modal"
                            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                            role="dialog" aria-modal="true" x-show="modalOpen"
                            x-transition:enter="transition ease-in-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in-out duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-4" x-cloak>

                            <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
                            @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add Inventory Outbound</div>
                                        <button type="button" class="text-slate-400 hover:text-slate-500"
                                            @click="modalOpen = false">
                                            <div class="sr-only">Close</div>
                                            <svg class="w-4 h-4 fill-current">
                                                <path
                                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <!-- Modal content -->
                                <div class="modal-content text-xs px-5 py-4">
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="nama_product">Inventory Name<span class="text-rose-500">*</span></label>
                                        <input id="nama_product" name="nama_product"
                                        class="nama_product form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required/>
                                        <div x-data="{ modalOpen: false }">
                                            <button type="button"
                                                class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click.prevent="modalOpen = true" id="rabSelection"
                                                aria-controls="feedback-modal">
                                                <svg class="w-4 h-4" viewBox="0 0 16 16"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path class="fill-current text-slate-200"
                                                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                                    <path class="fill-current text-slate-200"
                                                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                                                </svg>
                                                <span></span>
                                            </button>
                                            <!-- Modal backdrop -->
                                            <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                x-show="modalOpen"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-out duration-100"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" aria-hidden="true"
                                                x-cloak>
                                            </div>
                                            <!-- Modal dialog -->
                                            <div id="feedback-modal"
                                                class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                                role="dialog" aria-modal="true" x-show="modalOpen"
                                                x-transition:enter="transition ease-in-out duration-200"
                                                x-transition:enter-start="opacity-0 translate-y-4"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in-out duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-4" x-cloak>

                                                <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
                                                    @click.outside="modalOpen = false"
                                                    @keydown.escape.window="modalOpen = false">
                                                    <!-- Modal header -->
                                                    <div class="px-5 py-3 border-b border-slate-200">
                                                        <div class="flex justify-between items-center">
                                                            <div class="font-semibold text-slate-800 text-sm">Select Inventory</div>
                                                            <button type="button"
                                                                class="text-slate-400 hover:text-slate-500"
                                                                @click="modalOpen = false">
                                                                <div class="sr-only">Close</div>
                                                                <svg class="w-4 h-4 fill-current">
                                                                    <path
                                                                        d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- Modal content -->
                                                    <div class="modal-content text-xs px-5 py-4">
                                                        <div class="flex flex-row text-xs mb-3">
                                                            <label class="flex flex-row text-xs">
                                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="department">Department :</p>
                                                            <select id="department" name="department" class="department flex flex-row ml-3 mb-3 text-xs">
                                                                <option selected value="">All</option>
                                                                @foreach ( $department as $depts )
                                                                    <option value="{{$depts->id}}">{{$depts->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table id="assetInv"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Department</th>
                                                                        <th class="text-center">Sub Department</th>
                                                                        <th class="text-center">Inventory Name</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>

                                                        <div class="space-y-3">
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="px-5 py-4 border-t border-slate-200">
                                                        <div class="flex flex-wrap justify-end space-x-2">
                                                            <button type="button"
                                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                                @click="modalOpen = false">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="rabItemId" name="rabItemId"
                                            class="rabItemId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" hidden readonly required/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="quantitys">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="qty">Qty<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="qty" name="qty"
                                            class="qty numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="units">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="unit">Unit<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="unit" name="unit"
                                            class="unit form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" maxlength="20" readonly/>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                            <button type="button"
                                                class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click="modalOpen = false" id="addProduct">Add Outbound Item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr class="bg-slate-400">
                                <th class="text-sm text-center">Inventory Code</th>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Qty</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    </label>
                    <input id="grandtotal" name="grandtotal" class="block grandtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right mr-20" type="text" 
                    value="{{number_format($dataOutbound->grandTotal, 0, '.', '.')}}" readonly required/>
                    <label class="md:w-1/12 text-sm font-medium text-white"></label>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" 
                    value="{{$dataOutbound->grandTotal}}" readonly required/>
                </div>
                    @if ($dataOutbound->approvalstat == "Draft")
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Save Outbound Update</span>
                    </button> </center>
                    @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#assetInv').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ], [ 1, "asc" ], [ 2, "asc" ]],
                ajax: {
                    url: "{{ route('purchase.invasset') }}",
                    data:function(d){
                        d.department = $("#department").val()
                    }
                },
                columns: [
                    {
                        data: "category",
                        name: "category"
                    },
                    {
                        data: "sub_category",
                        name: "sub_category"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                    ],
                    columnDefs: [
                        { className: 'text-center', targets: [3] }
                    ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $('#department').on('change', function (e) {
                $('#assetInv').DataTable().ajax.reload();
            })

            $('#assetInv').on("click", ".btn-select", function () {
                const idAsset = $(this).data("id");
                const nameAsset = $(this).data("nama");
                const category = $(this).data("category");
                const sub_category = $(this).data("sub_category");
                const unitssss = $(this).data("unit");

                $("#rabItemId").val(idAsset);
                $("#nama_product").val(nameAsset);
                $("#category").val(category);
                $("#detail").val(sub_category);
                $("#unit").val(unitssss);
            });
        });

        let grandTotal = parseFloat($('#grandtotal1').val()) || 0;

        function calculateGrandTotal() {
            grandTotal = 0;
            $('.tableProductAddBody tbody tr').each(function() {
                const totalas = parseFloat($(this).find('input[name^="qty_"]').val()) || 0;
                grandTotal += totalas;
                console.log(grandTotal);
            });
            updateGrandTotal();
        }

        $("#addProduct").click(function () {
            let productIdx = $('#tableProductAddBody tr').length-1;
            var id = $('#rabItemId').val();
            var name = $('#nama_product').val();
            var unit = $('#unit').val();
            var qty = $('#qty').val();
            var qty2 = $('#qty').val().replace(/\./g, '').replace(/\,/g, '.');
            var total1 = parseFloat(qty2);

            var idExists = false;

            // console.log('Checking for id:', id);

            $('#tableProductAddBody tr').each(function () {
                var existingIdElement = $(this).find('[name^="ids"]');
                if (existingIdElement.length > 0) {
                    var existingId = existingIdElement.val();
                    // console.log('Existing ID:', existingId);
                    
                    if (id == existingId) {
                        idExists = true;
                        return false; // Exit the loop if the id is found
                    }

                }
            });

            // console.log('idExists:', idExists);
            if (idExists || $('#tableProductAddBody').find(`[name*="[ids2]"][value="${id}"]`).length > 0) {
                alert('Same Inventory Asset cannot be added again.');
                return false;
            }

            // Check if the product with the same id already exists for Inventory type
            if ($('#tableProductAddBody').find(`[name*="[ids]"][value="${id}"]`).length > 0) {
                alert('Same Inventory Asset cannot be added again.');
                return false;
            }

            if (name === '' || qty2 === '' || !unit || !name || !qty2) {
                alert('Data Inventory Outbound Must Fill.');
                return false;
            }

                    var tr = `<tr id="row-${productIdx}">
                            <td class="text-left">${id}<input name="rows[${productIdx}][ids]" value="${id}" hidden/></td>
                            <td class="text-left">${name}</td>
                            <td class="text-right">${divider(qty)}<input name="rows[${productIdx}][qtys]" value="${qty2}" hidden/></td>
                            <td class="text-center">${unit}<textarea name="rows[${productIdx}][units]" hidden>${unit}</textarea></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${productIdx}, ${total1}, ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button></td>
                        </tr>`;  

                $("#tableProductAddBody").append(tr);

                calculateGrandTotal();
                $('#rabItemId').val('');
                $('#nama_product').val('');
                $('#unit').val('');
                $('#qty').val('');
                $('#grandtotal').val(`${divider(grandTotal + total1)}`);
                $('#grandtotal1').val(grandTotal + total1);


                var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
                grandTotalRow.detach();
                $("#tableProductAddBody").append(grandTotalRow);
                $('#grandTotal1_text').text(`${divider(grandTotal + total1)}`);
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataOutboundItem?>;
        let tableRow = '';
        
        for (const value of dataProducts) {
            var iden = dataProducts.indexOf(value);

            const prods = <?=$dataOutboundItem?>;
            var modal_content = '';

            $('.tableProductAddBody').on('input', '.rab-input', function() {
                updateTotals(this);
            });

            function updateTotals(ths) {
                const exp = $(ths).attr('id').split('_');
                let iden = '';
                if(exp.length > 1){
                    iden = exp[1];
                }
                const qty3 = parseFloat($(`#qty2_${iden}`).val()) || 0;
                const total3 = qty3;

                $(`#itemTotal_${iden}`).val(divider1(total3));
            }

            $.each(prods, function (i,item1) {
                if(value.idrec == item1.idrec){
                        modal_content += `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3" id="qty2">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="qty2">qty
                                                </label>
                                                <input id="qty2_${iden}" name="qty2" class="rab-input numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" data-iden="${iden}" value="${newDivider2(value.qty)}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="itemTotal">Total
                                                </label>
                                                <input id="itemTotal_${iden}" name="itemTotal"
                                                class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                type="text" onchange="totally1(this)" value="${newDivider1(value.qty)}" readonly/>
                                            </div>

                                            <div class="space-y-3">
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="px-5 py-4 border-t border-slate-200">
                                                <div class="flex flex-wrap justify-end space-x-2">
                                                    <button type="button"
                                                        class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                        @click="modalOpen = false">Close</button>
                                                    <button type="button"
                                                        class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                        @click="modalOpen = false" onclick="updateDataProduct('${iden}')">Update</button>
                                                </div>
                                            </div>
                                        </div>`
                }
            })

            tableRow += `<tr id=row-${iden}>
                            <td><input type="text" name="iden[]" value="${iden}" hidden/>${value.idassets}<input type="text" name="ids_${iden}" id="ids_${iden}" value="${newDivider2(value.idassets)}" hidden/><input type="text" name="created_at_${iden}" id="created_at_${iden}" value="${newDivider2(value.created_at)}" hidden/><input type="text" name="created_by_${iden}" id="created_by_${iden}" value="${newDivider2(value.created_by)}" hidden/></td>
                            <td>${value.name}</td>
                            <td class="text-right"><input type="text" name="qty_${iden}" id="qty_${iden}" value="${newDivider2(value.qty)}" hidden/><span id="qty-text_${iden}">${newDivider1(value.qty)}</span></td>
                            <td class="text-center">${value.unit}</td>
                            <td class="flex justify-center">
                <button type="button" onclick="deleteDataProduct('${iden}', ${value.total}, ${value.idrec})" class="btn btn-delete border-slate-200 hover:border-slate-300" > <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/></svg></button>                
                    <div x-data="{ modalOpen: false }">
                                <button class="ml-2 btn bg-emerald-500 hover:bg-emerald-600 text-white" type="button"
                                @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>pen</title><g stroke-width="1" stroke-linecap="round" fill="none" stroke="#ffff" stroke-miterlimit="10" class="nc-icon-wrapper" stroke-linejoin="round"><line x1="10" y1="3" x2="13" y2="6" data-cap="butt" stroke="#ffff"></line> <polygon points="12,1 15,4 5,14 1,15 2,11 " data-cap="butt"></polygon> </g></svg>
                                    <span></span>
                                </button>
                                <!-- Modal backdrop -->
                                <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                    x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-out duration-100"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    aria-hidden="true" x-cloak></div>
                                <!-- Modal dialog -->
                                <div id="feedback-modal"
                                    class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                    role="dialog" aria-modal="true" x-show="modalOpen"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in-out duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-4" x-cloak>

                                    <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
                                        @click.outside="modalOpen = false"
                                        @keydown.escape.window="modalOpen = false">
                                        <!-- Modal header -->
                                        <div class="px-5 py-3 border-b border-slate-200">
                                            <div class="flex justify-between items-center">
                                                <div class="font-semibold text-slate-800">Edit Qty Outbound Inventory</div>
                                                <button type="button" class="text-slate-400 hover:text-slate-500"
                                                    @click="modalOpen = false">
                                                    <div class="sr-only">Close</div>
                                                    <svg class="w-4 h-4 fill-current">
                                                        <path
                                                            d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Modal content -->
                                        `+modal_content+`
                                    </div>
                                </div>
                    </div>
                </td>
            </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);
        var grandTotalRow = `<tr class="grandTotalRow bg-slate-400">
            <td class="text-center font-bold text-lg" colspan="2">Total</td>
            <td class="text-right font-bold text-lg"><span id="grandTotal1_text">${divider(grandTotal)}</span></td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);

                function deleteDataProduct(positionTableRow, total, dataFromDatabase,  nullParam) {
                    const positionTableRowVariable = positionTableRow;
                    const dataFromDatabaseVariable = dataFromDatabase;
                    const csrf_token = $('meta[name="csrf-token"]').attr('content');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Want to Delete Outbound Inventory!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (dataFromDatabaseVariable !== null) {
                                // Tandai baris yang dihapus dengan warna latar merah
                                $(`#row-${positionTableRowVariable}`).addClass('bg-red-100');
                                // Update status menjadi "Non Active"
                                // $(`#status_${positionTableRowVariable}`).val('Non Active');
                                // Simpan elemen baris yang akan dihapus
                                const $rowToDelete = $(`#tableProductAddBody tr#row-${positionTableRowVariable}`);
                                
                                // Hapus baris dari tabel
                                $rowToDelete.remove();
                                
                                // Panggil fungsi untuk menghapus data (misalnya, dari database)
                                handleDeleteRow(positionTableRowVariable, total);
                                calculateGrandTotal(); 
                            } else {
                                // Hapus baris jika data baru ditambahkan
                                $(`#tableProductAddBody tr#row-${positionTableRowVariable}`).remove();
                                
                                // Panggil fungsi untuk menghapus data (misalnya, dari database)
                                handleDeleteRow(positionTableRowVariable, total);
                                calculateGrandTotal(); 
                            }
                            Swal.fire({
                                icon : 'success',
                                title: 'Deleted!',
                                text: `Outbound Inventory has been Deleted.`,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }

                function handleDeleteRow(positionTableRow, total) {
                    const parsedTotal = parseFloat(total) || 0;
                    grandTotal = Math.max(grandTotal - parsedTotal, 0);
                    calculateGrandTotal();
                    // Update the grandTotal fields
                    $('#grandtotal').val(newDivider1(grandTotal));
                    $('#grandtotal1').val(grandTotal);
                    updateGrandTotal();
                }

        function updateDataProduct(iden) {
              // Get the old quantity value
            var oldQty = parseFloat($('#qty_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;

            // Get the new quantity value
            var newQty = parseFloat($('#qty2_' + iden).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;

            // Update grandTotal by subtracting the old value and adding the new value
            grandTotal -= oldQty;
            grandTotal += newQty;

            // Memperbarui nilai lain yang perlu diperbarui
            $('#qty_' + iden).val(newQty);
            $('#qty-text_'+iden).text(newDivider1(newQty));
            $('#grandtotal').val(newDivider1(grandTotal));
            $('#grandtotal1').val(grandTotal);

            // Memanggil fungsi untuk menghitung ulang grandTotal dan memperbarui tampilan
            calculateGrandTotal();
            updateGrandTotal();

            console.log(iden, newQty, grandTotal);
        }

        function updateGrandTotal() {
            $('#grandTotal1_text').text(`${divider(grandTotal)}`);
            $('#grandTotal1_text').val(`${grandTotal}`);
            $('#grandtotal').val(newDivider1(grandTotal));
            $('#grandtotal1').val(grandTotal);
        }
    </script>
    @endsection
</x-app-layout>