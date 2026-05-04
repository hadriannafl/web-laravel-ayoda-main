<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">RAB Request Approval 3 📝</h1>
        </div>
        @if ($dataRab->rab_file != null)
        <div class="px-5 py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <a href="{{ route('rab-list.viewfile', ['rabId' => $dataRab->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment RAB</a>
            </div>
        </div>
        @endif
        <form id="approvalForm" action="{{ route('rab-approvalga.updatestatus3', ['rabId' => $dataRab->idrec]) }}" method="post" enctype="multipart/form-data">
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
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Approval 1 By / Approval 2 By / Last Updated At</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->approved1by}}" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->approved2by}}" readonly>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->approvaldate}}" readonly/>
                        </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1" for="remarks1">Remarks Approval 1</label>
                    <textarea id="remarks1" name="remarks1" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataRab->remarks1}}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="remarks2">Remarks Approval 2</label>
                    <textarea id="remarks2" name="remarks2" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataRab->remarks2}}</textarea>
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
                                <th hidden class="text-sm text-center">Balance</th>
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
                    <label class="text-sm font-medium mb-1" for="remarks3">Remarks Approval 3</label>
                    <textarea id="remarks3" name="remarks3"
                        class="remarks3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
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
        document.getElementById('approvalForm').addEventListener('submit', function(event) {
            var remarks = document.getElementById('remarks3').value.trim();
            var status = document.activeElement.value;

            if ((status === 'Denied' || status === 'Return to Draft') && (remarks === '' || remarks.toLowerCase() === 'null')) {
                alert('Remarks must Fill if "Denied" or "Return to Draft"');
                event.preventDefault();
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataRabItem?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {
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
        
    </script>
    @endsection
</x-app-layout>