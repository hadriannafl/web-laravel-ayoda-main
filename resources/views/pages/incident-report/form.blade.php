<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Form Incident Report 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('incident.create') }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Incident Date Time :</label>
                    <input id="date" name="date"
                        class="date form-input w-full md:w-3/4 px-2 py-1" type="datetime-local"
                        Value="{{date('Y-m-d H:i:s')}}" required />
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id">Report By : </label>
                    <input id="name" name="name"
                        class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->username}}" readonly/>
                    <input id="id" name="id"
                        class="id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->employee_id}}" readonly hidden/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="subject">Subject :
                    </label>
                    <input id="subject" name="subject"
                        class="subject form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="status">Status :
                    </label>
                    <select id="status" name="status"
                        class="status form-select w-full md:w-3/4 px-2 py-1" required>
                            <option selected value="Open">Open</option>
                            <option value="Pending">Pending</option>
                            <option value="Close">Close</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="category">Category :
                    </label>
                    <select id="category" name="category"
                        class="category form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Set Category</option>
                            <option value="Minor">Minor</option>
                            <option value="Medium">Medium</option>
                            <option value="Major">Major</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="dept">Departement :
                    </label>
                    <input id="dept" name="dept"
                        class="dept form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="location">Location :
                    </label>
                    <input id="location" name="location"
                        class="location form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="cronology">Cronology : </label>
                    <textarea id="cronology" name="cronology" class="cronology form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        rows="3" required></textarea>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="division_involve">Division Involve :
                    </label>
                    <select id="division_involve" name="division_involve"
                        class="division_involve form-input w-full md:w-3/4 px-2 py-1" required>
                        <option value="" hidden>Select Division</option>
                        <option value="Accounting">Accounting</option>
                        <option value="Finance">Finance</option>
                        <option value="General Affair">General Affair</option>
                        <option value="Human Resource">Human Resource</option>
                        <option value="IT">IT</option>
                        <option value="Logistic">Logistic</option>
                        <option value="Purchasing">Purchasing</option>
                        <option value="Sales">Sales</option>
                        <option value="Technical">Technical</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="person_involve">Person Involve :
                    </label>
                    <input id="person_involve" name="person_involve"
                        class="person_involve form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="file1">Attachment File 1 :
                    </label>
                    <input name="file1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="file2">Attachment File 2 :
                    </label>
                    <input name="file2" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="file3">Attachment File 3 :
                    </label>
                    <input name="file3" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="img1">Upload Image 1 :
                    </label>
                    <input name="img1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1')"/>
                </div>
                <img id="output1" style="max-width: 300px; max-height: 150px"/>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="img2">Upload Image 2 :
                    </label>
                    <input name="img2" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output2')"/>
                </div>
                <img id="output2" style="max-width: 300px; max-height: 150px"/>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="img3">Upload Image 3 :
                    </label>
                    <input name="img3" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output3')"/>
                </div>
                <img id="output3" style="max-width: 300px; max-height: 150px"/>

                    <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create Report</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>    
            
</script>
@endsection
</x-app-layout>