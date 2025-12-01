@extends('layouts.app')

@section('title', 'Városok listája')

@section('content')
    <h1>Városok listája</h1>

    <form method="GET" action="{{ route('cities.index') }}" style="margin-bottom: 1rem;">
        <label for="county_id">Megye:</label>
        <select name="county_id" id="county_id" onchange="this.form.submit()">
            <option value="">-- Válassz megyét --</option>
            @foreach($counties as $county)
                <option value="{{ $county->id }}" {{ $selectedCounty == $county->id ? 'selected' : '' }}>
                    {{ $county->name }}
                </option>
            @endforeach
        </select>

        <input type="hidden" name="letter" id="letter" value="{{ $selectedLetter }}">
    </form>

    @if($selectedCounty)
        <div style="margin-bottom: 1rem;">
            <strong>Szűrés kezdőbetű szerint:</strong>
            @foreach($letters as $ltr)
                @php
                    $isActive = $selectedLetter === $ltr;
                @endphp
                <a href="{{ route('cities.index', ['county_id' => $selectedCounty, 'letter' => $ltr]) }}"
                   style="margin-right: 0.5rem; {{ $isActive ? 'font-weight:bold; text-decoration:underline;' : '' }}">
                    {{ $ltr }}
                </a>
            @endforeach
            <a href="{{ route('cities.index', ['county_id' => $selectedCounty]) }}" style="margin-left: 1rem;">
                (Összes)
            </a>
        </div>
    @else
        <p>Először válassz egy megyét a lenyíló listából.</p>
    @endif

    <table style="border:1px solid #000;border-collapse:collapse;width:100%;">
        <thead>
        <tr>
            <th style="border:1px solid #000;padding:5px;text-align:left;">ID</th>
            <th style="border:1px solid #000;padding:5px;text-align:left;">Név</th>
            <th style="border:1px solid #000;padding:5px;text-align:left;">Megye</th>
            <th style="border:1px solid #000;padding:5px;text-align:left;">Irányítószámok</th>
        </tr>
        </thead>
        <tbody>
        @forelse($cities as $city)
            <tr>
                <td style="border:1px solid #000;padding:5px;">{{ $city->id }}</td>
                <td style="border:1px solid #000;padding:5px;">{{ $city->name }}</td>
                <td style="border:1px solid #000;padding:5px;">{{ $city->county->name ?? '' }}</td>
                <td style="border:1px solid #000;padding:5px;">{{ $city->zipcodes->pluck('zipcode')->implode(', ') ?: '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="border:1px solid #000;padding:5px;">Nincs megjeleníthető város.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
