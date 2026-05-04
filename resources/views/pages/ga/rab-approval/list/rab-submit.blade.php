<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Submit RAB Request for Approval 📝</h1>
        </div>
        <form action="{{ route('rab-approvalga.submit', ['rabId' => $dataRab->idrec]) }}" method="post" enctype="multipart/form-data" id="rabSubmit">
                @csrf
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">RAB # / Form Date / Period</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->id_rab}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataRab->form_date))}}" readonly>
                        </div>
                        <div>
                            <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('F Y', strtotime($dataRab->date_rab))}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">RAB Title / RAB Type / Company</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->name_rab}}" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->rab_type}}" readonly>
                        </div>
                        <div>
                            <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->name}}" readonly/>
                            <input id="company" name="company"
                            class="company form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" 
                            value="{{$dataRab->id_company}}" readonly hidden/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3" id="benef" {{$dataRab->rab_type == 'Advance Payment To Site' ? '':'hidden'}}>
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Beneficiary Bank / Account / Name<span
                        class="text-rose-500">*</span></label>
                        <div>
                            <input style="width: 20.8rem; margin-right: 20px;" id="bank" name="bank" value="{{$dataRab->beneficiary_bank}}" class="bank form-input w-full px-2 py-1 read-only:bg-slate-200" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="number" name="number" class="number form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->beneficiary_acc}}" type="text" readonly/>
                        </div>
                        <div>
                            <input id="account" name="account" style="width: 21.2rem;" class="account form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->beneficiary_name}}" type="text" readonly/>
                        </div>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Department / Created By / Approval Status</label>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataRab->dept}}" type="text" readonly/>
                        </div>
                        <div style="width: 20.8rem; margin-right: 20px;">
                            <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->username}}" readonly>
                        </div>
                        <div>
                            <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataRab->approvalstat}}" readonly/>
                        </div>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">RAB Item 
                    </label>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Type</th>
                                <th class="text-sm text-center">Department</th>
                                <th class="text-sm text-center">Sub Department</th>
                                <th class="text-sm text-center">Inventory Asset</th>
                                <th class="text-sm text-center">Qty</th>
                                <th class="text-sm text-center">Unit</th>
                                <th class="text-sm text-center">Price</th>
                                <th class="text-sm text-center">Total</th>
                                <th class="text-sm text-center">Remarks</th>
                                <th hidden class="text-sm text-center">Balance</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mb-3 mt-3" hidden>
                    <label class="text-sm font-medium mb-1" for="totalAmount">Grand Total
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/3 px-2 py-1 read-only:bg-slate-200 text-right ml-6" type="text" 
                    value="{{number_format($dataRab->grandTotal, 0)}}" required readonly/>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" 
                    value="{{$dataRab->grandTotal}}" readonly required/>
                </div>

                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="request_to">Approval 1 Request to<span
                        class="text-rose-500">*</span>
                    </label>
                    <select id="approval_to" name="approval_to" class="approval_to form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Approval 1 to</option>
                        @foreach ($dataUser as $approvalTo)
                        <option value="{{$approvalTo->id}}">{{$approvalTo->username}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="request_to">Approval 2 Request to<span
                        class="text-rose-500">*</span>
                    </label>
                    <select id="approval2_to" name="approval2_to" class="approval2_to form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected hidden value="">Select Approval 2 to</option>
                        @foreach ($dataUser2 as $approval2To)
                        <option value="{{$approval2To->id}}">{{$approval2To->username}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- @if ($dataRab->id_company != '12')
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="request_to">Approval 3 Request to
                    </label>
                    <select id="approval3_to" name="approval3_to" class="approval3_to form-select w-full md:w-3/4 px-2 py-1">
                        <option selected hidden value="">Select Approval 3 to</option>
                        @foreach ($dataUser3 as $approval3To)
                        <option value="{{$approval3To->id}}">{{$approval3To->username}}</option>
                        @endforeach
                    </select>
                </div>
                @endif --}}

                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Attachment RAB File<span
                        class="text-rose-500">*</span>&nbsp;: </label>
                    <input id="file" name="file" class="file form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                    <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">File max size 12MB</div>
                </div>

                @if ($dataRab->approvalstat == "Printed")
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Submit RAB Request</span>
                    </button> </center>
                @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $('#approval_to').select2();
        $('#approval2_to').select2();
        $('#approval3_to').select2();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataRabItem?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {

            tableRow += `<tr id=row1-productIdx>
                            <td>${value.rab_calc_type}</td>
                            <td>${value.category === 'null' ? '' : (value.category || '')}</td>
                            <td>${value.sub_category === 'null' ? '' : (value.sub_category || '')}</td>
                            <td>${value.detail === 'null' ? '' : (value.detail || '')}</td>
                            <td class="text-right">${newDivider1(value.qty)}</td>
                            <td class="text-center">${value.unit}</td>
                            <td class="text-right">${newDivider1(value.amount)}</td>
                            <td class="text-right">${newDivider1(value.total)}</td>
                            <td>${value.remarks === 'null' ? '' : (value.remarks || '')}</td>
                                        </tr>`;
        }
        tableRow += `<tr>
                    <td class="text-center font-bold text-lg" colspan="7">Grand Total</td>
                    <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">{{number_format($dataRab->grandTotal, 0, '.', '.')}}</span></td>
                    <td></td>
                </tr>`;
        $(".tableProductAddBody").find('tbody').append(tableRow);
        
        $('#rabSubmit').submit(function (e, params) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            console.log(formData, $(this).attr('action'));
            $.ajax({
                url      : $(this).attr('action'),
                type     : 'POST',
                dataType : 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(_response){
                    if (_response.st == '1') {
                        Swal.fire({
                            title: 'Success',
                            text: 'RAB Request Has Been Submited, Waiting Approval 1',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                urlRedirect = '/ga/rab-approval/list/printsubmit';
                                window.open(urlRedirect, '_self');
                            }else {
                                urlRedirect = '/ga/rab-approval/list/printsubmit';
                                window.open(urlRedirect, '_self');
                            }
                        });
                        urlRedirect = '/ga/rab-approval/list/printsubmit';
                        window.open(urlRedirect, '_self');
                        // Swal.fire({
                        //     title: 'Success',
                        //     text: 'Reimburse #' + RRID + ' Has Been Created',
                        //     icon: 'success',
                        //     showCancelButton: false,
                        //     confirmButtonText: 'Ok',
                        //     cancelButtonText: 'No, cancel'
                        // }).then((result) => {
                        //     if (result.isConfirmed) {
                        //         Swal.close();
                        //     }else {
                        //         Swal.close();
                        //     }
                        // });
                    }else if (_response.st == '2') {
                        Swal.fire({
                            title: 'File to Large',
                            text: 'Please Compress File',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }else {
                                Swal.close();
                            }
                        });
                    }else if (_response.st == '3') {
                        Swal.fire({
                            title: 'Error',
                            text: 'RAB Already Submitted',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }else {
                                Swal.close();
                            }
                        });
                    }
                },
                    error: function(){
                    alert('Terjadi kesalahan');
                }
            });
        })
    </script>
    @endsection
</x-app-layout>