@extends('layouts.app')

@section('title', 'Kumbukumbu za Kiukaguzi (Audit Trail)')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Kumbukumbu za Kiukaguzi na Usalama wa Mfumo (Audit Trail)</h3>
            <p class="text-muted mb-0 small">Daftari lisilobadilika linalorekodi matendo yote ya kiutawala, uthibitishaji wa fedha, mabadiliko ya washirika na uingiaji mfumoni</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card-custom p-3 mb-4">
        <form method="GET" action="{{ route('audit.index') }}" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Tafuta kwa mtumiaji, maelezo, au anwani ya IP..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="action" class="form-select form-select-sm">
                    <option value="">Vitendo Vyote</option>
                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Kusajili (Created)</option>
                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Kuhariri (Updated)</option>
                    <option value="approved" {{ request('action') == 'approved' ? 'selected' : '' }}>Kuthibitisha (Approved / Confirmed)</option>
                    <option value="reversed" {{ request('action') == 'reversed' ? 'selected' : '' }}>Kukataa / Kurudisha (Reversed)</option>
                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Kufuta (Deleted)</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Kuingia (Login)</option>
                    <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Kutoka (Logout)</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-dark btn-sm rounded-3 w-100 fw-semibold">Chuja</button>
                <a href="{{ route('audit.index') }}" class="btn btn-light btn-sm rounded-3 border">Weka Upya</a>
            </div>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="card-custom p-4">
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Muda & Tarehe</th>
                        <th>Mtumiaji / Mtendaji</th>
                        <th>Kitendo</th>
                        <th>Kipengele</th>
                        <th>Maelezo ya Tukio</th>
                        <th>Anwani ya IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="small text-muted" style="white-space: nowrap;">{{ $log->created_at->format('d/m/Y - H:i:s') }}</td>
                            <td>
                                <strong class="text-dark">{{ $log->user_name }}</strong>
                            </td>
                            <td>
                                @php
                                    $actionColors = [
                                        'created' => 'primary',
                                        'updated' => 'info',
                                        'approved' => 'success',
                                        'reversed' => 'danger',
                                        'deleted' => 'danger',
                                        'login' => 'secondary',
                                        'logout' => 'secondary',
                                    ];
                                    $actionSwahili = [
                                        'created' => 'Kusajili',
                                        'updated' => 'Kurekebisha',
                                        'approved' => 'Kuthibitisha',
                                        'reversed' => 'Kurudisha',
                                        'deleted' => 'Kufuta',
                                        'login' => 'Kuingia',
                                        'logout' => 'Kutoka',
                                    ];
                                    $color = $actionColors[$log->action] ?? 'secondary';
                                    $actionLabel = $actionSwahili[$log->action] ?? $log->action;
                                @endphp
                                <span class="badge bg-{{ $color }}-subtle text-{{ $color }} border border-{{ $color }}-subtle px-2 py-1 text-uppercase" style="font-size: 0.72rem;">
                                    {{ $actionLabel }}
                                </span>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $log->entity_type }}</span></td>
                            <td class="small">{{ $log->description }}</td>
                            <td><code class="small">{{ $log->ip_address }}</code></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Hakuna kumbukumbu za ukaguzi zilizopatikana.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
