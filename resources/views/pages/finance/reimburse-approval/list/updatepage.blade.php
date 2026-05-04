<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit Reimburse 📝</h1>
        </div>
        @if ($dataRR->reimburse_file != null)
        <div class="py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <a href="{{ route('reimburse-list.viewfile', ['idRR' => $dataRR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Reimburse</a>
            </div>
        </div>
        @endif
        <form action="{{ route('reimburse-list.update', ['idRR' => $dataRR->idrec]) }}" method="post" enctype="multipart/form-data">
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
                            <select id="currency" name="currency" style="width: 21.2rem;"
                            class="currency form-select w-full px-2 py-1" required>
                            <option selected hidden value="">Select Currency</option>
                            @foreach ( $dataCurrency as $cur )
                            <option value="{{$cur->symbol}}" {{$cur->symbol == $dataRR->currency ? 'selected':''}}>{{$cur->symbol}}</option>
                            @endforeach
                        </select>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Payment To Beneficiary By / Beneficiary Account / Beneficiary Name</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <select id="bank" name="bank" class="bank form-select w-full px-2 py-1" type="text" required>
                                <option value="" hidden>Select Bank</option>
                                @foreach ($bank as $bankir )
                                    <option value="{{$bankir->id_bank}}" {{$bankir->id_bank == $dataRR->bank_account ? 'selected':''}}>{{$bankir->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="number" name="number" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRR->number_account}}" maxlength="20"/>
                        </div>
                        <div>
                            <input id="account" name="account" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRR->name_account}}"/>
                        </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file45">Upload New Attachment</label>
                    <input id="file45" name="file45" class="file45 form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                    <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">File max size 12MB</div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Notes</label>
                    <textarea rows="3" id="notes" name="notes" class="notes form-input w-full px-2 py-1">{{$dataRR->note}}</textarea>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Reimburse Detail</label>
                </div>
                <table class="table table-striped table-bordered mt-2 mb-2" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-sm text-center">Date</th>
                            <th class="text-sm text-center">Reimburse Type</th>
                            <th class="text-sm text-center">Vehicle Number</th>
                            <th class="text-sm text-center">Reimburse Description</th>
                            <th class="text-sm text-center">Subtotal</th>
                            <th class="text-sm text-center">VAT Type</th>
                            <th class="text-sm text-center">VAT</th>
                            <th class="text-sm text-center">WHT Type</th>
                            <th class="text-sm text-center">WHT</th>
                            <th class="text-sm text-center">Reimburse Total</th>
                            <th class="text-sm text-center">Remarks</th>
                            <th class="text-sm text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="tableProductAddBody" id="tableProductAddBody">
                    </tbody>
                </table>
                <div class="flex flex-row mt-3" hidden>
                    <label class="block w-full md:w-3/4 text-sm font-medium mb-1" for="grandtotal">Grand Total Reimburse</label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200 text-right"
                        type="text" value="{{number_format($dataRR->gtotal, 0, ',', '.')}}"readonly />
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200 text-right"
                        type="text" value="{{number_format($dataRR->gtotal, 0, '', '')}}"readonly />
                    <input id="subtotal1" value="{{number_format($dataRR->subtotal, 0, '', '')}}" name="subtotal1" class="subtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                    <input id="total1" value="{{number_format($dataRR->total, 0, '', '')}}" name="total1" class="total1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                    <input id="gtotal_vat" value="{{number_format($dataRR->total_vat, 0, '', '')}}" name="gtotal_vat" class="gtotal_vat form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                    <input id="gtotal_wht" value="{{number_format($dataRR->total_wht, 0, '', '')}}" name="gtotal_wht" class="gtotal_wht form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                </div>

                @if ($dataRR->approvalstat == "Draft")
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Save Reimburse Request</span>
                </button> </center>
                @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $('#bank').select2();
        let grandTotal = parseFloat($('#grandtotal1').val()) || 0;
        let substotal = parseFloat($('#subtotal1').val()) || 0;
        let totals = parseFloat($('#total1').val()) || 0;
        let gtotal_vat = parseFloat($('#gtotal_vat').val()) || 0;
        let gtotal_wht = parseFloat($('#gtotal_wht').val()) || 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$RRDetail?>;
        let tableRow = '';
        
        for (const value of dataProducts) {
            // var iden = makeid(3);
            var iden = dataProducts.indexOf(value);

            const prods = <?= json_encode($RRDetail) ?>;
            var modal_content = '';
            $(document).on('change', `[id^="vat_"]`, function (e) {
                const iden = this.id.split('_')[1];
                vatName(this, iden);
                vatPercent(this, iden);
                calculateVAT(iden);
                calculateSubtotal(iden);
                calculateGrandTotal(iden);
            });
            $(document).on('change', `[id^="wht_"]`, function (e) {
                const iden = this.id.split('_')[1];
                whtName(this, iden);
                whtPercent(this, iden);
                calculateWHT(iden);
                calculateGrandTotal(iden);
            });
            function vatName(ths, iden) {
                const vatName1 = $(`#vat_${iden} option:selected`).text(); // Mengambil teks opsi terpilih
                $(`#vatName_${iden}`).val(vatName1);
            }
            function vatPercent(ths, iden) {
                const vatPercent1 = $(`#vat_${iden}`).val(); // Mengambil teks opsi terpilih
                $(`#vatpercent_${iden}`).val(vatPercent1);
            }
            function whtName(ths, iden) {
                const whtName1 = $(`#wht_${iden} option:selected`).text(); // Mengambil teks opsi terpilih
                $(`#whtName_${iden}`).val(whtName1);
            }
            function whtPercent(ths, iden) {
                const whtId = $(ths).val(); // Mengambil nilai ID WHT yang dipilih
                const selectedWht = <?= json_encode($dataWht); ?>.find(wht => wht.id_wht == whtId); // Mencari WHT yang sesuai dengan ID yang dipilih
                if (selectedWht) {
                    const whtRate = selectedWht.rate; // Mengambil nilai rate dari WHT yang dipilih
                    $(`#wht_percent_${iden}`).val(whtRate); // Setel nilai wht_percent dengan nilai rate yang sesuai
                    const normaValue = selectedWht.norma; // Mengambil nilai norma dari WHT yang dipilih
                    $(`#norma_${iden}`).val(normaValue); // Setel nilai norma dengan nilai norma yang sesuai
                } else {
                    $(`#wht_percent_${iden}`).val(''); // Kosongkan nilai jika tidak ada WHT yang sesuai
                    $(`#norma_${iden}`).val(''); // Kosongkan nilai norma jika tidak ada WHT yang sesuai
                }
            }
            function calculateVAT(iden) {
                const vatPercent = parseFloat($(`#vatpercent_${iden}`).val()) || 0;
                const subtotal = parseFloat($(`#subtotal_${iden}`).val()) || 0;
                const totalVAT = Math.floor(subtotal * (vatPercent / 100));
                $(`#totalvat_${iden}`).val(divider(totalVAT));
            }

            function calculateSubtotal(iden) {
                const subtotal = parseFloat($(`#subtotal_${iden}`).val().replace(/\./g, '')) || 0;
                const totalVAT = parseFloat($(`#totalvat_${iden}`).val().replace(/\./g, '')) || 0;
                const subtotals = subtotal + totalVAT;
                $(`#total_${iden}`).val(divider(subtotals));
            }

            function calculateWHT(iden) {
                const subtotal = parseFloat($(`#subtotal_${iden}`).val().replace(/\./g, '')) || 0;
                const normaPercent = parseFloat($(`#norma_${iden}`).val()) || 0;
                const whtPercent = parseFloat($(`#wht_percent_${iden}`).val()) || 0;
                const totalWHT = Math.floor((subtotal * (normaPercent / 100)) * (whtPercent / 100)); // Memperbarui dengan Math.floor()
                $(`#total_wht_${iden}`).val(divider(totalWHT)); // Tidak perlu menggunakan toFixed() untuk mempertahankan angka bulat
            }

            function calculateGrandTotal(iden) {
                const total = parseFloat($(`#total_${iden}`).val().replace(/\./g, '')) || 0;
                const totalWHT = parseFloat($(`#total_wht_${iden}`).val().replace(/\./g, '')) || 0;
                const grandTotal = total - totalWHT;
                $(`#gtotal_${iden}`).val(divider(grandTotal));
            }
            $(document).on('input', `[id^="vatpercent_"], [id^="subtotal_"], [id^="total_"]`, function(e) {
                const iden = this.id.split('_')[1];
                calculateVAT(iden);
                calculateSubtotal(iden);
                calculateGrandTotal(iden);
            });
            $(document).on('input', `[id^="wht_percent_"], [id^="norma_"], [id^="subtotal_"]`, function (e) {
                const iden = this.id.split('_')[1];
                calculateWHT(iden);
                calculateGrandTotal(iden);
            });

            $(document).on('change', `[id^="vatType_"]`, function (e) {
                const iden = this.id.split('_')[1];
                const vatType = $(this).val();
                const subtotalis = $(`#subtotal_${iden}`).val();
                const whtType = $(`#whtType_${iden}`).val();
                const total = parseFloat($(`#total_${iden}`).val().replace(/\./g, '')) || 0;
                const totalWHT = parseFloat($(`#total_wht_${iden}`).val().replace(/\./g, '')) || 0;
                const grandTotal1 = total - totalWHT;

                if (vatType == 'N/A') {
                    $(`#vatt_${iden}`).attr("hidden", true);
                    $(`#vatt_percent_${iden}`).attr("hidden", true);
                    $(`#total_vatt_${iden}`).attr("hidden", true);
                    $(`#vatName_${iden}`).attr("hidden", true);
                    $(`#vatpercent_${iden}`).val('0');
                    $(`#totalvat_${iden}`).val('0');
                    $(`#vatName_${iden}`).val('');
                    $(`#gtotal_${iden}`).val(divider(grandTotal1));
                    $(`#total_${iden}`).val(subtotalis);
                    $(`#total_${iden}`).attr("readonly", true);
                    $(`#gtotal_${iden}`).attr("readonly", true);
                    $(`#totalvat_${iden}`).attr("readonly", false);
                    $(`#vatpercent_${iden}`).attr("readonly", false);
                }else if(vatType == 'Manual') {
                    $(`#vatt_${iden}`).attr("hidden", false);
                    $(`#vatt_percent_${iden}`).attr("hidden", false);
                    $(`#total_vatt_${iden}`).attr("hidden", false);
                    $(`#totalvat_${iden}`).attr("readonly", false);
                    $(`#vatName_${iden}`).attr("hidden", false);
                    $(`#vat_${iden}`).attr("hidden", true);
                    $(`#vatpercent_${iden}`).attr("readonly", false);
                    $(`#total_${iden}`).attr("readonly", false);
                    $(`#gtotal_${iden}`).attr("readonly", false);
                    $(`#gtotal_${iden}`).val(divider(grandTotal1));
                }else if(vatType == 'DB') {
                    $(`#vatt_${iden}`).attr("hidden", false);
                    $(`#vatt_percent_${iden}`).attr("hidden", false);
                    $(`#total_vatt_${iden}`).attr("hidden", false);
                    $(`#vatName_${iden}`).attr("hidden", true);
                    $(`#vat_${iden}`).attr("hidden", false);
                    $(`#totalvat_${iden}`).attr("readonly", true);
                    $(`#vatpercent_${iden}`).attr("readonly", true);
                    $(`#total_${iden}`).attr("readonly", true);
                    $(`#gtotal_${iden}`).attr("readonly", true);
                    $(`#gtotal_${iden}`).val(divider(grandTotal1));
                }
            });
            $(document).on('change', `[id^="whtType_"]`, function (e) {
                const iden = this.id.split('_')[1];
                const whtType = $(this).val();
                const subtotaliss = $(`#subtotal_${iden}`).val();
                const totalis = $(`#total_${iden}`).val();
                if (whtType == 'N/A') {
                    $(`#whtt_${iden}`).attr("hidden", true);
                    $(`#whtt_percent_${iden}`).attr("hidden", true);
                    $(`#total_whtt_${iden}`).attr("hidden", true);
                    $(`#normaa_${iden}`).attr("hidden", true);
                    $(`#norma_${iden}`).val('0');
                    $(`#wht_percent_${iden}`).val('0');
                    $(`#total_wht_${iden}`).val('0');
                    $(`#whtName_${iden}`).attr("hidden", true);
                    $(`#whtName_${iden}`).val('');
                    $(`#gtotal_${iden}`).val(totalis);
                    $(`#total_${iden}`).attr("readonly", true);
                    $(`#gtotal_${iden}`).attr("readonly", true);
                }else if(whtType == 'Manual') {
                    $(`#whtt_${iden}`).attr("hidden", false);
                    $(`#whtt_percent_${iden}`).attr("hidden", false);
                    $(`#total_whtt_${iden}`).attr("hidden", false);
                    $(`#total_wht_${iden}`).attr("readonly", false);
                    $(`#whtName_${iden}`).attr("hidden", false);
                    $(`#wht_${iden}`).attr("hidden", true);
                    $(`#normaa_${iden}`).attr("hidden", false);
                    $(`#norma_${iden}`).attr("readonly", false);
                    $(`#wht_percent_${iden}`).attr("readonly", false);
                    $(`#total_${iden}`).attr("readonly", false);
                    $(`#gtotal_${iden}`).attr("readonly", false);
                }else if(whtType == 'DB') {
                    $(`#whtt_${iden}`).attr("hidden", false);
                    $(`#whtt_percent_${iden}`).attr("hidden", false);
                    $(`#total_whtt_${iden}`).attr("hidden", false);
                    $(`#whtName_${iden}`).attr("hidden", true);
                    $(`#wht_${iden}`).attr("hidden", false);
                    $(`#normaa_${iden}`).attr("hidden", false);
                    $(`#total_wht_${iden}`).attr("readonly", true);
                    $(`#norma_${iden}`).attr("readonly", true);
                    $(`#wht_percent_${iden}`).attr("readonly", true);
                    $(`#total_${iden}`).attr("readonly", true);
                    $(`#gtotal_${iden}`).attr("readonly", true);
                }
            });
            $.each(prods, function (i,item1) {
                if(value.id == item1.id){
                        modal_content += `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="price">Vehicle Number
                                                </label>
                                                <input id="plate2_${iden}" name="plate2"
                                                    class="plate2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${textToInputFormat(value.no_vehicle === 'null' ? '' : (value.no_vehicle || ''))}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="reimburse">Description
                                                </label>
                                                <textarea name="reimburse2" id="reimburse2_${iden}" class="reimburse2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3">${value.reimburse_to}</textarea>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="subtotal">Subtotal
                                                </label>
                                                <input id="subtotal_${iden}" name="subtotal"
                                                    class="subtotal cc-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="number" value="${newDivider2(value.subtotal)}"/>
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <label class="text-sm font-medium mb-1 mt-1" for="vatType">VAT/Rate/Total</label>
                                                <div class="mb-3" style="width: 8rem; margin-left: 14.3rem;">
                                                    <select id="vatType_${iden}" name="vatType" class="vatType form-select px-2 py-1">
                                                        <option value="N/A">N/A</option>
                                                        <option value="DB" selected>DB</option>
                                                        <option value="Manual">Manual</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3" id="vatt_${iden}" style="text-indent: 29px;">
                                                    <select id="vat_${iden}" name="vat" style="width: 23rem;" class="vat form-input w-full px-2 py-1">
                                                            <option value="" selected hidden>Select VAT</option>
                                                        @foreach ( $dataVat as $vat)
                                                            <option value="{{$vat->rate}}">{{$vat->name_vat}} {{$vat->rate}}%</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" id="vatName_${iden}" name="vatName" style="width: 20rem; margin-left: 30px;" class="vatName form-input w-full px-2 py-1 ml-3" onchange="vatName(ths)" value="${textToInputFormat(value.vat === 'null' ? '' : (value.vat || ''))}" hidden/>
                                                </div>
                                                <div class="mb-3" id="vatt_percent_${iden}">
                                                    <input type="number" id="vatpercent_${iden}" name="vatpercent_${iden}" style="width: 15rem; margin-left: 10px;" class="total_vat w-full md:w-3/4 px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${newDivider1(value.vat_percent)}" readonly/>
                                                </div>
                                                <div class="mb-3" id="total_vatt_${iden}">
                                                    <input type="text" id="totalvat_${iden}" name="totalvat_${iden}" style="width: 12rem;" class="total_wht px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${newDivider1(value.total_vat)}" readonly/>
                                                </div>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="total">Total
                                                </label>
                                                <input id="total_${iden}" name="total"
                                                class="total form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                type="text" value="${newDivider1(value.total)}"/>
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <label class="text-sm font-medium mb-1 mt-1" for="whtType">WHT/Rate/Total</label>
                                                <div class="mb-3" style="width: 8rem; margin-left: 13.9rem; margin-right: 10px;">
                                                    <select id="whtType_${iden}" name="whtType" class="whtType form-input w-full px-2 py-1">
                                                        <option value="N/A">N/A</option>
                                                        <option value="DB">DB</option>
                                                        <option value="Manual" selected>Manual</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3" id="whtt_${iden}">
                                                    <select id="wht_${iden}" name="wht" style="width: 15rem;" class="wht form-input w-full px-2 py-1 ml-3" hidden>
                                                            <option value="" selected hidden>Select WHT</option>
                                                        @foreach ( $dataWht as $wht)
                                                            <option value="{{$wht->id_wht}}">{{$wht->name_wht}} {{$wht->rate}}%</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" id="whtName_${iden}" name="whtName" style="width: 15rem;" class="whtName w-full px-2 py-1 form-input ml-3" onchange="whtName(ths)" value="${textToInputFormat(value.wht === 'null' ? '' : (value.wht || ''))}"/>
                                                </div>
                                                <div class="mb-3" id="whtt_percent_${iden}">
                                                    <input type="number" id="wht_percent_${iden}" name="wht_percent" style="width: 12rem;" class="wht_percent px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${newDivider1(value.wht_percent)}"/>
                                                </div>
                                                <div class="mb-3" id="normaa_${iden}">
                                                    <input type="number" id="norma_${iden}" name="norma" style="width: 12rem;" class="norma px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${newDivider1(value.norma)}"/>
                                                </div>
                                                <div class="mb-3" id="total_whtt_${iden}">
                                                    <input type="text" id="total_wht_${iden}" name="total_wht" style="width: 12rem;" class="total_wht px-2 py-1 form-input read-only:bg-slate-200 ml-3" value="${newDivider1(value.total_wht)}"/>
                                                </div>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="gtotal">Reimburse Total</label>
                                                <input id="gtotal_${iden}" name="gtotal" class="gtotal form-input numeric-input md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="${newDivider1(value.paid_total)}" type="text"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="remarks">Remarks
                                                </label>
                                                <input id="remarks2_${iden}" name="remarks"
                                                    class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${textToInputFormat(value.remarks === 'null' ? '' : (value.remarks || ''))}"/>
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
            })

            tableRow += `<tr id=row-${iden}>
                <td class="text-center"><input type="text" name="idrecss_${iden}" value="${value.id}" hidden/><input type="text" name="iden[]" value="${iden}" hidden/>${value.date}</td>
                            <td>${value.reimburse_type}<input type="text" name="date_${iden}" id="date_${iden}" value="${value.date}" hidden/><input type="text" name="types_${iden}" id="types_${iden}" value="${value.type}" hidden/></td>
                            <td class="text-xs text-center"><input type="text" name="plate_${iden}" id="plate_${iden}" value="${value.no_vehicle}" hidden/><span id="plate-text_${iden}">${value.no_vehicle === 'null' ? '' : (value.no_vehicle || '')}</span></td>
                            <td class="text-xs"><textarea type="text" name="reimburse_${iden}" id="reimburse_${iden}" hidden>${value.reimburse_to}</textarea><span id="reimburse-text_${iden}">${value.reimburse_to}</span></td>
                            <td class="text-xs text-right"><input type="text" name="subtotal1_${iden}" id="subtotal1_${iden}" value="${newDivider2(value.subtotal)}" hidden/><span id="subtotal1-text_${iden}">${newDivider1(value.subtotal)}</span><input type="text" name="total1_${iden}" id="total1_${iden}" value="${newDivider2(value.total)}" hidden/></td>
                            <td><textarea name="vat_type_${iden}" id="vat_type_${iden}" hidden>${value.vat}</textarea><span id="vat_type-text_${iden}">${value.vat === 'null' ? '' : (value.vat || '')}</span></span><input type="text" name="vat_percent1_${iden}" id="vat_percent1_${iden}" value="${newDivider2(value.vat_percent)}" hidden/></td>
                            <td class="text-xs text-right"><input type="text" name="total_vat1_${iden}" id="total_vat1_${iden}" value="${newDivider2(value.total_vat)}" hidden/><span id="total_vat1-text_${iden}">${newDivider1(value.total_vat)}</span></td>
                            <td class="text-xs"><textarea name="wht_type_${iden}" id="wht_type_${iden}" hidden>${value.wht}</textarea><span id="wht_type-text_${iden}">${value.wht === 'null' ? '' : (value.wht || '')}</span></span><input type="text" name="wht_percent1_${iden}" id="wht_percent1_${iden}" value="${newDivider2(value.wht_percent)}" hidden/></td>
                            <td class="text-xs text-right"><input type="text" name="total_wht1_${iden}" id="total_wht1_${iden}" value="${newDivider2(value.total_wht)}" hidden/><span id="total_wht1-text_${iden}">${newDivider1(value.total_wht)}</span><input type="text" name="norma1_${iden}" id="norma1_${iden}" value="${newDivider2(value.norma)}" hidden/></td>
                            <td class="text-xs text-right"><input type="text" name="paid_total_${iden}" id="paid_total_${iden}" value="${newDivider2(value.paid_total)}" hidden/><span id="paid_total-text_${iden}">${newDivider1(value.paid_total)}</span></td>
                            <td class="text-xs"><textarea type="text" name="remarks231_${iden}" id="remarks231_${iden}" hidden>${value.remarks}</textarea><textarea type="text" name="remarks1_${iden}" id="remarks1_${iden}" hidden>${value.remarks}</textarea><span id="remarks1-text_${iden}">${value.remarks === 'null' ? '' : (value.remarks || '')}</span><textarea name="status_${iden}" id="status_${iden}" hidden>${value.status}</textarea></td>
                            <td class="text-xs flex flex-row justify-center" style="display: flex; justify-content: center;">
                <button type="button" onclick="deleteDataProduct('${iden}', ${value.paid_total}, ${value.subtotal}, ${value.total}, ${value.total_vat}, ${value.total_wht}, ${value.id})" class="btn btn-delete border-slate-200 hover:border-slate-300" > <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/></svg></button>                
                    <div x-data="{ modalOpen: false }">
                                <button class="ml-2 btn bg-emerald-500 hover:bg-emerald-600 text-white" type="button"
                                @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>pen</title><g stroke-width="1" stroke-linecap="round" fill="none" stroke="#ffff" stroke-miterlimit="10" class="nc-icon-wrapper" stroke-linejoin="round"><line x1="10" y1="3" x2="13" y2="6" data-cap="butt" stroke="#ffff"></line> <polygon points="12,1 15,4 5,14 1,15 2,11 " data-cap="butt"></polygon> </g></svg>
                                    <span></span>
                                </button>
                                <!-- Modal backdrop -->
                                <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                    x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-out duration-100"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    aria-hidden="true" x-cloak></div>
                                <!-- Modal dialog -->
                                <div id="feedback-modal"
                                    class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                    role="dialog" aria-modal="true" x-show="modalOpen"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in-out duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-4" x-cloak>

                                    <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
                                        @click.outside="modalOpen = false"
                                        @keydown.escape.window="modalOpen = false">
                                        <!-- Modal header -->
                                        <div class="px-5 py-3 border-b border-slate-200">
                                            <div class="flex justify-between items-center">
                                                <div class="font-semibold text-sm text-slate-800">Edit Reimburse Detail</div>
                                                <button type="button" class="text-slate-400 hover:text-slate-500"
                                                    @click="modalOpen = false">
                                                    <div class="sr-only">Close</div>
                                                    <svg class="w-4 h-4 fill-current">
                                                        <path
                                                            d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Modal content -->
                                        `+modal_content+`
                                    </div>
                                </div>
                    </div>
                </td>
           </tr>`;
        }
        $("#tableProductAddBody").append(tableRow);
        var grandTotalRow = `<tr class="grandTotalRow">
                            <td class="text-center font-bold text-sm" colspan="6">Grand Total Reimburse</td>
                            <td class="text-right font-bold text-sm" id="vatTotal_text">{{number_format($dataRR->total_vat, 0, ',', '.')}}</td>
                            <td></td>
                            <td class="text-right font-bold text-sm" id="whtTotal_text">{{number_format($dataRR->total_wht, 0, ',', '.')}}</td>
                            <td class="text-right font-bold text-sm" id="grandTotal_text">{{number_format($dataRR->gtotal, 0, ',', '.')}}</td>
                            <td></td>
                            <td></td>
                        </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);

        function updateDataProduct(iden) {
            var remarks = $('#remarks2_'+iden).val();
            var remarksTextarea = $(`#row-${iden}`).find(`textarea[name="remarks1_${iden}"]`);
            // Update the textarea value in the current row
            remarksTextarea.val(remarks);
            $('#remarks1-text_'+iden).text(remarks);

            var reimburse = $('#reimburse2_'+iden).val();
            var reimburseTextarea = $(`#row-${iden}`).find(`textarea[name="reimburse_${iden}"]`);
            // Update the textarea value in the current row
            reimburseTextarea.val(reimburse);
            $('#reimburse-text_'+iden).text(reimburse);

            var platess = $('#plate2_'+iden).val();
            $('#plate_'+iden).val(platess);
            $('#plate-text_'+iden).text(platess);

            var vatNames = $('#vatName_'+iden).val();
            $('#vat_type_'+iden).val(vatNames);
            $('#vat_type-text_'+iden).text(vatNames);

            var vatPercente = $('#vatpercent_'+iden).val();
            $('#vat_percent1_'+iden).val(vatPercente);

            var whtNames = $('#whtName_'+iden).val();
            $('#wht_type_'+iden).val(whtNames);
            $('#wht_type-text_'+iden).text(whtNames);

            var whtPercente = $('#wht_percent_'+iden).val();
            $('#wht_percent1_'+iden).val(whtPercente);

            var normas = $('#norma_'+iden).val();
            $('#norma1_'+iden).val(normas);
            
            var subtotal1 = parseFloat($('#subtotal_' + iden).val().replace(/\./g, '')) || 0;
            var vatTotale = parseFloat($('#totalvat_'+iden).val().replace(/\./g, ''));
            var total1 = parseFloat($('#total_' + iden).val().replace(/\./g, '')) || 0;
            var whtTotale = parseFloat($('#total_wht_'+iden).val().replace(/\./g, ''));
            var gtotal1 = parseFloat($('#gtotal_' + iden).val().replace(/\./g, '')) || 0;

            var moq = parseFloat($('#minimum_quantity_order2_' + iden).val()) || 0;
            var previousSubtotal = parseFloat($('#subtotal1_' + iden).val()) || 0;
            var previousVat = parseFloat($('#total_vat1_' + iden).val()) || 0;
            var previousTotal = parseFloat($('#total1_' + iden).val()) || 0;
            var previousWht = parseFloat($('#total_wht1_' + iden).val()) || 0;
            var previousGtotal = parseFloat($('#paid_total_' + iden).val()) || 0;

            var subtotalDifference = subtotal1 - previousSubtotal;
            var vatDifference = vatTotale - previousVat;
            var totalDifference = total1 - previousTotal;
            var whtDifference = whtTotale - previousWht;
            var gtotalDifference = gtotal1 - previousGtotal;


            substotal += subtotalDifference;
            gtotal_vat += vatDifference;
            totals += totalDifference;
            gtotal_wht += whtDifference;
            grandTotal += gtotalDifference;


            $('#grandtotal').val(newDivider1(grandTotal));
            $('#grandtotal1').val(grandTotal);
            $('#subtotal1').val(substotal);
            $('#gtotal_vat').val(gtotal_vat);
            $('#total1').val(totals);
            $('#gtotal_wht').val(gtotal_wht);
            updateGrandTotal();
            
            $('#subtotal1_' + iden).val(subtotal1);
            $('#subtotal1-text_' + iden).text(newDivider1(subtotal1));
            $('#total_vat1_'+iden).val(vatTotale);
            $('#total_vat1-text_'+iden).text(newDivider1(vatTotale));
            $('#total1_' + iden).val(total1);
            $('#total_wht1_'+iden).val(whtTotale);
            $('#total_wht1-text_'+iden).text(newDivider1(whtTotale));
            $('#total1-text_' + iden).text(newDivider1(total1));
            $('#paid_total_' + iden).val(gtotal1);
            $('#paid_total-text_' + iden).text(newDivider1(gtotal1));

            console.log(iden, gtotal1, grandTotal);
        }
        
        function deleteDataProduct(positionTableRow, paid_total, subtotal, total, total_vat, total_wht, dataFromDatabase) {
            const positionTableRowVariable = positionTableRow;
            const dataFromDatabaseVariable = dataFromDatabase;
            const csrf_token = $('meta[name="csrf-token"]').attr('content');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Want to Delete this Reimburse Detail!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                                const $rowToDelete = $(`#tableProductAddBody tr#row-${positionTableRowVariable}`);
                                $rowToDelete.remove();
                                handleDeleteRow(positionTableRowVariable, paid_total, subtotal, total, total_vat, total_wht);
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Reimburse Detail has been Deleted.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                                // $.ajax({
                                //     type: 'DELETE',
                                //     url: `/ga/reimburse-approval/list/deleteitem/${dataFromDatabaseVariable}`,
                                //     success: function (response) {
                                //         const { status, message } = response;
                                //         if (status == 1) {
                                //             Swal.fire('Deleted!', 'Reimburse Detail has been Deleted.', message);
                                //             handleDeleteRow(positionTableRowVariable, paid_total, subtotal, total, total_vat, total_wht);
                                //         }
                                //     },
                                //     error: function (data) {
                                //         console.error('Ajax Error:', data);
                                //     }
                                // });
                        }
                    });
        }

        function handleDeleteRow(positionTableRow, paid_total, subtotal, total, total_vat, total_wht) {
             // Remove the corresponding row using the id
            $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();
                
             // Update grandTotal if it's NaN
            substotal = isNaN(substotal) ? 0 : substotal;
            gtotal_vat = isNaN(gtotal_vat) ? 0 : gtotal_vat;
            totals = isNaN(totals) ? 0 : totals;
            gtotal_wht = isNaN(gtotal_wht) ? 0 : gtotal_wht;
            grandTotal = isNaN(grandTotal) ? 0 : grandTotal;
            // Ensure paid_total is a valid number
            const parsedSubstotal = parseFloat(subtotal) || 0;
            const parsedTotalVat = parseFloat(total_vat) || 0;
            const parsedTotals = parseFloat(total) || 0;
            const parsedTotalWht = parseFloat(total_wht) || 0;
            const parsedGtotal = parseFloat(paid_total) || 0;
             // Update grandTotal after removing the row
            substotal = Math.max(substotal - parsedSubstotal, 0);
            gtotal_vat = Math.max(gtotal_vat - parsedTotalVat, 0);
            totals = Math.max(totals - parsedTotals, 0);
            gtotal_wht = Math.max(gtotal_wht - parsedTotalWht, 0);
            grandTotal = Math.max(grandTotal - parsedGtotal, 0);
                    
            // Update the grandTotal fields
            $('#grandtotal').val(newDivider1(grandTotal));
            $('#subtotal1').val(substotal);
            $('#total1').val(totals);
            $('#gtotal_vat').val(gtotal_vat);
            $('#gtotal_wht').val(gtotal_wht);
            $('#grandtotal1').val(grandTotal);
            updateGrandTotal();
        }

        function updateGrandTotal() {
            $('#vatTotal_text').text(`${divider(gtotal_vat)}`);
            $('#vatTotal_text').val(`${divider(gtotal_vat)}`);
            $('#whtTotal_text').text(`${divider(gtotal_wht)}`);
            $('#whtTotal_text').val(`${divider(gtotal_wht)}`);
            $('#grandTotal_text').text(`${divider(grandTotal)}`);
            $('#grandTotal_text').val(`${divider(grandTotal)}`);

            $('#grandtotal').val(newDivider1(grandTotal));
            $('#subtotal1').val(substotal);
            $('#total1').val(totals);
            $('#gtotal_vat').val(gtotal_vat);
            $('#gtotal_wht').val(gtotal_wht);
            $('#grandtotal1').val(grandTotal);
        }
    </script>
    @endsection
</x-app-layout>