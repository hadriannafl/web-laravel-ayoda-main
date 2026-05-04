<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Brand/Model Inventory 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <div class="space-y-3">
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="chooseType">Select Create Option<span
                        class="text-rose-500">*</span></label>
                        <select id="chooseType" name="chooseType" class="chooseType form-select w-full md:w-3/4 px-2 py-1" type="text" required/>
                            <option value="" selected hidden>Choose Option...</option>
                                <option value="Brand">Brand</option>
                                <option value="Model">Model</option>
                        </select>
                </div>
            </div>
            <form action="{{route('m-brand.create')}}" method="post" id="brandCreate" hidden>
                @csrf
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="brand">Brand<span
                        class="text-rose-500">*</span></label>
                    <input id="brand" name="brand" type="text"
                    class="brand form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>

                <div class="flex flex-row justify-center">
                    <div x-data="{ modalOpen: false }">
                        <button type="button"
                            class="ml-2 btn bg-sky-500 hover:bg-sky-600 text-white mt-5"
                            @click.prevent="modalOpen = true"
                            aria-controls="feedback-modal9127387">
                            <span>View All Brand</span>
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
                                        <div class="font-semibold text-slate-800 text-sm">View All Brand</div>
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
                                        <table id="brand-table" class="table table-striped table-bordered text-xs" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Brand</th>
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
                        <span class="xs:block ml-5 mr-5">Create Brand</span>
                    </button>
                </div>
            </form>

            <form action="{{route('m-model.create')}}" method="post" id="modelCreate" hidden>
                @csrf
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="brand1">Brand<span
                        class="text-rose-500">*</span></label>
                        <select id="brand1" name="brand1" class="brand1 form-select w-full md:w-3/4 px-2 py-1" type="text" required/>
                            <option value="" selected hidden>Select Brand...</option>
                            @foreach ($dataBrand as $brand)
                            <option value="{{$brand->id_brand}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                </div>

                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="model">Model<span
                        class="text-rose-500">*</span></label>
                    <input id="model" name="model" type="text"
                    class="model form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>

                <div class="flex flex-row justify-center">
                    <div x-data="{ modalOpen: false }">
                        <button type="button"
                            class="ml-2 btn bg-sky-500 hover:bg-sky-600 text-white mt-5"
                            @click.prevent="modalOpen = true"
                            aria-controls="feedback-modal9127387">
                            <span>View All Model</span>
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
                                        <div class="font-semibold text-slate-800 text-sm">View All Model</div>
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
                                        <table id="model-table" class="table table-striped table-bordered text-xs" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Brand</th>
                                                    <th class="text-center">Model</th>
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
                        <span class="xs:block ml-5 mr-5">Create Model</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
$(document).ready(function () {
    $('#model-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        stateServe: true,
        "order": [[ 0, "asc" ]],
        language: {
            search: "Search Brand/Model:"
        },
        ajax: {
            url: "{{ route('m-brand.getdata1')}}",
                data:function(d){                    
                    d.brand1 = $("#brand1").val()
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
            }
        ],
        columnDefs: [
            { className: 'text-center', targets: [] },
            ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
    });
    $('#brand1').on('change', function (e) {
        $('#model-table').DataTable().ajax.reload();
    })
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
            url: "{{ route('m-brand.getdata')}}",
                data:function(d){                    
                    d.brand1 = $("#brand1").val()
                }
        },
        columns: [
            {
                data: "name",
                name: "name"
            }
        ],
        columnDefs: [
            { className: 'text-center', targets: [] },
            ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
    });
});
    $('#chooseType').on('change', function () {
            const chooseType = $(this).val();

            if (chooseType == "Brand") {
                $('#brandCreate').attr('hidden', false);
                $('#modelCreate').attr('hidden', true);
            }else if (chooseType == "Model") {
                $('#brandCreate').attr('hidden', true);
                $('#modelCreate').attr('hidden', false);
            }
        })
</script>
@endsection
</x-app-layout>