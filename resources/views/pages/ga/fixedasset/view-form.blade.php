<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">View M. Input Fixed Asset 📝</h1>
        </div>
        @if ($dataForm->invoice_pdf != null)
            <div class="px-5 py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('fixedasset.file', ['idForm' => $dataForm->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Invoice</a>
                </div>
            </div>
        @endif
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
            <div class="flex justify-between flex-col md:flex-row mt-3">
                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                    for="invoice_number">Invoice Number
                </label>
                    <input id="invoice_number" name="invoice_number"
                    class="invoice_number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    value="{{$dataForm->invoice_number}}" readonly/>
            </div>
            <div class="flex justify-between flex-col md:flex-row mt-3">
                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                    for="waddress">Warehouse Address
                </label>
                <textarea id="waddress" name="waddress"
                class="waddress form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" readonly>{{$dataForm->w_address}}</textarea>
            </div>
            
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">M. Input Detail
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
                            @foreach ($dataFormDetail as $item)
                            <tr>
                                <td class="text-sm text-center">{{$item->idnfa}}</td>
                                <td class="text-sm text-center">{{$item->idassets}}</td>
                                <td class="text-sm">{{$item->assetName}}</td>
                                <td class="text-sm text-right">{{number_format($item->qty, 0, ',', '.')}}</td>
                                <td class="text-sm text-center">{{$dataForm->currency}}</td>
                                <td class="text-sm text-right">{{number_format($item->price, 0, ',', '.')}}</td>
                                <td class="text-sm text-right">{{number_format($item->total, 0, ',', '.')}}</td>
                                @if ($item->detail == null || $item->detail == 'null')
                                <td></td>
                                @else
                                <td class="text-sm">{{$item->detail}}</td>
                                @endif
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
                                                                            <th class="text-sm text-center">SNFA #</th>
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
                                                                            @if ($assetDetail->detail == null || $assetDetail->detail == 'null')
                                                                            <td></td>
                                                                            @else
                                                                            <td class="text-left">{{ $assetDetail->detail }}</td>
                                                                            @endif
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
                            </tr>
                        </tbody>
                    </table>
                </div>
    </div>

    @section('js-page')
    <script>
    </script>
    @endsection
</x-app-layout>