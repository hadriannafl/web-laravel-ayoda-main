<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <title>Outbound Inventory Approval</title>


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

            /* .selector {
                position: relative;
                --bs-blue: #0d6efd;
                --bs-indigo: #6610f2;
                --bs-purple: #6f42c1;
                --bs-pink: #d63384;
                --bs-red: #dc3545;
                --bs-orange: #fd7e14;
                --bs-yellow: #ffc107;
                --bs-green: #198754;
                --bs-teal: #20c997;
                --bs-cyan: #0dcaf0;
                --bs-black: #000;
                --bs-white: #fff;
                --bs-gray: #6c757d;
                --bs-gray-dark: #343a40;
                --bs-gray-100: #f8f9fa;
                --bs-gray-200: #e9ecef;
                --bs-gray-300: #dee2e6;
                --bs-gray-400: #ced4da;
                --bs-gray-500: #adb5bd;
                --bs-gray-600: #6c757d;
                --bs-gray-700: #495057;
                --bs-gray-800: #343a40;
                --bs-gray-900: #212529;
                --bs-primary: #0d6efd;
                --bs-secondary: #6c757d;
                --bs-success: #198754;
                --bs-info: #0dcaf0;
                --bs-warning: #ffc107;
                --bs-danger: #dc3545;
                --bs-light: #f8f9fa;
                --bs-dark: #212529;
                --bs-primary-rgb: 13,110,253;
                --bs-secondary-rgb: 108,117,125;
                --bs-success-rgb: 25,135,84;
                --bs-info-rgb: 13,202,240;
                --bs-warning-rgb: 255,193,7;
                --bs-danger-rgb: 220,53,69;
                --bs-light-rgb: 248,249,250;
                --bs-dark-rgb: 33,37,41;
                --bs-white-rgb: 255,255,255;
                --bs-black-rgb: 0,0,0;
                --bs-body-color-rgb: 33,37,41;
                --bs-body-bg-rgb: 255,255,255;
                --bs-font-sans-serif: system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans","Liberation Sans",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
                --bs-font-monospace: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
                --bs-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
                --bs-body-font-family: var(--bs-font-sans-serif);
                --bs-body-font-size: 1rem;
                --bs-body-font-weight: 400;
                --bs-body-line-height: 1.5;
                --bs-body-color: #212529;
                --bs-body-bg: #fff;
                --bs-border-width: 1px;
                --bs-border-style: solid;
                --bs-border-color: #dee2e6;
                --bs-border-color-translucent: rgba(0, 0, 0, 0.175);
                --bs-border-radius: 0.375rem;
                --bs-border-radius-sm: 0.25rem;
                --bs-border-radius-lg: 0.5rem;
                --bs-border-radius-xl: 1rem;
                --bs-border-radius-2xl: 2rem;
                --bs-border-radius-pill: 50rem;
                --bs-link-color: #0d6efd;
                --bs-link-hover-color: #0a58ca;
                --bs-code-color: #d63384;
                --bs-highlight-bg: #fff3cd;
                --range-thumb-size: 36px;
                -webkit-text-size-adjust: 100%;
                -webkit-tap-highlight-color: transparent;
                -webkit-font-smoothing: antialiased;
                --bs-bg-opacity: 1;
                box-sizing: border-box;
                border-style: solid;
                --tw-border-spacing-x: 0;
                --tw-border-spacing-y: 0;
                --tw-translate-x: 0;
                --tw-translate-y: 0;
                --tw-rotate: 0;
                --tw-skew-x: 0;
                --tw-skew-y: 0;
                --tw-scale-x: 1;
                --tw-scale-y: 1;
                --tw-pan-x: ;
                --tw-pan-y: ;
                --tw-pinch-zoom: ;
                --tw-scroll-snap-strictness: proximity;
                --tw-ordinal: ;
                --tw-slashed-zero: ;
                --tw-numeric-figure: ;
                --tw-numeric-spacing: ;
                --tw-numeric-fraction: ;
                --tw-ring-inset: ;
                --tw-ring-offset-width: 0px;
                --tw-ring-offset-color: #fff;
                --tw-ring-color: rgb(59 130 246 / 0.5);
                --tw-ring-offset-shadow: 0 0 #0000;
                --tw-ring-shadow: 0 0 #0000;
                --tw-blur: ;
                --tw-brightness: ;
                --tw-contrast: ;
                --tw-grayscale: ;
                --tw-hue-rotate: ;
                --tw-invert: ;
                --tw-saturate: ;
                --tw-sepia: ;
                --tw-drop-shadow: ;
                --tw-backdrop-blur: ;
                --tw-backdrop-brightness: ;
                --tw-backdrop-contrast: ;
                --tw-backdrop-grayscale: ;
                --tw-backdrop-hue-rotate: ;
                --tw-backdrop-invert: ;
                --tw-backdrop-opacity: ;
                --tw-backdrop-saturate: ;
                --tw-backdrop-sepia: ;
                --calendarPadding: 24px;
                --daySize: 36px;
                --daysWidth: calc(var(--daySize)*7);
                font-family: inherit;
                font-weight: inherit;
                margin: 0;
                padding-right: .5rem!important;
                padding-left: .5rem!important;
                padding-top: .25rem!important;
                padding-bottom: .25rem!important;
                appearance: none;
                border-width: 1px;
                --tw-bg-opacity: 1;
                background-color: rgb(255 255 255 / var(--tw-bg-opacity));
                font-size: 0.875rem;
                --tw-text-opacity: 1;
                color: rgb(30 41 59 / var(--tw-text-opacity));
                border-radius: 0.25rem;
                --tw-border-opacity: 1;
                border-color: rgb(226 232 240 / var(--tw-border-opacity));
                line-height: 1.25rem;
                --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
                --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
                box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
                width: 75%;
            }

            .selector:before {
                content: attr(data-date);
            }

            .selector::-webkit-datetime-edit, .selector::-webkit-inner-spin-button, .selector::-webkit-clear-button {
                display: none;
            }

            .selector::-webkit-calendar-picker-indicator {
                position: relative;
                /* margin-right: 20px; */
                /* top: 50%;
                width: 1em;
                transform: translateY(-50%);
                left: 5rem;
                cursor: pointer; */
            /* } */
            .selector {
                position: relative;
                width: 75%; /* Sesuaikan lebar dengan kebutuhan Anda */
            }

            .selector:before {
                content: attr(data-date);
            }

            .selector::-webkit-datetime-edit,
            .selector::-webkit-inner-spin-button,
            .selector::-webkit-clear-button {
                display: none;
            }

            .selector::-webkit-calendar-picker-indicator {
                position: absolute;
                top: 50%;
                width: 1em;
                transform: translateY(-50%);
                left: 6rem;
                cursor: pointer;
            }
        </style>
    </head>
    <body class="font-inter antialiased bg-slate-100 text-slate-600">
        @include('sweetalert::alert')
        <main class="bg-white">
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
                <form id="approvalForm" action="{{ route('outbound.approve', ['outboundId' => $dataOutbound->idrec]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="token" value="{{ request()->get('token') }}">
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
                        <div class="flex flex-row md:flex-row mb-3 mt-3">
                            <label class="block text-sm font-medium mb-1" for="task_id"> List Outbound Inventory
                            </label>
                        </div>
                        <div class="flex flex-row md:flex-row">
                            <table class="tableProductAddBody table table-striped table-bordered mt-3"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-sm text-center">Inventory Name</th>
                                        <th class="text-sm text-center">Qty</th>
                                        <th class="text-sm text-center">Unit</th>
                                    </tr>
                                </thead>
                                <tbody class="tableProductAddBody" id="tableProductAddBody">
        
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                            <label class="text-sm font-medium mb-1" for="approved1by">Approved By<span class="text-rose-500">*</span>
                            </label>
                            <input id="approved1by" name="approved1by" class="approved1by form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                        </div> --}}
                        @if ($dataOutbound->approvalstat == 'Site Approved')
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
                        @endif
                    </form>
            </div>
        </main>

        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
        {{-- <script type="text/javascript" src="my.js"></script> --}}
        

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
            function divider1(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            function newDivider(num) {
                var numString = num.toString();
                var num_parts = numString.split(".");

                // Memisahkan dua digit terakhir dari bagian desimal
                var lastTwoDecimals = num_parts[1] ? num_parts[1].substr(0, 2) : "00";
                
                // Menggabungkan dua digit pertama desimal ke bagian yang sudah diformat
                var formattedNum = num_parts[0] + "." + lastTwoDecimals;

                // Memformat bagian sebelum titik desimal dengan titik sebagai pemisah ribuan
                formattedNum = formattedNum.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                return formattedNum;
            }
            function newDivider1(num) {
                // Mengkonversi angka menjadi string dan memisahkan bagian desimal
                var numString = num.toString();
                var num_parts = numString.split(".");

                // Bagian depan angka (tanpa desimal)
                var formattedNum = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                return formattedNum;
            }
            function newDivider2(num) {
                // Mengkonversi angka menjadi string dan memisahkan bagian desimal
                var numString = num.toString();
                var num_parts = numString.split(".");

                // Bagian depan angka (tanpa desimal)
                var formattedNum = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, "");

                return formattedNum;
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

            $('.selector').on("change", function () {
                if (this.value !== "") {
                    this.setAttribute(
                        "data-date",
                        moment(this.value, "YYYY-MM-DD").format(this.getAttribute("data-date-format"))
                    );
                } else {
                    this.removeAttribute("data-date");
                }
            }).trigger("change");

            function allinDivider(num) {
                const parts = num.toString().split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                if (parts[1]) {
                    parts[1] = parts[1].replace('.', ',');
                }
                return parts.join(',');
            }

            // Fungsi untuk menambahkan titik sebagai pemisah ribuan
            function addThousandSeparator(num) {
                // Memisahkan bagian angka sebelum koma dan setelah koma
                const parts = num.toString().split(',');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                
                // Jika ada bagian desimal
                if (parts[1]) {
                    // Mengambil hanya 4 digit pertama setelah koma
                    parts[1] = parts[1].substring(0, 4);
                }
                
                return parts.join(',');
            }

            // Fungsi untuk memastikan input hanya angka dan koma
            function allowOnlyNumbers(event) {
                const allowedKeys = [8, 9, 17, 44]; // Backspace, Tab, Ctrl, dan Koma (,)

                if (event.keyCode && allowedKeys.includes(event.keyCode)) return true;

                const charCode = event.which ? event.which : event.keyCode;

                // Memeriksa karakter apakah angka atau koma
                if ((charCode < 48 || charCode > 57) && charCode !== 44) return false;

                return true;
            }

            // Event listener untuk input dengan kelas numeric-input
            document.querySelectorAll('.numeric-input').forEach(function(input) {
                input.addEventListener('input', function(event) {
                    let inputValue = event.target.value;

                    // Menghapus semua karakter selain angka dan koma
                    inputValue = inputValue.replace(/[^\d,]/g, '');

                    // Memastikan hanya satu koma yang diizinkan
                    const commaCount = inputValue.split(',').length - 1;
                    if (commaCount > 1) {
                        inputValue = inputValue.replace(/,/g, ''); // Hapus semua koma tambahan
                    }

                    event.target.value = addThousandSeparator(inputValue);
                });

                input.addEventListener('keypress', function(event) {
                    if (!allowOnlyNumbers(event)) {
                        event.preventDefault();
                    }
                });
            });
        </script>
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
                                <td>${value.name}</td>
                                <td class="text-right">${newDivider1(value.qty)}</td>
                                <td class="text-center">${value.unit}</td>
                                            </tr>`;
            }
            tableRow += `<tr>
                        <td class="text-center font-bold text-lg">Total</td>
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
        @yield('js-page')
    </body>
</html>