@extends('layouts.app')

@section('title', 'Muhtasari wa Msimamizi Mkuu')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-shield-shaded text-warning me-2"></i>Jopo Kuu la Usimamizi wa Mfumo (Super Admin)</h3>
            <p class="text-muted mb-0 small">Usimamizi wa jumla wa makanisa, leseni, na usalama wa data</p>
        </div>
        <div>
            <a href="{{ route('superadmin.churches.create') }}" class="btn btn-warning btn-sm fw-bold rounded-pill px-3 shadow-sm text-dark">
                <i class="bi bi-plus-circle me-1"></i> Sajili Kanisa Jipya
            </a>
        </div>
    </div>

    <!-- 4 Super Admin Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #0f172a 0%, #334155 100%);">
                <div class="stat-card-icon"><i class="bi bi-buildings-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Jumla ya Makanisa</div>
                <h2 class="fw-bold my-2 text-white">{{ $totalChurches }}</h2>
                <div class="small text-white-50"><span class="badge bg-success">{{ $activeChurches }} Yapo Hai</span> usajili</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                <div class="stat-card-icon"><i class="bi bi-people-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Jumla ya Washirika Wote</div>
                <h2 class="fw-bold my-2 text-white">{{ number_format($totalMembers) }}</h2>
                <div class="small text-white-50">Kwenye makanisa yote yaliyosajiliwa</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="stat-card-icon"><i class="bi bi-person-badge-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Watumishi & Viongozi</div>
                <h2 class="fw-bold my-2 text-white">{{ $totalUsers }}</h2>
                <div class="small text-white-50">Wachungaji, Wazee, Wahazini</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div class="stat-card-icon"><i class="bi bi-shield-check"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Ulinzi wa Data za Makanisa</div>
                <h2 class="fw-bold my-2 text-white">100% Salama</h2>
                <div class="small text-white-50">Kila kanisa lipo pekee (Isolated)</div>
            </div>
        </div>
    </div>

    <!-- Church Tenants Table -->
    <div class="card-custom p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-bold mb-0">Makanisa Yaliyo Kwenye Mfumo</h5>
                <small class="text-muted">Chagua kanisa lolote ili kuingia kusimamia taarifa zake moja kwa moja</small>
            </div>
            <a href="{{ route('superadmin.churches.index') }}" class="btn btn-sm btn-light border rounded-pill">Tazama Yote</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0">
                <thead>
                    <tr>
                        <th>Kanisa / Shirika</th>
                        <th>Kifupisho / Slug</th>
                        <th>Watumishi</th>
                        <th>Washirika</th>
                        <th>Leseni</th>
                        <th>Rangi za Kanisa</th>
                        <th>Kitendo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($churches as $church)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 40px; height: 40px; background: {{ $church->primary_color }};">
                                        {{ substr($church->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $church->name }}</div>
                                        <small class="text-muted">{{ $church->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code>{{ $church->code }}</code><br>
                                <small class="text-muted">{{ $church->slug }}</small>
                            </td>
                            <td><strong>{{ $church->users_count }}</strong> watumishi</td>
                            <td><strong>{{ $church->members_count }}</strong> washirika</td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                    {{ $church->subscription_status == 'active' ? 'Hai' : $church->subscription_status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <span class="d-inline-block rounded-circle" style="width: 18px; height: 18px; background: {{ $church->primary_color }};" title="Rangi Kuu"></span>
                                    <span class="d-inline-block rounded-circle" style="width: 18px; height: 18px; background: {{ $church->secondary_color }};" title="Rangi ya Pili"></span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('superadmin.switch', $church) }}" class="btn btn-sm btn-primary-custom">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Ingia Hapa
                                    </a>
                                    <a href="{{ route('superadmin.churches.edit', $church) }}" class="btn btn-sm btn-light border">
                                        <i class="bi bi-gear"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- System Audit Activity Stream -->
    <div class="card-custom p-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-journal-text text-primary me-2"></i>Matukio ya Hivi Karibuni Kwenye Mfumo (Audit Stream)</h5>
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0">
                <thead>
                    <tr>
                        <th>Muda</th>
                        <th>Mtumiaji</th>
                        <th>Kitendo</th>
                        <th>Kipengele</th>
                        <th>Maelezo</th>
                        <th>Anwani ya IP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentAuditLogs as $log)
                        <tr>
                            <td class="small text-muted">{{ $log->created_at->format('d/m, H:i') }}</td>
                            <td class="fw-semibold text-dark">{{ $log->user_name }}</td>
                            <td>
                                <span class="badge bg-light text-dark border text-uppercase" style="font-size: 0.72rem;">{{ $log->action }}</span>
                            </td>
                            <td><span class="badge bg-secondary-subtle text-secondary">{{ $log->entity_type }}</span></td>
                            <td class="small">{{ $log->description }}</td>
                            <td><code class="small">{{ $log->ip_address }}</code></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
