@extends('layouts.app')

@section('title', 'Usimamizi wa Makanisa (Tenants)')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Makanisa na Leseni za Mfumo (Super Admin)</h3>
            <p class="text-muted mb-0 small">Kusajili, kutoa leseni, kubinafsisha mwonekano na kusimamia matawi au makanisa binafsi</p>
        </div>
        <div>
            <a href="{{ route('superadmin.churches.create') }}" class="btn btn-warning btn-sm fw-bold rounded-pill px-3 shadow-sm text-dark">
                <i class="bi bi-plus-circle me-1"></i> Sajili Kanisa / Tawi Jipya
            </a>
        </div>
    </div>

    <!-- 4 Stats -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #0f172a 0%, #334155 100%);">
                <div class="stat-card-icon"><i class="bi bi-buildings"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Jumla ya Makanisa</div>
                <h2 class="fw-bold my-2 text-white">{{ $totalChurches }}</h2>
                <div class="small text-white-50">{{ $activeChurches }} Yenye Leseni Hai</div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                <div class="stat-card-icon"><i class="bi bi-people"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Jumla ya Washirika</div>
                <h2 class="fw-bold my-2 text-white">{{ number_format($totalMembers) }}</h2>
                <div class="small text-white-50">Kwenye matawi yote ya kanisa</div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="stat-card-icon"><i class="bi bi-person-badge"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Watumishi Kwenye Mfumo</div>
                <h2 class="fw-bold my-2 text-white">{{ $totalUsers }}</h2>
                <div class="small text-white-50">Wachungaji na viongozi</div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div class="stat-card-icon"><i class="bi bi-shield-check"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Ulinzi wa Data za Kanisa</div>
                <h2 class="fw-bold my-2 text-white">Salama</h2>
                <div class="small text-white-50">Kila kanisa data zake zipo pekee</div>
            </div>
        </div>
    </div>

    <!-- Church Table -->
    <div class="card-custom p-4">
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Kanisa / Shirika</th>
                        <th>Kifupisho (Code)</th>
                        <th>Mawasiliano</th>
                        <th>Watumishi</th>
                        <th>Washirika</th>
                        <th>Rangi za Kanisa</th>
                        <th>Hali</th>
                        <th class="text-end">Vitendo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($churches as $c)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 44px; height: 44px; background: {{ $c->primary_color }};">
                                        {{ substr($c->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $c->name }}</div>
                                        <small class="text-muted">{{ $c->tagline ?? 'Kanisa' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code>{{ $c->code }}</code><br>
                                <small class="text-muted">/{{ $c->slug }}</small>
                            </td>
                            <td>
                                <small class="d-block">{{ $c->email }}</small>
                                <small class="text-muted">{{ $c->phone }}</small>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $c->users_count }} watumishi</span></td>
                            <td><span class="badge bg-light text-dark border">{{ $c->members_count }} washirika</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <span class="d-inline-block rounded-circle border shadow-sm" style="width: 20px; height: 20px; background: {{ $c->primary_color }};" title="Rangi Kuu"></span>
                                    <span class="d-inline-block rounded-circle border shadow-sm" style="width: 20px; height: 20px; background: {{ $c->secondary_color }};" title="Rangi ya Pili"></span>
                                </div>
                            </td>
                            <td>
                                @if($c->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">Hai (Active)</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1">Imesitishwa</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('superadmin.switch', $c) }}" class="btn btn-sm btn-primary-custom" title="Ingia kusimamia kanisa hili">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Ingia Hapa
                                    </a>
                                    <a href="{{ route('superadmin.churches.edit', $c) }}" class="btn btn-sm btn-light border" title="Sanidi">
                                        <i class="bi bi-sliders"></i>
                                    </a>
                                    <form action="{{ route('superadmin.churches.toggle', $c) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $c->is_active ? 'warning' : 'success' }} border" title="{{ $c->is_active ? 'Sitisha' : 'Washa' }}">
                                            <i class="bi bi-power"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
