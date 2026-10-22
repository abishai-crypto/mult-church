<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taarifa ya Mapato na Matumizi - {{ $church ? $church->name : 'Kanisa' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1e293b;
            background: #fff;
            padding: 24px;
        }
        .statement-card {
            max-width: 960px;
            margin: 0 auto;
            border: 1px solid #cbd5e1;
            padding: 32px;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .header-box {
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .church-title {
            color: #1e3a8a;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 20px;
            margin-bottom: 4px;
        }
        .report-badge {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 13px;
        }
        .table th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
        }
        .summary-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
        }
        .signature-line {
            border-top: 1px dashed #94a3b8;
            padding-top: 8px;
            margin-top: 48px;
            font-size: 13px;
            color: #475569;
        }
        @media print {
            body {
                padding: 0;
            }
            .statement-card {
                border: none;
                box-shadow: none;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="statement-card">
        <!-- Print controls -->
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="{{ route('finances.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Mfumo
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm px-4">
                <i class="bi bi-printer me-1"></i> Chapisha / Hifadhi kama PDF
            </button>
        </div>

        <!-- Official Church Header -->
        <div class="header-box text-center">
            <div class="church-title">{{ $church ? $church->name : 'EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT)' }}</div>
            <div class="text-muted small mb-1">{{ $church ? $church->tagline : 'Golani, Kimara-Suka - Dar es Salaam' }}</div>
            <div class="small text-secondary">{{ $church ? $church->address : 'Tanzania' }} | Simu: {{ $church ? $church->phone : '+255 754 123 456' }}</div>
            <h5 class="fw-bold mt-3 mb-1 text-dark">
                @if($isMember)
                    TAARIFA RASMI YA MICHANGO YA UJENZI NA MATUMIZI YA KANISA
                @else
                    TAARIFA RASMI YA MAPATO NA MATUMIZI YA KANISA
                @endif
            </h5>
            <div class="report-badge d-inline-block mt-2">
                Kipindi: <strong>{{ \Carbon\Carbon::parse($fromDate)->format('d/m/Y') }}</strong> hadi <strong>{{ \Carbon\Carbon::parse($toDate)->format('d/m/Y') }}</strong>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-4">
                <div class="summary-box text-center">
                    <div class="text-muted small text-uppercase">
                        {{ $isMember ? 'Jumla ya Michango ya Miradi' : 'Jumla ya Mapato' }}
                    </div>
                    <div class="h5 fw-bold text-success mb-0">Tsh {{ number_format($totalIncome) }}</div>
                </div>
            </div>
            <div class="col-4">
                <div class="summary-box text-center">
                    <div class="text-muted small text-uppercase">Jumla ya Matumizi</div>
                    <div class="h5 fw-bold text-danger mb-0">Tsh {{ number_format($totalExpense) }}</div>
                </div>
            </div>
            <div class="col-4">
                <div class="summary-box text-center">
                    <div class="text-muted small text-uppercase">Baki Safi (Net Balance)</div>
                    <div class="h5 fw-bold text-primary mb-0">Tsh {{ number_format($netBalance) }}</div>
                </div>
            </div>
        </div>

        <!-- 1. Mapato / Michango iliyothibitishwa -->
        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
            @if($isMember)
                1. MCHANGANUO WA MICHANGO YA UJENZI NA MIRADI
            @else
                1. MCHANGANUO WA MAPATO YALIYOTHIBITISHWA
            @endif
        </h6>
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Tarehe</th>
                        <th>Kumbukumbu</th>
                        <th>Mtoaji / Mshirika</th>
                        <th>{{ $isMember ? 'Aina ya Mchango' : 'Aina ya Sadaka' }}</th>
                        <th>Njia ya Malipo</th>
                        <th class="text-end">Kiasi (Tsh)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                        <tr>
                            <td>{{ $t->transaction_date->format('d/m/Y') }}</td>
                            <td><code>{{ $t->transaction_code }}</code></td>
                            <td>{{ $t->member ? $t->member->full_name : ($t->donor_name ?? 'Mshirika') }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $t->category)) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $t->payment_method)) }}</td>
                            <td class="text-end fw-semibold">{{ number_format($t->amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Hakuna mapato yaliyorekodiwa katika kipindi hiki.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <th colspan="5" class="text-end">JUMLA KUU YA MAPATO:</th>
                        <th class="text-end text-success">Tsh {{ number_format($totalIncome) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- 2. Matumizi yaliyoidhinishwa -->
        <h6 class="fw-bold text-danger border-bottom pb-2 mb-3">2. MCHANGANUO WA MATUMIZI YALIYOIDHINISHWA</h6>
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Tarehe</th>
                        <th>Vocha No.</th>
                        <th>Kichwa cha Matumizi</th>
                        <th>Kundi</th>
                        <th>Mlipwaji</th>
                        <th class="text-end">Kiasi (Tsh)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $e)
                        <tr>
                            <td>{{ $e->expense_date->format('d/m/Y') }}</td>
                            <td><code>{{ $e->expense_code }}</code></td>
                            <td>{{ $e->title }}</td>
                            <td>{{ $e->category }}</td>
                            <td>{{ $e->recipient_name ?? '-' }}</td>
                            <td class="text-end fw-semibold text-danger">{{ number_format($e->amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Hakuna matumizi yaliyorekodiwa katika kipindi hiki.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <th colspan="5" class="text-end">JUMLA KUU YA MATUMIZI:</th>
                        <th class="text-end text-danger">Tsh {{ number_format($totalExpense) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Saini na Viongozi -->
        <div class="row text-center mt-5">
            <div class="col-4">
                <div class="signature-line">
                    <strong>Mhazini wa Kanisa</strong><br>
                    Tarehe & Saini
                </div>
            </div>
            <div class="col-4">
                <div class="signature-line">
                    <strong>Katibu / Mzee wa Kanisa</strong><br>
                    Tarehe & Saini
                </div>
            </div>
            <div class="col-4">
                <div class="signature-line">
                    <strong>Mchungaji Kiongozi</strong><br>
                    Tarehe & Muhuri
                </div>
            </div>
        </div>

        <div class="text-center text-muted small mt-4 pt-3 border-top">
            Taarifa hii imetolewa kiotomatiki na Mfumo wa Kanisa (Multi-Church Management System) tarehe {{ now()->format('d/m/Y H:i') }}.
        </div>
    </div>
</body>
</html>
