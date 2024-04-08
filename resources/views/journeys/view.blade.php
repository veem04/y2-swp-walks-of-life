<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6">
                <div class="font-semibold text-xl py-4 text-gray-900">
                    {{ __("Journey View") }}
                </div>
                <div class="py-3 text-gray-900">
                    {{ __("emissions: $journey->co2_emissions") }}<br />
                    {{ __("starting position: $journey->start_lat, $journey->start_lng") }}<br />
                    {{ __("ending position: $journey->end_lat, $journey->end_lng") }}<br />
                    {{ __("method: $method->name ") }}
                </div>
                <div class="mb-5 mt-3 flex">
                    <a href="{{ route('journeys.edit', $journey ) }}" class="px-3 py-3 mr-5 font-medium text-white bg-my-green rounded-md duration-200 hover:bg-green-700">
                        Edit this journey
                    </a>
                    <form 
                    action="{{ route('journeys.destroy', $journey) }}" 
                    onsubmit="return confirm('Are you sure you want to delete this journey? This action is irreversible.');"
                    method="POST">
                        @csrf()
                        @method('DELETE')
                        <button 
                        type="submit"
                        class="px-3 py-3 font-medium text-white bg-red-400 rounded-md duration-200 hover:bg-red-700">
                            Delete this journey
                        </button>
                    </form>

                    {{-- <a href="{{ route('journeys.destroy', $journey ) }}" class="px-3 py-3 font-medium text-white bg-red-400 rounded-md duration-200 hover:bg-red-700">
                        
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
