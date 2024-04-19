<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

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
                <div class="flex gap-4">
                    <div id="map" style="width:400px; height:400px;"></div>
                    <div class="py-3 text-gray-900">
                        {{ __("Emissions: $journey->co2_emissions kg") }}<br />
                        {{ __("Emissions saved: " . $journey->max_co2 - $journey->co2_emissions  ."kg") }}<br />
                        {{ __("Travel distance: $journey->distance km") }}<br />
                        {{-- {{ __("starting position: $journey->start_lat, $journey->start_lng") }}<br />
                        {{ __("ending position: $journey->end_lat, $journey->end_lng") }}<br /> --}}
                        {{ __("method: $method->name ") }}
                    </div>
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

    <script>
        startlatlng = {
            lat: {{ $journey->start_lat }},
            lng: {{ $journey->start_lng }},
        };
        endlatlng = {
            lat: {{ $journey->end_lat }},
            lng: {{ $journey->end_lng }},
        };

        let avgLat = (startlatlng.lat + endlatlng.lat) / 2;
        let avgLng = (startlatlng.lng + endlatlng.lng) / 2;

        var map = L.map('map', {doubleClickZoom: false}).setView([avgLat,avgLng], 12);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        
        let marker1 = L.marker(startlatlng).addTo(map);
        let marker2 = L.marker(endlatlng).addTo(map);
    </script>
</x-app-layout>
