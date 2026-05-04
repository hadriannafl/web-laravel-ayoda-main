<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    RAB Post Approval Edit 💳
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="approval" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Periode</th>
                        <th class="text-center">RAB #</th>
                        <th class="text-center">RAB Name</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Grand Total</th>
                        <th class="text-center">Approval 1 Status</th>
                        <th class="text-center">Approval 2 Status</th>
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
                "order": [[ 0, "desc" ]],
                language: {
                    search: "Search RAB # : "
                },
                ajax: {
                    url: "{{ route('rab-list-edit.getdata') }}",
                    data:function(d){
                        d.status = $("#status").val()
                    }
                },
                columns: [
                    {
                        data: "date_rab",
                        name: "date_rab"
                    },
                    {
                        data: "id_rab",
                        name: "id_rab"
                    },
                    {
                        data: "name_rab",
                        name: "name_rab"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "gtotal",
                        name: "gtotal"
                    },
                    {
                        data: "approval1stat",
                        name: "approval1stat"
                    },
                    {
                        data: "approval2stat",
                        name: "approval2stat"
                    },
                    {
                        data: "approvaldate",
                        name: "approvaldate"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 5, 6, 7] },
                    { className: 'text-right', targets: [4] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $(".status").on('change', function (e) {
                e.preventDefault();
                $('#approval').DataTable().ajax.reload();
            })

            $('#approval').on("click", ".btn-submit",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Submit RAB Request!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Submit Request!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: `/ga/rab-approval/submit/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        icon : 'success',
                                        title: 'Success!',
                                        text: `RAB Request has been Submited.`,
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

            $('#approval').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const name_rab = $(this).data("name_rab");
                const rab_date = $(this).data("rab_date");
                const approvaldate = $(this).data("approvaldate");
                const approvalstat = $(this).data("approvalstat");
                const approved1by = $(this).data("approved1by");
                const approved2by = $(this).data("approved2by");
                const approval1stat = $(this).data("approval1stat");
                const approval2stat = $(this).data("approval2stat");
                const remarks1 = $(this).data("remarks1");
                const remarks2 = $(this).data("remarks2");
                const gtotal = $(this).data("gtotal");

                $.ajax({
                    type: "GET",
                    url: `/ga/rab-approval/getItem/${id}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Purchase Request #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${id}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="rabName">RAB Name</label>
                                        <input id="rabName" class="rabName form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${name_rab}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Approval Status</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approvalstat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Request Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${rab_date}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Approval 1 By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approved1by}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Approval 2 By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approved2by}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval Status 1</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approval1stat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval Status 2</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approval2stat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approved Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approvaldate}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">RAB Item Request :</label>
                                    </div>
                                    <table class="table table-striped table-bordered mt-2 mb-2 tableProductAddBody" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Department</th>
                                                <th class="text-sm text-center">Sub Department</th>
                                                <th class="text-sm text-center">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div class="grid md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="gtotal">Grand Total</label>
                                            <input id="gtotal" class="gtotal form-input w-full px-2 py-1 bg-slate-100"
                                                type="text" value="${newDivider(gtotal)}" disabled readonly />
                                        </div>
                                    </div>
                                <div class="mt-3">
                                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Remarks 1</label>
                                    <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                    type="text" disabled readonly>${remarks1}</textarea>
                                </div>
                                <div class="mt-3">
                                    <label class="block text-sm font-medium mb-1 text-left" for="notes">Remarks 2</label>
                                    <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                    type="text" disabled readonly>${remarks2}</textarea>
                                </div>
                            </div>
                        `); 
                        let tableRow = '';
                            for (const value of response) {
                                tableRow += `<tr>
                                                <td>${value.department}</td>
                                                <td>${value.sub_department}</td>
                                                <td class="text-right">${newDivider(value.amount)}</td>
                                            </tr>`;
                            }
                        $(".tableProductAddBody").find('tbody').append(tableRow);
                    },
                });
            });
        });
    </script>
    @endsection
</x-app-layout>