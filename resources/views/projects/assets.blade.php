@extends('layouts.app')

@section('title', 'Daftari la Mali za Kanisa')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Daftari la Mali na Vifaa vya Kanisa</h3>
            <p class="text-muted mb-0 small">Mitambo ya sauti, vyombo vya muziki, magari, samani na hati za viwanja/majengo</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-hammer me-1"></i> Miradi ya Kanisa
            </a>
            <button class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#newAssetModal">
                <i class="bi bi-plus-circle me-1"></i> Sajili Mali Mpya
            </button>
        </div>
    </div>

    <!-- 2 Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                <div class="stat-card-icon"><i class="bi bi-boxes"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Jumla ya Vifaa & Mali</div>
                <h2 class="fw-bold my-2 text-white">{{ $totalAssetCount }} Vitu</h2>
                <div class="small text-white-50">Vilivyoorodheshwa kwenye daftari kuu</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="stat-card-icon"><i class="bi bi-cash-stack"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Thamani ya Mali Yote</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalAssetValue) }}</h2>
                <div class="small text-white-50">Thamani inayotambulika kidaftari</div>
            </div>
        </div>
    </div>

    <!-- Assets Table -->
    <div class="card-custom p-4">
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Namba ya Mali</th>
                        <th>Jina / Maelezo ya Kifaa</th>
                        <th>Kundi</th>
                        <th>Hali Yake</th>
                        <th>Mahali Kilipo</th>
                        <th>Gharama ya Kununua</th>
                        <th>Thamani ya Sasa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $ast)
                        <tr>
                            <td><code class="text-primary fw-bold">{{ $ast->asset_code }}</code></td>
                            <td>
                                <strong class="text-dark">{{ $ast->name }}</strong>
                                @if($ast->serial_number)
                                    <small class="text-muted d-block">S/N: {{ $ast->serial_number }}</small>
                                @endif
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $ast->category }}</span></td>
                            <td>
                                <span class="badge bg-{{ $ast->condition == 'good' || $ast->condition == 'new' ? 'success' : 'warning' }}-subtle text-{{ $ast->condition == 'good' || $ast->condition == 'new' ? 'success' : 'warning' }} border px-2 py-1 rounded-pill">
                                    @if($ast->condition == 'new') Mpya Kabisa @elseif($ast->condition == 'good') Hali Nzuri @elseif($ast->condition == 'fair') Inatumika @else Inahitaji Matengenezo @endif
                                </span>
                            </td>
                            <td><small>{{ $ast->location ?? 'EAGT Golani' }}</small></td>
                            <td>Tsh {{ number_format($ast->purchase_price) }}</td>
                            <td class="fw-bold text-success">Tsh {{ number_format($ast->current_value ?? $ast->purchase_price) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Hakuna mali zilizosajiliwa kwenye daftari bado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $assets->links() }}
        </div>
    </div>
</div>

<!-- New Asset Modal -->
<div class="modal fade" id="newAssetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projects.assets.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Sajili Mali ya Kanisa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Jina la Mali / Kifaa *</label>
                        <input type="text" name="name" class="form-control" placeholder="Mf. Kinanda cha Yamaha / Spika za Hekaluni" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Kundi la Mali *</label>
                            <select name="category" class="form-select" required>
                                <option value="Audio/Visual">Mitambo ya Sauti & Picha</option>
                                <option value="Instrument">Vyombo vya Muziki</option>
                                <option value="Vehicle">Vyombo vya Usafiri / Gari</option>
                                <option value="Land">Kiwanja / Eneo la Kanisa</option>
                                <option value="Building">Jengo / Hekalu</option>
                                <option value="Furniture">Samani (Viti, Meza, Mimbari)</option>
                                <option value="IT Equipment">Kompyuta na Vifaa vya Tehama</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Hali ya Kifaa *</label>
                            <select name="condition" class="form-select" required>
                                <option value="new">Kipya Kabisa (Brand New)</option>
                                <option value="good" selected>Kizuri (Good)</option>
                                <option value="fair">Kinafanya Kazi (Fair)</option>
                                <option value="needs_repair">Kinahitaji Matengenezo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Gharama ya Kununua (Tsh)</label>
                            <input type="number" step="1" name="purchase_price" class="form-control" placeholder="1,500,000">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Thamani ya Sasa (Tsh)</label>
                            <input type="number" step="1" name="current_value" class="form-control" placeholder="1,200,000">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Mahali Kilipohifadhiwa</label>
                            <input type="text" name="location" class="form-control" placeholder="Chumba cha Sauti">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Namba ya Utambulisho (Serial No)</label>
                            <input type="text" name="serial_number" class="form-control" placeholder="S/N 987654321">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Maelezo ya Ziada / Udhamini (Warranty)</label>
                        <textarea name="warranty_info" class="form-control" rows="2" placeholder="Taarifa za bima, risiti au masharti ya udhamini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                    <button type="submit" class="btn btn-primary">Hifadhi Mali</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
