<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Submit Purchase Request for Approval 📝</h1>
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
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Asset Inventory
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
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/2 text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    <label class="text-sm font-medium mb-1 ml-16">&nbsp; &nbsp; </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right mr-40" type="text" 
                    value="{{number_format($dataPR->gtotal, 0, '.', '.')}}" required readonly/>
                </div>
                @if ($dataPR->approvalstat == 'Quotation Submitted' || $dataPR->approvalstat == 'HQ 1 Approved' || $dataPR->approvalstat == 'HQ 2 Approved'
                || $dataPR->approvalstat == 'HQ 1 Denied' || $dataPR->approvalstat == 'HQ 2 Denied' || $dataPR->approvalstat == 'Canceled' 
                || $dataPR->approvalstat == 'Waiting for Quotation')
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
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="deliveryCharge">Delivery Charge (IDR)
                    </label>
                    <input id="deliveryCharge" name="deliveryCharge" class="deliveryCharge form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" value="{{number_format($dataPR->delivery_charge, 0, '.', '.')}}" readonly/>
                </div>
                <form action="{{ route('purchase-list.submittedapproval', ['idPR' => $dataPR->idrec]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($dataPR->approvalstat == 'Waiting Quotation' || $dataPR->approvalstat == 'Quotation Submitted')
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit">
                        <span class="xs:block ml-5 mr-5">Submit to Approval</span>
                    </button> </center>
                    @endif
                </form>
    </div>

    @section('js-page')
    <script>
        $('#approval_to').select2();
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
                            <td>${value.name_rab_detail}</td>
                            <td class="text-center">${value.unit}</td>
                            <td class="text-right">${newDivider1(value.qty)}</td>
                            <td class="text-center">{{$dataPR->currency}}</td>
                            <td class="text-right">${newDivider1(value.price)}</td>
                            <td class="text-right">${newDivider1(value.total)}</td>
                            <td>${value.remarks == null ? '' : value.remarks}</td>
                                        </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);
        var grandTotalRow = `<tr class="grandTotalRow">
            <td class="text-center font-bold text-lg" colspan="6">Grand Total</td>
            <td class="text-right font-bold text-lg" id="grandTotal_text">{{number_format($dataPR->gtotal, 0, '.', '.')}}</td>
            <td></td>
            <td></td>
        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);
        
    </script>
    @endsection
</x-app-layout>