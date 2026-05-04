<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Form RAB LPJ📝</h1>
        </div>
        {{-- <div class="px-5 py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">
                <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
                <p class="flex flex-row ml-1">On Budget</p>
                <div class="rounded-full bg-red-500 columns-1 h-5 w-5 ml-5"></div>
                <p class="flex flex-row ml-1">Over Budget</p>
            </div>
        </div> --}}

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('purchase-request.createga') }}" id="form_create1">
                @csrf
                {{-- <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">LPJ Date<span
                        class="text-rose-500">*</span></label>
                    <input id="date" name="date"
                        class="date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{date('Y-m-d')}}" data-date-format="YYYY/MM/DD" type="date" required/>
                </div> --}}
                <input type="text" id="user" value="{{Auth::user()->username}}" hidden/>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="Rab123">RAB<span
                        class="text-rose-500">*</span>
                    </label>
                    <input class="idRab form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="idRab" name="idRab" readonly hidden required>
                    <input class="Rab123 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="Rab123" name="Rab123" required readonly>
                    <input class="departs form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="departs" name="departs" required readonly hidden>
                    <div x-data="{ modalOpen: false }">
                        <button type="button"
                            class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white rabSelector"
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
                                @keydown.escape.window="modalOpen = false"
                                >
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Select
                                            RAB</div>
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
                                    <div class="flex flex-row text-xs">
                                        <label class="flex flex-row text-xs">
                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3" for="department">Department :</p>
                                            <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                                                <option value="" selected>All</option>
                                                @foreach ($department as $dept)
                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="rabItem"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Period</th>
                                                    <th class="text-center">RAB #</th>
                                                    <th class="text-center">RAB Type</th>
                                                    <th class="text-center">RAB Title</th>
                                                    <th class="text-center">Company</th>
                                                    <th class="text-center">Department</th>
                                                    <th class="text-center">Budget</th>
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
                <div class="flex flex-row mb-3 mt-3" id="periodeRAB1">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="period1">RAB Period / User Applicant / Company<span
                        class="text-rose-500"></span>
                    </label>
                    <div style="width: 20.8rem; margin-right: 20px;">                                
                        <input id="period1" name="period1" class="period1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                    </div>
                    <div style="width: 20.8rem; margin-right: 20px;">                                
                        <input id="name" name="name"
                            class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="" readonly/>
                    </div>
                    <div>
                        <input id="company" name="company" style="width: 21.2rem;"
                            class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="" readonly/>
                        <input id="balanceRab" name="balanceRab" style="width: 21.2rem;"
                            class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="" readonly/>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row mt-3" id="periodeRAB" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="period">RAB Period<span
                        class="text-rose-500"></span>
                    </label>
                    <input id="period" name="period" class="period form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                </div>
                <div class="flex md:flex-row mt-3">
                    <label class="block w-1/4 text-sm"></label>
                    <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white mr-5" id="changeRab" hidden>Change RAB</button>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    {{-- <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id">User (Applicant)<span
                        class="text-rose-500"></span></label> --}}
                    <input id="id" name="id"
                        class="id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="" readonly hidden/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    {{-- <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="company">Company<span
                        class="text-rose-500"></span> --}}
                    </label>
                    <input id="id_company" name="id_company"
                        class="id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="" readonly hidden/>
                </div>
                {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="level">Request Level<span
                        class="text-rose-500">*</span>
                    </label>
                    <select id="level" name="level"
                        class="level form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Level</option>
                        <option value="Normal">Normal</option>
                        <option value="Important">Important</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div> --}}
                {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="notes form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        rows="3"></textarea>
                </div> --}}
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Add LPJ Detail<span
                    class="text-rose-500">*</span>
                    </label>
                    {{-- @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') --}}
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn btn-rab bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal1" disabled>
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
                            @click.outside="modalOpen = false"
                            @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add LPJ Detail</div>
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
                                            for="nama_product">Description<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="nama_product" name="nama_product" style="width: 58.5rem;"
                                        class="nama_product form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" required/>
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
                                            <div id="feedback-modal-content"
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
                                                        {{-- <div class="flex justify-between items-center">
                                                            <div class="font-semibold text-slate-800">Select RAB Item</div>
                                                            <button type="button"
                                                                class="text-slate-400 hover:text-slate-500"
                                                                @click="modalOpen = false">
                                                                <div class="sr-only">Close</div>
                                                                <svg class="w-4 h-4 fill-current">
                                                                    <path
                                                                        d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                                </svg>
                                                            </button>
                                                        </div> --}}
                                                    </div>
                                                    <!-- Modal content -->
                                                    <div class="modal-content text-xs px-5 py-4">
                                                        <div class="flex justify-end">
                                                            <button class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3" id="selectAllRAB" @click="modalOpen = false" type="button">Add All Item</button>
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table id="assetInv"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">RAB #</th>
                                                                        <th class="text-center">Type</th>
                                                                        <th class="text-center">Department</th>
                                                                        <th class="text-center">Sub Department</th>
                                                                        <th class="text-center">Inventory Name</th>
                                                                        <th class="text-center">Balance</th>
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
                                        <input id="assetId" name="assetId"
                                            class="assetId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                        <input id="rabId" name="rabId"
                                            class="rabId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                        {{-- <input id="budget" name="budget"
                                            class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/> --}}
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="reff">Reff<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="reff" name="reff"
                                            class="reff form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="reff_date">Reff Date<span
                                            class="text-rose-500"></span>
                                        </label>
                                        <input id="reff_date" name="reff_date" value="{{date('Y-m-d')}}" data-date-format="YYYY/MM/DD" type="date"
                                            class="reff_date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="budget">Budget<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="budget" name="budget"
                                            class="budget numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0"/>
                                        <input id="balancess" name="balancess"
                                            class="balancess numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0" hidden/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file45">Attachment Document<span
                                            class="text-rose-500">*</span></label>
                                        <input id="file45" name="file45" class="file45 form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf" required/>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                            <button type="button"
                                                class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click="modalOpen = false" id="addProduct">Add Asset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @else
                    <div x-data="{ modalOpen: false }" id="modalForm">
                        <button class="ml-2 btn btn-rab bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal1" disabled>
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
                            @click.outside="modalOpen = false"
                            @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add Purchase Detail</div>
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
                                            for="nama_product">Asset Name<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="nama_product" name="nama_product" style="width: 58.5rem;"
                                        class="nama_product form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required/>
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
                                                            <div class="font-semibold text-slate-800">Select RAB Item</div>
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
                                                        <div class="flex justify-end">
                                                            <button class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3" id="selectAllRAB" @click="modalOpen = false" type="button">Add All Item</button> 
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table id="assetInv"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">RAB #</th>
                                                                        <th class="text-center">Type</th>
                                                                        <th class="text-center">Department</th>
                                                                        <th class="text-center">Sub Department</th>
                                                                        <th class="text-center">Inventory Name</th>
                                                                        <th class="text-center">Balance</th>
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
                                        <input id="assetId" name="assetId"
                                            class="assetId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                        <input id="rabId" name="rabId"
                                            class="rabId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                        <input id="budget" name="budget"
                                            class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" readonly hidden/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="reff">Order Qty
                                        </label>
                                        <input id="reff" name="reff"
                                            class="reff numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="reff_date">reff_date<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="reff_date" name="reff_date"
                                            class="reff_date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" maxlength="20" readonly/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="product_price">@Price
                                        </label>
                                        <input id="product_price" name="product_price"
                                            class="product_price numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3" id="itemTotal1">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="itemTotal">Total
                                        </label>
                                        <input id="itemTotal" name="itemTotal"
                                            class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text" value="0" readonly/>
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
                                                @click="modalOpen = false" id="addProduct">Add Asset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif --}}
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Reff Date</th>
                                <th class="text-sm text-center">Reff</th>
                                <th class="text-sm text-center">Description</th>
                                <th class="text-sm text-center">Amount</th>
                                <th class="text-sm text-center">Balance</th>
                                <th class="text-sm text-center">User</th>
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="subtotal">Subtotal<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="subtotal" name="subtotal" type="text" class="subtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-16" required readonly/>
                    <input id="subtotal1" name="subtotal1" type="text" class="subtotal1 form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right" required readonly hidden/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="discount">Discount (IDR)<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="discount" name="discount" class="discount form-input md:w-1/4 px-2 py-1 ml-16" value="0" onchange="calculateDisc()" type="text" required/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="total">Total<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="total" name="total" type="text" class="total form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right ml-16" required readonly/>
                    <input id="total1" name="total1" type="text" class="total1 form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right" required readonly hidden/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="ppn">PPN (IDR)<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="ppn" name="ppn" class="ppn form-input md:w-1/4 px-2 py-1 ml-16" value="0" onchange="calculateDisc()" type="text" required/>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="block w-full md:w-1/2 text-sm font-medium mb-1" for="grandtotal">Grand Total<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/4 px-2 py-1 read-only:bg-slate-200 text-right flex justify-end" type="text" readonly required/>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly required/>
                </div>
                <div class="flex flex-row mt-3" hidden>
                    <label class="md:w-1/4 text-sm font-medium mb-1" for="deliveryCharge">Delivery Charge (IDR)<span
                        class="text-rose-500">*</span>
                    </label>
                    <input id="deliveryCharge" name="deliveryCharge" class="deliveryCharge form-input md:w-1/4 px-2 py-1 ml-16" type="text" value="0" required/>
                </div>

                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create Purchase Request</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
    $('#approval_to').select2();
    $('#company1').on('change', function (e) {
        const site = $('#company1').val();
        if ($('#company1').val() !== null) {
            $('#company').val(site);
            $('#company2').val(site);
            $('#delivery-address').DataTable().ajax.reload();
            $('#rabItem').DataTable().ajax.reload();
        }
        $(".rabSelector").attr("disabled", false);
    })
    // $('#department').on('change', function (e) {
    //     const deptsName = $("#department option:selected").text();
    //     $('#rabItem').DataTable().ajax.reload();
    //     $("#department").attr("hidden", true);
    //     $("#deptSelected").val(deptsName);
    //     $("#deptSelected").attr("hidden", false);
    //     $("#clearDept").attr("hidden", false);
    // })
    $('#changeRab').on('click', function () {
        $(".rabSelector").attr("disabled", false);
        $("#changeRab").attr("hidden", true);
        $(".btn-rab").attr("disabled", true);
        $("#selectAllRAB").attr("disabled", false);
        $("#Rab123").val('');
        $("#period1").val('');

        // Clear the table rows and reset subtotal
        $('#tableProductAddBody').empty();
    });
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
            { className: 'text-center', targets: [5, 6] }
        ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
    });
    // $('#vendor-table').DataTable({
    //     responsive: true,
    //                 processing: true,
    //                 serverSide: false,
    //                 stateServe: true,
    //                 "order": [[ 2, "asc" ]],
    //                 language: {
    //                     search: "Search Vendor:"
    //                 },
    //                 ajax: {
    //                     url: "{{ route('vendor.select') }}"
    //                 },
    //                 columns: [
    //                     {
    //                         data: "initials",
    //                         name: "initials"
    //                     },
    //                     {
    //                         data: "company_type",
    //                         name: "company_type"
    //                     },
    //                     {
    //                         data: "name",
    //                         name: "name"
    //                     },
    //                     {
    //                         data: "address",
    //                         name: "address"
    //                     },
    //                     {
    //                         data: "phone",
    //                         name: "phone"
    //                     },
    //                     {
    //                         data: "status",
    //                         name: "status"
    //                     },
    //                     {
    //                         data: "action",
    //                         name: "action"
    //                     },
    //                 ],
    //                 columnDefs: [
    //                     { className: 'text-center', targets: [0, 1, 4] },
    //                 ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
    // });
    $('#assetInv').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,
        "order": [[ 3, "asc" ]],
        language: {
            search: "Search: "
            },
        ajax: {
            url: "{{ route('rabLpj.selectrabdetail') }}",
            data:function(d){                    
                d.idRab = $("#idRab").val()
            }
        },
        columns: [
            {
                data: "id_rab",
                name: "id_rab"
            },
            {
                data: "rab_calc_type",
                name: "rab_calc_type"
            },
            {
                data: "category",
                name: "category"
            },
            {
                data: "sub_category",
                name: "sub_category"
            },
            {
                data: "name_rab_detail",
                name: "name_rab_detail"
            },
            {
                data: "balance",
                name: "balance"
            },
            {
                data: "action",
                name: "action"
            },
            ],
            columnDefs: [
                { className: 'text-right', targets: [5] },
                { className: 'text-center', targets: [0, 6] }
            ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
    });
    $('#rabItem').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,
        "order": [[ 1, "desc" ]],
        language: {
        search: "Search RAB #:"
        },
        ajax: {
            url: "{{ route('rabLpj.selectrab') }}",
            data:function(d){
                d.company = $("#company").val()
                d.department = $("#department").val()
            }
        },
        columns: [
            {
                data: "date_rab",
                name: "date_rab"
            },
            {
                data: "id_rab",
                name: "id_rab"
            },
            {
                data: "rab_type",
                name: "rab_type"
            },
            {
                data: "name_rab",
                name: "name_rab"
            },
            {
                data: "name",
                name: "name"
            },
            {
                data: "deptName",
                name: "deptName"
            },
            {
                data: "gtotal",
                name: "gtotal"
            },
            {
                data: "action",
                name: "action"
            },
        ],
            columnDefs: [
            { className: 'text-center', targets: [0, 1, 7] },
            { className: 'text-right', targets: [6] },
        ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
    });
    $('#company').on('change', function (e) {
        $('#rabItem').DataTable().ajax.reload();
    })
    $('#department').on('change', function (e) {
        $('#rabItem').DataTable().ajax.reload();
    })
    // $('#pr_type').on('change', function (e) {
    //     $('#rabItem').DataTable().ajax.reload();
    // })
});
// $('#vendor-table').on("click", ".btn-select", function () {
//     const id = $(this).data("id_vendor");
//     const name = $(this).data("name_vendor");
//     const type = $(this).data("type");
//     const phone = $(this).data("phone");
//     var nama = type + ' ' + name + ' - ' + phone
                
