<div>
    <dl class="grid items-center justify-center w-full max-w-screen-xl grid-cols-3 gap-6 mx-auto text-gray-900 dark:text-white sm:py-8">
        <x-stats-card :title="'Total'">
            {{ str_pad($totalVehicles, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
        <x-stats-card :title="'Active'">
            {{ str_pad($activeVehicles, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
        <x-stats-card :title="'Inactive'">
            {{ str_pad($inActiveVehicles, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
    </dl>
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
                         Number
                    </th>
                    <th scope="col" class="p-2">
                        Date added
                    </th>
                    <th scope="col" class="p-2">
                        Make
                    </th>
                    <th scope="col" class="p-2">
                        Model
                    </th>
                    <th scope="col" class="p-2">
                        Year
                    </th>
                    <th scope="col" class="p-2">
                        Color
                    </th>

                    <th scope="col" class="p-2">
                        Type
                    </th>
                    <th scope="col" class="p-2">
                        Photo
                    </th>
                    <th scope="col" class="p-2">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $vehicle )
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $vehicle->license_no_plate }}
                        </th>
                        <td class="p-2">
                            {{ $vehicle->created_at->format('d M Y') }}
                            {{-- <img src="{{Storage::disk('public')->url($vehicleType->upload_url) }}"/> --}}
                        </td>
                        <td class="p-2">
                            {{ $vehicle->make }}
                            {{-- <img src="{{Storage::disk('public')->url($vehicleType->upload_url) }}"/> --}}
                        </td>
                        <td class="p-2">
                            {{ $vehicle->model }}
                        </td>
                        <td class="p-2">
                            {{ $vehicle->year }}
                        </td>

                        <td class="p-2">
                            {{ $vehicle->color }}
                        </td>

                        <td class="p-2">
                            {{ $vehicle->vehicleType->name }}
                        </td>

                        <td class="p-2"  style="filter: invert(25%)">
                            <img src="{{Storage::disk('public')->url($vehicle->vehicleType->upload_url) }}"/>
                        </td>

                        <td class="p-2">
                            <span class="{{ ($vehicle->status=='active')?'bg-green-100 text-emerald-900':'bg-rose-100 text-red-800' }} p-1 rounded-md">
                            {{ ucfirst($vehicle->status) }}
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
