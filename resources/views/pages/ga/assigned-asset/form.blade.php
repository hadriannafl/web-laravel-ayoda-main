<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Assigned/Return Asset 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('assigned-asset.create') }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Form Date<span
                        class="text-rose-500">*</span></label>
                    <input id="date" name="date"
                    class="date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                    Value="{{date('Y-m-d')}}" required/>
                </div>
                {{-- <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Form Date<span
                            class="text-rose-500">*</span></label>
                    @php
                        // Menggunakan Carbon untuk mengubah format tampilan tanggal
                        $formattedDate = \Carbon\Carbon::parse(date('Y-m-d'))->format('Y-m-d');
                    @endphp
                    <input id="date" name="date" class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" value="{{ $formattedDate }}" pattern="\d{4}-\d{2}-\d{2}" title="Please enter date in yyyy-mm-dd format" required />
                </div>           --}}
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="type">Type Assigned<span
                        class="text-rose-500">*</span>
                    </label>
                    <select id="type" name="type"
                            class="type form-select w-full md:w-3/4 px-2 py-1" required>
                            <option selected hidden value="">Select Type...</option>
                            <option value="Assign">Assign</option>
                            <option value="Return">Return</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="company">Company<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="company" name="company"
                        class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="employee1">User<span
                        class="text-rose-500">*</span>
                    </label>
                    <input class="employee form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="employee" name="employee" hidden readonly>
                    <input class="employee1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="employee1" name="employee1" readonly>
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
                                            Employee</div>
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
                                        <div class="flex flex-row text-xs mb-3">
                                            @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                                                    <label class="flex flex-row text-xs">
                                                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="company12">Company :</p>
                                                        <select id="company12" class="company12 flex flex-row ml-3 mb-3 text-xs" name="company12">
                                                            <option value="">All</option>
                                                            @foreach ( $dataChildCompany as $company)
                                                            <option value="{{$company->id_company}}">{{$company->name}}</option>
                                                            @endforeach
                                                        </select>
                                                @else
                                                    <input id="company12" name="company12"
                                                    class="company12 form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                                    value="{{$dataChildCompany->id_company}}" readonly hidden/>
                                                @endif
                                            </div>
                                        <table id="employee-table"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">NIK</th>
                                                    <th class="text-center">Day Of Birth</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Gender</th>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Employee Type</th>
                                                    <th class="text-center">Department</th>
                                                    <th class="text-center">Structural Title</th>
                                                    <th class="text-center">Position</th>
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
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Add List Assigned/Return<span
                    class="text-rose-500">*</span>
                    </label>
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-10 btn bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                            <svg class="w-4 h-4 fill-current  text-slate-200" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
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
                            @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add List Assigned/Return</div>
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
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="nama_product">Fixed Asset Name :<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="nama_product" name="nama_product" style="width: 58.5rem;"
                                        class="nama_product form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required/>
                                        <input id="assetId" name="assetId"
                                        class="assetId form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required hidden/>
                                        <input id="companiess1" name="companiess1"
                                        class="companiess1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required hidden/>
                                        <input id="warehouses1" name="warehouses1"
                                        class="warehouses1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required hidden/>
                                        <div x-data="{ modalOpen: false }">
                                            <button type="button"
                                                class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click.prevent="modalOpen = true"
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
                                                            <div class="font-semibold text-slate-800">Select Fixed Asset</div>
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
                                                            <!-- label -->
                                                            <div class="flex flex-row mb-3">
                                                                <div class="rounded-full bg-sky-500 columns-1 h-5 w-5"></div>
                                                                <p class="flex flex-row ml-1 text-sm font-medium">Ready</p>
                                                                <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
                                                                <p class="flex flex-row ml-1 text-sm font-medium">In Use/Assigned</p>
                                                            </div>
                                                            <div class="flex flex-row text-xs mb-3">
                                                                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                                                                <label class="flex flex-row text-xs">
                                                                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status123">Available Status :</p>
                                                                    <select id="status123" class="status123 flex flex-row ml-3 mb-3 text-xs" name="status123">
                                                                        <option value="">All</option>
                                                                        <option value="Y">Ready</option>
                                                                        <option value="N">In Use/Assigned</option>
                                                                    </select>
                                                                <label class="flex flex-row text-xs">
                                                                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 ml-5" for="company123">Company :</p>
                                                                    <select id="company123" class="company123 flex flex-row ml-3 mb-3 text-xs" name="company123">
                                                                        <option value="">All</option>
                                                                        @foreach ( $dataChildCompany as $company)
                                                                        <option value="{{$company->id_company}}">{{$company->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                @else
                                                                    <label class="flex flex-row text-xs" hidden>
                                                                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status123">Available Status :</p>
                                                                    <select id="status123" class="status123 flex flex-row ml-3 mb-3 text-xs" name="status123">
                                                                        <option value="">All</option>
                                                                        <option value="Y">Yes</option>
                                                                        <option value="N">No</option>
                                                                    </select>
                                                                    <input id="company123" name="company123"
                                                                    class="company123 form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                                                                    value="{{$dataChildCompany->id_company}}" readonly hidden/>
                                                                @endif
                                                            </div>
                                                            <table id="assetInv"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th class="text-center">Fixed Asset Code</th>
                                                                        <th class="text-center">Asset Name</th>
                                                                        <th class="text-center">Company</th>
                                                                        <th class="text-center">Warehouse Address</th>
                                                                        <th class="text-center">Detail</th>
                                                                        <th class="text-center">Available</th>
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
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="remarks">Remarks
                                        </label>
                                        <input id="remarks" name="remarks"
                                            class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                            <button type="button"
                                                class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click="modalOpen = false" id="addProduct">Add List</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Fixed Asset Code</th>
                                <th class="text-sm text-center">Asset Name</th>
                                <th class="text-sm text-center">Company</th>
                                <th class="text-sm text-center">Warehouse Address</th>
                                <th class="text-sm text-center">Remarks</th> 
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <input id="qtyTotal" name="qtyTotal" class="qtyTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required hidden/>
                <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required hidden/>
                    <div class="flex flex-row justify-center">
                        <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5 ml-3" type="submit" id="create_offer">
                            <span class="xs:block ml-5 mr-5">Make Assigned/Return</span>
                        </button>
                    </div>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
$('#type').on('change', function (e) {
    const type123 = $('#type').val();
    if (type123 === 'Assign') {
        $('#status123').val('Y');
        $('#assetInv').DataTable().ajax.reload();
    }else if (type123 === 'Return') {
        $('#status123').val('N');
        $('#assetInv').DataTable().ajax.reload();
    }
})
$(document).ready(function () {
    $('#employee-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,
        language: {
            search: "Search Employee : "
        },
            ajax: {
            url: "{{ route('assigned-asset.employee') }}",
                data:function(d){                    
                    d.company12 = $("#company12").val()
                }
            },
        columns: [
            {
                data: "nik",
                name: "nik"
            },
            {
                data: "DoB",
                name: "DoB"                    
            },
            {               
                data: "first_name",
                name: "first_name"
            },
            {
                data: "gen",
                name: "gen"
            },
            {
                data: "company",
                name: "company"
            },
            {
                data: "employee_type",
                name: "employee_type"
            },
            {
                data: "department",
                name: "department"
            },
            {
                data: "title_structural",
                name: "title_structural"
            },
            {
                data: "position",
                name: "position"
            },
            {
                data: "action",
                name: "action"
            },
        ],
        columnDefs: [
            { className: 'text-center', targets: [0, 1, 3, 9] },
        ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
    });
    $('#company12').on('change', function (e) {
        $('#employee-table').DataTable().ajax.reload();
    })
    $('#assetInv').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,
        "order": [[ 1, "asc" ]],
        language: {
                    search: "Search Fixed Asset Code : "
                },
                ajax: {
                    url: "{{ route('fixedasset.getdata') }}",
                        data:function(d){                    
                            d.status123 = $("#status123").val()
                            d.company123 = $("#company123").val()
                        }
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "idfa",
                        name: "idfa"
                    },
                    {
                        data: "assetName",
                        name: "assetName"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "warehouse",
                        name: "warehouse"
                    },
                    {
                        data: "detail",
                        name: "detail"
                    },
                    {
                        data: "avail",
                        name: "avail"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1, 6, 7] },
            ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
    });
    $('#status123').on('change', function (e) {
        $('#assetInv').DataTable().ajax.reload();
    })
    $('#company123').on('change', function (e) {
        $('#assetInv').DataTable().ajax.reload();
    })
});
$('#assetInv').on("click", ".btn-select", function () {
    const idAsset = $(this).data("id");
    const nameAsset = $(this).data("nama");
    const company = $(this).data("company");
    const warehouse = $(this).data("warehouse");
                
    $("#assetId").val(idAsset);
    $("#nama_product").val(nameAsset);
    $("#companiess1").val(company);
    $("#warehouses1").val(warehouse);
});
$('#employee-table').on("click", ".btn-select", function () {
    const id = $(this).data("id");
    const name = $(this).data("nama");
    const company = $(this).data("company");
                
    $("#employee").val(id);
    $("#employee1").val(name);
    $("#company").val(company);
    $('#company12').val(company);
    $('#company123').val(company);
    $('#assetInv').DataTable().ajax.reload();
});

