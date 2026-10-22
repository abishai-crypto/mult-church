@extends('layouts.app')

@section('title', 'Sajili Kanisa Jipya')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Sajili Kanisa / Tawi Jipya (Provision Organization)</h3>
            <p class="text-muted mb-0 small">Unda mfumo huru wa kanisa jipya ukiwa na akaunti ya mchungaji msimamizi na rangi zake</p>
        </div>
        <a href="{{ route('superadmin.churches.index') }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Orodha
        </a>
    </div>

    <div class="card-custom p-4" style="max-width: 900px; margin: 0 auto;">
        <form action="{{ route('superadmin.churches.store') }}" method="POST">
            @csrf

            <!-- Church Details -->
            <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">1. Taarifa za Kanisa</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Jina Kamili la Kanisa *</label>
                    <input type="text" name="name" class="form-control" placeholder="Mf. EVANGELIST ASSEMBLIES OF GOD TANZANIA" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Kifupisho (Code)</label>
                    <input type="text" name="code" class="form-control" placeholder="EAGT-GOLANI" value="{{ old('code') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Slug / Anuani ya Wavuti</label>
                    <input type="text" name="slug" class="form-control" placeholder="eagt-golani" value="{{ old('slug') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Barua Pepe Rasmi *</label>
                    <input type="email" name="email" class="form-control" placeholder="info@eagtgolani.org" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Namba ya Simu</label>
                    <input type="text" name="phone" class="form-control" placeholder="+255 7XX XXX XXX" value="{{ old('phone') }}">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Eneo / Makao Makuu</label>
                    <input type="text" name="address" class="form-control" placeholder="Golani, Kimara-Suka, Dar es Salaam" value="{{ old('address') }}">
                </div>
            </div>

            <!-- Branding & Currency -->
            <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">2. Rangi za Utambulisho na Sarafu</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Rangi Kuu (Primary Color) *</label>
                    <input type="color" name="primary_color" class="form-control form-control-color w-100" value="{{ old('primary_color', '#1e40af') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Rangi ya Pili (Secondary Color) *</label>
                    <input type="color" name="secondary_color" class="form-control form-control-color w-100" value="{{ old('secondary_color', '#d97706') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Sarafu (Code) *</label>
                    <input type="text" name="currency" class="form-control" value="{{ old('currency', 'TZS') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Alama ya Sarafu *</label>
                    <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', 'Tsh') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Hali ya Leseni *</label>
                    <select name="subscription_status" class="form-select" required>
                        <option value="active" selected>Leseni Hai (Active License)</option>
                        <option value="trial">Majaribio ya Siku 30 (Trial)</option>
                    </select>
                </div>
            </div>

            <!-- Primary Admin Account -->
            <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">3. Akaunti ya Mchungaji Msimamizi</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Jina Kamili la Msimamizi *</label>
                    <input type="text" name="admin_name" class="form-control" placeholder="Jina la Mchungaji au Katibu" value="{{ old('admin_name') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Barua Pepe ya Kuingilia (Login) *</label>
                    <input type="email" name="admin_email" class="form-control" placeholder="mchungaji@kanisa.org" value="{{ old('admin_email') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Nenosiri la Awali *</label>
                    <input type="password" name="admin_password" class="form-control" placeholder="Herufi 6 au zaidi" value="password" required>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('superadmin.churches.index') }}" class="btn btn-light border px-4">Ghairi</a>
                <button type="submit" class="btn btn-warning fw-bold text-dark px-4 shadow">
                    <i class="bi bi-building-add me-1"></i> Sajili Kanisa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
