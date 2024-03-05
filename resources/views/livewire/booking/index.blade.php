<div>
    <dl class="grid items-center justify-center w-full max-w-screen-xl grid-cols-3 gap-6 mx-auto text-gray-900 sm:py-8">
        <x-stats-card :title="'Active Trips'">
            {{ str_pad($activeTrips, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
        <x-stats-card :title="'Total Trips Today'">
            {{  str_pad($todayTrips, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
        <x-stats-card :title="'Total Receipts'">
            £ {{ str_pad($totalReceipts, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
    </dl>
    <section class="py-4">
        <h2> Current Trips</h2>
        <x-live-gmap></x-live-gmap>
    </section>
    <div>
        <form class="flex items-center" wire:submit="search">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input wire:model='query' type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 " placeholder="Search">
            </div>
        </form>

    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr>
                    <th scope="col" class="p-2">
                        Number
                    </th>
                    <th scope="col" class="p-2">
                        Start time
                    </th>
                    <th scope="col" class="p-2">
                        End time
                    </th>
                    <th scope="col" class="p-2">
                        Pickup
                    </th>
                    <th scope="col" class="p-2">
                        Drop off
                    </th>
                    <th scope="col" class="p-2">
                        Est. Time
                    </th>

                    <th scope="col" class="p-2">
                        Driver
                    </th>
                    <th scope="col" class="p-2">
                        Est. Amount
                    </th>
                    <th scope="col" class="p-2">
                        Actual Amount
                    </th>
                    <th scope="col" class="p-2">
                        Type
                    </th>
                    <th scope="col" class="p-2">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $booking )
                <tr class="bg-white border-b cursor-pointer " onclick="window.location.href='{{ route('booking.show',encrypt($booking->id)) }}';">
                    {{-- <tr class="bg-white border-b cursor-pointer "> --}}
                        <th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap ">
                            {{ $booking->vehicle?->license_no_plate }}
                        </th>
                        <td class="p-2">
                            {{ $booking->created_at->format('d M Y h:i a') }}
                        </td>
                        <td class="p-2">
                            {{ $booking->updated_at->format('d M Y h:i a') }}
                            {{-- <img src="{{Storage::disk(env('CURRENT_IMG_DRIVER'))->url($bookingType->upload_url) }}"/> --}}
                        </td>
                        <td class="p-2">
                            {{ $booking->bookingStops?->first()->stop }}
                        </td>
                        <td class="p-2">
                            {{ $booking->bookingStops?->last()->stop  }}
                        </td>

                        <td class="p-2">
                            {{ $booking->bookingPayment?->total_minutes }}
                        </td>

                        <td class="p-2">
                            {{ $booking->driver?->first_name." ".$booking->driver?->last_name }}
                        </td>

                        <td class="p-2">
                            {{ $booking->pre_calculated_fare }}
                        </td>
                        <td class="p-2">
                            {{ $booking->bookingPayment?->total_fare }}
                        </td>
                        <td class="p-2">
                            {{ $booking->bookingPayment?->paymentMethod?->name }}
                        </td>
                        <td class="p-2">
                            <span class="{{ ($booking->status=='completed' || $booking->status=='active')?'bg-green-100 text-emerald-900':'bg-rose-100 text-red-800' }} p-1 rounded-md">
                            {{ ucfirst($booking->status) }}
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