//     $("#vendor").val(nama);
//     $("#vendor1").val(id);
// });
// let rowIdx = 0;
$('#assetInv').on("click", ".btn-select", function () {
    const idAsset = $(this).data("id_item");
    const nameAsset = $(this).data("nama");
    const budget = $(this).data("budget");
    const price = $(this).data("amount");
    const qty = $(this).data("qty");
    const total = $(this).data("total");
    const reff_date = $(this).data("reff_date");
    const rab = $(this).data("id");
    
    $("#assetId").val(idAsset);
    $("#rabId").val(rab);
    $("#nama_product").val(nameAsset);
    $('#product_price').val(newDivider1(price));
    $('#reff').val();
    $('#itemTotal').val(newDivider1(total));
    $("#budget").val(newDivider1(budget));
    // $("#reff_date").val(reff_date);
    $('#grandtotal').val(`${divider(subtotal)}`);
    $('#grandtotal1').val(subtotal);
});

// $('#delivery-address').on("click", ".btn-select", function () {
//     const id = $(this).data("id");
//     const address = $(this).data("address");
//     const city = $(this).data("city");
//     const province = $(this).data("province");
//     const country = $(this).data("country");
//     const zip_code = $(this).data("zip_code");

//     $("#id_warehouse").val(id);
//     $("#address").val(address);
//     $("#city").val(city);
//     $("#province").val(province);
//     $("#country").val(country);
//     $("#zip_code").val(zip_code);

