<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Submit Reimburse for Approval 📝</h1>
        </div>
        @if ($dataRR->reimburse_file != null)
        <div class="py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <a href="{{ route('reimburse-list.viewfile', ['idRR' => $dataRR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Reimburse</a>
            </div>
        </div>
        @endif
        <form action="{{ route('reimburse-list.submit', ['idRR' => $dataRR->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Reimburse Form # / Request Date / Employee</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRR->idreqform}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataRR->datereq))}}" readonly>
                        </div>
                        <div>
                            <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRR->employee}} {{$dataRR->last_name}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Company (Charged to) / Department / Currency</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRR->company_name}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRR->department}}" readonly>
                        </div>
                        <div>
                            <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRR->currency}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Payment To Beneficiary By / Beneficiary Account / Beneficiary Name</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRR->bank}}" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRR->number_account}}" readonly>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRR->name_account}}" readonly/>
                        </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Notes</label>
                    <textarea rows="3" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                    type="text" disabled readonly>{{$dataRR->note}}</textarea>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Reimburse Detail</label>
                </div>
                <table class="table table-striped table-bordered mt-2 mb-2" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-xs text-center">Date</th>
                            <th class="text-xs text-center">Reimburse Type</th>
                            <th class="text-xs text-center">Vehicle Number</th>
                            <th class="text-xs text-center">Reimburse Description</th>
                            <th class="text-xs text-center">Subtotal</th>
                            <th class="text-xs text-center">VAT Type</th>
                            <th class="text-xs text-center">VAT</th>
                            <th class="text-xs text-center">WHT Type</th>
                            <th class="text-xs text-center">WHT</th>
                            <th class="text-xs text-center">Reimburse Total</th>
                            <th class="text-xs text-center">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="tableProductAddBody" id="tableProductAddBody">
                        @foreach ($RRDetail as $item)
                            <tr class="text-xs">
                                <td class="text-center">{{$item->date}}</td>
                                <td class="text-left">{{$item->reimburse_type}}</td>
                                @if ($item->no_vehicle == 'null')
                                <td></td>
                                @else
                                <td class="text-center">{{$item->no_vehicle}}</td>
                                @endif
                                <td class="text-left">{{$item->reimburse_to}}</td>
                                <td class="text-right">{{number_format($item->subtotal, 0, ',', '.')}}</td>
                                <td class="text-left">{{$item->vat}}</td>
                                <td class="text-right">{{number_format($item->total_vat, 0, ',', '.')}}</td>
                                <td class="text-left">{{$item->wht}}</td>
                                <td class="text-right">{{number_format($item->total_wht, 0, ',', '.')}}</td>
                                <td class="text-right">{{number_format($item->paid_total, 0, ',', '.')}}</td>
                                @if ($item->remarks == 'null')
                                <td></td>
                                @else
                                <td class="text-left">{{$item->remarks}}</td>
                                @endif
                                {{-- <td class="text-center flex flex-row justify-center">
                                    <a href="{{ route('reimburse-approval.file', ['id' => $item->id]) }}" target="_blank" class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white
                                        {{$item->file == null ? 'hidden' : ''}}">
                                        View Reimburse File
                                    </a>
                                </td> --}}
                            </tr>
                        @endforeach
                        <tr class="grandTotalRow">
                            <td class="text-center font-bold text-sm" colspan="6">Grand Total Reimburse</td>
                            <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataRR->total_vat, 0, ',', '.')}}</td>
                            <td></td>
                            <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataRR->total_wht, 0, ',', '.')}}</td>
                            <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataRR->gtotal, 0, ',', '.')}}</td>
                            <td></td>
                        </tr>
                        @if ($dataRR->approved_total != null)
                        <tr class="grandTotalRow">
                            <td class="text-center font-bold text-sm" colspan="6">Reimburse Paid</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right font-bold text-sm">{{number_format($dataRR->approved_total, 0, ',', '.')}}</td>   
                            <td></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="flex flex-row mt-3" hidden>
                    <label class="block w-full md:w-3/4 text-sm font-medium mb-1" for="approve1_stat">Grand Total Reimburse</label>
                    <input id="approve1_stat" class="approve1_stat form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200 text-right"
                        type="text" value="{{number_format($dataRR->gtotal, 0, ',', '.')}}"readonly />
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="request_to">Approval Request to<span
                        class="text-rose-500">*</span>
                    </label>
                    <select id="approval_to" name="approval_to" class="approval_to form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Approval to</option>
                        @foreach ($dataUser as $approvalTo)
                        <option value="{{$approvalTo->id}}">{{$approvalTo->username}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="request_to">Approval Request 2 to<span
                        class="text-rose-500">*</span>
                    </label>
                    <select id="approval2_to" name="approval2_to" class="approval2_to form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Approval to</option>
                        @foreach ($dataUser2 as $approval2To)
                        <option value="{{$approval2To->id}}">{{$approval2To->username}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file45">Attachment Reimburse Request Printed Document<span
                        class="text-rose-500">*</span></label>
                    <input id="file45" name="file45" class="file45 form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf" required/>
                </div> --}}

                @if ($dataRR->approvalstat == "Draft")
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Submit Reimburse Request</span>
                </button> </center>
                @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $('#approval_to').select2();
        $('#approval2_to').select2();
        // var grandTotalRow = `<tr class="grandTotalRow">
        //     <td class="text-center font-bold text-lg" colspan="5">Grand Total</td>
        //     <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(subtotal)}</span></td>
        //     <td></td>
        // </tr>`;
        // $("#tableProductAddBody").append(grandTotalRow);
    </script>
    @endsection
</x-app-layout>