@extends('layouts.app')

@section('title', 'Kurekodi Sadaka au Zaka')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            @if($isMember)
                <h3 class="fw-bold mb-1">Kuwasilisha Mchango wa Ujenzi au Mradi</h3>
                <p class="text-muted mb-0 small">Mchango wako utahifadhiwa na kuthibitishwa na Wazee wa Kanisa kwa ujenzi wa hekalu na maendeleo</p>
            @else
                <h3 class="fw-bold mb-1">Kurekodi Mapato ya Kanisa (Sadaka / Zaka)</h3>
                <p class="text-muted mb-0 small">Kila muamala unaoingizwa huingia kwenye hatua ya uthibitisho wa Wazee wa Kanisa / Mchungaji</p>
            @endif
        </div>
        <a href="{{ route('finances.index') }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Leja
        </a>
    </div>

    <div class="card-custom p-4" style="max-width: 820px; margin: 0 auto;">
        <form action="{{ route('finances.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">
                        {{ $isMember ? 'Aina ya Mchango wa Mradi *' : 'Aina ya Sadaka / Mchango *' }}
                    </label>
                    <select name="category" class="form-select" id="categorySelect" required>
                        @if($isMember)
                            <option value="building_offering" selected>Mchango wa Ujenzi wa Hekalu Golani</option>
                            <option value="special_contribution">Mchango Maalum wa Miradi / Maendeleo</option>
                            <option value="other_income">Makusanyo Mengineyo ya Miradi</option>
                        @else
                            <option value="regular_offering" selected>Sadaka Kuu ya Jumapili</option>
                            <option value="tithe">Zaka (Fungu la Kumi - 10%)</option>
                            <option value="thanksgiving">Sadaka ya Shukrani / Ushuhuda</option>
                            <option value="building_offering">Mchango wa Ujenzi wa Hekalu Golani</option>
                            <option value="special_contribution">Mchango Maalum wa Uinjilisti</option>
                            <option value="other_income">Mapato Mengineyo</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Kiasi (Tsh - Shilingi ya Tanzania) *</label>
                    <div class="input-group">
                        <span class="input-group-text fw-bold">Tsh</span>
                        <input type="number" step="100" min="100" name="amount" class="form-control fs-5 fw-bold" placeholder="mfano: 50,000" value="{{ old('amount') }}" required>
                    </div>
                </div>

                @if(!$isMember)
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Chagua Muumini / Mshirika (Kama anajulikana)</label>
                    <select name="member_id" class="form-select">
                        <option value="">-- Muumini wa Kawaida / Asiyetajwa --</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}" {{ request('member_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->full_name }} ({{ $m->member_number }})
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Inasaidia kuweka rekodi ya utoaji wa muumini.</small>
                </div>
                @endif

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Jina la Mchangiaji *</label>
                    <input type="text" name="donor_name" class="form-control" placeholder="mfano: Jina Lako Kamili" value="{{ old('donor_name', Auth::user()->name) }}" required>
                </div>

                @if(!$isMember)
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Ibada Husika</label>
                    <select name="service_id" class="form-select">
                        <option value="">-- Hakuna / Sadaka ya Ofisini --</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}">{{ $s->title }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Tarehe ya Utoaji *</label>
                    <input type="date" name="transaction_date" class="form-control" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Njia ya Malipo *</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="cash" selected>Pesa Taslimu (Cash)</option>
                        <option value="mobile_money">Simu (M-Pesa / Tigo Pesa / Airtel Money)</option>
                        <option value="bank_transfer">Benki (CRDB / NMB)</option>
                        <option value="cheque">Hundi ya Benki (Cheque)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Kumbukumbu ya Muamala / Namba ya Simu</label>
                    <input type="text" name="reference_number" class="form-control" placeholder="mfano: MPESA-891244 au Hundi No. 042">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold">Maelezo ya Ziada / Madhumuni</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="mfano: Awamu ya 1 ya Matofali ya Hekalu..."></textarea>
                </div>
            </div>

            @if($isMember)
                <div class="alert alert-info border-0 rounded-3 mt-4 mb-3 d-flex align-items-center gap-3 small">
                    <i class="bi bi-shield-check fs-4 text-primary"></i>
                    <div>
                        <strong>Uwazi wa Ujenzi & Taratibu za Kanisa:</strong> Mchango wako wa ujenzi utahifadhiwa ukiwa <code>Inasubiri Uthibitisho</code> na Wazee wa Kanisa watathibitisha. Zaka na Sadaka za ibada zinapokelewa na kusimamiwa na Wazee wa Kanisa na Mchungaji pekee.
                    </div>
                </div>
            @else
                <div class="alert alert-warning border-0 rounded-3 mt-4 mb-3 d-flex align-items-center gap-3 small">
                    <i class="bi bi-shield-lock-fill fs-4 text-warning"></i>
                    <div>
                        <strong>Taratibu za Kanisa (Dual-Control & Zaka):</strong> Muamala huu utahifadhiwa ukiwa na hadhi ya <code>Inasubiri Uthibitisho</code>. Mzee wa Kanisa au Mchungaji atathibitisha. <em>Zaka zikithibitishwa na Wazee wa Kanisa huwasilishwa moja kwa moja kwa Mchungaji Kiongozi.</em>
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('finances.index') }}" class="btn btn-light border px-4">Ghairi</a>
                <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">
                    <i class="bi bi-save me-1"></i> Wasilisha kwa Uthibitisho
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