//     $('#pic1').removeAttr('hidden');
//     $('#phone1').removeAttr('hidden');
//     $('#address1').removeAttr('hidden');
//     $('#city1').removeAttr('hidden');
//     $('#province1').removeAttr('hidden');
//     $('#country1').removeAttr('hidden');
//     $('#zip1').removeAttr('hidden');
// });

$('#rabItem').on("click", ".btn-select", function () {
    const id = $(this).data("id");
    const title = $(this).data("title");
    const period = $(this).data("period");
    const division = $(this).data("division");
    const company = $(this).data("company");
    const username = $(this).data("username");
    const periodDate = new Date(period);
    const formDate = $(this).data("form_date");
    const balance = $(this).data("balance");

    // Dapatkan nama bulan dalam format 'F'
    const month = new Intl.DateTimeFormat('en-US', { month: 'long' }).format(periodDate);

    // Dapatkan tahun dalam format 'Y'
    const year = periodDate.getFullYear();

    var value = id;
    var value12 = month + ' ' + year; 

    var grandTotalRow = `<tr class="grandTotalRow">
        <td class="text-center text-md">${formDate}</td>
        <td class="text-center text-md">${id}</td>
        <td class="text-center text-md">Saldo Awal</td>
        <td class="text-center text-md">0</td>
        <td class="text-center text-md" id="grandTotal_text"><span id="grandTotal_text">${newDivider1(balance)}</span><input name="rows[][budgets1]" value="${newDivider2(balance)}" hidden/></td>
        <td class="text-center text-md">${username}</td>
        <td class="text-center text-md">-</td>
    </tr>`;
                
    $("#period1").val(value12);
    $("#period").val(period);
    // $('#periodeRAB1').attr('hidden', false);
    // $('#periodeRAB').attr('hidden', true);
    $("#Rab123").val(value);
    $("#idRab").val(id);
    $("#departs").val(division);
    $("#name").val(username);
    $("#company").val(company);
    $("#balancess").val(newDivider2(balance));
    $("#balanceRab").val(newDivider2(balance));
    $('#assetInv').DataTable().ajax.reload();
    $(".btn-rab").attr("disabled", false);
    $(".rabSelector").attr("disabled", true);
    $("#changeRab").attr("hidden", false);
    $("#tableProductAddBody").append(grandTotalRow);
    // rowIdx++;
    // console.log(rowIdx);
});

