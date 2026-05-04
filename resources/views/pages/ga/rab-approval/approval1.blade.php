<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">RAB Request Approval 1 📝</h1>
        </div>
        @if ($dataRab->rab_file != null)
        <div class="px-5 py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <a href="{{ route('rab-list.viewfile', ['rabId' => $dataRab->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment RAB</a>
            </div>
        </div>
        @endif
        <form id="approvalForm" action="{{ route('rab-approvalga.updatestatus', ['rabId' => $dataRab->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">RAB # / Form Date / Period</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->id_rab}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataRab->form_date))}}" readonly>
                        </div>
                        <div>
                            <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('F Y', strtotime($dataRab->date_rab))}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">RAB Title / RAB Type / Company</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->name_rab}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->rab_type}}" readonly>
                        </div>
                        <div>
                            <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->name}}" readonly/>
                            <input id="company" name="company"
                            class="company form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" 
                            value="{{$dataRab->id_company}}" readonly hidden/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3" id="benef" {{$dataRab->rab_type == 'Advance Payment To Site' ? '':'hidden'}}>
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Bank / Account / Name<span
                        class="text-rose-500">*</span></label>
                        <div>
                            <input style="width: 20.8rem; margin-right: 20px;" id="bank" name="bank" value="{{$dataRab->beneficiary_bank}}" class="bank form-input w-full px-2 py-1 read-only:bg-slate-200" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="number" name="number" class="number form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->beneficiary_acc}}" type="text" readonly/>
                        </div>
                        <div>
                            <input id="account" name="account" style="width: 21.2rem;" class="account form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->beneficiary_name}}" type="text" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Department / Created By / Approval Status</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->dept}}" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->username}}" readonly>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->approvalstat}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="text-sm font-medium mb-1" for="task_id">RAB Item
                    </label>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Type</th>
                                <th class="text-sm text-center">Department</th>
                                <th class="text-sm text-center">Sub Department</th>
                                <th class="text-sm text-center">Inventory Asset</th>
                                <th class="text-sm text-center">Qty</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">Price</th>
                                <th class="text-sm text-center">Total</th>
                                <th class="text-sm text-center">Remarks</th>
                                {{-- <th class="text-sm text-center">Action</th> --}}
                                {{-- <th hidden class="text-sm text-center">Balance</th> --}}
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/3 px-2 py-1 read-only:bg-slate-200 text-right ml-6" type="text" 
                    value="{{number_format($dataRab->grandTotal, 0)}}" required readonly/>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" 
                    value="{{$dataRab->grandTotal}}" readonly required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks1">Remarks Approval 1</label>
                    <textarea id="remarks1" name="remarks1"
                        class="remarks1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
                </div>
                <center>
                        <input type="submit" value="Approve" name="status" class="w-80 text-lg bg-green-500 hover:bg-green-600 text-white mt-3" />
                        <input type="submit" value="Denied" name="status" class="w-80 text-lg bg-red-400 border-slate-200 hover:bg-red-500 text-white mt-3" />
                        <input type="submit" value="Return to Draft" name="status" class="w-80 text-lg bg-amber-500 border-slate-200 hover:bg-amber-600 text-white mt-3" />
                </center>
            </form>
    </div>

    @section('js-page')
    <script>
        $('#approval_to').select2();
        let grandTotal = parseFloat($('#grandtotal1').val()) || 0;

        function rabCalcTypes(iden) {
            // Your existing code for rabCalcTypes function

            // Check the value of rab_calc_type
            var rabCalcType = $(`#calcul_${iden}`).val();

            // Check if the value is "FnB"
            if (rabCalcType === "FnB") {
                $(`#dayss2_${iden}`).attr("hidden", false);
            } else {
                $(`#dayss2_${iden}`).attr("hidden", true);
            }

            // Other logic for rabCalcTypes function
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataRabItem?>;
        let tableRow = '';
        
        for (const value of dataProducts) {
            // var iden = makeid(3);
            var iden = dataProducts.indexOf(value);

            const prods = <?=$dataRabItem?>;
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
                const qty2 = parseFloat($(`#qty2_${iden}`).val()) || 0;
                const days2 = parseFloat($(`#days2_${iden}`).val()) || 1;
                const price2 = parseFloat($(`#product-price2_${iden}`).val()) || 0;
                const total2 = price2 * qty2 * days2;

                $(`#itemTotal_${iden}`).val(divider1(total2));
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
                                                    for="product-price2">@Budget
                                                </label>
                                                <input id="product-price2_${iden}" name="product-price2" class="rab-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="number" data-iden="${iden}" value="${newDivider2(value.amount)}"/>
                                            </div>
                                            <div class="flex flex-row mb-3" id="dayss2_${iden}">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="days">Days Count : </label>
                                                <input id="days2_${iden}" name="days2" class="rab-input form-input w-20" type="number" data-iden="${iden}" value="${newDivider2(value.days)}"/>
                                                <span class="mx-2 mt-2 text-black-500">Days</span>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="itemTotal">Total
                                                </label>
                                                <input id="itemTotal_${iden}" name="itemTotal"
                                                class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                type="text" onchange="totally1(this)" value="${newDivider1(value.total)}" readonly/>
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
                            <td>${value.rab_calc_type}</td>
                            <td><input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="ids_${iden}" value="${value.id_rab_item}" hidden/> <input type="text" name="offer_${iden}" value="${value.id_rab}" hidden/>${value.category === 'null' ? '' : (value.category || '')}</td>
                            <td><input type="text" name="m_currency_${iden}" id="m_currency_${iden}" value="${value.sub_category}" hidden/><input type="text" name="idrecss_${iden}" value="${value.idrec}" hidden/>${value.sub_category === 'null' ? '' : (value.sub_category || '')}</td>
                            <td>${value.detail === 'null' ? '' : (value.detail || '')}<input type="text" name="days1_${iden}" id="days1_${iden}" value="${value.days}" hidden/><input type="text" name="calcul_${iden}" id="calcul_${iden}" value="${value.rab_calc_type}" hidden/></td>
                            <td class="text-right"><input type="text" name="qty_${iden}" id="qty_${iden}" value="${newDivider2(value.qty)}" hidden/><span id="qty_text_${iden}">${newDivider1(value.qty)}</span></td>
                            <td class="text-center"><input type="text" name="units1_${iden}" id="units1_${iden}" value="${value.unit}" hidden/><span id="units1_text_${iden}">${value.unit}</span></td>
                            <td class="text-right"><input type="text" name="price_${iden}" id="price_${iden}" value="${newDivider2(value.amount)}" hidden/><span id="price_text_${iden}">${newDivider1(value.amount)}</span></td>
                            <td class="text-right"><input type="text" name="total_${iden}" id="total_${iden}" value="${newDivider2(value.total)}" hidden/><span id="total_text_${iden}">${newDivider1(value.total)}</span></td>
                            <td><textarea type="text" name="remarks1_${iden}" id="remarks1_${iden}" value="${value.remarks}" hidden></textarea><span id="remarks1_text_${iden}">${value.remarks === 'null' ? '' : (value.remarks || '')}</span></td>
            </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="7">Grand Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(grandTotal)}</span></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);

        function updateDataProduct(iden) {
            var remarks = $('#remarks2_'+iden).val();
            $('#remarks1_'+iden).val(remarks);
            $('#remarks1_text_'+iden).text(remarks);

            var daysss = $('#days2_'+iden).val();
            $('#days1_'+iden).val(daysss);
            $('#days1-text_'+iden).text(daysss);
            
            var qty = parseFloat($('#qty2_' + iden).val()) || 0;
            var price = parseFloat($('#product-price2_' + iden).val()) || 0;
            var days = parseFloat($('#days2_' + iden).val()) || 0;
            var total = parseFloat(price*qty*days) || 0;
            // var moq = parseFloat($('#minimum_quantity_order2_' + iden).val()) || 0;

            var previousQty = parseFloat($('#qty_' + iden).val()) || 0;
            var previousPrice = parseFloat($('#price_' + iden).val()) || 0;
            var previousTotal = parseFloat($('#total_' + iden).val()) || 0;

            var totalDifference = total - previousTotal;

            // Update grandTotal with the price difference
            grandTotal += totalDifference;

            // Update nilai pada input #grandtotal
            $('#grandtotal').val(newDivider1(grandTotal));
            $('#grandtotal1').val(grandTotal);
            updateGrandTotal();

            // Update nilai pada hidden input price
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

        document.getElementById('approvalForm').addEventListener('submit', function(event) {
            var remarks = document.getElementById('remarks1').value.trim();
            var status = document.activeElement.value;

            if ((status === 'Denied' || status === 'Return to Draft') && (remarks === '' || remarks.toLowerCase() === 'null')) {
                alert('Remarks must Fill if "Denied" or "Return to Draft"');
                event.preventDefault();
            }
        });
    </script>
    @endsection
</x-app-layout>