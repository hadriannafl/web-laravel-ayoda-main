<x-app-layout>
           
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        {!! Auth::user()->g_cal !!}
    </div>
    

    @section('js-page')
    <script>
        
    </script>
    @endsection
</x-app-layout>