function calculateDisc() {
    let finalAmount = subtotal; // Pastikan variable 'subtotal' sudah didefinisikan dan memiliki nilai sebelumnya
    if ($('#discount').val()) {
        finalAmount = finalAmount - parseFloat($('#discount').val());
        $('#total').val(`${divider(finalAmount)}`);
        $('#total1').val(finalAmount);
        $('#grandtotal').val(`${divider(finalAmount)}`);
        $('#grandtotal1').val(finalAmount);
    }
    if ($('#ppn').val()) {
        finalAmount = finalAmount + parseFloat($('#ppn').val());
        $('#grandtotal').val(`${divider(finalAmount)}`);
        $('#grandtotal1').val(finalAmount);
    }
}

    // data product
    var usedBudgets = {};
    // var subtotal = $('#balanceRab').val();
    function calculateGrandTotal() {
        var idx = 0;
        var subtotal = 0;
        $('.tableProductAddBody tbody tr').each(function() {
            // console.log("Index: ", idx);
            if (idx == 0) {
                subtotal = $('#balanceRab').val();
            } else {
                const budgetss = parseFloat($(this).find('input[name^="rows"][name$="[budgets1]"]').val()) || 0;
                // const amounts = parseFloat($(this).find('input[name^="rows"][name$="[budget]"]').val()) || 0;
                // minus = budgetss - amounts;
                // console.log(subtotal, budgetss);
                subtotal -= budgetss;
                // console.log(subtotal, budgetss);            

                // Update the row's subtotal
                const productIdx = $(this).attr('id').split('-')[1]; // Extract productIdx from the row's id (row-productIdx)

                // Update the total amount in the row
                $(this).find(`#totals-text_${productIdx}`).text(subtotal); // Update the subtotal display
                $(this).find(`input[name^="rows"][name$="[amounts]"]`).val(subtotal); // Update the hidden input's value

            }
            console.log(subtotal);
            idx++;
        });
    }
    $(document).ready(function () {
        $('#reff, #product_price').on('input', function() {
            calculateTotal();
        });

        function calculateTotal() {
            const qtyValue = $('#reff').val().replace(/\./g, '').replace(/\,/g, '.');
            const priceValue = $('#budget').val().replace(/\./g, '').replace(/\,/g, '.');

            if (qtyValue !== '' && priceValue !== '') {
                const qty = parseFloat(qtyValue);
                const price1 = parseFloat(priceValue);

                const totalss1 = qty * price1;
                const total1 = Math.round(totalss1);

                $('#itemTotal').val(divider(total1));
            } else {
                $('#itemTotal').val('0');
            }
        }

        let productIdx = 0;
        $("#addProduct").click(function () {
            var prods = [];
            var id = $('#assetId').val();
            var id_rab = $('#rabId').val();
            var name = $('#nama_product').val();
            var budget = $("#budget").val();
            var budget2 = $("#budget").val().replace(/\./g, '').replace(/\,/g, '.');
            var balances = $('#balancess').val();
            // var price = $('#product_price').val();
            // var price2 = $('#product_price').val().replace(/\./g, '').replace(/\,/g, '.');
            var oq = $('#reff').val();
            var oq1 = $('#reff').val().replace(/\./g, '').replace(/\,/g, '.');
            var reff_date = $('#reff_date').val();
            var reff = $('#reff').val();
            var user = '{{Auth::user()->username}}';
            var totalas = balances - budget2;
            var total = Math.round(totalas);

            if (!usedBudgets[id_rab]) {
                usedBudgets[id_rab] = {};
            } 
            if (!usedBudgets[id_rab][id]) {
                usedBudgets[id_rab][id] = 0;
            } 

            var remainingBudget = $('#budget').val() - usedBudgets[id_rab][id];

            // if (total > remainingBudget) {
            //     alert('Over Budget canot added.');
            //     return false;
            // }

            console.log($('#tableProductAddBody').find(`[name*="[ids]"][value="${id}"]`));
                // // Check if the product with the same id already exists for Inventory type
                // if ($('#tableProductAddBody').find(`[name*="[ids]"][value="${id}"]`).length > 0) {
                //     alert('Same Inventory Asset cannot be added again.');
                //     return false;
                // }

            if (name === '' || oq1 === '0' || oq1 === '') {
                return false;
            }
            // usedBudgets[id_rab][id] += total;
            // subtotal -= budget;
                $(document).on('input', `[id^="qty_"], [id^="price_"]`, function (e) {
                    const productIdx = this.id.split('_')[1];
                    calculatesTotal(productIdx);
                });

                // function calculatesTotal(productIdx) {
                //     const qtysValue = $('#qty_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.');
                //     const pricesValue = $('#price_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.');

                //     if (qtysValue !== '' && pricesValue !== '') {
                //         const qtys = parseFloat(qtysValue);
                //         const prices = parseFloat(pricesValue);

                //         const totalss = qtys * prices;
                //         const totals = Math.round(totalss);

                //         $('#itemTotal_' + productIdx).val(divider(totals));
                //     } else {
                //         $('#itemTotal_' + productIdx).val('0');
                //     }
                // }
                modal_content = `<div class="modal-content text-xs px-5 py-4">
                                                <input id="assetId_${productIdx}" name="assetId"
                                                        class="assetId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${id}" readonly hidden/>
                                                    <input id="rabId_${productIdx}" name="rabId"
                                                        class="rabId form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${id_rab}" readonly hidden/>
                                                    <input id="budget_${productIdx}" name="budget"
                                                        class="budget form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${budget}" readonly hidden/>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="reff">Order Qty
                                                    </label>
                                                    <input id="qty_${productIdx}" name="reff"
                                                        class="reff numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${oq}"/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="reff_date">reff_date<span
                                                        class="text-rose-500">*</span>
                                                    </label>
                                                    <input id="reff_date_${productIdx}" name="reff_date"
                                                        class="reff_date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" maxlength="20" value="${reff_date}" readonly/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="product_price">@Price
                                                    </label>
                                                    <input id="price_${productIdx}" name="product_price"
                                                        class="product_price numeric-input form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value=""/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3" id="itemTotal1">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="itemTotal">Total
                                                    </label>
                                                    <input id="itemTotal_${productIdx}" name="itemTotal"
                                                        class="itemTotal form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                        type="text" value="${divider(total)}" readonly/>
                                                </div>
                                                <div class="flex justify-between flex-col md:flex-row mb-3">
                                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                        for="remarks">Remarks
                                                    </label>
                                                    <input id="remarks_${productIdx}" name="remarks"
                                                        class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="${user}"
                                                        type="text"/>
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
                                                            @click="modalOpen = false" onclick="updateDataProduct('${productIdx}')">Update</button>
                                                    </div>
                                                </div>
                                            </div>`
                prods.push({productIdx, id, id_rab, name, oq, oq1, reff_date, reff, user, total, modal_content});
                var tr = `<tr id="row-${productIdx}">
                            <td class="text-center"><span id="reff_dates-text_${productIdx}">${reff_date}</span><input type="date" id="reff_dates_${productIdx}" name="rows[${productIdx}][reff_dates]" value="${reff_date}" hidden/></td>
                            <td class="text-center"><span id="reff-text_${productIdx}">${reff}</span><input id="qtys_${productIdx}" name="rows[${productIdx}][qtys]" value="${oq1}" hidden/></td>
                            <td class="text-center">${name}<input name="rows[${productIdx}][ids]" value="${id}" hidden/><textarea name="rows[${productIdx}][namesis]" hidden>${name}</textarea></td>
                            <td class="text-center"><span id="prices-text_${productIdx}">${divider(budget)}</span><input id="prices_${productIdx}" name="rows[${productIdx}][budgets1]" value="${budget2}" hidden/><input name="rows[${productIdx}][budgets]" value="${budget}" hidden/></td>
                            <td class="text-center"><span id="totals-text_${productIdx}">0</span><input id="totals_${productIdx}" name="rows[${productIdx}][amounts]" value="0" hidden/></td>
                            <td class="text-center"><span id="user-text_${productIdx}">${user}</span><textarea id="remarkss_${productIdx}" name="rows[${productIdx}][remarkss]" hidden>${user}</textarea></td>
                            <td class="text-center flex flex-row justify-center">
                            <button type="button" onclick="deleteDataProduct(${productIdx}, ${total}, '${id_rab}', ${null})" class="remove_button btn border-slate-200 hover:border-slate-300" ><svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" /> </svg></button>
                            <div x-data="{ modalOpen: false }">
                                <button class="ml-2 btn bg-emerald-500 hover:bg-emerald-600 text-white" type="button"
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
                                                <div class="font-semibold text-slate-800">Adjust Purchase Detail</div>
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
                                        `+ prods.find(prod => prod.productIdx == productIdx).modal_content +`
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>`;

            $("#tableProductAddBody").append(tr);

            $('#assetId').val('');
            $('#nama_product').val('');
            $('#reff_date').val(reff_date);
            $('#product_price').val('0');
            $('#reff').val('0');
            $('#itemTotal').val('0');
            $('#remarks').val('');
            $('#grandtotal').val(divider(parseFloat(subtotal)));
            $('#grandtotal1').val(parseFloat(subtotal));
            $('#budget').val(``);
            $('#balancess').val(subtotal);
            $("#selectAllRAB").attr("disabled", true);
            calculateGrandTotal()
            // updateGrandTotal();

            // for (const value of tr) {                    
            //     var iden = tr.indexOf(value);

                            
            // }

            // calculateDisc();

            // var grandTotalRow = $("#tableProductAddBody").find('.grandTotalRow');
            // grandTotalRow.detach();
            // $("#tableProductAddBody").append(grandTotalRow);
            productIdx++;
        });
        // var grandTotalRow = `<tr class="grandTotalRow">
        //     <td class="text-center font-bold text-lg" colspan="4">Grand Total</td>
        //     <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">${divider(subtotal)}</span></td>
        //     <td></td>
        //     <td></td>
        // </tr>`;
        // $("#tableProductAddBody").append(grandTotalRow);
    });

    function updateDataProduct(rowIdx) {
        var remarks = $('#remarks_'+rowIdx).val();
        var remarksTextarea = $(`#row-${rowIdx}`).find(`textarea[name="rows[${rowIdx}][remarkss]"]`);
        // Update the textarea value in the current row
        remarksTextarea.val(remarks);
        $('#remarkss-text_'+rowIdx).text(remarks);
            
        var budgeet = parseFloat($('#budget_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var qty = parseFloat($('#qty_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var price = parseFloat($('#price_' + rowIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var itemTotal = parseFloat($('#itemTotal_' + rowIdx).val()) || 0;
        var tots = price * qty;
        var newTotal = Math.round(tots);

        if (newTotal > budgeet) {
            alert('Over Budget canot update.');
            return false;
        }

        // Mengupdate nilai total pada input tersembunyi
        $('#totals_' + rowIdx).val(newTotal);

        // Memanggil fungsi untuk menghitung ulang grandTotal dan memperbarui tampilan
        // calculateGrandTotal();
        // updateGrandTotal();

        // Memperbarui nilai lain yang perlu diperbarui
        $('#qtys_' + rowIdx).val(qty);
        $('#qtys-text_' + rowIdx).text(allinDivider(qty));
        $('#prices_' + rowIdx).val(price);
        $('#prices-text_' + rowIdx).text(allinDivider(price));
        $('#totals-text_' + rowIdx).text(newDivider1(newTotal));
        // $('#grandtotal').val(newDivider1(subtotal));
        // $('#grandtotal1').val(subtotal);

        console.log(rowIdx, qty, price, subtotal, newTotal);
    }
    
    function updateDataProduct(productIdx) {
        var remarks = $('#remarks_'+productIdx).val();
        var remarksTextarea = $(`#row-${productIdx}`).find(`textarea[name="rows[${productIdx}][remarkss]"]`);
        // Update the textarea value in the current row
        remarksTextarea.val(remarks);
        $('#remarkss-text_'+productIdx).text(remarks);
            
        var budgeet = parseFloat($('#budget_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var qty = parseFloat($('#qty_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var price = parseFloat($('#price_' + productIdx).val().replace(/\./g, '').replace(/\,/g, '.')) || 0;
        var itemTotal = parseFloat($('#itemTotal_' + productIdx).val()) || 0;
        var tots = price * qty;
        var newTotal = Math.round(tots);

        if (newTotal > budgeet) {
            alert('Over Budget canot update.');
            return false;
        }

        // Mengupdate nilai total pada input tersembunyi
        $('#totals_' + productIdx).val(newTotal);

        // Memanggil fungsi untuk menghitung ulang grandTotal dan memperbarui tampilan
        // calculateGrandTotal();
        // updateGrandTotal();

        // Memperbarui nilai lain yang perlu diperbarui
        $('#qtys_' + productIdx).val(qty);
        $('#qtys-text_' + productIdx).text(allinDivider(qty));
        $('#prices_' + productIdx).val(price);
        $('#prices-text_' + productIdx).text(allinDivider(price));
        $('#totals-text_' + productIdx).text(newDivider1(newTotal));
        // $('#grandtotal').val(newDivider1(subtotal));
        // $('#grandtotal1').val(subtotal);

        console.log(productIdx, qty, price, subtotal, newTotal);
    }
        function updateGrandTotal() {
            var subtotal = 0;
            $('.tableProductAddBody tbody tr').each(function() {
                const totalas = parseFloat($(this).find('input[name^="rows"][name$="[totals]"]').val()) || 0;
                subtotal += totalas;
                console.log(subtotal);
            });
            $('#grandtotal').val(divider(Math.round(subtotal)));
            $('#grandtotal1').val(Math.round(subtotal));
            
            $('#grandTotal_text').text(`${divider(Math.round(subtotal))}`);
            $('#grandTotal_text').val(`${divider(Math.round(subtotal))}`);
        }

        function moveRowUp(positionTableRow) {
            const $currentRow = $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`);
            const $previousRow = $(`#tableProductAddBody tr[id="row-${positionTableRow - 1}"]`);

            $currentRow.insertBefore($previousRow);
            // Update the productIdx attribute in the rows
            updateProductIdxAttributes();
        }

        // Function to move row down
        function moveRowDown(positionTableRow) {
            const $currentRow = $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`);
            const $nextRow = $(`#tableProductAddBody tr[id="row-${positionTableRow + 1}"]`);

            if ($nextRow.hasClass('grandTotalRow')) {
                // Jangan izinkan pemindahan jika baris berikutnya adalah grandTotalRow
                return;
            }

            $currentRow.insertAfter($nextRow);
            // Update the productIdx attribute in the rows
            updateProductIdxAttributes();
        }

        // Event listener for arrow-up button click
        $('#tableProductAddBody').one('click', '.icon-tabler-arrow-up', function () {
            const positionTableRow = $(this).closest('tr').index();
            if (positionTableRow > 0) {
                moveRowUp(positionTableRow);
            }
        });

        $('#tableProductAddBody').one('click', '.icon-tabler-arrow-down', function () {
            const positionTableRow = $(this).closest('tr').index();
            const rowCount = $('#tableProductAddBody tr').length;
            // Periksa apakah baris yang dipilih adalah baris sebelum grandTotalRow
            if (positionTableRow < rowCount - 2) { // Kurangi 2 karena grandTotalRow ada di posisi rowCount - 1
                moveRowDown(positionTableRow);
            }
        });
    
    function deleteDataProduct(positionTableRow, total, id_rab) {
        const positionTableRowVariable = positionTableRow
        const id_rab_deleted = id_rab;
        subtotal -= total;
        $(`#tableProductAddBody tr[id="row-${positionTableRow}"]`).remove();
        if (usedBudgets[id_rab_deleted]) {
            usedBudgets[id_rab_deleted] -= total;
        }
        // $('#subtotal').val(`${divider(subtotal)}`);
        $('#grandtotal').val(`${divider(subtotal)}`);
        $('#grandtotal1').val(`${subtotal}`);
        // $('#subtotal1').val(`${subtotal}`);
        if ($("#tableProductAddBody tr[id^='row-']").length === 0) {
            $(".btn-rab").attr("disabled", false);
            $("#selectAllRAB").attr("disabled", false);
        }
        // updateGrandTotal();
        calculateGrandTotal();

        var remainingBudget = $('#budget').val() - usedBudgets[id_rab_deleted];
        var status = "";

        if (total > remainingBudget) {
            status = '<div class="flex flex-row mt-2 justify-center"><div class="rounded-full bg-red-500 columns-1 h-5 w-5"></div></div>';
        } else if (total <= remainingBudget) {
            status = '<div class="flex flex-row mt-2 justify-center"><div class="rounded-full bg-green-700 columns-1 h-5 w-5"></div></div>';
        } else if (isNaN(remainingBudget)) {
            status = '<label class="text-left">No Budget</label>';
        }

        // Memperbarui status budget pada baris yang sesuai
        $(`#tableProductAddBody tr[id="row-${positionTableRow}"] .text-center:eq(1)`).html(status);
        console.log(positionTableRow);
        
    }

    function updateProductIdxAttributes() {
        $('#tableProductAddBody tr').each(function (index, element) {
            const newIndex = index;

            // Update attributes
            $(element).attr('id', `row-${newIndex}`);
            $(element).find('.icon-tabler-arrow-up').attr('onclick', `moveRowUp(${newIndex})`);
            $(element).find('.icon-tabler-arrow-down').attr('onclick', `moveRowDown(${newIndex})`);
            $(element).find('[onclick^="deleteDataProduct"]').attr('onclick', `deleteDataProduct(${newIndex}, ${$(element).find('[name*="[totals]"]').val()})`);

            // Find and update all input fields with dynamic names
            $(element).find('input, textarea').each(function () {
                const oldName = $(this).attr('name');
                const newName = oldName.replace(/rows\[\d+\]/, `rows[${newIndex}]`);
                $(this).attr('name', newName);
            });
        });
    }

    $('#form_create').submit(function (e, params) {
        e.preventDefault();
        $("#create_offer").prop('disabled', true);
        var formData = new FormData($(this)[0]);
        console.log(formData, $(this).attr('action'));
        $.ajax({
            url      : $(this).attr('action'),
            type     : 'POST',
            dataType : 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(_response){
                if (_response.st == '1') {
                    // var RRID = _response.id;
                    urlRedirect = '/finance/costcenter-approval/list';
                    window.open(urlRedirect, '_self');
                    // Swal.fire({
                    //     title: 'Success',
                    //     text: 'Reimburse #' + RRID + ' Has Been Created',
                    //     icon: 'success',
                    //     showCancelButton: false,
                    //     confirmButtonText: 'Ok',
                    //     cancelButtonText: 'No, cancel'
                    // }).then((result) => {
                    //     if (result.isConfirmed) {
                    //         Swal.close();
                    //     }else {
                    //         Swal.close();
                    //     }
                    // });
                }else if (_response.st == '2') {
                    Swal.fire({
                        title: 'File to Large',
                        text: 'Please Compress File',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        cancelButtonText: 'No, cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.close();
                        }else {
                            Swal.close();
                        }
                    });
                }else if (_response.st == '3') {
                    Swal.fire({
                        title: 'Reimburse Not Create',
                        text: 'Reimburse Detail or Grand Total must fill',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        cancelButtonText: 'No, cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.close();
                        }else {
                            Swal.close();
                        }
                    });
                }else if (_response.st == '4') {
                    Swal.fire({
                        title: 'Reimburse Not Create',
                        text: 'First row Subtotal cannot be 0 value',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        cancelButtonText: 'No, cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.close();
                        }else {
                            Swal.close();
                        }
                    });
                }
            },
                error: function(){
                alert('Terjadi kesalahan');
            }
        });
    })

</script>
@endsection
</x-app-layout>