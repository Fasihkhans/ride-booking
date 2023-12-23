<x-web-layout>
    <div class="relative w-full h-auto bg-white">

            <section class="bg-gray-700 bg-center bg-no-repeat " style="background-image: url('{{ asset('assets/png/landingPageS1.png') }}');">
                <div class="max-w-screen-xl px-4 py-24 mx-auto text-left lg:py-56">
                    <h1 class="mb-4 text-4xl leading-[88px] tracking-tight text-white md:text-5xl lg:text-6xl  font-normal">Get in the driver’s seat<br> and get paid</h1>
                    <p class="mb-8 text-lg font-normal text-white lg:text-xl sm:px-16 lg:px-2 font-['Outfit']">Drive on the platform with the largest network of active riders.</p>
                    <div class="flex flex-col space-y-4 sm:flex-row sm:justify-start sm:space-y-0">
                        <a href="#" class="inline-flex items-center justify-center px-5 py-3 text-base  font-['Outfit'] font-medium text-center text-black bg-white rounded-lg hover:bg-black hover:border-white border hover:text-white focus:ring-4 focus:ring-blue-300 ">
                            Apply to drive
                            {{-- <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg> --}}
                        </a>
                    </div>
                </div>
            </section>


            <section class="bg-white ">
                <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">
                    {{-- <div class="p-8 mb-8 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 md:p-12"> --}}

                        <h1 class="text-gray-900 mb-4  text-3xl md:text-5xl font-extrabold font-['Outfit']">Focused on safety, wherever you go</h1>

                    {{-- </div> --}}
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
            </section>

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
                                <a href="#" class="inline-flex items-center text-lg font-medium text-blue-600 hover:underline">Learn more about us
                                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                                </a>
                            </div>
                        </div>
                        <div class="rounded-lg ">
                            <a href="#">
                                <img class="rounded-lg" src="{{ asset('assets/svg/NewsVector.svg') }}" alt="" />
                            </a>
                            <div class="py-5">
                                <h2 class="mb-2 text-3xl font-extrabold text-gray-900 ">Newsroom</h2>
                                <p class="mb-4 text-lg font-normal text-gray-500 ">Find out how we started, what drives us, and how we’re reimagining how the world moves.</p>
                                <a href="#" class="inline-flex items-center text-lg font-medium text-blue-600 hover:underline">Learn more about us
                                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                                </a>
                            </div>
                        </div>
                        <div class="rounded-lg ">
                            <a href="#">
                                <img class="rounded-lg" src="{{ asset('assets/svg/HomeVactor.svg') }}" alt="" />
                            </a>
                            <div class="py-5">
                                <h2 class="mb-2 text-3xl font-extrabold text-gray-900 ">Global citizenship</h2>
                                <p class="mb-4 text-lg font-normal text-gray-500 ">Find out how we started, what drives us, and how we’re reimagining how the world moves.</p>
                                <a href="#" class="inline-flex items-center text-lg font-medium text-blue-600 hover:underline">Learn more about us
                                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white ">
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
            </section>

        {{--<img class="w-[632px] h-[451px] left-[80px] top-[944px] absolute" src="https://via.placeholder.com/632x451" />
        <img class="w-[632px] h-[451px] left-[728px] top-[944px] absolute" src="https://via.placeholder.com/632x451" />
        <div class="left-[80px] top-[1419px] absolute text-black text-[32px] font-semibold font-['Outfit'] leading-loose">Our commitment to your safety</div>
        <div class="left-[80px] top-[1719px] absolute text-black text-[32px] font-semibold font-['Outfit'] leading-loose">About us</div>
        <div class="left-[512px] top-[1719px] absolute text-black text-[32px] font-semibold font-['Outfit'] leading-loose">Newsroom</div>
        <div class="left-[944px] top-[1719px] absolute text-black text-[32px] font-semibold font-['Outfit'] leading-loose">Global citizenship</div>
        <div class="left-[728px] top-[1419px] absolute text-black text-[32px] font-semibold font-['Outfit'] leading-loose">Setting Darlington in motion</div>
        <div class="w-[595px] left-[83px] top-[1467px] absolute text-black text-xl font-normal font-['Outfit'] leading-normal">With every safety feature and every standard in our Community Guidelines, we're committed to helping to create a safe environment for our users.</div>
        <div class="w-[353px] left-[80px] top-[1767px] absolute text-black text-xl font-normal font-['Outfit'] leading-normal">Find out how we started, what drives us, and how we’re reimagining how the world moves.</div>
        <div class="w-[353px] left-[512px] top-[1767px] absolute text-black text-xl font-normal font-['Outfit'] leading-normal">Find out how we started, what drives us, and how we’re reimagining how the world moves.</div>
        <div class="w-[353px] left-[944px] top-[1767px] absolute text-black text-xl font-normal font-['Outfit'] leading-normal">Find out how we started, what drives us, and how we’re reimagining how the world moves.</div>
        <div class="w-[595px] left-[731px] top-[1467px] absolute text-black text-xl font-normal font-['Outfit'] leading-normal">The app is available in darlington, so you can request a ride even when you’re far from home.</div>
        <div class="w-[78px] h-[18px] pr-1.5 left-[83px] top-[1563px] absolute justify-start items-center inline-flex">
            <div class="text-indigo-600 text-sm font-medium font-['Outfit'] underline">Learn More</div>
        </div>
        <div class="w-[136px] h-[18px] pr-2 left-[80px] top-[1855px] absolute justify-start items-center inline-flex">
            <div class="text-indigo-600 text-sm font-medium font-['Outfit'] underline">Learn more about us</div>
        </div>
        <div class="w-[136px] h-[18px] pr-2 left-[512px] top-[1855px] absolute justify-start items-center inline-flex">
            <div class="text-indigo-600 text-sm font-medium font-['Outfit'] underline">Learn more about us</div>
        </div>
        <div class="w-[136px] h-[18px] pr-2 left-[944px] top-[1855px] absolute justify-start items-center inline-flex">
            <div class="text-indigo-600 text-sm font-medium font-['Outfit'] underline">Learn more about us</div>
        </div>
        <div class="w-[78px] h-[18px] pr-1.5 left-[731px] top-[1539px] absolute justify-start items-center inline-flex">
            <div class="text-indigo-600 text-sm font-medium font-['Outfit'] underline">Learn More</div>
        </div>
        <div class="w-[45px] h-[37.50px] left-[511px] top-[1663px] absolute">
        </div>
        <div class="w-[632px] h-[147px] left-[80px] top-[1953px] absolute bg-black bg-opacity-5 border-b-8 border-black"></div>
        <div class="w-[632px] h-[147px] left-[728px] top-[1953px] absolute bg-black bg-opacity-5 border-b-8 border-black"></div>
        <div class="left-[120px] top-[1993px] absolute text-black text-[56px] font-semibold font-['Outfit'] leading-[56px]">Apply to drive</div>
        <div class="left-[768px] top-[1993px] absolute text-black text-[56px] font-semibold font-['Outfit'] leading-[56px]">Sign up to ride</div>
        <div class="w-[1440px] h-[174px] left-0 top-[2220px] absolute bg-black"></div>
        <div class="w-[1440px] h-[104px] left-0 top-[2220px] absolute bg-stone-900"></div>
        <div class="w-[171px] h-12 px-[8.49px] py-[8.56px] left-[80px] top-[2248px] absolute justify-center items-center inline-flex">
            <div class="h-[30.88px] relative">
                <div class="w-[48.44px] h-[19.73px] left-0 top-[5.71px] absolute">
                </div>
                <div class="w-[48.44px] h-[19.73px] left-[105.58px] top-[5.71px] absolute">
                </div>
                <div class="w-[49.64px] h-[30.88px] left-[52.42px] top-0 absolute flex-col justify-start items-start inline-flex"></div>
            </div>
        </div>
        <div class="left-[291px] top-[2265px] absolute text-center text-white text-sm font-bold font-['Outfit'] leading-[14px]">Company</div>
        <div class="left-[395px] top-[2265px] absolute text-center text-white text-sm font-bold font-['Outfit'] leading-[14px]">Safety</div>
        <div class="left-[478px] top-[2265px] absolute text-center text-white text-sm font-bold font-['Outfit'] leading-[14px]">Help</div>
        <div class="left-[1084px] top-[2352px] absolute opacity-70 text-center text-white text-sm font-normal font-['Outfit'] leading-[14px]">Privacy                    Accessibility                    Terms</div>
        <div class="left-[80px] top-[2352px] absolute opacity-70 text-center text-white text-sm font-normal font-['Outfit'] leading-[14px]">© 2023 Dartcars  Technologies Inc.</div>
        <div class="left-[1228px] top-[2258px] absolute justify-start items-center gap-5 inline-flex">
            <div class="flex items-start justify-start gap-6">
                <div class="relative w-7 h-7">
                </div>
                <div class="relative w-7 h-7">
                    <div class="w-[21px] h-[16.33px] left-[3.50px] top-[5.83px] absolute rounded-md border border-white"></div>
                </div>
                <div class="relative w-7 h-7">
                    <div class="w-[18.67px] h-[18.67px] left-[4.67px] top-[4.67px] absolute rounded-md border border-white"></div>
                    <div class="w-[7px] h-[7px] left-[10.50px] top-[10.50px] absolute rounded-full border border-white"></div>
                </div>
            </div>
        </div> --}}
    </div>
</x-web-layout>
    {{-- </body>
</html> --}}
