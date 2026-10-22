@extends('layouts.app')

@section('title', 'Daftari la Waumini')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Daftari Kuu la Waumini na Washirika</h3>
            <p class="text-muted mb-0 small">Kumbukumbu za waumini wa EAGT Golani, mawasiliano, ubatizo, na idara wanazoshiriki</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('members.directory.print') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-printer me-1"></i> Chapisha Daftari / PDF
            </a>
            <a href="{{ route('members.export.csv') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> CSV (Excel)
            </a>
            <a href="{{ route('members.create') }}" class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Sajili Muumini Mpya
            </a>
        </div>
    </div>

    <!-- Sehemu ya Kuchuja (Filter) -->
    <div class="card-custom p-3 mb-4">
        <form method="GET" action="{{ route('members.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Tafuta jina, namba ya simu, au namba ya muumini..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Hali Yoyote ya Ushirika</option>
                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Yupo Hai (Active)</option>
                    <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Hajajiweka Hai (Inactive)</option>
                    <option value="Transferred" {{ request('status') == 'Transferred' ? 'selected' : '' }}>Amehamia Kanisa Jingine</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="baptism" class="form-select form-select-sm">
                    <option value="">Ubatizo wa Maji Mengi</option>
                    <option value="Baptized" {{ request('baptism') == 'Baptized' ? 'selected' : '' }}>Amebatizwa</option>
                    <option value="Not Baptized" {{ request('baptism') == 'Not Baptized' ? 'selected' : '' }}>Bado Kubatizwa</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="gender" class="form-select form-select-sm">
                    <option value="">Jinsia Zote</option>
                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Mwanaume</option>
                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Mwanamke</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-dark btn-sm rounded-3 w-100 fw-semibold">Tafuta</button>
                <a href="{{ route('members.index') }}" class="btn btn-light btn-sm rounded-3 border">Rudisha</a>
            </div>
        </form>
    </div>

    <!-- Jedwali la Waumini -->
    <div class="card-custom p-4">
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Muumini</th>
                        <th>Namba ya Usajili</th>
                        <th>Mawasiliano</th>
                        <th>Idara Wanazoshiriki</th>
                        <th>Ubatizo</th>
                        <th>Ushirika</th>
                        <th>Hatua</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $m)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        {{ substr($m->first_name, 0, 1) }}{{ substr($m->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('members.show', $m) }}" class="fw-bold text-dark text-decoration-none">
                                            {{ $m->full_name }}
                                        </a>
                                        <small class="text-muted d-block">{{ $m->occupation ?? 'Mshirika' }} • {{ $m->gender == 'Male' ? 'Mwanaume' : 'Mwanamke' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><code class="text-primary fw-bold">{{ $m->member_number }}</code></td>
                            <td>
                                <div class="small"><i class="bi bi-telephone text-muted me-1"></i> {{ $m->phone ?? 'Hakuna' }}</div>
                                <div class="small text-muted"><i class="bi bi-envelope text-muted me-1"></i> {{ $m->email ?? 'Hakuna' }}</div>
                            </td>
                            <td>
                                @forelse($m->departments as $dept)
                                    <span class="badge bg-light text-dark border me-1">{{ $dept->name }}</span>
                                @empty
                                    <span class="text-muted small">Hajapangiwa</span>
                                @endforelse
                            </td>
                            <td>
                                @if($m->baptism_status == 'Baptized')
                                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2 py-1">
                                        <i class="bi bi-droplet-fill me-1"></i> Amebatizwa
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-1">Bado</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                    {{ $m->membership_status == 'Active' ? 'Yupo Hai' : $m->membership_status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    @if($m->phone)
                                        <a href="{{ \App\Services\WhatsAppService::chatUrl($m->phone, 'Bwana Asifiwe ' . $m->first_name . '!') }}" target="_blank" class="btn btn-sm btn-outline-success border" title="Zungumza naye WhatsApp">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('members.show', $m) }}" class="btn btn-sm btn-light border" title="Tazama Wasifu">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('members.edit', $m) }}" class="btn btn-sm btn-light border" title="Hariri">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Hakuna muumini aliyepatikana kwa vigezo hivyo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection
