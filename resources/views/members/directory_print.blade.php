<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orodha Rasmi ya Waumini - {{ $church ? $church->name : 'Kanisa' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1e293b;
            background: #fff;
            padding: 24px;
        }
        .directory-card {
            max-width: 1020px;
            margin: 0 auto;
            border: 1px solid #cbd5e1;
            padding: 32px;
            background: #ffffff;
        }
        .church-title {
            color: #1e3a8a;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 20px;
            margin-bottom: 4px;
        }
        .table th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 11px;
            text-transform: uppercase;
        }
        .table td {
            font-size: 13px;
        }
        @media print {
            body { padding: 0; }
            .directory-card { border: none; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="directory-card">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="{{ route('members.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Mfumo
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm px-4">
                <i class="bi bi-printer me-1"></i> Chapisha / Hifadhi kama PDF
            </button>
        </div>

        <div class="text-center border-bottom pb-3 mb-4">
            <div class="church-title">{{ $church ? $church->name : 'EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT)' }}</div>
            <div class="text-muted small">{{ $church ? $church->tagline : 'Golani, Kimara-Suka - Dar es Salaam' }}</div>
            <h5 class="fw-bold mt-2 text-dark">ORODHA RASMI YA WASHIRIKA WA KANISA (MEMBERS DIRECTORY)</h5>
            <div class="badge bg-primary px-3 py-2">Jumla ya Waumini: {{ $members->count() }}</div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nambari</th>
                        <th>Jina Kamili</th>
                        <th>Jinsia</th>
                        <th>Namba ya Simu</th>
                        <th>Mtaa / Makazi</th>
                        <th>Ubatizo</th>
                        <th>Idara</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $idx => $m)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td><code>{{ $m->member_number }}</code></td>
                            <td class="fw-bold">{{ $m->full_name }}</td>
                            <td>{{ $m->gender == 'Male' ? 'Mwanaume' : 'Mwanamke' }}</td>
                            <td>{{ $m->phone ?? '-' }}</td>
                            <td>{{ $m->residential_address ?? '-' }}</td>
                            <td>
                                @if($m->baptism_status == 'Baptized')
                                    <span class="text-success"><i class="bi bi-check-circle me-1"></i>Amebatizwa</span>
                                @else
                                    <span class="text-muted">Bado</span>
                                @endif
                            </td>
                            <td>
                                {{ $m->departments->pluck('name')->implode(', ') ?: '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row text-center mt-5">
            <div class="col-6">
                <div style="border-top: 1px dashed #94a3b8; padding-top: 8px; margin-top: 48px; font-size: 13px;">
                    <strong>Katibu wa Kanisa</strong><br>
                    Tarehe & Saini
                </div>
            </div>
            <div class="col-6">
                <div style="border-top: 1px dashed #94a3b8; padding-top: 8px; margin-top: 48px; font-size: 13px;">
                    <strong>Mchungaji Kiongozi</strong><br>
                    Tarehe & Muhuri
                </div>
            </div>
        </div>
    </div>
</body>
</html>
