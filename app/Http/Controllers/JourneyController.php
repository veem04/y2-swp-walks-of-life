<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Method;
use Illuminate\Http\Request;
use Auth;

class JourneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journeys = Auth::user()->journeys()->orderBy('created_at', 'desc')->paginate(8);

        return view("journeys.index", [
            'journeys' => $journeys
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $methods = Method::orderBy('co2_constant', 'asc')->get();
        return view("journeys.create", [
            'methods' => $methods
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'start_lat' => 'required|numeric|min:-90|max:90',
            'end_lat' => 'required|numeric|min:-90|max:90',
            'start_lng' => 'required|numeric|min:-180|max:180',
            'end_lng' => 'required|numeric|min:-180|max:180',
            'method' => 'required|integer|exists:methods,id'
        ];

        $request->validate($rules);

        $journey = new Journey;
        $journey->start_lat = $request->start_lat;
        $journey->end_lat = $request->end_lat;
        $journey->start_lng = $request->start_lng;
        $journey->end_lng = $request->end_lng;
        $journey->date = date('Y-m-d');
        

        $coordsString = "[[$journey->start_lng,$journey->start_lat],[$journey->end_lng,$journey->end_lat]]";

        // start API call
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/driving-car/json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":' . $coordsString . ',"instructions":"false","geometry":"false"}');

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
        "Authorization: " . env('ORS_API_KEY'),
        "Content-Type: application/json; charset=utf-8"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        // end API call

        $routeDetails = json_decode($response);
        
        if(isset($routeDetails->routes[0]->summary->distance)){
            $journey->distance = $routeDetails->routes[0]->summary->distance / 1000;
        }else{
            return redirect()
                ->route('journeys.create')
                ->with('status', 'The distance between the points could not be calculated.');
        }

        $journey->method_id = $request->method;

        // this estimation is based off a Gasoline-Powered Ford F-150
        // https://earth911.com/eco-tech/carbon-calculating-getting-an-accurate-measure-of-carbon-emissions-from-driving/
        $dist_in_miles = $journey->distance / 1.6;
        $mpg = 19; // 19 miles per gallon
        $carbon_content = 8.88; // 8.88kg per gallon
        $gallons = $dist_in_miles / $mpg;
        $max_co2 = $gallons * $carbon_content;
        $journey->max_co2 = $max_co2;

        $method = Method::findOrFail($journey->method_id);
        $journey->co2_emissions = $max_co2 * $method->co2_constant;
        
        $journey->cost = 0;
        $journey->user_id = Auth::user()->id;
        
        // dd($journey);
        $journey->save();

        return redirect()
            ->route('journeys.index')
            ->with('status', 'Journey added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Journey $journey)
    {
        $method = Method::findOrFail($journey->method_id);
        return view('journeys.view', [
            'journey' => $journey,
            'method' => $method
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journey $journey)
    {
        if($journey->user->id !== Auth::id())
        {
            return redirect()
                ->route('journeys.index')
                ->with('status', 'You cannot edit another user\'s journeys!');
        }

        $methods = Method::orderBy('co2_constant', 'asc')->get();
        return view("journeys.edit", [
            'journey' => $journey,
            'methods' => $methods
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journey $journey)
    {
        if($journey->user->id !== Auth::id())
        {
            return redirect()
                ->route('journeys.index')
                ->with('status', 'You cannot edit another user\'s journeys!');
        }

        $rules = [
            'start_lat' => 'required|numeric|min:-90|max:90',
            'end_lat' => 'required|numeric|min:-90|max:90',
            'start_lng' => 'required|numeric|min:-180|max:180',
            'end_lng' => 'required|numeric|min:-180|max:180',
            'method' => 'required|integer|exists:methods,id'
        ];

        $request->validate($rules);

        $journey->start_lat = $request->start_lat;
        $journey->end_lat = $request->end_lat;
        $journey->start_lng = $request->start_lng;
        $journey->end_lng = $request->end_lng;
        
        $coordsString = "[[$journey->start_lng,$journey->start_lat],[$journey->end_lng,$journey->end_lat]]";

        // start API call
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/driving-car/json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":' . $coordsString . ',"instructions":"false","geometry":"false"}');

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
        "Authorization: " . env('ORS_API_KEY'),
        "Content-Type: application/json; charset=utf-8"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        // end API call

        $routeDetails = json_decode($response);

        if(isset($routeDetails->routes[0]->summary->distance)){
            $journey->distance = $routeDetails->routes[0]->summary->distance / 1000;
        }else{
            return redirect()
                ->route('journeys.edit', $journey->id)
                ->with('status', 'The distance between the points could not be calculated.');
        }
        
        $journey->method_id = $request->method;

        // this estimation is based off a Gasoline-Powered Ford F-150
        // https://earth911.com/eco-tech/carbon-calculating-getting-an-accurate-measure-of-carbon-emissions-from-driving/
        $dist_in_miles = $journey->distance / 1.6;
        $mpg = 19; // 19 miles per gallon
        $carbon_content = 8.88; // 8.88kg per gallon
        $gallons = $dist_in_miles / $mpg;
        $max_co2 = $gallons * $carbon_content;
        $journey->max_co2 = $max_co2;

        $method = Method::findOrFail($journey->method_id);
        $journey->co2_emissions = $max_co2 * $method->co2_constant;

        $journey->cost = 0;

        $journey->save();

        return redirect()
            ->route('journeys.index')
            ->with('status', 'Journey edited successfully!');
        // dd($request);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journey $journey)
    {
        if($journey->user->id !== Auth::id())
        {
            return redirect()
                ->route('journeys.index')
                ->with('status', 'You cannot edit another user\'s journeys!');
        }

        $journey->delete();
        return redirect()
            ->route('journeys.index')
            ->with('status', 'Deleted a journey successfully!');
    }
}
