<x-customer-layout>
    <div class="w-full max-h-screen py-3 mt-20 bg-white">


        <div class="max-h-screen mx-auto overflow-x-hidden max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 my-10 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 my-10 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>
            @if ( auth()->user()->hasRole('user'))

            <div class="p-4 my-10 mb-20 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
            @endif
        </div>
    </div>
</x-customer-layout>
