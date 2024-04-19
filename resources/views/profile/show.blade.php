<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full flex flex-col items-center gap-2">
                    <img 
                    src="{{ asset('storage/images/'.$user->image) }}" 
                    alt="" 
                    style="width:20%;">
                    <div class="text-2xl font-medium">
                        {{ $user->name }}
                    </div>
                    @if ($user->bio)
                        <div>
                            {{ $user->bio }}
                        </div>
                    @endif
                </div>

                <div class="px-6 text-2xl font-medium text-gray-900">
                    {{ $user->name }}'s journeys
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
