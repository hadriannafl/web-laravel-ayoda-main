<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Update Note 📝</h1>
        </div>
        <form action="{{ route('note.update', ['noteId' => $noteData->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="px-5 py-4">
                <div class="space-y-3">
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name">Note Title :</label>
                        <input id="name" name="name" class=" name form-input w-full md:w-3/4 px-2 py-1"
                            value="{{$noteData->name}}"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="desc">Notes : </label>
                        <textarea id="desc" name="desc" class="desc form-input w-full md:w-3/4 px-2 py-1" type="text" rows="3"/>{{$noteData->notes}}</textarea>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Upload Image :
                        </label>
                        <input name="photo" class="photo form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1')"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row ml-72 mt-3">
                        <img id="output1" style="max-width: 300px; max-height: 150px"/>
                    </div>  
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for=""></label>
                        <input id="company" name="file"
                            class="file form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 mb-3" type="text"
                            readonly disabled value="{{ $noteData->image_name}}" />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="users">Created By :</label>
                        <input id="users" name="users" class=" users form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                            value="{{$noteData->username}}" readonly/>
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="px-5 py-4 border-t border-slate-200">
            @if ($noteData->add_by == Auth::user()->id)                                                                            
            <div class="flex flex-wrap justify-end space-x-2">
                <button class="btn-sm text- bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">Update</button>
            </div>
            @endif
            </div>
                </div>
            </div>
        </form>
    </div>

    @section('js-page')
    <script>
    </script>
    @endsection
</x-app-layout>