<?php

// use App\Models\User;
use App\Constants\Constants;
use App\Repositories\UserRepository;
use App\Repositories\DriverRepository;
use App\Repositories\VehiclesRepository;
use App\Repositories\DriverVehiclesRepository;
use App\Helpers\Configuration;
use function Livewire\Volt\{state,usesFileUploads,rules,updated,mount};

state([
    'drivers'=>'',
    'vehicles' => '',
    'start_date' => '',
    'end_date' => '',
    'start_time' => '',
    'end_time' => '',
    'driver_id'=>'',
    'vehicle_id'=>''
]);

mount(function(){
        $this->drivers = DriverRepository::getAllActiveDrivers();
        $this->vehicles = VehiclesRepository::getAllActiveVehicles();
    });

usesFileUploads();

$save = function(){
    $validated = $this->validate([
        'start_date' => ['required', 'date'],
        'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        'start_time' => ['required', 'date_format:H:i'],
        'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        'driver_id' => ['required', 'numeric'],
        'vehicle_id' => ['required', 'numeric'],
    ],
    [
        'driver_id.required' => 'The driver field is required.',
        'driver_id.numeric' => 'The driver must be a number.',
        'vehicle_id.required' => 'The vehicle field is required.',
        'vehicle_id.numeric' => 'The vehicle must be a number.',
    ]);
    $validated['status'] = 'active';
    $Driver = DriverVehiclesRepository::create($validated);
    session()->flash('success','Vehicle has been assigned to driver');
    $this->redirect(route('vehicle-assignment.index'));
}?>

