@extends('layouts.app')

@section('title', 'Sanidi Kanisa - ' . $church->name)

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Sanidi Mfumo wa Kanisa</h3>
            <p class="text-muted mb-0 small">Badili taarifa, rangi za kanisa, sarafu na leseni ya {{ $church->name }}</p>
        </div>
        <a href="{{ route('superadmin.churches.index') }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Orodha
        </a>
    </div>

    <div class="card-custom p-4" style="max-width: 900px; margin: 0 auto;">
        <form action="{{ route('superadmin.churches.update', $church) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">1. Taarifa za Kanisa</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Jina Kamili la Kanisa *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $church->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Kaulimbiu / Motto</label>
                    <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $church->tagline) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Barua Pepe Rasmi *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $church->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Namba ya Simu</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $church->phone) }}">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Eneo / Makazi</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $church->address) }}">
                </div>
            </div>

            <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">2. Rangi za Utambulisho na Sarafu</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Rangi Kuu (Primary Color) *</label>
                    <input type="color" name="primary_color" class="form-control form-control-color w-100" value="{{ old('primary_color', $church->primary_color) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Rangi ya Pili (Secondary Accent) *</label>
                    <input type="color" name="secondary_color" class="form-control form-control-color w-100" value="{{ old('secondary_color', $church->secondary_color) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Sarafu (Code) *</label>
                    <input type="text" name="currency" class="form-control" value="{{ old('currency', $church->currency) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Alama ya Sarafu *</label>
                    <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', $church->currency_symbol) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Hali ya Leseni *</label>
                    <select name="subscription_status" class="form-select" required>
                        <option value="active" {{ $church->subscription_status == 'active' ? 'selected' : '' }}>Leseni Hai (Active)</option>
                        <option value="trial" {{ $church->subscription_status == 'trial' ? 'selected' : '' }}>Majaribio (Trial)</option>
                        <option value="past_due" {{ $church->subscription_status == 'past_due' ? 'selected' : '' }}>Imechelewa Malipo</option>
                        <option value="cancelled" {{ $church->subscription_status == 'cancelled' ? 'selected' : '' }}>Imefutwa</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="form-check pt-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="activeCheck" value="1" {{ $church->is_active ? 'checked' : '' }}>
                        <label class="form-check-label small fw-bold" for="activeCheck">
                            Akaunti ya Kanisa Imeruhusiwa Kutumika (Active)
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('superadmin.churches.index') }}" class="btn btn-light border px-4">Ghairi</a>
                <button type="submit" class="btn btn-primary-custom px-4">
                    <i class="bi bi-check-circle me-1"></i> Hifadhi Mipangilio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
