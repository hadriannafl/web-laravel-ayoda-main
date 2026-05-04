<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <title>{{ $CRM_ISS->nilai }}</title>


        <!-- style -->
        <link rel="stylesheet" href="/resources/css/mystyle.css">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        
        <!-- Styles -->
        @livewireStyles
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.jqueryui.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }
            .pointer {cursor: pointer;}
        </style>
    </head>
    <body>
        @include('sweetalert::alert')

        <!-- Page wrapper -->
        <div class="flex h-screen overflow-hidden">

            <!-- Content area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden" x-ref="contentarea">

                <main>
                    <div class="mb-8">
                        <h1 class="ml-5 mt-3"><a onclick="history.back()"><img src="{{ asset('images/left-arrow.png') }}" width="100" height="50" alt="Task 01" class="pointer"></a></h1>
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold ml-5">Update Delivery Orders 📦</h1>
                    </div>
                        <div class="px-5 py-4">
                            <div class="space-y-3">
                                <div class="flex justify-between flex-col md:flex-row">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="code">Tracking Code :
                                    </label>
                                    <input id="id" name="id" class=" id form-select w-full md:w-3/4 px-2 py-1"
                                        value="{{ $viewDo->id }}" hidden />
                                    </label>
                                    <input id="code" name="code"
                                        class="code form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                        value="{{ $viewDo->code }}" readonly disabled />
                                </div>
                                <div class="flex justify-between flex-col md:flex-row">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Delivery Order Number : </label>
                                    <input id="number" name="number"
                                        class="number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                        value="{{ $viewDo->do_number }}" readonly disabled />
                                </div>
                                <div class="flex justify-between flex-col md:flex-row">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="status">Status : </label>
                                    <input id="status" name="status"
                                        class="status form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                        value="{{ $viewDo->name_status }}" readonly disabled />
                                </div>
                                <div class="flex justify-between flex-col md:flex-row">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Delivery Date : </label>
                                    <input id="date" name="date"
                                        class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                        value="{{ date('Y-m-d', strtotime($viewDo->delivery_date)) }}" readonly disabled />
                                </div>
                                <div class="flex justify-between flex-col md:flex-row">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="by">Delivery By : </label>
                                    <input id="by" name="by"
                                        class="by form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                        value="{{ $viewDo->delivery_by }}" readonly disabled />
                                </div>
                                <div class="flex justify-between flex-col md:flex-row">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Delivery Address : </label>
                                    <textarea id="notes" name="notes" class="notes form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        rows="3" readonly disabled>{{ $viewDo->delivery_address}} </textarea>
                                </div>
                                <div class="table-responsive mt-4">
                                    <label class="block text-sm font-medium mb-1" for="address">Delivery Product Items :</label>
                                    <table class="table table-striped table-bordered detail-delivery-orders"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Product Code</th>
                                                <th class="text-sm text-center">Product Name</th>
                                                <th class="text-sm text-center">Batch No</th>
                                                <th class="text-sm text-center">Qty</th>
                                                <th class="text-sm text-center">Status</th>
                                                <th class="text-sm text-center">Damaged Qty</th>
                                                <th class="text-sm text-center">Lost Qty</th>
                                                <th class="text-sm text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="detail-delivery-orders" id="detail-delivery-orders">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3 mt-3 {{$viewDo->photo1 == 1 ? 'hidden' : ''}}">
                                        <div class="${photo1 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">AWB DO :</label>
                                            <a href="{{ route('tracking.photo1', ['code' => $viewDo->code]) }}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                            @if($viewDo->photo1_name != null)
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/{{$viewDo->photo1_name}}" width="259" height="142" alt="Do Image" />
                                            @endif
                                        </div>
                                        <div></div>
                                        <div class="${photo2 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Signed By :</label>
                                            <a href="{{ route('tracking.photo2', ['code' => $viewDo->code]) }}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                            @if($viewDo->photo2_name != null)
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/{{$viewDo->photo2_name}}" width="259" height="142" alt="Do Image"/>
                                            @endif
                                        </div>
                                </div>
                                <form method="post" class="form_do_update" enctype="multipart/form-data" action="{{ route('tracking.status', ['doNumber' => $viewDo->do_number]) }}">
                                    @csrf
                                    <div class="grid md:grid-cols-3 gap-3 mt-3" {{$viewDo->photo1 == 1 ? '' : 'hidden'}}>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="file">AWB DO Upload:</label>
                                            <input name="photo1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output1-${code}')" required />
                                            <img id="output1-${code}" style="max-width: 300px; max-height: 150px"/>
                                        </div>
                                        <div></div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="file">Signed DO Upload:</label>
                                            <input name="photo2" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output2-${code}')" required />
                                            <img id="output2-${code}" style="max-width: 300px; max-height: 150px"/>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-3" {{$viewDo->photo1 == 1 ? '' : 'hidden'}}>
                                        <div></div>
                                        <div></div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="file">Status Delivery Orders:</label>
                                            <select name="doStatus" class="form-select w-full md:w-3/4 px-2 py-1" required>
                                                <option value="" hidden>Select Status</option>
                                                <option value="301">All Delivered - CONFIRMED</option>
                                                <option value="302">Partially Damage/Lost - DAMAGE/LOST</option>
                                                <option value="303">All Lost Delivery - DAMAGE/LOST</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-5" {{$viewDo->status == '301' ? 'hidden' : ''}}>
                                            <div></div>
                                            <button type="submit" name="status" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" />Save<button>
                                            <div></div>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-5">
                                            <div></div>
                                            
                                            <div></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>

            </div>

        </div>

        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            function formatDate(date){
                let d = new Date(date);
                const formattedDate = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2);
                return formattedDate;
            }

            function formatCurrency(num) {
                var num_parts = num.toString().split(".");
                num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                return 'IDR ' + num_parts.join(".");
            }
            function divider(num) {
                var num_parts = num.toString().split(".");
                num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                return ' ' + num_parts.join(".");
            }

            const loadFile = function (event) {
                const output = document.getElementById("output");
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src); // free memory
                };
            };

            const loadFileMultiple = function (event, idView) {
                const output = document.getElementById(idView);
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src); // free memory
                };
            };
        </script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
            });
            const dataProducts = <?=$dataDeliveryOrders?>;
            let tableRow = '';
            for (const value of dataProducts) {
                var iden = makeid(3);
                console.log(String(value.product_id).length);

                const prods = <?=$dataDeliveryOrders?>;
                const csrf_token = $('meta[name="csrf-token"]').attr('content');
                const doNumber = `${value.do_number}`;
                const batchNo = `${value.batch_no}`;
                var modal_content = '';
                $.each(prods, function (i,item1) {
                    if(value.do_number == item1.do_number){
                        modal_content = `
                        <form method="post" class="form_do_product" enctype="multipart/form-data" action="/check/${doNumber}/${batchNo}">
                                    <input type="hidden" name="_token" value="${csrf_token}" />
                        <div class="modal-content text-xs px-5 py-4">
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="order_quantity2">Damaged Quantity :
                                                    </label>
                                                    <input id="qty_damaged2_${iden}" name="qty_damaged2"
                                                        class="qty_damaged2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="number" value="${value.qty_damaged}"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="order_quantity2">Lost Quantity :
                                                    </label>
                                                    <input id="qty_lost2_${iden}" name="qty_lost2"
                                                        class="qty_lost2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="number" value="${value.qty_lost}"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="order_quantity2">Damaged Imaage 1 :
                                                    </label>
                                                    <input id="damaged_image1_${iden}" name="damaged_image1_${iden}" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output3-${iden}')"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row ml-72 mt-3 mb-3">
                                                    <img id="output3-${iden}" style="max-width: 300px; max-height: 150px"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="order_quantity2">Damaged Imaage 2 :
                                                    </label>
                                                    <input id="damaged_image2_${iden}" name="damaged_image2_${iden}" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output4-${iden}')"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row ml-72 mt-3 mb-3">
                                                    <img id="output4-${iden}" style="max-width: 300px; max-height: 150px"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="order_quantity2">Lost Imaage 1 :
                                                    </label>
                                                    <input id="lost_image1_${iden}" name="lost_image1_${iden}" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output5-${iden}')"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row ml-72 mt-3 mb-3">
                                                    <img id="output5-${iden}" style="max-width: 300px; max-height: 150px"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="order_quantity2">Lost Imaage 2 :
                                                    </label>
                                                    <input id="lost_image2_${iden}" name="lost_image2_${iden}" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output6-${iden}')"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row ml-72 mt-3 mb-3">
                                                    <img id="output6-${iden}" style="max-width: 300px; max-height: 150px"/>
                                                </div>

                                                <div class="space-y-3">
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="px-5 py-4 border-t border-slate-200">
                                                    <div class="flex flex-wrap justify-end space-x-2">
                                                        <button type="button"
                                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                            @click="modalOpen = false">Close</button>
                                                        <button type="submit"
                                                            class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                            @click="modalOpen = false" onclick="updateDataProduct('${iden}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>`
                    }
                    // console.log(item)
                })
                
                tableRow += `<tr id=row1-productIdx>
                                <td class="text-center"><input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="code_${iden}" value="${value.product_code}" hidden/>${value.product_code}</td>
                                <td>${value.product_name}</td>
                                <td class="text-center"><input type="text" name="batch_no_${iden}" id="batch_no_${iden}" value="${value.batch_no}" hidden/><span id="batch_no_text_${iden}">${value.batch_no}</span></td>
                                <td class="text-center">${value.qty}</td>
                                <td class="text-center">${value.status_order}</td>
                                <td class="text-center"><input type="text" name="qty_damaged_${iden}" id="qty_damaged_${iden}" value="${value.qty_damaged}" hidden/><span id="qty_damaged_text_${iden}">${value.qty_damaged}</span></td>
                                <td class="text-center"><input type="text" name="qty_lost_${iden}" id="qty_lost_${iden}" value="${value.qty_lost}" hidden/><span id="qty_lost_text_${iden}">${value.qty_lost}</span></td>
                                <td class="flex flex-row justify-center">
                    <a href="/check/productpage/${value.do_number}/${value.batch_no}/${value.product_code}" class="ml-2 btn bg-purple-500 hover:bg-purple-600 text-white" type="button">
                        QTY Damage/lost
                    </a> 

                    <a href="/check/report/${value.do_number}/${value.batch_no}/${value.product_code}" target="_blank" type="button" class="btn-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-3 ${value.status_order == 'Partially Damage/Lost - DAMAGE/LOST' ? '' : 'hidden'}">Print Incident Report &nbsp; <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                    </svg><a>
                    </td>
                                            </tr>`;
            }
            $("#detail-delivery-orders").append(tableRow);

            function updateDataProduct(iden) {
                var dqty = $('#qty_damaged2_'+iden).val();
                $('#qty_damaged_'+iden).val(dqty);
                $('#qty_damaged_text_'+iden).text(dqty);

                var lqty = $('#qty_lost2_'+iden).val();
                $('#qty_lost_'+iden).val(lqty);
                $('#qty_lost_text_'+iden).text(lqty);

                console.log(iden,dqty,lqty);
            }

            function makeid(length) {
                var result           = '';
                var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for ( var i = 0; i < length; i++ ) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            }
        </script>
        @yield('js-page')
    </body>
</html>
{{-- <div x-data="{ modalOpen: false }">
    <button class="ml-2 btn bg-purple-500 hover:bg-purple-600 text-white" type="button"
        @click.prevent="modalOpen = true" aria-controls="feedback-modal">
        <span>QTY Damage/lost</span>
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
                    <div class="font-semibold text-slate-800">QTY Damage/Lost</div>
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
</div> --}}