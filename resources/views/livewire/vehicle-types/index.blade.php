<?php
use App\Repositories\VehicleTypesRepository;
use function Livewire\Volt\{state,mount,with,usesPagination,placeholder};

state([
    'vehicleTypes'=> [],
    'search'=>'',
]);

mount(fn () => $this->vehicleTypes = VehicleTypesRepository::getAll());
// mount(fn () => $this->vehicleTypes = VehicleTypesRepository::fetchData($this->search)->paginate(10));

placeholder('<div>Loading...</div>');

// mount(function () {
//     if ($this->search) {
//         // Build the search query with "LIKE" clause based on $this->search
//         $query = VehicleTypesRepository::fetchData($this->search);
//     } else {
//         $query = VehicleTypesRepository::fetchData();
//     }

//     // Manually paginate the query results and assign to state
//     $this->vehicleTypes = $query->paginate(10);
// });
?>

<div>

    <div>

        <form class="flex items-center">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required>
            </div>
            {{-- <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search</span>
            </button> --}}
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
                        Peak Hour Rate
                    </th>$vehicleType
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
                @foreach ($vehicleTypes as $vehicleType )
                    {{-- {{ $vehicleType }} --}}
                {{-- @endforeach --}}
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $vehicleType->name }}
                        </th>
                        <td class="p-2" style="filter: invert(25%)">
                            <img src="{{Storage::disk('public')->url($vehicleType->upload_url) }}"/>
                        </td>
                        <td class="p-2">
                            {{ $vehicleType->base_fare }}
                        </td>
                        <td class="p-2">
                            {{ $vehicleType->per_mintue_rate }}
                        </td>

                        <td class="p-2">
                            {{ $vehicleType->per_mile_rate }}
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
        {{-- {{ $vehicleTypes->paginate()}} --}}
    </div>
</div>
