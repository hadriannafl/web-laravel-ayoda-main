<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Cost Center Approval 1 📝</h1>
        </div>
        @if ($dataCC->cost_file != null)
            <div class="py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('cost-list.costfile', ['idCC' => $dataCC->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Cost Center</a>
                </div>
            </div>
        @endif
        <form action="{{ route('costcenter-approval-approvalga.updatestatus', ['idCC' => $dataCC->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="grid md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1"
                            for="id">Cost Center Form #</label>
                        <input id="id" class="form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->idreqform}}" disabled readonly/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1"
                            for="date">Form Date</label>
                        <input id="date" class=" form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{date('d F Y', strtotime($dataCC->datereq))}}" disabled readonly/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1"
                            for="date">Due Date</label>
                        <input id="date" class=" form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{date('d F Y', strtotime($dataCC->due_date))}}" disabled readonly/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Applicant</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->username}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Payable Name</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->applicant}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Company</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->company}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Cost Center Description</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->department}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Currency</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->currency}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Exchange Rate</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->crate}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Beneficiary Bank</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->bank}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Beneficiary Account</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->number_account}}" disabled readonly />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Beneficiary Name</label>
                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                            type="text" value="{{$dataCC->name_account}}" disabled readonly />
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Notes/ToP</label>
                    <textarea rows="3" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                    type="text" disabled readonly>{{$dataCC->note}}</textarea>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Cost Center Detail</label>
                </div>
                <table class="table table-striped table-bordered mt-2 mb-2" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-xs text-center">Date</th>
                            <th class="text-xs text-center">Cost Type</th>
                            <th class="text-xs text-center">Reff #</th>
                            <th class="text-xs text-center">Description</th>
                            <th class="text-xs text-center">Unit</th>
                            <th class="text-xs text-center">Qty</th>
                            <th class="text-xs text-center">Price</th>
                            <th class="text-xs text-center">Subtotal</th>
                            <th class="text-xs text-center">VAT Type</th>
                            <th class="text-xs text-center">VAT</th>
                            <th class="text-xs text-center">WHT Type</th>
                            <th class="text-xs text-center">WHT</th>
                            <th class="text-xs text-center">Cost Total</th>
                            <th class="text-xs text-center">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="tableProductAddBody" id="tableProductAddBody">
                        @foreach ($CCDetail as $item)
                            <tr>
                                <td class="text-xs text-center">{{$item->date}}</td>
                                <td class="text-xs text-left">{{$item->cost_type}}</td>
                                @if ($item->invoice_number == 'null')
                                <td></td>
                                @else
                                <td class="text-xs text-center">{{$item->invoice_number}}</td>
                                @endif
                                <td class="text-xs text-left">{{$item->desc}}</td>
                                <td class="text-xs text-left">{{$item->unit}}</td>
                                <td class="text-xs text-right">{{number_format($item->qty, 0, ',', '.')}}</td>
                                <td class="text-xs text-right">{{number_format($item->price, 0, ',', '.')}}</td>
                                <td class="text-xs text-right">{{number_format($item->subtotal, 0, ',', '.')}}</td>
                                <td class="text-xs text-left">{{$item->vat}}</td>
                                <td class="text-xs text-right">{{number_format($item->total_vat, 0, ',', '.')}}</td>
                                <td class="text-xs text-left">{{$item->wht}}</td>
                                <td class="text-xs text-right">{{number_format($item->total_wht, 0, ',', '.')}}</td>
                                <td class="text-xs text-right">{{number_format($item->paid_total, 0, ',', '.')}}</td>
                                @if ($item->remarks == 'null')
                                <td></td>
                                @else
                                <td class="text-xs text-left">{{$item->remarks}}</td>
                                @endif
                            </tr>
                        @endforeach
                        <tr class="grandTotalRow">
                            <td class="text-center font-bold text-sm" colspan="8">Grand Total Cost Center</td>
                            <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCC->total_vat, 0, ',', '.')}}</td>
                            <td></td>
                            <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCC->total_wht, 0, ',', '.')}}</td>
                            <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataCC->gtotal, 0, ',', '.')}}</td>
                            <td></td>
                        </tr>
                        @if ($dataCC->approved_total != null)
                        <tr class="grandTotalRow">
                            <td class="text-center font-bold text-sm" colspan="6">Cost Paid</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right font-bold text-sm">{{number_format($dataCC->approved_total, 0, ',', '.')}}</td>   
                            <td></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="approved_total">Cost Paid<span class="text-rose-500">*</span></label>
                        <div style="width: 31rem; margin-right: 41px;">
                            <input id="approved_total" name="approved_total" class="approved_total numeric-input form-input w-full px-2 py-1" type="text" required/>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white mr-5" id="fullAmount">Full Amount</button>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks1">Cost Center Remarks</label>
                    <textarea id="remarks1" name="remarks1"
                        class="remarks1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
                </div>
                <center>
                        <input type="submit" value="Approved" name="status" class="w-80 text-lg bg-green-500 hover:bg-green-600 text-white mt-3" />
                        <input type="submit" value="Denied" name="status" class="w-80 text-lg bg-red-400 border-slate-200 hover:bg-red-500 text-white mt-3" />
                </center>
            </form>
    </div>

    @section('js-page')
    <script>
        $('#fullAmount').on('click', function () {
            $("#approved_total").val('{{number_format($dataCC->gtotal, 0, ',', '.')}}');
        });
    </script>
    @endsection
</x-app-layout>