@extends('layouts.app')

@section('title', 'Miradi ya Maendeleo ya Kanisa')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Miradi na Maendeleo ya Kanisa</h3>
            <p class="text-muted mb-0 small">Ujenzi wa hekalu, ununuzi wa viwanja, michango ya maendeleo na bajeti za miradi</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('projects.assets') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-box-seam me-1"></i> Daftari la Mali za Kanisa
            </a>
            <button class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#newProjectModal">
                <i class="bi bi-plus-circle me-1"></i> Sajili Mradi Mpya
            </button>
        </div>
    </div>

    <!-- 3 Metrics -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #0f172a 0%, #334155 100%);">
                <div class="stat-card-icon"><i class="bi bi-hammer"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Makadirio ya Bajeti ya Miradi</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalEstimated) }}</h2>
                <div class="small text-white-50">Jumla ya miradi yote ya maendeleo</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="stat-card-icon"><i class="bi bi-cash-coin"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Michango na Ahadi Zilizopatikana</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalRaised) }}</h2>
                <div class="small text-white-50">Kutoka kwa washirika na wadau</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div class="stat-card-icon"><i class="bi bi-wallet2"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Fedha Zilizotumika Hadi Sasa</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalSpent) }}</h2>
                <div class="small text-white-50">Vifaa vya ujenzi, mafundi na ujenzi</div>
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="row g-4">
        @forelse($projects as $p)
            <div class="col-md-6">
                <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-light text-dark border text-uppercase">{{ $p->project_type }}</span>
                            <span class="badge bg-{{ $p->status == 'completed' ? 'success' : ($p->status == 'in_progress' ? 'primary' : 'warning') }} rounded-pill px-3 py-1">
                                @if($p->status == 'completed') Umekamilika @elseif($p->status == 'in_progress') Unaendelea @elseif($p->status == 'planning') Mpango @else Umesitishwa @endif
                            </span>
                        </div>

                        <h5 class="fw-bold text-dark mb-1">{{ $p->title }}</h5>
                        <p class="text-muted small mb-3">{{ $p->description }}</p>

                        <!-- Progress Bar -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="fw-semibold">Utekelezaji wa Bajeti</span>
                                <strong class="text-primary">{{ $p->progressPercent() }}%</strong>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" style="width: {{ $p->progressPercent() }}%;"></div>
                            </div>
                        </div>

                        <div class="row g-2 text-center py-2 bg-light rounded-3 small mb-3">
                            <div class="col-4">
                                <span class="text-muted d-block" style="font-size: 0.75rem;">MAKADIRIO</span>
                                <strong>Tsh {{ number_format($p->estimated_cost) }}</strong>
                            </div>
                            <div class="col-4 border-start border-end">
                                <span class="text-muted d-block" style="font-size: 0.75rem;">ZILIZOPATIKANA</span>
                                <strong class="text-success">Tsh {{ number_format($p->raised_amount) }}</strong>
                            </div>
                            <div class="col-4">
                                <span class="text-muted d-block" style="font-size: 0.75rem;">ZILIZOTUMIKA</span>
                                <strong class="text-danger">Tsh {{ number_format($p->spent_amount) }}</strong>
                            </div>
                        </div>

                        <div class="small text-muted">
                            <div><i class="bi bi-geo-alt me-1"></i> Eneo: {{ $p->location ?? 'EAGT Golani' }}</div>
                            <div><i class="bi bi-person me-1"></i> Msimamizi: {{ $p->leader_name ?? 'Kamati ya Ujenzi' }}</div>
                            @if($p->target_completion_date)
                                <div><i class="bi bi-calendar-check me-1"></i> Lengo la Kukamilika: {{ $p->target_completion_date->format('M Y') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                Hakuna miradi ya ujenzi au maendeleo iliyosajiliwa bado.
            </div>
        @endforelse
    </div>
</div>

<!-- New Project Modal -->
<div class="modal fade" id="newProjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Sajili Mradi Mpya wa Kanisa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Jina la Mradi *</label>
                        <input type="text" name="title" class="form-control" placeholder="Mf. Ujenzi wa Ukumbi wa Vijana" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Aina ya Mradi *</label>
                            <select name="project_type" class="form-select" required>
                                <option value="building">Ujenzi wa Hekalu / Jengo</option>
                                <option value="land">Ununuzi wa Kiwanja / Eneo</option>
                                <option value="renovation">Ukarabati na Upanuzi</option>
                                <option value="equipment">Vyombo vya Muziki na Mitambo</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Hali ya Mradi *</label>
                            <select name="status" class="form-select" required>
                                <option value="planning">Hatua ya Mipango</option>
                                <option value="in_progress" selected>Unaendelea</option>
                                <option value="on_hold">Umesitishwa kwa Muda</option>
                                <option value="completed">Umekamilika</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Makadirio ya Gharama (Tsh) *</label>
                            <input type="number" step="1" name="estimated_cost" class="form-control" placeholder="10,000,000" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Zilizopatikana / Ahadi (Tsh)</label>
                            <input type="number" step="1" name="raised_amount" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Eneo la Mradi</label>
                            <input type="text" name="location" class="form-control" placeholder="Mf. Golani, Kimara-Suka">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Kiongozi / Mwenyekiti wa Kamati</label>
                            <input type="text" name="leader_name" class="form-control" placeholder="Mzee wa Kanisa">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Maelezo ya Mradi</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Ufafanuzi wa mradi huu..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                    <button type="submit" class="btn btn-primary">Sajili Mradi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
