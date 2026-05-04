<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">View RAB Request 📝</h1>
        </div>
        @if ($dataRab->rab_file != null)
            <div class="px-5 py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('rab-list.viewfile', ['rabId' => $dataRab->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment RAB</a>
                </div>
            </div>
        @endif
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
        <ul class="mt-3" x-data="{ open: {{ in_array(Request::segment(1), ['#0']) ? 1 : 0 }} }">
                <a class="block text-sm font-medium truncate transition duration-150 @if(in_array(Request::segment(1), ['#0'])){{ 'hover:text-indigo-500' }}@endif"
                    href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                        <div class="flex justify-center">
                            <div class="flex items-center">
                                <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">View More Detail</span>
                            </div>
                            <!-- Icon -->
                            <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 mt-1">
                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                </svg>
                            </div>
                        </div>
                </a>
                    <div class="">
                        <ul class="mt-3 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                            :class="open ? '!block' : 'hidden'">
                            <div class="flex flex-row mb-3 mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Approved 1 By / Approved 2 By / Approved 3 By</label>
                                    <div style="width: 20.8rem; margin-right: 20px;">
                                        <input id="total_amount" value="{{$dataRab->approved1by}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                    </div>
                                    <div style="width: 20.8rem; margin-right: 20px;">
                                        <input id="total_paid" value="{{$dataRab->approved2by}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly>
                                    </div>
                                    <div>
                                        <input id="balance" value="{{$dataRab->approved3by}}" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                    </div>
                            </div>
                            <div class="flex flex-row mb-3 mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Last Updated At</label>
                                    <div style="width: 20.8rem; margin-right: 20px;">
                                        <input id="total_amount" value="{{$dataRab->approvaldate}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                    </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-sm font-medium mb-1" for="remarks1">Remarks 1</label>
                                <textarea id="remarks1" name="remarks1" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataRab->remarks1}}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="remarks2">Remarks 2</label>
                                <textarea id="remarks2" name="remarks2" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataRab->remarks2}}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="remarks3">Remarks 3</label>
                                <textarea id="remarks3" name="remarks3" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataRab->remarks3}}</textarea>
                            </div>
                        </ul>
                    </div>
        </ul>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">RAB Item
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
    </div>

    @section('js-page')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataRabItem?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {
            var iden = makeid(3);

            const prods = <?=$dataRabItem?>;
            var modal_content = '';
            $.each(prods, function (i,item1) {
                if(value.id_rab_item == item1.id_rab_item){
                    modal_content += `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="product_price2">Amount :
                                                </label>
                                                <input id="product_price2_${iden}" name="product_price2"
                                                    class="product_price2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="number" value="${newDivider1(value.amount)}"/>
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

            tableRow += `<tr id=row1-productIdx>
                            <td>${value.rab_calc_type}</td>
                            <td>${value.category === 'null' ? '' : (value.category || '')}</td>
                            <td>${value.sub_category === 'null' ? '' : (value.sub_category || '')}</td>
                            <td>${value.detail === 'null' ? '' : (value.detail || '')}</td>
                            <td class="text-right">${newDivider1(value.qty)}</td>
                            <td class="text-center">${value.unit}</td>
                            <td class="text-right">${newDivider1(value.amount)}</td>
                            <td class="text-right">${newDivider1(value.total)}</td>
                            <td>${value.remarks === 'null' ? '' : (value.remarks || '')}</td>
                                        </tr>`;
        }
        tableRow += `<tr>
                    <td class="text-center font-bold text-lg" colspan="7">Grand Total</td>
                    <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">{{number_format($dataRab->grandTotal, 0, '.', '.')}}</span></td>
                    <td></td>
                </tr>`;
        $(".tableProductAddBody").find('tbody').append(tableRow);

        $(document).ready(function () {
            $('#rabItem').DataTable({
                responsive: true,
                            processing: true,
                            serverSide: false,
                            stateServe: true,
                            "order": [[ 0, "desc" ]],
                            language: {
                                search: "Search Item:"
                            },
                            ajax: {
                                url: "{{ route('rab.item') }}"
                            },
                            columns: [
                                {
                                    data: "created_at",
                                    name: "created_at"
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
                                    data: "sub_department",
                                    name: "sub_department"
                                },
                                {
                                    data: "detail",
                                    name: "detail"
                                },
                                {
                                    data: "coa",
                                    name: "coa"
                                },
                                {
                                    data: "action",
                                    name: "action"
                                },
                            ],
                            columnDefs: [
                                { className: 'text-center', targets: [0, 6] },
                            ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#rabItem').on("click", ".btn-select", function () {
                const idAsset = $(this).data("id");
                const nameAsset = $(this).data("nama");
                const department = $(this).data("department");

                $("#rabItemId").val(idAsset);
                $("#nama_product").val(nameAsset);
                $("#department").val(department);
            });
        });

        let grandTotal = parseFloat($('#grandtotal1').val()) || 0;
        $("#addProduct").click(function () {
            var id = $('#rabItemId').val();
            var department = $('#department').val();
            var name = $('#nama_product').val();
            var price1 = $('#product_price').val();
            var price = parseFloat($('#product_price').val());
            // var oq1 = $('#order_quantity').val();
            // var oq = parseFloat($('#order_quantity').val());
            price = Math.floor(price);
            var total = price;
            grandTotal += total;

                
            var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                "  <td class=\"text-left\">" + department + "</td>\n" +
                "  <td class=\"text-left\">" + name + "<input type=\"hidden\" name = \"rows[" + productIdx + "][ids]\"value =" + id + "></td>\n" +
                "  <td class=\"text-right\">" + `${newDivider(price1)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][prices]\" value =" + price1 + "></td>\n" +
                // "  <td class=\"text-right\">" + `${divider(oq1)}` + "<input type=\"hidden\" name = \"rows[" + productIdx + "][oqs]\" value =" + oq1 + "></td>\n" +
                "  <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + total + "," + null + ")\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
                "</tr>";


                if (name === '' || price === '') {
                    return false;
                }

                $("#tableProductAddBody").append(tr);

                $('#rabItemId').val('');
                $('#department').val('');
                $('#nama_product').val('');
                $('#product_price').val('');
                $('#order_quantity').val('');
                $('#grandtotal').val(`${newDivider(grandTotal)}`);
                $('#grandtotal1').val(grandTotal);

                productIdx++;
                    
        });

        function updateDataProduct(iden) {
            var price = parseFloat($('#product_price2_' + iden).val()) || 0;
            // var moq = parseFloat($('#minimum_quantity_order2_' + iden).val()) || 0;

            var previousPrice = parseFloat($('#price_' + iden).val()) || 0;

            var priceDifference = price - previousPrice;

            // Update grandTotal with the price difference
            grandTotal += priceDifference;

            // Update nilai pada input #grandtotal
            $('#grandtotal').val(newDivider(grandTotal));
            $('#grandtotal1').val(grandTotal);

            // Update tampilan grandTotal jika diperlukan
            // $('#grandtotal').text(newDivider1(grandTotal));

            // Update nilai pada hidden input moqty
            // $('#moqty_' + iden).val(moq);
            // $('#moqty_text_' + iden).text(newDivider1(moq));

            // Update nilai pada hidden input price
            $('#price_' + iden).val(price);
            $('#price_text_' + iden).text(newDivider(price));

            console.log(iden, price, grandTotal);
        }

        
        function deleteDataProduct(positionTableRow, total) {
            const positionTableRowVariable = positionTableRow;
            console.log(grandTotal, total);

            // Kurangkan total produk yang dihapus dari grandtotal
            grandTotal -= parseFloat(total);

            // Hapus baris tabel produk yang dihapus
            $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();

            // Perbarui nilai #grandtotal dan #grandtotal1 dengan grandtotal baru
            $('#grandtotal').val(newDivider(grandTotal));
            $('#grandtotal1').val(grandTotal);

            console.info('positionTableRowVariable: ', positionTableRowVariable);
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
        
    </script>
    @endsection
</x-app-layout>