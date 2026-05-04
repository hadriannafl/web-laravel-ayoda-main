<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Add Signature By 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" id="myForm" enctype="multipart/form-data" action="{{ route('rab-list.signatureupdate', ['rabId' => $dataRab->idrec]) }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="prepared">Prepared By<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1 ml-4">:</label>
                    <input id="prepared" name="prepared" value="{{$dataRab->prepared_by}}"
                        class="prepared form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="view">Reviewed 1 By<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1 ml-1">:</label>
                    <input id="view" name="view" value="{{$dataRab->reviewed_by}}"
                        class="view form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="view2">Reviewed 2 By<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1">:</label>
                    <input id="view2" name="view2" value="{{$dataRab->reviewed2_by}}"
                        class="view2 form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="approved">Approved By<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1 ml-3">:</label>
                    <input id="approved" name="approved" value="{{$dataRab->approved_by}}"
                        class="approved form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>

                @if ($dataRab->approvalstat == 'Draft' || $dataRab->approvalstat == 'Printed')                    
                <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Print File RAB</span>
                </button> </center>
                @endif
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
$('#myForm').submit(function (e, params) {
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
                    if(_response.st == '1'){
                        var idRec = _response.id;
                        urlRedirect = '/ga/rab-approval/list/print/'+idRec;
                        window.open(urlRedirect, '_blank');
                        window.location.href = '/ga/rab-approval/list/printsubmit';
                    } else if(_response.st == '0'){
                        alert('Terjadi kesalahan');
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