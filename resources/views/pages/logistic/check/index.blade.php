<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $CRM_ISS->nilai }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-inter antialiased bg-slate-100 text-slate-600">
        @include('sweetalert::alert')

        <main class="bg-white">

            <div class="relative flex">

                <!-- Content -->
                <div class="w-full md:w-1/2">

                    <div class="min-h-screen h-full flex flex-col after:flex-1">

                        <!-- Header -->
                        <div class="flex-1">
                            <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                                <!-- Logo -->
                                <a class="block" href="{{ route('dashboard') }}">
                                    <img src="/images/Logo.png" alt="" class='w-10 h-10'>
                                </a>
                            </div>
                        </div>

                        <div class="w-full max-w-sm mx-auto px-4 py-8">
                            <div class="min-h-screen h-full flex flex-col after:flex-1">
                                <h1 class="text-3xl text-slate-800 font-bold mb-6">Welcome to {{ $CRM_ISS->nilai }} Tracking ✨</h1>
                            
                                <div class="w-full max-w-sm mx-auto px-4 py-8">
                                    <div class="space-y-4">
                                        <form class="items-center mb-3" id="search" action="{{route('tracking.update')}}" method="GET">
                                            <label class="text-center block text-sm font-medium text-lg mb-1" for="form-search">Search Tracking Code :</label>
                                            <div>
                                                <input id="search" name="search" class="search form-input w-full" type="text" placeholder="Tracking Code" maxlength="4" required autofocus>
                                            </div>
                                            <center>
                                                <button class="item-center btn-sm bg-indigo-500 hover:bg-indigo-600 text-white mt-3" type="submit" aria-label="Search">
                                                    Search
                                                </button>
                                            </center>
                                        </form>
                                    </div>
                                        
                                </div>
                            
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Image -->
                <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2" aria-hidden="true">
                    <img class="object-cover object-center w-full h-full" src="{{ asset('images/1.jpg') }}" width="760" height="1024" alt="Authentication image" />
                    <img class="absolute top-1/4 left-0 -translate-x-1/2 ml-8 hidden lg:block" src="{{ asset('images/auth-decoration.png') }}" width="218" height="224" alt="Authentication decoration" />
                </div>

            </div>

        </main>

        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            function formatDate(date){
                let d = new Date(date);
                const formattedDate = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2);
                return formattedDate;
            }

            function formatCurrency(num) {
                var num_parts = num.toString().split(".");
                num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                return 'IDR ' + num_parts.join(".");
            }
            function divider(num) {
                var num_parts = num.toString().split(".");
                num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                return ' ' + num_parts.join(".");
            }

            const loadFile = function (event) {
                const output = document.getElementById("output");
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src); // free memory
                };
            };

            const loadFileMultiple = function (event, idView) {
                const output = document.getElementById(idView);
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src); // free memory
                };
            };
        </script>
        @yield('js-page')
    </body>
</html>
