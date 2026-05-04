<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                   Upload Document Request 📋
                </h1>
            </div>
        </div>

        <!-- form -->
        <form method="post" class="form_upload" enctype="multipart/form-data" action="{{ route('document.upload', ['offeringId' => $dataDocument->id_offerings, 'productId' => $dataDocument->product_id]) }}">
            @csrf
            <input type="text" id="offer" name="offer" class="offer form-input px-2 py-1 ml-5" value="{{$dataDocument->id_offerings}}" hidden></input>
            <input type="text" id="product" name="product" class="product form-input px-2 py-1 ml-5" value="{{$dataDocument->product_id}}" hidden></input>
            <div class="flex flex-col md:flex-row">
                <label class="block text-sm font-medium mb-1" for="botes">Document Date : </label>
                <input type="date" id="date" name="date" class="date form-input px-2 py-1 ml-5" required></input>
            </div>
            <div class="grid md:grid-cols-3 gap-3 mt-3">
                <div>
                    <label class="block text-sm font-medium mb-1" for="file">Upload Document 1:</label>
                    <input name="file1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="file">Upload Document 2:</label>
                    <input name="file2" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf"/>
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-3 mt-5">
                <div>
                    <label class="block text-sm font-medium mb-1" for="file">Upload Image 1:</label>
                    <input name="photo1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1-${code}')"/>
                    <img id="output1-${code}" style="max-width: 300px; max-height: 150px" class="mt-2 ml-3"/>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="file">Upload Image 2:</label>
                    <input name="photo2" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output2-${code}')"/>
                    <img id="output2-${code}" style="max-width: 300px; max-height: 150px" class="mt-2 ml-3"/>
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-3 mt-3" {{$dataDocument->blob2 == 1 ? '' : 'hidden'}}>
                <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit">
                    <span class="xs:block ml-5 mr-5">Upload Document</span>
                </button></center>
            </div>
        </form>
    </div>
    </div>

    @section('js-page')
    <script>

    </script>
    @endsection
</x-app-layout>