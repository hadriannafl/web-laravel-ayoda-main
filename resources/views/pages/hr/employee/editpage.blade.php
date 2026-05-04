<x-app-layout background="bg-white">
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
            
                    <!-- Page header -->
                    <div class="mb-8">
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit Employee 📝</h1>
                    </div>
            
                <div class="px-5 py-4">
                    <div class="space-y-3">
                        <form action="{{ route('employee.update', ['employeeId' => $employee->idemployee]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="flex justify-between flex-col md:flex-row">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="nik">NIK<span
                                    class="text-rose-500">*</span></label>
                                <input id="nik" name="nik"
                                    class="nik form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->nik}}" type="number" minlength="8" required/>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="first_name">First Name<span
                                    class="text-rose-500">*</span></label>
                                <input id="first_name" name="first_name"
                                    class="first_name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->first_name}}" type="text" required/>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="last_name">Last Name<span
                                    class="text-rose-500">*</span></label>
                                <input id="last_name" name="last_name"
                                    class="last_name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->last_name}}" type="text" required/>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="DoB">Day Of Birth<span
                                    class="text-rose-500">*</span></label>
                                </label>
                                <input id="DoB" name="DoB" value="{{$employee->DoB}}" class="DoB selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date" required/>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="place_of_birth">Place Of Birth<span
                                    class="text-rose-500">*</span></label>
                                <input id="place_of_birth" name="place_of_birth"
                                    class="place_of_birth form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->place_of_birth}}" type="text" required/>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="marital_status">Marital Status<span
                                    class="text-rose-500">*</span></label>
                                <input id="marital_status" name="marital_status"
                                    class="marital_status form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->marital_status}}" type="text" required/>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="gender">Gender<span
                                    class="text-rose-500">*</span></label>
                                <select id="gender" name="gender"
                                    class="gender form-select w-full md:w-3/4 px-2 py-1" required>
                                    <option value="" hidden>Select Gender...</option>
                                    <option value="F" {{$employee->gender == 'F' ? "selected":""}}>Female</option>
                                    <option value="M" {{$employee->gender == 'M' ? "selected":""}}>Male</option>
                                </select>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="religion">Religion<span
                                    class="text-rose-500">*</span></label>
                                <select id="religion" name="religion"
                                    class="religion form-select w-full md:w-3/4 px-2 py-1" required>
                                    <option value="" hidden>Select Religion...</option>
                                    <option value="BUDDHA" {{$employee->religion == 'BUDDHA' ? "selected":""}}>BUDDHA</option>
                                    <option value="HINDU" {{$employee->religion == 'HINDU' ? "selected":""}}>HINDU</option>
                                    <option value="ISLAM" {{$employee->religion == 'ISLAM' ? "selected":""}}>ISLAM</option>
                                    <option value="KATOLIK" {{$employee->religion == 'KATOLIK' ? "selected":""}}>KATOLIK</option>
                                    <option value="KHONGHUCU" {{$employee->religion == 'KHONGHUCU' ? "selected":""}}>KHONGHUCU</option>
                                    <option value="PROTESTAN" {{$employee->religion == 'PROTESTAN' ? "selected":""}}>PROTESTAN</option>
                                </select>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="address">Address<span
                                    class="text-rose-500">*</span></label>
                                <textarea id="address" name="address"
                                    class="address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3" required>{{$employee->address}}</textarea>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="city">City<span
                                    class="text-rose-500">*</span></label>
                                <input id="city" name="city"
                                    class="city form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->city}}" type="text" required/>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="province">Province<span
                                    class="text-rose-500">*</span></label>
                                <input id="province" name="province"
                                    class="province form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->province}}" type="text" required/>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="poh">Point Of Hire<span
                                    class="text-rose-500">*</span></label>
                                <input id="poh" name="poh"
                                    class="poh form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->poh}}" type="text" required/>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Company<span
                                    class="text-rose-500">*</span></label>
                                {{-- @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') --}}
                                    <select id="id_company" name="id_company"
                                        class="id_company form-select w-full md:w-3/4 px-2 py-1" required>
                                        <option value="" hidden>Select Company...</option>
                                        @foreach ($company as $item)
                                            <option value="{{$item->id_company}}" {{$employee->id_company == $item->id_company ? "selected":""}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                {{-- @else --}}
                                    {{-- <select id="companies" name="companies"
                                            class="companies form-select w-full md:w-3/4 px-2 py-1" disabled>
                                            <option value="" hidden>Select Company...</option>
                                            @foreach ($company as $item)
                                                <option value="{{$item->id_company}}" {{$item->id_company == $employee->id_company ? "selected":""}}>{{$item->name}}</option>
                                            @endforeach
                                    </select>
                                    <input type="text" name="id_company" class="id_company w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->id_company}}" hidden readonly/>
                                @endif --}}
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="employee_type">Employee Type<span
                                    class="text-rose-500">*</span></label>
                                <select id="employee_type" name="employee_type"
                                    class="employee_type form-select w-full md:w-3/4 px-2 py-1" required>
                                    <option value="" hidden>Select Type...</option>
                                    <option value="KHL" {{$employee->employee_type == 'KHL' ? "selected":""}}>KHL</option>
                                    <option value="KONTRAK" {{$employee->employee_type == 'KONTRAK' ? "selected":""}}>KONTRAK</option>
                                    <option value="PERMANEN" {{$employee->employee_type == 'PERMANEN' ? "selected":""}}>PERMANEN</option>
                                </select>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="joined_date">Joined Date<span
                                    class="text-rose-500">*</span></label>
                                <input id="joined_date" name="joined_date" value="{{$employee->joined_date}}" class="joined_date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date" required/>
                            </div>
                            <div class="flex flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="department">Department<span class="text-rose-500">*</span></label>
                                <input class="department form-input w-full md:w-1/2 px-2 py-1" id="department" name="department" value="{{$employee->department}}" type="text" required>
                            </div>
                            <div class="flex flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="title_structural">Title Structural<span class="text-rose-500">*</span></label>
                                <input class="title_structural form-input w-full md:w-1/2 px-2 py-1" id="title_structural" name="title_structural" value="{{$employee->title_structural}}" type="text" required>
                            </div>
                            <div class="flex flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="position">Position<span class="text-rose-500">*</span></label>
                                <input class="position form-input w-full md:w-1/2 px-2 py-1" id="position" name="position" value="{{$employee->position}}" type="text" required>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_num">NPWP Number</label>
                                <input id="npwp_num" name="npwp_num"
                                    class="npwp_num form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->npwp_num}}" type="text" minlength="8"/>
                            </div>
                            <div class="flex flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="npwp_name">NPWP Name</label>
                                <input class="npwp_name form-input w-full md:w-1/2 px-2 py-1" id="npwp_name" name="npwp_name" value="{{$employee->npwp_name}}" type="text">
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="bank_name">Bank Name</label>
                                    <select id="bank_name" name="bank_name"
                                        class="bank_name form-select w-full md:w-3/4 px-2 py-1">
                                        <option value="" hidden>Select Bank...</option>
                                        @foreach ($bank as $bank)
                                            <option value="{{$bank->name}}" {{$employee->bank_name == $bank->name ? "selected":""}}>{{$bank->name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div id="bank">
                                <div class="flex justify-between flex-col md:flex-row mt-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="bank_acc_num">Bank Account Number</label>
                                    <input id="bank_acc_num" name="bank_acc_num"
                                        class="bank_acc_num form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->bank_acc_num}}" type="text" minlength="8"/>
                                </div>
                                <div class="flex flex-col md:flex-row mt-3">
                                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="bank_acc_name">Bank Account Name</label>
                                    <input class="bank_acc_name form-input w-full md:w-1/2 px-2 py-1" id="bank_acc_name" name="bank_acc_name" value="{{$employee->bank_acc_name}}" type="text">
                                </div>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="phone">Phone<span
                                    class="text-rose-500">*</span></label>
                                <input id="phone" name="phone"
                                    class="phone form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->phone}}" type="text" minlength="8" required/>
                            </div>
                            <div class="flex justify-between flex-col md:flex-row mt-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="email">Email</label>
                                <input id="email" name="email"
                                    class="email form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" value="{{$employee->email}}" type="email"/>
                            </div>
            
                                <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                                    <span class="xs:block ml-5 mr-5">Save Updated Employee</span>
                                </button> </center>
                        </form>
                    </div>
                </div>
            
            </div>
            @section('js-page')
            <script>
                $('#bank_name').select2();
                // $('#bank_name').on('change', function (e) {
                //     const bankName = $(this).val();
            
                //     if (bankName == '') {
                //         $("#bank").attr("hidden", true);
                //         $("#bank_acc_num").attr("required", false);
                //         $("#bank_acc_name").attr("required", false);
                //     }else{
                //         $("#bank").attr("hidden", false);
                //         $("#bank_acc_num").attr("required", true);
                //         $("#bank_acc_name").attr("required", true);
                //     }
                // })   
                document.getElementById('department').addEventListener('change', function () {
                var selectedDepartment = this.value;
                var subDepartmentSelect = document.getElementById('sub_department');
            
                // Mengaktifkan atau menonaktifkan form select Sub Department berdasarkan pilihan Department
                if (selectedDepartment !== '') {
                    subDepartmentSelect.removeAttribute('disabled');
                    // Menghapus opsi yang ada dalam select Sub Department
                    while (subDepartmentSelect.options.length > 1) {
                        subDepartmentSelect.remove(1);
                    }
                } else {
                    // Menonaktifkan dan mengembalikan opsi yang asli jika Department tidak dipilih
                    subDepartmentSelect.selectedIndex = 0;
                    subDepartmentSelect.setAttribute('disabled', 'disabled');
                }
            });   
            </script>
            {{-- // Menambahkan opsi yang sesuai dengan Department yang dipilih
            @foreach ($subDepartment as $divisi)
                 var departmentName = "{{ $divisi->dept_name }}";
                 if (departmentName === selectedDepartment) {
                     var option = document.createElement('option');
                     var displayName = "{{ $divisi->name }}";
                     displayName = displayName.replace(/&amp;/g, '&'); // Mengganti &amp; kembali menjadi &
                     option.value = displayName;
                     option.text = displayName;
                     subDepartmentSelect.appendChild(option);
                 }
             @endforeach --}}
            @endsection
            </x-app-layout>