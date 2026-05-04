<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Update Price Purchase Request 📝</h1>
        </div>
        <form action="{{ route('purchase-list.update1', ['idPR' => $dataPR->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Purchase Request # / PR Date / PR Title</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->idreqform}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataPR->pr_date))}}" readonly>
                        </div>
                        <div>
                            <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->pr_title}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Applicant / Company / Request Level</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->applicant}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->companyName}}" readonly>
                        </div>
                        <div>
                            <input id="benef_bank" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPR->reqlevel}}" type="text" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Delivery Date / RAB / Currency</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataPR->delivery_date))}}" readonly>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->id_rab}}-{{$dataPR->name_rab}}-{{date('F Y', strtotime($dataPR->rab_date))}}" readonly/>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPR->currency}}" type="text" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Payment Source / PIC / Phone Number</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPR->payment_by}}" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPR->pic}}" type="text" readonly>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPR->phone}}" type="text" readonly/>
                        </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1" for="address">Address</label>
                    <textarea id="address" name="address" class="address form-input w-full px-2 py-1 read-only:bg-slate-200"
                        rows="3" readonly>{{$dataPR->delivery_address}}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="notes form-input w-full px-2 py-1 read-only:bg-slate-200"
                        rows="3" readonly>{{$dataPR->note}}</textarea>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">List Purchase Asset Request
                    </label>
                    
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Asset Code</th>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">Quantity</th>
                                <th class="text-sm text-center">Currency</th>
                                <th class="text-sm text-center">@Price</th>
                                <th class="text-sm text-center">Total</th>
                                <th class="text-sm text-center">Remakrs</th>
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row md:flex-row" hidden>
                    <table class="tableProductAddBody23 table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Asset Code</th>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Quantity</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">@Price</th>
                                <th class="text-sm text-center">Currency</th>
                                <th class="text-sm text-center">Total</th>
                                <th class="text-sm text-center">Remakrs</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody23" id="tableProductAddBody23">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="subtotal">Subtotal
                    </label>
                    <input id="subtotal" name="subtotal" type="text" class="subtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-36" value="{{number_format($dataPR->subtotal, 0, '.', '.')}}" readonly/>
                    <input id="subtotal1" name="subtotal1" type="text" class="subtotal1 form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-36" value="{{number_format($dataPR->subtotal, 0, '', '')}}" readonly hidden/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="discount">Discount (IDR)
                    </label>
                    <input id="discount" name="discount" class="discount form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 ml-36" type="text" onchange="calculateDisc()" value="{{number_format($dataPR->discount, 0, '', '')}}"/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="total">Total
                    </label>
                    <input id="total" name="total" type="text" class="total form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-36" value="{{number_format($dataPR->total, 0, '.', '.')}}" readonly/>
                    <input id="total1" name="total1" type="text" class="total1 form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-36" value="{{number_format($dataPR->total, 0, '', '')}}" readonly hidden/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="ppn">PPN (IDR)
                    </label>
                    <input id="ppn" name="ppn" class="ppn form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 ml-36" type="text" onchange="calculateDisc()" value="{{number_format($dataPR->ppn, 0, '', '')}}"/>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/2 text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    <label class="text-sm font-medium mb-1 ml-16">&nbsp;&nbsp;</label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input w-full md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right mr-60" type="text" 
                    value="{{number_format($dataPR->gtotal, 0, '.', '.')}}" required readonly/>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-36" type="text" 
                    value="{{number_format($dataPR->gtotal, 0, '', '')}}" required readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="deliveryCharge">Delivery Charge (IDR)
                    </label>
                    <input id="deliveryCharge" name="deliveryCharge" class="deliveryCharge form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 ml-36" type="text" value="{{number_format($dataPR->delivery_charge, 0, '', '')}}"/>
                </div>
                @if ($dataPR->approvalstat == 'Draft' || $dataPR->approvalstat == 'Price Updated')
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Save Updated Price</span>
                    </button> </center>
                @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#vendor-table').DataTable({
                responsive: true,
                            processing: true,
                            serverSide: false,
                            stateServe: true,
                            "order": [[ 2, "asc" ]],
                            language: {
                                search: "Search Vendor:"
                            },
                            ajax: {
                                url: "{{ route('vendor.select') }}"
                            },
                            columns: [
                                {
                                    data: "initials",
                                    name: "initials"
                                },
                                {
                                    data: "company_type",
                                    name: "company_type"
                                },
                                {
                                    data: "name",
                                    name: "name"
                                },
                                {
                                    data: "address",
                                    name: "address"
                                },
                                {
                                    data: "status",
                                    name: "status"
                                },
                                {
                                    data: "action",
                                    name: "action"
                                },
                            ],
                            columnDefs: [
                                { className: 'text-center', targets: [0, 1, 4, 5] },
                            ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#vendor-table').on("click", ".btn-select", function () {
                const id = $(this).data("id_vendor");
                const name = $(this).data("name_vendor");
                const type = $(this).data("type");
                var nama = type + ' ' + name
                            
                $("#vendor").val(nama);
                $("#vendor1").val(id);
            });
        });

        function calculateDisc() {
            let finalAmount = grandTotal; // Pastikan variable 'subtotal' sudah didefinisikan dan memiliki nilai sebelumnya
            if ($('#discount').val()) {
                finalAmount = finalAmount - parseFloat($('#discount').val());
                $('#total').val(`${divider(finalAmount)}`);
                $('#total1').val(finalAmount);
                $('#grandtotal').val(`${divider(finalAmount)}`);
                $('#grandtotal1').val(finalAmount);
            }
            if ($('#ppn').val()) {
                finalAmount = finalAmount + parseFloat($('#ppn').val());
                $('#grandtotal').val(`${divider(finalAmount)}`);
                $('#grandtotal1').val(finalAmount);
            }
        }

        let grandTotal = parseFloat($('#grandtotal1').val()) || 0;
        function calculateGrandTotal() {
            grandTotal = 0;
            $('.tableProductAddBody tbody tr').each(function() {
                const totalas = parseFloat($(this).find('input[name^="total_"]').val()) || 0;
                grandTotal += totalas;
            });
            updateGrandTotal();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$PRDetail?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {
            // var iden = makeid(3);
            var iden = dataProducts.indexOf(value);

            $('.tableProductAddBody').on('input', '.pr-input', function() {
                updateTotals(this);
            });

            function updateTotals(ths) {
                const exp = $(ths).attr('id').split('_');
                let iden = '';
                if(exp.length > 1){
                    iden = exp[1];
                }
                const qty2 = parseFloat($(`#qty2_${iden}`).val()) || 0;
                const days2 = parseFloat($(`#days2_${iden}`).val()) || 1;
                const price2 = parseFloat($(`#product-price2_${iden}`).val()) || 0;
                const total2 = price2 * qty2 * days2;

                $(`#itemTotal_${iden}`).val(divider1(total2));
            }

            const prods = <?=$PRDetail?>;
            var modal_content = '';
            $.each(prods, function (i,item1) {
                if(value.idassets == item1.idassets){
                    modal_content += `<div class="modal-content text-xs px-5 py-4">
                        <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="qty2">Quantity
                                                </label>
                                                <input id="qty2_${iden}" name="qty2" class="pr-input numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" data-iden="${iden}" value="${newDivider2(value.qty)}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="product_price2">@Price
                                                </label>
                                                <input id="product-price2_${iden}" name="product-price2" class="pr-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="number" data-iden="${iden}" value="${newDivider2(value.price)}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="itemTotal">Total
                                                </label>
                                                <input id="itemTotal_${iden}" name="itemTotal"
                                                class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                type="text" value="${newDivider1(value.total)}" readonly/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="remarks">Remarks
                                                </label>
                                                <input id="remarks2_${iden}" name="remarks"
                                                    class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${value.remarks === 'null' ? '' : (value.remarks || '')}" />
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
                // console.log(item)
            })

            tableRow += `<tr id=row-${iden}>
                            <td class="text-center"><input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="ids_${iden}" value="${value.idassets}" hidden/><input type="text" name="idPR_${iden}" value="${value.idreqform}" hidden/>${value.idassets}</td>
                            <td>${value.name_rab_detail}<input type="text" name="idrec_${iden}" value="${value.id}" hidden/><input type="text" name="unit_${iden}" value="${value.unit}" hidden/><input type="text" name="createdat_${iden}" value="${value.created_at}" hidden/></td>
                            <td class="text-center">${value.unit}<textarea name="status_${iden}" id="status_${iden}" hidden>${value.status}</textarea></td>
                            <td class="text-right"><input type="text" name="qty_${iden}" id="qty_${iden}" value="${newDivider2(value.qty)}" hidden/><span id="qty_text_${iden}">${newDivider1(value.qty)}</span></td>
                            <td class="text-center">{{$dataPR->currency}}<input type="text" name="id_rab_${iden}" value="${value.id_rab}" hidden/></td>
                            <td class="text-right"><input type="text" name="price_${iden}" id="price_${iden}" value="${newDivider2(value.price)}" hidden/><span id="price_text_${iden}">${newDivider1(value.price)}</span></td>
                            <td class="text-right"><input type="text" name="total_${iden}" id="total_${iden}" value="${newDivider2(value.total)}" hidden/><span id="total_text_${iden}">${newDivider1(value.total)}</span></td>
                            <td><textarea name="remarks1_${iden}" id="remarks1_${iden}" hidden>${value.remarks}</textarea><span id="remarks1_text_${iden}">${value.remarks === 'null' ? '' : (value.remarks || '')}</span></td>
                            <td class="flex justify-center">             
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
                                                <div class="font-semibold text-slate-800">Edit Price Purchase Request</div>
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
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="6">Grand Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">{{number_format($dataPR->gtotal, 0, '.', '.')}}</span></td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);

        function updateDataProduct(iden) {
            var remarks = $('#remarks2_'+iden).val();
            $('#remarks1_'+iden).val(remarks);
            $('#remarks1_text_'+iden).text(remarks);
            
            var qty = parseFloat($('#qty2_' + iden).val()) || 0;
            var price = parseFloat($('#product-price2_' + iden).val()) || 0;
            var total = parseFloat(price*qty) || 0;
            // var moq = parseFloat($('#minimum_quantity_order2_' + iden).val()) || 0;
            $('#total_' + iden).val(total);

            // var previousQty = parseFloat($('#qty_' + iden).val()) || 0;
            // var previousPrice = parseFloat($('#price_' + iden).val()) || 0;
            // var previousTotal = parseFloat($('#total_' + iden).val()) || 0;

            // var totalDifference = total - previousTotal;

            // Update grandTotal with the price difference
            // grandTotal += totalDifference;
            calculateGrandTotal();
            updateGrandTotal();

            $('#subtotal').val(newDivider1(grandTotal));
            $('#subtotal1').val(grandTotal);
            $('#grandtotal').val(newDivider1(grandTotal));
            $('#grandtotal1').val(grandTotal);
            $('#qty_' + iden).val(qty);
            $('#qty_text_' + iden).text(newDivider1(qty));
            $('#price_' + iden).val(price);
            $('#price_text_' + iden).text(newDivider1(price));
            $('#total_' + iden).val(total);
            $('#total_text_' + iden).text(newDivider1(total));

            console.log(iden, qty, price, total, grandTotal, remarks);
        }
        function updateGrandTotal() {
            $('#grandTotal_text').text(`${divider(grandTotal)}`);
            $('#grandTotal_text').val(`${divider(grandTotal)}`);
        }

        function makeid(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
        const dataProducts123 = <?=$PRDetail1?>;
        let tableRow123 = '';
        
        for (const value123 of dataProducts123) {
            // var iden = makeid(3);
            var idenas = dataProducts123.indexOf(value123);

            tableRow123 += `<tr id=row-${idenas}>
                            <td class="text-center"><input type="text" name="idenas[]" value="${idenas}" hidden/><input type="text" name="ids123_${idenas}" value="${value123.idassets}" hidden/> <input type="text" name="idPR123_${idenas}" value="${value123.idreqform}" hidden/>${value123.idassets}</td>
                            <td>${value123.name_rab_detail}<input type="text" name="idrec123_${idenas}" value="${value123.id}" hidden/><input type="text" name="unit123_${idenas}" value="${value123.unit}" hidden/><input type="text" name="createdat123_${idenas}" value="${value123.created_at}" hidden/></td>
                            <td class="text-right"><input type="text" name="qty123_${idenas}" id="qty_${idenas}" value="${newDivider2(value123.qty)}" hidden/><span id="qty_text_${idenas}">${newDivider1(value123.qty)}</span></td>
                            <td class="text-center">${value123.unit}<textarea name="status123_${idenas}" id="status_${idenas}" hidden>${value123.status}</textarea><input type="text" id="newbalances_${idenas}" name="newbalances123_${idenas}="${newDivider2(value123.balance_rab)}" hidden/></td>
                            <td class="text-right"><input type="text" name="price123_${idenas}" id="price_${idenas}" value="${newDivider2(value123.price)}" hidden/><span id="price_text_${idenas}">${newDivider1(value123.price)}</span></td>
                            <td class="text-center">{{$dataPR->currency}}<input type="text" name="id_rab123_${idenas}" value="${value123.id_rab}" hidden/><input type="text" id="balanciaga123_${idenas}" name="balanciaga123_${idenas}" value="${newDivider2(value123.balance_rab)}" hidden/></td>
                            <td class="text-right"><input type="text" name="total123_${idenas}" id="total_${idenas}" value="${newDivider2(value123.total)}" hidden/><input type="text" id="totalia_${idenas}" name="totalia123_${idenas}" value="${newDivider2(value123.total)}" hidden/><span id="total_text_${idenas}">${newDivider1(value123.total)}</span></td>
                            <td><textarea name="remarks1123_${idenas}" id="remarks1_${idenas}" hidden>${value123.remarks}</textarea><span id="remarks1_text_${idenas}">${value123.remarks === 'null' ? '' : (value123.remarks || '')}</span></td>
                                        </tr>`;
        }
        $(".tableProductAddBody23").find('tbody').append(tableRow123);
    </script>
    @endsection
</x-app-layout>