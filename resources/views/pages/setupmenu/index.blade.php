<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Setup List Menu ✨
                </h1>
            </div>
        </div>
         <!-- Filters -->
        <div class="mb-1">
            <ul class="flex justify-end">
                <form class="flex flex-row mb-3" id="form-search" action="" method="GET">
                    <label class="block text-sm font-semibold mt-2 mr-3">Search Username :</label>
                        <div class="mt-2">
                            <select id="search" name="search" class="search form-input w-full" style="width: 20rem" required>
                                    <option value="" selected hidden>Search...</option>
                                 @foreach ($datauser as $users)
                                    <option class="" value="{{ $users->id }}">{{ $users->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($search != '')
                            <button class="item-center btn-lg bg-indigo-500 hover:bg-indigo-600 text-white ml-2" type="submit" aria-label="Search" disabled>
                                <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path class="fill-current text-slate-200"
                                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                    <path class="fill-current text-slate-200"
                                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                                </svg>
                            </button>
                        @else
                            <button class="item-center btn-lg bg-indigo-500 hover:bg-indigo-600 text-white ml-2" type="submit" aria-label="Search">
                                <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path class="fill-current text-slate-200"
                                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                    <path class="fill-current text-slate-200"
                                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                                </svg>
                            </button>
                        @endif
                </form>
            </ul>
        </div>
                    <div class="modal-content text-xs px-5 py-4">
                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                @if ($search == '')
                                    <table id="tableMenuList" class="tableMenuList table table-bordered mt-3 bg-white"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">Main Menu</th>
                                                <th colspan="2" class="text-center">Sub Menu</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Show</th>
                                                <th class="text-center">Main Menu Name</th>
                                                <th class="text-center">Show</th>
                                                <th class="text-center">Submenu Name</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableMenuList" id="tableMenuList">
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="kanban" name="kanban" value="1"/></td>
                                                <td colspan="3">Kanban</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                <td rowspan="26" class="text-center"><input class="mt-1" type="checkbox" id="ga" name="ga" value="1" onclick="checkGA(this)"/></td>
                                                <td rowspan="26">GA</td>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_1" name="ga_1" value="1" onclick="checkGA1(this)"/></td>
                                                <td>List Assigned Asset</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_2" name="ga_2" value="1" onclick="checkGA2(this)"/></td>
                                                <td>New Assigned Asset</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_3" name="ga_3" value="1" onclick="checkGA3(this)"/></td>
                                                <td>Approval Assigned Asset</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_4" name="ga_4" value="1" onclick="checkGA4(this)"/></td>
                                                <td>List Asset Code</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_5" name="ga_5" value="1" onclick="checkGA5(this)"/></td>
                                                <td>New Asset Code</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_6" name="ga_6" value="1" onclick="checkGA6(this)"/></td>
                                                <td>Edit Asset Code</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_7" name="ga_7" value="1" onclick="checkGA7(this)"/></td>
                                                <td>Delete Asset Code</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_8" name="ga_8" value="1" onclick="checkGA8(this)"/></td>
                                                <td>Catalogue Fixed Asset</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_9" name="ga_9" value="1" onclick="checkGA9(this)"/></td>
                                                <td>List Fixed Asset</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_10" name="ga_10" value="1" onclick="checkGA10(this)"/></td>
                                                <td>New Fixed Asset</td>
                                            </tr>
                                            {{-- <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_11" name="ga_11" value="1" onclick="checkGA11(this)"/></td>
                                                <td>List Purchase Request</td>
                                            </tr> --}}
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_11" name="ga_11" value="1" onclick="checkGA11(this)"/></td>
                                                <td>New Purchase Request</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_12" name="ga_12" value="1" onclick="checkGA12(this)"/></td>
                                                <td>Update Prize Purchase Request</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_13" name="ga_13" value="1" onclick="checkGA13(this)"/></td>
                                                <td>Submit Quotation Prize Purchase Request</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_14" name="ga_14" value="1" onclick="checkGA14(this)"/></td>
                                                <td>Approval 1 Purchase Request</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_15" name="ga_15" value="1" onclick="checkGA15(this)"/></td>
                                                <td>Approval 2 Purchase Request</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_16" name="ga_16" value="1" onclick="checkGA16(this)"/></td>
                                                <td>Approval 3 Purchase Request</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_17" name="ga_17" value="1" onclick="checkGA17(this)"/></td>
                                                <td>List RAB</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_18" name="ga_18" value="1" onclick="checkGA18(this)"/></td>
                                                <td>New RAB</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_19" name="ga_19" value="1" onclick="checkGA19(this)"/></td>
                                                <td>Approval 1 RAB</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_20" name="ga_20" value="1" onclick="checkGA20(this)"/></td>
                                                <td>Approval 2 RAB</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_21" name="ga_21" value="1" onclick="checkGA21(this)"/></td>
                                                <td>Approval 3 RAB</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_22" name="ga_22" value="1" onclick="checkGA22(this)"/></td>
                                                <td>List Reimbursement</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_23" name="ga_23" value="1" onclick="checkGA23(this)"/></td>
                                                <td>New Reimbursement</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_24" name="ga_24" value="1" onclick="checkGA24(this)"/></td>
                                                <td>New Type Reimbursement</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_25" name="ga_25" value="1" onclick="checkGA25(this)"/></td>
                                                <td>Approval 1 Reimbursement</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_26" name="ga_26" value="1" onclick="checkGA26(this)"/></td>
                                                <td>Approval 2 Reimbursement</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                <td rowspan="11" class="text-center"><input class="mt-1" type="checkbox" id="hr" name="hr" value="1" onclick="checkHR(this)"/></td>
                                                <td rowspan="11">HR</td>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_1" name="hr_1" value="1" onclick="checkHR1(this)"/></td>
                                                <td>List Attendance</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_2" name="hr_2" value="1" onclick="checkHR2(this)"/></td>
                                                <td>List Attendance - ALL</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_3" name="hr_3" value="1" onclick="checkHR3(this)"/></td>
                                                <td>List Employee</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_4" name="hr_4" value="1" onclick="checkHR4(this)"/></td>
                                                <td>New Employee</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_5" name="hr_5" value="1" onclick="checkHR5(this)"/></td>
                                                <td>Edit Employee</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_6" name="hr_6" value="1" onclick="checkHR6(this)"/></td>
                                                <td>Delete Employee</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_7" name="hr_7" value="1" onclick="checkHR7(this)"/></td>
                                                <td>List Leave Request</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_8" name="hr_8" value="1" onclick="checkHR8(this)"/></td>
                                                <td>New Leave Request</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_9" name="hr_9" value="1" onclick="checkHR9(this)"/></td>
                                                <td>Leave Allowance</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_10" name="hr_10" value="1" onclick="checkHR10(this)"/></td>
                                                <td>Approval 1 Leave Request</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_11" name="hr_11" value="1" onclick="checkHR11(this)"/></td>
                                                <td>Approval 2 Leave Request</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                <td rowspan="32" class="text-center"><input class="mt-1" type="checkbox" id="master_data" name="master_data" value="1" onclick="checkMD(this)"/></td>
                                                <td rowspan="32">Master Data</td>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_1" name="md_1" value="1" onclick="checkMD1(this)"/></td>
                                                <td>List Bank</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_2" name="md_2" value="1" onclick="checkMD2(this)"/></td>
                                                <td>New Bank</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_3" name="md_3" value="1" onclick="checkMD3(this)"/></td>
                                                <td>Edit Bank</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_4" name="md_4" value="1" onclick="checkMD4(this)"/></td>
                                                <td>Delete Bank</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_5" name="md_5" value="1" onclick="checkMD5(this)"/></td>
                                                <td>List Brand</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_6" name="md_6" value="1" onclick="checkMD6(this)"/></td>
                                                <td>New Brand</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_7" name="md_7" value="1" onclick="checkMD7(this)"/></td>
                                                <td>Edit Brand</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_8" name="md_8" value="1" onclick="checkMD8(this)"/></td>
                                                <td>Delete Brand</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_9" name="md_9" value="1" onclick="checkMD9(this)"/></td>
                                                <td>List Category</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_10" name="md_10" value="1" onclick="checkMD10(this)"/></td>
                                                <td>New Category</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_11" name="md_11" value="1" onclick="checkMD11(this)"/></td>
                                                <td>Edit Category</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_12" name="md_12" value="1" onclick="checkMD12(this)"/></td>
                                                <td>Delete Category</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_13" name="md_13" value="1" onclick="checkMD13(this)"/></td>
                                                <td>List Child Company</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_14" name="md_14" value="1" onclick="checkMD14(this)"/></td>
                                                <td>New Child Company</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_15" name="md_15" value="1" onclick="checkMD15(this)"/></td>
                                                <td>Edit Child Company</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_16" name="md_16" value="1" onclick="checkMD16(this)"/></td>
                                                <td>Delete Child Company</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_17" name="md_17" value="1" onclick="checkMD17(this)"/></td>
                                                <td>List Department</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_18" name="md_18" value="1" onclick="checkMD18(this)"/></td>
                                                <td>New Department</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_19" name="md_19" value="1" onclick="checkMD19(this)"/></td>
                                                <td>Edit Department</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_20" name="md_20" value="1" onclick="checkMD20(this)"/></td>
                                                <td>Delete Department</td>
                                            </tr>
                                            {{-- <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_17" name="md_17" value="1" onclick="checkMD17(this)"/></td>
                                                <td>List Department</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_18" name="md_18" value="1" onclick="checkMD18(this)"/></td>
                                                <td>New Department</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_19" name="md_19" value="1" onclick="checkMD19(this)"/></td>
                                                <td>Edit Department</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_20" name="md_20" value="1" onclick="checkMD20(this)"/></td>
                                                <td>Delete Department</td>
                                            </tr> --}}
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_21" name="md_21" value="1" onclick="checkMD21(this)"/></td>
                                                <td>List RAB Item</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_22" name="md_22" value="1" onclick="checkMD22(this)"/></td>
                                                <td>New RAB Item</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_23" name="md_23" value="1" onclick="checkMD23(this)"/></td>
                                                <td>Edit RAB Item</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_24" name="md_24" value="1" onclick="checkMD24(this)"/></td>
                                                <td>Delete RAB Item</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_25" name="md_25" value="1" onclick="checkMD25(this)"/></td>
                                                <td>List Site Warehouse</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_26" name="md_26" value="1" onclick="checkMD26(this)"/></td>
                                                <td>New Site Warehouse</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_27" name="md_27" value="1" onclick="checkMD27(this)"/></td>
                                                <td>Edit Site Warehouse</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_28" name="md_28" value="1" onclick="checkMD28(this)"/></td>
                                                <td>Delete Site Warehouse</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_29" name="md_29" value="1" onclick="checkMD29(this)"/></td>
                                                <td>List Vendor Asset</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_30" name="md_30" value="1" onclick="checkMD30(this)"/></td>
                                                <td>New Vendor Asset</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_31" name="md_31" value="1" onclick="checkMD31(this)"/></td>
                                                <td>Edit Vendor Asset</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="md_32" name="md_32" value="1" onclick="checkMD32(this)"/></td>
                                                <td>Delete Vendor Asset</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="calendar" name="calendar" value="1"/></td>
                                                <td colspan="3">Calendar</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="company_calendar" name="company_calendar" value="1"/></td>
                                                <td colspan="3">Corporate Calendar</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="google" name="google" value="1" onclick="checkGoogle(this)"/></td>
                                                <td>Google</td>
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="google_calendar" name="google_calendar" value="1" onclick="checkGoogle1(this)"/></td>
                                                <td>Google Calendar</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                            </div>
            <form method="post" id="menu" class="listMenu" enctype="multipart/form-data" action="{{ route('menu-setting.update', ['userId' => $dataMenu->id])}}">
                @csrf
                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                    <table id="tableMenuList" class="tableMenuList table table-bordered mt-3 bg-white"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">Main Menu</th>
                                                <th colspan="2" class="text-center">Sub Menu</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Show</th>
                                                <th class="text-center">Main Menu Name</th>
                                                <th class="text-center">Show</th>
                                                <th class="text-center">Submenu Name</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableMenuList" id="tableMenuList">
                                            <tr>
                                                @if ($dataMenu->kanban == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="kanban" name="kanban" value="1" checked/></td>
                                                    <td colspan="3"><li class="text-emerald-500 flex flex-auto">Kanban <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="kanban" name="kanban" value="1"/></td>
                                                    <td colspan="3">Kanban</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga == '1')
                                                    <td rowspan=26" class="text-center"><input class="mt-1" type="checkbox" id="ga" name="ga" value="1" onclick="checkGA(this)" checked/></td>  
                                                    <td rowspan=26"><li class="text-emerald-500 flex flex-auto">GA <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td rowspan="26" class="text-center"><input class="mt-1" type="checkbox" id="ga" name="ga" value="1" onclick="checkGA(this)"/></td>
                                                    <td rowspan="26">GA</td>
                                                @endif
                                                @if ($dataMenu->ga_1 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="ga_1" name="ga_1" value="1" onclick="checkGA1(this)" checked/></td>
                                                <td><li class="text-emerald-500 flex flex-auto">List Assigned Asset <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_1" name="ga_1" value="1" onclick="checkGA1(this)"/></td>
                                                    <td>List Assigned Asset</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_2 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_2" name="ga_2" value="1" onclick="checkGA2(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Assigned Asset <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_2" name="ga_2" value="1" onclick="checkGA2(this)"/></td>
                                                    <td>New Assigned Asset</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_3 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_3" name="ga_3" value="1" onclick="checkGA3(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Approval Assigned Asset <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_3" name="ga_3" value="1" onclick="checkGA3(this)"/></td>
                                                    <td>Approval Assigned Asset</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_4 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_4" name="ga_4" value="1" onclick="checkGA4(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Asset Code <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_4" name="ga_4" value="1" onclick="checkGA4(this)"/></td>
                                                    <td>List Asset Code</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_5 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_5" name="ga_5" value="1" onclick="checkGA5(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Asset Code <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_5" name="ga_5" value="1" onclick="checkGA5(this)"/></td>
                                                    <td>New Asset Code</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_6 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_6" name="ga_6" value="1" onclick="checkGA6(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Edit Asset Code <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_6" name="ga_6" value="1" onclick="checkGA6(this)"/></td>
                                                    <td>Edit Asset Code</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_7 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_7" name="ga_7" value="1" onclick="checkGA7(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Delete Asset Code <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_7" name="ga_7" value="1" onclick="checkGA7(this)"/></td>
                                                    <td>Delete Asset Code</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_8 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_8" name="ga_8" value="1" onclick="checkGA8(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Catalogue Fixed Asset <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_8" name="ga_8" value="1" onclick="checkGA8(this)"/></td>
                                                    <td>Catalogue Fixed Asset</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_9 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_9" name="ga_9" value="1" onclick="checkGA9(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Fixed Asset <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_9" name="ga_9" value="1" onclick="checkGA9(this)"/></td>
                                                    <td>List Fixed Asset</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_10 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_10" name="ga_10" value="1" onclick="checkGA10(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Fixed Asset <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_10" name="ga_10" value="1" onclick="checkGA10(this)"/></td>
                                                    <td>New Fixed Asset</td>
                                                @endif
                                            </tr>
                                            {{-- <tr>
                                                @if ($dataMenu->ga_11 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_11" name="ga_11" value="1" onclick="checkGA11(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Purchase Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_11" name="ga_11" value="1" onclick="checkGA11(this)"/></td>
                                                    <td>List Purchase Request</td>
                                                @endif
                                            </tr> --}}
                                            <tr>
                                                @if ($dataMenu->ga_11 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_11" name="ga_11" value="1" onclick="checkGA11(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Purchase Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_11" name="ga_11" value="1" onclick="checkGA11(this)"/></td>
                                                    <td>New Purchase Request</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_12 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_12" name="ga_12" value="1" onclick="checkGA12(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Purchase Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_12" name="ga_12" value="1" onclick="checkGA12(this)"/></td>
                                                    <td>Update Price Purchase Request</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_13 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_13" name="ga_13" value="1" onclick="checkGA13(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Purchase Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_13" name="ga_13" value="1" onclick="checkGA13(this)"/></td>
                                                    <td>Quotation Submit Purchase Request</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_14 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_14" name="ga_14" value="1" onclick="checkGA14(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Approval 1 Purchase Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_14" name="ga_14" value="1" onclick="checkGA14(this)"/></td>
                                                    <td>Approval 1 Purchase Request</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_15 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_15" name="ga_15" value="1" onclick="checkGA15(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Approval 2 Purchase Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_15" name="ga_15" value="1" onclick="checkGA15(this)"/></td>
                                                    <td>Approval 2 Purchase Request</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_16 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_16" name="ga_16" value="1" onclick="checkGA16(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Approval 3 Purchase Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_16" name="ga_16" value="1" onclick="checkGA16(this)"/></td>
                                                    <td>Approval 3 Purchase Request</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_17 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_17" name="ga_17" value="1" onclick="checkGA17(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List RAB <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_17" name="ga_17" value="1" onclick="checkGA17(this)"/></td>
                                                    <td>List RAB</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_18 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_18" name="ga_18" value="1" onclick="checkGA18(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New RAB <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_18" name="ga_18" value="1" onclick="checkGA18(this)"/></td>
                                                    <td>New RAB</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_19 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_19" name="ga_19" value="1" onclick="checkGA19(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Approval 1 RAB <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_19" name="ga_19" value="1" onclick="checkGA19(this)"/></td>
                                                    <td>Approval 1 RAB</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_20 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_20" name="ga_20" value="1" onclick="checkGA20(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Approval 2 RAB <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_20" name="ga_20" value="1" onclick="checkGA20(this)"/></td>
                                                    <td>Approval 2 RAB</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_21 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_21" name="ga_21" value="1" onclick="checkGA21(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Approval 3 RAB <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_21" name="ga_21" value="1" onclick="checkGA21(this)"/></td>
                                                    <td>Approval 3 RAB</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_22 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_22" name="ga_22" value="1" onclick="checkGA22(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Reimbursement <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_22" name="ga_22" value="1" onclick="checkGA22(this)"/></td>
                                                    <td>List Reimbursement</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_23 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_23" name="ga_23" value="1" onclick="checkGA23(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Reimbursement <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_23" name="ga_23" value="1" onclick="checkGA23(this)"/></td>
                                                    <td>New Reimbursement</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_24 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_24" name="ga_24" value="1" onclick="checkGA24(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Type Reimbursement <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_24" name="ga_24" value="1" onclick="checkGA24(this)"/></td>
                                                    <td>New Type Reimbursement</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_25 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_25" name="ga_25" value="1" onclick="checkGA25(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Approval 1 Reimbursement <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_25" name="ga_25" value="1" onclick="checkGA25(this)"/></td>
                                                    <td>Approval 1 Reimbursement</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->ga_26 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_26" name="ga_26" value="1" onclick="checkGA26(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Approval 2 Reimbursement <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="ga_26" name="ga_26" value="1" onclick="checkGA26(this)"/></td>
                                                    <td>Approval 2 Reimbursement</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr == '1')
                                                <td rowspan=11" class="text-center"><input class="mt-1" type="checkbox" id="hr" name="hr" value="1" onclick="checkHR(this)" checked/></td>  
                                                <td rowspan=11"><li class="text-emerald-500 flex flex-auto">HR <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td rowspan="11" class="text-center"><input class="mt-1" type="checkbox" id="hr" name="hr" value="1" onclick="checkHR(this)"/></td>
                                                <td rowspan="11">HR</td>
                                                @endif
                                                @if ($dataMenu->hr_1 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_1" name="hr_1" value="1" onclick="checkHR1(this)" checked/></td>  
                                                <td><li class="text-emerald-500 flex flex-auto">List Attendance <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td class="text-center"><input class="mt-1" type="checkbox" id=hr_1" name=hr_1" value="1" onclick="checkHR1(this)"/></td>
                                                <td>List Attendance</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr_2 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_2" name="hr_2" value="1" onclick="checkHR2(this)" checked/></td>  
                                                <td><li class="text-emerald-500 flex flex-auto">List Attendance - ALL <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="hr_2" name="hr_2" value="1" onclick="checkHR2(this)"/></td>
                                                    <td>List Attendance - ALL</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr_3 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_3" name="hr_3" value="1" onclick="checkHR3(this)" checked/></td> 
                                                <td><li class="text-emerald-500 flex flex-auto">List Employee <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_3" name="hr_3" value="1" onclick="checkHR3(this)"/></td>
                                                <td>List Employee</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr_4 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_4" name="hr_4" value="1" onclick="checkHR4(this)" checked/></td> 
                                                <td><li class="text-emerald-500 flex flex-auto">New Employee <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_4" name="hr_4" value="1" onclick="checkHR4(this)"/></td>
                                                <td>New Employee</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr_5 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_5" name="hr_5" value="1" onclick="checkHR5(this)" checked/></td>
                                                <td><li class="text-emerald-500 flex flex-auto">Edit Employee <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_5" name="hr_5" value="1" onclick="checkHR5(this)"/></td>
                                                <td>Edit Employee</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr_6 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_6" name="hr_6" value="1" onclick="checkHR6(this)" checked/></td>
                                                <td><li class="text-emerald-500 flex flex-auto">Delete Employee <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_6" name="hr_6" value="1" onclick="checkHR6(this)"/></td>
                                                <td>Delete Employee</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr_7 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_7" name="hr_7" value="1" onclick="checkHR7(this)" checked/></td>
                                                <td><li class="text-emerald-500 flex flex-auto">List Leave Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_7" name="hr_7" value="1" onclick="checkHR7(this)"/></td>
                                                <td>List Leave Request</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr_8 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_8" name="hr_8" value="1" onclick="checkHR8(this)" checked/></td>
                                                <td><li class="text-emerald-500 flex flex-auto">New Leave Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_8" name="hr_8" value="1" onclick="checkHR8(this)"/></td>
                                                <td>New Leave Request</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr_9 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_9" name="hr_9" value="1" onclick="checkHR9(this)" checked/></td>
                                                <td><li class="text-emerald-500 flex flex-auto">Leave Allowance <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_9" name="hr_9" value="1" onclick="checkHR9(this)"/></td>
                                                <td>Leave Allowance</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr_10 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_10" name="hr_10" value="1" onclick="checkHR10(this)" checked/></td>
                                                <td><li class="text-emerald-500 flex flex-auto">Approval 1 Leave Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_10" name="hr_10" value="1" onclick="checkHR10(this)"/></td>
                                                <td>Approval 1 Leave Request</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->hr_11 == '1')
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_11" name="hr_11" value="1" onclick="checkHR11(this)" checked/></td>
                                                <td><li class="text-emerald-500 flex flex-auto">Approval 2 Leave Request <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                </svg></li></td>
                                                @else
                                                <td class="text-center"><input class="mt-1" type="checkbox" id="hr_11" name="hr_11" value="1" onclick="checkHR11(this)"/></td>
                                                <td>Approval 2 Leave Request</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->master_data == '1')
                                                    <td rowspan="32" class="text-center"><input class="mt-1" type="checkbox" id="master_data" name="master_data" value="1" onclick="checkMD(this)" checked/></td>  
                                                    <td rowspan="32"><li class="text-emerald-500 flex flex-auto">Master Data <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td rowspan="32" class="text-center"><input class="mt-1" type="checkbox" id="master_data" name="master_data" value="1" onclick="checkMD(this)"/></td>
                                                    <td rowspan="32">Master Data</td>
                                                @endif
                                                @if ($dataMenu->md_1 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_1" name="md_1" value="1" onclick="checkMD1(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Bank <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_1" name="md_1" value="1" onclick="checkMD1(this)"/></td>
                                                    <td>List Bank</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_2 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_2" name="md_2" value="1" onclick="checkMD2(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Bank <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_2" name="md_2" value="1" onclick="checkMD2(this)"/></td>
                                                    <td>New Bank</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_3 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_3" name="md_3" value="1" onclick="checkMD3(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Edit Bank <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_3" name="md_3" value="1" onclick="checkMD3(this)"/></td>
                                                    <td>Edit Bank</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_4 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_4" name="md_4" value="1" onclick="checkMD4(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Delete Bank <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_4" name="md_4" value="1" onclick="checkMD4(this)"/></td>
                                                    <td>Delete Bank</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_5 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_5" name="md_5" value="1" onclick="checkMD5(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Brand <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_5" name="md_5" value="1" onclick="checkMD5(this)"/></td>
                                                    <td>List Brand</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_6 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_6" name="md_6" value="1" onclick="checkMD6(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Brand <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_6" name="md_6" value="1" onclick="checkMD6(this)"/></td>
                                                    <td>New Brand</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_7 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_7" name="md_7" value="1" onclick="checkMD7(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Edit Brand <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_7" name="md_7" value="1" onclick="checkMD7(this)"/></td>
                                                    <td>Edit Brand</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_8 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_8" name="md_8" value="1" onclick="checkMD8(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Delete Brand <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_8" name="md_8" value="1" onclick="checkMD8(this)"/></td>
                                                    <td>Delete Brand</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_9 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_9" name="md_9" value="1" onclick="checkMD9(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Category <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_9" name="md_9" value="1" onclick="checkMD9(this)"/></td>
                                                    <td>List Category</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_10 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_10" name="md_10" value="1" onclick="checkMD10(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Category <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_10" name="md_10" value="1" onclick="checkMD10(this)"/></td>
                                                    <td>New Category</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_11 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_11" name="md_11" value="1" onclick="checkMD11(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Edit Category <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_11" name="md_11" value="1" onclick="checkMD11(this)"/></td>
                                                    <td>Edit Category</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_12 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_12" name="md_12" value="1" onclick="checkMD12(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Delete Category <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_12" name="md_12" value="1" onclick="checkMD12(this)"/></td>
                                                    <td>Delete Category</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_13 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_13" name="md_13" value="1" onclick="checkMD13(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Child Company <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_13" name="md_13" value="1" onclick="checkMD13(this)"/></td>
                                                    <td>List Child Company</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_14 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_14" name="md_14" value="1" onclick="checkMD14(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Child Company <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_14" name="md_14" value="1" onclick="checkMD14(this)"/></td>
                                                    <td>New Child Company</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_15 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_15" name="md_15" value="1" onclick="checkMD15(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Edit Child Company <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_15" name="md_15" value="1" onclick="checkMD15(this)"/></td>
                                                    <td>Edit Child Company</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_16 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_16" name="md_16" value="1" onclick="checkMD16(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Delete Child Company <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_16" name="md_16" value="1" onclick="checkMD16(this)"/></td>
                                                    <td>Delete Child Company</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_17 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_17" name="md_17" value="1" onclick="checkMD17(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Department <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_17" name="md_17" value="1" onclick="checkMD17(this)"/></td>
                                                    <td>List Department</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_18 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_18" name="md_18" value="1" onclick="checkMD18(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Department <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_18" name="md_18" value="1" onclick="checkMD18(this)"/></td>
                                                    <td>New Department</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_19 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_19" name="md_19" value="1" onclick="checkMD19(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Edit Department <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_19" name="md_19" value="1" onclick="checkMD19(this)"/></td>
                                                    <td>Edit Department</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_20 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_20" name="md_20" value="1" onclick="checkMD20(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Delete Department <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_20" name="md_20" value="1" onclick="checkMD20(this)"/></td>
                                                    <td>Delete Department</td>
                                                @endif
                                            </tr>
                                            {{-- <tr>
                                                @if ($dataMenu->md_17 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_17" name="md_17" value="1" onclick="checkMD17(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Department <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_17" name="md_17" value="1" onclick="checkMD17(this)"/></td>
                                                    <td>List Department</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_18 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_18" name="md_18" value="1" onclick="checkMD18(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Department <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_18" name="md_18" value="1" onclick="checkMD18(this)"/></td>
                                                    <td>New Department</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_19 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_19" name="md_19" value="1" onclick="checkMD19(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Edit Department <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_19" name="md_19" value="1" onclick="checkMD19(this)"/></td>
                                                    <td>Edit Department</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_20 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_20" name="md_20" value="1" onclick="checkMD20(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Delete Department <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_20" name="md_20" value="1" onclick="checkMD20(this)"/></td>
                                                    <td>Delete Department</td>
                                                @endif
                                            </tr> --}}
                                            <tr>
                                                @if ($dataMenu->md_21 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_21" name="md_21" value="1" onclick="checkMD21(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List RAB Item <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_21" name="md_21" value="1" onclick="checkMD21(this)"/></td>
                                                    <td>List RAB Item</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_22 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_22" name="md_22" value="1" onclick="checkMD22(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New RAB Item <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_22" name="md_22" value="1" onclick="checkMD22(this)"/></td>
                                                    <td>New RAB Item</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_23 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_23" name="md_23" value="1" onclick="checkMD23(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Edit RAB Item <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_23" name="md_23" value="1" onclick="checkMD23(this)"/></td>
                                                    <td>Edit RAB Item</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_24 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_24" name="md_24" value="1" onclick="checkMD24(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Delete RAB Item <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_24" name="md_24" value="1" onclick="checkMD24(this)"/></td>
                                                    <td>Delete RAB Item</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_25 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_25" name="md_25" value="1" onclick="checkMD25(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Site Warehouse <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_25" name="md_25" value="1" onclick="checkMD25(this)"/></td>
                                                    <td>List Site Warehouse</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_26 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_26" name="md_26" value="1" onclick="checkMD26(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Site Warehouse <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_26" name="md_26" value="1" onclick="checkMD26(this)"/></td>
                                                    <td>New Site Warehouse</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_27 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_27" name="md_27" value="1" onclick="checkMD27(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Edit Site Warehouse <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_27" name="md_27" value="1" onclick="checkMD27(this)"/></td>
                                                    <td>Edit Site Warehouse</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_28 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_28" name="md_28" value="1" onclick="checkMD28(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Delete Site Warehouse <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_28" name="md_28" value="1" onclick="checkMD28(this)"/></td>
                                                    <td>Delete Site Warehouse</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_29 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_29" name="md_29" value="1" onclick="checkMD29(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">List Vendor Asset <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_29" name="md_29" value="1" onclick="checkMD29(this)"/></td>
                                                    <td>List Vendor Asset</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_30 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_30" name="md_30" value="1" onclick="checkMD30(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">New Vendor Asset <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_30" name="md_30" value="1" onclick="checkMD30(this)"/></td>
                                                    <td>New Vendor Asset</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_31 == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_31" name="md_31" value="1" onclick="checkMD31(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Edit Vendor Asset <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_31" name="md_31" value="1" onclick="checkMD31(this)"/></td>
                                                    <td>Edit Vendor Asset</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->md_32== '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_32" name="md_32" value="1" onclick="checkMD32(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Delete Vendor Asset <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="md_32" name="md_32" value="1" onclick="checkMD32(this)"/></td>
                                                    <td>Delete Vendor Asset</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->calendar == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="calendar" name="calendar" value="1" checked/></td>
                                                    <td colspan="3"><li class="text-emerald-500 flex flex-auto">Calendar <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="calendar" name="calendar" value="1"/></td>
                                                    <td colspan="3">Calendar</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->company_calendar == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="company_calendar" name="company_calendar" value="1" checked/></td>
                                                    <td colspan="3"><li class="text-emerald-500 flex flex-auto">Corporate Calendar <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="company_calendar" name="company_calendar" value="1"/></td>
                                                    <td colspan="3">Corporate Calendar</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                @if ($dataMenu->google == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="google" name="google" value="1" onclick="checkGoogle(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Google <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="google" name="google" value="1" onclick="checkGoogle(this)"/></td>
                                                    <td>Google</td>
                                                @endif
                                                @if ($dataMenu->google_calendar == '1')
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="google_calendar" name="google_calendar" value="1" onclick="checkGoogle1(this)" checked/></td>
                                                    <td><li class="text-emerald-500 flex flex-auto">Google Calendar <svg class="mt-0.5 ml-2 w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                    </svg></li></td>
                                                @else
                                                    <td class="text-center"><input class="mt-1" type="checkbox" id="google_calendar" name="google_calendar" value="1" onclick="checkGoogle1(this)"/></td>
                                                    <td>Google Calendar</td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            <div class="space-y-3">
                            </div>
                    </div>
                    @if ($search == '')
                    <center>
                            <button type="submit" class="btn btn-lg btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white disabled:bg-indigo-500" disabled>Set List Menu</button>
                    </center>
                    @else
                    <center>
                            <button type="submit" class="btn btn-lg btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white disabled:bg-indigo-500">Set List Menu</button>
                    </center>
                    @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#search').select2();
        });

        // function checkIncidentReport(ths) {
        //     if ($('#incident_report').is(':checked')) {
        //         $('#ir_1').prop('checked', true);
        //         $('#ir_2').prop('checked', true);
        //         $('#ir_3').prop('checked', true);
        //     } else {
        //         $('#ir_1').prop('checked', false);
        //         $('#ir_2').prop('checked', false);
        //         $('#ir_3').prop('checked', false);
        //     }
        // }
        
        // function checkIncidentReport1(ths) {
        //     if ($('#ir_1').is(':checked')) {
        //         $('#incident_report').prop('checked', true);
        //     }else if (!$('#ir_1').is(':checked') && !$('#ir_2').is(':checked') && !$('#ir_3').is(':checked')){
        //         $('#incident_report').prop('checked', false);
        //     }
        // }

        // function checkIncidentReport2(ths) {
        //     if ($('#ir_2').is(':checked')) {
        //         $('#incident_report').prop('checked', true);
        //     }else if (!$('#ir_1').is(':checked') && !$('#ir_2').is(':checked') && !$('#ir_3').is(':checked')){
        //         $('#incident_report').prop('checked', false);
        //     }
        // }

        // function checkIncidentReport3(ths) {
        //     if ($('#ir_3').is(':checked')) {
        //         $('#incident_report').prop('checked', true);
        //     }else if (!$('#ir_1').is(':checked') && !$('#ir_2').is(':checked') && !$('#ir_3').is(':checked')){
        //         $('#incident_report').prop('checked', false);
        //     }
        // }

        // function checkPurchasing(ths) {
        //     if ($('#purchasing').is(':checked')) {
        //         $('#pr_1').prop('checked', true);
        //         $('#pr_2').prop('checked', true);
        //         $('#pr_3').prop('checked', true);
        //         $('#pr_4').prop('checked', true);
        //         $('#pr_5').prop('checked', true);
        //         $('#pr_6').prop('checked', true);
        //     } else {
        //         $('#pr_1').prop('checked', false);
        //         $('#pr_2').prop('checked', false);
        //         $('#pr_3').prop('checked', false);
        //         $('#pr_4').prop('checked', false);
        //         $('#pr_5').prop('checked', false);
        //         $('#pr_6').prop('checked', false);
        //     }
        // }

        // function checkPurchasing1(ths) {
        //     if ($('#pr_1').is(':checked')) {
        //         $('#purchasing').prop('checked', true);
        //     }else if (!$('#pr_1').is(':checked') && !$('#pr_2').is(':checked') && !$('#pr_3').is(':checked')
        //     && !$('#pr_4').is(':checked') && !$('#pr_5').is(':checked') && !$('#pr_6').is(':checked')){
        //         $('#purchasing').prop('checked', false);
        //     }
        // }

        // function checkPurchasing2(ths) {
        //     if ($('#pr_2').is(':checked')) {
        //         $('#purchasing').prop('checked', true);
        //     }else if (!$('#pr_1').is(':checked') && !$('#pr_2').is(':checked') && !$('#pr_3').is(':checked')
        //     && !$('#pr_4').is(':checked') && !$('#pr_5').is(':checked') && !$('#pr_6').is(':checked')){
        //         $('#purchasing').prop('checked', false);
        //     }
        // }

        // function checkPurchasing3(ths) {
        //     if ($('#pr_3').is(':checked')) {
        //         $('#purchasing').prop('checked', true);
        //     }else if (!$('#pr_1').is(':checked') && !$('#pr_2').is(':checked') && !$('#pr_3').is(':checked')
        //     && !$('#pr_4').is(':checked') && !$('#pr_5').is(':checked') && !$('#pr_6').is(':checked')){
        //         $('#purchasing').prop('checked', false);
        //     }
        // }

        // function checkPurchasing4(ths) {
        //     if ($('#pr_4').is(':checked')) {
        //         $('#purchasing').prop('checked', true);
        //     }else if (!$('#pr_1').is(':checked') && !$('#pr_2').is(':checked') && !$('#pr_3').is(':checked')
        //     && !$('#pr_4').is(':checked') && !$('#pr_5').is(':checked') && !$('#pr_6').is(':checked')){
        //         $('#purchasing').prop('checked', false);
        //     }
        // }

        // function checkPurchasing5(ths) {
        //     if ($('#pr_5').is(':checked')) {
        //         $('#purchasing').prop('checked', true);
        //     }else if (!$('#pr_1').is(':checked') && !$('#pr_2').is(':checked') && !$('#pr_3').is(':checked')
        //     && !$('#pr_4').is(':checked') && !$('#pr_5').is(':checked') && !$('#pr_6').is(':checked')){
        //         $('#purchasing').prop('checked', false);
        //     }
        // }

        // function checkPurchasing6(ths) {
        //     if ($('#pr_6').is(':checked')) {
        //         $('#purchasing').prop('checked', true);
        //     }else if (!$('#pr_1').is(':checked') && !$('#pr_2').is(':checked') && !$('#pr_3').is(':checked')
        //     && !$('#pr_4').is(':checked') && !$('#pr_5').is(':checked') && !$('#pr_6').is(':checked')){
        //         $('#purchasing').prop('checked', false);
        //     }
        // }

        // function checkFinance(ths) {
        //     if ($('#finance').is(':checked')) {
        //         $('#fin_1').prop('checked', true);
        //         $('#fin_2').prop('checked', true);
        //         $('#fin_3').prop('checked', true);
        //         $('#fin_4').prop('checked', true);
        //     } else {
        //         $('#fin_1').prop('checked', false);
        //         $('#fin_2').prop('checked', false);
        //         $('#fin_3').prop('checked', false);
        //         $('#fin_4').prop('checked', false);
        //     }
        // }

        // function checkFinance1(ths) {
        //     if ($('#fin_1').is(':checked')) {
        //         $('#finance').prop('checked', true);
        //     }else if (!$('#fin_1').is(':checked') && !$('#fin_2').is(':checked') && !$('#fin_3').is(':checked')
        //     && !$('#fin_4').is(':checked')){
        //         $('#finance').prop('checked', false);
        //     }
        // }

        // function checkFinance2(ths) {
        //     if ($('#fin_2').is(':checked')) {
        //         $('#finance').prop('checked', true);
        //     }else if (!$('#fin_1').is(':checked') && !$('#fin_2').is(':checked') && !$('#fin_3').is(':checked')
        //     && !$('#fin_4').is(':checked')){
        //         $('#finance').prop('checked', false);
        //     }
        // }

        // function checkFinance3(ths) {
        //     if ($('#fin_3').is(':checked')) {
        //         $('#finance').prop('checked', true);
        //     }else if (!$('#fin_1').is(':checked') && !$('#fin_2').is(':checked') && !$('#fin_3').is(':checked')
        //     && !$('#fin_4').is(':checked')){
        //         $('#finance').prop('checked', false);
        //     }
        // }

        // function checkFinance4(ths) {
        //     if ($('#fin_4').is(':checked')) {
        //         $('#finance').prop('checked', true);
        //     }else if (!$('#fin_1').is(':checked') && !$('#fin_2').is(':checked') && !$('#fin_3').is(':checked')
        //     && !$('#fin_4').is(':checked')){
        //         $('#finance').prop('checked', false);
        //     }
        // }

        function checkHR(ths){
            if ($('#hr').is(':checked')) {
                $('#hr_1').prop('checked', true);
                $('#hr_2').prop('checked', true);
                $('#hr_3').prop('checked', true);
                $('#hr_4').prop('checked', true);
                $('#hr_5').prop('checked', true);
                $('#hr_6').prop('checked', true);
                $('#hr_7').prop('checked', true);
                $('#hr_8').prop('checked', true);
                $('#hr_9').prop('checked', true);
                $('#hr_10').prop('checked', true);
                $('#hr_11').prop('checked', true);
            } else {
                $('#hr_1').prop('checked', false);
                $('#hr_2').prop('checked', false);
                $('#hr_3').prop('checked', false);
                $('#hr_4').prop('checked', false);
                $('#hr_5').prop('checked', false);
                $('#hr_6').prop('checked', false);
                $('#hr_7').prop('checked', false);
                $('#hr_8').prop('checked', false);
                $('#hr_9').prop('checked', false);
                $('#hr_10').prop('checked', false);
                $('#hr_11').prop('checked', false);
            }
        }

            function checkHR1(ths) {
                if ($('#hr_1').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkHR2(ths) {
                if ($('#hr_2').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkHR3(ths) {
                if ($('#hr_3').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkHR4(ths) {
                if ($('#hr_4').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkHR5(ths) {
                if ($('#hr_5').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkHR6(ths) {
                if ($('#hr_6').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkHR7(ths) {
                if ($('#hr_7').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkHR8(ths) {
                if ($('#hr_8').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkHR9(ths) {
                if ($('#hr_9').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkHR10(ths) {
                if ($('#hr_10').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkHR11(ths) {
                if ($('#hr_11').is(':checked')) {
                    $('#hr').prop('checked', true);
                }else if (!$('#hr_1').is(':checked') && !$('#hr_2').is(':checked') && !$('#hr_3').is(':checked')
                && !$('#hr_4').is(':checked') && !$('#hr_5').is(':checked') && !$('#hr_6').is(':checked') && !$('#hr_7').is(':checked')
                && !$('#hr_8').is(':checked') && !$('#hr_9').is(':checked') && !$('#hr_10').is(':checked') && !$('#hr_11').is(':checked')){
                    $('#hr').prop('checked', false);
                }
            }

            function checkGA(ths){
                if ($('#ga').is(':checked')) {
                    $('#ga_1').prop('checked', true);
                    $('#ga_2').prop('checked', true);
                    $('#ga_3').prop('checked', true);
                    $('#ga_4').prop('checked', true);
                    $('#ga_5').prop('checked', true);
                    $('#ga_6').prop('checked', true);
                    $('#ga_7').prop('checked', true);
                    $('#ga_8').prop('checked', true);
                    $('#ga_9').prop('checked', true);
                    $('#ga_10').prop('checked', true);
                    $('#ga_11').prop('checked', true);
                    $('#ga_12').prop('checked', true);
                    $('#ga_13').prop('checked', true);
                    $('#ga_14').prop('checked', true);
                    $('#ga_15').prop('checked', true);
                    $('#ga_16').prop('checked', true);
                    $('#ga_17').prop('checked', true);
                    $('#ga_18').prop('checked', true);
                    $('#ga_19').prop('checked', true);
                    $('#ga_20').prop('checked', true);
                    $('#ga_21').prop('checked', true);
                    $('#ga_22').prop('checked', true);
                    $('#ga_23').prop('checked', true);
                    $('#ga_24').prop('checked', true);
                    $('#ga_25').prop('checked', true);
                    $('#ga_26').prop('checked', true);
                } else {
                    $('#ga_1').prop('checked', false);
                    $('#ga_2').prop('checked', false);
                    $('#ga_3').prop('checked', false);
                    $('#ga_4').prop('checked', false);
                    $('#ga_5').prop('checked', false);
                    $('#ga_6').prop('checked', false);
                    $('#ga_7').prop('checked', false);
                    $('#ga_8').prop('checked', false);
                    $('#ga_9').prop('checked', false);
                    $('#ga_10').prop('checked', false);
                    $('#ga_11').prop('checked', false);
                    $('#ga_12').prop('checked', false);
                    $('#ga_13').prop('checked', false);
                    $('#ga_14').prop('checked', false);
                    $('#ga_15').prop('checked', false);
                    $('#ga_16').prop('checked', false);
                    $('#ga_17').prop('checked', false);
                    $('#ga_18').prop('checked', false);
                    $('#ga_19').prop('checked', false);
                    $('#ga_20').prop('checked', false);
                    $('#ga_21').prop('checked', false);
                    $('#ga_22').prop('checked', false);
                    $('#ga_23').prop('checked', false);
                    $('#ga_24').prop('checked', false);
                    $('#ga_25').prop('checked', false);
                    $('#ga_26').prop('checked', false);
                }
            }

            function checkGA1(ths) {
                if ($('#ga_1').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA2(ths) {
                if ($('#ga_2').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA3(ths) {
                if ($('#ga_3').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA4(ths) {
                if ($('#ga_4').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA5(ths) {
                if ($('#ga_5').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA6(ths) {
                if ($('#ga_6').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA7(ths) {
                if ($('#ga_7').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA8(ths) {
                if ($('#ga_8').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA9(ths) {
                if ($('#ga_9').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA10(ths) {
                if ($('#ga_10').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA11(ths) {
                if ($('#ga_11').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA12(ths) {
                if ($('#ga_12').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA13(ths) {
                if ($('#ga_13').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA14(ths) {
                if ($('#ga_14').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA15(ths) {
                if ($('#ga_15').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA16(ths) {
                if ($('#ga_16').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA17(ths) {
                if ($('#ga_17').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA18(ths) {
                if ($('#ga_18').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA19(ths) {
                if ($('#ga_19').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA20(ths) {
                if ($('#ga_20').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA21(ths) {
                if ($('#ga_21').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA22(ths) {
                if ($('#ga_22').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA23(ths) {
                if ($('#ga_23').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA24(ths) {
                if ($('#ga_24').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA25(ths) {
                if ($('#ga_25').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkGA26(ths) {
                if ($('#ga_26').is(':checked')) {
                    $('#ga').prop('checked', true);
                }else if (!$('#ga_1').is(':checked') && !$('#ga_2').is(':checked') && !$('#ga_3').is(':checked')
                && !$('#ga_4').is(':checked') && !$('#ga_5').is(':checked') && !$('#ga_6').is(':checked') && !$('#ga_7').is(':checked')
                && !$('#ga_8').is(':checked') && !$('#ga_9').is(':checked') && !$('#ga_10').is(':checked') && !$('#ga_11').is(':checked')
                && !$('#ga_12').is(':checked') && !$('#ga_13').is(':checked') && !$('#ga_14').is(':checked') && !$('#ga_15').is(':checked')
                && !$('#ga_16').is(':checked') && !$('#ga_17').is(':checked') && !$('#ga_18').is(':checked') && !$('#ga_19').is(':checked')
                && !$('#ga_20').is(':checked') && !$('#ga_21').is(':checked') && !$('#ga_22').is(':checked') && !$('#ga_23').is(':checked') && !$('#ga_24').is(':checked') && !$('#ga_25').is(':checked')
                && !$('#ga_26').is(':checked')){
                    $('#ga').prop('checked', false);
                }
            }

            function checkMD(ths){
                if ($('#master_data').is(':checked')) {
                    $('#md_1').prop('checked', true);
                    $('#md_2').prop('checked', true);
                    $('#md_3').prop('checked', true);
                    $('#md_4').prop('checked', true);
                    $('#md_5').prop('checked', true);
                    $('#md_6').prop('checked', true);
                    $('#md_7').prop('checked', true);
                    $('#md_8').prop('checked', true);
                    $('#md_9').prop('checked', true);
                    $('#md_10').prop('checked', true);
                    $('#md_11').prop('checked', true);
                    $('#md_12').prop('checked', true);
                    $('#md_13').prop('checked', true);
                    $('#md_14').prop('checked', true);
                    $('#md_15').prop('checked', true);
                    $('#md_16').prop('checked', true);
                    $('#md_17').prop('checked', true);
                    $('#md_18').prop('checked', true);
                    $('#md_19').prop('checked', true);
                    $('#md_20').prop('checked', true);
                    $('#md_21').prop('checked', true);
                    $('#md_22').prop('checked', true);
                    $('#md_23').prop('checked', true);
                    $('#md_24').prop('checked', true);
                    $('#md_25').prop('checked', true);
                    $('#md_26').prop('checked', true);
                    $('#md_27').prop('checked', true);
                    $('#md_28').prop('checked', true);
                    $('#md_29').prop('checked', true);
                    $('#md_30').prop('checked', true);
                    $('#md_31').prop('checked', true);
                    $('#md_32').prop('checked', true);
                } else {
                    $('#md_1').prop('checked', false);
                    $('#md_2').prop('checked', false);
                    $('#md_3').prop('checked', false);
                    $('#md_4').prop('checked', false);
                    $('#md_5').prop('checked', false);
                    $('#md_6').prop('checked', false);
                    $('#md_7').prop('checked', false);
                    $('#md_8').prop('checked', false);
                    $('#md_9').prop('checked', false);
                    $('#md_10').prop('checked', false);
                    $('#md_11').prop('checked', false);
                    $('#md_12').prop('checked', false);
                    $('#md_13').prop('checked', false);
                    $('#md_14').prop('checked', false);
                    $('#md_15').prop('checked', false);
                    $('#md_16').prop('checked', false);
                    $('#md_17').prop('checked', false);
                    $('#md_18').prop('checked', false);
                    $('#md_19').prop('checked', false);
                    $('#md_20').prop('checked', false);
                    $('#md_21').prop('checked', false);
                    $('#md_22').prop('checked', false);
                    $('#md_23').prop('checked', false);
                    $('#md_24').prop('checked', false);
                    $('#md_25').prop('checked', false);
                    $('#md_26').prop('checked', false);
                    $('#md_27').prop('checked', false);
                    $('#md_28').prop('checked', false);
                    $('#md_29').prop('checked', false);
                    $('#md_30').prop('checked', false);
                    $('#md_31').prop('checked', false);
                    $('#md_32').prop('checked', false);
                }
            }

            function checkMD1(ths) {
                if ($('#md_1').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD2(ths) {
                if ($('#md_2').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD3(ths) {
                if ($('#md_3').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD4(ths) {
                if ($('#md_4').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD5(ths) {
                if ($('#md_5').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD6(ths) {
                if ($('#md_6').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD7(ths) {
                if ($('#md_7').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD8(ths) {
                if ($('#md_8').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD9(ths) {
                if ($('#md_9').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD10(ths) {
                if ($('#md_10').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD11(ths) {
                if ($('#md_11').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD12(ths) {
                if ($('#md_12').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD13(ths) {
                if ($('#md_13').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD14(ths) {
                if ($('#md_14').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD15(ths) {
                if ($('#md_15').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD16(ths) {
                if ($('#md_16').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD17(ths) {
                if ($('#md_17').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD18(ths) {
                if ($('#md_18').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD19(ths) {
                if ($('#md_19').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD20(ths) {
                if ($('#md_20').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD21(ths) {
                if ($('#md_21').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD22(ths) {
                if ($('#md_22').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD23(ths) {
                if ($('#md_23').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD24(ths) {
                if ($('#md_24').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD25(ths) {
                if ($('#md_25').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD26(ths) {
                if ($('#md_26').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }
            
            function checkMD27(ths) {
                if ($('#md_27').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD28(ths) {
                if ($('#md_28').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD29(ths) {
                if ($('#md_29').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD30(ths) {
                if ($('#md_30').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD31(ths) {
                if ($('#md_31').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

            function checkMD32(ths) {
                if ($('#md_16').is(':checked')) {
                    $('#master_data').prop('checked', true);
                }else if (!$('#md_1').is(':checked') && !$('#md_2').is(':checked') && !$('#md_3').is(':checked')
                && !$('#md_4').is(':checked') && !$('#md_5').is(':checked') && !$('#md_6').is(':checked') && !$('#md_7').is(':checked')
                && !$('#md_8').is(':checked') && !$('#md_9').is(':checked') && !$('#md_10').is(':checked') && !$('#md11').is(':checked')
                && !$('#md_12').is(':checked') && !$('#md_13').is(':checked') && !$('#md_14').is(':checked') && !$('#md_15').is(':checked') && !$('#md_16').is(':checked')
                && !$('#md_17').is(':checked') && !$('#md_18').is(':checked') && !$('#md_19').is(':checked') && !$('#md_20').is(':checked') && !$('#md_21').is(':checked')
                && !$('#md_22').is(':checked') && !$('#md_23').is(':checked') && !$('#md_24').is(':checked') && !$('#md_25').is(':checked') && !$('#md_26').is(':checked')
                && !$('#md_27').is(':checked') && !$('#md_28').is(':checked') && !$('#md_29').is(':checked') && !$('#md_30').is(':checked') && !$('#md_31').is(':checked')
                && !$('#md_32').is(':checked')){
                    $('#master_data').prop('checked', false);
                }
            }

        function checkGoogle(ths) {
            if ($('#google').is(':checked')) {
                $('#google_calendar').prop('checked', true);
            } else {
                $('#google_calendar').prop('checked', false);
            }
        }
        
        function checkGoogle1(ths) {
            if ($('#google_calendar').is(':checked')) {
                $('#google').prop('checked', true);
            }else{
                $('#google').prop('checked', false);
            }
        }
    </script>
    @endsection
</x-app-layout>
