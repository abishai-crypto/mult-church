@extends('layouts.app')

@section('title', $member->full_name . ' - Wasifu wa Muumini')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('members.index') }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Daftari
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-light border rounded-pill">
                <i class="bi bi-pencil me-1"></i> Hariri Taarifa
            </a>
            @if(Auth::user()->isTreasurer() || Auth::user()->isSecretary())
                <a href="{{ route('finances.create') }}?member_id={{ $member->id }}" class="btn btn-sm btn-primary-custom rounded-pill">
                    <i class="bi bi-cash me-1"></i> Rekodi Utoaji wa Muumini
                </a>
            @endif
        </div>
    </div>

    <!-- Kadi Kuu ya Wasifu wa Muumini -->
    <div class="card-custom p-4 mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary text-white fs-3 fw-bold d-flex align-items-center justify-content-center shadow" style="width: 72px; height: 72px;">
                    {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                </div>
                <div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $member->full_name }}</h3>
                    <div class="d-flex flex-wrap align-items-center gap-2 small text-muted">
                        <span><code class="fw-bold text-primary">{{ $member->member_number }}</code></span>
                        <span>•</span>
                        <span><i class="bi bi-briefcase me-1"></i>{{ $member->occupation ?? 'Mshirika' }}</span>
                        <span>•</span>
                        <span><i class="bi bi-geo-alt me-1"></i>{{ $member->residential_address ?? 'Golani, Kimara-Suka' }}</span>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fs-6">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ $member->membership_status == 'Active' ? 'Mshirika Hai' : $member->membership_status }}
                </span>
                <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill fs-6">
                    {{ $member->baptism_status == 'Baptized' ? 'Amebatizwa' : 'Bado Kubatizwa' }}
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Upande wa Kushoto: Taarifa Binafsi -->
        <div class="col-lg-4">
            <div class="card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Taarifa Binafsi</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2 d-flex justify-content-between">
                        <span class="text-muted small">Jinsia:</span>
                        <strong class="text-dark small">{{ $member->gender == 'Male' ? 'Mwanaume' : 'Mwanamke' }}</strong>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span class="text-muted small">Tarehe ya Kuzaliwa:</span>
                        <strong class="text-dark small">{{ $member->date_of_birth ? $member->date_of_birth->format('d M, Y') : 'Haikutajwa' }}</strong>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span class="text-muted small">Hali ya Ndoa:</span>
                        <strong class="text-dark small">{{ $member->marital_status ?? 'Haikutajwa' }}</strong>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span class="text-muted small">Tarehe ya Kujiunga:</span>
                        <strong class="text-dark small">{{ $member->joined_date ? $member->joined_date->format('d M, Y') : 'Haikutajwa' }}</strong>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span class="text-muted small">Namba ya Simu:</span>
                        <strong class="text-dark small">{{ $member->phone ?? 'Hakuna' }}</strong>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="text-muted small">Barua Pepe:</span>
                        <strong class="text-dark small">{{ $member->email ?? 'Hakuna' }}</strong>
                    </li>
                </ul>

                <h5 class="fw-bold mt-4 mb-3 border-bottom pb-2">Mtu wa Karibu wa Dharura</h5>
                <p class="small mb-1"><strong>Jina:</strong> {{ $member->emergency_contact_name ?? 'Haikutajwa' }}</p>
                <p class="small mb-0"><strong>Simu:</strong> {{ $member->emergency_contact_phone ?? 'Haikutajwa' }}</p>
            </div>

            <!-- Idara Anazoshiriki -->
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Idara na Ushirika wa Kanisa</h5>
                @forelse($member->departments as $dept)
                    <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-light rounded-3">
                        <span class="fw-semibold text-dark small">{{ $dept->name }}</span>
                        <span class="badge bg-primary rounded-pill small">{{ $dept->pivot->role_in_department }}</span>
                    </div>
                @empty
                    <p class="text-muted small mb-0">Hajapangiwa idara yoyote kwa sasa.</p>
                @endforelse
            </div>
        </div>

        <!-- Upande wa Kulia: Historia ya Utoaji na Ziara za Kichungaji -->
        <div class="col-lg-8">
            <!-- Rekodi ya Michango na Sadaka -->
            <div class="card-custom p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold mb-0">Kumbukumbu ya Utoaji wa Muumini</h5>
                        <small class="text-muted">Sadaka, Zaka na Michango ya Ujenzi iliyothibitishwa</small>
                    </div>
                    <span class="badge bg-success-subtle text-success fs-6 border border-success-subtle px-3 py-2 rounded-pill">
                        Jumla ya Utoaji: Tsh {{ number_format($totalGiving) }}
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Namba ya Muamala</th>
                                <th>Aina ya Utoaji</th>
                                <th>Kiasi</th>
                                <th>Njia ya Malipo</th>
                                <th>Tarehe</th>
                                <th>Hadhi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($member->financialTransactions as $txn)
                                <tr>
                                    <td><code>{{ $txn->transaction_code }}</code></td>
                                    <td>
                                        @php
                                            $catNames = [
                                                'tithe' => 'Zaka (Fungu la Kumi)',
                                                'regular_offering' => 'Sadaka ya Jumapili',
                                                'thanksgiving' => 'Sadaka ya Shukrani',
                                                'building_offering' => 'Mchango wa Ujenzi',
                                                'special_contribution' => 'Mchango Maalum',
                                            ];
                                        @endphp
                                        <span class="badge bg-light text-dark border">{{ $catNames[$txn->category] ?? $txn->category }}</span>
                                    </td>
                                    <td class="fw-bold text-success">Tsh {{ number_format($txn->amount) }}</td>
                                    <td>{{ ucwords($txn->payment_method) }}</td>
                                    <td>{{ $txn->transaction_date->format('d M, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $txn->status == 'confirmed' ? 'success' : 'warning' }} rounded-pill">
                                            {{ $txn->status == 'confirmed' ? 'Imethibitishwa' : 'Inasubiri' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">Hakuna kumbukumbu za utoaji zilizorekodiwa kwa muumini huyu bado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kumbukumbu za Ziara za Kichungaji -->
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3">Huduma za Kichungaji na Ziara za Nyumbani</h5>
                @forelse($member->pastoralVisits as $visit)
                    <div class="p-3 mb-3 bg-light rounded-3 border-start border-4 border-primary">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-dark">{{ $visit->visit_type }}</strong>
                            <span class="small text-muted">{{ $visit->visit_date->format('d M, Y') }} • Mchungaji: {{ $visit->pastor->name }}</span>
                        </div>
                        <p class="small text-muted mb-0">{{ $visit->notes }}</p>
                    </div>
                @empty
                    <p class="text-muted small mb-0">Hakuna ziara ya kichungaji iliyorekodiwa kwa muumini huyu.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
