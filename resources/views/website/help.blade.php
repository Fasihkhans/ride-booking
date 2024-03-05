<x-web-layout>
    @php

    @endphp
    <div class="items-center justify-center w-full h-full p-10 mt-20 bg-white ">
        <section class="bg-white ">
            <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">
                <div class="flex items-center justify-center">

                    <h1 class="text-gray-900 mb-4  text-3xl md:text-5xl font-extrabold font-['Outfit']">Hello, How can we help you?</h1>
                </div>
                <div class="w-full p-10 mt-10 bg-white border rounded-lg shadow-xl">
                    <form method="POST" action="{{ route('helpMail') }}" class="w-full mx-auto">
                        {{ csrf_field() }}
                        <div class="mb-6">
                            <label for="name-input" class="block mb-2 text-sm font-bold text-gray-900">Name</label>
                            <input type="text" id="name-input" name="name" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg shadow-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 " required>
                        </div>
                        <div class="mb-6">
                            <label for="email-input" class="block mb-2 text-sm font-bold text-gray-900">Email</label>
                            <input type="email" id="email-input" name="email" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg shadow-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 " required>
                        </div>
                        <div class="mb-5">
                            <label for="message" class="block mb-2 text-sm font-bold text-gray-900">Message</label>
                            <textarea id="message" rows="4" name="message" class="block p-2.5 shadow-lg w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500   " placeholder="Leave a comment..." required></textarea>
                        </div>
                        <div class="mt-5">

                            <x-primary-button>
                                {{__('Get Help')}}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</x-web-layout>
