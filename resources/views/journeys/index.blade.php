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
                        <x-journey-link :journey="$journey"/>
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
