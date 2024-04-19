@php
$date = date_create($journey->date);
$fdate = date_format($date,'l jS \o\f F Y');


@endphp
    <li class='w-5/6'>
        <a href="{{ route('journeys.show', $journey->id ) }}">
            <div class='py-3 px-5 my-2 text-lg flex items-center justify-between gap-5 border-2 border-green-600 shadow-md rounded duration-200 hover:bg-green-100'>
                <div>
                    {{ __("$journey->distance km on $fdate") }}<br>
                    {{ __("Saved " . $journey->max_co2 - $journey->co2_emissions . " kg of CO2") }}
                </div>
                <div>
                    <i class="fa-solid {{ $journey->method->icon_name }} fa-2xl" style="color:rgb(22 163 74);"></i>
                </div>
            </div>
        </a>
    </li>