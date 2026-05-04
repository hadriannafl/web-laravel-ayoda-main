<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master Vendor Preference - Edit 🗄️
                </h1>
            </div>
        </div>
        <div class="flex flex-row text-xs">
            @if (Auth::user()->role_name == 'IT' || Auth::user()->role_name == 'Administrator')
                <label class="flex flex-row text-xs">
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="dept">Department</p>
                    <select id="dept" class="dept form-select flex flex-row ml-3 mb-3 text-xs" name="dept">
                        <option value="0">All</option>
                        <option value="1">Purchasing</option>
                        <option value="2">Finance</option>
                    </select>
                </label>
            @elseif (Auth::user()->role_name == 'Finance')
                <input type="text" id="dept" name="dept" class="dept form-input" value="2" readonly hidden/>
            @elseif (Auth::user()->role_name == 'Purchasing')
            <input type="text" id="dept" name="dept" class="dept form-input" value="1" readonly hidden/>
            @endif
        </div>
        <div class="table-responsive">
            <table id="vendors" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Vendor's Type</th>
                        <th class="text-center">Vendor's Name</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">City</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">Contact Phone</th>
                        <th class="text-center">POS Code</th>
                        <th class="text-center">NPWP ID</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $('#bank1').select2();
        $(document).ready(function () {
            $('#vendors').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 2, "asc" ]],
                language: {
                    search: "Search Vendor:"
                },
                ajax: {
                    url: "{{ route('m-vendor.getdata') }}",
                    data:function(d){
                        d.dept = $("#dept").val()
                    }
                },
                columns: [
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
                        data: "city",
                        name: "city"
                    },
                    {
                        data: "country",
                        name: "country"
                    },
                    {
                        data: "phone",
                        name: "phone"
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
                        data: "status",
                        name: "status"
                    },   
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 5, 6, 8] },
                    { className: 'flex justify-center', targets: [9] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $("#dept").on('change', function (e) {
                e.preventDefault();
                $('#vendors').DataTable().ajax.reload();
            })

            $('#vendors').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const initials = $(this).data('initials');
                const name = $(this).data('name');
                const address = $(this).data('address');
                const country = $(this).data('country');
                const city = $(this).data('city');
                const type = $(this).data('type');
                const category = $(this).data('category');
                const phone = $(this).data('phone');
                const zip_code = $(this).data('zip_code');
                const npwp_id = $(this).data('npwp_id');
                const npwp_address = $(this).data('npwp_address');
                const npwp_city = $(this).data('npwp_city');
                const npwp_country = $(this).data('npwp_country');
                const npwp_zipcode = $(this).data('npwp_zipcode');
                const bank_acc_num = $(this).data('bank_acc_num');
                const bank_name = $(this).data('bank_name');
                const bank_acc_name = $(this).data('bank_acc_name');
                const vendor_type = $(this).data('vendor_type');

                $.ajax({
                    type: "GET",
                    url: `/data-master/m-vendor/getdata/${id}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');
                        var role = "{{ Auth::user()->role_name }}";
                        if (role == 'Finance') {
                            $(".modal-content").html(`
                                <form method="post" id="updateVendor" class="type_update" enctype="multipart/form-data" action="/data-master/m-vendor/update/${id}">
                                    <input type="hidden" name="_token" value="${csrf_token}"/>
                                    <div class="px-5 py-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-slate-800"></div>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="companyType1">Company Type<span class="text-rose-500">*</span></label>
                                                <select name="companyType1" id="companyType1" class="companyType1 form-input w-full px-2 py-1" required>
                                                    <option value="-" ${type == '-' ? 'selected':''}>-</option>
                                                    <option value="BPJS" ${type == 'BPJS' ? 'selected':''}>BPJS</option>
                                                    <option value="BPR" ${type == 'BPR' ? 'selected':''}>BPR</option>
                                                    <option value="CV" ${type == 'CV' ? 'selected':''}>CV</option>
                                                    <option value="E-Commerce" ${type == 'E-Commerce' ? 'selected':''}>E-Commerce</option>
                                                    <option value="Government" ${type == 'Government' ? 'selected':''}>Government</option>
                                                    <option value="Koperasi" ${type == 'Koperasi' ? 'selected':''}>Koperasi</option>
                                                    <option value="Perseorangan" ${type == 'Perseorangan' ? 'selected':''}>Perseorangan</option>
                                                    <option value="PD" ${type == 'PD' ? 'selected':''}>PD</option>
                                                    <option value="Pos Pelayanan Kesehatan" ${type == 'Pos Pelayanan Kesehatan' ? 'selected':''}>Pos Pelayanan Kesehatan</option>
                                                    <option value="PT" ${type == 'PT' ? 'selected':''}>PT</option>
                                                    <option value="Tax" ${type == 'Tax' ? 'selected':''}>Tax</option>
                                                    <option value="Toko" ${type == 'Toko' ? 'selected':''}>Toko</option>
                                                    <option value="UD" ${type == 'UD' ? 'selected':''}>UD</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="companyType1">Vendor's Department<span class="text-rose-500">*</span></label>
                                                <select name="vendor_type" id="vendor_type" class="vendor_type form-input w-full px-2 py-1" required>
                                                    <option value="0" ${vendor_type == '0' ? 'selected':''}>All</option>
                                                    <option value="1" ${vendor_type == '1' ? 'selected':''}>Purchasing</option>
                                                    <option value="2" ${vendor_type == '2' ? 'selected':''}>Finance</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="childName1">Vendor's Name<span class="text-rose-500">*</span></label>
                                                <input id="childName1" name="childName1" type="text"
                                                    class="childName1 form-input w-full px-2 py-1" value="${name}"
                                                    required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="address1">Address<span class="text-rose-500">*</span></label>
                                                <textarea id="address1" name="address1"
                                                    class="address1 form-input w-full px-2 py-1" rows="3">${address === 'null' ? '' : (address || '-')}</textarea>
                                                <span class="text-rose-500">Minimal Address is 1 character</span>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="city1">City<span class="text-rose-500">*</span></label>
                                                <input id="city1" name="city1" type="text"
                                                    class="city1 form-input w-full px-2 py-1" value="${city === 'null' ? '' : (city || '-')}"/>
                                                <span class="text-rose-500">Minimal City is 1 character</span>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="phone1">Contact Phone</label>
                                                <input id="phone1" name="phone1" type="text"
                                                    class="phone1 form-input w-full px-2 py-1" value="${phone}"/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="country1">Country<span class="text-rose-500">*</span></label>
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
                                                    class="zipCode1 form-input w-full px-2 py-1" maxlength="10" value="${zip_code}"/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="bank1">Bank<span class="text-rose-500">*</span></label>
                                                <select name="bank1" id="bank1" class="company1 form-input w-full px-2 py-1" required>
                                                    <option value="-" ${bank_name == '-' ? 'selected':''}>-</option>
                                                    @foreach ($bank as $item)
                                                        <option value="{{$item->name}}" ${bank_name == '{{$item->name}}' ? 'selected':''}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="number1">Bank Account Number<span class="text-rose-500">*</span></label>
                                                <input id="number1" name="number1" type="text"
                                                    class="number1 form-input w-full px-2 py-1" value="${bank_acc_num}"
                                                    required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="account1">Bank Account Name<span class="text-rose-500">*</span></label>
                                                <input id="account1" name="account1" type="text"
                                                    class="account1 form-input w-full px-2 py-1" value="${bank_acc_name}"
                                                    required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="npwp_id1">NPWP ID</label>
                                                <input id="npwp_id1" name="npwp_id1" type="text"
                                                    class="npwp_id1 form-input w-full px-2 py-1" value="${npwp_id}"/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="npwp_address1">NPWP Address</label>
                                                <textarea id="npwp_address1" name="npwp_address1"
                                                    class="npwp_address1 form-input w-full px-2 py-1" rows="3">${npwp_address}</textarea>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="npwp_city1">NPWP City</label>
                                                <input id="npwp_city1" name="npwp_city1" type="text"
                                                    class="npwp_city1 form-input w-full px-2 py-1" value="${npwp_city}"/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="npwp_country1">NPWP Country</label>
                                                        <select name="npwp_country1" id="npwp_country1" class="npwp_country1 form-input w-full px-2 py-1">
                                                            @foreach ($dataCountry as $country)
                                                                <option value="{{$country->name}}" ${npwp_country == '{{$country->name}}' ? 'selected':''}>{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="npwp_zipcode1">NPWP POS Code</label>
                                                <input id="npwp_zipcode1" name="npwp_zipcode1" type="text"
                                                    class="npwp_zipcode1 form-input w-full px-2 py-1" maxlength="10" value="${npwp_zipcode}"/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1"
                                                    for="npwp_pdf1">NPWP PDF
                                                </label>
                                                <input id="npwp_pdf1" name="npwp_pdf1" class="form-input w-full px-2 py-1" type="file" accept="application/pdf"/>
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
                        } else {
                            $(".modal-content").html(`
                                <form method="post" id="updateVendor" class="type_update" enctype="multipart/form-data" action="/data-master/m-vendor/update/${id}">
                                    <input type="hidden" name="_token" value="${csrf_token}"/>
                                    <div class="px-5 py-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-slate-800"></div>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="companyType1">Company Type<span class="text-rose-500">*</span></label>
                                                <select name="companyType1" id="companyType1" class="companyType1 form-input w-full px-2 py-1" required>
                                                    <option value="-" ${type == '-' ? 'selected':''}>-</option>
                                                    <option value="BPJS" ${type == 'BPJS' ? 'selected':''}>BPJS</option>
                                                    <option value="BPR" ${type == 'BPR' ? 'selected':''}>BPR</option>
                                                    <option value="CV" ${type == 'CV' ? 'selected':''}>CV</option>
                                                    <option value="E-Commerce" ${type == 'E-Commerce' ? 'selected':''}>E-Commerce</option>
                                                    <option value="Government" ${type == 'Government' ? 'selected':''}>Government</option>
                                                    <option value="Koperasi" ${type == 'Koperasi' ? 'selected':''}>Koperasi</option>
                                                    <option value="Perseorangan" ${type == 'Perseorangan' ? 'selected':''}>Perseorangan</option>
                                                    <option value="PD" ${type == 'PD' ? 'selected':''}>PD</option>
                                                    <option value="Pos Pelayanan Kesehatan" ${type == 'Pos Pelayanan Kesehatan' ? 'selected':''}>Pos Pelayanan Kesehatan</option>
                                                    <option value="PT" ${type == 'PT' ? 'selected':''}>PT</option>
                                                    <option value="Tax" ${type == 'Tax' ? 'selected':''}>Tax</option>
                                                    <option value="Toko" ${type == 'Toko' ? 'selected':''}>Toko</option>
                                                    <option value="UD" ${type == 'UD' ? 'selected':''}>UD</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="companyType1">Vendor's Department<span class="text-rose-500">*</span></label>
                                                <select name="vendor_type" id="vendor_type" class="vendor_type form-input w-full px-2 py-1" required>
                                                    <option value="0" ${vendor_type == '0' ? 'selected':''}>All</option>
                                                    <option value="1" ${vendor_type == '1' ? 'selected':''}>Purchasing</option>
                                                    <option value="2" ${vendor_type == '2' ? 'selected':''}>Finance</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="childName1">Vendor's Name<span class="text-rose-500">*</span></label>
                                                <input id="childName1" name="childName1" type="text"
                                                    class="childName1 form-input w-full px-2 py-1" value="${name}"
                                                    required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="address1">Address<span class="text-rose-500">*</span></label>
                                                <textarea id="address1" name="address1"
                                                    class="address1 form-input w-full px-2 py-1" rows="3">${address === 'null' ? '' : (address || '-')}</textarea>
                                                    <span class="text-rose-500">Full address is required</span>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="city1">City<span class="text-rose-500">*</span></label>
                                                <input id="city1" name="city1" type="text"
                                                    class="city1 form-input w-full px-2 py-1" value="${city === 'null' ? '' : (city || '-')}"/>
                                                <span class="text-rose-500">Full address is required</span>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="phone1">Contact Phone</label>
                                                <input id="phone1" name="phone1" type="text"
                                                    class="phone1 form-input w-full px-2 py-1" value="${phone}"/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="country1">Country<span class="text-rose-500">*</span></label>
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
                                                    class="zipCode1 form-input w-full px-2 py-1" maxlength="10" value="${zip_code}"/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="bank1">Bank<span class="text-rose-500">*</span></label>
                                                <select name="bank1" id="bank1" class="company1 form-input w-full px-2 py-1" required>
                                                    <option value="-" ${bank_name == '-' ? 'selected':''}>-</option>
                                                    @foreach ($bank as $item)
                                                        <option value="{{$item->name}}" ${bank_name == '{{$item->name}}' ? 'selected':''}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="number1">Bank Account Number<span class="text-rose-500">*</span></label>
                                                <input id="number1" name="number1" type="text"
                                                    class="number1 form-input w-full px-2 py-1" value="${bank_acc_num}"
                                                    required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="account1">Bank Account Name<span class="text-rose-500">*</span></label>
                                                <input id="account1" name="account1" type="text"
                                                    class="account1 form-input w-full px-2 py-1" value="${bank_acc_name}"
                                                    required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="npwp_id1">NPWP ID</label>
                                                <input id="npwp_id1" name="npwp_id1" type="text"
                                                    class="npwp_id1 form-input w-full px-2 py-1" value="${npwp_id}"/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="npwp_address1">NPWP Address</label>
                                                <textarea id="npwp_address1" name="npwp_address1"
                                                    class="npwp_address1 form-input w-full px-2 py-1" rows="3">${npwp_address}</textarea>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="npwp_city1">NPWP City</label>
                                                <input id="npwp_city1" name="npwp_city1" type="text"
                                                    class="npwp_city1 form-input w-full px-2 py-1" value="${npwp_city}"/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="npwp_country1">NPWP Country</label>
                                                        <select name="npwp_country1" id="npwp_country1" class="npwp_country1 form-input w-full px-2 py-1">
                                                            @foreach ($dataCountry as $country)
                                                                <option value="{{$country->name}}" ${npwp_country == '{{$country->name}}' ? 'selected':''}>{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="npwp_zipcode1">NPWP POS Code</label>
                                                <input id="npwp_zipcode1" name="npwp_zipcode1" type="text"
                                                    class="npwp_zipcode1 form-input w-full px-2 py-1" maxlength="10" value="${npwp_zipcode}"/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1"
                                                    for="npwp_pdf1">NPWP PDF
                                                </label>
                                                <input id="npwp_pdf1" name="npwp_pdf1" class="form-input w-full px-2 py-1" type="file" accept="application/pdf"/>
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
                        }
                    },
                });
            });
            $('#vendor_type').on('change', function () {
                const vendstype = $(this).val();
                if (vendstype == '2') {
                    $("#address1").val('-');
                    $("#city1").val('-');   
                    $("#country1").val('Indonesia');   
                    $("#npwp_country1").val('Indonesia');   
                } else {
                    $("#address1").val('');
                    $("#city1").val('');   
                    $("#country1").val('');  
                    $("#npwp_country1").val(''); 
                }
            });
            document.getElementById('updateVendor').addEventListener('submit', function(event) {
                var address = document.getElementById('address1').value.trim();
                var city = document.getElementById('city1').value.trim();
                var role = "{{ Auth::user()->role_name }}";

                if (role === 'Finance' && (address.length < 1 || city.length < 1)) {
                    alert('Minimal address and city is 1 character');
                    event.preventDefault();
                } else if (role !== 'Finance' && (address === '' || address.toLowerCase() === 'null' || city === '' || city.toLowerCase() === 'null')) {
                    alert('Full address and city is required');
                    event.preventDefault();
                }
            });

            $('#vendors').on("click", ".btn-delete",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Delete Data Vendor!",
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
                            url: `/data-master/m-vendor/delete/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Data Vendor has been Deleted.',
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