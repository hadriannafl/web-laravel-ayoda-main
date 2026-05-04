<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <title>RAB Approval 2</title>


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
                      <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">RAB Request Approval 2 📝</h1>
              </div>
              @if ($dataRab->rab_file != null)
              <div class="px-5 py-4 border-t border-slate-200">
                  <div class="flex flex-wrap justify-end space-x-2">
                      <a href="{{ route('rab-list.viewfile', ['rabId' => $dataRab->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment RAB</a>
                  </div>
              </div>
              @endif
              <form id="approvalForm" action="{{ route('rab.approve2', ['rabId' => $dataRab->idrec]) }}" method="post" enctype="multipart/form-data" id="myForm">
                      @csrf
                      <input type="hidden" name="token" value="{{ request()->get('token') }}" readonly>
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
                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Approval 1 By / Last Updated At</label>
                                <div style="width: 20.8rem; margin-right: 20px;">
                                    <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->approved1by}}" type="text" readonly/>
                                </div>
                                <div style="width: 20.8rem; margin-right: 20px;">
                                    <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->approvaldate}}" readonly>
                                </div>
                                {{-- <div>
                                    <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->approvalstat}}" readonly/>
                                </div> --}}
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium mb-1" for="remarks1">Remarks Approval 1</label>
                            <textarea id="remarks1" name="remarks1" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataRab->remarks1}}</textarea>
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
                                      {{-- <th class="text-sm text-center">Action</th>
                                      <th hidden class="text-sm text-center">Balance</th> --}}
                                  </tr>
                              </thead>
                              <tbody class="tableProductAddBody" id="tableProductAddBody">
      
                              </tbody>
                          </table>
                      </div>
                      <div class="flex flex-row mb-3 mt-3" hidden>
                          <label class="text-sm font-medium mb-1" for="totalAmount">Grand Total
                          </label>
                          <label class="text-sm font-medium mb-1 ml-16">&nbsp;&nbsp;</label>
                          <input type="text" class="bg-white border-white md:w-1/3 px-2 py-1" disabled/>
                          <label class="md:w-1/6 text-sm font-medium mb-1 ml-5 text-white" for="discount2idr">Discount 1 (IDR):
                          </label>
                          <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/3 px-2 py-1 read-only:bg-slate-200 text-right ml-6" type="text" 
                          value="{{number_format($dataRab->grandTotal, 0)}}" required readonly/>
                          <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" 
                          value="{{$dataRab->grandTotal}}" readonly required/>
                      </div>

                    {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="text-sm font-medium mb-1" for="approved2by">Approved 2 By<span class="text-rose-500">*</span>
                        </label>
                        <input id="approved2by" name="approved2by" class="approved2by form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                    </div> --}}
                    @if ($dataRab->approvalstat == 'HQ 1 Approved')
                      <div class="flex justify-between flex-col md:flex-row mt-3">
                          <label class="text-sm font-medium mb-1" for="remarks2">Remarks Approval 2 </label>
                          <textarea id="remarks2" name="remarks2"
                              class="remarks2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
                      </div>
                      <center>
                        <tr>
                            <input type="submit" value="Approve" name="status" class="w-50 text-lg bg-green-500 hover:bg-green-600 text-white mt-3" />
                        </tr>
                        <tr>
                            <input type="submit" value="Decline" name="status" class="w-50 text-lg bg-red-400 border-slate-200 hover:bg-red-500 text-white mt-3" />
                        </tr>
                        <tr>
                            <input type="submit" value="Return to Draft" name="status" class="w-50 text-lg bg-amber-500 border-slate-200 hover:bg-amber-600 text-white mt-3" />
                        </tr>
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

            // function allinDivider(num) {
            //     const parts = num.toString().split('.');
            //     parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                
            //     if (parts[1]) {
            //         parts[1] = parts[1].substring(0, 2).replace('.', ',');
            //     }
                
            //     return parts.join(',');
            // }

            function allinDivider(num) {
                const parts = num.toString().split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                if (parts[1]) {
                    // Hapus nol di akhir desimal dan batasi hingga 4 digit desimal
                    parts[1] = parts[1].replace(/0+$/, '').substring(0, 4);
                }

                return parts.length > 1 && parts[1] !== '' ? parts.join(',') : parts[0];
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

            // Fungsi untuk memastikan input hanya angka, koma, dan tanda minus
            function allowExtendedNumbers(event) {
                const allowedKeys = [8, 9, 17, 44, 45]; // Backspace, Tab, Ctrl, Koma (,), dan Minus (-)

                if (event.keyCode && allowedKeys.includes(event.keyCode)) return true;

                const charCode = event.which ? event.which : event.keyCode;

                // Memeriksa karakter apakah angka, koma, atau tanda minus
                if ((charCode < 48 || charCode > 57) && charCode !== 44 && charCode !== 45) return false;

                return true;
            }

            // Event listener untuk input dengan kelas extended-numeric-input
            document.querySelectorAll('.extended-numeric-input').forEach(function(input) {
                input.addEventListener('input', function(event) {
                    let inputValue = event.target.value;

                    // Menghapus semua karakter selain angka, koma, dan tanda minus
                    inputValue = inputValue.replace(/[^-\d,]/g, '');

                    // Memastikan hanya satu koma yang diizinkan
                    const commaCount = inputValue.split(',').length - 1;
                    if (commaCount > 1) {
                        inputValue = inputValue.replace(/,/g, ''); // Hapus semua koma tambahan
                    }

                    // Memastikan hanya satu tanda minus yang diizinkan, dan harus di awal string
                    const minusCount = inputValue.split('-').length - 1;
                    if (minusCount > 1 || (minusCount === 1 && inputValue.indexOf('-') > 0)) {
                        inputValue = inputValue.replace(/-/g, ''); // Hapus semua tanda minus tambahan
                    }

                    event.target.value = addThousandSeparator(inputValue);
                });

                input.addEventListener('keypress', function(event) {
                    if (!allowExtendedNumbers(event)) {
                        event.preventDefault();
                    }
                });
            });

            function allowOnlyNumbersAndDot(event) {
                const allowedKeys = [8, 9, 17, 46]; // Backspace, Tab, Ctrl, dan Titik (.)

                if (event.keyCode && allowedKeys.includes(event.keyCode)) return true;

                const charCode = event.which ? event.which : event.keyCode;

                // Memeriksa karakter apakah angka atau titik
                if ((charCode < 48 || charCode > 57) && charCode !== 46) return false;

                return true;
            }

            // Event listener untuk input dengan kelas numeric-input
            document.querySelectorAll('.numeric1-input').forEach(function(input) {
                input.addEventListener('input', function(event) {
                    let inputValue = event.target.value;

                    // Menghapus semua karakter selain angka dan titik
                    inputValue = inputValue.replace(/[^\d.]/g, '');

                    event.target.value = inputValue;
                });

                input.addEventListener('keypress', function(event) {
                    if (!allowOnlyNumbersAndDot(event)) {
                        event.preventDefault();
                    }
                });
            });
        </script>
        <script>
            $('#approval_to').select2();
            $('#company').on('change', '.rab-input', function() {
                const comps = $(this).val();

                if (comps == '12') {
                    $('#approval_to').attr('required', false);
                } else {
                    $('#approval_to').attr('required', true);
                }
            })
            document.getElementById('approvalForm').addEventListener('submit', function(event) {
                var remarks = document.getElementById('remarks2').value.trim();
                var status = document.activeElement.value;

                if ((status === 'Decline' || status === 'Return to Draft') && (remarks === '' || remarks.toLowerCase() === 'null')) {
                    alert('Remarks must Fill if "Denied" or "Return to Draft"');
                    event.preventDefault();
                }
            });
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
            const dataProducts = <?=$dataRabItem?>;
            let tableRow = '';
            
            for (const value of dataProducts) {
                // var iden = makeid(3);
                var iden = dataProducts.indexOf(value);
    
                const prods = <?=$dataRabItem?>;
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
                    const days2 = parseFloat($(`#days2_${iden}`).val()) || 1;
                    const price2 = parseFloat($(`#product-price2_${iden}`).val()) || 0;
                    const total2 = price2 * qty2 * days2;
    
                    $(`#itemTotal_${iden}`).val(divider1(total2));
                }
    
                $.each(prods, function (i,item1) {
                    if(value.idrec == item1.idrec){
                        modal_content += `<div class="modal-content text-xs px-5 py-4">
                                                <div class="flex justify-between flex-col md:flex-row mb-3" id="qty2">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="qty2">qty
                                                    </label>
                                                    <input id="qty2_${iden}" name="qty2" class="rab-input numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" data-iden="${iden}" value="${newDivider2(value.qty)}"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="product-price2">@Budget
                                                    </label>
                                                    <input id="product-price2_${iden}" name="product-price2" class="rab-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="number" data-iden="${iden}" value="${newDivider2(value.amount)}"/>
                                                </div>
                                                <div class="flex flex-row mb-3" id="dayss2_${iden}">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="days">Days Count : </label>
                                                    <input id="days2_${iden}" name="days2" class="rab-input form-input w-20" type="number" data-iden="${iden}" value="${newDivider2(value.days)}"/>
                                                    <span class="mx-2 mt-2 text-black-500">Days</span>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Total
                                                    </label>
                                                    <input id="itemTotal_${iden}" name="itemTotal"
                                                    class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 totally1-trigger"
                                                    type="text" onchange="totally1(this)" value="${newDivider1(value.total)}" readonly/>
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
                    // console.log(item)
                })
    
                tableRow += `<tr id=row-${iden}>
                                <td>${value.rab_calc_type}</td>
                                <td><input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="ids_${iden}" value="${value.id_rab_item}" hidden/> <input type="text" name="offer_${iden}" value="${value.id_rab}" hidden/>${value.category === 'null' ? '' : (value.category || '')}</td>
                                <td><input type="text" name="m_currency_${iden}" id="m_currency_${iden}" value="${value.sub_category}" hidden/><input type="text" name="idrecss_${iden}" value="${value.idrec}" hidden/>${value.sub_category === 'null' ? '' : (value.sub_category || '')}</td>
                                <td>${value.detail === 'null' ? '' : (value.detail || '')}<input type="text" name="days1_${iden}" id="days1_${iden}" value="${value.days}" hidden/><input type="text" name="calcul_${iden}" id="calcul_${iden}" value="${value.rab_calc_type}" hidden/></td>
                                <td class="text-right"><input type="text" name="qty_${iden}" id="qty_${iden}" value="${newDivider2(value.qty)}" hidden/><span id="qty_text_${iden}">${newDivider1(value.qty)}</span></td>
                                <td class="text-center"><input type="text" name="units1_${iden}" id="units1_${iden}" value="${value.unit}" hidden/><span id="units1_text_${iden}">${value.unit}</span></td>
                                <td class="text-right"><input type="text" name="price_${iden}" id="price_${iden}" value="${newDivider2(value.amount)}" hidden/><span id="price_text_${iden}">${newDivider1(value.amount)}</span></td>
                                <td class="text-right"><input type="text" name="total_${iden}" id="total_${iden}" value="${newDivider2(value.total)}" hidden/><span id="total_text_${iden}">${newDivider1(value.total)}</span></td>
                                <td><textarea type="text" name="remarks1_${iden}" id="remarks1_${iden}" value="${value.remarks}" hidden></textarea><span id="remarks1_text_${iden}">${value.remarks === 'null' ? '' : (value.remarks || '')}</span></td>
                </tr>`;
            }
            $(".tableProductAddBody").find('tbody').append(tableRow);
            var grandTotalRow = `<tr class="grandTotalRow">
                <td class="text-center font-bold text-lg" colspan="7">Grand Total</td>
                <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(grandTotal)}</span></td>
                <td></td>
            </tr>`;
            $("#tableProductAddBody").append(grandTotalRow);
    
            function updateDataProduct(iden) {
                var remarks = $('#remarks2_'+iden).val();
                $('#remarks1_'+iden).val(remarks);
                $('#remarks1_text_'+iden).text(remarks);
    
                var daysss = $('#days2_'+iden).val();
                $('#days1_'+iden).val(daysss);
                $('#days1-text_'+iden).text(daysss);
                
                var qty = parseFloat($('#qty2_' + iden).val()) || 0;
                var price = parseFloat($('#product-price2_' + iden).val()) || 0;
                var days = parseFloat($('#days2_' + iden).val()) || 0;
                var total = parseFloat(price*qty*days) || 0;
                // var moq = parseFloat($('#minimum_quantity_order2_' + iden).val()) || 0;
    
                var previousQty = parseFloat($('#qty_' + iden).val()) || 0;
                var previousPrice = parseFloat($('#price_' + iden).val()) || 0;
                var previousTotal = parseFloat($('#total_' + iden).val()) || 0;
    
                var totalDifference = total - previousTotal;
    
                // Update grandTotal with the price difference
                grandTotal += totalDifference;
    
                // Update nilai pada input #grandtotal
                $('#grandtotal').val(newDivider1(grandTotal));
                $('#grandtotal1').val(grandTotal);
                updateGrandTotal();
    
                // Update nilai pada hidden input price
                $('#qty_' + iden).val(qty);
                $('#qty_text_' + iden).text(newDivider1(qty));
                $('#price_' + iden).val(price);
                $('#price_text_' + iden).text(newDivider1(price));
                $('#total_' + iden).val(total);
                $('#total_text_' + iden).text(newDivider1(total));
    
                console.log(iden, qty, price, total, grandTotal, remarks);
            }
    
            function updateGrandTotal() {
                $('#grandTotal_text').text(`${divider(grandTotal)}`);
                $('#grandTotal_text').val(`${divider(grandTotal)}`);
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