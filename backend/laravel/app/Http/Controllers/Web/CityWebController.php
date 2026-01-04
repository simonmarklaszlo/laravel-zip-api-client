<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\County;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CityWebController extends Controller
{
    public function index(Request $request)
    {
        $counties = County::orderBy('name')->get();

        $selectedCounty = $request->input('county_id');
        $letter = $request->input('letter');

        $citiesQuery = City::with(['county', 'zipcodes']);

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

    public function exportCsv(Request $request)
    {
        $selectedCounty = $request->input('county_id');
        $letter = $request->input('letter');

        $citiesQuery = City::with(['county', 'zipcodes']);

        if ($selectedCounty) {
            $citiesQuery->where('county_id', $selectedCounty);
        }

        if ($letter) {
            $citiesQuery->where('name', 'LIKE', $letter . '%');
        }

        $cities = $citiesQuery->orderBy('name')->get();

        $fileName = 'varosok_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($cities) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($file, ['ID', 'Város neve', 'Megye', 'Irányítószámok'], ';');

            // Data rows
            foreach ($cities as $city) {
                $zipcodes = $city->zipcodes->pluck('zipcode')->implode(', ');
                fputcsv($file, [
                    $city->id,
                    $city->name,
                    $city->county->name ?? '',
                    $zipcodes ?: '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $selectedCounty = $request->input('county_id');
        $letter = $request->input('letter');

        $citiesQuery = City::with(['county', 'zipcodes']);

        if ($selectedCounty) {
            $citiesQuery->where('county_id', $selectedCounty);
        }

        if ($letter) {
            $citiesQuery->where('name', 'LIKE', $letter . '%');
        }

        $cities = $citiesQuery->orderBy('name')->get();

        // Get county name for title
        $countyName = 'Összes megye';
        if ($selectedCounty) {
            $county = County::find($selectedCounty);
            $countyName = $county ? $county->name : 'Ismeretlen megye';
        }

        $data = [
            'cities' => $cities,
            'countyName' => $countyName,
            'letter' => $letter,
            'generatedAt' => date('Y-m-d H:i:s')
        ];

        $pdf = Pdf::loadView('cities.pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('varosok_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
