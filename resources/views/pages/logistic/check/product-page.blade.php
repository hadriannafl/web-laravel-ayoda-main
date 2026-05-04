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
                    <div class="mb-3">
                        <h1 class="ml-5 mt-3"><a onclick="history.back()"><img src="{{ asset('images/left-arrow.png') }}" width="100" height="50" alt="Task 01" class="pointer"></a></h1>
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold ml-5">QTY Damage/Lost Orders 📦</h1>
                    </div>
                        <div class="px-5 py-4">
                            <div class="space-y-3">
                                <label class="block text-sm font-medium mb-1" for="address">Damage/Lost Product Items :</label>
                                <center>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered detail-delivery-orders"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-sm text-center">DO Number</th>
                                                    <th class="text-sm text-center">Tracking Code</th>
                                                    <th class="text-sm text-center">Product Code</th>
                                                    <th class="text-sm text-center">Product Name</th>
                                                    <th class="text-sm text-center">Batch No</th>
                                                </tr>
                                            </thead>
                                            <tbody class="detail-delivery-orders" id="detail-delivery-orders">
                                                <tr>
                                                    <td class="text-center">{{$dataDeliveryOrders->do_number}}</td>
                                                    <td class="text-center">{{$dataDeliveryOrders->code}}</td>
                                                    <td class="text-center">{{$dataDeliveryOrders->product_code}}</td>
                                                    <td>{{$dataDeliveryOrders->product_name}}</td>
                                                    <td class="text-center">{{$dataDeliveryOrders->batch_no}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </center>
                            <form method="post" class="form_do_product" enctype="multipart/form-data" action="{{ route('tracking.product', ['doNumber' => $dataDeliveryOrders->do_number, 'batchNo' => $dataDeliveryOrders->batch_no, 'productCode' => $dataDeliveryOrders->product_code]) }}">
                                @csrf
                                <input type="text" name="doNumber" value="{{$dataDeliveryOrders->do_number}}" hidden/>
                                <input type="text" name="batchNo" value="{{$dataDeliveryOrders->batch_no}}" hidden/>
                                <input type="text" name="productCode" value="{{$dataDeliveryOrders->product_code}}" hidden/>
                                <input type="text" name="code" value="{{$dataDeliveryOrders->code}}" hidden/>
                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                        for="order_quantity2">Damaged Quantity :
                                    </label>
                                    <input id="qty_damaged" name="qty_damaged"
                                        class="qty_damaged form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="number"/>
                                </div>
                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                        for="order_quantity2">Lost Quantity :
                                    </label>
                                    <input id="qty_lost" name="qty_lost"
                                        class="qty_lost form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="number"/>
                                </div>
                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                        for="order_quantity2">Damaged Imaage 1 :
                                    </label>
                                    <input id="damaged_image1" name="damaged_image1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output3-${iden}')"/>
                                </div>
                                <div class="mb-3">
                                    <img id="output3-${iden}" style="max-width: 300px; max-height: 150px"/>
                                </div>
                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                        for="order_quantity2">Damaged Imaage 2 :
                                    </label>
                                    <input id="damaged_image2" name="damaged_image2" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output4-${iden}')"/>
                                </div>
                                <div class="mb-3">
                                    <img id="output4-${iden}" style="max-width: 300px; max-height: 150px"/>
                                </div>
                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                        for="order_quantity2">Lost Imaage 1 :
                                    </label>
                                    <input id="lost_image1" name="lost_image1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output5-${iden}')"/>
                                </div>
                                <div class="mb-3">
                                    <img id="output5-${iden}" style="max-width: 300px; max-height: 150px"/>
                                </div>
                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                        for="order_quantity2">Lost Imaage 2 :
                                    </label>
                                    <input id="lost_image2" name="lost_image2" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output6-${iden}')"/>
                                </div>
                                <div class="mb-3">
                                    <img id="output6-${iden}" style="max-width: 300px; max-height: 150px"/>
                                </div>
                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                        for="notes">Damage/Lost Notes :
                                    </label>
                                    <textarea id="notes" name="notes" class="form-input w-full md:w-3/4 px-2 py-1" minlength="20" rows="3" required></textarea>
                                </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-5 {{$dataDeliveryOrders->orders_status == '301' ? 'hidden' : ''}}">
                                            <div></div>
                                            <button type="submit" name="status" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" />Update<button>
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
        </script>
        @yield('js-page')
    </body>
</html>