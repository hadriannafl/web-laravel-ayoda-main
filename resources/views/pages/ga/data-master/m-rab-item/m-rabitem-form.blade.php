<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">New RAB Item 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form action="{{route('master-rab.create')}}" method="post">
                @csrf
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block text-sm font-medium mb-1" for="department">Department<span
                            class="text-rose-500">*</span></label>
                    <select name="department" id="department" class="department form-input w-full md:w-3/4 px-2 py-1" required>
                        <option value="" selected hidden>Select Department...</option>
                        @foreach ($dataDepartment as $department)
                            <option value="{{$department->id}}">{{$department->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="subDepartment">Sub Department<span
                            class="text-rose-500">*</span></label>
                    <select id="subDepartment" name="subDepartment" type="text"
                            class="subDepartment form-input w-full md:w-3/4 px-2 py-1" required disabled>
                        <option value="" selected hidden>Select Sub Department...</option>
                        @foreach ($dataSubDepartment as $subdepartment)
                            @if ($subdepartment->dept_name === $department->name)
                                <option value="{{ $subdepartment->id }}">{{ $subdepartment->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="detail">Detail<span
                            class="text-rose-500">*</span></label>
                    <input id="detail" name="detail" type="text"
                        class="detail form-input w-full md:w-3/4 px-2 py-1"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block text-sm font-medium mb-1" for="coa">Chart of Account (COA)<span
                            class="text-rose-500">*</span></label>
                    <input id="coa" name="coa" type="text" value="0"
                        class="coa form-input w-full md:w-3/4 px-2 py-1"
                        required/>
                </div>

                    <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create RAB Item</span>
                    </button> </center>
            </form>
        </div>
    </div>
</div>
@section('js-page')
<script>
    document.getElementById('department').addEventListener('change', function () {
    var selectedDepartment = this.value;
    var subDepartmentSelect = document.getElementById('subDepartment');

    // Mengaktifkan atau menonaktifkan form select Sub Department berdasarkan pilihan Department
    if (selectedDepartment !== '') {
        subDepartmentSelect.removeAttribute('disabled');
        // Menghapus opsi yang ada dalam select Sub Department
        while (subDepartmentSelect.options.length > 1) {
            subDepartmentSelect.remove(1);
        }

        // Menambahkan opsi yang sesuai dengan Department yang dipilih
       @foreach ($dataSubDepartment as $subdepartment)
        var departmentName = "{{ $subdepartment->p_id_dept }}";
        if (departmentName === selectedDepartment) {
            var option = document.createElement('option');
            var displayValue = "{{ $subdepartment->id }}";
            var displayName = "{{ $subdepartment->name }}";
            displayName = displayName.replace(/&amp;/g, '&'); // Mengganti &amp; kembali menjadi &
            option.value = displayValue;
            option.text = displayName;
            subDepartmentSelect.appendChild(option);
        }
    @endforeach
    } else {
        // Menonaktifkan dan mengembalikan opsi yang asli jika Department tidak dipilih
        subDepartmentSelect.selectedIndex = 0;
        subDepartmentSelect.setAttribute('disabled', 'disabled');
    }
});   
</script>
@endsection
</x-app-layout>