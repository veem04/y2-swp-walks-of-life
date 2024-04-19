<x-app-layout>
    {{-- <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <link href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" rel="stylesheet"/> --}}

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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="font-semibold text-xl px-6 py-4 text-gray-900">
                    {{ __("Log a journey") }}
                </div>
                <form action="{{ route('journeys.store') }}" method="post" class="px-6">
                    @csrf

                    <div class="w-full flex justify-around items-center my-4">
                        <div class="flex flex-col gap-2">
                            <div class="text-lg font-medium">Starting position</div>
                            <div id="map1" style="width:400px; height:400px;"></div>
                        </div>
                        <i class="fa-solid fa-arrow-right-long fa-2xl"></i>
                        <div class="flex flex-col gap-2">
                            <div class="text-lg font-medium">Ending position</div>
                            <div id="map2" style="width:400px; height:400px;"></div>
                        </div>
                    </div>


                    <input name="start_lat" id="start_lat" type="hidden" />
                    <input name="start_lng" id="start_lng" type="hidden" />

                    <input name="end_lat" id="end_lat" type="hidden" />
                    <input name="end_lng" id="end_lng" type="hidden" />

                    <div>
                        <label for="method">Method</label>
                        <select 
                        name="method" id="method" 
                        class="block rounded @error('method') is-invalid @enderror"
                        >
                            @forelse ($methods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @empty
                                <option value="" disabled>No methods found.</option>
                            @endforelse
                        </select>
                        @error('method')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <button type="submit" class="px-3 py-3 my-3 font-medium text-white bg-my-green rounded-md duration-200 hover:bg-green-700">Submit</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    var map1 = L.map('map1', {doubleClickZoom: false}).locate({setView: true, maxZoom: 16});

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map1);

    let marker = null;
    map1.on('dblclick', function (e) {
        if (marker !== null) {
            map1.removeLayer(marker);
        }
        document.getElementById('start_lat').value = e.latlng.lat;
        document.getElementById('start_lng').value = e.latlng.lng;
        marker = L.marker(e.latlng).addTo(map1);
    });



    var map2 = L.map('map2', {doubleClickZoom: false}).locate({setView: true, maxZoom: 16});

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map2);

    let marker2 = null;
    map2.on('dblclick', function (e) {
        if (marker2 !== null) {
            map2.removeLayer(marker2);
        }
        document.getElementById('end_lat').value = e.latlng.lat;
        document.getElementById('end_lng').value = e.latlng.lng;
        marker2 = L.marker(e.latlng).addTo(map2);
    });
</script>