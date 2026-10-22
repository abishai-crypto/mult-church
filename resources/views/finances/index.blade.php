@extends('layouts.app')

@section('title', 'Usimamizi wa Hazina na Mapato ya Kanisa')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Hazina na Uthibitisho wa Pamoja wa Mapato (Dual-Control)</h3>
            <p class="text-muted mb-0 small">Usimamizi wa Zaka, Sadaka za Jumapili, Shukrani, Ujenzi na Uthibitisho wa Wazee wa Kanisa</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('finances.statement.print') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-printer me-1"></i> Chapisha / PDF
            </a>
            <a href="{{ route('finances.export.csv') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> CSV (Excel)
            </a>
            <a href="{{ route('finances.expenses') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-receipt me-1"></i> Matumizi
            </a>
            <a href="{{ route('finances.create') }}" class="btn btn-warning btn-sm fw-bold rounded-pill px-3 shadow-sm text-dark">
                <i class="bi bi-plus-circle me-1"></i> Rekodi Sadaka / Zaka
            </a>
        </div>
    </div>

    <!-- Ilani Maalum kwa Mhazini Kuhusu Zaka -->
    @if($isTreasurer)
        <div class="alert alert-info border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center gap-3">
            <div class="bg-primary text-white p-2 rounded-circle fs-4">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1 text-dark">Mwongozo wa Zaka kwa Mhazini:</h6>
                <small class="text-dark-emphasis d-block">
                    Mhazini haruhusiwi kuona kumbukumbu za Zaka kwenye leja kuu. Zaka zikithibitishwa na Wazee wa Kanisa hazihifadhiwi kwenye hazina ya kawaida bali zinaenda moja kwa moja kwa Mchungaji Kiongozi. Hapa unaona Sadaka za kawaida, Shukrani na Michango ya Ujenzi pekee.
                </small>
            </div>
        </div>
    @endif

    <!-- Kadi 4 za Hazina -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="stat-card-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">
                    {{ $isTreasurer ? 'Sadaka & Michango Iliyothibitishwa' : 'Hazina Iliyothibitishwa (Jumla)' }}
                </div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalConfirmed) }}</h2>
                <div class="small text-white-50"><i class="bi bi-shield-check"></i> Ipo kwenye leja rasmi</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div class="stat-card-icon"><i class="bi bi-hourglass-split"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Zinazosubiri Wazee</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalPending) }}</h2>
                <div class="small text-white-50">Miamala {{ $pendingTransactions->count() }} inangoja uthibitisho</div>
            </div>
        </div>

        @if(!$isTreasurer)
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                <div class="stat-card-icon"><i class="bi bi-wallet2"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Zaka Zilizothibitishwa</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalTithes) }}</h2>
                <div class="small text-white-50"><i class="bi bi-person-heart"></i> Zimekabidhiwa kwa Mchungaji</div>
            </div>
        </div>
        @else
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                <div class="stat-card-icon"><i class="bi bi-hammer"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Mfuko wa Ujenzi</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalBuilding) }}</h2>
                <div class="small text-white-50">Hekalu Jipya Golani</div>
            </div>
        </div>
        @endif

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #334155 0%, #475569 100%);">
                <div class="stat-card-icon"><i class="bi bi-receipt-cutoff"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Matumizi ya Kanisa</div>
                <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalExpenses) }}</h2>
                <div class="small text-white-50">Yaliyoidhinishwa na uongozi</div>
            </div>
        </div>
    </div>

    <!-- SEHEMU YA MIAMALA INAYOSUBIRI UTHIBITISHO (Dual-Control Holding Stage) -->
    <div class="card-custom p-4 mb-4 border-warning border-2">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div>
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-1">
                    <i class="bi bi-shield-lock-fill me-1"></i> Hatua ya Uthibitisho wa Pamoja (Dual-Control)
                </span>
                <h5 class="fw-bold mb-0 text-dark">Mapato Yanayosubiri Uthibitisho wa Wazee wa Kanisa / Mchungaji ({{ $pendingTransactions->count() }})</h5>
                <small class="text-muted">Miamala iliyoingizwa na watunza hazina/makatibu. Lazima Mzee wa Kanisa au Mchungaji athibitishe.</small>
            </div>
            @if(Auth::user()->isPastor() || Auth::user()->isElder())
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-person-check-fill me-1"></i> Una mamlaka ya Kuthibitisha
                </span>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Nambari</th>
                        <th>Aliyerekodi</th>
                        <th>Muumini / Mtoaji</th>
                        <th>Aina ya Sadaka</th>
                        <th>Kiasi</th>
                        <th>Njia ya Malipo</th>
                        <th>Tarehe</th>
                        <th class="text-end">Hatua ya Uthibitisho</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingTransactions as $pending)
                        <tr>
                            <td><code class="text-dark fw-bold">{{ $pending->transaction_code }}</code></td>
                            <td><small class="text-muted">{{ $pending->enteredBy?->name ?? 'Mtendaji' }}</small></td>
                            <td>
                                @if($pending->member)
                                    <a href="{{ route('members.show', $pending->member) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $pending->member->full_name }}
                                    </a>
                                @else
                                    <span class="text-dark">{{ $pending->donor_name ?? 'Muumini wa Kawaida' }}</span>
                                @endif
                            </td>
                            <td>
                                @if($pending->category === 'tithe')
                                    <span class="badge bg-primary text-white">Zaka (Fungu la Kumi)</span>
                                @else
                                    <span class="badge bg-light text-dark border">{{ ucwords(str_replace('_', ' ', $pending->category)) }}</span>
                                @endif
                            </td>
                            <td class="fs-6 fw-bold text-success">Tsh {{ number_format($pending->amount) }}</td>
                            <td><small>{{ ucwords($pending->payment_method) }}</small></td>
                            <td><small>{{ $pending->transaction_date->format('d M, Y') }}</small></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    @if(Auth::user()->isPastor() || Auth::user()->isElder() || Auth::user()->isSuperAdmin())
                                        <form action="{{ route('finances.confirm', $pending) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" onclick="return confirm('Je, unathibitisha muamala huu?');">
                                                <i class="bi bi-check2-circle me-1"></i> 
                                                @if($pending->category === 'tithe')
                                                    Thibitisha (Moja kwa moja kwa Mchungaji)
                                                @else
                                                    Thibitisha & Ingiza Leja
                                                @endif
                                            </button>
                                        </form>
                                    @endif

                                    @if(Auth::user()->isPastor() || Auth::user()->isElder() || Auth::user()->isChurchAdmin() || Auth::user()->isSuperAdmin())
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-2" data-bs-toggle="modal" data-bs-target="#reverseModal_{{ $pending->id }}">
                                            <i class="bi bi-x-circle"></i> Futa
                                        </button>

                                        <!-- Modal ya Kufuta Muamala -->
                                        <div class="modal fade" id="reverseModal_{{ $pending->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content text-start">
                                                    <form action="{{ route('finances.reverse', $pending) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fw-bold">Futa Muamala {{ $pending->transaction_code }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-semibold">Sababu ya Kufuta Muamala *</label>
                                                                <textarea name="reversal_reason" class="form-control" rows="3" placeholder="Eleza sababu ya kufuta muamala huu (mfano: namba isiyo sahihi au muamala uliorudiwa)..." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                                                            <button type="submit" class="btn btn-danger">Thibitisha Kufuta</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-check2-all text-success fs-3 d-block mb-1"></i>
                                Hakuna miamala inayosubiri uthibitisho. Miamala yote imeshathibitishwa na Wazee/Mchungaji!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SEHEMU YA LEJA KUU ILIYOTHIBITISHWA -->
    <div class="card-custom p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div>
                <h5 class="fw-bold mb-0">Leja Rasmi ya Mapato Yaliyothibitishwa</h5>
                <small class="text-muted">
                    @if($isTreasurer)
                        Inaonyesha Sadaka za kawaida, Shukrani na Michango ya Ujenzi (Zaka hazionekani kwa Mhazini).
                    @else
                        Kumbukumbu rasmi za Zaka (kwa Mchungaji) na Sadaka za kanisa zilizothibitishwa.
                    @endif
                </small>
            </div>
        </div>

        <!-- Fomu ya Kuchuja (Filter) -->
        <form method="GET" action="{{ route('finances.index') }}" class="row g-2 mb-3">
            <div class="col-md-3">
                <select name="category" class="form-select form-select-sm">
                    <option value="">Aina Zote za Mapato</option>
                    @if(!$isTreasurer)
                        <option value="tithe" {{ request('category') == 'tithe' ? 'selected' : '' }}>Zaka (Fungu la Kumi)</option>
                    @endif
                    <option value="regular_offering" {{ request('category') == 'regular_offering' ? 'selected' : '' }}>Sadaka ya Jumapili</option>
                    <option value="thanksgiving" {{ request('category') == 'thanksgiving' ? 'selected' : '' }}>Sadaka ya Shukrani</option>
                    <option value="building_offering" {{ request('category') == 'building_offering' ? 'selected' : '' }}>Mchango wa Ujenzi</option>
                    <option value="special_contribution" {{ request('category') == 'special_contribution' ? 'selected' : '' }}>Mchango Maalum</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="payment_method" class="form-select form-select-sm">
                    <option value="">Njia Zote za Malipo</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Pesa Taslimu (Cash)</option>
                    <option value="mobile_money" {{ request('payment_method') == 'mobile_money' ? 'selected' : '' }}>Simu (M-Pesa, Tigo, Airtel)</option>
                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Benki (CRDB, NMB)</option>
                    <option value="cheque" {{ request('payment_method') == 'cheque' ? 'selected' : '' }}>Hundi (Cheque)</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}" placeholder="Kuanzia">
            </div>
            <div class="col-md-2">
                <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}" placeholder="Mpaka">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-dark btn-sm w-100 fw-semibold rounded-3">Chuja</button>
                <a href="{{ route('finances.index') }}" class="btn btn-light btn-sm border rounded-3">Rudisha</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0">
                <thead>
                    <tr>
                        <th>Nambari</th>
                        <th>Muumini / Mchangiaji</th>
                        <th>Aina ya Mapato</th>
                        <th>Kiasi (Tsh)</th>
                        <th>Njia & Kumbukumbu</th>
                        <th>Tarehe</th>
                        <th>Aliyerekodi</th>
                        <th>Aliyethibitisha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($confirmedTransactions as $txn)
                        <tr>
                            <td><code class="text-dark fw-bold">{{ $txn->transaction_code }}</code></td>
                            <td>
                                @if($txn->member)
                                    <a href="{{ route('members.show', $txn->member) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $txn->member->full_name }}
                                    </a>
                                @else
                                    <span class="text-dark">{{ $txn->donor_name ?? 'Muumini wa Kawaida' }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $swahiliCategories = [
                                        'tithe' => 'Zaka (Fungu la Kumi)',
                                        'regular_offering' => 'Sadaka ya Jumapili',
                                        'thanksgiving' => 'Sadaka ya Shukrani',
                                        'building_offering' => 'Mchango wa Ujenzi',
                                        'special_contribution' => 'Mchango Maalum',
                                    ];
                                @endphp
                                <span class="badge bg-light text-dark border">
                                    {{ $swahiliCategories[$txn->category] ?? $txn->category }}
                                </span>
                            </td>
                            <td class="fw-bold text-success">Tsh {{ number_format($txn->amount) }}</td>
                            <td>
                                <div class="small fw-semibold">{{ ucwords($txn->payment_method) }}</div>
                                @if($txn->reference_number)
                                    <small class="text-muted">{{ $txn->reference_number }}</small>
                                @endif
                            </td>
                            <td>{{ $txn->transaction_date->format('d M, Y') }}</td>
                            <td><small class="text-muted">{{ $txn->enteredBy?->name }}</small></td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1">
                                    <i class="bi bi-shield-check me-1"></i> {{ $txn->approvedBy?->name ?? 'Mzee/Mchungaji' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Hakuna miamala iliyothibitishwa kulingana na vigezo ulivyochagua.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $confirmedTransactions->links() }}
        </div>
    </div>
</div>
@endsection
