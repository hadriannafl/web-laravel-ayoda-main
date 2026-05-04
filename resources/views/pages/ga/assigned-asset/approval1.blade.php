<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Assigned Request Approval 📝</h1>
        </div>
        @if ($dataAssigned->file != null)
            <div class="px-5 py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('assigned-asset.viewfile', ['idassign' => $dataAssigned->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Received</a>
                </div>
            </div>
        @endif
        <form action="{{ route('assigned-approvalga.updatestatus', ['idassign' => $dataAssigned->idrec]) }}" method="post" enctype="multipart/form-data">
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
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="approvalstat">Approval Status</label>
                    <input id="approvalstat" name="approvalstat" value="{{$dataAssigned->approvalstat}}"
                        class="approvalstat form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required readonly/>
                </div>
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
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Attachment Asset Condition</label>
                    <input id="file" name="file" class="file form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf/image/jpg"/>
                </div>
                @if ($dataAssigned->type_assign == 'Assign')
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="assigned_remark">Assigned Remarks</label>
                    <textarea id="assigned_remark" name="assigned_remark" rows="3" class="assigned_remark form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200">{{$dataAssigned->assign_remark}}</textarea>
                </div>
                @endif
                @if ($dataAssigned->type_assign == 'Return')
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="return_remark">Return Remarks</label>
                    <textarea id="return_remark" name="return_remark" rows="3" class="return_remark form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200">{{$dataAssigned->return_remark}}</textarea>
                </div>
                @endif
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