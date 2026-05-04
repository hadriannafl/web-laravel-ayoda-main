<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Child Company 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form action="{{route('child-company.create')}}" method="post">
                @csrf
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block text-sm font-medium mb-1" for="companyType">Company Type<span
                            class="text-rose-500">*</span></label>
                    <select name="companyType" id="companyType" class="companyType form-select w-full md:w-3/4 px-2 py-1" required>
                        <option value="" hidden>Select Company Type...</option>
                        <option value="CV">CV</option>
                        <option value="PD">PD</option>
                        <option value="PT">PT</option>
                        <option value="UD">UD</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="childName">Company Name<span
                        class="text-rose-500">*</span></label>
                    <input id="childName" name="childName" type="text"
                    class="childName form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="initials">Initials<span
                        class="text-rose-500">*</span></label>
                    <input id="initials" name="initials" type="text" maxlength="5"
                    class="initials form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="childName">Address<span
                        class="text-rose-500">*</span></label>
                    <textarea id="address" name="address" rows="3" class="address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" required></textarea>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="city">City<span
                        class="text-rose-500">*</span></label>
                    <input id="city" name="city" type="text"
                    class="city form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="country">Country<span
                        class="text-rose-500">*</span></label>
                    <select name="country" id="country" class="country form-select w-full md:w-3/4 px-2 py-1" required>
                        <option value="" hidden>Select Country...</option>
                        @foreach ($dataCountry as $country)
                            <option value="{{$country->name}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="zipCode">POS Code<span
                        class="text-rose-500">*</span></label>
                    <input id="zipCode" name="zipCode" type="text"
                    class="zipCode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" maxlength="10" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_id">NPWP ID<span
                        class="text-rose-500">*</span></label>
                    <input id="npwp_id" name="npwp_id" type="text"
                    class="npwp_id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_address">NPWP Address<span
                        class="text-rose-500">*</span></label>
                    <textarea id="npwp_address" name="npwp_address"
                    class="npwp_address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3" required></textarea>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_city">NPWP City<span
                        class="text-rose-500">*</span></label>
                    <input id="npwp_city" name="npwp_city" type="text"
                    class="npwp_city form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_country">NPWP Country<span
                        class="text-rose-500">*</span></label>
                    <select name="npwp_country" id="npwp_country" class="npwp_country form-select w-full md:w-3/4 px-2 py-1" required>
                        <option value="" hidden>Select Country...</option>
                        @foreach ($dataCountry as $country)
                            <option value="{{$country->name}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_zipcode">NPWP POS Code<span
                        class="text-rose-500">*</span></label>
                    <input id="npwp_zipcode" name="npwp_zipcode" type="text"
                    class="npwp_zipcode form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" maxlength="10" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1"
                        for="npwp_pdf">NPWP PDF
                    </label>
                    <input id="npwp_pdf" name="npwp_pdf" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1"
                        for="img">Company's Logo
                    </label>
                    <input id="img" name="img" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1')"/>
                </div>

                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create Child Company</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
</x-app-layout>