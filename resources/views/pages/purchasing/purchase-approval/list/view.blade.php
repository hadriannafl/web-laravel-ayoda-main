<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">View Purchase Request 📝</h1>
        </div>
        @if ($dataPR->pr_file != null)
            <div class="py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('purchase-list.viewfile', ['idPR' => $dataPR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Purchase Request</a>
                </div>
            </div>
        @endif
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
                                    <input id="total_amount" value="{{$dataPR->approved1by}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                </div>
                                <div style="width: 20.8rem; margin-right: 20px;">
                                    <input id="total_paid" value="{{$dataPR->approved2by}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly>
                                </div>
                                <div>
                                    <input id="balance" value="{{$dataPR->approved3by}}" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                </div>
                        </div>
                        <div class="flex flex-row mb-3 mt-3">
                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Approval Status / Approval Date</label>
                                <div style="width: 20.8rem; margin-right: 20px;">
                                    <input id="total_amount" value="{{$dataPR->approvalstat}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                </div>
                                <div style="width: 20.8rem; margin-right: 20px;">
                                    <input id="total_paid" value="{{$dataPR->approvaldate}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly>
                                </div>
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium mb-1" for="remarks1">Quotation Remarks 1</label>
                            <textarea id="remarks1" name="remarks1" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataPR->remarks1}}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="remarks1">Quotation Remarks 2</label>
                            <textarea id="remarks1" name="remarks1" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataPR->remarks2}}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="remarks1">Quotation Remarks 3</label>
                            <textarea id="remarks1" name="remarks1" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataPR->remarks3}}</textarea>
                        </div>
                    </ul>
                </div>
        </ul>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">List Asset Inventory
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
                                <th class="text-sm text-center">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/2 text-sm font-medium mb-1" for="grandtotal">Grand Total</label>
                    <label class="text-sm font-medium mb-1 ml-16">&nbsp; &nbsp; </label>
                    <input id="grandtotal" name="grandtotal"
                        class="grandtotal form-input w-full md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right" type="text" 
                        value="{{number_format($dataPR->gtotal, 0, '.', '.')}}" readonly/>
                </div>
                @if ($dataPR->approvalstat == 'Quotation Submitted' || $dataPR->approvalstat == 'Waiting Approval 1' || $dataPR->approvalstat == 'HQ 1 Approved' || $dataPR->approvalstat == 'HQ 2 Approved'
                || $dataPR->approvalstat == 'HQ 1 Denied' || $dataPR->approvalstat == 'HQ 2 Denied' || $dataPR->approvalstat == 'HQ 3 Denied' || $dataPR->approvalstat == 'HQ 3 Approved')
                    <div class="flex flex-row md:flex-row mb-3 mt-3">
                        <label class="block text-sm font-medium mb-1" for="task_id">Quotation List
                        </label>
                    </div>
                    <div class="flex flex-row md:flex-row">
                        <table class="quotation-tables table table-striped table-bordered mt-3"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-sm text-center">Quotation Detail</th>
                                    <th class="text-sm text-center">Quotation 1</th>
                                    <th class="text-sm text-center">Quotation 2</th>
                                    <th class="text-sm text-center">Quotation 3</th>
                                </tr>
                            </thead>
                            <tbody class="quotation-tables" id="quotation-tables">
                                <tr>
                                    <th class="text-sm text-left font-medium mt-2">Attachment Quotation</th>
                                    <th class="text-sm text-center"><a href="{{ route('purchase-list.quotation1', ['idPR' => $dataPR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Quotation 1</a></th>
                                    @if ($dataPR->quotation2 != null)
                                    <th class="text-sm text-center"><a href="{{ route('purchase-list.quotation2', ['idPR' => $dataPR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Quotation 2</a></th>
                                    @else
                                    <th class="text-sm text-center"></th>
                                    @endif
                                    @if ($dataPR->quotation3 != null)
                                    <th class="text-sm text-center"><a href="{{ route('purchase-list.quotation3', ['idPR' => $dataPR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Quotation 3</a></th>
                                    @else
                                    <th class="text-sm text-center"></th>
                                    @endif
                                </tr>
                                <tr>
                                    <th class="text-sm font-medium">Vendor Name</th>
                                    <th class="text-sm text-center font-medium">{{$dataPR->vendor_quo1}}</th>
                                    @if ($dataPR->vendor_quo2 != null)
                                    <th class="text-sm text-center font-medium">{{$dataPR->vendor_quo2}}</th>
                                    @else
                                    <th class="text-sm"></th>
                                    @endif
                                    @if ($dataPR->vendor_quo3 != null)
                                    <th class="text-sm text-center font-medium">{{$dataPR->vendor_quo3}}</th>
                                    @else
                                    <th class="text-sm"></th>
                                    @endif
                                </tr>
                                <tr>
                                    <th class="text-sm font-medium">Vendor Offering Price</th>
                                    <th class="text-xs text-center font-medium">{{number_format($dataPR->total_quo1, 0, ',', '.')}}</th>
                                    @if ($dataPR->total_quo2 != '0')
                                    <th class="text-xs text-center font-medium">{{number_format($dataPR->total_quo2, 0, ',', '.')}}</th>
                                    @else
                                    <th class="text-sm text-center"></th>
                                    @endif
                                    @if ($dataPR->total_quo3 != '0')
                                    <th class="text-xs text-center font-medium">{{number_format($dataPR->total_quo3, 0, ',', '.')}}</th>
                                    @else
                                    <th class="text-sm text-center"></th>
                                    @endif
                                </tr>
                                <tr>
                                    <th class="text-sm font-medium">Approval 1 Selection</th>
                                    <th class="text-sm text-center"><input type="radio" id="quotation_approval1" name="quotation_approval1" value="1" {{$dataPR->quotation_approval1 == '1' ? 'checked':''}}></th>
                                    @if ($dataPR->quotation2 != null)
                                    <th class="text-sm text-center"><input type="radio" id="quotation_approval1" name="quotation_approval1" value="2" {{$dataPR->quotation_approval1 == '2' ? 'checked':''}}></th>
                                    @else
                                    <th class="text-sm text-center"></th>
                                    @endif
                                    @if ($dataPR->quotation3 != null)
                                    <th class="text-sm text-center"><input type="radio" id="quotation_approval1" name="quotation_approval1" value="3" {{$dataPR->quotation_approval1 == '3' ? 'checked':''}}></th>
                                    @else
                                    <th class="text-sm text-center"></th>
                                    @endif
                                </tr>
                                {{-- <tr>
                                    <th class="text-sm font-medium">Approval 2 Selection</th>
                                    <th class="text-sm text-center"><input type="radio" id="quotation_approval2" name="quotation_approval2" value="1" {{$dataPR->quotation_approval2 == '1' ? 'checked':''}}></th>
                                    @if ($dataPR->quotation2 != null)
                                    <th class="text-sm text-center"><input type="radio" id="quotation_approval2" name="quotation_approval2" value="2" {{$dataPR->quotation_approval2 == '2' ? 'checked':''}}></th>
                                    @else
                                    <th class="text-sm text-center"></th>
                                    @endif
                                    @if ($dataPR->quotation3 != null)
                                    <th class="text-sm text-center"><input type="radio" id="quotation_approval2" name="quotation_approval2" value="3" {{$dataPR->quotation_approval2 == '3' ? 'checked':''}}></th>
                                    @else
                                    <th class="text-sm text-center"></th>
                                    @endif
                                </tr>
                                <tr>
                                    <th class="text-sm font-medium">Approval 3 Selection</th>
                                    <th class="text-sm text-center"><input type="radio" id="quotation_approval3" name="quotation_approval3" value="1" {{$dataPR->quotation_approval3 == '1' ? 'checked':''}}></th>
                                    @if ($dataPR->quotation2 != null)
                                    <th class="text-sm text-center"><input type="radio" id="quotation_approval3" name="quotation_approval3" value="2" {{$dataPR->quotation_approval3 == '2' ? 'checked':''}}></th>
                                    @else
                                    <th class="text-sm text-center"></th>
                                    @endif
                                    @if ($dataPR->quotation3 != null)
                                    <th class="text-sm text-center"><input type="radio" id="quotation_approval3" name="quotation_approval3" value="3" {{$dataPR->quotation_approval3 == '3' ? 'checked':''}}></th>
                                    @else
                                    <th class="text-sm text-center"></th>
                                    @endif
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="subtotal">Subtotal
                    </label>
                    <input id="subtotal" name="subtotal" type="text" class="subtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" value="{{number_format($dataPR->subtotal, 0, '.', '.')}}" readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="discount">Discount (IDR)
                    </label>
                    <input id="discount" name="discount" class="discount form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" value="{{number_format($dataPR->discount, 0, '.', '.')}}" readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="total">Total
                    </label>
                    <input id="total" name="total" type="text" class="total form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" value="{{number_format($dataPR->total, 0, '.', '.')}}" readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="ppn">PPN (IDR)
                    </label>
                    <input id="ppn" name="ppn" class="ppn form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" value="{{number_format($dataPR->ppn, 0, '.', '.')}}" readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/2 text-sm font-medium mb-1" for="grandtotal">Grand Total</label>
                    <input id="grandtotal" name="grandtotal"
                        class="grandtotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 text-right mr-48" type="text" 
                        value="{{number_format($dataPR->gtotal, 0, '.', '.')}}" readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="deliveryCharge">Delivery Charge (IDR)
                    </label>
                    <input id="deliveryCharge" name="deliveryCharge" class="deliveryCharge form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" value="{{number_format($dataPR->delivery_charge, 0, '.', '.')}}" readonly/>
                </div>
    </div>

    @section('js-page')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$PRDetail?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {
            var iden = makeid(3);

            tableRow += `<tr id=row1-productIdx>
                            <td>${value.idassets}</td>
                            <td>${value.name_rab_detail}</td>
                            <td class="text-center">${value.unit}</td>
                            <td class="text-right">${newDivider1(value.qty)}</td>
                            <td class="text-center">{{$dataPR->currency}}</td>
                            <td class="text-right">${newDivider1(value.price)}</td>
                            <td class="text-right">${newDivider1(value.total)}</td>
                            <td>${value.remarks === 'null' ? '' : (value.remarks || '')}</td>
                                        </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="6">Grand Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text">{{number_format($dataPR->gtotal, 0, '.', '.')}}</td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);

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