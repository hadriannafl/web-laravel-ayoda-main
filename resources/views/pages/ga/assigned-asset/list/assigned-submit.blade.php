<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            @if ($dataAssigned->type_assign == 'Assign')
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Submit Assigned Fixed Asset 📝</h1>
            @else
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Submit Return Fixed Asset 📝</h1>
            @endif
        </div>
        <form action="{{ route('assigned-asset.submit', ['idassign' => $dataAssigned->idrec]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between flex-col md:flex-row mb-3">
                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Form Date</label>
                <input id="date" name="date"
                class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                Value="{{date('d F Y', strtotime($dataAssigned->borrow_date))}}" required readonly/>
            </div>
            <div class="flex justify-between flex-col md:flex-row mt-3">
                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                    for="type">Type Assigned
                </label>
                <input id="type" name="type" class="type form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" 
                value="{{$dataAssigned->type_assign}}" readonly/>
            </div>
            <div class="flex justify-between flex-col md:flex-row mt-3">
                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                    for="company">Company
                </label>
                    <input id="company" name="company"
                    class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    value="{{$dataAssigned->company}}" readonly/>
                    <input id="company1" name="company1"
                    class="company1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    value="{{$dataAssigned->id_company}}" hidden readonly/>
            </div>
            <div class="flex flex-col md:flex-row mt-3">
                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="employee1">Employee
                </label>
                <input class="employee form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" id="employee" name="employee" value="{{$dataAssigned->name}}" readonly>
            </div>
                {{-- <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="approved2by">Approval 2 By</label>
                    <input id="approved2by" name="approved2by" value="{{$dataAssigned->approved2by}}"
                        class="approved2by form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div> --}}
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="approved2by">Last Updated At</label>
                    <input id="approved2by" name="approved2by" Value="{{date('d F Y', strtotime($dataAssigned->updated_at))}}"
                        class="approved2by form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                @if ($dataAssigned->file_condition != null)
                <div class="flex md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks1">Attachment Asset Condition</label>
                    <a href="{{ route('assigned-asset.viewcondition', ['idassign' => $dataAssigned->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Asset Condition</a>
                </div>
                @endif
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">List Fixed Asset
                    </label>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Fixed Asset Code</th>
                                <th class="text-sm text-center">Asset Name</th>
                                <th class="text-sm text-center">Company</th>
                                <th class="text-sm text-center">Warehouse Address</th>
                                <th class="text-sm text-center">Remarks</th> 
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">
    
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between flex-col md:flex-row mt-3">
                    @if ($dataAssigned->type_assign == 'Assign')
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Attachment Received Asset<span
                        class="text-rose-500">*</span></label>
                    @else
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Attachment Return Asset<span
                        class="text-rose-500">*</span></label>
                    @endif
                    <input id="file" name="file" class="file form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf" required/>
                </div>
                {{-- @if ($dataAssigned->approvalstat == 'Printed') --}}
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    @if ($dataAssigned->type_assign == 'Assign')
                    <span class="xs:block ml-5 mr-5">Submit Received</span>
                    @else
                    <span class="xs:block ml-5 mr-5">Submit Return</span>
                    @endif
                </button> </center>
                {{-- @endif --}}
            </form>
    </div>

    @section('js-page')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataAssignedDetail?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {
            var iden = makeid(3);

            tableRow += `<tr id=row-${iden}>
                            <td class="text-center">${value.idfa}<input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="ids_${iden}" value="${value.idfa}" hidden/></td>
                            <td>${value.assetName}</td>
                            <td>${value.company}</td>
                            <td>${value.w_address}</td>
                            <td>${value.remarks === 'null' ? '' : (value.remarks || '')}</td>           
                </td>
                                        </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);

        function makeid(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
        
    </script>
    @endsection
</x-app-layout>