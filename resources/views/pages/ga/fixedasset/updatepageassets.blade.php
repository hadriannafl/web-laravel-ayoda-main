<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit Fixed Assets 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('fixedasset.upload', ['idAsset' => $dataInv->idassets]) }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Request Date :</label>
                    <input id="date" name="date"
                    class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    Value="{{date('Y-m-d')}}" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3" hidden>
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id">Applicant : </label>
                    <input id="name" name="name"
                        class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->username}}" readonly/>
                    <input id="id" name="id"
                        class="id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->employee_id}}" readonly hidden/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="category">Category :</label>
                    <input id="category" name="category"
                    class="category form-input w-full md:w-1/2 px-2 py-1" type="text" value="{{$dataInv->category}}" readonly required/>
                    <div x-data="{ modalOpen: false }">
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
                    </div>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="subCategory">Sub Category :</label>
                    <input id="subCategory" name="subCategory"
                    class="subCategory form-input w-full md:w-1/2 px-2 py-1" type="text" value="{{$dataInv->sub_category}}" readonly required/>
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
                                        <div class="font-semibold text-slate-800">Select Sub Category</div>
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
                                            <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="categoryFilter">Filter Category :</p>
                                            <select id="categoryFilter" class="categoryFilter flex flex-row ml-3 mb-3 text-xs" name="categoryFilter">
                                                <option value="">All</option>
                                                @foreach ($dataCategory as $category)
                                                <option value="{{$category->id_cat}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="subCategory-table"
                                            class="table table-striped table-bordered text-xs"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Category</th>
                                                    <th class="text-center">Sub Category</th>
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
                                        <div x-data="{ modalOpen: false }">
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
                                        </div>
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="inventoryCode">Inventory Asset Code :</label>
                    <input id="inventoryCode" name="inventoryCode" value="{{$dataInv->idassets}}"
                    class="inventoryCode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" minlength="5" maxlength="100" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="inventoryName">Inventory Name :</label>
                    <input id="inventoryName" name="inventoryName" value="{{$dataInv->name}}"
                    class="inventoryName form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="unit">Unit :</label>
                    <input id="unit" name="unit" value="{{$dataInv->unit}}"
                        class="unit form-input w-full md:w-3/4 px-2 py-1"/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="brand">Brand :</label>
                    <input id="brand" name="brand" value="{{$dataInv->brand}}"
                    class="brand form-input w-full md:w-1/2 px-2 py-1" type="text" readonly required/>
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
                    </div>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="model">Model Number :</label>
                    <input id="model" name="model" value="{{$dataInv->model_number}}"
                    class="model form-input w-full md:w-1/2 px-2 py-1" type="text" readonly required/>
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
                                        <div class="font-semibold text-slate-800">Select Model</div>
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
                                        <div x-data="{ modalOpen: false }">
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
                                        </div>
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="color">Color / Variant :</label>
                    <input id="color" name="color" value="{{$dataInv->color}}"
                    class="color form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="sku">Part # / SKU :</label>
                    <input id="sku" name="sku" value="{{$dataInv->sku}}"
                    class="sku form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="Rab123">RAB ID :
                    </label>
                    <input class="idRab form-input w-full md:w-1/2 px-2 py-1" id="idRab" name="idRab" value="{{$dataInv->id_rab_item}}" hidden required>
                    <input class="coa form-input w-full md:w-1/2 px-2 py-1" id="coa" name="coa" value="{{$dataInv->id_coa}}" hidden required>
                    <input class="Rab123 form-input w-full md:w-1/2 px-2 py-1" id="Rab123" name="Rab123" value="{{$dataInv->id_rab_item}}-{{$dataInv->department}}-{{$dataInv->sub_department}}-{{$dataInv->detail}}" readonly required>
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
                                                    <th class="text-center">Created At</th>
                                                    <th class="text-center">Department</th>
                                                    <th class="text-center">Sub Department</th>
                                                    <th class="text-center">Detail</th>
                                                    <th class="text-center">Chart Of Account (COA)</th>
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
                @if ($dataVendor == null)
                    <div class="flex flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="vendor">Vendor Preference :</label>
                        <input id="vendor" name="vendor" class="vendor form-input w-full md:w-1/2 px-2 py-1" type="text" value="" readonly required/>
                        <input id="vendor1" name="vendor1" class="vendor1 form-input w-full md:w-1/2 px-2 py-1" type="text" value=""readonly hidden required/>
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
                    </div>
                @else
                    <div class="flex flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="vendor">Vendor Preference :</label>
                        <input id="vendor" name="vendor" class="vendor form-input w-full md:w-1/2 px-2 py-1" type="text" value="{{$dataVendor->company_type}} {{$dataVendor->name}}" readonly required/>
                        <input id="vendor1" name="vendor1" class="vendor1 form-input w-full md:w-1/2 px-2 py-1" type="text" value="{{$dataVendor->idsupplier}}"readonly hidden required/>
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
                    </div>
                @endif
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Asset Type :</label>
                    <select id="type" name="type"
                    class="type form-select w-full md:w-3/4 px-2 py-1" required>
                    <option value="Perishable Asset" {{$dataInv->type == 'Perishable Asset' ? 'selected':''}}>Perishable Asset</option>
                    <option value="Fix Asset" {{$dataInv->type == 'Fix Asset' ? 'selected':''}}>Fix Asset</option>
                    <option value="Moving Asset" {{$dataInv->type == 'Moving Asset' ? 'selected':''}}>Moving Asset</option>
                </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Inventory Description PDF : </label>
                    <input name="file" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="photo">Inventory Description Image : </label>
                    <input name="photo" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1')"/>
                </div>
                <img id="output1" style="max-width: 300px; max-height: 150px"/>
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Edit Fixed Asset</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
$(".btn-sub").attr("hidden", true);

