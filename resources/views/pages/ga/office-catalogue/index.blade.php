<x-app-layout>
    <style>
        .clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
    </style>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-5">

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Office Inventory Catalogue ✨</h1>

        </div>

        <!-- Page content -->
        <div class="flex flex-col space-y-10 sm:flex-row sm:space-x-6 sm:space-y-0 md:flex-col md:space-x-0 md:space-y-10 xl:flex-row xl:space-x-6 xl:space-y-0 mt-9">

            <!-- Sidebar -->
            <div>
                <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-5 min-w-60">
                    <div class="grid md:grid-cols-2 xl:grid-cols-1 gap-6">
                        <!-- Group 1 -->
                        <div>
                            <div class="text-sm text-slate-800 font-semibold mb-3">Category</div>
                            <ul class="text-sm font-medium space-y-2">
                                <li>
                                    <a class="text-slate-600 hover:text-slate-700 @if(Route::is('office-catalogue')){{ '!text-indigo-500' }}@endif" href="{{ route('office-catalogue') }}">View All</a>
                                </li>
                                @foreach ($dataCategory as $category)
                                    <li>
                                        <a class="text-slate-600 hover:text-slate-700" href="{{ route('office-catalogue.category', ['category' => $category->name]) }}">{{$category->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div> 
                    </div>
                </div>
            </div>
            {{-- <x-ecommerce.shop-sidebar /> --}}

            <!-- Content -->
            <div>

                <!-- Filters -->
                <div class="mb-1">
                    <ul class="flex justify-end">
                        <form class="flex flex-row mb-3" id="form-search" action="" method="GET">
                            <label class="block text-sm font-semibold mt-2 mr-3">Search Asset Code :</label>
                            <div>
                                <input id="search" name="search" class="search form-input w-full mr-2" type="text" placeholder="Search..." maxlength="8" value="{{request('search')}}">
                            </div>
                            <button class="item-center btn-lg bg-indigo-500 hover:bg-indigo-600 text-white ml-2" type="submit" aria-label="Search">
                                <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path class="fill-current text-slate-200"
                                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                    <path class="fill-current text-slate-200"
                                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                                </svg>
                            </button>
                        </form>
                    </ul>
                </div>

                <div class="text-sm text-slate-500 italic mb-4">{{ $totalItemsAfterSearch }} Items</div>

                <!-- Cards 1 (Video Courses) -->
                <div>
                    <div class="grid grid-cols-12 gap-6 mb-2">
                        @if ($dataAsset->count())
                        @foreach ($dataAsset as $asset)
                        <!-- Card 1 -->
                        <div class="col-span-full md:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200 overflow-hidden">
                            <div class="flex flex-col h-full">
                                <!-- Image -->
                                <div class="relative">
                                    @if ($asset->img_name != null)
                                    <img class="w-full" src="http://ayoda.integrated-os.cloud/{{$asset->img_name}}" width="301" height="226" alt="InvOffice" /> 
                                    @else
                                    <img class="w-full" src="{{ asset('images/No_Image.jpg') }}" width="301" height="226" alt="InvOffice" />
                                    @endif
                                </div>
                                <!-- Card Content -->
                                <div class="grow flex flex-col p-5">
                                    <!-- Card body -->
                                    <div class="grow">
                                        <header class="mb-2">
                                            <a href="#0">
                                                <h3 class="text-lg text-slate-800 font-bold mb-1">{{$asset->idassets}}</h3>
                                            </a>
                                            <div class="text-sm text-slate-800 font-semibold">{{$asset->name}},</div>
                                            <span class="text-sm clamp-2" id="desc">{{ $asset->description }}.</span>
                                            @if ($asset->description != null)
                                            <button class="text-sky-600 hover:underline mt-2 show-more-button" id="show-more-button">Show More</button>
                                            <button class="text-rose-600 hover:underline mt-2 show-less-button hidden" id="show-less-button">Show Less</button>
                                            @endif
                                        </header>
                                    </div>
                                    <!-- Rating and price -->
                                    <div class="flex flex-wrap justify-between items-center">
                                        <!-- Rating -->
                                        <div class="flex items-center space-x-2 mr-2">
                                            
                                        </div>
                                        <!-- Price -->
                                        <div>
                                            <div class="inline-flex text-sm font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2 py-0.5">{{ number_format($asset->qty, 0, '.', ' ') }} {{$asset->unit}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <x-ecommerce.shop-cards-07 />--}}
                        @endforeach
                        @else
                        <center>
                            <p class="text-center text-lg text-slate-800 font-semibold">Inventory Not Found</p>
                        </center>
                    @endif
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{$dataAsset->links()}}
                </div>
                {{-- <x-pagination-classic /> --}}

            </div>

        </div>

    </div>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".show-more-button").click(function () {
            console.log("Show More button clicked");
            $("#desc").removeClass("clamp-2");
            $(this).hide();
            $("#show-less-button").show();
        });

        $(".show-less-button").click(function () {
            console.log("Show Less button clicked");
            $("#desc").addClass("clamp-2");
            $(this).hide();
            $("#show-more-button").show();
        });
    });
</script>

