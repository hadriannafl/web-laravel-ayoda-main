<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit M. Input Fixed Asset 📝</h1>
        </div>
        @if ($dataForm->invoice_pdf != null)
            <div class="px-5 py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('fixedasset.file', ['idForm' => $dataForm->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Invoice</a>
                </div>
            </div>
        @endif
        <div class="px-5 py-4">
            <div class="space-y-3">
                <form method="post" enctype="multipart/form-data" id="myForm" action="{{ route('fixedasset.update', ['idForm' => $dataForm->idrec]) }}">
                    @csrf
                    <div class="flex justify-between flex-col md:flex-row mb-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Form Date</label>
                        <input id="date" name="date"
                        class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        Value="{{date('d F Y', strtotime($dataForm->form_date))}}" required readonly/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                            for="no_form">M. Input #
                        </label>
                            <input id="no_form" name="no_form"
                            class="no_form form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{$dataForm->no_form}}" readonly/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                            for="company">Company
                        </label>
                            <input id="company" name="company"
                            class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{$dataForm->company}}" readonly/>
                    </div>
                    <div class="flex flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="vendor">Select Warehouse<span
                            class="text-rose-500">*</span></label>
                        <input id="wid" name="wid"
                        class="wid form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" value="{{$dataForm->id_warehouse}}" readonly required hidden/>
                        <div x-data="{ modalOpen: false }">
                            <button type="button"
                                class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                @click.prevent="modalOpen = true">
                                <svg class="w-4 h-4" viewBox="0 0 16 16"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path class="fill-current text-slate-200"
                                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                    <path class="fill-current text-slate-200"
                                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                                </svg>
                                <span></span>
                            </button>
                            <!-- Modal backdrop -->
                            <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                x-show="modalOpen"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-out duration-100"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0" aria-hidden="true"
                                x-cloak>
                            </div>
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
                                            <div class="font-semibold text-slate-800">Select
                                                Warehouse Address</div>
                                            <button type="button"
                                                class="text-slate-400 hover:text-slate-500"
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
                                    <div class="modal-content text-xs px-5 py-4">
                                        <select id="companyTest1" name="companyTest1"
                                            class="companyTest1 form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" disabled required hidden>
                                                <option value="{{$dataForm->id_company}}" selected>{{$dataForm->company}}</option>
                                        </select>
                                        <input id="company2" name="company2"
                                        class="company2 form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                        value="{{$dataForm->company}}" readonly hidden/>
                                        <div class="table-responsive">
                                            <table id="delivery-address" class="table table-striped table-bordered text-xs" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Company</th>
                                                        <th class="text-center">Warehouse</th>
                                                        <th class="text-center">Address</th>
                                                        <th class="text-center">City</th>
                                                        <th class="text-center">Province</th>
                                                        <th class="text-center">Country</th>
                                                        <th class="text-center">Pos Code</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
    
                                        <div class="space-y-3">
                                        </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                            for="waddress">Warehouse Address
                        </label>
                        <textarea id="waddress" name="waddress"
                        class="waddress form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" readonly>{{$dataForm->w_address}}</textarea>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="currency">Currency</label>
                        <select id="currency" name="currency"
                            class="currency form-select w-full md:w-3/4 px-2 py-1">
                            @foreach ( $dataCurrency as $cur )
                            <option value="{{$cur->symbol}}"{{$dataForm->currency == $cur->symbol ? 'selected':''}}>{{$cur->symbol}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                            for="invoice_number">Invoice Number
                        </label>
                            <input id="invoice_number" name="invoice_number"
                            class="invoice_number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{$dataForm->invoice_number}}"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="invoice_pdf">Invoice PDF</label>
                        <input id="invoice_pdf" name="invoice_pdf"
                            class="invoice_pdf form-input w-full md:w-3/4 px-2 py-1"
                            type="file" accept="application/pdf"/>
                    </div>
                    
                        <div class="flex flex-row md:flex-row mb-3 mt-3">
                            <label class="block text-sm font-medium mb-1" for="task_id">FORM Fixed Asset Detail
                            </label>
                        </div>
                        <div class="flex flex-row md:flex-row">
                            <table class="tableProductAddBody table table-striped table-bordered mt-3"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-sm text-center">M. Input Detail #</th>
                                        <th class="text-sm text-center">Asset Code</th>
                                        <th class="text-sm text-center">Inventory Name</th>
                                        <th class="text-sm text-center">Quantity</th>
                                        <th class="text-sm text-center">Currency</th>
                                        <th class="text-sm text-center">Price</th> 
                                        <th class="text-sm text-center">Total</th> 
                                        <th class="text-sm text-center">Detail</th> 
                                        <th class="text-sm text-center">Action</th> 
                                    </tr>
                                </thead>
                                <tbody class="tableProductAddBody" id="tableProductAddBody">
                                    {{-- @foreach ($dataFormDetail as $item)
                                    <tr>
                                        <td class="text-sm text-center">{{$item->idnfa}}</td>
                                        <td class="text-sm text-center">{{$item->idassets}}</td>
                                        <td class="text-sm">{{$item->assetName}}</td>
                                        <td class="text-sm text-right">{{number_format($item->qty, 0, ',', '.')}}</td>
                                        <td class="text-sm text-center">{{$dataForm->currency}}</td>
                                        <td class="text-sm text-right">{{number_format($item->price, 0, ',', '.')}}</td>
                                        <td class="text-sm text-right">{{number_format($item->total, 0, ',', '.')}}</td>
                                        <td class="text-sm">{{$item->detail}}</td>
                                        <td class="text-sm text-center">
                                            @if ($dataForm->generate == 'Y')
                                            <div x-data="{ modalOpen: false }">
                                                <button type="button" class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                    @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                                    <span>View Detail</span>
                                                </button>
                                                <!-- Modal backdrop -->
                                                <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
                                                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true"
                                                    x-cloak>
                                                </div>
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
                                                        @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                                        <!-- Modal header -->
                                                        <div class="px-5 py-3 border-b border-slate-200">
                                                            <div class="flex justify-between items-center">
                                                                <div class="font-semibold text-slate-800">Fixed Asset</div>
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
                                                        <div class="modal-content text-xs px-5 py-4">
                                                            <div class="table-responsive">
                                                                    <div x-show="modalOpen">
                                                                        <table class="tableProductAddBody table table-striped table-bordered mt-3"
                                                                        style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-sm text-center">Fixed Asset Code</th>
                                                                                    <th class="text-sm text-center">Asset Code</th>
                                                                                    <th class="text-sm text-center">Inventory Name</th>
                                                                                    <th class="text-sm text-center">Detail</th>
                                                                                    <th class="text-sm text-center">Available</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($groupedAssets[$item->idassets] as $assetDetail)
                                                                                <tr>
                                                                                    <td class="text-center">{{ $assetDetail->idfa }}</td>
                                                                                    <td class="text-center">{{ $assetDetail->idassets }}</td>
                                                                                    <td class="text-left">{{ $assetDetail->assetName1 }}</td>
                                                                                    <td class="text-left">{{ $assetDetail->detail }}</td>
                                                                                    <td class="text-center">{{ $assetDetail->avail_name }}</td>
                                                                                    <!-- Add other fields you want to display -->
                                                                                </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                            </div>
                    
                                                            <div class="space-y-3">
                                                            </div>
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="px-5 py-4 border-t border-slate-200">
                                                            <div class="flex flex-wrap justify-end space-x-2">
                                                                <button type="button"
                                                                    class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                                    @click="modalOpen = false">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="grandTotalRow">
                                        <td class="text-center font-bold text-lg" colspan="3">Qty Total</td>
                                        <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">{{number_format($dataForm->qty, 0, ',', '.')}}</span></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr class="grandTotalRow1">
                                        <td class="text-center font-bold text-lg" colspan="3">Grand Total</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right font-bold text-lg" id="grandTotal_text1"><span id="grandTotal_text1">{{number_format($dataForm->gtotal, 0, ',', '.')}}</span></td>
                                        <td></td>
                                        <td></td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="flex flex-row mb-3 mt-3" hidden>
                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="totalAmount">Qty Total</label>
                            <label class="text-sm font-medium mb-1 ml-32">:</label>
                            <label class="w-36 text-sm font-medium mb-1 text-white" for="discount2idr">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                            </label>
                            <input id="qtyTotall" name="qtyTotall" class="qtyTotall form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 text-right" type="text" value="{{number_format($dataForm->qty, 0, '.', '.')}}" readonly required/>
                            <label class="md:w-1/12 text-sm font-medium text-white"></label>
                        </div>
                        <div class="flex flex-row mb-3 mt-3" hidden>
                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="totalAmount">Grand Total</label>
                            <label class="text-sm font-medium mb-1 ml-32">:</label>
                            <label class="w-36 text-sm font-medium mb-1 text-white" for="discount2idr">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                            </label>
                            <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 text-right" type="text" value="{{number_format($dataForm->gtotal, 0, '.', '.')}}" readonly required/>
                            <label class="md:w-1/12 text-sm font-medium text-white"></label>
                        </div>
                        <input id="qtyTotal" name="qtyTotal" class="qtyTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataForm->qty}}" readonly required hidden/>
                        <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataForm->gtotal}}" readonly required hidden/>
                    <img id="output1" style="max-width: 300px; max-height: 150px"/>
                    @if ($dataForm->generate == 'N')
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Edit Fixed Asset</span>
                    </button> </center>
                    @endif
                </form>
            </div>
        </div>
    </div>

    @section('js-page')
    <script>
        $('#company1').on('change', function (e) {
        const site = $('#company1').val();
        if ($('#company1').val() !== null) {
            $('#company').val(site);
            $('#company2').val(site);
            $('#delivery-address').DataTable().ajax.reload();
            $('#assetInv').DataTable().ajax.reload();
        }
    })
    $(document).ready(function () {
        $('#delivery-address').DataTable({
            responsive: true,
            processing: true,
            serverSide: false,
            stateServe: true,                
            "order": [[ 0, "asc" ]],
            language: {
                search: "Search Address:"
            },
            ajax: {
                url: "{{ route('delivery.address') }}",
                data:function(d){                    
                    d.company2 = $("#company2").val()
                }
            },
            columns: [
                {
                    data: "name",                    
                    name: "name"
                },
                {                    
                    data: "w_name",
                    name: "w_name"
                },
                {                    
                    data: "w_address",
                    name: "w_address"
                },
                {
                    data: "w_city",
                    name: "w_city"
                },
                {
                    data: "w_province",
                    name: "w_province"
                },
                {
                    data: "w_country",
                    name: "w_country"
                },
                {
                    data: "w_zipcode",
                    name: "w_zipcode"
                },
                {
                    data: "action",
                    name: "action"
                },
            ],
            columnDefs: [
                { className: 'text-center', targets: [6, 7] }
            ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
        });
    });
    $('#delivery-address').on("click", ".btn-select", function () {
        const id = $(this).data("id");
        const address = $(this).data("address");
        const city = $(this).data("city");
        const province = $(this).data("province");
        const country = $(this).data("country");
        const zip_code = $(this).data("zip_code");
        const wname = $(this).data("wname");

        $("#wid").val(id);
        $("#wname").val(wname);
        $("#waddress").val(address);
    });

    function changeProducts(iden) {
        $('#assetInv_'+iden).DataTable({
            responsive: true,
            processing: true,
            serverSide: false,
            stateServe: true,
            language: {
                search: "Search Asset Code: "
                },
            ajax: {
                url: "{{ route('fixedasset.invfixasset') }}"
            },
            columns: [
                {
                    data: "idassets",
                    name: "idassets"
                },
                {
                    data: "name",
                    name: "name"
                },
                {
                    data: "unit",
                    name: "unit"
                },
                {
                    data: "category",
                    name: "category"
                },
                {
                    data: "action",
                    name: "action"
                },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 2, 4] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
        });
        $('#assetInv_' + iden).on("click", ".btn-select", function () {
            const idAsset = $(this).data("id");
            const nameAsset = $(this).data("nama");

            // Update your form inputs with the selected values
            $('#nama_product_' + iden).val(nameAsset);
            $('#assetId_' + iden).val(idAsset);
        });
    }

    let grandTotal = parseFloat($('#grandtotal1').val()) || 0;
    let qtyTotal = parseFloat($('#qtyTotal').val()) || 0;

    function calculateGrandTotal() {
        grandTotal = 0;
        $('.tableProductAddBody tbody tr').each(function() {
            const totalas = parseFloat($(this).find('input[name^="total_"]').val()) || 0;
            grandTotal += totalas;
            // console.log(grandTotal);
        });
        updateGrandTotal();
    }
    function calculateqtyTotal() {
        qtyTotal = 0;
        $('.tableProductAddBody tbody tr').each(function() {
            const qtyTots = parseFloat($(this).find('input[name^="qty_"]').val()) || 0;
            qtyTotal += qtyTots;
            // console.log(qtyTotal);
        });
        updateGrandTotal();
    }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataFormDetail?>;
        let tableRow = '';
        
        for (const value of dataProducts) {
            // var iden = makeid(3);
            var iden = dataProducts.indexOf(value);

            const prods = <?=$dataFormDetail?>;
            var modal_content = '';

            $('.tableProductAddBody').on('input', '.rab-input', function() {
                updateTotals(this);
            });

            function updateTotals(ths) {
                const exp = $(ths).attr('id').split('_');
                let iden = '';
                if(exp.length > 1){
                    iden = exp[1];
                }
                const qty2 = parseFloat($(`#qty2_${iden}`).val()) || 0;
                const price2 = parseFloat($(`#product-price2_${iden}`).val()) || 0;
                const total2 = price2 * qty2;

                $(`#itemTotal_${iden}`).val(divider1(total2));
            }

            $.each(prods, function (i,item1) {
                if(value.idrec == item1.idrec){
                        modal_content += `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="nama_product">Asset Name<span
                                                    class="text-rose-500">*</span>
                                                </label>
                                                <input id="nama_product_${iden}" name="nama_product_${iden}"
                                                class="nama_product_${iden} form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="${value.assetName}"
                                                type="text" readonly/>
                                                <div x-data="{ modalOpen: false }">
                                                        <button type="button"
                                                        class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                        @click.prevent="modalOpen = true" onclick="changeProducts(${iden})"
                                                        aria-controls="feedback-modal">
                                                        <svg class="w-4 h-4" viewBox="0 0 16 16"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path class="fill-current text-slate-200"
                                                                d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                                            <path class="fill-current text-slate-200"
                                                                d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                                                        </svg>
                                                        <span></span>
                                                    </button>
                                                    <!-- Modal backdrop -->
                                                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                        x-show="modalOpen"
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="transition ease-out duration-100"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0" aria-hidden="true"
                                                        x-cloak>
                                                    </div>
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
                                                                    <div class="font-semibold text-slate-800">Select
                                                                        Asset</div>
                                                                    <button type="button"
                                                                        class="text-slate-400 hover:text-slate-500"
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
                                                            <div class="modal-content text-xs px-5 py-4">
                                                                <div class="table-responsive">
                                                                    <table id="assetInv_${iden}"
                                                                        class="table table-striped table-bordered text-xs"
                                                                        style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center">Asset Code</th>
                                                                                <th class="text-center">Name</th>
                                                                                <th class="text-center">Unit</th>
                                                                                <th class="text-center">Category</th>
                                                                                <th class="text-center">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>

                                                                <div class="space-y-3">
                                                                </div>
                                                            </div>
                                                            <!-- Modal footer -->
                                                            <div class="px-5 py-4 border-t border-slate-200">
                                                                <div class="flex flex-wrap justify-end space-x-2">
                                                                    <button type="button"
                                                                        class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                                        @click="modalOpen = false">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input id="assetId_${iden}" name="assetId_${iden}"
                                                    class="assetId_${iden} form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200" value="${value.idassets}"
                                                    type="text" readonly hidden/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3" id="qty2">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="qty2">qty
                                                </label>
                                                <input id="qty2_${iden}" name="qty2" class="rab-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="number" data-iden="${iden}" value="${newDivider2(value.qty)}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="product-price2">Price
                                                </label>
                                                <input id="product-price2_${iden}" name="product-price2" class="rab-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="number" data-iden="${iden}" value="${newDivider2(value.price)}"/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="itemTotal">Total
                                                </label>
                                                <input id="itemTotal_${iden}" name="itemTotal"
                                                class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                type="text" onchange="totally1(this)" value="${newDivider1(value.total)}" readonly/>
                                            </div>
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="remarks">Detail
                                                </label>
                                                <textarea id="remarks2_${iden}" name="remarks"
                                                    class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3">${value.detail === 'null' ? '' : (value.detail || '')}</textarea>
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
                            <td><input type="text" name="idrecss_${iden}" value="${value.idrec}" hidden/>${value.idnfa}<input type="text" name="idnfa_${iden}" value="${value.idnfa}" hidden/><input type="text" name="createdat_${iden}" value="${value.created_at}" hidden/><input type="text" name="createdby_${iden}" value="${value.created_by}" hidden/></td>
                            <td><input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="ids_${iden}" id="ids_${iden}" value="${value.idassets}" hidden/><span id="ids-text_${iden}">${value.idassets}</span></td>
                            <td><input type="text" name="assetName_${iden}" id="assetName_${iden}" value="${value.assetName}" hidden/><span id="assetName-text_${iden}">${value.assetName}</span></td>
                            <td class="text-right"><input type="text" name="qty_${iden}" id="qty_${iden}" value="${newDivider2(value.qty)}" hidden/><span id="qty-text_${iden}">${newDivider1(value.qty)}</span></td>
                            <td class="text-center">{{$dataForm->currency}}</td>
                            <td class="text-right"><input type="text" name="price_${iden}" id="price_${iden}" value="${newDivider2(value.price)}" hidden/><span id="price-text_${iden}">${newDivider1(value.price)}</span></td>
                            <td class="text-right"><input type="text" name="total_${iden}" id="total_${iden}" value="${newDivider2(value.total)}" hidden/><span id="total-text_${iden}">${newDivider1(value.total)}</span></td>
                            <td><textarea name="details_${iden}" id="details_${iden}" hidden>${value.detail === 'null' ? '' : (value.detail || '')}</textarea><span id="details-text_${iden}">${value.detail === 'null' ? '' : (value.detail || '')}</span><textarea name="details123_${iden}" id="details123_${iden}" hidden>${value.detail}</textarea></td>
                            <td class="flex justify-center">                
                    <div x-data="{ modalOpen: false }">
                                <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white" type="button"
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
                                                <div class="font-semibold text-slate-800">Edit M Input Fixed Asset</div>
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
        $(".tableProductAddBody").find('tbody').append(tableRow);
        var grandTotalRow = `<tr class="grandTotalRow">
                                <td class="text-center font-bold text-lg" colspan="3">Qty Total</td>
                                <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">{{number_format($dataForm->qty, 0, ',', '.')}}</span></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);
        var grandTotalRow1 = `<tr class="grandTotalRow1">
                                <td class="text-center font-bold text-lg" colspan="3">Grand Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right font-bold text-lg" id="grandTotal_text1"><span id="grandTotal_text1">{{number_format($dataForm->gtotal, 0, ',', '.')}}</span></td>
                                <td></td>
                                <td></td>
                            </tr>`;
        $("#tableProductAddBody").append(grandTotalRow1);

        function updateGrandTotal() {
            $('#grandTotal_text').text(`${divider(qtyTotal)}`);
            $('#grandTotal_text').val(`${divider(qtyTotal)}`);
            $('#grandTotal_text1').text(`${divider(grandTotal)}`);
            $('#grandTotal_text1').val(`${divider(grandTotal)}`);
        }

        function updateDataProduct(iden) {
            var remarks = $('#remarks2_'+iden).val();
            var remarksTextarea = $(`#row-${iden}`).find(`textarea[name="details_${iden}"]`);
            
            var nameAssets2 = $('#nama_product_' + iden).val();
            var idassets2 = $('#assetId_' + iden).val();
            var qty = parseFloat($('#qty2_' + iden).val()) || 0;
            var price = parseFloat($('#product-price2_' + iden).val()) || 0;
            var total = parseFloat(price*qty) || 0;
            // var moq = parseFloat($('#minimum_quantity_order2_' + iden).val()) || 0;

            // var previousQty = parseFloat($('#qty_' + iden).val()) || 0;
            // var previousPrice = parseFloat($('#price_' + iden).val()) || 0;
            // var previousTotal = parseFloat($('#total_' + iden).val()) || 0;

            $('#qty_' + iden).val(qty);
            $('#total_' + iden).val(total);

            // var idExists = false;

            // $('#tableProductAddBody tr').not(`#row-${iden}`).each(function () {
            //     var existingIdElement = $(this).find('[name^="ids_"]');
            //     if (existingIdElement.length > 0) {
            //         var existingId = existingIdElement.val();

            //         if (idassets2 == existingId) {
            //             idExists = true;
            //             return false; // Exit the loop if the idassets is found
            //         }
            //     }
            // });

            // if (idExists) {
            //     alert('Same Inventory Asset cannot be added again.');
            //     var qtyDifference = 0;
            //     var totalDifference = 0;
            //     qtyTotal += 0;
            //     grandTotal += 0;
            //     return false;
            // }else {
                // var qtyDifference = qty - previousQty;
                // var totalDifference = total - previousTotal;
                 // Update grandTotal with the price difference
                // qtyTotal += qtyDifference;
                // grandTotal += totalDifference;
                // Update nilai pada input #grandtotal

                calculateGrandTotal();
                calculateqtyTotal();
                updateGrandTotal();
                
                $('#assetName_' + iden).val(nameAssets2);
                $('#assetName-text_' + iden).text(nameAssets2);
                $('#ids_' + iden).val(idassets2);
                $('#ids-text_' + iden).text(idassets2);
                $('#qty_' + iden).val(qty);
                $('#qty-text_' + iden).text(newDivider1(qty));
                $('#price_' + iden).val(price);
                $('#price-text_' + iden).text(newDivider1(price));
                $('#total_' + iden).val(total);
                $('#total-text_' + iden).text(newDivider1(total));
                remarksTextarea.val(remarks);
                $('#details-text_'+iden).text(remarks);
                $('#grandtotal').val(newDivider1(grandTotal));
                $('#grandtotal1').val(grandTotal);
                $('#qtyTotall').val(newDivider1(qtyTotal));
                $('#qtyTotal').val(qtyTotal);

                // console.log(iden, qty, price, total, grandTotal, qtyTotal, remarks);
            // }
        }
    </script>
    @endsection
</x-app-layout>