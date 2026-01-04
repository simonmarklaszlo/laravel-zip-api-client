<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Városok listája - {{ $countyName }}</title>
    <style>
        @page {
            margin: 100px 50px 80px 50px;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            color: #333;
        }
        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 60px;
            background-color: #f8f9fa;
            border-bottom: 3px solid #007bff;
            padding: 10px 20px;
        }
        .logo-container {
            float: left;
            width: 100px;
        }
        .header-title {
            float: left;
            margin-left: 20px;
            margin-top: 5px;
        }
        .header-title h1 {
            margin: 0;
            font-size: 18pt;
            color: #007bff;
        }
        .header-title p {
            margin: 5px 0 0 0;
            font-size: 9pt;
            color: #666;
        }
        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 40px;
            background-color: #f8f9fa;
            border-top: 2px solid #007bff;
            padding: 10px 20px;
            font-size: 8pt;
            color: #666;
        }
        .page-number:before {
            content: counter(page);
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th {
            background-color: #007bff;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #0056b3;
        }
        table td {
            padding: 6px 8px;
            border: 1px solid #dee2e6;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .filter-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
        }
        .filter-info strong {
            color: #007bff;
        }
    </style>
</head>
<body>
    <header class="clearfix">
        <div class="logo-container">
            <!-- SVG logo - simple Hungarian flag inspired design -->
            <svg width="80" height="50" viewBox="0 0 80 50" xmlns="http://www.w3.org/2000/svg">
                <rect width="80" height="16.67" fill="#CD2A3E"/>
                <rect y="16.67" width="80" height="16.67" fill="#FFFFFF"/>
                <rect y="33.34" width="80" height="16.67" fill="#436F4D"/>
            </svg>
        </div>
        <div class="header-title">
            <h1>Városok Listája</h1>
            <p>Magyar Települések Nyilvántartása</p>
        </div>
    </header>

    <footer>
        <div style="float: left;">
            Generálva: {{ $generatedAt }}
        </div>
        <div style="float: right;">
            Oldal: <span class="page-number"></span>
        </div>
    </footer>

    <main>
        <div class="filter-info">
            <strong>Megye:</strong> {{ $countyName }}
            @if($letter)
                <br><strong>Kezdőbetű:</strong> {{ $letter }}
            @endif
        </div>

        @if($cities->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">ID</th>
                        <th style="width: 25%;">Város neve</th>
                        <th style="width: 25%;">Megye</th>
                        <th style="width: 42%;">Irányítószámok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cities as $city)
                        <tr>
                            <td>{{ $city->id }}</td>
                            <td>{{ $city->name }}</td>
                            <td>{{ $city->county->name ?? '' }}</td>
                            <td>{{ $city->zipcodes->pluck('zipcode')->implode(', ') ?: '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Nincs megjeleníthető város a kiválasztott szűrési feltételekkel.</p>
        @endif
    </main>
</body>
</html>

