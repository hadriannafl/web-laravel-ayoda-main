<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Category/Sub Category Inventory 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <div class="flex justify-between flex-col md:flex-row mb-3">
                <label class="block w-full md:w-1/4 text-sm font-medium" for="chooseType">Select Create Option<span class="text-rose-500">*</span></label>
                    <select id="chooseType" name="chooseType" class="chooseType form-select w-full md:w-3/4 px-2 py-1" type="text" required/>
                        <option value="" selected hidden>Choose Option...</option>
                        <option value="Category">Category</option>
                        <option value="Sub Category">Sub Category</option>
                    </select>
            </div>
        </div>
            <form action="{{route('m-category.create')}}" method="post" id="categoryCreate" hidden>
                @csrf
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="category">Category's Name<span
                        class="text-rose-500">*</span></label>
                    <input id="category" name="category" type="text"
                    class="category form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>

                    <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create Category</span>
                    </button> </center>
            </form>
            <form action="{{route('m-subcategory.create')}}" method="post" id="subCategoryCreate" hidden>
                @csrf
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="category1">Category's Name<span
                        class="text-rose-500">*</span></label>
                        <select id="category1" name="category1" class="category1 form-select w-full md:w-3/4 px-2 py-1" type="text" required/>
                            <option value="" selected hidden>Select Category...</option>
                            @foreach ($dataCat as $cat)
                            <option value="{{$cat->id_cat}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                </div>

                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="subcategory">Sub Category<span
                        class="text-rose-500">*</span></label>
                    <input id="subcategory" name="subcategory" type="text"
                    class="subcategory form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>

                    <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create Sub Category</span>
                    </button> </center>
            </form>
    </div>
</div>
@section('js-page')
<script>  
    $('#chooseType').on('change', function () {
            const chooseType = $(this).val();

            if (chooseType == "Category") {
                $('#categoryCreate').attr('hidden', false);
                $('#subCategoryCreate').attr('hidden', true);
            }else if (chooseType == "Sub Category") {
                $('#categoryCreate').attr('hidden', true);
                $('#subCategoryCreate').attr('hidden', false);
            }
        })
</script>
@endsection
</x-app-layout>