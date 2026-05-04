<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Preview Inventory Asset Code 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="inventoryCode">Inventory Asset Code<span
                        class="text-rose-500">*</span></label>
                    <input id="inventoryCode" name="inventoryCode"
                    class="inventoryCode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$dataInv->idassets}}" minlength="5" maxlength="100" type="text" oninput="this.value = this.value.toUpperCase().replace(/\s/g, '')" readonly/>
                </div>   
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
                    class="category form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataInv->category}}" readonly required/>
                    <input class="category1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="category1" name="category1" hidden required>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="subCategory">Sub Department<span
                        class="text-rose-500">*</span></label>
                    <input id="subCategory" name="subCategory"
                    class="subCategory form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataInv->sub_category}}" readonly required/>
                    <input id="subCategory1" name="subCategory1"
                    class="subCategory1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" type="text" hidden required/>
                </div>             
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="inventoryName">Inventory Asset Name<span
                        class="text-rose-500">*</span></label>
                    <input id="inventoryName" name="inventoryName" value="{{$dataInv->name}}"
                    class="inventoryName form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="unit">Unit<span
                        class="text-rose-500">*</span></label>
                    <input id="unit" name="unit" value="{{$dataInv->unit}}"
                        class="unit form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" readonly/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="brand">Brand<span
                        class="text-rose-500">*</span></label>
                    <input id="brand" name="brand" value="{{$dataInv->brand}}"
                    class="brand form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly required/>
                    <input class="brand1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" id="brand1" name="brand1" hidden readonly>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="model">Model #<span
                        class="text-rose-500">*</span></label>
                    <input id="model" name="model" value="{{$dataInv->model_number}}"
                    class="model form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                    <input id="model1" name="model1"
                    class="model1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200" type="text" hidden readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="color">Color / Variant</label>
                    <input id="color" name="color" value="{{$dataInv->color}}"
                    class="color form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="sku">Part # / SKU</label>
                    <input id="sku" name="sku" value="{{$dataInv->sku}}"
                    class="sku form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Asset Type<span
                        class="text-rose-500">*</span></label>
                    <input id="sku" name="sku" value="{{$dataInv->type}}"
                    class="sku form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="desc">Description</label>
                    <textarea name="desc" id="desc" class="form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" readonly>{{$dataInv->description}}</textarea>
                </div>
                @if ($dataInv->file != null)
                <div class="flex md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks1">View File Asset</label>
                    <a href="{{ route('office-inventory.file', ['idAsset' => $dataInv->idassets]) }}" target="_blank" class="btn bg-sky-500 hover:bg-sky-600 text-white">View Asset Description</a>
                </div>
                @endif
                @if ($dataInv->img_name != null)
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks1">View Image Asset</label>
                    <img class="w-full md:w-3/4 px-2 py-1" src="http://ayoda.integrated-os.cloud/{{$dataInv->img_name}}" width="260" height="140" alt="Asset Photo"/>
                </div>
                @endif
                <img id="output1" style="max-width: 300px; max-height: 150px"/>
                    <div class="flex flex-row justify-center">
                        <div x-data="{ modalOpen: false }">
                                <button type="button"
                                    class="ml-2 btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5"
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
                                                <div class="font-semibold text-slate-800">View All Code Inventory Assets</div>
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
                        <a href="{{route('office-inventory.updatepage', ['idAsset' => $dataInv->idassets])}}" class="btn bg-amber-500 hover:bg-amber-600 text-white mt-5 ml-3" type="button">
                            <span class="xs:block ml-5 mr-5">Edit</span>
                        </a>
                        <a href="{{route('inventory-code')}}" class="btn bg-purple-500 hover:bg-purple-600 text-white mt-5 ml-3" type="button">
                            <span class="xs:block ml-5 mr-5">Create New </span>
                        </a>
                    </div>
        </div>
    </div>

</div>
@section('js-page')
<script>  
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
</script>
@endsection
</x-app-layout>