// data product
    let productIdx = 0;
    $(document).ready(function () {
        $("#addProduct").click(function () {
            var id = $('#assetId').val();
            var name = $('#nama_product').val();
            var com = $('#companiess1').val();
            var ware = $('#warehouses1').val();
            var remarks = $('#remarks').val();

            // Check for duplicate ID
            var isDuplicate = $('#tableProductAddBody tr').filter(function () {
                return $(this).find('[name*="[ids]"]').val() === id;
            }).length > 0;

            if (isDuplicate) {
                alert('Same Fixed Asset cannot be added again.');
                return false;
            }
            
                var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                "  <td class=\"text-center\">" + id + "<textarea name = \"rows[" + productIdx + "][ids]\" hidden>" + id + "</textarea></td>\n" +
                "  <td class=\"text-left\">" + name + "</td>\n" +
                "  <td class=\"text-left\">" + com + "</td>\n" +
                "  <td class=\"text-left\">" + ware + "</td>\n" +
                "  <td class=\"text-left\">" + remarks + "<textarea name = \"rows[" + productIdx + "][remarkss]\" hidden>" + remarks + "</textarea></td>\n" +
                "  <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + null + ")\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
                "</tr>";


            if (!name || !id) {
                return false;
            }

            $("#tableProductAddBody").append(tr);

            $('#assetId').val('');
            $('#nama_product').val('');
            $('#companiess1').val('');
            $('#warehouses1').val('');
            $('#remarks').val('');

            productIdx++;
        });
    });
    
    function deleteDataProduct(positionTableRow) {
        const positionTableRowVariable = positionTableRow
        $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();
    }
</script>
@endsection
</x-app-layout>