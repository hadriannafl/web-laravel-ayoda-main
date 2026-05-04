<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Delivery Address - Edit 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <div x-data="{ modalOpen: false }">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white text-xs mb-3" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>&nbsp; Create New Delivery Address</button>
                    <!-- Modal backdrop -->
                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
                        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true"
                        x-cloak></div>
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
                        <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                        @keydown.escape.window="modalOpen = false">
                            <!-- Modal header -->
                            <div class="px-5 py-3 border-b border-slate-200">
                                <div class="flex justify-between items-center">
                                    <div class="font-semibold text-slate-800">Create New Delivery Address</div>
                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <form action="{{route('delivery-address.create')}}" method="post">
                                @csrf
                                <!-- Modal content -->
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="company">Company<span
                                                    class="text-rose-500">*</span></label>
                                            <select name="company" id="company" class="company form-input w-full px-2 py-1" required>
                                                <option value="" selected hidden>Select Company Site...</option>
                                                @foreach ($dataChildCompany as $company)
                                                <option value="{{$company->id_company}}">{{$company->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="address">Address<span
                                                    class="text-rose-500">*</span></label>
                                            <textarea id="address" name="address" type="text"
                                            class="address form-input w-full px-2 py-1"
                                            required rows="3"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="city">City<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="city" name="city" type="text"
                                                class="city form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="province">Province<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="province" name="province" type="text"
                                                class="province form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="country">Country<span
                                                    class="text-rose-500">*</span></label>
                                            <select name="country" id="country" class="country form-input w-full px-2 py-1" required>
                                                <option value="" hidden>Select Country...</option>
                                                @foreach ($dataCountry as $country)
                                                    <option value="{{$country->name}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="zip_code">Pos Code<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="zip_code" name="zip_code" type="text"
                                                class="zip_code form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="px-5 py-4 border-t border-slate-200">
                                    <div class="flex flex-wrap justify-end space-x-2">
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Cancel</button>
                                        <button type="submit" id="submit"
                                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>     
            </label>
        </div>
        <div class="table-responsive">
            <table id="delivery-address" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Company</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">City</th>
                        <th class="text-center">Province</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">Pos Code</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
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
                    url: "{{ route('delivery-address.getdata') }}"
                },
                columns: [
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "address",
                        name: "address"
                    },
                    {
                        data: "city",
                        name: "city"
                    },
                    {
                        data: "province",
                        name: "province"
                    },
                    {
                        data: "country",
                        name: "country"
                    },
                    {
                        data: "zip_code",
                        name: "zip_code"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [5] },
                    { className: 'flex justify-center', targets: [6] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#delivery-address').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const address = $(this).data('address');
                const country = $(this).data('country');
                const city = $(this).data('city');
                const province = $(this).data('province');
                const zip_code = $(this).data('zip_code');
                const company = $(this).data('company');
                const name = $(this).data('name');

                $.ajax({
                    type: "GET",
                    url: `/data-master/m-delivery-address/getdata/${id}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/data-master/m-delivery-address/update/${id}">
                                <input type="hidden" name="_token" value="${csrf_token}"/>
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="company1">Company Site<span
                                                    class="text-rose-500">*</span></label>
                                            <select name="company1" id="company1" class="company1 form-input w-full px-2 py-1" required>
                                                @foreach ($dataChildCompany as $company)
                                                    <option value="{{$company->id_company}}" ${company == '{{$company->id_company}}' ? 'selected':''}>{{$company->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="address1">Address<span
                                                    class="text-rose-500">*</span></label>
                                            <textarea id="address1" name="address1"
                                                class="address1 form-input w-full px-2 py-1" rows="3"
                                                required>${address}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="city1">City<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="city1" name="city1" type="text"
                                                class="city1 form-input w-full px-2 py-1" value="${city}"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="province1">Province<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="province1" name="province1" type="text"
                                                class="province1 form-input w-full px-2 py-1" value="${province}"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="country1">Country<span
                                                    class="text-rose-500">*</span></label>
                                                <select name="country1" id="country1" class="country1 form-input w-full px-2 py-1" required>
                                                <option value="${country}" hidden>${country}</option>
                                                @foreach ($dataCountry as $country)
                                                    <option value="{{$country->name}}" ${country == '{{$country->name}}' ? 'selected':''}>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="zip_code1">Pos Code<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="zip_code1" name="zip_code1" type="text"
                                                class="zip_code1 form-input w-full px-2 py-1" value="${zip_code}"
                                                required/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Cancel</button>
                                            <button type="submit"
                                                class="btn-sm btn-update bg-indigo-500 hover:bg-indigo-600 text-white">Update</button>
                                        </div>
                                    </div>
                            </form>
                        `);
                    },
                });
            });

            $('#delivery-address').on("click", ".btn-delete",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure',
                    text: "Want to Delete Data Delivery Address?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: `/data-master/m-delivery-address/delete/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Data Delivery Address has been Deleted.',
                                        message
                                    )
                                    window.location.reload(true);
                                }
                            },
                            error: function (data) {
                                console.info("error: ", data)
                            }
                        })

                    }
                })
            });
        });
    </script>
    @endsection
</x-app-layout>