<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Purchase Request Approval 3 📝</h1>
        </div>
        <div class="py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <a href="{{ route('purchase-list.viewfile', ['idPR' => $dataPR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Purchase Request</a>
            </div>
        </div>
        <form id="approvalForm" action="{{ route('purchase-approvalga3.updatestatus', ['idPR' => $dataPR->idrec]) }}" method="post" enctype="multipart/form-data">
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
                                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Approval Status / Approved 1 By / Approved 2 By</label>
                                        <div style="width: 20.8rem; margin-right: 20px;">
                                            <input id="total_amount" value="{{$dataPR->approvalstat}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                        </div>
                                        <div style="width: 20.8rem; margin-right: 20px;">
                                            <input id="total_paid" value="{{$dataPR->approved1by}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly>
                                        </div>
                                        <div>
                                            <input id="balance" value="{{$dataPR->approved2by}}" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                        </div>
                                </div>
                                <div class="flex flex-row mb-3 mt-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Approved Date</label>
                                        <div style="width: 20.8rem; margin-right: 20px;">
                                            <input id="total_amount" value="{{$dataPR->approvaldate}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
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
                                <th class="text-sm text-center">@Price</th>
                                <th class="text-sm text-center">Total</th>
                                <th class="text-sm text-center">Remarks</th>
                                
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/2 text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    <label class="text-sm font-medium mb-1 ml-16">&nbsp; &nbsp; </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" 
                    value="{{number_format($dataPR->gtotal, 0, '.', '.')}}" required readonly/>
                </div>
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
                                <th class="text-sm flex justify-start mt-2 font-medium">Attachment Quotation</th>
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
                                @if ($dataPR->total_quo2 != null)
                                <th class="text-xs text-center font-medium">{{number_format($dataPR->total_quo2, 0, ',', '.')}}</th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                                @if ($dataPR->total_quo3 != null)
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
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval3" name="quotation_approval3" value="1"></th>
                                @if ($dataPR->quotation2 != null)
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval3" name="quotation_approval3" value="2"></th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                                @if ($dataPR->quotation3 != null)
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval3" name="quotation_approval3" value="3"></th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
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
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" 
                    value="{{number_format($dataPR->gtotal, 0, '.', '.')}}" required readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="deliveryCharge">Delivery Charge (IDR)
                    </label>
                    <input id="deliveryCharge" name="deliveryCharge" class="deliveryCharge form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" value="{{number_format($dataPR->delivery_charge, 0, '.', '.')}}" readonly/>
                </div>

                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks3">Quotation Remarks 3 </label>
                    <textarea id="remarks3" name="remarks3"
                        class="remarks3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
                </div>
                <center>
                        <input type="submit" value="Approved" name="status" class="w-80 text-lg bg-green-500 hover:bg-green-600 text-white mt-3" />
                        <input type="submit" value="Denied" name="status" class="w-80 text-lg bg-red-400 border-slate-200 hover:bg-red-500 text-white mt-3" />
                </center>
            </form>
    </div>

    @section('js-page')
    <script>
        document.getElementById('approvalForm').addEventListener('submit', function(event) {
            var remarks = document.getElementById('remarks3').value.trim();
            var status = document.activeElement.value;

            if ((status === 'Denied') && (remarks === '' || remarks.toLowerCase() === 'null')) {
                alert('Remarks must Fill if "Denied"');
                event.preventDefault();
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$PRDetail?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {

            tableRow += `<tr id=row1-productIdx>
                            <td>${value.idassets}</td>
                            <td>${value.name}</td>
                            <td class="text-center">${value.unit}</td>
                            <td class="text-right">${newDivider1(value.qty)}</td>
                            <td class="text-right">${newDivider1(value.price)}</td>
                            <td class="text-right">${newDivider1(value.total)}</td>
                            <td>${value.remarks === 'null' ? '' : (value.remarks || '')}</td>
                                        </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="5">Grand Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text">{{number_format($dataPR->gtotal, 0, '.', '.')}}</td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);
        
    </script>
    @endsection
</x-app-layout>