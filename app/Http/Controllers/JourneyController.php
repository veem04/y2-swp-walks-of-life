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
        $journeys = Journey::orderBy('created_at', 'desc')->paginate(8);

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
        $journey->distance = 20;
        $journey->co2_emissions = 0;

        // this estimation is based off a Gasoline-Powered Ford F-150
        // https://earth911.com/eco-tech/carbon-calculating-getting-an-accurate-measure-of-carbon-emissions-from-driving/
        $dist_in_miles = $journey->distance / 1.6;
        $mpg = 19; // 19 miles per gallon
        $carbon_content = 8.88; // 8.88kg per gallon
        $gallons = $dist_in_miles / $mpg;
        $max_co2 = $gallons * $carbon_content;
        $journey->max_co2 = $max_co2;

        $journey->cost = 0;
        $journey->user_id = Auth::user()->id;
        $journey->method_id = $request->method;

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
        // $journey->date = date('Y-m-d');
        $journey->distance = 20;
        $journey->co2_emissions = 0;

        // this estimation is based off a Gasoline-Powered Ford F-150
        // https://earth911.com/eco-tech/carbon-calculating-getting-an-accurate-measure-of-carbon-emissions-from-driving/
        $dist_in_miles = $journey->distance / 1.6;
        $mpg = 19; // 19 miles per gallon
        $carbon_content = 8.88; // 8.88kg per gallon
        $gallons = $dist_in_miles / $mpg;
        $max_co2 = $gallons * $carbon_content;
        $journey->max_co2 = $max_co2;

        $journey->cost = 0;
        $journey->method_id = $request->method;

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
        $journey->delete();
        return redirect()
            ->route('journeys.index')
            ->with('status', 'Deleted a journey successfully!');
    }
}
