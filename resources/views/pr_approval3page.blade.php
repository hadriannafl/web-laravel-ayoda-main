<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <title>PR Approval 3</title>


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
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Purchase Request Approval 3 📝</h1>
        </div>
        <div class="py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <a href="{{ route('purchase-list.viewfile', ['idPR' => $dataPR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Purchase Request</a>
            </div>
        </div>
        <form id="approvalForm" action="{{ route('purchase.approve3', ['idPR' => $dataPR->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="token" value="{{ request()->get('token') }}" readonly>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Purchase Request # / PR Date / PR Title</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->idreqform}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataPR->pr_date))}}" readonly>
                        </div>
                        <div>
                            <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->pr_title}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Applicant / Company / Request Level</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->applicant}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->companyName}}" readonly>
                        </div>
                        <div>
                            <input id="benef_bank" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPR->reqlevel}}" type="text" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Delivery Date / RAB / Currency</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataPR->delivery_date))}}" readonly>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataPR->id_rab}}-{{$dataPR->name_rab}}-{{date('F Y', strtotime($dataPR->rab_date))}}" readonly/>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPR->currency}}" type="text" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Payment Source / PIC / Phone Number</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPR->payment_by}}" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPR->pic}}" type="text" readonly>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataPR->phone}}" type="text" readonly/>
                        </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1" for="address">Address</label>
                    <textarea id="address" name="address" class="address form-input w-full px-2 py-1 read-only:bg-slate-200"
                        rows="3" readonly>{{$dataPR->delivery_address}}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="notes form-input w-full px-2 py-1 read-only:bg-slate-200"
                        rows="3" readonly>{{$dataPR->note}}</textarea>
                </div>
                <ul class="mt-3" x-data="{ open: {{ in_array(Request::segment(1), ['#0']) ? 1 : 0 }} }">
                    <a class="block text-sm font-medium truncate transition duration-150 @if(in_array(Request::segment(1), ['#0'])){{ 'hover:text-indigo-500' }}@endif"
                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex justify-center">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">View More Detail</span>
                                </div>
                                <!-- Icon -->
                                <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 mt-1">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                    </a>
                        <div class="">
                            <ul class="mt-3 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <div class="flex flex-row mb-3 mt-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Approval Status / Approved 1 By / Approved 2 By</label>
                                        <div style="width: 20.8rem; margin-right: 20px;">
                                            <input id="total_amount" value="{{$dataPR->approvalstat}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                        </div>
                                        <div style="width: 20.8rem; margin-right: 20px;">
                                            <input id="total_paid" value="{{$dataPR->approved1by}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly>
                                        </div>
                                        <div>
                                            <input id="balance" value="{{$dataPR->approved2by}}" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                        </div>
                                </div>
                                <div class="flex flex-row mb-3 mt-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Approved Date</label>
                                        <div style="width: 20.8rem; margin-right: 20px;">
                                            <input id="total_amount" value="{{$dataPR->approvaldate}}" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                                        </div>
                                </div>
                                <div class="mt-3">
                                    <label class="block text-sm font-medium mb-1" for="remarks1">Quotation Remarks 1</label>
                                    <textarea id="remarks1" name="remarks1" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataPR->remarks1}}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="remarks1">Quotation Remarks 2</label>
                                    <textarea id="remarks1" name="remarks1" rows="3" class="remarks1 form-input w-full px-2 py-1 read-only:bg-slate-200" readonly>{{$dataPR->remarks2}}</textarea>
                                </div>
                            </ul>
                        </div>
                </ul>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">List Asset Inventory
                    </label>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Asset Code</th>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">Quantity</th>
                                <th class="text-sm text-center">@Price</th>
                                <th class="text-sm text-center">Total</th>
                                <th class="text-sm text-center">Remarks</th>
                                
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/2 text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    <label class="text-sm font-medium mb-1 ml-16">&nbsp; &nbsp; </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" 
                    value="{{number_format($dataPR->gtotal, 0, '.', '.')}}" required readonly/>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Quotation List
                    </label>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="quotation-tables table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Quotation Detail</th>
                                <th class="text-sm text-center">Quotation 1</th>
                                <th class="text-sm text-center">Quotation 2</th>
                                <th class="text-sm text-center">Quotation 3</th>
                            </tr>
                        </thead>
                        <tbody class="quotation-tables" id="quotation-tables">
                            <tr>
                                <th class="text-sm flex justify-start mt-2 font-medium">Attachment Quotation</th>
                                <th class="text-sm text-center"><a href="{{ route('purchase-list.quotation1', ['idPR' => $dataPR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Quotation 1</a></th>
                                @if ($dataPR->quotation2 != null)
                                <th class="text-sm text-center"><a href="{{ route('purchase-list.quotation2', ['idPR' => $dataPR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Quotation 2</a></th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                                @if ($dataPR->quotation3 != null)
                                <th class="text-sm text-center"><a href="{{ route('purchase-list.quotation3', ['idPR' => $dataPR->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Quotation 3</a></th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                            </tr>
                            <tr>
                                <th class="text-sm font-medium">Vendor Name</th>
                                <th class="text-sm text-center font-medium">{{$dataPR->vendor_quo1}}</th>
                                @if ($dataPR->vendor_quo2 != null)
                                <th class="text-sm text-center font-medium">{{$dataPR->vendor_quo2}}</th>
                                @else
                                <th class="text-sm"></th>
                                @endif
                                @if ($dataPR->vendor_quo3 != null)
                                <th class="text-sm text-center font-medium">{{$dataPR->vendor_quo3}}</th>
                                @else
                                <th class="text-sm"></th>
                                @endif
                            </tr>
                            <tr>
                                <th class="text-sm font-medium">Vendor Offering Price</th>
                                <th class="text-xs text-center font-medium">{{number_format($dataPR->total_quo1, 0, ',', '.')}}</th>
                                @if ($dataPR->total_quo2 != null)
                                <th class="text-xs text-center font-medium">{{number_format($dataPR->total_quo2, 0, ',', '.')}}</th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                                @if ($dataPR->total_quo3 != null)
                                <th class="text-xs text-center font-medium">{{number_format($dataPR->total_quo3, 0, ',', '.')}}</th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                            </tr>
                            <tr>
                                <th class="text-sm font-medium">Approval 1 Selection</th>
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval1" name="quotation_approval1" value="1" {{$dataPR->quotation_approval1 == '1' ? 'checked':''}}></th>
                                @if ($dataPR->quotation2 != null)
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval1" name="quotation_approval1" value="2" {{$dataPR->quotation_approval1 == '2' ? 'checked':''}}></th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                                @if ($dataPR->quotation3 != null)
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval1" name="quotation_approval1" value="3" {{$dataPR->quotation_approval1 == '3' ? 'checked':''}}></th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                            </tr>
                            {{-- <tr>
                                <th class="text-sm font-medium">Approval 2 Selection</th>
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval2" name="quotation_approval2" value="1" {{$dataPR->quotation_approval2 == '1' ? 'checked':''}}></th>
                                @if ($dataPR->quotation2 != null)
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval2" name="quotation_approval2" value="2" {{$dataPR->quotation_approval2 == '2' ? 'checked':''}}></th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                                @if ($dataPR->quotation3 != null)
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval2" name="quotation_approval2" value="3" {{$dataPR->quotation_approval2 == '3' ? 'checked':''}}></th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                            </tr>
                            <tr>
                                <th class="text-sm font-medium">Approval 3 Selection</th>
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval3" name="quotation_approval3" value="1"></th>
                                @if ($dataPR->quotation2 != null)
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval3" name="quotation_approval3" value="2"></th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                                @if ($dataPR->quotation3 != null)
                                <th class="text-sm text-center"><input type="radio" id="quotation_approval3" name="quotation_approval3" value="3"></th>
                                @else
                                <th class="text-sm text-center"></th>
                                @endif
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="subtotal">Subtotal
                    </label>
                    <input id="subtotal" name="subtotal" type="text" class="subtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" value="{{number_format($dataPR->subtotal, 0, '.', '.')}}" readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="discount">Discount (IDR)
                    </label>
                    <input id="discount" name="discount" class="discount form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" value="{{number_format($dataPR->discount, 0, '.', '.')}}" readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="total">Total
                    </label>
                    <input id="total" name="total" type="text" class="total form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" value="{{number_format($dataPR->total, 0, '.', '.')}}" readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="ppn">PPN (IDR)
                    </label>
                    <input id="ppn" name="ppn" class="ppn form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" value="{{number_format($dataPR->ppn, 0, '.', '.')}}" readonly/>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" 
                    value="{{number_format($dataPR->gtotal, 0, '.', '.')}}" required readonly/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="deliveryCharge">Delivery Charge (IDR)
                    </label>
                    <input id="deliveryCharge" name="deliveryCharge" class="deliveryCharge form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-52" type="text" value="{{number_format($dataPR->delivery_charge, 0, '.', '.')}}" readonly/>
                </div>

                    @if ($dataRab->approvalstat == 'HQ 2 Approved')
                      <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks3">Quotation Remarks 3 </label>
                        <textarea id="remarks3" name="remarks3"
                            class="remarks3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
                    </div>
                    <center>
                            <input type="submit" value="Approved" name="status" class="w-80 text-lg bg-green-500 hover:bg-green-600 text-white mt-3" />
                            <input type="submit" value="Denied" name="status" class="w-80 text-lg bg-red-400 border-slate-200 hover:bg-red-500 text-white mt-3" />
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
            document.getElementById('approvalForm').addEventListener('submit', function(event) {
                var remarks = document.getElementById('remarks3').value.trim();
                var status = document.activeElement.value;
    
                if ((status === 'Denied') && (remarks === '' || remarks.toLowerCase() === 'null')) {
                    alert('Remarks must Fill if "Denied"');
                    event.preventDefault();
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            const dataProducts = <?=$PRDetail?>;
            let tableRow = '';
            let productIdx = 0;
            
            for (const value of dataProducts) {
    
                tableRow += `<tr id=row1-productIdx>
                                <td>${value.idassets}</td>
                                <td>${value.name}</td>
                                <td class="text-center">${value.unit}</td>
                                <td class="text-right">${newDivider1(value.qty)}</td>
                                <td class="text-right">${newDivider1(value.price)}</td>
                                <td class="text-right">${newDivider1(value.total)}</td>
                                <td>${value.remarks === 'null' ? '' : (value.remarks || '')}</td>
                                            </tr>`;
            }
            $(".tableProductAddBody").find('tbody').append(tableRow);
            var grandTotalRow = `<tr class="grandTotalRow">
                <td class="text-center font-bold text-lg" colspan="5">Grand Total</td>
                <td class="text-right font-bold text-lg" id="grandTotal_text">{{number_format($dataPR->gtotal, 0, '.', '.')}}</td>
                <td></td>
                <td></td>
            </tr>`;
            $("#tableProductAddBody").append(grandTotalRow);
            
        </script>
        @yield('js-page')
    </body>
</html>