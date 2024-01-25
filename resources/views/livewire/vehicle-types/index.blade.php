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
        </form>

    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-2">
                        Type Name
                    </th>
                    <th scope="col" class="p-2">
                        Icon
                    </th>
                    <th scope="col" class="p-2">
                        Base Fare
                    </th>
                    <th scope="col" class="p-2">
                        Per-minute Rate
                    </th>
                    <th scope="col" class="p-2">
                        Per-mile Rate
                    </th>
                    <th scope="col" class="p-2">
                        Night Base Fare
                    </th>
                    <th scope="col" class="p-2">
                        Night Per-minute Rate
                    </th>
                    <th scope="col" class="p-2">
                        Night Per-mile Rate
                    </th>
                    <th scope="col" class="p-2">
                        Peak Hour Rate
                    </th>
                    <th scope="col" class="p-2">
                        Holiday Rate
                    </th>
                    <th scope="col" class="p-2">
                        Minimum Mintues
                    </th>
                    <th scope="col" class="p-2">
                        Minimum Miles
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $vehicleType )
                    <tr class="bg-white border-b cursor-pointer dark:bg-gray-800 dark:border-gray-700" onclick="window.location.href='{{ route('vehicle-types.show',encrypt($vehicleType->id)) }}';">
                        <th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $vehicleType->name }}
                        </th>
                        <td class="p-2" style="filter: invert(25%)">
                            <img src="{{Storage::disk(env('CURRENT_IMG_DRIVER'))->url($vehicleType->upload_url) }}"/>
                        </td>
                        <td class="p-2">
                            {{ $vehicleType->base_fare }}
                        </td>
                        <td class="p-2">
                            {{ $vehicleType->per_minute_rate }}
                        </td>

                        <td class="p-2">
                            {{ $vehicleType->per_mile_rate }}
                        </td>
                        <td class="p-2">
                            {{ $vehicleType->night_base_fare }}
                        </td>
                        <td class="p-2">
                            {{ $vehicleType->night_per_minute_rate }}
                        </td>

                        <td class="p-2">
                            {{ $vehicleType->night_per_mile_rate }}
                        </td>

                        <td class="p-2">
                            {{ $vehicleType->peak_hour_rate }}
                        </td>

                        <td class="p-2">
                            {{ $vehicleType->holiday_rate }}
                        </td>

                        <td class="p-2">
                            {{ $vehicleType->min_mintues }}
                        </td>

                        <td class="p-2">
                            {{ $vehicleType->min_miles }}
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
