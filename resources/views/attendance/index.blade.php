@extends('layouts.app')

@section('title', 'Ibada na Mahudhurio')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Takwimu za Ibada na Mahudhurio</h3>
            <p class="text-muted mb-0 small">Kufuatilia idadi ya washirika kila ibada, wageni mara ya kwanza, na waliookoka (altar call)</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('attendance.summary.print') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-printer me-1"></i> Ripoti / PDF
            </a>
            <a href="{{ route('attendance.export.csv') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> CSV (Excel)
            </a>
            <a href="{{ route('attendance.services') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-calendar3 me-1"></i> Ratiba za Ibada
            </a>
            <a href="{{ route('attendance.create') }}" class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-clipboard-plus-fill me-1"></i> Rekodi Mahudhurio
            </a>
        </div>
    </div>

    <!-- 4 Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                <div class="stat-card-icon"><i class="bi bi-people-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Mahudhurio ya Mwisho</div>
                <h2 class="fw-bold my-2 text-white">{{ $latestAttendance ? number_format($latestAttendance->total_count) : '0' }}</h2>
                <div class="small text-white-50">{{ $latestAttendance ? $latestAttendance->attendance_date->format('d/m/Y') : 'Hakuna kumbukumbu' }}</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="stat-card-icon"><i class="bi bi-graph-up"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Wastani wa Mahudhurio</div>
                <h2 class="fw-bold my-2 text-white">{{ number_format($avgAttendance) }}</h2>
                <div class="small text-white-50">Kila ibada ya kanisa</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div class="stat-card-icon"><i class="bi bi-person-plus-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Wageni Wapya</div>
                <h2 class="fw-bold my-2 text-white">{{ number_format($totalFirstTimers) }}</h2>
                <div class="small text-white-50">Wageni waliofika kanisani</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);">
                <div class="stat-card-icon"><i class="bi bi-heart-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Waliookoka (Altar Call)</div>
                <h2 class="fw-bold my-2 text-white">{{ number_format($totalConverts) }}</h2>
                <div class="small text-white-50">Roho zilizovunwa kwa Kristo</div>
            </div>
        </div>
    </div>

    <!-- Attendance Chart -->
    <div class="card-custom p-4 mb-4">
        <h5 class="fw-bold mb-1">Mgawanyo wa Mahudhurio kwa Makundi</h5>
        <small class="text-muted d-block mb-3">Mwelekeo wa wanaume, wanawake, na watoto katika ibada zilizopita</small>
        <div style="height: 320px;">
            <canvas id="mainAttendanceChart"></canvas>
        </div>
    </div>

    <!-- Attendance Records Table -->
    <div class="card-custom p-4">
        <h5 class="fw-bold mb-3">Daftari la Mahudhurio ya Ibada</h5>
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0">
                <thead>
                    <tr>
                        <th>Tarehe</th>
                        <th>Ibada / Tukio</th>
                        <th>Jumla</th>
                        <th>Wanaume</th>
                        <th>Wanawake</th>
                        <th>Watoto</th>
                        <th>Wageni</th>
                        <th>Waliookoka</th>
                        <th>Mrekodiji</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $att)
                        <tr>
                            <td><strong>{{ $att->attendance_date->format('d/m/Y') }}</strong></td>
                            <td><span class="badge bg-light text-dark border">{{ $att->service?->title ?? 'Ibada ya Kawaida' }}</span></td>
                            <td class="fw-bold fs-6 text-primary">{{ number_format($att->total_count) }}</td>
                            <td>{{ $att->men_count }}</td>
                            <td>{{ $att->women_count }}</td>
                            <td>{{ $att->children_count }}</td>
                            <td>
                                @if($att->first_timers_count > 0)
                                    <span class="badge bg-warning-subtle text-warning border px-2 py-1">+{{ $att->first_timers_count }} wageni</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($att->new_converts_count > 0)
                                    <span class="badge bg-success-subtle text-success border px-2 py-1">+{{ $att->new_converts_count }} waliookoka</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ $att->recorder?->name ?? 'Mtumishi' }}</small></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Hakuna kumbukumbu za mahudhurio zilizorekodiwa bado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('mainAttendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [
                {
                    label: 'Wanaume',
                    data: {!! json_encode($chartData['men']) !!},
                    backgroundColor: '#1e40af',
                    borderRadius: 6
                },
                {
                    label: 'Wanawake',
                    data: {!! json_encode($chartData['women']) !!},
                    backgroundColor: '#ec4899',
                    borderRadius: 6
                },
                {
                    label: 'Watoto',
                    data: {!! json_encode($chartData['children']) !!},
                    backgroundColor: '#10b981',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                x: { stacked: true, grid: { display: false } },
                y: { stacked: true, beginAtZero: true, grid: { color: '#f1f5f9' } }
            }
        }
    });
</script>
@endsection
