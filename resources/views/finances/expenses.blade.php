@extends('layouts.app')

@section('title', 'Matumizi ya Kanisa')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Matumizi na Malipo ya Uendeshaji wa Kanisa</h3>
            <p class="text-muted mb-0 small">Kumbukumbu za bili za umeme, maji, huduma za jamii, ukarabati na idhini ya Mchungaji</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('finances.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-cash-stack me-1"></i> Sadaka na Hazina
            </a>
            <a href="{{ route('finances.expenses.create') }}" class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Rekodi Vocha ya Matumizi
            </a>
        </div>
    </div>

    <!-- Kadi 2 za Matumizi -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #0f172a 0%, #334155 100%);">
                <div class="stat-card-icon"><i class="bi bi-receipt"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Jumla ya Matumizi Yaliyoidhinishwa</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalApproved) }}</h2>
                <div class="small text-white-50">Yamehakikiwa na uongozi wa kanisa</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div class="stat-card-icon"><i class="bi bi-hourglass-split"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Matumizi Yanayosubiri Idhini</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalPending) }}</h2>
                <div class="small text-white-50">Yanasubiri saini ya Mchungaji au Admin</div>
            </div>
        </div>
    </div>

    <!-- Jedwali la Matumizi -->
    <div class="card-custom p-4">
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Nambari ya Vocha</th>
                        <th>Kichwa cha Matumizi / Mlipiwa</th>
                        <th>Kundi</th>
                        <th>Kiasi</th>
                        <th>Tarehe</th>
                        <th>Aliyerekodi</th>
                        <th>Hadhi</th>
                        <th class="text-end">Hatua</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $exp)
                        <tr>
                            <td><code class="text-dark fw-bold">{{ $exp->expense_code }}</code></td>
                            <td>
                                <strong class="text-dark">{{ $exp->title }}</strong>
                                <small class="text-muted d-block">Mlipiwa: {{ $exp->recipient_name ?? 'Haikutajwa' }}</small>
                            </td>
                            <td>
                                @php
                                    $expCats = [
                                        'Utilities' => 'Bili za Huduma (Umeme/Maji)',
                                        'Honorarium' => 'Posho / Wahudumu Wageni',
                                        'Welfare' => 'Ustawi wa Jamii / Huruma',
                                        'Missions' => 'Uinjilisti & Misheni',
                                        'Maintenance' => 'Ukarabati & Utunzaji',
                                        'Administration' => 'Utawala & Ofisi',
                                        'Equipment' => 'Vyombo & Vifaa',
                                        'Outreach' => 'Mikutano ya Nje',
                                    ];
                                @endphp
                                <span class="badge bg-light text-dark border">{{ $expCats[$exp->category] ?? $exp->category }}</span>
                            </td>
                            <td class="fw-bold text-danger">-Tsh {{ number_format($exp->amount) }}</td>
                            <td>{{ $exp->expense_date->format('d M, Y') }}</td>
                            <td><small class="text-muted">{{ $exp->enteredBy?->name }}</small></td>
                            <td>
                                @if($exp->status == 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                        <i class="bi bi-check-circle me-1"></i> Imeidhinishwa
                                    </span>
                                @elseif($exp->status == 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1">
                                        <i class="bi bi-clock me-1"></i> Inasubiri Idhini
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-2 py-1">{{ $exp->status }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($exp->status == 'pending' && (Auth::user()->isPastor() || Auth::user()->isChurchAdmin() || Auth::user()->isSuperAdmin()))
                                    <form action="{{ route('finances.expenses.approve', $exp) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" onclick="return confirm('Je, unaidhinisha malipo haya ya kanisa?');">
                                            <i class="bi bi-check-lg me-1"></i> Idhinisha Malipo
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Hakuna kumbukumbu za matumizi yaliyorekodiwa bado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $expenses->links() }}
        </div>
    </div>
</div>
@endsection
