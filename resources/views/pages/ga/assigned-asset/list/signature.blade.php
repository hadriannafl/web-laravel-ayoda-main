<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Add Signature By 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" id="myForm" enctype="multipart/form-data" action="{{ route('assigned-asset.signatureupdate', ['idassign' => $dataAssigned->idrec]) }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="prepared">Prepared By<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1 ml-4">:</label>
                    <input id="prepared" name="prepared"
                        class="prepared form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="received">Received By<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1 ml-3">:</label>
                    <input id="received" name="received"
                        class="received form-input w-full md:w-3/4 px-2 py-1" type="text" required/>
                </div>

                @if ($dataAssigned->approvalstat == 'Approved')                    
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    @if ($dataAssigned->type_assign == 'Assign')
                    <span class="xs:block ml-5 mr-5">Print File Received</span>                        
                    @else
                    <span class="xs:block ml-5 mr-5">Print File Return</span>
                    @endif
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
                        urlRedirect = '/ga/assigned-asset/list/print/'+idRec;
                        window.open(urlRedirect, '_self');
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