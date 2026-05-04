<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Change Incident Report 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('incident.update', ['reportId' => $dataReport->id])}}">
                @csrf
                <input type="text" name="id_report" value="{{$dataReport->id_report}}" hidden/>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Incident Date Time :</label>
                    <input id="date" name="date"
                        class="date form-input w-full md:w-3/4 px-2 py-1" type="datetime-local"
                        Value="{{date('Y-m-d H:i:s', strtotime($dataReport->date_time))}}" required />
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id">Report By : </label>
                    <input id="name" name="name"
                        class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$dataReport->add_by}}" readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="subject">Subject :
                    </label>
                    <input id="subject" name="subject"
                        class="subject form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" value="{{$dataReport->subject}}" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="status">Status :
                    </label>
                    <select id="status" name="status"
                        class="status form-select w-full md:w-3/4 px-2 py-1" required>
                            <option value="Open" {{ $dataReport->status == 'Open' ? ' selected' : '' }}>Open</option>
                            <option value="Pending" {{ $dataReport->status == 'Pending' ? ' selected' : '' }}>Pending</option>
                            <option value="Close" {{ $dataReport->status == 'Close' ? ' selected' : '' }}>Close</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="category">Category :
                    </label>
                    <select id="category" name="category"
                        class="currency form-select w-full md:w-3/4 px-2 py-1" required>
                            <option value="Minor" {{ $dataReport->category == 'Minor' ? ' selected' : '' }}>Minor</option>
                            <option value="Medium" {{ $dataReport->category == 'Medium' ? ' selected' : '' }}>Medium</option>
                            <option value="Major" {{ $dataReport->category == 'Major' ? ' selected' : '' }}>Major</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="dept">Departement :
                    </label>
                    <input id="dept" name="dept"
                        class="dept form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" value="{{$dataReport->dept}}" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="location">Location :
                    </label>
                    <input id="location" name="location"
                    class="location form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                    type="text" value="{{$dataReport->location}}"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="cronology">Cronology : </label>
                    <textarea id="cronology" name="cronology" class="cronology form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        rows="3" required>{{$dataReport->cronology}}</textarea>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="division_involve">Division Involve :
                    </label>
                    <input id="division_involve" name="division_involve"
                        class="division_involve form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" value="{{$dataReport->division_involve}}"/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="person_involve">Person Involve :
                    </label>
                    <input id="person_involve" name="person_involve"
                        class="person_involve form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" value="{{$dataReport->person_involve}}"/>
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
                        <span class="xs:block ml-5 mr-5">Update Report</span>
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