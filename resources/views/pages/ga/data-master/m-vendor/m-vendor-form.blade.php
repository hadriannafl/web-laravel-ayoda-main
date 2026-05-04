<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Master Vendor Preference 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form action="{{route('m-vendor.create')}}" id="createVendor" method="post" enctype="multipart/form-data">
                @csrf
                @if (Auth::user()->role_name == 'Finance')
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="vendors">Company Type / Vendor's Department<span class="text-rose-500">*</span></label>
                            <div style="width: 31rem; margin-right: 41px;">
                                <select id="companyType" name="companyType" class="companyType form-select w-full px-2 py-1" required>
                                    <option value="" hidden selected>Select Vendor's Type...</option>
                                    <option value="-">-</option>
                                    <option value="BPJS">BPJS</option>
                                    <option value="BPR">BPR</option>
                                    <option value="CV">CV</option>
                                    <option value="E-Commerce">E-Commerce</option>
                                    <option value="Government">Government</option>
                                    <option value="Koperasi">Koperasi</option>
                                    <option value="Perseorangan">Perseorangan</option>
                                    <option value="PD">PD</option>
                                    <option value="Post Pelayanan Kesehatan">Post Pelayanan Kesehatan</option>
                                    <option value="PT">PT</option>
                                    <option value="Tax">Tax</option>
                                    <option value="Toko">Toko</option>
                                    <option value="UD">UD</option>
                                </select>
                            </div>
                            <div>
                                <select id="vendor_type" name="vendor_type" style="width: 31.7rem;" class="vendor_type form-select w-full px-2 py-1" required>
                                    <option value="" hidden selected>Select Department</option>
                                    <option value="0">All</option>
                                    <option value="1">Purchasing</option>
                                    <option value="2">Finance</option>
                                </select>
                            </div>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="vendor">Vendor's Name<span
                                class="text-rose-500">*</span></label>
                        <input id="vendor" name="vendor" type="text"
                            class="vendor form-input w-full md:w-3/4 px-2 py-1"
                            required/>
                    </div>
                    {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="initials">Initials</label>
                        <input id="initials" name="initials" type="text" maxlength="5"
                            class="initials form-input w-full md:w-3/4 px-2 py-1"
                        />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="category">Category</label>
                        <input id="category" name="category" type="text"
                            class="category form-input w-full md:w-3/4 px-2 py-1"
                        />
                    </div> --}}
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="address">Address</label>
                        <textarea id="address" name="address" type="text"
                        class="address form-input w-full md:w-3/4 px-2 py-1"
                    rows="3"></textarea>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                        <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">Minimal Address is 1 character</div>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="city">City</label>
                        <input id="city" name="city" type="text"
                            class="city form-input w-full md:w-3/4 px-2 py-1"
                        />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                        <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">Minimal City is 1 character</div>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="phone">Contact Phone</label>
                        <input id="phone" name="phone" type="text"
                            class="phone form-input w-full md:w-3/4 px-2 py-1"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="country">Country<span
                            class="text-rose-500">*</span></label>
                        <select name="country" id="country" class="country form-input w-full md:w-3/4 px-2 py-1" required>
                            <option value="" hidden>Select Country...</option>
                            @foreach ($dataCountry as $country)
                                <option value="{{$country->name}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="zipCode">POS Code</label>
                        <input id="zipCode" name="zipCode" type="text"
                        class="zipCode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" maxlength="10" type="text"/>
                    </div>
                    <div>
                        <div class="flex flex-row mb-3 mt-3">
                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Bank / Account / Name<span
                                class="text-rose-500">*</span></label>
                                <div>
                                    <select style="width: 20rem;" id="bank" name="bank" class="bank form-select w-full px-2 py-1" required>
                                        <option value="" hidden>Select Bank</option>
                                        {{-- <option value="-">-</option> --}}
                                        {{-- <option value="Cash">Cash</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Cheque/Giro">Cheque/Giro</option> --}}
                                        @foreach ($bank as $bankir )
                                            <option value="{{$bankir->name}}">{{$bankir->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="width: 20rem; margin-right: 25.5px; margin-left:25.5px;">
                                    <input id="number" name="number" class="number form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Bank Account"/>
                                </div>
                                <div>
                                    <input id="account" name="account" style="width: 22rem;" class="account form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Bank Account Name"/>
                                </div>
                        </div>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_id">NPWP ID</label>
                        <input id="npwp_id" name="npwp_id" type="text"
                        class="npwp_id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_address">NPWP Address</label>
                        <textarea id="npwp_address" name="npwp_address"
                        class="npwp_address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_city">NPWP City</label>
                        <input id="npwp_city" name="npwp_city" type="text"
                        class="npwp_city form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_country">NPWP Country</label>
                        <select name="npwp_country" id="npwp_country" class="npwp_country form-select w-full md:w-3/4 px-2 py-1">
                            <option value="" hidden>Select Country...</option>
                            @foreach ($dataCountry as $country)
                                <option value="{{$country->name}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_zipcode">NPWP POS Code</label>
                        <input id="npwp_zipcode" name="npwp_zipcode" type="text"
                        class="npwp_zipcode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" maxlength="10" type="text"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block md:w-1/4 text-sm font-medium mb-1" for="npwp_pdf1">NPWP PDF</label>
                        <input id="npwp_pdf1" name="npwp_pdf1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                    </div>
                @else
                    <div class="flex flex-row mb-3 mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="vendors">Company's Type / Vendor's Department<span class="text-rose-500">*</span></label>
                            <div style="width: 31rem; margin-right: 41px;">
                                <select id="companyType" name="companyType" class="companyType form-select w-full px-2 py-1" required>
                                    <option value="" hidden selected>Select Vendor's Type...</option>
                                    {{-- <option value="-">-</option> --}}
                                    <option value="BPJS">BPJS</option>
                                    <option value="BPR">BPR</option>
                                    <option value="CV">CV</option>
                                    <option value="E-Commerce">E-Commerce</option>
                                    <option value="Government">Government</option>
                                    <option value="Koperasi">Koperasi</option>
                                    <option value="Perseorangan">Perseorangan</option>
                                    <option value="PD">PD</option>
                                    <option value="Post Pelayanan Kesehatan">Post Pelayanan Kesehatan</option>
                                    <option value="PT">PT</option>
                                    <option value="Tax">Tax</option>
                                    <option value="Toko">Toko</option>
                                    <option value="UD">UD</option>
                                </select>
                            </div>
                            <div>
                                <select id="vendor_type" name="vendor_type" style="width: 31.7rem;" class="vendor_type form-select w-full px-2 py-1" required>
                                    <option value="" hidden selected>Select Department</option>
                                    <option value="0">All</option>
                                    <option value="1">Purchasing</option>
                                    <option value="2">Finance</option>
                                </select>
                            </div>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="vendor">Vendor's Name<span
                                class="text-rose-500">*</span></label>
                        <input id="vendor" name="vendor" type="text"
                            class="vendor form-input w-full md:w-3/4 px-2 py-1"
                            required/>
                    </div>
                    {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="initials">Initials</label>
                        <input id="initials" name="initials" type="text" maxlength="5"
                            class="initials form-input w-full md:w-3/4 px-2 py-1"
                        />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="category">Category</label>
                        <input id="category" name="category" type="text"
                            class="category form-input w-full md:w-3/4 px-2 py-1"
                        />
                    </div> --}}
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="address">Address<span
                            class="text-rose-500">*</span></label>
                        <textarea id="address" name="address" type="text"
                        class="address form-input w-full md:w-3/4 px-2 py-1"
                    rows="3"></textarea>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                        <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">Full address is required</div>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="city">City<span
                            class="text-rose-500">*</span></label>
                        <input id="city" name="city" type="text"
                            class="city form-input w-full md:w-3/4 px-2 py-1"
                        />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                        <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">Full City is required</div>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="phone">Contact Phone</label>
                        <input id="phone" name="phone" type="text"
                            class="phone form-input w-full md:w-3/4 px-2 py-1"
                        />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block text-sm font-medium mb-1" for="country">Country<span
                            class="text-rose-500">*</span></label>
                        <select name="country" id="country" class="country form-input w-full md:w-3/4 px-2 py-1" required>
                            <option value="" hidden>Select Country...</option>
                            @foreach ($dataCountry as $country)
                                <option value="{{$country->name}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="zipCode">POS Code</label>
                        <input id="zipCode" name="zipCode" type="text"
                        class="zipCode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" maxlength="10" type="text"/>
                    </div>
                    <div>
                        <div class="flex flex-row mb-3 mt-3">
                            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Bank / Account / Name<span
                                class="text-rose-500">*</span></label>
                                <div>
                                    <select style="width: 20rem;" id="bank" name="bank" class="bank form-select w-full px-2 py-1" required>
                                        <option value="" hidden>Select Bank</option>
                                        {{-- <option value="-">-</option> --}}
                                        {{-- <option value="Cash">Cash</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Cheque/Giro">Cheque/Giro</option> --}}
                                        @foreach ($bank as $bankir )
                                            <option value="{{$bankir->name}}">{{$bankir->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="width: 20rem; margin-right: 25.5px; margin-left:25.5px;">
                                    <input id="number" name="number" class="number form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Bank Account"/>
                                </div>
                                <div>
                                    <input id="account" name="account" style="width: 22rem;" class="account form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" placeholder="Bank Account Name"/>
                                </div>
                        </div>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_id">NPWP ID</label>
                        <input id="npwp_id" name="npwp_id" type="text"
                        class="npwp_id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_address">NPWP Address</label>
                        <textarea id="npwp_address" name="npwp_address"
                        class="npwp_address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"></textarea>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_city">NPWP City</label>
                        <input id="npwp_city" name="npwp_city" type="text"
                        class="npwp_city form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_country">NPWP Country</label>
                        <select name="npwp_country" id="npwp_country" class="npwp_country form-select w-full md:w-3/4 px-2 py-1">
                            <option value="" hidden>Select Country...</option>
                            @foreach ($dataCountry as $country)
                                <option value="{{$country->name}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_zipcode">NPWP POS Code</label>
                        <input id="npwp_zipcode" name="npwp_zipcode" type="text"
                        class="npwp_zipcode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" maxlength="10" type="text"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block md:w-1/4 text-sm font-medium mb-1" for="npwp_pdf1">NPWP PDF</label>
                        <input id="npwp_pdf1" name="npwp_pdf1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                    </div>
                @endif
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Create Data Vendor</span>
                </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>
    $('#companyType').select2();
    $('#bank').select2();
    $('#vendor_type').on('change', function () {
        const vendstype = $(this).val();
        if (vendstype == '2') {
            $("#address").val('-');
            $("#city").val('-');   
            $("#country").val('Indonesia');   
            $("#npwp_country").val('Indonesia');   
        } else {
            $("#address").val('');
            $("#city").val('');   
            $("#country").val('');  
            $("#npwp_country").val(''); 
        }
    });
    document.getElementById('createVendor').addEventListener('submit', function(event) {
        var address = document.getElementById('address').value.trim();
        var city = document.getElementById('city').value.trim();
        var role = "{{ Auth::user()->role_name }}";

        if (role === 'Finance' && (address.length < 1 || city.length < 1)) {
            alert('Minimal address and city is 1 character');
            event.preventDefault();
        } else if (role !== 'Finance' && (address === '' || address.toLowerCase() === 'null' || city === '' || city.toLowerCase() === 'null')) {
            alert('Full address and city is required');
            event.preventDefault();
        }
    });
</script>
@endsection
</x-app-layout>