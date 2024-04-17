<x-web-layout>
    <div class="relative w-full h-auto bg-white">
            <section class="flex justify-center bg-local bg-gray-700 bg-center bg-no-repeat bg-cover" style="background-image: url('{{ asset('assets/png/landingPageS1.png') }}');">
                <div class="max-w-screen-xl px-4 py-24 mx-auto text-left lg:py-56">
                    {{-- <h1 class="mb-4 text-4xl leading-[88px] tracking-tight text-white md:text-5xl lg:text-6xl  font-normal">Get in the driver’s seat<br> and get paid</h1> --}}
                    {{-- <p class="mb-8 text-lg font-normal text-white lg:text-xl sm:px-16 lg:px-2 font-['Outfit']">Drive on the platform with the largest network of active riders.</p> --}}
                    <h1 class="mt-7 mb-4 text-xl font-normal leading-10 tracking-tight text-white md:leading-[88px] lg:leading-[88px] md:text-5xl lg:text-6xl">For booking, call on the given number.</h1>
                    <div class="flex w-full space-y-4 sm:flex-row sm:justify-start sm:space-y-0">
                        <a href="tel:01325521640" class="inline-flex md:w-1/2 w-full items-center justify-center px-5 py-3 text-base  font-['Outfit'] font-medium text-center text-black bg-white rounded-lg hover:bg-black hover:border-white border hover:text-white focus:ring-4 focus:ring-blue-300 ">
                            Call Now 01325 521640
                        </a>
                    </div>
                    <ul class="flex justify-start gap-5 mt-10">
                        <li>
                            <a href="https://apps.apple.com/pk/app/darts-cars/id6474194239">
                                <img src="{{ asset('assets/jpg/app-store.jpg') }}" alt="app-store" class="w-64 h-12 border border-white md:h-20 rounded-xl">
                            </a>
                        </li>
                        <li>
                            <a href="https://play.google.com/store/apps/details?id=com.dartscars">
                                <img src="{{ asset('assets/png/play-store.png') }}" alt="play-store" class="w-64 h-12 border border-white md:h-20 rounded-xl">
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="items-center hidden max-w-screen-xl px-4 py-24 mx-auto text-left lg:py-56 md:flex">
                    <a href="/" class="flex items-center justify-center w-full space-x-2 text-center md:w-auto md:justify-start md:rtl:space-x-reverse">
                        <img src="{{ asset('assets/svg/dart-logo.svg') }}" class="h-40 w-80" alt="DartsCars Logo">
                    </a>

                </div>
            </section>


            {{-- <section class="bg-white ">
                <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">

                        <h1 class="text-gray-900 mb-4  text-3xl md:text-5xl font-extrabold font-['Outfit']">Focused on safety, wherever you go</h1>
                    <div class="grid gap-8 md:grid-cols-2">
                        <div class="rounded-lg ">
                            <a href="#">
                                <img class="rounded-lg" src="{{ asset('assets/svg/OurCommitmentToYourSafety.svg') }}" alt="" />
                            </a>
                            <div class="py-5">
                                <h2 class="mb-2 text-3xl font-extrabold text-gray-900 ">Our commitment to your safety</h2>
                                <p class="mb-4 text-lg font-normal text-gray-500 ">With every safety feature and every standard in our Community Guidelines, we're committed to helping to create a safe environment for our users.</p>
                                <a href="#" class="inline-flex items-center text-lg font-medium text-blue-600 hover:underline">Learn more
                                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                                </a>
                            </div>
                        </div>
                        <div class="rounded-lg ">
                            <a href="#">
                                <img class="rounded-lg" src="{{ asset('assets/svg/SettingDarlingtonInMotion.svg') }}" alt="" />
                            </a>
                            <div class="py-5">
                                <h2 class="mb-2 text-3xl font-extrabold text-gray-900 ">Setting Darlington in motion</h2>
                                <p class="mb-4 text-lg font-normal text-gray-500 ">The app is available in darlington, so you can request a ride even when you’re far from home.</p>
                                <a href="#" class="inline-flex items-center text-lg font-medium text-blue-600 hover:underline">Learn more
                                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --}}

            <section class="bg-white ">
                <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">
                    <div class="grid gap-8 md:grid-cols-3">
                        <div class="rounded-lg ">
                            <a href="#">
                                <img class="rounded-lg" src="{{ asset('assets/svg/HumanVector.svg') }}" alt="" />
                            </a>
                            <div class="py-5">
                                <h2 class="mb-2 text-3xl font-extrabold text-gray-900 ">About us</h2>
                                <p class="mb-4 text-lg font-normal text-gray-500 ">Find out how we started, what drives us, and how we’re reimagining how the world moves.</p>
                                {{-- <a href="#" class="inline-flex items-center text-lg font-medium text-blue-600 hover:underline">Learn more about us
                                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                                </a> --}}
                            </div>
                        </div>
                        <div class="rounded-lg ">
                            <a href="#">
                                <img class="rounded-lg" src="{{ asset('assets/svg/NewsVector.svg') }}" alt="" />
                            </a>
                            <div class="py-5">
                                <h2 class="mb-2 text-3xl font-extrabold text-gray-900 ">Newsroom</h2>
                                <p class="mb-4 text-lg font-normal text-gray-500 ">Find out how we started, what drives us, and how we’re reimagining how the world moves.</p>
                                {{-- <a href="#" class="inline-flex items-center text-lg font-medium text-blue-600 hover:underline">Learn more about us
                                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                                </a> --}}
                            </div>
                        </div>
                        <div class="rounded-lg ">
                            <a href="#">
                                <img class="rounded-lg" src="{{ asset('assets/svg/HomeVactor.svg') }}" alt="" />
                            </a>
                            <div class="py-5">
                                <h2 class="mb-2 text-3xl font-extrabold text-gray-900 ">Global citizenship</h2>
                                <p class="mb-4 text-lg font-normal text-gray-500 ">Find out how we started, what drives us, and how we’re reimagining how the world moves.</p>
                                {{-- <a href="#" class="inline-flex items-center text-lg font-medium text-blue-600 hover:underline">Learn more about us
                                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- <section class="bg-white ">
                <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">
                    <div class="grid gap-8 md:grid-cols-2">
                        <div class="relative bg-black border-b-8 border-black rounded-lg bg-opacity-5">
                            <div class="inline-flex text-black text-5xl py-8 px-4 font-semibold font-['Outfit'] leading-[56px]">Apply to drive</div>
                            <svg class="md:flex absolute  top-[2.5rem] right-[2rem] w-[3rem] h-[3rem] hidden md:order-1 text-black " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                            </svg>
                        </div>
                        <div class="relative align-middle bg-black border-b-8 border-black rounded-lg bg-opacity-5">
                            <div class="inline-flex text-black text-5xl py-8 px-4 font-semibold font-['Outfit'] leading-[56px]">Sign up to ride</div>
                            <svg class="md:flex absolute  top-[2.5rem] right-[2rem] w-[3rem] h-[3rem] hidden md:order-1 text-black " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </section> --}}
    </div>

</x-web-layout>
