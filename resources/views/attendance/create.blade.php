@extends('layouts.app')

@section('title', 'Rekodi Mahudhurio ya Ibada')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Rekodi Mahudhurio ya Ibada</h3>
            <p class="text-muted mb-0 small">Weka idadi ya washirika waliohudhuria kwa makundi na takwimu za wageni</p>
        </div>
        <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Orodha
        </a>
    </div>

    <div class="card-custom p-4" style="max-width: 800px; margin: 0 auto;">
        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Ibada ya Kanisa / Programu *</label>
                    <select name="service_id" class="form-select" required>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}">{{ $s->title }} ({{ $s->service_type }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Tarehe ya Ibada *</label>
                    <input type="date" name="attendance_date" class="form-control" value="{{ old('attendance_date', date('Y-m-d')) }}" required>
                </div>

                <!-- Demographics Headcount -->
                <div class="col-12 mt-4">
                    <h6 class="fw-bold text-primary border-bottom pb-2">Mgawanyo wa Idadi ya Washirika</h6>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Wanaume (Idadi) *</label>
                    <input type="number" min="0" name="men_count" id="men" class="form-control fs-5 fw-bold" value="{{ old('men_count', 0) }}" oninput="calcTotal()" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Wanawake (Idadi) *</label>
                    <input type="number" min="0" name="women_count" id="women" class="form-control fs-5 fw-bold" value="{{ old('women_count', 0) }}" oninput="calcTotal()" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Watoto (Idadi) *</label>
                    <input type="number" min="0" name="children_count" id="children" class="form-control fs-5 fw-bold" value="{{ old('children_count', 0) }}" oninput="calcTotal()" required>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-light rounded-3 text-center">
                        <span class="text-muted small text-uppercase fw-bold">Jumla Kuu ya Waliohudhuria:</span>
                        <div class="fs-2 fw-bold text-primary" id="totalDisplay">0</div>
                    </div>
                </div>

                <!-- Visitors and Converts -->
                <div class="col-12 mt-4">
                    <h6 class="fw-bold text-primary border-bottom pb-2">Wageni na Waliofanya Uamuzi (Wokovu)</h6>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Idadi ya Wageni wa Mara ya Kwanza</label>
                    <input type="number" min="0" name="first_timers_count" class="form-control" value="{{ old('first_timers_count', 0) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Idadi ya Waliookoka (Altar Call)</label>
                    <input type="number" min="0" name="new_converts_count" class="form-control" value="{{ old('new_converts_count', 0) }}">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold">Maelezo ya Ziada / Muhtasari wa Mahubiri</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Ujumbe wa siku, hali ya ibada, wageni maalum..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('attendance.index') }}" class="btn btn-light border px-4">Ghairi</a>
                <button type="submit" class="btn btn-primary-custom px-4">
                    <i class="bi bi-save me-1"></i> Hifadhi Mahudhurio
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function calcTotal() {
        const m = parseInt(document.getElementById('men').value) || 0;
        const w = parseInt(document.getElementById('women').value) || 0;
        const c = parseInt(document.getElementById('children').value) || 0;
        document.getElementById('totalDisplay').innerText = (m + w + c).toLocaleString();
    }
    calcTotal();
</script>
@endsection
