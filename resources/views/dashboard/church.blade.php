@extends('layouts.app')

@section('title', 'Dashibodi ya Kanisa')

@section('content')
<div class="container-fluid px-0">
    <!-- Kichwa cha Dashibodi -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('assets/images/eagt_logo.jpg') }}" alt="EAGT Logo" class="rounded-circle shadow-sm flex-shrink-0" style="width: 52px; height: 52px; object-fit: contain; background: #fff; padding: 2px; border: 2px solid #d97706;">
            <div>
                <h3 class="fw-bold mb-0 text-dark">{{ $church->name }}</h3>
                <p class="text-muted mb-0 small">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> Golani, Kimara-Suka - Dar es Salaam | Mwaka wa Uamsho na Ukombozi
                </p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if(Auth::user()->isTreasurer() || Auth::user()->isSecretary() || Auth::user()->isChurchAdmin())
                <a href="{{ route('finances.create') }}" class="btn btn-warning btn-sm fw-bold rounded-pill px-3 shadow-sm text-dark">
                    <i class="bi bi-plus-circle me-1"></i> Rekodi Sadaka / Mchango
                </a>
            @endif
            @if(Auth::user()->isSecretary() || Auth::user()->isChurchAdmin() || Auth::user()->isPastor())
                <a href="{{ route('attendance.create') }}" class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-clipboard-plus me-1"></i> Rekodi Mahudhurio
                </a>
            @endif
        </div>
    </div>

    <!-- Taarifa Maalum kwa Mhazini Kuhusu Zaka -->
    @if($isTreasurer)
        <div class="alert alert-info border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center gap-3">
            <div class="bg-primary text-white p-2 rounded-circle fs-4">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-dark">Mwongozo wa Hazina Kuhusu Zaka (Fungu la Kumi):</h6>
                <small class="text-dark-emphasis">
                    Kwa mujibu wa taratibu za kanisa, Zaka za waumini zikithibitishwa na Wazee wa Kanisa hazihifadhiwi kwenye hazina kuu ya kawaida bali zinapelekwa moja kwa moja kwa Mchungaji Kiongozi. Kwa hiyo, Zaka hazionekani kwenye leja ya Mhazini.
                </small>
            </div>
        </div>
    @endif

    <!-- Arifa ya Uthibitisho wa Pamoja (Dual-Control) kwa Mchungaji na Wazee wa Kanisa -->
    @if($pendingCount > 0 && (Auth::user()->isPastor() || Auth::user()->isElder() || Auth::user()->isSuperAdmin()))
        <div class="alert alert-warning border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-warning text-dark p-2 rounded-circle fs-4">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Uthibitisho wa Wazee wa Kanisa / Mchungaji Unahitajika: Miamala {{ $pendingCount }} (Tsh {{ number_format($totalPendingOfferings) }})</h6>
                    <small class="text-dark-emphasis">Kuna mapato yaliyoingizwa na yanangoja uthibitisho wako kabla ya kuingizwa rasmi kwenye leja ya kanisa au kukabidhiwa kwa Mchungaji.</small>
                </div>
            </div>
            <a href="{{ route('finances.index') }}" class="btn btn-dark btn-sm rounded-pill px-3 fw-bold">
                Kagua & Thibitisha <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    @endif

    <!-- Kadi 4 za Takwimu Kuu (KPI Cards) -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                <div class="stat-card-icon"><i class="bi bi-people-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Jumla ya Waumini</div>
                <h2 class="fw-bold my-2 text-white">{{ number_format($totalMembers) }}</h2>
                <div class="small text-white-50"><span class="badge bg-white bg-opacity-25">{{ $activeMembers }} Wapo Hai</span> kwenye daftari</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="stat-card-icon"><i class="bi bi-clipboard-check-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Mahudhurio ya Jumapili</div>
                <h2 class="fw-bold my-2 text-white">{{ $latestAttendance ? number_format($latestAttendance->total_count) : '0' }}</h2>
                <div class="small text-white-50">
                    @if($latestAttendance)
                        {{ $latestAttendance->men_count }} Wanaume, {{ $latestAttendance->women_count }} Wanawake, {{ $latestAttendance->children_count }} Watoto
                    @else
                        Hakuna rekodi bado
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div class="stat-card-icon"><i class="bi bi-cash-stack"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">
                    @if($isTreasurer)
                        Sadaka na Michango
                    @else
                        Hazina Iliyothibitishwa
                    @endif
                </div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalConfirmedIncome) }}</h2>
                <div class="small text-white-50">
                    @if($isTreasurer)
                        <i class="bi bi-info-circle"></i> Bila Zaka (Inaenda kwa Mchungaji)
                    @else
                        <i class="bi bi-shield-check"></i> Imethibitishwa na Wazee/Mchungaji
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #334155 0%, #475569 100%);">
                <div class="stat-card-icon"><i class="bi bi-wallet2"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Matumizi Yaliyoidhinishwa</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalExpenses) }}</h2>
                <div class="small text-white-50">Salio la Hazina: <strong class="text-white">Tsh {{ number_format($netBalance) }}</strong></div>
            </div>
        </div>
    </div>

    <!-- Sehemu ya Chati za Mwenendo -->
    <div class="row g-4 mb-4">
        <!-- Chati ya Mahudhurio -->
        <div class="col-lg-8">
            <div class="card-custom p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold mb-0">Mwenendo wa Mahudhurio ya Ibada Kuu</h5>
                        <small class="text-muted">Mchanganuo wa Wanaume, Wanawake na Watoto kwa Ibada 6 zilizopita</small>
                    </div>
                    <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-light border rounded-pill">Tazama Yote</a>
                </div>
                <div style="height: 300px;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Chati ya Mgawanyo wa Mapato -->
        <div class="col-lg-4">
            <div class="card-custom p-4 h-100">
                <div class="mb-3">
                    <h5 class="fw-bold mb-0">Mgawanyo wa Mapato</h5>
                    <small class="text-muted">Mchanganuo wa vyanzo vya fedha vilivyothibitishwa</small>
                </div>
                <div style="height: 250px;" class="position-relative">
                    <canvas id="financeChart"></canvas>
                </div>
                <div class="mt-3 pt-3 border-top small text-muted text-center">
                    Jumla Iliyothibitishwa: <strong class="text-dark">Tsh {{ number_format($totalConfirmedIncome) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Miradi na Matukio ya Kanisa -->
    <div class="row g-4 mb-4">
        <!-- Miradi ya Maendeleo -->
        <div class="col-lg-6">
            <div class="card-custom p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-hammer text-warning me-2"></i>Miradi ya Kanisa EAGT Golani</h5>
                    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-light border rounded-pill">Miradi Yote</a>
                </div>

                @forelse($activeProjects as $project)
                    <div class="mb-3 p-3 bg-light rounded-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-dark">{{ $project->title }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $project->progressPercent() }}%</span>
                        </div>
                        <small class="text-muted d-block mb-2">{{ $project->description }}</small>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $project->progressPercent() }}%;"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mt-2">
                            <span>Zilizopatikana: <strong class="text-success">Tsh {{ number_format($project->raised_amount) }}</strong></span>
                            <span>Lengo: Tsh {{ number_format($project->estimated_cost) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small">Hakuna miradi inayoendelea kwa sasa.</p>
                @endforelse
            </div>
        </div>

        <!-- Matangazo na Matukio Yanayokuja -->
        <div class="col-lg-6">
            <div class="card-custom p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-megaphone text-primary me-2"></i>Matangazo & Matukio ya Kanisa</h5>
                    <a href="{{ route('announcements.index') }}" class="btn btn-sm btn-light border rounded-pill">Kalenda</a>
                </div>

                @foreach($pinnedAnnouncements as $announcement)
                    <div class="alert alert-primary border-0 rounded-3 p-3 mb-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-danger rounded-pill"><i class="bi bi-pin-fill"></i> Tangazo Muhimu</span>
                            <strong class="text-dark">{{ $announcement->title }}</strong>
                        </div>
                        <small class="text-muted d-block">{{ Str::limit($announcement->content, 120) }}</small>
                    </div>
                @endforeach

                @foreach($upcomingEvents as $evt)
                    <div class="d-flex align-items-center gap-3 p-2 border-bottom">
                        <div class="text-center bg-light border rounded-3 p-2" style="min-width: 58px;">
                            <div class="fw-bold text-primary">{{ $evt->start_time->format('M') }}</div>
                            <div class="fs-5 fw-bold text-dark">{{ $evt->start_time->format('d') }}</div>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">{{ $evt->title }}</div>
                            <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $evt->start_time->format('H:i') }} • {{ $evt->location ?? 'Hekalu la Golani' }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Miamala ya Hivi Karibuni -->
    <div class="card-custom p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-bold mb-0">Miamala ya Hivi Karibuni ya Sadaka na Michango</h5>
                <small class="text-muted">Kumbukumbu za mapato yaliyowasilishwa kanisani</small>
            </div>
            <a href="{{ route('finances.index') }}" class="btn btn-sm btn-primary-custom">Fungua Leja ya Fedha</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0">
                <thead>
                    <tr>
                        <th>Nambari ya Muamala</th>
                        <th>Muumini / Mchangiaji</th>
                        <th>Aina ya Sadaka</th>
                        <th>Kiasi</th>
                        <th>Njia ya Malipo</th>
                        <th>Tarehe</th>
                        <th>Hali ya Uthibitisho</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $txn)
                        <tr>
                            <td><code class="text-dark fw-bold">{{ $txn->transaction_code }}</code></td>
                            <td>{{ $txn->member?->full_name ?? ($txn->donor_name ?? 'Muumini wa Kawaida') }}</td>
                            <td>
                                @php
                                    $catNames = [
                                        'tithe' => 'Zaka (Fungu la Kumi)',
                                        'regular_offering' => 'Sadaka ya Jumapili',
                                        'thanksgiving' => 'Sadaka ya Shukrani',
                                        'building_offering' => 'Mchango wa Ujenzi',
                                        'special_contribution' => 'Mchango Maalum',
                                        'other_income' => 'Mapato Mengine',
                                    ];
                                @endphp
                                <span class="badge bg-light text-dark border">{{ $catNames[$txn->category] ?? $txn->category }}</span>
                            </td>
                            <td class="fw-bold text-success">Tsh {{ number_format($txn->amount) }}</td>
                            <td><i class="bi bi-wallet2 me-1"></i> {{ ucwords($txn->payment_method) }}</td>
                            <td>{{ $txn->transaction_date->format('d M, Y') }}</td>
                            <td>
                                @if($txn->isConfirmed())
                                    <span class="badge bg-success rounded-pill px-3 py-1"><i class="bi bi-check-circle me-1"></i> Imethibitishwa</span>
                                @elseif($txn->isPending())
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1"><i class="bi bi-clock me-1"></i> Inangoja Wazee</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-2 py-1">{{ $txn->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Hakuna miamala iliyorekodiwa bado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Grafu ya Mahudhurio
    const attCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($attendanceChartData['labels']) !!},
            datasets: [
                {
                    label: 'Jumla ya Wote',
                    data: {!! json_encode($attendanceChartData['total']) !!},
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30, 58, 138, 0.08)',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Wanaume',
                    data: {!! json_encode($attendanceChartData['men']) !!},
                    borderColor: '#0284c7',
                    borderWidth: 2,
                    tension: 0.3,
                    borderDash: [5, 5]
                },
                {
                    label: 'Wanawake',
                    data: {!! json_encode($attendanceChartData['women']) !!},
                    borderColor: '#ec4899',
                    borderWidth: 2,
                    tension: 0.3,
                    borderDash: [5, 5]
                },
                {
                    label: 'Watoto',
                    data: {!! json_encode($attendanceChartData['children']) !!},
                    borderColor: '#10b981',
                    borderWidth: 2,
                    tension: 0.3,
                    borderDash: [5, 5]
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
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Grafu ya Mgawanyo wa Fedha
    const finCtx = document.getElementById('financeChart').getContext('2d');
    new Chart(finCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($financeCategoriesData)) !!},
            datasets: [{
                data: {!! json_encode(array_values($financeCategoriesData)) !!},
                backgroundColor: ['#1e3a8a', '#10b981', '#f59e0b', '#8b5cf6', '#64748b'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12 } }
            }
        }
    });
</script>
@endsection
