<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ripoti ya Mahudhurio ya Ibada - {{ $church ? $church->name : 'Kanisa' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.css') }}">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1e293b; background: #fff; padding: 24px; }
        .print-card { max-width: 960px; margin: 0 auto; border: 1px solid #cbd5e1; padding: 32px; background: #fff; }
        .church-title { color: #1e3a8a; font-weight: 800; text-transform: uppercase; font-size: 20px; }
        .table th { background: #f8fafc; font-size: 11px; text-transform: uppercase; }
        @media print {
            body { padding: 0; }
            .print-card { border: none; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="print-card">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Rudi
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm px-4">
                <i class="bi bi-printer me-1"></i> Chapisha / Hifadhi kama PDF
            </button>
        </div>

        <div class="text-center border-bottom pb-3 mb-4">
            <div class="church-title">{{ $church ? $church->name : 'EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT)' }}</div>
            <div class="text-muted small">{{ $church ? $church->tagline : 'Golani, Kimara-Suka - Dar es Salaam' }}</div>
            <h5 class="fw-bold mt-2 text-dark">RIPOTI RASMI YA TAKWIMU NA MAHUDHURIO YA IBADA</h5>
        </div>

        <div class="row g-3 mb-4 text-center">
            <div class="col-3">
                <div class="p-3 bg-light border rounded">
                    <div class="small text-muted">Jumla ya Waliohudhuria</div>
                    <div class="h5 fw-bold text-primary mb-0">{{ number_format($totalOverall) }}</div>
                </div>
            </div>
            <div class="col-3">
                <div class="p-3 bg-light border rounded">
                    <div class="small text-muted">Wanaume / Wanawake</div>
                    <div class="h5 fw-bold text-dark mb-0">{{ number_format($totalMen) }} / {{ number_format($totalWomen) }}</div>
                </div>
            </div>
            <div class="col-3">
                <div class="p-3 bg-light border rounded">
                    <div class="small text-muted">Watoto (Sunday School)</div>
                    <div class="h5 fw-bold text-success mb-0">{{ number_format($totalChildren) }}</div>
                </div>
            </div>
            <div class="col-3">
                <div class="p-3 bg-light border rounded">
                    <div class="small text-muted">Wageni / Waliookoka</div>
                    <div class="h5 fw-bold text-danger mb-0">{{ number_format($totalFirstTimers) }} / {{ number_format($totalConverts) }}</div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>Tarehe</th>
                        <th>Ibada</th>
                        <th class="text-center">Wanaume</th>
                        <th class="text-center">Wanawake</th>
                        <th class="text-center">Watoto</th>
                        <th class="text-center">Jumla</th>
                        <th class="text-center">Wageni</th>
                        <th class="text-center">Waliookoka</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $a)
                        <tr>
                            <td>{{ $a->attendance_date->format('d/m/Y') }}</td>
                            <td>{{ $a->service ? $a->service->title : 'Ibada' }}</td>
                            <td class="text-center">{{ $a->men_count }}</td>
                            <td class="text-center">{{ $a->women_count }}</td>
                            <td class="text-center">{{ $a->children_count }}</td>
                            <td class="text-center fw-bold">{{ $a->total_count }}</td>
                            <td class="text-center text-primary">{{ $a->first_timers_count }}</td>
                            <td class="text-center text-success">{{ $a->new_converts_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row text-center mt-5">
            <div class="col-6">
                <div style="border-top: 1px dashed #94a3b8; padding-top: 8px; margin-top: 48px; font-size: 13px;">
                    <strong>Katibu / Mweka Takwimu</strong><br>
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
