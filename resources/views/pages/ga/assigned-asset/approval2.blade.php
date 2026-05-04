<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Assigned Request Approval 2 📝</h1>
        </div>
        @if ($dataAssigned->file != null)
            <div class="px-5 py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('assigned-asset.viewfile', ['idassign' => $dataAssigned->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Received</a>
                </div>
            </div>
        @endif
        <form action="{{ route('assigned-approvalga.updatestatus2', ['idassign' => $dataAssigned->idrec]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between flex-col md:flex-row mb-3">
                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Form Date :<span
                    class="text-rose-500">*</span></label>
                <input id="date" name="date"
                class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                Value="{{date('d F Y', strtotime($dataAssigned->borrow_date))}}" required readonly/>
            </div>
            <div class="flex justify-between flex-col md:flex-row mt-3">
                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                    for="type">Type Assigned<span
                    class="text-rose-500">*</span>
                </label>
                <input id="type" name="type" class="type form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" 
                value="{{$dataAssigned->type_assign}}" readonly/>
            </div>
            <div class="flex justify-between flex-col md:flex-row mt-3">
                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                    for="company">Company<span
                    class="text-rose-500">*</span>
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
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="approvalstat">Approval Status</label>
                    <input id="approvalstat" name="approvalstat" value="{{$dataAssigned->approvalstat}}"
                        class="approvalstat form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="approved1by">Approval 1 By</label>
                    <input id="approved1by" name="approved1by" value="{{$dataAssigned->approved1by}}"
                        class="approved1by form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="approved2by">Last Updated At</label>
                    <input id="approved2by" name="approved2by" Value="{{date('d F Y', strtotime($dataAssigned->updated_at))}}"
                        class="approved2by form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks1">Assigned Remarks</label>
                    <textarea id="remarks1" name="remarks1" rows="3" class="remarks1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" readonly>{{$dataAssigned->assign_remark}}</textarea>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">List Fixed Asset<span
                    class="text-rose-500">*</span>
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
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="remarks">Assigned Remarks</label>
                    <textarea id="remarks" name="remarks"
                        class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required rows="3"></textarea>
                </div>
                <center>
                        <input type="submit" value="Approved" name="status" class="w-80 text-lg bg-green-500 hover:bg-green-600 text-white mt-3" />
                        <input type="submit" value="Denied" name="status" class="w-80 text-lg bg-red-400 border-slate-200 hover:bg-red-500 text-white mt-3" />
                </center>
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

            tableRow += `<tr id=row>
                            <td class="text-center">${value.idfa}</td>
                            <td>${value.assetName}</td>
                            <td>${value.company}</td>
                            <td>${value.w_address}</td>
                            <td>${value.remarks}</span></td>           
                </td>
                                        </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);
        
    </script>
    @endsection
</x-app-layout>