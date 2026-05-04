<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Reimburse Approval 1 📝</h1>
        </div>
        @if ($dataRR->reimburse_file != null)
        <div class="py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <a href="{{ route('reimburse-list.viewfile', ['idRR' => $dataRR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Reimburse Request</a>
            </div>
        </div>
        @endif
        <form id="approvalForm" action="{{ route('reimburse-approvalga.updatestatus', ['idRR' => $dataRR->idrec]) }}" method="post" enctype="multipart/form-data">
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
                            <input id="depskuys" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRR->department}}" readonly>
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
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="approved_total">Reimburse Paid<span class="text-rose-500">*</span></label>
                        <div style="width: 31rem; margin-right: 41px;">
                            <input id="approved_total" name="approved_total" class="approved_total numeric-input form-input w-full px-2 py-1" type="text"/>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white mr-5" id="fullAmount">Full Amount</button>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks1">Reimburse Remarks 1</label>
                    <textarea id="remarks1" name="remarks1"
                        class="remarks1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
                </div>
                <center>
                        <input type="submit" value="Direct Approval" name="status" id="status" class="w-80 text-lg bg-amber-500 hover:bg-amber-600 text-white mt-3"/>
                        <input type="submit" value="Approve" name="status" id="status2" class="w-80 text-lg bg-green-500 hover:bg-green-600 text-white mt-3"/>
                        <input type="submit" value="Denied" name="status" id="status3" class="w-80 text-lg bg-red-400 border-slate-200 hover:bg-red-500 text-white mt-3"/>
                </center>
            </form>
    </div>

    @section('js-page')
    <script>
        $('#approval_to').select2();
        $('#fullAmount').on('click', function () {
            $("#approved_total").val('{{number_format($dataRR->gtotal, 0, ',', '.')}}');
        });
        document.getElementById('approvalForm').addEventListener('submit', function(event) {
            var remarks = document.getElementById('remarks1').value.trim();
            var approvedTotal = document.getElementById('approved_total').value.trim();
            var status = document.activeElement.value;

            if ((status === 'Denied') && (remarks === '' || remarks.toLowerCase() === 'null')) {
                alert('Remarks must Fill if "Denied"');
                 event.preventDefault();
            }
            if ((status === 'Approve' || status === 'Direct Approval') && (approvedTotal === '' || approvedTotal === '0'|| !approvedTotal)) {
                alert('Reimburse Paid must Fill if "Approve" or "Direct Approval"');
                event.preventDefault();
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
                // Fungsi untuk menampilkan alert jika melebihi batas
                function checkAmountLimit() {
                    console.log("Checking amount limit...");
                    var balance = parseFloat("{{$dataRR->gtotal}}");

                    // Menghapus titik pemisah ribuan dari nilai input
                    var amountInputValue = document.getElementById('approved_total').value.replace(/\./g, '');
                    var amount = parseFloat(amountInputValue);

                    if (amount > balance) {
                        alert("Reimburse Paid cannot exceed the Grand Total Reimburse.");
                        $('#status').attr('hidden', true);
                        $('#status2').attr('hidden', true);
                        $('#status3').attr('hidden', true);
                        document.getElementById('approved_total').value = addThousandSeparator(previousAmount);
                    }else {
                        // Jika nilai tidak melebihi batas, update nilai sebelumnya
                        previousAmount = amountInputValue;
                        $('#status').attr('hidden', false);
                        $('#status2').attr('hidden', false);
                        $('#status3').attr('hidden', false);
                    }
                }

                // Tambahkan event listener untuk perubahan pada input amount
                document.getElementById('approved_total').addEventListener('input', function() {
                    checkAmountLimit();
                    calculateBalance(); // Panggil fungsi perhitungan saldo setelah perubahan amount
                });
            });
    </script>
    @endsection
</x-app-layout>