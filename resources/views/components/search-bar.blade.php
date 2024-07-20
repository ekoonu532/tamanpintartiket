<!-- Tambahkan link CSS Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
{{-- <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
    <form action="{{ route('search.tickets') }}" method="GET" >
        <div class="w-full sm:w-[996px] mx-auto h-auto bg-white rounded border-2 flex items-center justify-center">
            <!-- Input Pencarian -->
            <div class="flex-1 pr-2">
                <input type="text" name="search" placeholder="Cari Berdasarkan Event, Wahana dan Jadwal"
                    class="w-full h-[69px] py-2 px-4 border-none outline-none text-zinc-600 text-base font-normal font-['Poppins'] sm:px-5 lg:px-8">
            </div>

            <!-- Input Tanggal -->
            <div class="hidden sm:flex w-1/3 h-full pl-[17px] pr-2 pt-6 pb-[21px] items-start gap-[11px] inline-flex">
                <div class="text-zinc-600 text-base font-normal font-['Poppins']">
                    <input id="tanggal" type="text" placeholder="Pilih Tanggal" readonly>
                </div>
            </div>

            <!-- Tanggal Picker (Hidden on Small Screens) -->
            <div
                class="sm:hidden w-[37px] h-auto sm:w-0 sm:h-0 left-[50%] transform -translate-x-1/2 absolute origin-top-left rotate-90 border border-neutral-200">
            </div>

            <!-- Tombol Cari -->
            <button type="submit"
                class="ml-2 mt-2 sm:mt-0 px-4 py-2.5 bg-teal-400 text-white font-normal">Cari</button>
        </div>
    </form>
<div> --}}
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
        <form action="{{ route('search.tickets') }}" method="GET" class="w-full mx-auto h-auto bg-white rounded border-2 flex items-center justify-center sm:flex sm:justify-around">
            <div class="flex">
                <label for="search-dropdown" class="sr-only">Your Email</label>
                <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">All categories
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1 5 5 9 1"/>
                    </svg>
                </button>
                <div id="dropdown" class="hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mockups</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Templates</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Design</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Logos</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex relative w-full">
                <div class="flex-grow">
                    <input type="search" id="search-dropdown" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Cari Event atau Wahana..." required />
                </div>
                <div class="relative flex-grow-0">
                    <input type="date" id="tanggal" name="tanggal" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Pilih tanggal" required/>
                </div>
                <button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </form>
    </div>


    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
        <form action="{{ route('search.tickets') }}" method="GET">
          <div class="w-full mx-auto h-auto bg-white rounded border-2 flex items-center justify-center sm:flex sm:justify-around">
            <div class="flex-1 sm:w-1/2 pr-2">
              <input type="text" name="search" placeholder="Cari Berdasarkan Event, Wahana dan Jadwal"
                   class="w-full h-[69px] py-2 px-4 border-none outline-none text-zinc-600 text-base font-normal font-['Poppins'] sm:px-5 lg:px-8">
            </div>

            <div class="flex-1 sm:w-1/2 h-full pl-2 pr-2 pt-6 pb-[21px] mt-auto sm:pt-0 sm:pr-4 sm:items-start gap-[11px] inline-flex">
              <div class="text-zinc-600 text-base font-normal font-['Poppins']">
                <input id="tanggal" type="text" placeholder="Pilih Tanggal" readonly>
              </div>
              <div class="sm:hidden w-[37px] h-auto sm:w-0 sm:h-0 left-[50%] transform -translate-x-1/2 absolute origin-top-left rotate-90 border border-neutral-200">
              </div>
            </div>

            <button type="submit" class="mt-2 m:mt-0 mx-auto sm:mx-0 px-4 py-2.5 bg-teal-400 text-white font-normal">Cari</button>
          </div>
        </form>
      </div>

      <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
        <form action="{{ route('search.tickets') }}" method="GET" class="max-w-lg mx-auto">
            <div class="flex">
                <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your Email</label>
                <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">All categories <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg></button>
                <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mockups</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Templates</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Design</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Logos</button>
                        </li>
                    </ul>
                </div>

                <div class="flex relative w-full">
                    <div class="flex-grow">
                        <input type="search" id="search-dropdown" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50   border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Cari Event atau Wahana..." required />
                    </div>
                    <div class="relative flex-grow-0">
                        <input type="date" id="tanggal" name="tanggal" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Pilih tanggal" required/>
                    </div>
                    <button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>

            </div>
        </form>
    </div>







        <!-- Tambahkan script Flatpickr -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#tanggal", {
                mode: "range",
                dateFormat: "Y-m-d",
            });
        </script>
