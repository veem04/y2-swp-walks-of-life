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