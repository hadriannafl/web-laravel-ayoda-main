<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Vehicle 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form action="{{route('vehicle.create')}}" method="post">
                @csrf
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="company">Company<span class="text-rose-500">*</span>
                    </label>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                        <select id="company" name="company"
                            class="company form-select w-full md:w-3/4 px-2 py-1" required>
                            <option selected hidden value="">Select Company </option>
                            @foreach ( $dataChildCompany as $company )
                                <option value="{{$company->id_company}}">{{$company->name}}</option>
                            @endforeach
                        </select>
                    @else
                        <select id="companyTest" name="companyTest"
                            class="companyTest form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" disabled required>
                                <option value="{{$fixCompany->id_company}}" selected>{{$fixCompany->name}}</option>
                        </select>
                        <input id="company" name="company"
                        class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$fixCompany->id_company}}" readonly hidden/>
                    @endif
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="vehicle_type">Vehicle Type<span class="text-rose-500">*</span></label>
                    <select id="vehicle_type" name="vehicle_type" type="text" class="vehicle_type form-select w-full md:w-3/4 px-2 py-1" required>
                        <option value="" selected hidden>Select Vehicle</option>
                        <option value="Car">Car</option>
                        <option value="Dump Truk">Dump Truk</option>
                        <option value="Light Vehicle">Light Vehicle</option>
                        <option value="Motorcycle">Motorcycle</option>
                        <option value="Tug Boat">Tug Boat</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="vehicle_number">Vehicle Number<span
                        class="text-rose-500">*</span></label>
                    <input id="vehicle_number" name="vehicle_number" type="text" class="vehicle_number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="engine_number">Engine Number<span
                        class="text-rose-500">*</span></label>
                    <input id="engine_number" name="engine_number" type="text" class="engine_number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="frame_number">Frame Number<span
                        class="text-rose-500">*</span></label>
                    <input id="frame_number" name="frame_number" type="text" class="frame_number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="active_date">Active Date<span
                        class="text-rose-500">*</span></label>
                    <input id="active_date" name="active_date" value="{{date('Y-m-d')}}"
                        class="active_date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>

                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Submit Vehicle</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
</x-app-layout>