<div>
    <div>
        @error('message')
                {{$message}}
        @enderror
    </div>

    <div class="col-8 h-[664px] bg-stone-50 rounded-[20px] border border-stone-300 p-4 ml-5">
        <x-auth-session-status class="mb-4" :status="session('success')" />
        <form wire:submit="save"  class="mt-4">
            <div class="text-xl font-bold tracking-tight text-black">Vehicle information</div>
            <div class="mt-4 form-row">
                {{-- <x-form-input :errorMessage="$errors->get('first_name')"  type="text" placeholder="First name" name="first_name" wire:model="first_name"/> --}}
                    <div class="mb-3 col-md-6">
                        <div class="form-group">
                            <select class="form-control"  wire:model='vehicle_id'>
                                <option>Select Vehicle</option>
                                @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->license_no_plate." ".$vehicle->make." ".$vehicle->year }}</option>
                                @endforeach
                              </select>
                              <x-input-error :messages="$errors->get('vehicle_id')" class="mt-2" />
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="form-group">
                            <select class="form-control" wire:model='driver_id' >
                                <option>Select Driver</option>
                                @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->user->first_name." ".$driver->user->last_name }}</option>
                                @endforeach
                              </select>
                              <x-input-error :messages="$errors->get('driver_id')" class="mt-2" />
                        </div>
                    </div>
            </div>
            <div class="text-xl font-bold tracking-tight text-black">Start Date and time</div>
            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('start_date')"  type="date" placeholder="Start Date" name="startDate" id="startDate" wire:model='start_date'/>
                <x-form-input :errorMessage="$errors->get('start_time')"  type="time" placeholder="Start Time" name="startTime" id="startTime" wire:model='start_time'/>
            </div>
            <div class="text-xl font-bold tracking-tight text-black">End Date and time</div>
            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('end_date')"  type="date" placeholder="End Date" name="endDate" id="endDate" wire:model='end_date'/>
                    <x-form-input :errorMessage="$errors->get('end_time')"  type="time" placeholder="End Time" name="endTime" id="endTime" wire:model='end_time'/>
            </div>

            <x-primary-button>
                {{__('save')}}
            </x-primary-button>
      </form>
    </div>
    {{-- <div class="calendar-container">
                            <div class="calendar-month-arrow-container">
                              <div class="calendar-month-year-container">
                                  <select class="calendar-months">
                                  </select>
                                <select class="calendar-years"></select>
                              </div>
                              <div class="calendar-month-year">
                              </div>
                              <div class="calendar-arrow-container">
                                <button class="calendar-today-button"></button>
                                <button class="calendar-left-arrow">
                                  ← </button>
                                <button class="calendar-right-arrow"> →</button>
                              </div>
                            </div>
                            <ul class="calendar-week">
                            </ul>
                            <ul class="calendar-days">
                            </ul>
                          </div> --}}
    <script>
        const weekArray = ["S", "M", "T", "W", "T", "F", "S"];
        const monthArray = [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ];
        const current = new Date();
        const todaysDate = current.getDate();
        const currentYear = current.getFullYear();
        const currentMonth = current.getMonth();

        window.onload = function () {
        const currentDate = new Date();
        generateCalendarDays(currentDate);

        let calendarWeek = document.getElementsByClassName("calendar-week")[0];
        let calendarTodayButton = document.getElementsByClassName(
            "calendar-today-button"
        )[0];
        calendarTodayButton.textContent = `Today ${todaysDate}`;

        calendarTodayButton.addEventListener("click", () => {
            generateCalendarDays(currentDate);
        });

        weekArray.forEach((week) => {
            let li = document.createElement("li");
            li.textContent = week;
            li.classList.add("calendar-week-day");
            calendarWeek.appendChild(li);
        });

        const calendarMonths = document.getElementsByClassName("calendar-months")[0];
        const calendarYears = document.getElementsByClassName("calendar-years")[0];
        const monthYear = document.getElementsByClassName("calendar-month-year")[0];

        const selectedMonth = parseInt(monthYear.getAttribute("data-month") || 0);
        const selectedYear = parseInt(monthYear.getAttribute("data-year") || 0);

        monthArray.forEach((month, index) => {
            let option = document.createElement("option");
            option.textContent = month;
            option.value = index;
            option.selected = index === selectedMonth;
            calendarMonths.appendChild(option);
        });

        const currentYear = new Date().getFullYear();
        const startYear = currentYear - 60;
        const endYear = currentYear + 60;
        let newYear = startYear;
        while (newYear <= endYear) {
            let option = document.createElement("option");
            option.textContent = newYear;
            option.value = newYear;
            option.selected = newYear === selectedYear;
            calendarYears.appendChild(option);
            newYear++;
        }

        const leftArrow = document.getElementsByClassName("calendar-left-arrow")[0];

        leftArrow.addEventListener("click", () => {
            const monthYear = document.getElementsByClassName("calendar-month-year")[0];
            const month = parseInt(monthYear.getAttribute("data-month") || 0);
            const year = parseInt(monthYear.getAttribute("data-year") || 0);

            let newMonth = month === 0 ? 11 : month - 1;
            let newYear = month === 0 ? year - 1 : year;
            let newDate = new Date(newYear, newMonth, 1);
            generateCalendarDays(newDate);
        });

        const rightArrow = document.getElementsByClassName("calendar-right-arrow")[0];

        rightArrow.addEventListener("click", () => {
            const monthYear = document.getElementsByClassName("calendar-month-year")[0];
            const month = parseInt(monthYear.getAttribute("data-month") || 0);
            const year = parseInt(monthYear.getAttribute("data-year") || 0);
            let newMonth = month + 1;
            newMonth = newMonth === 12 ? 0 : newMonth;
            let newYear = newMonth === 0 ? year + 1 : year;
            let newDate = new Date(newYear, newMonth, 1);
            generateCalendarDays(newDate);
        });

        calendarMonths.addEventListener("change", function () {
            let newDate = new Date(calendarYears.value, calendarMonths.value, 1);
            generateCalendarDays(newDate);
        });

        calendarYears.addEventListener("change", function () {
            let newDate = new Date(calendarYears.value, calendarMonths.value, 1);
            generateCalendarDays(newDate);
        });
        };

        function generateCalendarDays(currentDate) {
        const newDate = new Date(currentDate);
        const year = newDate.getFullYear();
        const month = newDate.getMonth();
        const totalDaysInMonth = getTotalDaysInAMonth(year, month);
        const firstDayOfWeek = getFirstDayOfWeek(year, month);
        let calendarDays = document.getElementsByClassName("calendar-days")[0];

        removeAllChildren(calendarDays);

        let firstDay = 1;
        while (firstDay <= firstDayOfWeek) {
            let li = document.createElement("li");
            li.classList.add("calendar-day");
            calendarDays.appendChild(li);
            firstDay++;
        }

        let day = 1;
        while (day <= totalDaysInMonth) {
            let li = document.createElement("li");
            li.textContent = day;
            li.classList.add("calendar-day");
            if (todaysDate === day && currentMonth === month && currentYear === year) {
            li.classList.add("calendar-day-active");
            }
            calendarDays.appendChild(li);
            day++;
        }

        const monthYear = document.getElementsByClassName("calendar-month-year")[0];
        monthYear.setAttribute("data-month", month);
        monthYear.setAttribute("data-year", year);
        const calendarMonths = document.getElementsByClassName("calendar-months")[0];
        const calendarYears = document.getElementsByClassName("calendar-years")[0];
        calendarMonths.value = month;
        calendarYears.value = year;
        }

        function getTotalDaysInAMonth(year, month) {
        return new Date(year, month + 1, 0).getDate();
        }

        function getFirstDayOfWeek(year, month) {
        return new Date(year, month, 1).getDay();
        }

        function removeAllChildren(parent) {
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
        }

    </script>
    <style>

        .calendar-container {
        /* height: auto; */
        /* width: 400px; */
        background-color: rgba(32, 32, 32, 0.5);
        border-radius: 10px;
        box-shadow: 0px 0px 2px rgba(255, 255, 255, 0.4);
        /* padding: 20px 20px; */
        }

        .calendar-week {
        display: flex;
        list-style: none;
        align-items: center;
        padding-inline-start: 0px;
        }

        .calendar-week-day {
            width: 100%;
            text-align: center;
            color: #525659;
        }

        .calendar-days {
            list-style: none;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
            padding-inline-start: 0px;
        }

        .calendar-day {
            text-align: center;
            color: #525659;
            padding: 0.2rem;
        }

        .calendar-month-arrow-container {
            /* display: flex; */
            align-items: center;
            justify-content: space-between;
        }

        .calendar-month-year-container {
            /* padding: 10px 10px 20px 10px; */
            color: #525659;
            cursor: pointer;
        }

        .calendar-arrow-container {
            /* margin-top: -5px; */
        }

        .calendar-left-arrow,
        .calendar-right-arrow {
            height: 1.2rem;
            width: 1.2rem;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            color: #030303;
        }

        .calendar-today-button {
        margin-top: -10px;
        border-radius: 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        color: #525659;
        padding: 5px 10px;
        display: none;
        }

        .calendar-today-button {
        height: 27px;
        margin-right: 10px;
        background-color: #ec7625;
        color: white;
        }

        .calendar-months,
        .calendar-years {
            flex: 1;
            border-radius: 10px;
            height: 30px;
            border: none;
            cursor: pointer;
            outline: none;
            color: #525659;
            font-size: 15px;
            font-weight: bold;
            background: none;
        }

        .calendar-day-active {
        background-color: #000;
        color: white;
        border-radius: 100%;
        }
    </style>
</div>
{{--  --}}
