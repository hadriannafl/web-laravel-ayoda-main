<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New Department/Division Inventory 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <div class="space-y-3">
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="chooseType">Select Create Option<span
                        class="text-rose-500">*</span></label>
                        <select id="chooseType" name="chooseType" class="chooseType form-select w-full md:w-3/4 px-2 py-1" type="text" required/>
                            <option value="" selected hidden>Choose Option...</option>
                                <option value="Department">Department</option>
                                <option value="Division">Division</option>
                        </select>
                </div>
            </div>
            <form action="{{route('m-department1.create')}}" method="post" id="departmentCreate" hidden>
                @csrf
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="department">Department<span
                        class="text-rose-500">*</span></label>
                    <input id="department" name="department" type="text"
                    class="department form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>

                    <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create Department</span>
                    </button> </center>
            </form>

            <form action="{{route('m-division.create')}}" method="post" id="divisionCreate" hidden>
                @csrf
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="department1">Department<span
                        class="text-rose-500">*</span></label>
                        <select id="department1" name="department1" class="department1 form-select w-full md:w-3/4 px-2 py-1" type="text" required/>
                            <option value="" selected hidden>Select Department...</option>
                            @foreach ($dataDepartment as $dept)
                            <option value="{{$dept->idrec}}">{{$dept->name}}</option>
                            @endforeach
                        </select>
                </div>

                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="division">Division<span
                        class="text-rose-500">*</span></label>
                    <input id="division" name="division" type="text"
                    class="division form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>

                    <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create Division</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
    $('#chooseType').on('change', function () {
            const chooseType = $(this).val();

            if (chooseType == "Department") {
                $('#departmentCreate').attr('hidden', false);
                $('#divisionCreate').attr('hidden', true);
            }else if (chooseType == "Division") {
                $('#departmentCreate').attr('hidden', true);
                $('#divisionCreate').attr('hidden', false);
            }
        })
</script>
@endsection
</x-app-layout>