<div>
    <div>
        <form class="flex items-center" wire:submit="search">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input wire:model='query' type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  " placeholder="Search">
            </div>
        </form>

    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr>
                    <th scope="col" class="p-2">
                        Driver
                    </th>
                    <th scope="col" class="p-2">
                        Vehicle
                    </th>
                    <th scope="col" class="p-2">
                        Start Date
                    </th>
                    <th scope="col" class="p-2">
                        Time
                    </th>
                    <th scope="col" class="p-2">
                        End Date
                    </th>
                    <th scope="col" class="p-2">
                        Time
                    </th>

                    <th scope="col" class="p-2">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $driverVehicle )
                {{-- {{ $driver }} --}}
                    <tr class="bg-white border-b cursor-pointer " onclick="window.location.href='{{ route('vehicle-assignment.show',encrypt($driverVehicle->id)) }}';">
                        <th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap ">
                            {{ $driverVehicle->driver->user->first_name.' '.$driverVehicle->driver->user->last_name }}
                        </th>
                        <td class="p-2">
                            {{ $driverVehicle->vehicle->license_no_plate }}

                        </td>
                        <td class="p-2">
                            {{ $driverVehicle->start_date }}

                        </td>
                        <td class="p-2">
                            {{ $driverVehicle->start_time }}
                        </td>
                        <td class="p-2">
                            {{ $driverVehicle->end_date }}
                        </td>

                        <td class="p-2">
                            {{ $driverVehicle->end_time }}
                        </td>

                        <td class="p-2">
                            <span class="{{ ($driverVehicle->status=='active')?'bg-green-100 text-emerald-900':'bg-rose-100 text-red-800' }} p-1 rounded-md">
                            {{ ucfirst($driverVehicle->status) }}
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
