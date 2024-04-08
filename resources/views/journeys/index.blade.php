<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="font-medium text-2xl px-6 py-4 text-gray-900">
                    {{ __("My Journeys") }}
                </div>
                <div class="px-6 py-3 text-gray-900">
                    {{ __("Let's take a look at how much you've saved!") }}
                </div>

                <div class='mx-6 my-4'>
                    <a href='{{ route('journeys.create') }}' class='px-3 py-3 font-medium text-white bg-my-green rounded-md duration-200 hover:bg-green-700'>Log a journey</a>
                </div>

                <ul class='my-6 flex flex-col place-items-center'>
                    @forelse ($journeys as $journey)
                    @php
                    $date = date_create($journey->date);
                    $fdate = date_format($date,'l jS \o\f F Y');
                    @endphp
                        <li class='w-5/6'>
                            <a href="{{ route('journeys.show', $journey->id ) }}">
                                <div class='p-3 my-2 text-lg border-2 border-green-600 shadow-md rounded duration-200 hover:bg-green-100'>
                                    {{ __("$journey->distance km on $fdate") }}<br>
                                    {{ __("Saved " . $journey->max_co2 - $journey->co2_emissions . " kg of CO2") }}
                                </div>
                            </a>
                            
                        </li>
                    @empty
                    <div class="px-6 py-3 text-gray-900">
                        {{ __("No journeys found.") }}
                    </div>
                    @endforelse
                    {{ $journeys->links() }}
                </ul>
                
            </div>
        </div>
    </div>
</x-app-layout>
