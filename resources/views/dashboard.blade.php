<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-xl font-medium px-6 py-4 text-gray-900">
                    {{ __("Welcome back, " . Auth::user()->name . "!") }}
                </div>
                <div class="px-6 py-2 text-gray-900">
                    {{ __("Over the past two weeks, you saved " . $saved_last_two_weeks . "kg of CO2 emissions.") }}
                </div>
                <div class="px-6 py-2 mb-4 text-gray-900">
                    {{ __("Want to save more?") }}
                    <a href='{{ route('journeys.create') }}' class='px-3 py-3 ml-2 font-medium text-white bg-my-green rounded-md duration-200 hover:bg-green-700'>Log a journey</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-5">
                <div class="text-xl px-6 font-medium py-4 text-gray-900">
                    {{ __("Your most recent journeys") }}
                </div>
                @if (sizeof($journeys) === 0)
                    <div class="px-6 pb-6 text-gray-900">
                        {{ __("No journeys found.") }}
                    </div>
                @else
                    <ul class='flex flex-col place-items-center mb-5'>
                        @foreach ($journeys as $journey)
                            <x-journey-link :journey="$journey" />
                        @endforeach
                    </ul>
                    <div class="flex flex-col place-items-center">
                        <div class='w-5/6 mb-5'>
                            <a href='{{ route('journeys.create') }}' class='px-3 py-3 font-medium text-white bg-my-green rounded-md duration-200 hover:bg-green-700'>Log a journey</a>
                        </div>
                    </div>
                @endif
                
                
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-5">
                <div class="text-xl px-6 font-medium py-4 text-gray-900">
                    {{ __("Your friends that saved the most") }}
                </div>
                <div class="text-red-600 px-6 pb-6 font-medium">
                    can't get this to work right now. problems in dashboardcontroller
                </div>
                {{-- <ul class='my-6 flex flex-col place-items-center'>
                    @php
                        $count = 0;
                    @endphp
                    @forelse ($friends as $friend)
                    @php
                        $count += 1;
                    @endphp
                        <li class='w-5/6'>
                            <a href="#">
                                <x-user-link :user="$friend" :count="$count" />
                            </a>
                        </li>
                    @empty
                    <div class="px-6 py-3 text-gray-900">
                        {{ __("No friends have submitted journeys in the past 2 weeks.") }}
                    </div>
                    @endforelse
                    {{ $friends->links() }}
                </ul> --}}
                
            </div>


        </div>
    </div>
</x-app-layout>
