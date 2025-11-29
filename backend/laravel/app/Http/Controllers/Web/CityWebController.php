<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\County;
use Illuminate\Http\Request;

class CityWebController extends Controller
{
    public function index(Request $request)
    {
        $counties = County::orderBy('name')->get();

        $selectedCounty = $request->input('county_id');
        $letter = $request->input('letter');

        $citiesQuery = City::with('county');

        if ($selectedCounty) {
            $citiesQuery->where('county_id', $selectedCounty);
        }

        if ($letter) {
            $citiesQuery->where('name', 'LIKE', $letter . '%');
        }

        $cities = $citiesQuery->orderBy('name')->get();

        $letters = range('A', 'Z');

        return view('cities.index', [
            'counties' => $counties,
            'cities' => $cities,
            'letters' => $letters,
            'selectedCounty' => $selectedCounty,
            'selectedLetter' => $letter,
        ]);
    }

    public function filter(Request $request)
    {
        return redirect()->route('cities.index', [
            'county_id' => $request->input('county_id'),
            'letter' => $request->input('letter'),
        ]);
    }
}
