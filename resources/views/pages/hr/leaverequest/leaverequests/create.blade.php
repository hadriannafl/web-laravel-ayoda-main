<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Form Leave Request 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('leaverequests.create') }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Leave Date :</label>
                    <input id="date" name="date"
                        class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        Value="{{date('Y-m-d')}}" readonly required />
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id">Employee Name : </label>
                    <input id="name" name="name"
                        class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->username}}" readonly/>
                    <input id="id" name="id"
                        class="id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->employee_id}}" readonly hidden/>
                </div>
                <div class="flex flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="periode">From Date : </label>
                    <input type="date" id="from" name="from" class="from text" required></input>
                    <span class="mx-5 mt-2 text-black-500">to</span>
                    <input type="date" id="to" name="to" class="to text" required></input>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Leave Type :
                    </label>
                    <select id="type" name="type" class="type form-select w-full md:w-3/4 px-2 py-1" required>
                        <option selected disabled hidden>Select Here</option>
                        <option value="Sick Leave">Sick Leave</option>
                        <option value="Maternity Leave">Maternity Leave</option>
                        <option value="Paternity Leave">Paternity Leave</option>
                        <option value="Bereavement Leave">Bereavement Leave</option>
                        <option value="Religious Leave">Religious Leave</option>
                        <option value="Compensatory Leave">Compensatory Leave</option>
                        <option value="Unpaid Leave">Unpaid Leave</option>
                    </select>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="description">Notes : </label>
                    <textarea id="description" name="description" class="description form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        rows="3" required></textarea>
                </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                            <label class="block text-sm font-medium mb-1" for="file">Upload Document :</label>
                            <input name="photo1" id="photo1" class="photo1 form-input w-full md:w-3/4 px-2 py-1 bg-gray-50 dark:text-gray-400" type="file" onchange="loadFileMultiple(event, 'output1')" 
                            accept="image/jpeg,image/png,image/jpg,application/pdf"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row ml-72 mt-3">
                        <img id="output1" style="max-width: 300px; max-height: 150px"/>
                    </div>  

                    <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create Request</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>
     $('#from').on('change', function () {
            const sdate = $(this).val();
            const edate = document.getElementById('to').value;
            
            // alert(edate);

            if (edate < sdate && edate != '') {
                alert('End date cannot be before start date!');
                document.getElementById('create_offer').disabled = true;
            } else {
                document.getElementById('create_offer').disabled = false;
            }
        });
    
        $('#to').on('change', function () {
            const edate = $(this).val();
            const sdate = document.getElementById('from').value;
                
            if (edate < sdate && sdate != '') {
                alert('End date cannot be before Start date!');
                document.getElementById('create_offer').disabled = true;
            } else {
                document.getElementById('create_offer').disabled = false;
            }
        });
</script>
@endsection
</x-app-layout>