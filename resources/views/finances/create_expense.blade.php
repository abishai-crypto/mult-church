@extends('layouts.app')

@section('title', 'Kurekodi Vocha ya Matumizi')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Kurekodi Vocha ya Matumizi ya Kanisa</h3>
            <p class="text-muted mb-0 small">Wasilisha maombi ya malipo ya uendeshaji kwa ajili ya kibali cha Mchungaji Kiongozi</p>
        </div>
        <a href="{{ route('finances.expenses') }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Matumizi
        </a>
    </div>

    <div class="card-custom p-4" style="max-width: 800px; margin: 0 auto;">
        <form action="{{ route('finances.expenses.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label small fw-semibold">Jina la Matumizi / Bidhaa *</label>
                    <input type="text" name="title" class="form-control" placeholder="mfano: Umeme wa LUKU, Maji ya DAWASA, Mafuta ya Jenereta" value="{{ old('title') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Kundi la Matumizi *</label>
                    <select name="category" class="form-select" required>
                        <option value="Utilities">Bili za Huduma (Umeme TANESCO, Maji DAWASA)</option>
                        <option value="Honorarium">Posho za Wahudumu / Wageni</option>
                        <option value="Welfare">Mfuko wa Huruma / Wajane & Yatima</option>
                        <option value="Missions">Uinjilisti & Semina</option>
                        <option value="Maintenance">Ukarabati wa Majengo & Vifaa</option>
                        <option value="Administration">Gharama za Ofisi & Utawala</option>
                        <option value="Equipment">Vyombo vya Muziki & TEHAMA</option>
                        <option value="Outreach">Mikutano ya Injili ya Nje</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Kiasi (Tsh - Shilingi ya Tanzania) *</label>
                    <div class="input-group">
                        <span class="input-group-text fw-bold">Tsh</span>
                        <input type="number" step="100" min="100" name="amount" class="form-control fs-5 fw-bold" placeholder="mfano: 150,000" value="{{ old('amount') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Jina la Mlipiwa / Mtoa Huduma</label>
                    <input type="text" name="recipient_name" class="form-control" placeholder="Mtu, Kampuni au Fundi" value="{{ old('recipient_name') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Tarehe ya Malipo *</label>
                    <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', date('Y-m-d')) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Njia ya Malipo *</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="cash" selected>Pesa Taslimu (Cash)</option>
                        <option value="mobile_money">Simu (M-Pesa, Tigo Pesa, Airtel Money)</option>
                        <option value="bank_transfer">Benki (CRDB / NMB)</option>
                        <option value="cheque">Hundi (Cheque)</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold">Maelezo ya Kina ya Matumizi</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Toa ufafanuzi wa matumizi haya na nani ameidhinisha ununuzi..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('finances.expenses') }}" class="btn btn-light border px-4">Ghairi</a>
                <button type="submit" class="btn btn-primary-custom px-4">
                    <i class="bi bi-save me-1"></i> Wasilisha Vocha
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
