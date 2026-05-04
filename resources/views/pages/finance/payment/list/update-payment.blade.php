<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Edit Payment 💳
                </h1>
            </div>
        </div>

        <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-sm text-slate-800 mb-3 mt-2" for="lastentry">FROM :</p>
                <input id="min" class="text-sm flex flex-row ml-3 mb-3" type="date"/>
                <p class="flex flex-row text-sm text-slate-800 mb-3 ml-5 mt-2" for="lastentry">TO :</p>
                <input id="max" class="text-sm flex flex-row ml-3 mb-3" type="date"/>
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="company">Company :</p>
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company">
                        <option value="" selected>All</option>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                @else
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company" hidden>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}" {{ Auth::user()->company_id == $company->id_company ? ' selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                @endif
                <button id="btn-search" class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-5 mb-3" type="button">
                    <span class="xs:block">Search</span>
                </button>
                {{-- <input type="text" id="balance" name="balance" class="balance bg-slate-200 form-input flex flex-row ml-3 mb-3 text-xs" value="0" readonly hidden/> --}}
            </label>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="payment" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Form Date</th>
                        <th class="text-center">Payment Date</th>
                        <th class="text-center">Reff #</th>
                        <th class="text-center">Payment Voucher #</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Paid By</th>
                        <th class="text-center">Amount Paid</th>
                        <th class="text-center">Balance A/P</th>
                        <th class="text-center">Balance WHT</th>
                        <th class="text-center">Applicant</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        // Get today's date
        const today = new Date();

        // Function to format date to YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Calculate date 30 days ago
        const minDate = new Date(today);
        minDate.setDate(minDate.getDate() - 30);

        // Calculate date 3 days from now
        const maxDate = new Date(today);
        maxDate.setDate(maxDate.getDate() + 3);

        // Set the initial values for the input fields
        document.getElementById('min').value = formatDate(minDate);
        document.getElementById('max').value = formatDate(maxDate);

        // Calculate the max allowed date which is 3 months after min date
        const maxAllowedDate = new Date(minDate);
        maxAllowedDate.setMonth(maxAllowedDate.getMonth() + 3);

        const btnSearch = document.getElementById('btn-search');

        // Function to validate dates and toggle button state
        function validateDates() {
            const minInputDate = new Date(document.getElementById('min').value);
            const maxInputDate = new Date(document.getElementById('max').value);
            const newMaxAllowedDate = new Date(minInputDate);
            newMaxAllowedDate.setMonth(newMaxAllowedDate.getMonth() + 3);

            if (maxInputDate > newMaxAllowedDate || minInputDate > maxInputDate) {
                alert(`The "TO" date must be within 3 months of the "FROM" date, and cannot be earlier than the "FROM" date.`);
                btnSearch.disabled = true;
            } else {
                btnSearch.disabled = false;
            }
        }

        // Add event listeners to the input fields
        document.getElementById('min').addEventListener('change', function () {
            const minInputDate = new Date(this.value);
            const maxInputDate = new Date(document.getElementById('max').value);

            if (maxInputDate > maxAllowedDate || minInputDate > maxInputDate || minInputDate < maxInputDate) {
                validateDates();
            } else {
                btnSearch.disabled = false;
            }
        });

        document.getElementById('max').addEventListener('change', function () {
            validateDates();
        });

        // Initial validation
        validateDates();
         $(document).ready(function () {
            $('#payment').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search: "
                },
                ajax: {
                    url: "{{ route('payment-list.getdetail2') }}",
                    data:function(d){
                        d.from = $("#min").val()
                        d.to = $("#max").val()
                        d.company = $("#company").val()
                        d.status = $("#status").val()
                    }
                },
                columns: [
                    {
                        data: "date",
                        name: "date"
                    },
                    {
                        data: "payment_date",
                        name: "payment_date"
                    },
                    {
                        data: "id_costpayment",
                        name: "id_costpayment"
                    },
                    {
                        data: "id_payment",
                        name: "id_payment"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "companyCharge",
                        name: "companyCharge"
                    },
                    {
                        data: "amount_paid",
                        name: "amount_paid"
                    },
                    {
                        data: "balance",
                        name: "balance"
                    },
                    {
                        data: "balance_wht",
                        name: "balance_wht"
                    },
                    {
                        data: "created_by",
                        name: "created_by"
                    },
                    {
                        data: "aktif",
                        name: "aktif"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1] },
                    { className: 'text-right', targets: [6, 7, 8] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $("#btn-search").on("click", function () {
                $('#payment').DataTable().ajax.reload();
            });
        });
    </script>
    @endsection
</x-app-layout>