$(".btn-model").attr("hidden", true);

$(document).ready(function () {
$('#rabItem').DataTable({
    responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "asc" ]],
                language: {
                    search: "Search Item:"
                },
                ajax: {
                    url: "{{ route('rab.item') }}"
                },
                columns: [
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "department",
                        name: "department"
                    },
                    {
                        data: "sub_department",
                        name: "sub_department"
                    },
                    {
                        data: "detail",
                        name: "detail"
                    },
                    {
                        data: "coa",
                        name: "coa"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 5] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
});
$('#vendor-table').DataTable({
    responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 2, "asc" ]],
                language: {
                    search: "Search Vendor:"
                },
                ajax: {
                    url: "{{ route('vendor.select') }}"
                },
                columns: [
                    {
                        data: "initials",
                        name: "initials"
                    },
                    {
                        data: "company_type",
                        name: "company_type"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "address",
                        name: "address"
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
                    { className: 'text-center', targets: [0, 1, 4, 5] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
});
$('#brand-table').DataTable({
    responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Brand:"
                },
                ajax: {
                    url: "{{ route('brand.select') }}"
                },
                columns: [
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
                    { className: 'text-center', targets: [1] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
});
$('#brand-table1').DataTable({
    responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Brand:"
                },
                ajax: {
                    url: "{{ route('brand.select') }}"
                },
                columns: [
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
                    { className: 'text-center', targets: [1] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
});
$('#model-select').DataTable({
    responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "asc" ]],
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
$('#categoryTable').DataTable({
    responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Category:"
                },
                ajax: {
                    url: "{{ route('category.select') }}"
                },
                columns: [
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
                    { className: 'text-center', targets: [1] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
});
$('#categoryTable1').DataTable({
    responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Category:"
                },
                ajax: {
                    url: "{{ route('category.select') }}"
                },
                columns: [
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
                    { className: 'text-center', targets: [1] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
});
$('#subCategory-table').DataTable({
    responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "asc" ]],
                "searching": false,
                ajax: {
                    url: "{{ route('subcategory.selected') }}",
                    data:function(d){
                        d.categoryFilter = $("#categoryFilter").val()
                    }
                },
                columns: [
                    {
                        data: "name_cat",
                        name: "name_cat"
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
});

$('#rabItem').on("click", ".btn-select", function () {
    const idAsset = $(this).data("id");
    const nameAsset = $(this).data("nama");
    const department = $(this).data("department");
    const detail = $(this).data("detail");
    const coa = $(this).data("coa");
    var value = idAsset + '-' + department + '-' + nameAsset + '-' + detail;
                
    $("#Rab123").val(value);
    $("#idRab").val(idAsset);
    $("#coa").val(coa);
});
$('#vendor-table').on("click", ".btn-select", function () {
    const id = $(this).data("id_vendor");
    const name = $(this).data("name_vendor");
    const type = $(this).data("type");
    var nama = type + ' ' + name
               
    $("#vendor").val(nama);
    $("#vendor1").val(id);
});
$('#brand-table').on("click", ".btn-select", function () {
    const id = $(this).data("id_brand");
    const name = $(this).data("name_brand");
               
    $("#brand").val(name);
    $("#brandFilter").val(id);   

     // Tutup modal pertama
     $('[aria-controls="feedback-modal"]').click();

    // Ganti value option pada #model-select
    $('#model-select option[value="' + id + '"]').prop('selected', true);

    // Refresh tabel #model-select
    $('#model-select').DataTable().ajax.reload();
});
$('#brand-table1').on("click", ".btn-select", function () {
    const id = $(this).data("id_brand");
    const name = $(this).data("name_brand");
               
    $("#brand").val(name);  
    $("#brandFilter").val(id);   

    // Ganti value option pada #model-select
    $('#model-select option[value="' + id + '"]').prop('selected', true);

    // Refresh tabel #model-select
    $('#model-select').DataTable().ajax.reload();
});
$('#model-select').on("click", ".btn-select", function () {
    const id = $(this).data("id_model");
    const name = $(this).data("name_model");
               
    $("#model").val(name);
});
$('#categoryTable').on("click", ".btn-select", function () {
    const id = $(this).data("id_cat");
    const name = $(this).data("name_cat");
               
    $("#category").val(name);
    $("#categoryFilter").val(id);   

     // Tutup modal pertama
     $('[aria-controls="feedback-category"]').click();

    // Ganti value option pada #model-select
    $('#subCategory-table option[value="' + id + '"]').prop('selected', true);

    // Refresh tabel #model-select
    $('#subCategory-table').DataTable().ajax.reload();
});
$('#categoryTable1').on("click", ".btn-select", function () {
    const id = $(this).data("id_cat");
    const name = $(this).data("name_cat");
               
    $("#category").val(name);
    $("#categoryFilter").val(id);   

    // Ganti value option pada #model-select
    $('#subCategory-table option[value="' + id + '"]').prop('selected', true);

    // Refresh tabel #model-select
    $('#subCategory-table').DataTable().ajax.reload();
});
$('#subCategory-table').on("click", ".btn-select", function () {
    const id = $(this).data("id_cat");
    const name = $(this).data("name_cat");
               
    $("#subCategory").val(name);
});
</script>
@endsection
</x-app-layout>