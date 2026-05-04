<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Outbound Inventory Approval 📝</h1>
        </div>
        @if ($dataOutbound->file != null)
        <div class="px-5 py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <a href="{{ route('outbound-inventory.viewfile', ['outboundId' => $dataOutbound->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment</a>
            </div>
        </div>
        @endif
        <form id="approvalForm" action="{{ route('outbound-approval.updatestatus', ['outboundId' => $dataOutbound->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Outbound # / Date Outbound / Company</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->id_outbound}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataOutbound->date))}}" readonly>
                        </div>
                        <div>
                            <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('F Y', strtotime($dataOutbound->companyName))}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Warehouse Name / Address / City</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataOutbound->w_name}}" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <textarea id="address" name="address" class="address form-input w-full px-2 py-1 read-only:bg-slate-200" rows="3" readonly>{{$dataOutbound->w_address}}</textarea>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->w_city}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Warehouse Province / Country / POS Code</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataOutbound->w_province}}" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->w_country}}" readonly>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->w_zipcode}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">User Request / Department / Position</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->first_name}} {{$dataOutbound->last_name}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->department}}" readonly>
                        </div>
                        <div>
                            <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->position}}" readonly/>
                            <input id="company" name="company"
                            class="company form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" 
                            value="{{$dataOutbound->id_company}}" readonly hidden/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Reff # / Courier Name / Vehicle #</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->reff}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->courier_name}}" readonly>
                        </div>
                        <div>
                            <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataOutbound->vehicle}}" readonly/>
                            <input id="company" name="company"
                            class="company form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" 
                            value="{{$dataOutbound->id_company}}" readonly hidden/>
                        </div>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id"> List Outbound Inventory
                    </label>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Inventory Code</th>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Qty</th>
                                <th class="text-sm text-center">Unit</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks1">Remarks</label>
                    <textarea id="remarks1" name="remarks1"
                        class="remarks1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
                </div>
                <center>
                        <input type="submit" value="Approved" name="status" class="w-80 text-lg bg-green-500 hover:bg-green-600 text-white mt-3" />
                        <input type="submit" value="Denied" name="status" class="w-80 text-lg bg-red-400 border-slate-200 hover:bg-red-500 text-white mt-3" />
                        {{-- <input type="submit" value="Return to Draft" name="status" class="w-80 text-lg bg-yellow-400 border-slate-200 hover:bg-yellow-500 text-white mt-3" /> --}}
                </center>
            </form>
    </div>

    @section('js-page')
    <script>
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
        const dataProducts = <?=$dataOutboundItem?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {

            const prods = <?=$dataOutboundItem?>;

            tableRow += `<tr id=row1-productIdx>
                            <td>${value.idassets}</td>
                            <td>${value.name}</td>
                            <td class="text-right">${newDivider1(value.qty)}</td>
                            <td class="text-center">${value.unit}</td>
                                        </tr>`;
        }
        tableRow += `<tr>
                    <td class="text-center font-bold text-lg" colspan="2">Total</td>
                    <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">{{number_format($dataOutbound->grandTotal, 0, '.', '.')}}</span></td>
                    <td></td>
                </tr>`;
        $(".tableProductAddBody").find('tbody').append(tableRow);

        document.getElementById('approvalForm').addEventListener('submit', function(event) {
            var remarks = document.getElementById('remarks1').value.trim();
            var status = document.activeElement.value;

            if ((status === 'Denied') && (remarks === '' || remarks.toLowerCase() === 'null')) {
                alert('Remarks must Fill if "Denied"');
                event.preventDefault();
            }
        });
    </script>
    @endsection
</x-app-layout>