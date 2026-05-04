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
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold ml-5">Tracking Fixed Asset 📦</h1>
                    </div>
                        <div class="px-5 py-4">
                            <div class="space-y-3">
                                {{-- <form method="post" enctype="multipart/form-data" action="{{ route('assetTrack.update', ['idrec' => $dataFixedAsset->idrec]) }}">
                                    @csrf --}}
                                    <div class="flex justify-between flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="inventoryCode">Fixed Asset Code</label>
                                        <input id="inventoryCode" name="inventoryCode" value="{{$dataFixedAsset->idassets}}"
                                        class="inventoryCode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="inventoryCode">Fixed Asset Code</label>
                                        <input id="inventoryCode" name="inventoryCode" value="{{$dataFixedAsset->idfa}}"
                                        class="inventoryCode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                                    </div>
                                    <div class="flex flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="category">Category</label>
                                        <input id="category" name="category"
                                        class="category form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataFixedAsset->category}}" readonly required/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="inventoryName">Name</label>
                                        <input id="inventoryName" name="inventoryName" value="{{$dataFixedAsset->name}}"
                                        class="inventoryName form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                                    </div>
                                    <div class="flex flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="brand">Brand</label>
                                        <input id="brand" name="brand" value="{{$dataFixedAsset->brand}}"
                                        class="brand form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="unit">Asset Type</label>
                                        <input id="unit" name="unit" value="{{$dataFixedAsset->type}}"
                                            class="unit form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="loc">Location</label>
                                        <input id="loc" name="loc"
                                        class="loc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataFixedAsset->companyName}}" readonly required/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="w_address">Site Warehouse</label>
                                        <textarea id="w_address" name="w_address"
                                        class="w_address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3" readonly required>{{$dataFixedAsset->w_address}}</textarea>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="kondisi">Condition</label>
                                        <select id="kondisi" name="kondisi"
                                            class="kondisi form-select w-full md:w-3/4 px-2 py-1" disabled>
                                            <option value="Ready" {{$dataFixedAsset->kondisi == 'Ready' ? 'selected':''}}>Ready</option>
                                            <option value="In Use/Assigned" {{$dataFixedAsset->kondisi == 'In Use/Assigned' ? 'selected':''}}>In Use/Assigned</option>
                                            <option value="Need Repair" {{$dataFixedAsset->kondisi == 'Need Repair' ? 'selected':''}}>Need Repair</option>
                                            <option value="Broken" {{$dataFixedAsset->kondisi == 'Broken' ? 'selected':''}}>Broken</option>
                                            <option value="Discard" {{$dataFixedAsset->kondisi == 'Discard' ? 'selected':''}}>Discard</option>
                                            <option value="Sold" {{$dataFixedAsset->kondisi == 'Sold' ? 'selected':''}}>Sold</option>
                                        </select>
                                    </div>
                                    {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes">Notes</label>
                                        <textarea id="notes" name="notes"
                                        class="notes form-input w-full md:w-3/4 px-2 py-1" rows="3">{{$dataFixedAsset->notes}}</textarea>
                                    </div> --}}
                                    {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="photo">Upload Photo Condition Fixed Asset</label>
                                        <input name="photo" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1')"/>
                                    </div> --}}
                                    <img id="output1" style="max-width: 300px; max-height: 150px"/>
                                    <div class="grid md:grid-cols-3 gap-3 mt-5" {{$dataFixedAsset->img_name == null ? 'hidden' : ''}}>
                                            <label class="text-sm font-medium mb-1">Image Fixed Asset</label>
                                            @if($dataFixedAsset->img_name != null)
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/{{$dataFixedAsset->img_name}}" width="259" height="142" alt="Asset Image" />
                                            @endif
                                    </div>
                                            <div class="grid md:grid-cols-3 gap-3 mt-3" {{$dataFixedAsset->photo == null ? 'hidden' : ''}}>
                                                <label class="text-sm font-medium mb-1">Photo Condition Fixed Asset</label>
                                                @if($dataFixedAsset->photo != null)
                                                <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/{{$dataFixedAsset->photo}}" width="259" height="142" alt="Asset Photo"/>
                                                @endif
                                            </div>
                                    </div>
                                        {{-- <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                                            <span class="xs:block ml-5 mr-5">Save Update Fixed Asset</span>
                                        </button> </center>
                                </form> --}}
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
        @yield('js-page')
    </body>
</html>