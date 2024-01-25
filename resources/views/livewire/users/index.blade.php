<div>
    <div>
        <form class="flex items-center" wire:submit="search">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input wire:model='query' type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
            </div>
            {{-- <div x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="px-4 py-2 mx-2 bg-white border rounded">
                    Sort
                </button>

                <div x-show="open" class="absolute z-50 mt-2 bg-white border rounded shadow-md">
                    <!-- Dropdown content goes here -->
                    <a wire:click="sortBy('user.first_name','asc')" href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Name</a>
                    <a wire:click="sortBy('created_at')" href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Date Created</a>

                </div>
            </div> --}}
        </form>

    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-2">
                        Date added
                    </th>
                    <th scope="col" class="p-2">
                        Name
                    </th>
                    <th scope="col" class="p-2">
                        Phone
                    </th>
                    <th scope="col" class="p-2">
                        Email
                    </th>

                    {{-- <th scope="col" class="p-2">
                        Trips
                    </th> --}}

                    <th scope="col" class="p-2">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user )
                {{-- {{ $driver }} --}}
                    <tr class="bg-white border-b cursor-pointer dark:bg-gray-800 dark:border-gray-700" onclick="window.location.href='{{ route('users.show',encrypt($user->id)) }}';">
                        <th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           {{ $user->created_at->format('d M Y') }}
                        </th>
                        <td class="p-2">
                            {{ $user->first_name.' '.$user->last_name }}
                        </td>
                        <td class="p-2">
                            {{ $user->phone_number }}
                        </td>
                        <td class="p-2">
                            {{ $user->email }}
                        </td>

                        {{-- <td class="p-2">
                            {{ count($user->booking) }}
                        </td> --}}
                        <td class="p-2">
                            <span class="{{ ($user->status=='active')?'bg-green-100 text-emerald-900':'bg-rose-100 text-red-800' }} p-1 rounded-md">
                            {{ ucfirst($user->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{ $data->links()}}
    </div>
</div>
