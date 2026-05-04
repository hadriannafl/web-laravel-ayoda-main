<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Reimburse Approval 2 📝</h1>
        </div>
        @if ($dataRR->reimburse_file != null)
        <div class="py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <a href="{{ route('reimburse-list.viewfile', ['idRR' => $dataRR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Reimburse Request</a>
            </div>
        </div>
        @endif
        <form id="approvalForm" action="{{ route('reimburse-approvalga2.updatestatus', ['idRR' => $dataRR->idrec]) }}" method="post" enctype="multipart/form-data">
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
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Status Request</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="{{$dataRR->approvalstat}}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Approved 1 By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="{{$dataRR->approved1by}}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approved 1 Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="{{$dataRR->approval1_date}}" disabled readonly />
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Remarks 1</label>
                                    <textarea rows="3" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                    type="text" disabled readonly>{{$dataRR->remarks1}}</textarea>
                                </div>
                            </ul>
                        </div>
                </ul>
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
                            <td class="text-center font-bold text-sm" colspan="9">Grand Total Reimburse</td>
                            <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataRR->gtotal, 0, ',', '.')}}</td>
                            <td></td>
                        </tr>
                        @if ($dataRR->approved_total != null)
                        <tr class="grandTotalRow">
                            <td class="text-center font-bold text-sm" colspan="9">Reimburse Paid</td>
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
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks2">Reimburse Remarks 2</label>
                    <textarea id="remarks2" name="remarks2"
                        class="remarks2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
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
            var remarks = document.getElementById('remarks2').value.trim();
            var status = document.activeElement.value;

            if ((status === 'Denied') && (remarks === '' || remarks.toLowerCase() === 'null')) {
                alert('Remarks must Fill if "Denied"');
                 event.preventDefault();
            }
        });
    </script>
    @endsection
</x-app-layout>