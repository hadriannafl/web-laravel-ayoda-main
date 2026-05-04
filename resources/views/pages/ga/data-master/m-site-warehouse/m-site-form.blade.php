<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Master Site Warehouse 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form action="{{route('m-site-warehouse.create')}}" method="post">
                @csrf
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block text-sm font-medium mb-1" for="company">Company<span
                            class="text-rose-500">*</span></label>
                    <select name="company" id="company" class="company form-input w-full md:w-3/4 px-2 py-1" required>
                        <option value="" selected hidden>Select Company...</option>
                        @foreach ($dataChildCompany as $company)
                        <option value="{{$company->id_company}}">{{$company->name}}</option>
                        @endforeach
                    </select>
                </div>
                @else
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block text-sm font-medium mb-1" for="company">Company<span
                            class="text-rose-500">*</span></label>
                    <select name="companyan" id="companyan" class="companyan form-input w-full md:w-3/4 px-2 py-1 bg-slate-100" disabled required>
                        @foreach ($dataChildCompany as $company)
                        <option value="{{$company->id_company}}" {{Auth::user()->company_id == $company->id_company ? 'selected':''}}>{{$company->name}}</option>
                        @endforeach
                    </select>
                    <input class="bg-slate-100" type="text" name="company" id="company" value="{{Auth::user()->company_id}}" hidden readonly/>
                </div>
                @endif
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="w_name">Warehouse Name<span
                            class="text-rose-500">*</span></label>
                    <input id="w_name" name="w_name" type="text" class="w_name form-input w-full md:w-3/4 px-2 py-1"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="w_address">Address<span
                            class="text-rose-500">*</span></label>
                    <textarea id="w_address" name="w_address" type="text"
                    class="w_address form-input w-full md:w-3/4 px-2 py-1"
                    required rows="3"></textarea>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="w_city">City<span
                            class="text-rose-500">*</span></label>
                    <input id="w_city" name="w_city" type="text"
                        class="w_city form-input w-full md:w-3/4 px-2 py-1"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="w_province">Province<span
                            class="text-rose-500">*</span></label>
                    <input id="w_province" name="w_province" type="text"
                        class="w_province form-input w-full md:w-3/4 px-2 py-1"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="w_country">Country<span
                            class="text-rose-500">*</span></label>
                    <select name="w_country" id="w_country" class="w_country form-input w-full md:w-3/4 px-2 py-1" required>
                        <option value="" hidden>Select Country...</option>
                        @foreach ($dataCountry as $country)
                            <option value="{{$country->name}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="w_zipcode">POS Code<span
                            class="text-rose-500">*</span></label>
                    <input id="w_zipcode" name="w_zipcode" type="text" maxlength="10"
                        class="w_zipcode form-input w-full md:w-3/4 px-2 py-1"
                        required/>
                </div>
                {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="w_pic">PIC<span
                            class="text-rose-500">*</span></label>
                    <input id="w_pic" name="w_pic" type="text"
                        class="w_pic form-input w-full md:w-3/4 px-2 py-1"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="w_phone">Phone<span
                            class="text-rose-500">*</span></label>
                    <input id="w_phone" name="w_phone" type="text"
                        class="w_phone form-input w-full md:w-3/4 px-2 py-1"
                        required/>
                </div> --}}

                <div class="flex flex-row justify-center">
                    <div x-data="{ modalOpen: false }">
                            <button type="button"
                                class="ml-2 btn bg-sky-500 hover:bg-sky-600 text-white mt-5"
                                @click.prevent="modalOpen = true"
                                aria-controls="feedback-modal9127387">
                                <span>View All Site Warehouse</span>
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
                                            <div class="font-semibold text-slate-800">View All Site Warehouse</div>
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
                                            <table id="delivery-address" class="table table-striped table-bordered text-xs" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Company</th>
                                                        <th class="text-center">Warehouse</th>
                                                        <th class="text-center">Address</th>
                                                        <th class="text-center">City</th>
                                                        <th class="text-center">Province</th>
                                                        <th class="text-center">Country</th>
                                                        <th class="text-center">Pos Code</th>
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
                        <span class="xs:block ml-5 mr-5">Create Site Warehouse</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>
    $(document).ready(function () {
        $('#company').on('change', function (e) {
            $('#delivery-address').DataTable().ajax.reload();
        })
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
                    d.company2 = $("#company").val()
                }
            },
            columns: [
                {
                    data: "name",                    
                    name: "name"
                },
                {                    
                    data: "w_name",
                    name: "w_name"
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
            ],
            columnDefs: [
                { className: 'text-center', targets: [6] }
            ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
        });
    });
</script>
@endsection
</x-app-layout>