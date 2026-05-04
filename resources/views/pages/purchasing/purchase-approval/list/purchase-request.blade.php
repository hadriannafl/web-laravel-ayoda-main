<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Purchase Request List 💳
                </h1>
            </div>
        </div>

        <div class="flex flex-row mb-3">
            <div class="rounded-full columns-1 h-5 w-5" style="background-color: grey"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">Draft</p>
            <div class="rounded-full bg-sky-500 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">Price Updated/PR Printed/Waiting Quotation</p>
            <div class="rounded-full bg-yellow-200 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">Quotation Submitted/Waiting Approval 1/HQ 1 Approved/HQ 2 Approved</p>
            <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">HQ 3 Approved</p>
            <div class="rounded-full bg-red-500 md:break-after-column h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1 text-sm font-medium">HQ 1 Denied/HQ 2 Denied/HQ 3 Denied/Canceled</p>
        </div>
         <!-- Table -->
        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                    <a href="{{ route('purchase-requestga') }}" class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>&nbsp; New Purchase Request</a> 
            </label>

            <label class="flex flex-row text-xs ml-5">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status">Request Status :</p>
                <select id="status" class="status flex flex-row ml-3 mb-3 text-xs" name="status">
                    <option value="">All</option>
                    <option value="Canceled">Canceled</option>
                    <option value="Draft">Draft</option>
                    <option value="HQ 1 Approved">HQ 1 Approved</option>
                    <option value="HQ 2 Approved">HQ 2 Approved</option>
                    <option value="HQ 3 Approved">HQ 3 Approved</option>
                    <option value="HQ 1 Denied">HQ 1 Denied</option>
                    <option value="HQ 2 Denied">HQ 2 Denied</option>
                    <option value="HQ 3 Denied">HQ 3 Denied</option>
                    <option value="Price Updated">Price Updated</option>
                    <option value="Printed">PR Printed</option>
                    <option value="Quotation Submitted">Quotation Submitted</option>
                    <option value="Waiting Approval 1">Waiting Approval 1</option>
                    <option value="Waiting Quotation">Waiting Quotation</option>
                </select>
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="company">Company :</p>
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company">
                        <option value="" selected>All</option>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="department">Department :</p>
                    <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                        <option value="" selected>All</option>
                        @foreach ($department as $dept)
                            <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                {{-- @else
                <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company" hidden>
                    <option value="" selected>All</option>
                    @foreach ($dataChildCompany as $company)
                        <option value="{{ $company->id_company }}" {{Auth::user()->company_id == $company->id_company ? 'selected':''}}>{{ $company->name }}</option>
                    @endforeach
                </select> --}}
                @endif
        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table id="approval" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">PR Date</th>
                        <th class="text-center">Delivery Date</th>
                        <th class="text-center">Purchase Request #</th>
                        <th class="text-center">PR Title</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Request Level</th>
                        <th class="text-center">Applicant</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Approved Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>

    @section('js-page')
    <script>
         $(document).ready(function () {
            $('#approval').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "desc" ]],
                language: {
                    search: "Search Purchase Request # : "
                },
                ajax: {
                    url: "{{ route('purchase-list.getdata') }}",
                    data:function(d){
                        d.status = $("#status").val()
                        d.company = $("#company").val()
                        d.department = $("#department").val()
                    }
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "pr_date",
                        name: "pr_date"
                    },
                    {
                        data: "delivery_date",
                        name: "delivery_date"
                    },
                    {
                        data: "idreqform",
                        name: "idreqform"
                    },
                    {
                        data: "pr_title",
                        name: "pr_title"
                    },
                    {
                        data: "companyName",
                        name: "companyName"
                    },
                    {
                        data: "departmentName",
                        name: "departmentName"
                    },
                    {
                        data: "reqlevel",
                        name: "reqlevel"
                    },
                    {
                        data: "applicant",
                        name: "applicant"
                    },
                    {
                        data: "approvalstat",
                        name: "approvalstat"
                    },
                    {
                        data: "approvaldate",
                        name: "approvaldate"
                    },
                    {
                        data: "action1",
                        name: "action1"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 7, 10, 11] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $(".status").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })
            $(".company").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })
            $(".department").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })

            $('#approval').on("click", ".btn-cancel",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Cancel Purchase Request!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel Request!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: `/ga/purchase-approval/cancel/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        icon : 'success',
                                        title: 'Success!',
                                        text: `Purchase Request has been Canceled.`,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                    window.location.reload(true);
                                }
                            },
                            error: function (data) {
                                console.info("error: ", data)
                            }
                        })

                    }
                })
            });

            // $('#approval').on("click", ".btn-modal", function () {
            //     const idpr = $(this).data('idpr');
            //     const datepr = $(this).data("datepr");
            //     const applicant = $(this).data("applicant");
            //     const loc = $(this).data("loc");
            //     const reqlevel = $(this).data("reqlevel");
            //     const note = $(this).data("note");
            //     const daterequired = $(this).data("daterequired");
            //     const approvaldate = $(this).data("approvaldate");
            //     const approvalstat = $(this).data("approvalstat");
            //     const approved1by = $(this).data("approved1by");
            //     const approved2by = $(this).data("approved2by");
            //     const approval1_status = $(this).data("approval1_status");
            //     const approval2_status = $(this).data("approval2_status");
            //     const remarks1 = $(this).data("remarks1");
            //     const remarks2 = $(this).data("remarks2");
            //     const gtotal = $(this).data("gtotal");
            //     const currency = $(this).data("currency");

            //     $.ajax({
            //         type: "GET",
            //         url: `/ga/purchase-approval/getProduct/${idpr}`,
            //         success: function (response) {
            //             $(".modal-content").html(`
            //             <div class="px-5">
            //                     <div class="text-sm">
            //                         <div class="font-medium text-slate-800 mb-3"></div>
            //                     </div>
            //                     <div class="grid md:grid-cols-3 gap-3">
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1"
            //                                 for="id">Purchase Request #</label>
            //                             <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${idpr}" disabled readonly/>
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="status">Approval Status</label>
            //                             <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${approvalstat}" disabled readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1"
            //                                 for="date">Request Date</label>
            //                             <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${datepr}" disabled readonly/>
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="approve1_stat">Applicant</label>
            //                             <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${applicant}" disabled readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="approve1_stat">Location</label>
            //                             <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${loc}" disabled readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="approve1_stat">Request Level</label>
            //                             <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${reqlevel}" disabled readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="approve1_stat">Required Date</label>
            //                             <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${daterequired}" disabled readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="currency">Approval 1 By</label>
            //                             <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${approved1by}" disabled
            //                                 readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="currency">Approval 2 By</label>
            //                             <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${approved2by}" disabled
            //                                 readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="approve1_stat">Approved Date</label>
            //                             <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${approvaldate}" disabled readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval Status 1</label>
            //                             <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${approval1_status}" disabled readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval Status 2</label>
            //                             <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${approval2_status}" disabled readonly />
            //                         </div>
            //                     </div>
            //                         <div class="mt-3">
            //                             <label class="block text-sm font-medium mb-1 text-left" for="notes">Notes</label>
            //                             <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
            //                             type="text" disabled readonly>${note}</textarea>
            //                         </div>
            //                         <div class="mt-3">
            //                             <label class="block text-sm font-medium mb-1 text-left" for="notes">Inventory Request :</label>
            //                         </div>
            //                         <table class="table table-striped table-bordered mt-2 mb-2 tableProductAddBody" style="width:100%">
            //                             <thead>
            //                                 <tr>
            //                                     <th class="text-sm text-center">Item Name</th>
            //                                     <th class="text-sm text-center">Unit</th>
            //                                     <th class="text-sm text-center">Quantity</th>
            //                                     <th class="text-sm text-center">Price</th>
            //                                     <th class="text-sm text-center">Total</th>
            //                                     <th class="text-sm text-center">Category</th>
            //                                     <th class="text-sm text-center">Action</th>
            //                                 </tr>
            //                             </thead>
            //                             <tbody>

            //                             </tbody>
            //                         </table>
            //                         <div class="grid md:grid-cols-3 gap-3">
            //                             <div>
            //                                 <label class="block text-sm font-medium mb-1" for="gtotal">Grand Total</label>
            //                                 <input id="gtotal" class="gtotal form-input w-full px-2 py-1 bg-slate-100"
            //                                     type="text" value="${currency} ${divider(gtotal)}" disabled readonly />
            //                             </div>
            //                         </div>
            //                     <div class="mt-3">
            //                         <label class="block text-sm font-medium mb-1 text-left" for="notes">Remarks 1</label>
            //                         <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
            //                         type="text" disabled readonly>${remarks1}</textarea>
            //                     </div>
            //                     <div class="mt-3">
            //                         <label class="block text-sm font-medium mb-1 text-left" for="notes">Remarks 2</label>
            //                         <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
            //                         type="text" disabled readonly>${remarks2}</textarea>
            //                     </div>
            //                 </div>
            //             `); 
            //             let tableRow = '';
            //                 for (const value of response) {
            //                     tableRow += `<tr>
            //                                     <td>${value.name}</td>
            //                                     <td class="text-center">${value.unit}</td>
            //                                     <td class="text-center">${divider(value.qty)}</td>
            //                                     <td class="text-center">${divider(value.price)}</td>
            //                                     <td class="text-center">${divider(value.total)}</td>
            //                                     <td class="text-center">${value.category}</td>
            //                                     <td class="text-center flex flex-row justify-center">
            //             <a href="/ga/office-inventory/file/${value.idassets}" target="_blank" class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white
            //             ${value.pdf == 1 ? 'hidden' : ''}">
            //                 View File
            //             </a>

            //             <a href="/ga/office-inventory/photo/${value.idassets}" target="_blank" class="btn btn-sm bg-sky-500 hover:bg-sky-600 text-white ml-3 
            //             ${value.image == 1 ? 'hidden' : ''}">
            //             View Image
            //             </a>

            //         </td>
            //                                 </tr>`;
            //                 }
            //             $(".tableProductAddBody").find('tbody').append(tableRow);
            //         },
            //     });
            // });
        });
    </script>
    @endsection
</x-app-layout>