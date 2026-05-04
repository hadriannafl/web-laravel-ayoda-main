<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Inventory Asset Code 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" id="myForm" enctype="multipart/form-data" action="{{ route('inventory-code.create') }}">
                @csrf
                {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="inventoryCode">Inventory Asset Code<span
                        class="text-rose-500">*</span></label>
                    <input id="inventoryCode" name="inventoryCode"
                    class="inventoryCode form-input w-full md:w-3/4 px-2 py-1" minlength="5" maxlength="100" type="text" oninput="this.value = this.value.toUpperCase().replace(/\s/g, '')"/>
                </div>    --}}
                <div class="flex justify-between flex-col md:flex-row" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Request Date<span
                        class="text-rose-500">*</span></label>
                    <input id="date" name="date"
                    class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    Value="{{date('Y-m-d')}}" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id">Applicant</label>
                    <input id="name" name="name"
                        class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->username}}" readonly/>
                    <input id="id" name="id"
                        class="id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->employee_id}}" readonly hidden/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="category">Department<span
                        class="text-rose-500">*</span></label>
                    <input id="category" name="category"
                    class="category form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                    <input class="category1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="category1" name="category1" hidden required>
                    {{-- <div x-data="{ modalOpen: false }">
                        <button type="button"
                            class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                            @click.prevent="modalOpen = true"
                            aria-controls="feedback-category">
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
                                        <div class="font-semibold text-slate-800">Select Category</div>
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
                                        <table id="categoryTable"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Category</th>
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
                    </div> --}}
                    <div x-data="{ modalOpen: false }">
                        <button type="button"
                            class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white btn-sub"
                            @click.prevent="modalOpen = true"
                            aria-controls="feedback-category">
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
                            x-transition:leave-end="opacity-0" aria-hidden="false"
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
                                        <div class="font-semibold text-slate-800">Select Department/Sub Department</div>
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
                                    <div class="flex flex-row justify-end text-xs">
                                        <label class="flex flex-row text-xs">
                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="categoryFilter">Filter Department :</p>
                                            <select id="categoryFilter" class="categoryFilter flex flex-row ml-3 mb-3 text-xs" name="categoryFilter">
                                                <option value="">All</option>
                                                @foreach ($dataCategory as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="subCategory-table"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Department</th>
                                                    <th class="text-center">Sub Department</th>
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
                                        {{-- <div x-data="{ modalOpen: false }">
                                            <button type="button"
                                                class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click.prevent="modalOpen = true"
                                                aria-controls="feedback-modal @click="modalOpen = false"">
                                                <span>Back to Select Category</span>
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
                                                            <div class="font-semibold text-slate-800">Select Brand</div>
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
                                                            <table id="categoryTable1"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Category</th>
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
                                        </div> --}}
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="subCategory">Sub Department<span
                        class="text-rose-500">*</span></label>
                    <input id="subCategory" name="subCategory"
                    class="subCategory form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                    <input id="subCategory1" name="subCategory1"
                    class="subCategory1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" type="text" hidden required/>
                </div>             
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="inventoryName">Inventory Asset Name<span
                        class="text-rose-500">*</span></label>
                    <input id="inventoryName" name="inventoryName"
                    class="inventoryName form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="unit">Unit<span
                        class="text-rose-500">*</span></label>
                    <input id="unit" name="unit"
                        class="unit form-input w-full md:w-3/4 px-2 py-1" maxlength="20"/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="brand">Brand<span
                        class="text-rose-500">*</span></label>
                    <input id="brand" name="brand"
                    class="brand form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                    <input class="brand1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="brand1" name="brand1" hidden readonly>
                    {{-- <div x-data="{ modalOpen: false }">
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
                                        <div class="font-semibold text-slate-800">Select Brand</div>
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
                                        <table id="brand-table"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Brand</th>
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
                    </div> --}}
                    <div x-data="{ modalOpen: false }">
                        <button type="button"
                            class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white btn-model"
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
                            x-transition:leave-end="opacity-0" aria-hidden="false"
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
                                        <div class="font-semibold text-slate-800">Select Brand/Model</div>
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
                                    <div class="flex flex-row justify-end text-xs">
                                        <label class="flex flex-row text-xs">
                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="brandFilter">Filter Brand :</p>
                                            <select id="brandFilter" class="brandFilter flex flex-row ml-3 mb-3 text-xs" name="brandFilter">
                                                <option value="">All</option>
                                                @foreach ($dataModel as $model)
                                                <option value="{{$model->id_brand}}">{{$model->name}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="model-select"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Brand</th>
                                                    <th class="text-center">Model</th>
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
                                    <div class="flex flex-wrap justify-between space-x-2">
                                        {{-- <div x-data="{ modalOpen: false }">
                                            <button type="button"
                                                class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click.prevent="modalOpen = true"
                                                aria-controls="feedback-modal @click="modalOpen = false"">
                                                <span>Back to Select Brand</span>
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
                                                            <div class="font-semibold text-slate-800">Select Brand</div>
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
                                                            <table id="brand-table1"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Brand</th>
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
                                        </div> --}}
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="model">Model #<span
                        class="text-rose-500">*</span></label>
                    <input id="model" name="model"
                    class="model form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                    <input id="model1" name="model1"
                    class="model1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="color">Color / Variant</label>
                    <input id="color" name="color"
                    class="color form-input w-full md:w-3/4 px-2 py-1" type="text"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="sku">Part # / SKU</label>
                    <input id="sku" name="sku"
                    class="sku form-input w-full md:w-3/4 px-2 py-1" type="text"/>
                </div>
                {{-- <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="Rab123">RAB ID<span
                        class="text-rose-500">*</span>
                    </label>
                    <input class="coa form-input w-full md:w-1/2 px-2 py-1" id="coa" name="coa" hidden>
                    <input class="idRab form-input w-full md:w-1/2 px-2 py-1" id="idRab" name="idRab" hidden>
                    <input class="Rab123 form-input w-full md:w-1/2 px-2 py-1" id="Rab123" name="Rab123" required readonly>
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
                                            RAB Item</div>
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
                                        <table id="rabItem"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">RAB #</th>
                                                    <th class="text-center">Department</th>
                                                    <th class="text-center">Sub Department</th>
                                                    <th class="text-center">Detail</th>
                                                    <th class="text-center">Chart Of Account (COA)</th>
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
                </div> --}}
                {{-- <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="vendor">Vendor Preference :</label>
                    <input id="vendor" name="vendor" class="vendor form-input w-full md:w-1/2 px-2 py-1" type="text" readonly required/>
                    <input class="vendor1 form-input w-full md:w-1/2 px-2 py-1" id="vendor1" name="vendor1" hidden required>
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
                                            Vendor Preference</div>
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
                                        <table id="vendor-table"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Initials</th>
                                                    <th class="text-center">Vendor's Type</th>
                                                    <th class="text-center">Vendor's Name</th>
                                                    <th class="text-center">Address</th>
                                                    <th class="text-center">Status</th>
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
                </div> --}}
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Asset Type<span
                        class="text-rose-500">*</span></label>
                    <select id="type" name="type"
                        class="type form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Type</option>
                        <option value="Current Asset">Current Asset</option>
                        <option value="Fixed Asset">Fixed Asset</option>
                        <option value="No Stock Keep">No Stock Keep</option>
                    </select>
                </div>
                {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="currency">Currency :
                    </label>
                    <select id="currency" name="currency"
                        class="currency form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Set Currency</option>
                        @foreach ($dataCurrency as $dataCurrency)
                            <option class="" value="{{ $dataCurrency->currency }}">{{ $dataCurrency->symbol }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="desc">Description</label>
                    <textarea name="desc" id="desc" class="form-input w-full md:w-3/4 px-2 py-1" rows="3"></textarea>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Brosur/Spek (PDF)</label>
                    <input name="file" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                    <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">File size max 5mb</div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="photo">Inventory Image</label>
                    <input name="photo" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1')"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                    <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">Image size max 15mb and 300x225 of resolution</div>
                </div>
                <img id="output1" style="max-width: 300px; max-height: 150px"/>
                    <div class="flex flex-row justify-center">
                        <div x-data="{ modalOpen: false }">
                                <button type="button"
                                    class="ml-2 btn bg-sky-500 hover:bg-sky-600 text-white mt-5"
                                    @click.prevent="modalOpen = true"
                                    aria-controls="feedback-modal9127387">
                                    <span>View All Code Inventory Assets</span>
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
                                <div id="feedback-modal9127387"
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
                                                <div class="font-semibold text-slate-800 text-sm">View All Code Inventory Assets</div>
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
                                                <table id="office-inventory12" class="table table-striped table-bordered text-xs" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Asset Code</th>
                                                            <th class="text-center">Department</th>
                                                            <th class="text-center">Inventory Name</th>
                                                            <th class="text-center">Brand</th>
                                                            <th class="text-center">Type</th>
                                                            <th class="text-center">Model #</th>
                                                            <th class="text-center">Color</th>
                                                            <th class="text-center">Unit</th>
                                                            <th class="text-center">Part #</th>
                                                            <th class="text-center">Status</th>
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
                        <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5 ml-3" type="submit" id="create_offer">
                            <span class="xs:block ml-5 mr-5">Create Code Inventory Asset</span>
                        </button>
                    </div>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
$(document).ready(function () {
// $('#rabItem').DataTable({
//     responsive: true,
//                 processing: true,
//                 serverSide: false,
//                 stateServe: true,
//                 "order": [[ 1, "asc" ]],
//                 language: {
//                     search: "Search RAB #:"
//                 },
//                 ajax: {
//                     url: "{{ route('inventory-code.invbudget') }}"
//                 },
//                 columns: [
//                     {
//                         data: "id_rab",
//                         name: "id_rab"
//                     },
//                     {
//                         data: "department",
//                         name: "department"
//                     },
//                     {
//                         data: "sub_department",
//                         name: "sub_department"
//                     },
//                     {
//                         data: "detail",
//                         name: "detail"
//                     },
//                     {
//                         data: "coa",
//                         name: "coa"
//                     },
//                     {
//                         data: "total",
//                         name: "total"
//                     },
//                     {
//                         data: "action",
//                         name: "action"
//                     },
//                 ],
//                 columnDefs: [
//                     { className: 'text-center', targets: [0, 6] },
//                     { className: 'text-right', targets: [5] },
//                 ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
// });
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
//                         data: "status",
//                         name: "status"
//                     },
//                     {
//                         data: "action",
//                         name: "action"
//                     },
//                 ],
//                 columnDefs: [
//                     { className: 'text-center', targets: [0, 1, 4, 5] },
//                 ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
// });
// $('#brand-table').DataTable({
//     responsive: true,
//                 processing: true,
//                 serverSide: false,
//                 stateServe: true,
//                 "order": [[ 0, "asc" ]],
//                 language: {
//                     search: "Search Brand:"
//                 },
//                 ajax: {
//                     url: "{{ route('brand.select') }}"
//                 },
//                 columns: [
//                     {
//                         data: "name",
//                         name: "name"
//                     },
//                     {
//                         data: "action",
//                         name: "action"
//                     },
//                 ],
//                 columnDefs: [
//                     { className: 'text-center', targets: [1] },
//                 ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
// });
// $('#brand-table1').DataTable({
//     responsive: true,
//                 processing: true,
//                 serverSide: false,
//                 stateServe: true,
//                 "order": [[ 0, "asc" ]],
//                 language: {
//                     search: "Search Brand:"
//                 },
//                 ajax: {
//                     url: "{{ route('brand.select') }}"
//                 },
//                 columns: [
//                     {
//                         data: "name",
//                         name: "name"
//                     },
//                     {
//                         data: "action",
//                         name: "action"
//                     },
//                 ],
//                 columnDefs: [
//                     { className: 'text-center', targets: [1] },
//                 ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
// });
$('#model-select').DataTable({
    responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ], [ 1, "asc" ]],
                "searching": false,
                ajax: {
                    url: "{{ route('model.selected') }}",
                    data:function(d){
                        d.brandFilter = $("#brandFilter").val()
                    }
                },
                columns: [
                    {
                        data: "name_brand",
                        name: "name_brand"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [2] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
});
$('#brandFilter').on('change', function (e) {
    $('#model-select').DataTable().ajax.reload();
})
// $('#categoryTable').DataTable({
//     responsive: true,
//                 processing: true,
//                 serverSide: false,
//                 stateServe: true,
//                 "order": [[ 0, "asc" ]],
//                 language: {
//                     search: "Search Category:"
//                 },
//                 ajax: {
//                     url: "{{ route('category.select') }}"
//                 },
//                 columns: [
//                     {
//                         data: "name",
//                         name: "name"
//                     },
//                     {
//                         data: "action",
//                         name: "action"
//                     },
//                 ],
//                 columnDefs: [
//                     { className: 'text-center', targets: [1] },
//                 ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
// });
// $('#categoryTable1').DataTable({
//     responsive: true,
//                 processing: true,
//                 serverSide: false,
//                 stateServe: true,
//                 "order": [[ 0, "asc" ]],
//                 language: {
//                     search: "Search Category:"
//                 },
//                 ajax: {
//                     url: "{{ route('category.select') }}"
//                 },
//                 columns: [
//                     {
//                         data: "name",
//                         name: "name"
//                     },
//                     {
//                         data: "action",
//                         name: "action"
//                     },
//                 ],
//                 columnDefs: [
//                     { className: 'text-center', targets: [1] },
//                 ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
// });
$('#subCategory-table').DataTable({
    responsive: true,
    processing: true,
    serverSide: false,
    stateServe: true,
    "order": [[ 0, "asc" ], [ 1, "asc" ]],
    "searching": false,
    ajax: {
    url: "{{ route('subcategory.selected') }}",
        data:function(d){
            d.categoryFilter = $("#categoryFilter").val()
        }
    },
    columns: [
        {
            data: "dept_name",
            name: "dept_name"
        },
        {
            data: "name",
            name: "name"
        },
        {
            data: "action",
            name: "action"
        },
        ],
        columnDefs: [
            { className: 'text-center', targets: [2] },
        ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
});
$('#categoryFilter').on('change', function (e) {
    $('#subCategory-table').DataTable().ajax.reload();
})
});

// $('#rabItem').on("click", ".btn-select", function () {
//     const idAsset = $(this).data("id");
//     const idRab = $(this).data("id_rab");
//     const nameAsset = $(this).data("nama");
//     const department = $(this).data("department");
//     const detail = $(this).data("detail");
//     const coa = $(this).data("coa");
//     var value = idRab + '-' + department + '-' + nameAsset + '-' + detail;
                
//     $("#Rab123").val(value);
//     $("#idRab").val(idAsset);
//     $("#coa").val(coa);
// });
// $('#vendor-table').on("click", ".btn-select", function () {
//     const id = $(this).data("id_vendor");
//     const name = $(this).data("name_vendor");
//     const type = $(this).data("type");
//     var nama = type + ' ' + name
               
//     $("#vendor").val(nama);
//     $("#vendor1").val(id);
// });
// $('#brand-table').on("click", ".btn-select", function () {
//     const id = $(this).data("id_brand");
//     const name = $(this).data("name_brand");
               
//     $("#brand").val(name);
//     $("#brand1").val(id);   
//     $("#brandFilter").val(id);   

//      // Tutup modal pertama
//      $('[aria-controls="feedback-modal"]').click();

//     // Ganti value option pada #model-select
//     $('#model-select option[value="' + id + '"]').prop('selected', true);

//     // Refresh tabel #model-select
//     $('#model-select').DataTable().ajax.reload();
// });
// $('#brand-table1').on("click", ".btn-select", function () {
//     const id = $(this).data("id_brand");
//     const name = $(this).data("name_brand");
               
//     $("#brand").val(name);
//     $("#brand1").val(id);   
//     $("#brandFilter").val(id);   

//     // Ganti value option pada #model-select
//     $('#model-select option[value="' + id + '"]').prop('selected', true);

//     // Refresh tabel #model-select
//     $('#model-select').DataTable().ajax.reload();
// });
$('#model-select').on("click", ".btn-select", function () {
    const id_model = $(this).data("id_model");
    const name_model = $(this).data("name_model");
    const id_brand = $(this).data("id_brand");
    const name_brand = $(this).data("name_brand");
               
    $("#brand").val(name_brand);
    $("#brand1").val(id_brand);   
    $("#model").val(name_model);
    $("#model1").val(id_model);
});
// $('#categoryTable').on("click", ".btn-select", function () {
//     const id = $(this).data("id_cat");
//     const name = $(this).data("name_cat");
               
//     $("#category").val(name);
//     $("#category1").val(id);   
//     $("#categoryFilter").val(id);   

//      // Tutup modal pertama
//      $('[aria-controls="feedback-category"]').click();

//     // Ganti value option pada #model-select
//     $('#subCategory-table option[value="' + id + '"]').prop('selected', true);

//     // Refresh tabel #model-select
//     $('#subCategory-table').DataTable().ajax.reload();
// });
// $('#categoryTable1').on("click", ".btn-select", function () {
//     const id = $(this).data("id_cat");
//     const name = $(this).data("name_cat");
               
    // $("#category").val(name);
    // $("#category1").val(id);   
//     $("#categoryFilter").val(id);   

//     // Ganti value option pada #model-select
//     $('#subCategory-table option[value="' + id + '"]').prop('selected', true);

//     // Refresh tabel #model-select
//     $('#subCategory-table').DataTable().ajax.reload();
// });
$('#subCategory-table').on("click", ".btn-select", function () {
    const id_dept = $(this).data("id_dept");
    const dept_name = $(this).data("dept_name");
    const id_sub = $(this).data("id_sub");
    const sub_name = $(this).data("sub_name");
               
    $("#category").val(dept_name);
    $("#category1").val(id_dept);   
    $("#subCategory").val(sub_name);
    $("#subCategory1").val(id_sub);
});

$(document).ready(function() {
    $('#office-inventory12').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Assets ID : "
                },
                ajax: {
                    url: "{{ route('office-inventory.getdata') }}"
                },
                columns: [
                    {
                        data: "idassets",
                        name: "idassets"
                    },
                    {
                        data: "category",
                        name: "category"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "brand",
                        name: "brand"
                    },
                    {
                        data: "type",
                        name: "type"
                    },
                    {
                        data: "model_number",
                        name: "model_number"
                    },
                    {
                        data: "color",
                        name: "color"
                    },
                    {
                        data: "unit",
                        name: "unit"
                    },
                    {
                        data: "sku",
                        name: "sku"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 8, 9, 10] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
});
$('#myForm').submit(function (e, params) {
    e.preventDefault();
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
                    if(_response.st == '1'){
                        var idassets = _response.id;
                        urlRedirect = '/ga/office-inventory/view/'+idassets;
                        window.open(urlRedirect, '_self');
                    } else if(_response.st == '0'){
                        Swal.fire({
                            title: 'Inventory Already Exists',
                            text: 'Asset Name Already Exist or Wrong Input',
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
                    } else if(_response.st == '2'){
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
                    } else if(_response.st == '3'){
                        Swal.fire({
                            title: 'Image to Large',
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
                    }
                },
                error: function(){
                    Swal.fire({
                        title: 'Error Occurred',
                        text: 'Error Occurred',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, proceed',
                        cancelButtonText: 'No, cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.close();
                        }else {
                            Swal.close();
                        }
                    });
                }
            });
        })
</script>
@endsection
</x-app-layout>