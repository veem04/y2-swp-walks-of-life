<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="font-semibold text-xl px-6 py-4 text-gray-900">
                    {{ __("Change journey details") }}
                </div>
                <form action="{{ route('journeys.update', $journey->id) }}" method="post" class="px-6">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center gap-4 my-3">
                        <div class="grow">
                            <label for="start_lat">Starting latitude</label>
                            <input 
                            name="start_lat" id="start_lat" 
                            class="block rounded w-5/6 @error('start_lat') is-invalid @enderror"
                            value="{{ old('start_lat', $journey->start_lat) }}"
                            />
                            @error('start_lat')
                                <div class="text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="grow">
                            <label for="start_lng">Starting longitude</label>
                            <input 
                            name="start_lng" id="start_lng" 
                            class="block rounded w-5/6 @error('start_lng') is-invalid @enderror" 
                            value="{{ old('start_lng', $journey->start_lng) }}"
                            />
                            @error('start_lng')
                                <div class="text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="grow">
                            <button type="button" onclick="getStartLocation()" class="border border-2 aspect-square p-4">
                                <i class="fa-solid fa-location-crosshairs fa-lg"></i>
                            </button>
                            <span id="start_loc_getting" class="text-gray-900"></span>
                        </div>
                    </div>

                    <div class="flex w-3/4 justify-center">
                        <i class="fa-solid fa-arrow-down-long fa-2xl"></i>
                    </div>

                    <div class="flex items-center gap-4 my-3">
                        <div class="grow">
                            <label for="end_lat">Ending latitude</label>
                            <input 
                            name="end_lat" id="end_lat" 
                            class="block rounded w-5/6 @error('end_lat') is-invalid @enderror" 
                            value="{{ old('end_lat', $journey->end_lat) }}"
                            />
                            @error('end_lat')
                                <div class="text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="grow">
                            <label for="end_lng">Ending longitude</label>
                            <input 
                            name="end_lng" id="end_lng" 
                            class="block rounded w-5/6 @error('end_lng') is-invalid @enderror" 
                            value="{{ old('end_lng', $journey->end_lng) }}"
                            />
                            @error('end_lng')
                                <div class="text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="grow">
                            <button type="button" onclick="getEndLocation()" class="border border-2 aspect-square p-4">
                                <i class="fa-solid fa-location-crosshairs fa-lg"></i>
                            </button>
                            <span id="end_loc_getting" class="text-gray-900"></span>
                        </div>
                    </div>

                    <div>
                        <label for="method">Method</label>
                        <select 
                        name="method" id="method" 
                        class="block rounded  @error('method') is-invalid @enderror"
                        >
                            @forelse ($methods as $method)
                                <option 
                                value="{{ $method->id }}"
                                @if (old('method'))
                                {{old('method') == $method->id ? 'selected' : ''}}
                                @else
                                {{$method->id === $journey->method_id ? 'selected' : ''}}
                                @endif
                                >
                                {{ $method->name }}
                                </option>
                            @empty
                                <option value="" disabled>No methods found.</option>
                            @endforelse
                        </select>
                        @error('method')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <button type="submit" class="px-3 py-3 my-3 font-medium text-white bg-my-green rounded-md duration-200 hover:bg-green-800">Submit changes</button>
                </form>
            </div>
        </div>
    </div>
    @fcScripts
</x-app-layout>

<script>
    const start_lat = document.getElementById("start_lat");
    const start_lng = document.getElementById("start_lng");
    const end_lat = document.getElementById("end_lat");
    const end_lng = document.getElementById("end_lng");

    
    function getStartLocation() {
        if (navigator.geolocation) {
            document.getElementById('start_loc_getting').innerHTML = "Getting location...";
            const options = {
                maximumAge: 5*60*1000,
                timeout: 10000
            }
            navigator.geolocation.getCurrentPosition(enterStartPosition, error, options);
        } else {
            console.warn("Geolocation is not supported by this browser.");
        }
    }
    
    function enterStartPosition(position) {
        start_lat.value = position.coords.latitude;
        start_lng.value = position.coords.longitude;
        document.getElementById('start_loc_getting').innerHTML = "";
    }

    function getEndLocation() {
        if (navigator.geolocation) {
            document.getElementById('end_loc_getting').innerHTML = "Getting location...";
            const options = {
                maximumAge: 60000,
                timeout: 10000
            }
            navigator.geolocation.getCurrentPosition(enterEndPosition, error, options);
        } else {
            console.warn("Geolocation is not supported by this browser.");
        }
    }
    
    function enterEndPosition(position) {
        document.getElementById('end_loc_getting').innerHTML = "";
        end_lat.value = position.coords.latitude;
        end_lng.value = position.coords.longitude;
    }

    function error(err){
        console.warn(err.code, err.message)
    }
</script> 