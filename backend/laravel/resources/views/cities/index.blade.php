@extends('layouts.app')

@section('title', 'Városok listája')

@section('content')
    <style>
        .filter-section {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        .letters-container {
            margin: 1rem 0;
            padding: 1rem;
            background-color: #e7f3ff;
            border-radius: 5px;
        }
        .letter-link {
            display: inline-block;
            margin: 0.25rem;
            padding: 0.5rem 0.75rem;
            background-color: white;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #007bff;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .letter-link:hover {
            background-color: #007bff;
            color: white;
        }
        .letter-link.active {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .export-section {
            margin: 1rem 0;
            padding: 1rem;
            background-color: #f0f8ff;
            border-left: 4px solid #28a745;
            border-radius: 5px;
        }
        .export-btn {
            margin-left: 1rem;
            padding: 0.5rem 1.25rem;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
            transition: all 0.3s;
        }
        .export-btn.csv {
            background-color: #28a745;
            color: white;
        }
        .export-btn.csv:hover {
            background-color: #218838;
        }
        .export-btn.pdf {
            background-color: #dc3545;
            color: white;
        }
        .export-btn.pdf:hover {
            background-color: #c82333;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .data-table th {
            background-color: #007bff;
            color: white;
            padding: 0.75rem;
            text-align: left;
            font-weight: bold;
            border: 1px solid #0056b3;
        }
        .data-table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .data-table tr:hover {
            background-color: #e7f3ff;
        }
        .info-message {
            padding: 1rem;
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            color: #856404;
            border-radius: 4px;
        }
    </style>

    <h1>Városok listája</h1>

    <div class="filter-section">
        <form method="GET" action="{{ route('cities.index') }}">
            <label for="county_id">Megye kiválasztása:</label>
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
    </div>

    @if($selectedCounty)
        <div class="letters-container">
            <strong style="display: block; margin-bottom: 0.5rem;">📋 Szűrés kezdőbetű szerint:</strong>
            @foreach($letters as $ltr)
                @php
                    $isActive = $selectedLetter === $ltr;
                @endphp
                <a href="{{ route('cities.index', ['county_id' => $selectedCounty, 'letter' => $ltr]) }}"
                   class="letter-link {{ $isActive ? 'active' : '' }}">
                    {{ $ltr }}
                </a>
            @endforeach
            <a href="{{ route('cities.index', ['county_id' => $selectedCounty]) }}"
               class="letter-link"
               style="margin-left: 1rem; background-color: #6c757d; color: white; border-color: #6c757d;">
                Összes
            </a>
        </div>

        @if($cities->count() > 0)
            <div class="export-section">
                <strong>💾 Exportálás:</strong>
                <a href="{{ route('cities.export.csv', ['county_id' => $selectedCounty, 'letter' => $selectedLetter]) }}"
                   class="export-btn csv">
                    📊 CSV letöltése
                </a>
                <a href="{{ route('cities.export.pdf', ['county_id' => $selectedCounty, 'letter' => $selectedLetter]) }}"
                   class="export-btn pdf">
                    📄 PDF letöltése
                </a>
            </div>
        @endif
    @else
        <p class="info-message">
            ℹ️ Először válassz egy megyét a lenyíló listából a városok megjelenítéséhez.
        </p>
    @endif

    <table class="data-table">
        <thead>
        <tr>
            <th style="width: 8%;">ID</th>
            <th style="width: 25%;">Név</th>
            <th style="width: 25%;">Megye</th>
            <th style="width: 42%;">Irányítószámok</th>
        </tr>
        </thead>
        <tbody>
        @forelse($cities as $city)
            <tr>
                <td>{{ $city->id }}</td>
                <td><strong>{{ $city->name }}</strong></td>
                <td>{{ $city->county->name ?? '' }}</td>
                <td>{{ $city->zipcodes->pluck('zipcode')->implode(', ') ?: '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 2rem; color: #6c757d;">
                    Nincs megjeleníthető város a kiválasztott szűrési feltételekkel.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
