<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Child Company - Edit 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        {{-- <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <div x-data="{ modalOpen: false }">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white text-xs mb-3" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>&nbsp; Create New Child Company</button>
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
                                    <div class="font-semibold text-slate-800">Create New Child Company</div>
                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <form action="{{route('child-company.create1')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <!-- Modal content -->
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="companyType">Company Type<span
                                                    class="text-rose-500">*</span></label>
                                            <select name="companyType" id="companyType" class="companyType form-input w-full px-2 py-1" required>
                                                <option value="" hidden>Select Company Type...</option>
                                                <option value="CV">CV</option>
                                                <option value="PD">PD</option>
                                                <option value="PT">PT</option>
                                                <option value="UD">UD</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="childName">Company Name<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="childName" name="childName" type="text"
                                                class="childName form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="initials">Initials<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="initials" name="initials" type="text" maxlength="5"
                                                class="initials form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="address">Address<span
                                                    class="text-rose-500">*</span></label>
                                            <textarea id="address" name="address"
                                                class="address form-input w-full px-2 py-1" rows="3"
                                                required></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="city">City<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="city" name="city" type="text"
                                                class="city form-input w-full px-2 py-1"
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
                                            <label class="block text-sm font-medium mb-1" for="zipCode">POS Code<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="zipCode" name="zipCode" type="text"
                                                class="zipCode form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="npwp_id">NPWP ID<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="npwp_id" name="npwp_id" type="text"
                                                class="npwp_id form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="npwp_address">NPWP Address<span
                                                    class="text-rose-500">*</span></label>
                                            <textarea id="npwp_address" name="npwp_address"
                                                class="npwp_address form-input w-full px-2 py-1" rows="3"
                                                required></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="npwp_city">NPWP City<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="npwp_city" name="npwp_city" type="text"
                                                class="npwp_city form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="npwp_country">NPWP Country<span
                                                    class="text-rose-500">*</span></label>
                                                    <select name="npwp_country" id="npwp_country" class="npwp_country form-input w-full px-2 py-1" required>
                                                        <option value="" hidden>Select Country...</option>
                                                        @foreach ($dataCountry as $country)
                                                            <option value="{{$country->name}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="npwp_zipcode">NPWP POS Code<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="npwp_zipcode" name="npwp_zipcode" type="text"
                                                class="npwp_zipcode form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1"
                                                for="npwp_pdf">NPWP PDF<span class="text-rose-500">*</span>
                                            </label>
                                            <input id="npwp_pdf" name="npwp_pdf" class="form-input w-full px-2 py-1" type="file" accept="application/pdf"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1"
                                                for="img">Company's Logo<span class="text-rose-500">*</span>
                                            </label>
                                            <input id="img" name="img" class="form-input w-full px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1')"/>
                                        </div>
                                        <div>
                                            <img id="output1" style="max-width: 300px; max-height: 150px"/>
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
        </div> --}}
        <div class="table-responsive">
            <table id="child-company" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Initials</th>
                        <th class="text-center">Logo</th>
                        <th class="text-center">Company Type</th>
                        <th class="text-center">Company Name</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">City</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">POS Code</th>
                        <th class="text-center">NPWP ID</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#child-company').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 3, "asc" ]],
                language: {
                    search: "Search Company:"
                },
                ajax: {
                    url: "{{ route('child-company.getdata') }}"
                },
                columns: [
                    {
                        data: "initials",
                        name: "initials"
                    },
                    {
                        data: "logo",
                        name: "logo"
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
                        data: "country",
                        name: "country"
                    },
                    {
                        data: "city",
                        name: "city"
                    },
                    {
                        data: "address",
                        name: "address"
                    },
                    {
                        data: "zip_code",
                        name: "zip_code"
                    },
                    {
                        data: "npwp_id",
                        name: "npwp_id"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 7] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#child-company').on("click", ".btn-modal", function () {
                const id_company = $(this).data('id_company');
                const zip_code = $(this).data('zip_code');
                const initials = $(this).data('initials');
                const name = $(this).data('name');
                const country = $(this).data('country');
                const city = $(this).data('city');
                const address = $(this).data('address');
                const type = $(this).data('type');
                const npwp_id = $(this).data('npwp_id');
                const npwp_address = $(this).data('npwp_address');
                const npwp_city = $(this).data('npwp_city');
                const npwp_country = $(this).data('npwp_country');
                const npwp_zipcode = $(this).data('npwp_zipcode');

                $.ajax({
                    type: "GET",
                    url: `/data-master/m-child-company/getdata/${id_company}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/data-master/m-child-company/update/${id_company}">
                                <input type="hidden" name="_token" value="${csrf_token}" />
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="companyType1">Company Type</label>
                                            <select name="companyType1" id="companyType1" class="companyType1 form-input w-full px-2 py-1 bg-slate-100" disabled required>
                                                <option value="CV" ${type == 'CV' ? 'selected':''}>CV</option>
                                                <option value="PD" ${type == 'PD' ? 'selected':''}>PD</option>
                                                <option value="PO" ${type == 'PO' ? 'selected':''}>PO</option>
                                                <option value="PT" ${type == 'PT' ? 'selected':''}>PT</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="childName1">Company Name</label>
                                            <input id="childName1" name="childName1" type="text"
                                                class="childName1 form-input w-full px-2 py-1" value="${name}"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="initials1">Initials</label>
                                            <input id="initials1" name="initials1" type="text"
                                                class="initials1 form-input w-full px-2 py-1" value="${initials}"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="address1">Address</label>
                                            <textarea id="address1" name="address1"
                                                class="address1 form-input w-full px-2 py-1" rows="3"
                                                required>${address}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="city1">City</label>
                                            <input id="city1" name="city1" type="text"
                                                class="city1 form-input w-full px-2 py-1" value="${city}"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="country1">Country</label>
                                                <select name="country1" id="country1" class="country1 form-input w-full px-2 py-1" required>
                                                <option value="${country}" hidden>${country}</option>
                                                @foreach ($dataCountry as $country)
                                                    <option value="{{$country->name}}" ${country == '{{$country->name}}' ? 'selected':''}>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="zipCode1">POS Code</label>
                                            <input id="zipCode1" name="zipCode1" type="text"
                                                class="zipCode1 form-input w-full px-2 py-1" maxlength="10" value="${zip_code}"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="npwp_id1">NPWP ID</label>
                                            <input id="npwp_id1" name="npwp_id1" type="text"
                                                class="npwp_id1 form-input w-full px-2 py-1" value="${npwp_id}"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="npwp_address1">NPWP Address</label>
                                            <textarea id="npwp_address1" name="npwp_address1"
                                                class="npwp_address1 form-input w-full px-2 py-1" rows="3"
                                                required>${npwp_address}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="npwp_city1">NPWP City</label>
                                            <input id="npwp_city1" name="npwp_city1" type="text"
                                                class="npwp_city1 form-input w-full px-2 py-1" value="${npwp_city}"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="npwp_country1">NPWP Country</label>
                                                    <select name="npwp_country1" id="npwp_country1" class="npwp_country1 form-input w-full px-2 py-1" required>
                                                        @foreach ($dataCountry as $country)
                                                            <option value="{{$country->name}}" ${npwp_country == '{{$country->name}}' ? 'selected':''}>{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="npwp_zipcode1">NPWP POS Code</label>
                                            <input id="npwp_zipcode1" name="npwp_zipcode1" type="text"
                                                class="npwp_zipcode1 form-input w-full px-2 py-1" maxlength="10" value="${npwp_zipcode}"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1"
                                                for="npwp_pdf1">NPWP PDF
                                            </label>
                                            <input id="npwp_pdf1" name="npwp_pdf1" class="form-input w-full px-2 py-1" type="file" accept="application/pdf"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="image1">Company's Logo</label>
                                            <input id="image1" name="image1" type="file" accept="image/jpeg"
                                                class="image1 form-input w-full px-2 py-1" onchange="loadFileMultiple(event, 'output2')"/>
                                        </div>
                                        <div>
                                            <img id="output2" style="max-width: 300px; max-height: 150px"/>
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
                                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Update</button>
                                    </div>
                                </div>
                            </form>
                        `);
                    },
                });
            });

            $('#child-company').on("click", ".btn-delete",  function () {
                const id_company = $(this).data("id_company");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Delete Child Company!",
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
                            url: `/data-master/m-child-company/delete/${id_company}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Child Company has been Deleted.',
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